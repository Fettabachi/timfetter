<?php

/**
 * The page-banner demo panel is a front-end showcase for the page-banner block.
 *
 * It is intentionally loaded only on pages where the banner is relevant so the
 * portfolio/demo UI stays isolated from the rest of the theme.
 */
function fu_should_load_page_banner_demo_panel()
{
    if (is_admin()) return false;

    return has_block('acf/fu-page-banner');
}

/**
 * Shared demo panel assets are needed by both portfolio demo pages.
 */
function fu_should_load_demo_panel_assets()
{
    if (is_admin()) return false;

    return fu_should_load_page_banner_demo_panel() || is_page_template('page-content-switcher.php');
}

/**
 * Return the display label for a portfolio item's stored project type.
 */
function fu_get_portfolio_project_type_label($post_id)
{
    $project_types = array(
        'wordpress' => 'WordPress',
        'front-end-prototype' => 'Front-End Prototype',
    );
    $portfolio_content = get_field('portfolio_content', $post_id);
    $project_type = is_array($portfolio_content) && isset($portfolio_content['project_type'])
        ? $portfolio_content['project_type']
        : '';

    return isset($project_types[$project_type]) ? $project_types[$project_type] : '';
}

function fu_inject_demo_panel()
{
    if (fu_should_load_page_banner_demo_panel()) {
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
