<?php
/**
 * Plugin Name: Tim Fetter Portfolio Abilities
 * Description: Safe read-only portfolio system audit endpoint and Abilities API demo.
 * Version: 0.1.0
 * Author: Tim Fetter
 * Text Domain: timfetter-portfolio-abilities
 *
 * @package TimFetterPortfolioAbilities
 */

defined('ABSPATH') || exit;

const TF_PORTFOLIO_ABILITIES_REST_NAMESPACE = 'timfetter/v1';
const TF_PORTFOLIO_ABILITIES_REST_ROUTE = '/portfolio-system-audit';
const TF_PORTFOLIO_ABILITIES_PUBLIC_TRANSIENT = 'tf_portfolio_system_audit_public_v2';
const TF_PORTFOLIO_ABILITIES_CACHE_TTL = 10 * MINUTE_IN_SECONDS;

add_action('init', 'tf_portfolio_abilities_register_ability');
add_action('rest_api_init', 'tf_portfolio_abilities_register_rest_route');

/**
 * Register the demo ability when the host WordPress install supports it.
 */
function tf_portfolio_abilities_register_ability()
{
    if (!function_exists('wp_register_ability')) {
        return;
    }

    try {
        wp_register_ability(
            'timfetter/get-portfolio-system-audit',
            array(
                'label' => __('Get portfolio system audit', 'timfetter-portfolio-abilities'),
                'description' => __('Returns a public, sanitized, read-only summary of portfolio system health checks.', 'timfetter-portfolio-abilities'),
                'execute_callback' => 'tf_portfolio_abilities_get_audit',
                'permission_callback' => '__return_true',
                'input_schema' => array(
                    'type' => 'object',
                    'properties' => array(),
                    'additionalProperties' => false,
                ),
                'output_schema' => array(
                    'type' => 'object',
                    'additionalProperties' => true,
                ),
            )
        );
    } catch (Throwable $error) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('Portfolio Abilities API registration failed: ' . $error->getMessage()); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
        }
    }
}

/**
 * Register the controlled public REST endpoint used by the front-end demo.
 */
function tf_portfolio_abilities_register_rest_route()
{
    register_rest_route(
        TF_PORTFOLIO_ABILITIES_REST_NAMESPACE,
        TF_PORTFOLIO_ABILITIES_REST_ROUTE,
        array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'tf_portfolio_abilities_get_audit_response',
            'permission_callback' => '__return_true',
        )
    );
}

/**
 * Return audit data as a REST response.
 *
 * @return WP_REST_Response
 */
function tf_portfolio_abilities_get_audit_response()
{
    return rest_ensure_response(tf_portfolio_abilities_get_audit());
}

/**
 * Build or retrieve the public audit summary.
 *
 * @return array<string,mixed>
 */
function tf_portfolio_abilities_get_audit()
{
    $include_admin_details = tf_portfolio_abilities_can_view_admin_details();
    $cached_audit = $include_admin_details ? false : get_transient(TF_PORTFOLIO_ABILITIES_PUBLIC_TRANSIENT);

    if (is_array($cached_audit)) {
        return $cached_audit;
    }

    $checks = array(
        tf_portfolio_abilities_get_published_work_check($include_admin_details),
        tf_portfolio_abilities_get_published_resources_check($include_admin_details),
        tf_portfolio_abilities_get_work_thumbnail_check($include_admin_details),
        tf_portfolio_abilities_get_resource_category_check($include_admin_details),
        tf_portfolio_abilities_get_image_alt_check($include_admin_details),
        tf_portfolio_abilities_get_local_url_check($include_admin_details),
        tf_portfolio_abilities_get_acf_block_case_study_check($include_admin_details),
    );

    $audit = array(
        'title' => __('Portfolio System Audit', 'timfetter-portfolio-abilities'),
        'generatedAt' => gmdate('c'),
        'abilitiesAvailable' => function_exists('wp_register_ability'),
        'adminDetailsAvailable' => $include_admin_details,
        'source' => function_exists('wp_register_ability') ? 'abilities-ready-rest-fallback' : 'rest-fallback',
        'checks' => array_values(array_filter($checks)),
    );

    if (!$include_admin_details) {
        set_transient(TF_PORTFOLIO_ABILITIES_PUBLIC_TRANSIENT, $audit, TF_PORTFOLIO_ABILITIES_CACHE_TTL);
    }

    return $audit;
}

