<?php

/**
 * FU Heading Child Block - Audited for Accessibility & Editor UX
 */

// 1. Setup Fields with Defaults
$text  = get_field('heading_text');
$size  = get_field('heading_size') ?: 'large';
$level = get_field('heading_level') ?: 'h2'; // H2 is generally safer for nested blocks

// 2. Logic: Show fallback text if empty in the editor
if (empty($text) && is_admin()) {
    $text = 'Enter heading text...';
}

// 3. Render: Only output on frontend if text exists
if (!empty($text) || is_admin()) : ?>

    <<?php echo esc_attr($level); ?> class="headline headline--<?php echo esc_attr($size); ?>">
        <?php echo esc_html($text); ?>
    </<?php echo esc_attr($level); ?>>

<?php endif; ?>