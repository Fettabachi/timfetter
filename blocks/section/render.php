<?php

/**
 * Section Block Template
 */

// Fields
$layout = get_field('layout') ?: 'stacked';
$heading = get_field('heading');
$body = get_field('body');
$image = get_field('image');
$buttons = get_field('buttons');
$bg_color = get_field('background_color');
$padding = get_field('padding') ?: 'md';

// Classes
$classes = [
    'tf-section',
    'tf-section--layout-' . $layout,
    'tf-section--padding-' . $padding,
];

// Inline styles
$style = '';
if ($bg_color) {
    $style = 'style="background-color:' . esc_attr($bg_color) . ';"';
}
?>

<section class="<?php echo esc_attr(implode(' ', $classes)); ?>" <?php echo $style; ?>>
    <div class="tf-section__inner">

        <?php if ($image && !empty($image['url'])) : ?>
            <div class="tf-section__media">
                <img
                    src="<?php echo esc_url($image['url']); ?>"
                    alt="<?php echo esc_attr($image['alt'] ?? ''); ?>"
                    loading="lazy">
            </div>
        <?php endif; ?>

        <div class="tf-section__content">

            <?php if ($heading) : ?>
                <h2 class="tf-section__heading">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php endif; ?>

            <?php if ($body) : ?>
                <div class="tf-section__body">
                    <?php echo wp_kses_post($body); ?>
                </div>
            <?php endif; ?>

            <?php if ($buttons) : ?>
                <div class="tf-section__buttons">
                    <?php foreach ($buttons as $button) :
                        $link = $button['link'];
                        if ($link && !empty($link['url'])) : ?>
                            <a
                                href="<?php echo esc_url($link['url']); ?>"
                                target="<?php echo esc_attr($link['target'] ?: '_self'); ?>"
                                class="tf-button">
                                <?php echo esc_html($button['label']); ?>
                            </a>
                    <?php endif;
                    endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>
</section>