/**
 * Determine whether the current request may include maintenance details.
 *
 * @return bool
 */
function tf_portfolio_abilities_can_view_admin_details()
{
    return is_user_logged_in() && current_user_can('edit_posts');
}

/**
 * Count published posts for a public post type.
 *
 * @param string $post_type Post type key.
 * @return int
 */
function tf_portfolio_abilities_count_published($post_type)
{
    if (!post_type_exists($post_type)) {
        return 0;
    }

    $counts = wp_count_posts($post_type);

    return isset($counts->publish) ? (int) $counts->publish : 0;
}

/**
 * Published work count check.
 *
 * @return array<string,string>
 */
function tf_portfolio_abilities_get_published_work_check($include_admin_details = false)
{
    if (!$include_admin_details) {
        return tf_portfolio_abilities_make_public_check(
            'published_work',
            __('Published work items', 'timfetter-portfolio-abilities'),
            __('Checks whether the portfolio has published work available for visitors to browse.', 'timfetter-portfolio-abilities'),
            __('A populated work archive helps visitors understand the range, quality, and relevance of the portfolio.', 'timfetter-portfolio-abilities'),
            __('Authorized admins can review published work and add or update portfolio items when the archive needs attention.', 'timfetter-portfolio-abilities')
        );
    }

    $count = tf_portfolio_abilities_count_published('portfolio-items');

    return tf_portfolio_abilities_make_check(
        'published_work',
        __('Published work items', 'timfetter-portfolio-abilities'),
        $count > 0 ? 'pass' : 'notice',
        sprintf(
            /* translators: %d: published work count */
            _n('%d public portfolio item is available.', '%d public portfolio items are available.', $count, 'timfetter-portfolio-abilities'),
            $count
        ),
        __('A populated work archive helps visitors understand the range, quality, and relevance of the portfolio.', 'timfetter-portfolio-abilities'),
        __('Publish or refresh portfolio items so the Work archive reflects current capabilities.', 'timfetter-portfolio-abilities')
    );
}

/**
 * Published resources count check.
 *
 * @return array<string,string>
 */
function tf_portfolio_abilities_get_published_resources_check($include_admin_details = false)
{
    if (!$include_admin_details) {
        return tf_portfolio_abilities_make_public_check(
            'published_resources',
            __('Published resources', 'timfetter-portfolio-abilities'),
            __('Checks whether the site has published resources available for readers.', 'timfetter-portfolio-abilities'),
            __('Resources can support search visibility, demonstrate expertise, and give visitors a useful next step.', 'timfetter-portfolio-abilities'),
            __('Authorized admins can review the resource library and publish new resources when the library needs more coverage.', 'timfetter-portfolio-abilities')
        );
    }

    $count = tf_portfolio_abilities_count_published('resource');

    return tf_portfolio_abilities_make_check(
        'published_resources',
        __('Published resources', 'timfetter-portfolio-abilities'),
        $count > 0 ? 'pass' : 'notice',
        sprintf(
            /* translators: %d: published resource count */
            _n('%d public resource is available.', '%d public resources are available.', $count, 'timfetter-portfolio-abilities'),
            $count
        ),
        __('Resources can support search visibility, demonstrate expertise, and give visitors a useful next step.', 'timfetter-portfolio-abilities'),
        __('Publish useful resources or remove this check from the public demo if resources are not part of the content strategy.', 'timfetter-portfolio-abilities')
    );
}

/**
 * Work thumbnail coverage check.
 *
 * @return array<string,string>
 */
