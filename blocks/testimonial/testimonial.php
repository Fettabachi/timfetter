<?php

/**
 * Testimonial Block template.
 * Prefix: fu (Fictional University)
 * @param array $block The block settings and attributes.
 */

// 1. Load values and assign defaults
$quote             = get_field('quote') ?: 'Your quote here...';
$author            = get_field('author');
$author_role       = get_field('role');
$bg_slug           = get_field('background_color') ?: 'primary'; // The select field slug
$text_color        = get_field('text_color');        // The color picker hex
$image             = get_field('image');

// 1. Determine the column width class
// If there is an image, we use our 64/36 split. 
// If NO image, we tell the column to be full width.
$col_class = $image ? 'fu-testimonial__testimonial--has-image' : 'fu-testimonial__col--full-width';

// 2. Build the Wrapper ID (Anchor)
$anchor = '';
if (! empty($block['anchor'])) {
    $anchor = ' id="' . esc_attr($block['anchor']) . '"';
}

// 3. Build Class String (Namespaced with fu-)
$classes = ['fu-testimonial'];

// Add alignment class
if (! empty($block['align'])) {
    $classes[] = 'align' . $block['align'];
}

// Add custom classes from the Block Editor sidebar
if (! empty($block['className'])) {
    $classes[] = $block['className'];
}

// Add the brand background class
$classes[] = 'has-brand-bg-' . $bg_slug;

$class_string = implode(' ', $classes);

$style_attr = '';
if ($text_color) {
    $style_attr = 'style="color: ' . esc_attr($text_color) . ';"';
} else {
    $style_attr = '';
}
?>

<div class="fu-testimonial-wrapper" <?php echo $anchor; ?>>
    <div class="<?php echo esc_attr($class_string); ?>" <?php echo $style_attr; ?>>

        <div class=" fu-testimonial__col <?php echo esc_attr($col_class); ?>">
            <blockquote class="fu-testimonial__blockquote">
                <p class="fu-testimonial__text"><?php echo esc_html($quote); ?></p>

                <?php if ($author) : ?>
                    <footer class="fu-testimonial__attribution">
                        <cite class="fu-testimonial__author"><?php echo esc_html($author); ?></cite>
                        <?php if ($author_role) : ?>
                            <span class="fu-testimonial__role"><?php echo esc_html($author_role); ?></span>
                        <?php endif; ?>
                    </footer>
                <?php endif; ?>
            </blockquote>
        </div>

        <?php if ($image) : ?>
            <div class="fu-testimonial__col fu-testimonial__col--image">
                <figure class="fu-testimonial__image">
                    <?php echo wp_get_attachment_image($image['ID'], 'full', '', array('class' => 'fu-testimonial__img')); ?>
                </figure>
            </div>
        <?php endif; ?>

    </div>
</div>