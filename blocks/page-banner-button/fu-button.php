<?php

/**
 * FU Button Child Block - Optimized for Editor Visibility
 */

$link  = get_field('btn_link');
$size  = get_field('btn_size') ?: 'large';
$color = get_field('btn_color') ?: 'orange';

// 1. Prepare Data
$has_link = !empty($link['url']);
$url      = $has_link ? $link['url'] : '#';
$text     = $link['title'] ?? 'Learn More';
$target   = $has_link ? ($link['target'] ?? '_self') : '_self';
$rel      = ($target === '_blank') ? ' rel="noopener noreferrer"' : '';

$classes = [
    'btn',
    'btn--' . $size,
    'btn--fu-' . $color
];

if (!$has_link) {
    $classes[] = 'btn--placeholder';
}
?>

<a href="<?php echo esc_url($url); ?>"
    target="<?php echo esc_attr($target); ?>"
    <?php echo $rel; ?>
    <?php if (!$has_link) : ?>aria-disabled="true" onclick="return false;" title="Link not set yet" <?php endif; ?>
    class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <?php echo esc_html($text); ?>
</a>