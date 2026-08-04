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
        add_theme_support('title-tag');
        add_post_type_support('page', 'excerpt');
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

function timfetter_document_title_separator($sep)
{
    return '|';
}
add_filter('document_title_separator', 'timfetter_document_title_separator');

function timfetter_document_title_parts($title)
{
    if (is_front_page()) {
        $title['title'] = 'Tim Fetter';
        $title['tagline'] = 'WordPress & Front-End Developer';
    }

    if (is_post_type_archive('portfolio-items')) {
        $title['title'] = 'Work';
    }

    return $title;
}
add_filter('document_title_parts', 'timfetter_document_title_parts');


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
    $is_comparison_cards_demo = is_page_template('page-comparison-cards.php')
        || 'page-comparison-cards.php' === $current_template_slug
        || is_page('comparison-cards');
    $is_portfolio_audit_demo = is_page_template('page-acf-block-system.php')
        || 'page-acf-block-system.php' === $current_template_slug
        || is_page('acf-block-system');
    $is_page_banner_demo = function_exists('fu_should_load_page_banner_demo_panel')
        ? fu_should_load_page_banner_demo_panel()
        : false;

    if ($is_content_switcher_demo || $is_page_banner_demo || $is_comparison_cards_demo) {
        wp_enqueue_style(
            'fu-demo-panel',
            get_theme_file_uri('/css/blocks/demo-panel.css'),
            array(),
            filemtime(get_theme_file_path('/css/blocks/demo-panel.css'))
        );

        if ($is_page_banner_demo) {
            wp_enqueue_script(
                'fu-demo-panel',
                get_theme_file_uri('/src/blocks/demo-panel.js'),
                array(),
                filemtime(get_theme_file_path('/src/blocks/demo-panel.js')),
                true
            );
        }

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

    if ($is_comparison_cards_demo) {
        wp_enqueue_script(
            'fu-demo-panel-comparison-cards',
            get_theme_file_uri('/src/blocks/demo-panel-comparison-cards.js'),
            array(),
            filemtime(get_theme_file_path('/src/blocks/demo-panel-comparison-cards.js')),
            true
        );
    }

    if ($is_portfolio_audit_demo) {
        wp_enqueue_script(
            'fu-portfolio-system-audit',
            get_theme_file_uri('/src/portfolio-system-audit.js'),
            array(),
            filemtime(get_theme_file_path('/src/portfolio-system-audit.js')),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'base_scripts');

// Conditionally enqueue Client Project Timeline prototype assets for the correct portfolio item only.
add_action('wp_enqueue_scripts', function () {
    if (is_singular('portfolio-items')) {
        $slug = get_post_field('post_name', get_queried_object_id());
        if ($slug === 'client-project-timeline') {
            wp_enqueue_style(
                'client-project-timeline',
                get_theme_file_uri('/assets/prototypes/client-project-timeline/client-project-timeline.css'),
                [],
                filemtime(get_theme_file_path('/assets/prototypes/client-project-timeline/client-project-timeline.css'))
            );
            wp_enqueue_script(
                'client-project-timeline',
                get_theme_file_uri('/assets/prototypes/client-project-timeline/client-project-timeline.js'),
                [],
                filemtime(get_theme_file_path('/assets/prototypes/client-project-timeline/client-project-timeline.js')),
                true
            );
        } elseif ($slug === 'project-scope-estimator') {
            wp_enqueue_style(
                'project-scope-estimator',
                get_theme_file_uri('/assets/prototypes/project-scope-estimator/project-scope-estimator.css'),
                [],
                filemtime(get_theme_file_path('/assets/prototypes/project-scope-estimator/project-scope-estimator.css'))
            );
            wp_enqueue_script(
                'project-scope-estimator',
                get_theme_file_uri('/assets/prototypes/project-scope-estimator/project-scope-estimator.js'),
                [],
                filemtime(get_theme_file_path('/assets/prototypes/project-scope-estimator/project-scope-estimator.js')),
                true
            );
        } elseif ($slug === 'content-approval-checklist') {
            wp_enqueue_style(
                'content-approval-checklist',
                get_theme_file_uri('/assets/prototypes/content-approval-checklist/content-approval-checklist.css'),
                [],
                filemtime(get_theme_file_path('/assets/prototypes/content-approval-checklist/content-approval-checklist.css'))
            );
            wp_enqueue_script(
                'content-approval-checklist',
                get_theme_file_uri('/assets/prototypes/content-approval-checklist/content-approval-checklist.js'),
                [],
                filemtime(get_theme_file_path('/assets/prototypes/content-approval-checklist/content-approval-checklist.js')),
                true
            );
        }
    }
});

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

/**
 * Remove users from the native WordPress XML sitemap.
 */
function timfetter_remove_users_from_sitemap($provider, $name)
{
    if ('users' === $name) {
        return false;
    }

    return $provider;
}
add_filter('wp_sitemaps_add_provider', 'timfetter_remove_users_from_sitemap', 10, 2);

/**
 * Keep only selected post types in the native WordPress XML sitemap.
 */
function timfetter_filter_sitemap_post_types($post_types)
{
    $allowed_post_types = [
        'page',
        'post',
        'resource',
        'portfolio-items',
    ];

    foreach ($post_types as $post_type_name => $post_type_object) {
        if (! in_array($post_type_name, $allowed_post_types, true)) {
            unset($post_types[$post_type_name]);
        }
    }

    return $post_types;
}
add_filter('wp_sitemaps_post_types', 'timfetter_filter_sitemap_post_types');

/*  DISABLE GUTENBERG STYLE IN HEADER| WordPress 5.9 */
// function wps_deregister_styles() {
//     wp_dequeue_style( 'global-styles' );
// }
// add_action( 'wp_enqueue_scripts', 'wps_deregister_styles', 100 );

/**
 * Output a meta description for public-facing pages.
 */
function tf_output_meta_description()
{
    if (is_admin() || is_404() || is_search()) {
        return;
    }

    $description = '';

    if (is_singular()) {
        $post_id = get_queried_object_id();

        // 1. Use a manually entered ACF description when available.
        if (function_exists('get_field')) {
            $description = get_field('meta_description', $post_id);
        }

        // 2. Fall back to a manually entered WordPress excerpt.
        if (!$description && has_excerpt($post_id)) {
            $description = get_the_excerpt($post_id);
        }

        // 3. Fall back to the page's normal WordPress content.
        if (!$description) {
            $description = get_post_field('post_content', $post_id);
        }
    } elseif (is_post_type_archive()) {
        $description = get_the_archive_description();

        if (!$description) {
            $archive_descriptions = array(
                'portfolio-items' => 'Explore reusable WordPress sections, front-end UI examples, and selected client work focused on responsive, maintainable implementation.',
                'resource' => 'Practical WordPress and front-end resources for planning content, improving accessibility, reviewing quality, and preparing websites for launch.',
            );
            $post_type = get_query_var('post_type');

            if (is_string($post_type) && isset($archive_descriptions[$post_type])) {
                $description = $archive_descriptions[$post_type];
            }
        }
    }

    if (!is_string($description)) {
        return;
    }

    $description = strip_shortcodes($description);
    $description = wp_strip_all_tags($description, true);
    $description = preg_replace('/\s+/', ' ', $description);
    $description = trim($description);

    if (!$description || 'my career website' === strtolower(rtrim($description, '.'))) {
        return;
    }

    $description = wp_html_excerpt($description, 160, '…');

    printf(
        '<meta name="description" content="%s">' . "\n",
        esc_attr($description)
    );
}

add_action('wp_head', 'tf_output_meta_description', 5);