function tf_portfolio_abilities_get_work_thumbnail_check($include_admin_details = false)
{
    if (!$include_admin_details) {
        return tf_portfolio_abilities_make_public_check(
            'work_featured_images',
            __('Work featured images', 'timfetter-portfolio-abilities'),
            __('Checks whether published work items have featured images for cards, archives, and visual previews.', 'timfetter-portfolio-abilities'),
            __('Featured images make portfolio cards easier to scan and help case studies feel complete before a visitor clicks through.', 'timfetter-portfolio-abilities'),
            __('Authorized admins can open any flagged work item and set a clear, relevant featured image.', 'timfetter-portfolio-abilities')
        );
    }

    $total = tf_portfolio_abilities_count_published('portfolio-items');
    $missing_items = tf_portfolio_abilities_get_posts_missing_meta('portfolio-items', '_thumbnail_id');
    $missing_count = count($missing_items);
    return tf_portfolio_abilities_make_check(
        'work_featured_images',
        __('Work featured images', 'timfetter-portfolio-abilities'),
        $total > 0 && $missing_count === 0 ? 'pass' : 'notice',
        tf_portfolio_abilities_format_work_thumbnail_result($missing_count, $total),
        __('Featured images make portfolio cards easier to scan and help case studies feel complete before a visitor clicks through.', 'timfetter-portfolio-abilities'),
        __('Open each flagged work item and set a relevant featured image.', 'timfetter-portfolio-abilities'),
        tf_portfolio_abilities_make_admin_details($missing_items)
    );
}

/**
 * Resource category coverage check.
 *
 * @return array<string,string>
 */
function tf_portfolio_abilities_get_resource_category_check($include_admin_details = false)
{
    if (!$include_admin_details) {
        return tf_portfolio_abilities_make_public_check(
            'resource_categories',
            __('Resource categories', 'timfetter-portfolio-abilities'),
            __('Checks whether published resources are assigned to categories for filtering and browsing.', 'timfetter-portfolio-abilities'),
            __('Categories help visitors find related resources and keep the library from feeling like an unstructured list.', 'timfetter-portfolio-abilities'),
            __('Authorized admins can open any flagged resource and assign the most useful resource category.', 'timfetter-portfolio-abilities')
        );
    }

    $total = tf_portfolio_abilities_count_published('resource');
    $with_terms = 0;
    $missing_items = array();

    if ($total > 0 && taxonomy_exists('resource_category')) {
        $query = new WP_Query(
            array(
                'post_type' => 'resource',
                'post_status' => 'publish',
                'posts_per_page' => 50,
                'fields' => 'ids',
                'no_found_rows' => true,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => true,
            )
        );

        foreach ($query->posts as $post_id) {
            if (has_term('', 'resource_category', $post_id)) {
                ++$with_terms;
            } else {
                $missing_items[] = (int) $post_id;
            }
        }
    }

    $missing_count = count($missing_items);

    return tf_portfolio_abilities_make_check(
        'resource_categories',
        __('Resource categories', 'timfetter-portfolio-abilities'),
        $total > 0 && $missing_count === 0 ? 'pass' : 'notice',
        tf_portfolio_abilities_format_resource_category_result($missing_count, $total),
        __('Categories help visitors find related resources and keep the library from feeling like an unstructured list.', 'timfetter-portfolio-abilities'),
        __('Open each flagged resource and assign the most useful resource category.', 'timfetter-portfolio-abilities'),
        tf_portfolio_abilities_make_admin_details($missing_items)
    );
}

/**
 * Get published post IDs missing a meta key.
 *
 * @param string $post_type Post type key.
 * @param string $meta_key Meta key.
 * @return int[]
 */
function tf_portfolio_abilities_get_posts_missing_meta($post_type, $meta_key)
{
    if (!post_type_exists($post_type)) {
        return array();
    }

    $query = new WP_Query(
        array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => 50,
            'fields' => 'ids',
            'no_found_rows' => true,
            'meta_query' => array(
                array(
                    'key' => $meta_key,
                    'compare' => 'NOT EXISTS',
                ),
            ),
        )
    );

    return array_map('intval', $query->posts);
}

/**
 * Image alt text check scoped to a small public sample.
 *
 * @return array<string,string>
 */
