﻿<?php

/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

</div> <!-- end of content -->
<aside id="rightSide">
    <?php get_sidebar("right"); ?>
</aside>

</div><!-- main-content-area -->

<footer id="colophon" role="contentinfo">
    <div class="site-info">
        KUTYÁVAL EGY <strong>MOSOLYÉRT</strong> ALAPÍTVÁNY<br>
        6000 Kecskemét Petúr bán u. 2/a<br>
        Telefon: 0630/27868-01 , 0670/25170-22
    </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->


<!-- pop up hun -->
<?php if (is_front_page() && strpos(get_bloginfo('language'), "hu") !== false) { ?>
<div id="popup_onepercent_background"></div>
<div id="popup_content">

    <div>
        <a href="index.php?page_id=17"><img
                src="<?php echo get_template_directory_uri(); ?>/_images/html/onpercent_ad.jpg" alt="egyszazalek"></a>
    </div>

    <!-- div style="margin: 25px 0;">
	<a href="https://www.fressnapf.hu/segito-kez-allati-kuldetes/"><img src="<?php echo get_template_directory_uri(); ?>/_images/banner/fressnapf.jpg"  alt="freshnapf kutyavalegymosolyert" style="width: 650px; heigth:auto;">
	</a>
  </div -->

    <div style="margin: 25px 0">
        <a href="index.php?page_id=2025"><img
                src="<?php echo get_template_directory_uri(); ?>/_images/html/pedakkred.jpg" alt="pedaker">
        </a>
    </div>

    <div style="margin: 25px 0;">
        <a href="https://juharos.hu/alapitvany/?page_id=2485"><img
                src="https://juharos.hu/alapitvany/wp-content/uploads/2016/08/book_cover.jpg" alt="könyv borító"
                style="width: 650px; heigth:auto;">
        </a>
    </div>

</div>
<?php } ?>

<!-- pop-up en_US -->
<?php if (is_front_page() && strpos(get_bloginfo('language'), "en") !== false) { ?>
<div id="popup_onepercent_background"></div>
<div id="popup_content">
    <div style="margin: 25px 0">
        <a href="https://www.amazon.com/dp/B079KHKHXD/ref=tsm_1_fb_lk"><img
                src="<?php echo get_template_directory_uri(); ?>/_images/banner/dog_for_a_smile_book_banner_small.jpg"
                alt="dog for a smile book english">
        </a>
    </div>
</div>
<?php } ?>

<script language="javascript" type="text/javascript">
jQuery("#popup_onepercent_background").click(function() {
    jQuery(this).fadeOut();
    jQuery("#popup_content").fadeOut();
});
</script>

<script>
// Create BP element on the window
window["bp"] = window["bp"] || function() {
    (window["bp"].q = window["bp"].q || []).push(arguments);
};
window["bp"].l = 1 * new Date();

// Insert a script tag on the top of the head to load bp.js
scriptElement = document.createElement("script");
firstScript = document.getElementsByTagName("script")[0];
scriptElement.async = true;
scriptElement.src = 'https://pixel.barion.com/bp.js';
firstScript.parentNode.insertBefore(scriptElement, firstScript);
window['barion_pixel_id'] = 'BP-7lDwx8I3Ua-40';

// Send init event
bp('init', 'addBarionPixelId', window['barion_pixel_id']);
</script>

<noscript>
    <img height="1" width="1" style="display:none" alt="Barion Pixel"
        src="https://pixel.barion.com/a.gif?ba_pixel_id='BP-7lDwx8I3Ua-40'&ev=contentView&noscript=1">
</noscript>

<script type="text/javascript" src="https://cookieconsent.popupsmart.com/src/js/popper.js"></script>
<script>
window.start.init({
    Palette: "palette2",
    Mode: "banner bottom",
    Time: "5",
    Message: "Ez az oldal sütiket használ a legjobb élmény érdekében.",
    ButtonText: "Értettem",
    LinkText: "Elolvasom",
    Location: "https://juharos.hu/alapitvany/?page_id=7349",
})
</script>



<?php wp_footer(); ?>
</body>

</html>