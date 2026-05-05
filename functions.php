<?php

require get_theme_file_path('/inc/acf-block-loader.php');
require_once get_theme_file_path('/inc/acf-admin-ui.php');
include get_theme_file_path('/inc/post-types.php');
// include get_theme_file_path('/inc/seeders.php');
include get_theme_file_path('/inc/template-helpers.php');

/**
 * Theme support
 */
if (!function_exists('base_setup')) :
    function base_setup()
    {
        add_theme_support('editor-styles');
        add_theme_support('post-thumbnails');
        add_image_size('small-image', 600);
        add_image_size('wide-image', 1400);
        add_image_size('extra-wide-image', 2000);

        register_nav_menus(array(
            'primary' => __('Primary Menu', 'base'),
            'secondary' => __('Secondary', 'base'),
        ));
    }
endif;
add_action('after_setup_theme', 'base_setup');


//Enqueue scripts and styles.
function base_scripts()
{
    wp_enqueue_style('base-google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600|Raleway:300,400,500,600', false);

    wp_enqueue_style('our-main-styles', get_theme_file_uri('/build/style-index.css'));

    wp_enqueue_script('our-main-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);

    // Register Alpine.js for the Lab Grid "Bridge"
    wp_register_script('alpine-js', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', array(), null, true);

    // Conditionally load shared demo panel assets for Page Banner and Content Switcher portfolio demos.
    $current_template_slug = get_page_template_slug();
    $is_content_switcher_demo = is_page_template('page-content-switcher.php')
        || 'page-content-switcher.php' === $current_template_slug
        || is_page('content-switcher');
    $is_page_banner_demo = function_exists('fu_should_load_page_banner_demo_panel')
        ? fu_should_load_page_banner_demo_panel()
        : false;

    if ($is_content_switcher_demo || $is_page_banner_demo) {
        wp_enqueue_style(
            'fu-demo-panel',
            get_theme_file_uri('/css/blocks/demo-panel.css'),
            array(),
            filemtime(get_theme_file_path('/css/blocks/demo-panel.css'))
        );

        wp_enqueue_script(
            'fu-demo-panel',
            get_theme_file_uri('/src/blocks/demo-panel.js'),
            array(),
            filemtime(get_theme_file_path('/src/blocks/demo-panel.js')),
            true
        );

        if ($is_content_switcher_demo) {
            wp_enqueue_script(
                'fu-demo-panel-content-switcher',
                get_theme_file_uri('/src/blocks/demo-panel-content-switcher.js'),
                array(),
                filemtime(get_theme_file_path('/src/blocks/demo-panel-content-switcher.js')),
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'base_scripts');

function fu_normalize_title_spacing($title)
{
    if (is_admin() || '' === $title) {
        return $title;
    }

    return preg_replace('/(?:\x{00A0}|&nbsp;|&#160;|&#xA0;)+/iu', ' ', $title);
}
add_filter('the_title', 'fu_normalize_title_spacing');

function fu_register_switcher_panel_wysiwyg_toolbar($toolbars)
{
    $toolbars['fu_switcher_panel'] = array();
    $toolbars['fu_switcher_panel'][1] = array('bold', 'italic', 'link', 'unlink', 'bullist');

    return $toolbars;
}
add_filter('acf/fields/wysiwyg/toolbars', 'fu_register_switcher_panel_wysiwyg_toolbar');


// Add Page Slug Body Class
function add_slug_body_class($classes)
{
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}
add_filter('body_class', 'add_slug_body_class');


/**
 * Disable the emoji's
 */
function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
    if ('dns-prefetch' == $relation_type) {
        /** This filter is documented in wp-includes/formatting.php */
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

        $urls = array_diff($urls, array($emoji_svg_url));
    }

    return $urls;
}

/*  DISABLE GUTENBERG STYLE IN HEADER| WordPress 5.9 */
// function wps_deregister_styles() {
//     wp_dequeue_style( 'global-styles' );
// }
// add_action( 'wp_enqueue_scripts', 'wps_deregister_styles', 100 );
