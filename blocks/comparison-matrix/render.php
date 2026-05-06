<?php

/**
 * FU Comparison Matrix Block — render template.
 * Prefix: fu
 * Phase 1 scaffold: placeholder only. Fields not yet implemented.
 *
 * @param array $block The block settings and attributes.
 */

// 1. Anchor
$anchor = '';
if (! empty($block['anchor'])) {
    $anchor = ' id="' . esc_attr($block['anchor']) . '"';
}

// 2. Class list
$classes = ['fu-comparison-matrix'];

if (! empty($block['align'])) {
    $classes[] = 'align' . $block['align'];
}

if (! empty($block['className'])) {
    $classes[] = $block['className'];
}

$class_string = implode(' ', $classes);
?>

<div class="<?php echo esc_attr($class_string); ?>" <?php echo $anchor; ?>>
    <p class="fu-comparison-matrix__placeholder">
        <?php esc_html_e('Comparison Matrix block scaffold ready.', 'tim-fetter-portfolio'); ?>
    </p>
</div>