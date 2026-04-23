<?php

/**
 * FU Content Switcher block template.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    Saved block content.
 * @param bool   $is_preview Whether preview is being shown.
 */

if (!function_exists('fu_content_switcher_get_seed_panels')) {
    function fu_content_switcher_get_seed_panels()
    {
        return array(
            array(
                'label' => 'Strategy',
                'slug' => 'strategy',
                'icon' => 'strategy',
                'eyebrow' => 'Content Planning',
                'heading' => 'Plan content before building layouts',
                'body' => 'Structured sections help teams organize complex information before visual styling begins, making content easier to maintain and easier for users to scan.',
                'highlights' => array(
                    'Clarifies content hierarchy',
                    'Reduces layout rework',
                    'Improves editorial consistency',
                ),
                'cta_1_text' => 'See the Demo',
                'cta_1_url' => '#live-demo',
                'cta_2_text' => 'Implementation Notes',
                'cta_2_url' => '#implementation',
            ),
            array(
                'label' => 'Design',
                'slug' => 'design',
                'icon' => 'design',
                'eyebrow' => 'System-Driven Styling',
                'heading' => 'Keep branding consistent across variations',
                'body' => 'The same structured component can support different visual treatments while staying inside a controlled design system for spacing, color, and presentation.',
                'highlights' => array(
                    'Predefined styling options',
                    'Brand-aware presentation',
                    'Flexible without visual drift',
                ),
                'cta_1_text' => 'Design Principles',
                'cta_1_url' => '#design-principles',
                'cta_2_text' => 'Editor Experience',
                'cta_2_url' => '#editor-experience',
            ),
            array(
                'label' => 'Development',
                'slug' => 'development',
                'icon' => 'development',
                'eyebrow' => 'Reusable Architecture',
                'heading' => 'Build components editors can trust',
                'body' => 'Reusable blocks are most effective when the editor experience mirrors the front end and content rules are clear enough to prevent accidental breakage.',
                'highlights' => array(
                    'Accessible interaction patterns',
                    'Predictable markup and styling',
                    'Better editor/front-end parity',
                ),
                'cta_1_text' => 'How It’s Built',
                'cta_1_url' => '#implementation',
                'cta_2_text' => 'View Portfolio',
                'cta_2_url' => '/portfolio/',
            ),
        );
    }
}

if (!function_exists('fu_content_switcher_seed_panel_data')) {
    function fu_content_switcher_seed_panel_data(array $panel)
    {
        $highlight_rows = array();

        foreach ($panel['highlights'] as $highlight) {
            $highlight_rows[] = array(
                'highlight_text' => $highlight,
                '_highlight_text' => 'field_6806fc300205',
            );
        }

        return array(
            'panel_label' => $panel['label'],
            '_panel_label' => 'field_6806fc300201',
            'panel_slug' => $panel['slug'],
            '_panel_slug' => 'field_6806fc300203',
            'panel_icon' => $panel['icon'],
            '_panel_icon' => 'field_6806fc300204',
            'panel_eyebrow' => $panel['eyebrow'],
            '_panel_eyebrow' => 'field_6806fc300206',
            'panel_heading' => $panel['heading'],
            '_panel_heading' => 'field_6806fc300207',
            'panel_body' => $panel['body'],
            '_panel_body' => 'field_6806fc300208',
            'panel_highlights' => $highlight_rows,
            '_panel_highlights' => 'field_6806fc300209',
            'panel_cta_1_text' => $panel['cta_1_text'],
            '_panel_cta_1_text' => 'field_6806fc30020b',
            'panel_cta_1_url' => $panel['cta_1_url'],
            '_panel_cta_1_url' => 'field_6806fc30020c',
            'panel_cta_2_text' => $panel['cta_2_text'],
            '_panel_cta_2_text' => 'field_6806fc30020d',
            'panel_cta_2_url' => $panel['cta_2_url'],
            '_panel_cta_2_url' => 'field_6806fc30020e',
        );
    }
}

if (!function_exists('fu_content_switcher_extract_panel_blocks')) {
    function fu_content_switcher_extract_panel_blocks(array $blocks)
    {
        $results = array();

        foreach ($blocks as $nested_block) {
            $block_name = $nested_block['blockName'] ?? $nested_block['name'] ?? '';

            if ($block_name === 'acf/fu-switcher-panel') {
                $results[] = $nested_block;
            }

            $inner_blocks = array();

            if (!empty($nested_block['innerBlocks']) && is_array($nested_block['innerBlocks'])) {
                $inner_blocks = $nested_block['innerBlocks'];
            } elseif (!empty($nested_block['inner_blocks']) && is_array($nested_block['inner_blocks'])) {
                $inner_blocks = $nested_block['inner_blocks'];
            }

            if (!empty($inner_blocks)) {
                $results = array_merge($results, fu_content_switcher_extract_panel_blocks($inner_blocks));
            }
        }

        return $results;
    }
}

