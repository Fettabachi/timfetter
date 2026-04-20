<?php

if (!function_exists('fu_filtered_content_grid_get_source_settings')) {
    function fu_filtered_content_grid_get_source_settings()
    {
        return [
            'post_type' => 'resource',
            'taxonomy' => 'resource_category',
            'rest_base' => 'resource',
        ];
    }
}

if (!function_exists('fu_filtered_content_grid_normalize_boolean')) {
    function fu_filtered_content_grid_normalize_boolean($value, $default = true)
    {
        if ($value === null || $value === '') {
            return $default;
        }

        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (int) $value !== 0;
        }

        if (is_string($value)) {
            $normalized = strtolower(trim($value));

            if (in_array($normalized, ['0', 'false', 'off', 'no'], true)) {
                return false;
            }

            if (in_array($normalized, ['1', 'true', 'on', 'yes'], true)) {
                return true;
            }
        }

        return (bool) $value;
    }
}

if (!function_exists('fu_filtered_content_grid_normalize_count')) {
    function fu_filtered_content_grid_normalize_count($value, $default = 12)
    {
        $count = absint($value);

        if ($count < 1) {
            $count = $default;
        }

        return min($count, 50);
    }
}

if (!function_exists('fu_filtered_content_grid_get_terms')) {
    function fu_filtered_content_grid_get_terms($taxonomy)
    {
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
        ]);

        if (is_wp_error($terms)) {
            return [];
        }

        return $terms;
    }
}

if (!function_exists('fu_filtered_content_grid_get_posts')) {
    function fu_filtered_content_grid_get_posts($source_settings, $active_term_id = 0, $item_count = 12)
    {
        $query_args = [
            'post_type' => $source_settings['post_type'],
            'post_status' => 'publish',
            'posts_per_page' => fu_filtered_content_grid_normalize_count($item_count),
            'no_found_rows' => true,
            'ignore_sticky_posts' => true,
        ];

        if ($active_term_id > 0) {
            $query_args['tax_query'] = [
                [
                    'taxonomy' => $source_settings['taxonomy'],
                    'field' => 'term_id',
                    'terms' => $active_term_id,
                ],
            ];
        }

        return new WP_Query($query_args);
    }
}

if (!function_exists('fu_filtered_content_grid_render_card')) {
    function fu_filtered_content_grid_render_card($post_id, $cta_label, $show_excerpt, $transition_name, $index = 0)
    {
        $permalink = get_permalink($post_id);
        $title = get_the_title($post_id);
        $excerpt = get_the_excerpt($post_id);
        $image_id = get_post_thumbnail_id($post_id);
        $image_html = '';

        if ($image_id) {
            $image_html = wp_get_attachment_image(
                $image_id,
                'large',
                false,
                [
                    'class' => 'fu-filtered-content-grid__image-media',
                    'loading' => 'lazy',
                ]
            );
        }

        ob_start();
?>
        <article class="fu-filtered-content-grid__card" style="--fu-filtered-index: <?php echo esc_attr((string) $index); ?>; view-transition-name: <?php echo esc_attr($transition_name); ?>;">
            <a class="fu-filtered-content-grid__image-link" href="<?php echo esc_url($permalink); ?>">
                <div class="fu-filtered-content-grid__image-wrap">
                    <?php if ($image_html) : ?>
                        <?php echo $image_html; ?>
                    <?php else : ?>
                        <div class="fu-filtered-content-grid__image-placeholder" aria-hidden="true"></div>
                    <?php endif; ?>
                </div>
            </a>

            <div class="fu-filtered-content-grid__content">
                <h3 class="fu-filtered-content-grid__title">
                    <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
                </h3>

                <?php if ($show_excerpt && $excerpt) : ?>
                    <div class="fu-filtered-content-grid__excerpt"><?php echo wp_kses_post(wpautop($excerpt)); ?></div>
                <?php endif; ?>

                <a class="fu-filtered-content-grid__cta" href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($cta_label); ?></a>
            </div>
        </article>
        <?php
        return trim((string) ob_get_clean());
    }
}

if (!function_exists('fu_filtered_content_grid_render_results')) {
    function fu_filtered_content_grid_render_results($query, $args)
    {
        $posts = $query instanceof WP_Query ? $query->posts : [];
        $cta_label = $args['cta_label'];
        $show_excerpt = (bool) $args['show_excerpt'];
        $empty_message = $args['empty_message'];
        $transition_scope = $args['transition_scope'];

        ob_start();

        if (!empty($posts)) {
            foreach ($posts as $index => $post) {
                echo fu_filtered_content_grid_render_card(
                    $post->ID,
                    $cta_label,
                    $show_excerpt,
                    $transition_scope . '-card-' . $post->ID,
                    $index
                );
            }
        } else {
        ?>
            <div class="fu-filtered-content-grid__empty-state">
                <p><?php echo esc_html($empty_message); ?></p>
            </div>
<?php
        }

        wp_reset_postdata();

        return trim((string) ob_get_clean());
    }
}
