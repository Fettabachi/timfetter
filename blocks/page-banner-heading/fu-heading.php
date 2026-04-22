<?php

/**
 * FU Heading Child Block - Audited for Accessibility & Editor UX
 */

// 1. Setup Fields with Defaults
$text  = get_field('heading_text');
$size  = get_field('heading_size') ?: 'large';
$level = get_field('heading_level') ?: 'h2'; // H2 is generally safer for nested blocks
$block_class_name = '';

if (!empty($block['className']) && is_string($block['className'])) {
    $block_class_name = trim($block['className']);
}

$is_subhead = $block_class_name !== '' && preg_match('/(?:^|\s)fu-page-banner__subhead(?:\s|$)/', $block_class_name);

$classes = array(
    'headline',
    'headline--' . $size,
);

if ($block_class_name !== '') {
    $classes[] = $block_class_name;
}

// 2. Logic: Show fallback text if empty in the editor
if (empty($text) && is_admin()) {
    $text = $is_subhead ? 'Enter subheading text...' : 'Enter heading text...';
}

// 3. Render: Only output on frontend if text exists
if (!empty($text) || is_admin()) : ?>

    <<?php echo esc_attr($level); ?> class="<?php echo esc_attr(implode(' ', $classes)); ?>">
        <?php echo esc_html($text); ?>
    </<?php echo esc_attr($level); ?>>

<?php endif; ?>