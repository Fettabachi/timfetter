<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/favicons/manifest.json">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <title>Tim Fetter | Web Developer</title>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HKFVCPJGEY"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-HKFVCPJGEY');
    </script>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <!-- get our svg defs -->
    <?php include_once("ui/svg/symbol-defs.svg"); ?>
    <div id="page" class="hfeed site">
        <header id="masthead" class="site-header" role="banner">
            <div class="container">
                <div class="header-wrap">
                    <div class="site-branding">
                        <a class="site-logo" href="mailto:timfettermail@gmail.com">
                            timfettermail@gmail.com
                        </a>
                    </div>
                    <nav id="site-navigation" class="main-navigation" role="navigation">
                        <div id="responsive-toggle" class="menu-toggle">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </div>
                        <a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'base'); ?></a>
                        <div class="main-menu-wrap">
                            <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
                        </div>
                    </nav><!-- #site-navigation -->
                </div>
            </div>
        </header><!-- #masthead -->

        <div id="content" class="site-content">
            <div class="wrap">