if (!function_exists('fu_content_switcher_get_outer_html')) {
    function fu_content_switcher_get_outer_html(DOMNode $node)
    {
        $document = $node->ownerDocument;

        return $document instanceof DOMDocument ? trim((string) $document->saveHTML($node)) : '';
    }
}

if (!function_exists('fu_content_switcher_extract_saved_panel_markup')) {
    function fu_content_switcher_extract_saved_panel_markup($content)
    {
        if (!is_string($content) || trim($content) === '' || strpos($content, 'fu-switcher-panel') === false) {
            return array();
        }

        if (!class_exists('DOMDocument') || !class_exists('DOMXPath')) {
            return array();
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $wrapper_id = 'fu-content-switcher-panels-root';
        $markup = '<?xml encoding="utf-8" ?><div id="' . $wrapper_id . '">' . $content . '</div>';
        $previous_state = libxml_use_internal_errors(true);
        $loaded = $document->loadHTML($markup, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous_state);

        if (!$loaded) {
            return array();
        }

        $xpath = new DOMXPath($document);
        $nodes = $xpath->query(
            '//*[@id="' . $wrapper_id . '"]//*[contains(concat(" ", normalize-space(@class), " "), " fu-switcher-panel ") and not(ancestor::*[contains(concat(" ", normalize-space(@class), " "), " fu-switcher-panel ")]) ]'
        );

        if (!$nodes instanceof DOMNodeList || $nodes->length === 0) {
            return array();
        }

        $panels = array();

        foreach ($nodes as $node) {
            if (!$node instanceof DOMElement) {
                continue;
            }

            $html = fu_content_switcher_get_outer_html($node);

            if ($html === '') {
                continue;
            }

            $panels[] = array(
                'label' => trim((string) $node->getAttribute('data-panel-label')),
                'slug' => trim((string) $node->getAttribute('data-panel-slug')),
                'icon' => sanitize_key((string) $node->getAttribute('data-panel-icon')),
                'rendered' => $html,
            );
        }

        return $panels;
    }
}

if (!function_exists('fu_content_switcher_find_saved_block_instance')) {
    function fu_content_switcher_find_saved_block_instance(array $blocks, array $target_block)
    {
        $target_id = (string) ($target_block['id'] ?? '');
        $target_anchor = (string) ($target_block['anchor'] ?? '');

        foreach ($blocks as $parsed_block) {
            $block_name = $parsed_block['blockName'] ?? $parsed_block['name'] ?? '';

            if ($block_name !== 'acf/fu-content-switcher') {
                $inner_blocks = $parsed_block['innerBlocks'] ?? $parsed_block['inner_blocks'] ?? array();

                if (!empty($inner_blocks) && is_array($inner_blocks)) {
                    $match = fu_content_switcher_find_saved_block_instance($inner_blocks, $target_block);

                    if (is_array($match)) {
                        return $match;
                    }
                }

                continue;
            }

            $attrs = $parsed_block['attrs'] ?? array();
            $parsed_id = (string) ($attrs['id'] ?? '');
            $parsed_anchor = (string) ($attrs['anchor'] ?? '');

            if ($target_id !== '' && $parsed_id === $target_id) {
                return $parsed_block;
            }

            if ($target_anchor !== '' && $parsed_anchor !== '' && $parsed_anchor === $target_anchor) {
                return $parsed_block;
            }
        }

        return null;
    }
}

if (!function_exists('fu_content_switcher_resolve_saved_inner_blocks')) {
    function fu_content_switcher_resolve_saved_inner_blocks(array $block)
    {
        if (!function_exists('parse_blocks')) {
            return array();
        }

        $post_id = get_the_ID();

        if (!$post_id) {
            $post = get_post();
            $post_id = $post instanceof WP_Post ? $post->ID : 0;
        }

        if (!$post_id) {
            return array();
        }

        $post = get_post($post_id);

        if (!$post instanceof WP_Post || !is_string($post->post_content) || $post->post_content === '') {
            return array();
        }

        $parsed_blocks = parse_blocks($post->post_content);

        if (empty($parsed_blocks)) {
            return array();
        }

        $matched_block = fu_content_switcher_find_saved_block_instance($parsed_blocks, $block);

        if (!is_array($matched_block)) {
            return array();
        }

        $inner_blocks = $matched_block['innerBlocks'] ?? $matched_block['inner_blocks'] ?? array();

        return is_array($inner_blocks) ? $inner_blocks : array();
    }
}

if (!function_exists('fu_content_switcher_collect_panel_blocks')) {
    function fu_content_switcher_collect_panel_blocks(array $block, $content)
    {
        $sources = array();

        if (!empty($block['innerBlocks']) && is_array($block['innerBlocks'])) {
            $sources = $block['innerBlocks'];
        } elseif (!empty($block['parsed_block']['innerBlocks']) && is_array($block['parsed_block']['innerBlocks'])) {
            $sources = $block['parsed_block']['innerBlocks'];
        } elseif (is_string($content) && strpos($content, '<!-- wp:') !== false) {
            $sources = parse_blocks($content);
        } else {
            $sources = fu_content_switcher_resolve_saved_inner_blocks($block);
        }

        return fu_content_switcher_extract_panel_blocks($sources);
    }
}

if (!function_exists('fu_content_switcher_sanitize_choice')) {
    function fu_content_switcher_sanitize_choice($value, array $allowed, $fallback)
    {
        return in_array($value, $allowed, true) ? $value : $fallback;
    }
}

if (!function_exists('fu_content_switcher_normalize_bool')) {
    function fu_content_switcher_normalize_bool($value, $fallback = false)
    {
        if ($value === null) {
            return (bool) $fallback;
        }

        return (bool) $value;
    }
}

if (!function_exists('fu_content_switcher_unique_slug')) {
    function fu_content_switcher_unique_slug($preferred, $fallback_label, array &$used_slugs)
    {
        $base_slug = sanitize_title($preferred !== '' ? $preferred : $fallback_label);

        if ($base_slug === '') {
            $base_slug = 'panel';
        }

        $slug = $base_slug;
        $suffix = 2;

        while (in_array($slug, $used_slugs, true)) {
            $slug = $base_slug . '-' . $suffix;
            $suffix++;
        }

        $used_slugs[] = $slug;

        return $slug;
    }
}

if (!function_exists('fu_content_switcher_instance_prefix')) {
    function fu_content_switcher_instance_prefix(array $block, $is_preview = false)
    {
        $raw_id = (string) ($block['id'] ?? '');
        $sanitized_id = sanitize_title($raw_id);

        static $render_counts = array();

        if ($sanitized_id === '') {
            $sanitized_id = 'instance';
        }

        if ($is_preview) {
            return 'switcher-' . $sanitized_id;
        }

        $render_counts[$sanitized_id] = ($render_counts[$sanitized_id] ?? 0) + 1;

        return 'switcher-' . $sanitized_id . '-' . $render_counts[$sanitized_id];
    }
}

if (!function_exists('fu_content_switcher_hash_slug')) {
    function fu_content_switcher_hash_slug($instance_prefix, $panel_slug)
    {
        $panel_slug = sanitize_title((string) $panel_slug);

        if ($panel_slug === '') {
            $panel_slug = 'panel';
        }

        return $instance_prefix . '-' . $panel_slug;
    }
}

if (!function_exists('fu_content_switcher_panel_icon_svg')) {
    function fu_content_switcher_panel_icon_svg($icon)
    {
        $icons = array(
            'strategy' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 5.75A1.75 1.75 0 0 1 5.75 4h8.19a1.75 1.75 0 0 1 1.24.51l3.31 3.31c.33.33.51.78.51 1.24v9.19A1.75 1.75 0 0 1 17.25 20h-11.5A1.75 1.75 0 0 1 4 18.25Zm2 1.25v10h10v-6h-3.5A1.5 1.5 0 0 1 11 9.5V6Zm7 .41V9h1.59Z"/></svg>',
            'design' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M11.1 3.39a1.5 1.5 0 0 1 1.8 0l6.26 4.69a1.5 1.5 0 0 1 .6 1.2v7.44a1.5 1.5 0 0 1-.6 1.2l-6.26 4.69a1.5 1.5 0 0 1-1.8 0l-6.26-4.69a1.5 1.5 0 0 1-.6-1.2V9.28a1.5 1.5 0 0 1 .6-1.2ZM12 6.18 7.2 9.77V15L12 18.59 16.8 15V9.77Z"/></svg>',
            'development' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M8.47 7.22a1 1 0 0 1 0 1.41L5.12 12l3.35 3.37a1 1 0 1 1-1.42 1.4l-4.05-4.08a1 1 0 0 1 0-1.4l4.05-4.07a1 1 0 0 1 1.42 0Zm7.06 0a1 1 0 0 1 1.42 0L21 11.29a1 1 0 0 1 0 1.4l-4.05 4.08a1 1 0 0 1-1.42-1.4L18.88 12l-3.35-3.37a1 1 0 0 1 0-1.41ZM13.9 4.36a1 1 0 0 1 .74 1.21l-3 12a1 1 0 1 1-1.94-.48l3-12a1 1 0 0 1 1.2-.73Z"/></svg>',
            'audience' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 12a3.5 3.5 0 1 0-3.5-3.5A3.5 3.5 0 0 0 12 12Zm-6.75 7a5.75 5.75 0 0 1 11.5 0 1 1 0 0 1-2 0 3.75 3.75 0 1 0-7.5 0 1 1 0 0 1-2 0Zm12.5-5.59A3 3 0 1 0 14.76 8a3 3 0 0 0 2.99 5.41ZM18.25 19a4.7 4.7 0 0 0-.63-2.35 3.75 3.75 0 0 1 3.13 2.35 1 1 0 0 1-1.88.7Z"/></svg>',
            'check' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M9.55 16.2 5.3 11.95a1 1 0 1 1 1.4-1.42l2.85 2.86 7.75-7.76a1 1 0 1 1 1.4 1.42l-9.15 9.15a1 1 0 0 1-1.4 0Z"/></svg>',
        );

        return $icons[$icon] ?? '';
    }
}

$display_style = fu_content_switcher_sanitize_choice(
    get_field('display_style') ?: 'tabs',
    array('tabs', 'pills', 'vertical', 'minimal'),
    'tabs'
);

$mobile_behavior = fu_content_switcher_sanitize_choice(
    get_field('mobile_behavior') ?: 'accordion',
    array('accordion', 'stacked'),
    'accordion'
);

$nav_alignment = fu_content_switcher_sanitize_choice(
    get_field('nav_alignment') ?: 'left',
    array('left', 'center', 'right'),
    'left'
);

$panel_layout = fu_content_switcher_sanitize_choice(
    get_field('panel_layout') ?: 'text_media',
    array('text_only', 'text_media', 'media_text'),
    'text_media'
);

$background_style = fu_content_switcher_sanitize_choice(
    get_field('background_style') ?: 'surface',
    array('none', 'surface', 'surface-alt', 'brand-tint', 'dark'),
    'surface'
);

$panel_radius = fu_content_switcher_sanitize_choice(
    get_field('panel_radius') ?: 'medium',
    array('none', 'small', 'medium', 'large'),
    'medium'
);

$spacing_top = fu_content_switcher_sanitize_choice(
    get_field('spacing_top') ?: 'medium',
    array('small', 'medium', 'large'),
    'medium'
);

$spacing_bottom = fu_content_switcher_sanitize_choice(
    get_field('spacing_bottom') ?: 'medium',
    array('small', 'medium', 'large'),
    'medium'
);

$panel_transition = fu_content_switcher_sanitize_choice(
    get_field('panel_transition') ?: 'fade',
    array('none', 'fade', 'slide'),
    'fade'
);

$show_nav_icons = fu_content_switcher_normalize_bool(get_field('show_nav_icons'), false);
$equal_nav_items = fu_content_switcher_normalize_bool(get_field('equal_nav_items'), false);
$enable_deep_linking = fu_content_switcher_normalize_bool(get_field('enable_deep_linking'), true);

$seed_panels = fu_content_switcher_get_seed_panels();

$template = array();
foreach ($seed_panels as $seed_panel) {
    $template[] = array(
        'acf/fu-switcher-panel',
        array(
            'data' => fu_content_switcher_seed_panel_data($seed_panel),
        ),
    );
}

$saved_panel_markup = !$is_preview ? fu_content_switcher_extract_saved_panel_markup($content ?? '') : array();
$panel_blocks = empty($saved_panel_markup) ? fu_content_switcher_collect_panel_blocks($block, $content ?? '') : array();

if (empty($saved_panel_markup) && empty($panel_blocks)) {
    foreach ($seed_panels as $seed_panel) {
        $panel_blocks[] = array(
            'blockName' => 'acf/fu-switcher-panel',
            'attrs' => array(
                'name' => 'acf/fu-switcher-panel',
                'data' => fu_content_switcher_seed_panel_data($seed_panel),
            ),
            'innerBlocks' => array(),
            'innerHTML' => '',
            'innerContent' => array(),
        );
    }
}

$instance_prefix = fu_content_switcher_instance_prefix($block, $is_preview);
$internal_id_prefix = $instance_prefix;
$used_slugs = array();
$panels = array();

if (!empty($saved_panel_markup)) {
    foreach ($saved_panel_markup as $index => $saved_panel) {
        $label = trim((string) ($saved_panel['label'] ?? ''));
        $fallback_label = $label !== '' ? $label : 'Panel ' . ($index + 1);
        $slug = fu_content_switcher_unique_slug(trim((string) ($saved_panel['slug'] ?? '')), $fallback_label, $used_slugs);
        $hash_slug = fu_content_switcher_hash_slug($instance_prefix, $slug);

        $panels[] = array(
            'index' => $index,
            'label' => $fallback_label,
            'slug' => $slug,
            'hash_slug' => $hash_slug,
            'icon' => sanitize_key((string) ($saved_panel['icon'] ?? '')),
            'tab_id' => $internal_id_prefix . '-tab-' . ($index + 1),
            'panel_id' => $internal_id_prefix . '-panel-' . ($index + 1),
            'accordion_id' => $internal_id_prefix . '-accordion-' . ($index + 1),
            'rendered' => $saved_panel['rendered'],
        );
    }
} else {
    foreach ($panel_blocks as $index => $panel_block) {
        $attrs = $panel_block['attrs'] ?? array();
        $data = $attrs['data'] ?? array();
        $label = trim((string) ($data['panel_label'] ?? ''));
        $fallback_label = $label !== '' ? $label : 'Panel ' . ($index + 1);
        $slug = fu_content_switcher_unique_slug(trim((string) ($data['panel_slug'] ?? '')), $fallback_label, $used_slugs);
        $hash_slug = fu_content_switcher_hash_slug($instance_prefix, $slug);

        $panels[] = array(
            'index' => $index,
            'label' => $fallback_label,
            'slug' => $slug,
            'hash_slug' => $hash_slug,
            'icon' => sanitize_key((string) ($data['panel_icon'] ?? '')),
            'tab_id' => $internal_id_prefix . '-tab-' . ($index + 1),
            'panel_id' => $internal_id_prefix . '-panel-' . ($index + 1),
            'accordion_id' => $internal_id_prefix . '-accordion-' . ($index + 1),
            'rendered' => !$is_preview ? render_block($panel_block) : '',
        );
    }
}

$panel_count = count($panels);
$initial_index = max(0, (int) (get_field('initial_active_panel') ?: 1) - 1);

if ($panel_count > 0 && $initial_index >= $panel_count) {
    $initial_index = 0;
}

$classes = array(
    'fu-content-switcher',
    'fu-content-switcher--' . $display_style,
    'fu-content-switcher--mobile-' . $mobile_behavior,
    'fu-content-switcher--layout-' . $panel_layout,
    'fu-content-switcher--bg-' . sanitize_html_class($background_style),
    'fu-content-switcher--radius-' . $panel_radius,
    'fu-content-switcher--nav-' . $nav_alignment,
    'fu-content-switcher--transition-' . $panel_transition,
    'fu-content-switcher--pt-' . $spacing_top,
    'fu-content-switcher--pb-' . $spacing_bottom,
);

if ($show_nav_icons) {
    $classes[] = 'fu-content-switcher--show-icons';
}

if ($equal_nav_items) {
    $classes[] = 'fu-content-switcher--equal-nav';
}

if (!empty($block['align'])) {
    $classes[] = 'align' . $block['align'];
}

if (!empty($block['className'])) {
    $classes[] = $block['className'];
}

$wrapper_id = !empty($block['anchor']) ? $block['anchor'] : $internal_id_prefix;
?>
<section
    id="<?php echo esc_attr($wrapper_id); ?>"
    class="<?php echo esc_attr(implode(' ', $classes)); ?>"
    data-fu-content-switcher
    data-instance-prefix="<?php echo esc_attr($instance_prefix); ?>"
    data-display-style="<?php echo esc_attr($display_style); ?>"
    data-mobile-behavior="<?php echo esc_attr($mobile_behavior); ?>"
    data-initial-index="<?php echo esc_attr((string) $initial_index); ?>"
    data-deep-link-enabled="<?php echo esc_attr($enable_deep_linking ? 'true' : 'false'); ?>"
    data-transition="<?php echo esc_attr($panel_transition); ?>">
    <?php if ($panel_count > 0) : ?>
        <div
            class="fu-content-switcher__nav"
            role="tablist"
            aria-label="Content Switcher panels"
            aria-orientation="<?php echo esc_attr($display_style === 'vertical' ? 'vertical' : 'horizontal'); ?>">
            <?php foreach ($panels as $panel) : ?>
                <?php $is_active = $panel['index'] === $initial_index; ?>
                <?php $render_nav_icon = $show_nav_icons && (!$is_preview && $panel['icon'] !== '' || $is_preview); ?>
                <button
                    type="button"
                    id="<?php echo esc_attr($panel['tab_id']); ?>"
                    class="fu-content-switcher__tab<?php echo $is_active ? ' is-active' : ''; ?>"
                    role="tab"
                    aria-selected="<?php echo esc_attr($is_active ? 'true' : 'false'); ?>"
                    aria-controls="<?php echo esc_attr($panel['panel_id']); ?>"
                    tabindex="<?php echo esc_attr($is_active ? '0' : '-1'); ?>"
                    data-fu-switcher-tab
                    data-panel-index="<?php echo esc_attr((string) $panel['index']); ?>"
                    data-panel-slug="<?php echo esc_attr($panel['slug']); ?>"
                    data-panel-hash="<?php echo esc_attr($panel['hash_slug']); ?>"
                    data-panel-label="<?php echo esc_attr($panel['label']); ?>">
                    <?php if ($render_nav_icon) : ?>
                        <span class="fu-content-switcher__tab-icon" aria-hidden="true"><?php echo $is_preview ? '' : fu_content_switcher_panel_icon_svg($panel['icon']); ?></span>
                    <?php endif; ?>
                    <span class="fu-content-switcher__tab-label"><?php echo esc_html($panel['label']); ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="fu-content-switcher__panels" data-fu-switcher-panels>
            <?php if ($is_preview) : ?>
                <?php
                echo '<InnerBlocks allowedBlocks="' . esc_attr(wp_json_encode(array('acf/fu-switcher-panel'))) . '" template="' . esc_attr(wp_json_encode($template)) . '" />';
                ?>
            <?php else : ?>
                <?php foreach ($panels as $panel) : ?>
                    <?php $is_active = $panel['index'] === $initial_index; ?>
                    <div
                        class="fu-content-switcher__panel<?php echo $is_active ? ' is-active' : ''; ?>"
                        data-fu-switcher-panel
                        data-panel-index="<?php echo esc_attr((string) $panel['index']); ?>"
                        data-panel-slug="<?php echo esc_attr($panel['slug']); ?>"
                        data-panel-hash="<?php echo esc_attr($panel['hash_slug']); ?>"
                        data-panel-label="<?php echo esc_attr($panel['label']); ?>">
                        <button
                            type="button"
                            id="<?php echo esc_attr($panel['accordion_id']); ?>"
                            class="fu-content-switcher__accordion-trigger<?php echo $is_active ? ' is-active' : ''; ?>"
                            aria-controls="<?php echo esc_attr($panel['panel_id']); ?>"
                            aria-expanded="<?php echo esc_attr($is_active ? 'true' : 'false'); ?>"
                            data-fu-switcher-accordion
                            data-panel-index="<?php echo esc_attr((string) $panel['index']); ?>"
                            data-panel-slug="<?php echo esc_attr($panel['slug']); ?>"
                            data-panel-hash="<?php echo esc_attr($panel['hash_slug']); ?>"
                            data-panel-label="<?php echo esc_attr($panel['label']); ?>">
                            <?php if ($show_nav_icons && $panel['icon'] !== '') : ?>
                                <span class="fu-content-switcher__tab-icon" aria-hidden="true"><?php echo fu_content_switcher_panel_icon_svg($panel['icon']); ?></span>
                            <?php endif; ?>
                            <span class="fu-content-switcher__tab-label"><?php echo esc_html($panel['label']); ?></span>
                        </button>

                        <div
                            id="<?php echo esc_attr($panel['panel_id']); ?>"
                            class="fu-content-switcher__panel-inner"
                            role="tabpanel"
                            aria-labelledby="<?php echo esc_attr($panel['tab_id']); ?>"
                            <?php echo $is_active ? '' : 'hidden'; ?>>
                            <?php echo $panel['rendered']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>