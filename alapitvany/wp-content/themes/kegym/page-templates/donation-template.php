<?php
/*
Template Name: Donation Page
*/

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array('..', 'barionlib', 'BarionClient.php'));
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'poskey.php';

// we should always have a post here
the_post();

$isEnLang = strpos(get_bloginfo('language'), "hu") === false;


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
if (isset($queryParams['paymentId']) && $queryParams['paymentId'] !== '') {
    // We only process the redirect URL and not the callback URL.
    // Redirect URL only called when payment is in a final state.

    // https://docs.barion.com/Payment-GetPaymentState-v2
    $response = $BC->GetPaymentState($queryParams['paymentId']);
    //print_r($response);
    if ($response->Status == PaymentStatus::Succeeded || $response->Status == PaymentStatus::PartiallySucceeded) {
        $showPaymentOk = true;
    } else {
        $hasPaymentError = true;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["donate"])) {
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

        if (isset($payment->PaymentRedirectUrl) && $payment->PaymentRedirectUrl !== '') {
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
<?php if ($showPaymentOk) { ?>
<div>
    <p><?php echo $isEnLang ? 'Successful payment. Thank you.' : 'Sikeres fizetés. Köszönjük.' ?></p>
</div>
<?php } ?>
<?php if ($hasPaymentError) { ?>
<div>
    <p style="color: red">
        <?php echo $isEnLang ? 'An error has happened during payment processing!' : 'Hiba történt a fizetés során!' ?>
    </p>
</div>
<?php } ?>
<div id="donation-form">
    <form method="post" action="<?php echo get_permalink(); ?>">
        <div id="amount">
            <?php foreach (array(1000, 3000, 5000, 10000) as $amount) { ?>
            <input class="amount-input" type="radio" name="amount" id="<?php echo $amount ?>_huf"
                value="<?php echo $amount ?>" required />
            <label class="amount-label" for="<?php echo $amount ?>_huf"><?php echo $amount ?> Ft</label>
            <?php } ?>
            <input class="amount-input" type="radio" name="amount" id="custom_huf" value="-1" required />
            <label class="amount-label"
                for="custom_huf"><?php echo $isEnLang ? 'Other amount' : 'Egyéb összeg' ?></label>
        </div>

        <div id="custom_input">
            <input id="custom_amount" type="number" min="1000" value="1000" />
        </div>

        <div id="name">
            <div>
                <label for="firstname"><?php echo $isEnLang ? 'Family name' : 'Vezetéknév' ?></label><br />
                <input id="firstname" type="text" name="firstname" placeholder="" required>
            </div>
            <div>
                <label for="lastname"><?php echo $isEnLang ? 'First name' : 'Keresztnév' ?></label><br />
                <input id="lastname" type="text" name="lastname" placeholder="" required>
            </div>
        </div>

        <label for="email">Email</label>
        <input id="email" type="email" name="email" placeholder="email@cim.hu" required>

        <input type="checkbox" id="aszf" required />
        <label for="aszf">
            <?php if ($isEnLang) { ?>
            I've read and understand the <a href="https://juharos.hu/alapitvany/?page_id=7346">donation requirements</a>
            and the <a href="https://juharos.hu/alapitvany/?page_id=6587">privacy policy</a>.</label>
        <?php } else { ?>
        Az <a href="https://juharos.hu/alapitvany/?page_id=7346">adományozási feltételeket</a> és a
        <a href="https://juharos.hu/alapitvany/?page_id=6587">adatvédelmi nyilatkozatot</a>
        megértettem és elfogadom.</label>
        <?php } ?>
        <input type="hidden" name="donate" value="yes" />
        </br>
        <input type="submit" />
    </form>
    <div id="barion-banner">
        <img src="<?php echo get_template_directory_uri() . '/_images/barion.png'  ?>" alt="barion_banner" />
    </div>
</div>
<div><?php the_content(); ?></div>


<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/page-templates/donation-template.js">
</script>

<style>
#donation-form input[type=text],
#donation-form input[type=number],
#donation-form input[type=email] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

#donation-form #name {
    margin-top: 20px;
}

#donation-form #custom_input {
    display: none;
    margin-top: 10px;
    justify-content: flex-end;
    margin-right: 20px;
}

#donation-form #custom_input input {
    width: 30%;
    font-size: 16px;
}

#donation-form #custom_input::after {
    position: absolute;
    padding: 20px;
    margin-right: 20px;
    content: 'Ft';
}

#donation-form #name div {
    width: 45%;
    display: inline-block;
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

input[type=radio] {
    display: none;
}

input[type=radio]:not(:disabled)~label {
    cursor: pointer;
}

#amount {
    display: flex;
    flex-direction: row;
    justify-content: center;
    margin-top: 15px;
}

.amount-label {
    height: 100%;
    display: block;
    background: white;
    border: 2px solid #20df80;
    border-radius: 20px;
    padding: 0.5rem 1rem;
    margin-bottom: 1rem;
    text-align: center;
    margin: 0 12px;
    font-size: 16px;
    box-shadow: 0px 3px 10px -2px rgba(161, 170, 166, 0.5);
    position: relative;
}

input[type=radio]:checked+label {
    background: #e31938;
    color: white;
    box-shadow: 0px 0px 20px rgba(0, 255, 128, 0.75);
}

input[type=radio]:checked+label::after {
    color: #3d3f43;
    border: 2px solid #e31938;
    content: "🐕";
    font-size: 20px;
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    height: 30px;
    width: 30px;
    line-height: 30px;
    text-align: center;
    border-radius: 50%;
    background: white;
    box-shadow: 0px 2px 5px -2px rgba(0, 0, 0, 0.25);
}
</style>

<?php get_footer(); ?>