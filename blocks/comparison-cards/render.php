<?php

/**
 * Comparison Cards parent block template.
 *
 * Renders the section wrapper, header, and responsive grid.
 * Child acf/fu-comparison-card blocks provide card content via InnerBlocks.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    Rendered inner blocks HTML (child card blocks).
 * @param bool   $is_preview Whether preview is being shown.
 */

$is_preview = ! empty($is_preview);

$sanitize_choice = static function ($value, array $allowed, $fallback) {
    return in_array($value, $allowed, true) ? $value : $fallback;
};

$normalize_layout = static function ($value) {
    $raw = strtolower(trim((string) $value));

    $aliases = array(
        'auto' => 'auto',
        'automatic' => 'auto',
        '2-col' => '2-col',
        '2col' => '2-col',
        '2-cols' => '2-col',
        '2-column' => '2-col',
        '2-columns' => '2-col',
        '2 columns' => '2-col',
        'three-col' => '3-col',
        '3-col' => '3-col',
        '3col' => '3-col',
        '3-cols' => '3-col',
        '3-column' => '3-col',
        '3-columns' => '3-col',
        '3 columns' => '3-col',
    );

    return $aliases[$raw] ?? $raw;
};

// -------------------------------------------------------------------------
// Block-level fields
// -------------------------------------------------------------------------

$eyebrow = trim((string) ($block_data['cc_eyebrow'] ?? get_field('cc_eyebrow')));
$heading = trim((string) ($block_data['cc_heading'] ?? get_field('cc_heading')));
$intro   = trim((string) ($block_data['cc_intro']   ?? get_field('cc_intro')));

$block_data = $block['data'] ?? array();

$layout = $sanitize_choice(
    $normalize_layout($block_data['cc_layout'] ?? get_field('cc_layout') ?: 'auto'),
    array('auto', '2-col', '3-col'),
    'auto'
);

$card_style = $sanitize_choice(
    $block_data['cc_card_style'] ?? get_field('cc_card_style') ?: 'elevated',
    array('clean', 'elevated', 'bordered'),
    'elevated'
);

$bg_style = $sanitize_choice(
    $block_data['cc_bg_style'] ?? get_field('cc_bg_style') ?: 'none',
    array('none', 'light', 'dark', 'brand-tinted'),
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

// In preview mode with no cards yet, seed default header text for context.
if (! $has_cards && $is_preview) {
    if ($heading === '') {
        $heading = 'Choose the Right Membership';
    }
    if ($eyebrow === '') {
        $eyebrow = 'Membership Options';
    }
    if ($intro === '') {
        $intro = 'Find the level of support that fits where you are right now.';
    }
}

// -------------------------------------------------------------------------
// Build block wrapper classes and IDs.
// -------------------------------------------------------------------------

$block_id     = $block['id'] ?? uniqid('cc-');
$block_anchor = ! empty($block['anchor']) ? $block['anchor'] : 'fu-comparison-cards-' . $block_id;
$heading_id   = 'cc-heading-' . $block_id;

$classes = array(
    'fu-comparison-cards',
    'fu-comparison-cards--layout-' . $layout,
    'fu-comparison-cards--style-' . $card_style,
    'fu-comparison-cards--bg-' . $bg_style,
);

$block_class   = implode(' ', array_filter($classes));
$section_attrs = $heading !== '' ? ' aria-labelledby="' . esc_attr($heading_id) . '"' : '';

$innerblocks_allowed = array('acf/fu-comparison-card');
$innerblocks_template = array(
    array('acf/fu-comparison-card'),
    array('acf/fu-comparison-card'),
    array('acf/fu-comparison-card'),
);

?>
<section
    id="<?php echo esc_attr($block_anchor); ?>"
    class="<?php echo esc_attr($block_class); ?>"
    <?php echo $section_attrs; // Pre-escaped above. phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
    ?>>
    <div class="fu-comparison-cards__inner">

        <?php if ($eyebrow !== '' || $heading !== '' || $intro !== '') : ?>
            <header class="fu-comparison-cards__header">

                <?php if ($eyebrow !== '') : ?>
                    <p class="fu-comparison-cards__eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>

                <?php if ($heading !== '') : ?>
                    <h2 class="fu-comparison-cards__heading" id="<?php echo esc_attr($heading_id); ?>">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($intro !== '') : ?>
                    <p class="fu-comparison-cards__intro"><?php echo esc_html($intro); ?></p>
                <?php endif; ?>

            </header>
        <?php endif; ?>

        <div class="fu-comparison-cards__grid" role="list">

            <?php if ($is_preview) : ?>
                <?php
                echo '<InnerBlocks allowedBlocks="' . esc_attr(wp_json_encode($innerblocks_allowed)) . '" template="' . esc_attr(wp_json_encode($innerblocks_template)) . '" templateLock="false" />';
                ?>
            <?php elseif ($has_cards) : ?>
                <?php echo $content; // Rendered child acf/fu-comparison-card blocks. phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                ?>
            <?php endif; ?>

        </div><!-- .fu-comparison-cards__grid -->

    </div><!-- .fu-comparison-cards__inner -->
</section>