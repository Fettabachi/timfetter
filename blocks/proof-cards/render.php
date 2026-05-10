<?php

/**
 * Proof Cards parent block template.
 *
 * Renders the section wrapper, optional header, and responsive grid.
 * Child acf/fu-proof-card blocks provide card content via InnerBlocks.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    Rendered inner blocks HTML (child card blocks).
 * @param bool   $is_preview Whether preview is being shown.
 */

$is_preview = ! empty($is_preview);
$content = isset($content) && is_string($content) ? $content : '';

$sanitize_choice = static function ($value, array $allowed, $fallback) {
    return in_array($value, $allowed, true) ? $value : $fallback;
};

$block_data = $block['data'] ?? array();

// -------------------------------------------------------------------------
// Block-level fields
// -------------------------------------------------------------------------

$eyebrow = trim((string) ($block_data['pc_eyebrow'] ?? get_field('pc_eyebrow')));
$heading = trim((string) ($block_data['pc_heading'] ?? get_field('pc_heading')));
$intro   = trim((string) ($block_data['pc_intro']   ?? get_field('pc_intro')));

$layout = $sanitize_choice(
    $block_data['pc_layout'] ?? get_field('pc_layout') ?: 'grid',
    array('grid', 'featured-first'),
    'grid'
);

$card_style = $sanitize_choice(
    $block_data['pc_card_style'] ?? get_field('pc_card_style') ?: 'default',
    array('default', 'bordered', 'elevated'),
    'default'
);

$bg_style = $sanitize_choice(
    $block_data['pc_bg_style'] ?? get_field('pc_bg_style') ?: 'none',
    array('none', 'cool', 'dark', 'warm'),
    'none'
);

// -------------------------------------------------------------------------
// Determine whether child card content exists.
// -------------------------------------------------------------------------

$has_cards = is_string($content) && trim($content) !== '';

// On the front end with no child cards, output nothing.
if (! $has_cards && ! $is_preview) {
    return;
}

// In preview mode with no cards yet, seed defaults for context.
if (! $has_cards && $is_preview) {
    if ($heading === '') {
        $heading = 'Proof that connects feedback to outcomes';
    }
    if ($eyebrow === '') {
        $eyebrow = 'Client Proof & Project Outcomes';
    }
    if ($intro === '') {
        $intro = 'Use Proof Card child blocks to add testimonials, outcomes, and source details.';
    }
}

// -------------------------------------------------------------------------
// Build block wrapper classes and IDs.
// -------------------------------------------------------------------------

$block_id     = $block['id'] ?? uniqid('pc-');
$block_anchor = ! empty($block['anchor']) ? $block['anchor'] : 'fu-proof-cards-' . $block_id;
$heading_id   = 'pc-heading-' . $block_id;

$classes = array(
    'fu-proof-cards',
    'fu-proof-cards--layout-' . $layout,
    'fu-proof-cards--style-' . $card_style,
    'fu-proof-cards--bg-' . $bg_style,
);

if (! empty($block['align'])) {
    $classes[] = 'align' . $block['align'];
}

if (! empty($block['className']) && is_string($block['className'])) {
    $classes[] = $block['className'];
}

$block_class   = implode(' ', array_filter($classes));
$section_attrs = $heading !== '' ? ' aria-labelledby="' . esc_attr($heading_id) . '"' : '';

$innerblocks_allowed = array('acf/fu-proof-card');
$innerblocks_template = array(
    array(
        'acf/fu-proof-card',
        array(
            'data' => array(
                'card_label' => 'Client Result',
                '_card_label' => 'field_69f1pc0002002',
                'metric_value' => '42%',
                '_metric_value' => 'field_69f1pc0002003',
                'metric_label' => 'increase in qualified inquiries',
                '_metric_label' => 'field_69f1pc0002004',
                'statement' => 'Restructuring the service page around visitor intent helped users understand the offer faster and take the next step with less friction.',
                '_statement' => 'field_69f1pc0002005',
                'source_name' => 'BrightPath Dental',
                '_source_name' => 'field_69f1pc0002006',
                'source_detail' => 'Service landing page redesign',
                '_source_detail' => 'field_69f1pc0002007',
                'featured_card' => 1,
                '_featured_card' => 'field_69f1pc0002010',
            ),
        )
    ),
    array(
        'acf/fu-proof-card',
        array(
            'data' => array(
                'card_label' => 'Agency Feedback',
                '_card_label' => 'field_69f1pc0002002',
                'statement' => 'The block gave our client enough flexibility to manage the section themselves without breaking the design.',
                '_statement' => 'field_69f1pc0002005',
                'source_name' => 'Agency Partner',
                '_source_name' => 'field_69f1pc0002006',
                'source_detail' => 'WordPress implementation lead',
                '_source_detail' => 'field_69f1pc0002007',
            ),
        )
    ),
    array(
        'acf/fu-proof-card',
        array(
            'data' => array(
                'card_label' => 'Editor Experience',
                '_card_label' => 'field_69f1pc0002002',
                'metric_value' => '5 min',
                '_metric_value' => 'field_69f1pc0002003',
                'metric_label' => 'average time to add a new proof card',
                '_metric_label' => 'field_69f1pc0002004',
                'statement' => 'Editors can add a new result, quote, logo, and source link without touching layout settings or asking a developer for help.',
                '_statement' => 'field_69f1pc0002005',
                'source_name' => 'Internal publishing team',
                '_source_name' => 'field_69f1pc0002006',
                'source_detail' => 'Structured content workflow',
                '_source_detail' => 'field_69f1pc0002007',
            ),
        )
    ),
);

?>
<section
    id="<?php echo esc_attr($block_anchor); ?>"
    class="<?php echo esc_attr($block_class); ?>"
    <?php echo $section_attrs; // Pre-escaped above. phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    ?>>
    <div class="fu-proof-cards__container">

        <?php if ($eyebrow !== '' || $heading !== '' || $intro !== '') : ?>
            <header class="fu-proof-cards__header">

                <?php if ($eyebrow !== '') : ?>
                    <p class="fu-proof-cards__eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>

                <?php if ($heading !== '') : ?>
                    <h2 class="fu-proof-cards__heading" id="<?php echo esc_attr($heading_id); ?>">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($intro !== '') : ?>
                    <p class="fu-proof-cards__intro"><?php echo esc_html($intro); ?></p>
                <?php endif; ?>

            </header>
        <?php endif; ?>

        <div class="fu-proof-cards__grid" role="list">

            <?php if ($is_preview) : ?>
                <?php
                echo '<InnerBlocks allowedBlocks="' . esc_attr(wp_json_encode($innerblocks_allowed)) . '" template="' . esc_attr(wp_json_encode($innerblocks_template)) . '" templateLock="false" />';
                ?>
            <?php elseif ($has_cards) : ?>
                <?php echo $content; // Rendered child acf/fu-proof-card blocks. phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>
            <?php endif; ?>

        </div><!-- .fu-proof-cards__grid -->

    </div><!-- .fu-proof-cards__container -->
</section>