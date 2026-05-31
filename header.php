<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?php echo esc_url(get_theme_file_uri('/assets/favicons/favicon.ico')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url(get_theme_file_uri('/assets/favicons/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url(get_theme_file_uri('/assets/favicons/favicon-16x16.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_theme_file_uri('/assets/favicons/apple-touch-icon.png')); ?>">
    <link rel="manifest" href="<?php echo esc_url(get_theme_file_uri('/assets/favicons/site.webmanifest')); ?>">

    <meta name="theme-color" content="#0d3b66">
    <meta name="msapplication-TileColor" content="#0d3b66">
    <meta name="msapplication-config" content="<?php echo esc_url(get_theme_file_uri('/assets/favicons/browserconfig.xml')); ?>">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HKFVCPJGEY"></script>

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
                        <a class="site-logo" href="/">
                            <span class="site-logo__icon">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-white.webp'); ?>" alt="Tim Fetter Logo">
                            </span>
                            <span class="site-logo__text">Tim Fetter</span>
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
            <!-- <div class="wrap"> -->