function tf_portfolio_abilities_get_image_alt_check($include_admin_details = false)
{
    if (!$include_admin_details) {
        return tf_portfolio_abilities_make_public_check(
            'image_alt_text',
            __('Image alt text', 'timfetter-portfolio-abilities'),
            __('Checks whether recent public image uploads include alternative text.', 'timfetter-portfolio-abilities'),
            __('Alt text supports accessibility, gives non-visual visitors useful context, and can make media easier to maintain.', 'timfetter-portfolio-abilities'),
            __('Authorized admins can review flagged media items and add concise, descriptive alt text where the image conveys meaning.', 'timfetter-portfolio-abilities')
        );
    }

    $query = new WP_Query(
        array(
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'post_mime_type' => 'image',
            'posts_per_page' => 50,
            'fields' => 'ids',
            'no_found_rows' => true,
            'orderby' => 'date',
            'order' => 'DESC',
        )
    );

    $missing_alt = 0;
    $checked = count($query->posts);
    $missing_items = array();

    foreach ($query->posts as $attachment_id) {
        $alt = trim((string) get_post_meta($attachment_id, '_wp_attachment_image_alt', true));

        if ($alt === '') {
            ++$missing_alt;
            $missing_items[] = (int) $attachment_id;
        }
    }

    return tf_portfolio_abilities_make_check(
        'image_alt_text',
        __('Recent image alt text', 'timfetter-portfolio-abilities'),
        $checked > 0 && $missing_alt === 0 ? 'pass' : 'notice',
        tf_portfolio_abilities_format_missing_alt_result($missing_alt, $checked),
        __('Alt text supports accessibility, gives non-visual visitors useful context, and can make media easier to maintain.', 'timfetter-portfolio-abilities'),
        __('Open each flagged media item and add concise, descriptive alt text when the image conveys meaning.', 'timfetter-portfolio-abilities'),
        tf_portfolio_abilities_make_admin_details($missing_items)
    );
}

/**
 * Local development URL check scoped to published public content.
 *
 * @return array<string,string>
 */
function tf_portfolio_abilities_get_local_url_check($include_admin_details = false)
{
    if (!$include_admin_details) {
        return tf_portfolio_abilities_make_public_check(
            'local_urls',
            __('Local development URLs', 'timfetter-portfolio-abilities'),
            __('Checks published content for local development URL references before visitors encounter broken links or environment-specific paths.', 'timfetter-portfolio-abilities'),
            __('Local URLs can break on production and may reveal implementation details that do not belong in public content.', 'timfetter-portfolio-abilities'),
            __('Authorized admins can review flagged published content and replace local references with production URLs or relative links.', 'timfetter-portfolio-abilities')
        );
    }

    global $wpdb;

    $public_post_types = array_values(
        array_filter(
            array('post', 'page', 'portfolio-items', 'resource'),
            'post_type_exists'
        )
    );

    if (empty($public_post_types)) {
        return tf_portfolio_abilities_make_check(
            'local_urls',
            __('Local development URLs', 'timfetter-portfolio-abilities'),
            'notice',
            __('No public content types were available to scan.', 'timfetter-portfolio-abilities'),
            __('Local URLs can break on production and may reveal implementation details that do not belong in public content.', 'timfetter-portfolio-abilities'),
            __('Confirm that the public content types are registered before running the audit.', 'timfetter-portfolio-abilities')
        );
    }

    $placeholders = implode(', ', array_fill(0, count($public_post_types), '%s'));
    $patterns = array('%localhost%', '%127.0.0.1%', '%.local/%', '%Local Sites%');

    $sql = "
        SELECT ID
        FROM {$wpdb->posts}
        WHERE post_status = 'publish'
            AND post_type IN ({$placeholders})
            AND (
                post_content LIKE %s
                OR post_content LIKE %s
                OR post_content LIKE %s
                OR post_content LIKE %s
            )
        LIMIT 50
    ";

    $matching_ids = array_map(
        'intval',
        $wpdb->get_col($wpdb->prepare($sql, array_merge($public_post_types, $patterns))) // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
    );
    $matches = count($matching_ids);

    return tf_portfolio_abilities_make_check(
        'local_urls',
        __('Local development URLs', 'timfetter-portfolio-abilities'),
        $matches > 0 ? 'notice' : 'pass',
        tf_portfolio_abilities_format_local_url_result($matches),
        __('Local URLs can break on production and may reveal implementation details that do not belong in public content.', 'timfetter-portfolio-abilities'),
        __('Review flagged published content and replace local references with production URLs or relative links.', 'timfetter-portfolio-abilities'),
        tf_portfolio_abilities_make_admin_details($matching_ids)
    );
}

