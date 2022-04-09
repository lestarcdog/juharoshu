<?php

/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <title><?php wp_title('|', true, 'right'); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. 
	?>
    <!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

    <!-- Google  analytics -->
    <script>
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-58433522-1', 'auto');
    ga('send', 'pageview');
    </script>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <a name="top"></a>
    <!-- fb social plugin -->
    <div id="fb-root"></div>
    <script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>

    <div id="page" class="hfeed site">
        <header id="header">
            <div id="wrapper">
                <div id="alapitvanynev_wrapper">
                    <a href="<?php echo home_url(); ?>"><img
                            src="<?php echo get_template_directory_uri(); ?>/_images/alapitvany_logo.png"
                            alt="kutyavalegymosolyert" width="100" height="98"></a>
                    <a href="<?php echo home_url(); ?>">
                        <div id="alapitvanyNev">
                            <?php if (strpos(get_bloginfo('language'), "hu") !== false) { ?>
                            KUTYÁVAL EGY <b>MOSOLYÉRT</b> ALAPÍTVÁNY
                            <?php } else {  ?>
                            WITH DOGS FOR A <b>SMILE</b> FOUNDATION
                            <?php } ?>
                        </div>
                    </a>
                </div>
                <div>
                    <nav id="topNav">
                        <?php wp_nav_menu(array('theme_location' => "topmenu")); ?>
                    </nav>

                    <div id="lang-sidebar">
                        <?php dynamic_sidebar('sidebar-lang'); ?>
                    </div>

                    <div id="search-bar"><?php get_search_form(); ?> </div>
                    <div id="donate">
                        <?php if (strpos(get_bloginfo('language'), "hu") !== false) { ?>
                        <a href="https://juharos.hu/alapitvany/?page_id=7414">TÁMOGATÁS 💚</a>
                        <?php } else {  ?>
                        <a href="https://juharos.hu/alapitvany/?page_id=7341">DONATE 💚</a>
                        <?php } ?></a>
                    </div>
                </div>

            </div> <!-- wrapper end -->
        </header>

        <div id="main-content-area">

            <aside id="leftSide">
                <?php get_sidebar("left"); ?>
            </aside>

            <div id="content">