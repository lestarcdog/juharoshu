<?php
/*
Template Name: Donation Page
*/

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array('..' , 'barionlib' , 'BarionClient.php'));
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR .'poskey.php';

// we should always have a post here
the_post();


// Test environment
// Sandbox card details https://docs.barion.com/Sandbox
$environment = BarionEnvironment::Test;
// $environment = BarionEnvironment::Prod;

// Returned URL http://127.0.0.1/edsa-kema/?page_id=7423&paymentId=a3247cd7ff9dec118bde001dd8b71cc4
        
$useCert = $environment == BarionEnvironment::Test;
$posKey = $environment == BarionEnvironment::Test ? $testPosKey : $prodPosKey;
$payee = $environment == BarionEnvironment::Test ? $testPayee : $prodPayee;
$pixelId = $environment == BarionEnvironment::Test ? $testPixelId : $prodPixelId;
$BC = new BarionClient($posKey, 2, $environment, $useCert);

$hasPaymentError = false;
$showPaymentOk = false;

$queryParams = array();
parse_str($_SERVER['QUERY_STRING'], $queryParams);
if(isset($queryParams['paymentId']) && $queryParams['paymentId'] !== '') {
    // We only process the redirect URL and not the callback URL.
    // Redirect URL only called when payment is in a final state.

    // https://docs.barion.com/Payment-GetPaymentState-v2
    $response = $BC->GetPaymentState($queryParams['paymentId']);
    //print_r($response);
    if($response->Status == PaymentStatus::Succeeded || $response->Status == PaymentStatus::PartiallySucceeded) {
        $showPaymentOk = true;
    } else {
        $hasPaymentError = true;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["donate"])) {
        $amount = intval($_POST["amount"]);
        $callbackUrl = get_permalink();
        $email = htmlspecialchars($_POST["email"]);
        $firstname = htmlspecialchars($_POST["firstname"]);
        $lastname = htmlspecialchars($_POST["lastname"]);
        $transactionId = $email . "-" . time();

        // https://docs.barion.com/Payment-Start-v2
        $item = new ItemModel();
        $item->Name = "Adomány";
        $item->Description = "KEMA adomány";
        $item->Quantity = 1;
        $item->Unit = "db";
        $item->UnitPrice = $amount;
        $item->ItemTotal = $amount;

        $trans = new PaymentTransactionModel();
        $trans->POSTransactionId = $transactionId;
        $trans->Payee = $payee;
        $trans->Total = $amount;
        $trans->Currency = Currency::HUF;
        $trans->AddItem($item);

        $ppr = new PreparePaymentRequestModel();
        $ppr->GuestCheckout = true;
        $ppr->PaymentType = PaymentType::Immediate;
        $ppr->FundingSources = array(FundingSourceType::All);
        $ppr->PaymentRequestId = $transactionId;
        $ppr->PayerHint = $email;
        $ppr->CardHolderNameHint = $firstname . ' ' . $lastname;
        $ppr->Locale = UILocale::HU;
        $ppr->Currency = Currency::HUF;
        $ppr->RedirectUrl = $callbackUrl;

        $hasPaymentError = true;
        // no callback is needed 
        // $ppr->CallbackUrl = $callbackUrl;
        $ppr->AddTransaction($trans);

        $payment = $BC->PreparePayment($ppr);
        //print_r($payment);

        if(isset($payment->PaymentRedirectUrl) && $payment->PaymentRedirectUrl !== '') {
            nocache_headers();
            wp_redirect($payment->PaymentRedirectUrl, 302, 'KEMA');
            exit;
        } else {
            $hasPaymentError = true;
        }
    }
}

get_header();

?>
<h2><?php the_title(); ?></h2>
<div id="donation-form">
    <form method="post" action="<?php echo get_permalink(); ?>">
        <div>
            <?php foreach(array(2000, 3000, 5000) as $amount) {?>
            <button type="button">
                <input class="d-none" type="radio" name="amount" value="<?php echo $amount ?>" required />
                <?php echo $amount ?> Ft
            </button>
            <?php } ?>
        </div>


        <label for="firstname">Vezetéknév</label>
        <input id="firstname" type="text" name="firstname" placeholder="Kiss" value="Kiss">

        <label for="lastname">Keresztnév</label>
        <input id="lastname" type="text" name="lastname" placeholder="János" value="Janos">

        <label for="email">Email</label>
        <input id="email" type="email" name="email" placeholder="kutya@kema.hu" value="valami@test.ru">

        <input type="checkbox" id="aszf" required />
        <label for="aszf">A <a href="https://www.barion.com/hu/files/barion-pixel-aszf.pdf">Barion ÁSZF</a>-t megértettem és elfogadom.</label>

        <input type="hidden" name="donate" value="yes" />
        </br>
        <input type="submit" />
    </form>
    <div id="barion-banner">
        <img src="<?php echo get_template_directory_uri() . '/_images/barion.png'  ?>" alt="barion_banner" />
    </div>
    <?php if($showPaymentOk) { ?>
    <div>
        <p>Sikeres fizetés. Köszönjük.</p>
    </div>
    <?php } ?>
    <?php if($hasPaymentError) { ?>
    <div>
        <p>Hiba történt a fizetés során</p>
    </div>
    <?php } ?>
</div>
<div><?php the_content(); ?></div>

<script>
    // Create BP element on the window
    window["bp"] = window["bp"] || function () {
    (window["bp"].q = window["bp"].q || []).push(arguments);
    };
    window["bp"].l = 1 * new Date();
    
    // Insert a script tag on the top of the head to load bp.js
    scriptElement = document.createElement("script");
    firstScript = document.getElementsByTagName("script")[0];
    scriptElement.async = true;
    scriptElement.src = 'https://pixel.barion.com/bp.js';
    firstScript.parentNode.insertBefore(scriptElement, firstScript);
    window['barion_pixel_id'] = <?php echo $pixelId ?>;            

    // Send init event
    bp('init', 'addBarionPixelId', window['barion_pixel_id']);
</script>

<noscript>
    <img height="1" width="1" style="display:none" alt="Barion Pixel" src="https://pixel.barion.com/a.gif?ba_pixel_id='<?php echo $pixelId ?>'&ev=contentView&noscript=1">
</noscript>

<style>
#donation-form input[type=text],
#donation-form input[type=email] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

#donation-form input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

#donation-form input[type=submit]:hover {
    background-color: #45a049;
}

#barion-banner {
    display: flex;
    justify-content: center;
}
</style>

<?php get_footer(); ?>