/**
 * Detect ACF block case-study pages by known public template usage.
 *
 * @return array<string,string>
 */
function tf_portfolio_abilities_get_acf_block_case_study_check($include_admin_details = false)
{
    if (!$include_admin_details) {
        return tf_portfolio_abilities_make_public_check(
            'acf_block_case_studies',
            __('ACF block case-study pages', 'timfetter-portfolio-abilities'),
            __('Checks whether public case-study pages are using the expected ACF block system templates.', 'timfetter-portfolio-abilities'),
            __('Template coverage helps keep the portfolio story connected to real reusable WordPress implementation work.', 'timfetter-portfolio-abilities'),
            __('Authorized admins can review detected case-study pages and update page templates when a page belongs in the block system collection.', 'timfetter-portfolio-abilities')
        );
    }

    $templates = array(
        'page-page-banner.php',
        'page-flexible-feature-section.php',
        'page-filtered-content-grid.php',
        'page-content-switcher.php',
        'page-comparison-cards.php',
        'page-proof-cards.php',
        'page-acf-block-system.php',
        'page-editor-experience.php',
    );

    $query = new WP_Query(
        array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => 50,
            'fields' => 'ids',
            'no_found_rows' => true,
            'meta_query' => array(
                array(
                    'key' => '_wp_page_template',
                    'value' => $templates,
                    'compare' => 'IN',
                ),
            ),
        )
    );

    $count = count($query->posts);

    return tf_portfolio_abilities_make_check(
        'acf_block_case_studies',
        __('ACF block case-study pages', 'timfetter-portfolio-abilities'),
        $count > 0 ? 'pass' : 'notice',
        sprintf(
            /* translators: %d: detected page count */
            _n('%d public ACF block case-study page was detected.', '%d public ACF block case-study pages were detected.', $count, 'timfetter-portfolio-abilities'),
            $count
        ),
        __('Template coverage helps keep the portfolio story connected to real reusable WordPress implementation work.', 'timfetter-portfolio-abilities'),
        __('Review page templates and assign the correct case-study template to any published block-system pages.', 'timfetter-portfolio-abilities')
    );
}

/**
 * Format work thumbnail result with useful action wording.
 *
 * @param int $missing_count Missing featured image count.
 * @param int $total Total published work count.
 * @return string
 */
function tf_portfolio_abilities_format_work_thumbnail_result($missing_count, $total)
{
    if ($total === 0) {
        return __('No published work items are available to check for featured images.', 'timfetter-portfolio-abilities');
    }

    if ($missing_count === 0) {
        return sprintf(
            /* translators: %d: total work count */
            _n('The published work item has a featured image.', 'All %d published work items have featured images.', $total, 'timfetter-portfolio-abilities'),
            $total
        );
    }

    return sprintf(
        /* translators: %d: missing featured image count */
        _n('%d published work item is missing a featured image.', '%d published work items are missing featured images.', $missing_count, 'timfetter-portfolio-abilities'),
        $missing_count
    );
}

/**
 * Format resource category result with useful action wording.
 *
 * @param int $missing_count Missing category count.
 * @param int $total Total published resource count.
 * @return string
 */
function tf_portfolio_abilities_format_resource_category_result($missing_count, $total)
{
    if ($total === 0) {
        return __('No published resources are available to check for categories.', 'timfetter-portfolio-abilities');
    }

    if ($missing_count === 0) {
        return sprintf(
            /* translators: %d: total resource count */
            _n('The published resource is categorized.', 'All %d published resources are categorized.', $total, 'timfetter-portfolio-abilities'),
            $total
        );
    }

    return sprintf(
        /* translators: %d: missing category count */
        _n('%d published resource is missing a category.', '%d published resources are missing categories.', $missing_count, 'timfetter-portfolio-abilities'),
        $missing_count
    );
}

/**
 * Format local URL result with useful action wording.
 *
 * @param int $matches Number of published content items with local URL references.
 * @return string
 */
function tf_portfolio_abilities_format_local_url_result($matches)
{
    if ($matches === 0) {
        return __('No local development URLs were found in published content.', 'timfetter-portfolio-abilities');
    }

    return sprintf(
        /* translators: %d: content item count */
        _n('%d published content item includes a local development URL reference.', '%d published content items include local development URL references.', $matches, 'timfetter-portfolio-abilities'),
        $matches
    );
}

