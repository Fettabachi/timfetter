<?php

require get_theme_file_path('/inc/acf-block-loader.php');

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

    wp_enqueue_style('our-main-styles', get_theme_file_uri('/build/style-index.css'));

    wp_enqueue_script('our-main-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);

    if (fu_should_load_demo_panel()) {
        wp_enqueue_style(
            'fu-demo-panel',
            get_theme_file_uri('/css/demo-panel.css'),
            array(),
            filemtime(get_theme_file_path('/css/demo-panel.css'))
        );

        wp_enqueue_script(
            'fu-demo-panel',
            get_theme_file_uri('/src/demo-panel.js'),
            array(),
            filemtime(get_theme_file_path('/src/demo-panel.js')),
            true
        );
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

// Property Post Type
function fu_register_property_cpt()
{
    $labels = array(
        'name'               => 'Properties',
        'singular_name'      => 'Property',
        'menu_name'          => 'Properties',
        'name_admin_bar'     => 'Property', // Top bar "New" menu
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Property', // <--- This fixes the sidebar hover!
        'new_item'           => 'New Property',
        'edit_item'          => 'Edit Property',
        'view_item'          => 'View Property',
        'all_items'          => 'All Properties',
        'search_items'       => 'Search Properties',
        'not_found'          => 'No properties found.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'menu_icon'          => 'dashicons-admin-home', // The home icon
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'       => true, // Required for Gutenberg
        'rewrite'            => array('slug' => 'properties'),
    );

    register_post_type('fu_property', $args);
}
add_action('init', 'fu_register_property_cpt');

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

/**
 * The demo panel is a front-end showcase for the page-banner block.
 *
 * It is intentionally loaded only on pages where the banner is relevant so the
 * portfolio/demo UI stays isolated from the rest of the theme.
 */
function fu_should_load_demo_panel()
{
    if (is_admin()) return false;

    return has_block('acf/fu-page-banner') || is_singular();
}

function fu_inject_demo_panel()
{
    if (fu_should_load_demo_panel()) {
        // Markup only. Supporting CSS/JS are enqueued separately in base_scripts().
        get_template_part('parts/demo-panel');
    }
}
add_action('wp_footer', 'fu_inject_demo_panel', 999);

if (!function_exists('tim_fetter_portfolio_posted_on')) :
    function tim_fetter_portfolio_posted_on()
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            esc_html_x('Posted on %s', 'post date', 'tim-fetter-portfolio'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . wp_kses_post($posted_on) . '</span>';
    }
endif;

if (!function_exists('tim_fetter_portfolio_posted_by')) :
    function tim_fetter_portfolio_posted_by()
    {
        $byline = sprintf(
            esc_html_x('by %s', 'post author', 'tim-fetter-portfolio'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . wp_kses_post($byline) . '</span>';
    }
endif;

if (!function_exists('tim_fetter_portfolio_post_thumbnail')) :
    function tim_fetter_portfolio_post_thumbnail()
    {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) {
?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php
            return;
        }

        ?>
        <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
            <?php
            the_post_thumbnail(
                'post-thumbnail',
                array(
                    'alt' => the_title_attribute(
                        array(
                            'echo' => false,
                        )
                    ),
                )
            );
            ?>
        </a>
<?php
    }
endif;
