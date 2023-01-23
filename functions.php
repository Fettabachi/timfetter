<?php

/**
 * Theme support
 */
if (!function_exists('base_setup')) :
    function base_setup()
    {
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

    wp_enqueue_style('bootstrap4-css', '//cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css');

    wp_enqueue_style('our-main-styles', get_theme_file_uri('/build/style-index.css'));

    wp_enqueue_script('our-main-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);

    wp_enqueue_script('bootstrap4-js', '//cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js', array('jquery'), NULL, true);
}
add_action('wp_enqueue_scripts', 'base_scripts');


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


// Portfolio Items Post Type
add_action('init', 'tf_portfolio_items_register_post_type');

function tf_portfolio_items_register_post_type()
{
    register_post_type('portfolio-items', array(
        'labels' => array(
            'name' => 'Portfolio Items',
            'singular_name' => 'Portfolio Item',
            'add_new' => 'Add new portfolio item',
            'edit_item' => 'Edit portfolio item',
            'new_item' => 'New portfolio item',
            'view_item' => 'View portfolio item',
            'search_items' => 'Search portfolio items',
            'not_found' => 'No portfolio items found',
            'not_found_in_trash' => 'No portfolio items found in Trash'
        ),
        'public' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        )
    ));
}

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