/**
 * Format missing image alt text result with correct grammar.
 *
 * @param int $missing_alt Missing alt count.
 * @param int $checked Checked image count.
 * @return string
 */
function tf_portfolio_abilities_format_missing_alt_result($missing_alt, $checked)
{
    if ($checked === 0) {
        return __('No recent public images are available to check for alt text.', 'timfetter-portfolio-abilities');
    }

    if ($missing_alt === 0) {
        return sprintf(
            /* translators: %d: checked image count */
            _n('No missing alt text was found in the %d most recent public image.', 'No missing alt text was found in the %d most recent public images.', $checked, 'timfetter-portfolio-abilities'),
            $checked
        );
    }

    return sprintf(
        /* translators: 1: missing alt count, 2: checked image count */
        _n('%1$d image is missing alt text in the %2$d most recent public images.', '%1$d images are missing alt text in the %2$d most recent public images.', $missing_alt, 'timfetter-portfolio-abilities'),
        $missing_alt,
        $checked
    );
}

/**
 * Build safe admin details for published content items.
 *
 * @param int[] $post_ids Post IDs.
 * @return array<int,array<string,string>>
 */
function tf_portfolio_abilities_make_admin_details($post_ids)
{
    if (!tf_portfolio_abilities_can_view_admin_details() || empty($post_ids)) {
        return array();
    }

    $details = array();

    foreach ($post_ids as $post_id) {
        $post_id = (int) $post_id;
        $post = get_post($post_id);

        if (!$post || !in_array($post->post_status, array('publish', 'inherit'), true)) {
            continue;
        }

        $title = get_the_title($post_id);

        if ($post->post_type === 'attachment') {
            $filename = wp_basename((string) get_attached_file($post_id));

            if ($filename !== '') {
                $title = sprintf(
                    /* translators: 1: media title, 2: media filename */
                    __('%1$s (%2$s)', 'timfetter-portfolio-abilities'),
                    $title,
                    $filename
                );
            }
        }

        $item = array(
            'title' => sanitize_text_field($title),
        );

        if (current_user_can('edit_post', $post_id)) {
            $edit_link = get_edit_post_link($post_id, 'raw');

            if ($edit_link) {
                $item['edit_url'] = esc_url_raw($edit_link);
            }
        }

        $details[] = $item;
    }

    return $details;
}

/**
 * Normalize a public-safe check row.
 *
 * @param string $key Check key.
 * @param string $label Check label.
 * @param string $result Public result.
 * @param string $why_it_matters Public explanation.
 * @param string $recommended_fix Public recommendation.
 * @return array<string,string>
 */
function tf_portfolio_abilities_make_public_check($key, $label, $result, $why_it_matters, $recommended_fix)
{
    return tf_portfolio_abilities_make_check(
        $key,
        $label,
        'available',
        $result,
        $why_it_matters,
        $recommended_fix
    );
}

/**
 * Normalize an audit check row.
 *
 * @param string $key Check key.
 * @param string $label Check label.
 * @param string $status Public status.
 * @param string $result Safe result.
 * @param string $why_it_matters Why it matters.
 * @param string $recommended_fix Recommended fix.
 * @param array<int,array<string,string>> $admin_details Admin-only details.
 * @return array<string,mixed>
 */
function tf_portfolio_abilities_make_check($key, $label, $status, $result, $why_it_matters, $recommended_fix, $admin_details = array())
{
    $allowed_statuses = array('available', 'pass', 'notice');
    $check = array(
        'key' => sanitize_key($key),
        'label' => sanitize_text_field($label),
        'status' => in_array($status, $allowed_statuses, true) ? $status : 'notice',
        'result' => sanitize_text_field($result),
        'why_it_matters' => sanitize_text_field($why_it_matters),
        'recommended_fix' => sanitize_text_field($recommended_fix),
    );

    if (!empty($admin_details) && tf_portfolio_abilities_can_view_admin_details()) {
        $check['admin_details'] = $admin_details;
    }

    return $check;
}
