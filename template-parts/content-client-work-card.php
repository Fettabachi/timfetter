<?php

/**
 * Shared Selected Client Work card.
 *
 * @package Tim_Fetter_Portfolio
 */

$portfolio_post = isset($args['post']) && $args['post'] instanceof WP_Post ? $args['post'] : null;

if (!$portfolio_post) {
    return;
}

$heading_level = isset($args['heading_level']) && in_array($args['heading_level'], array('h2', 'h3'), true)
    ? $args['heading_level']
    : 'h3';
$kicker = isset($args['kicker']) && is_string($args['kicker']) ? trim($args['kicker']) : '';
$project_type = fu_get_portfolio_project_type_label($portfolio_post->ID);
$excerpt = has_excerpt($portfolio_post) ? get_the_excerpt($portfolio_post) : wp_trim_words(wp_strip_all_tags($portfolio_post->post_content), 26);
$thumbnail_id = get_post_thumbnail_id($portfolio_post);
$thumbnail_alt = $thumbnail_id ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : '';

if ($thumbnail_id && !$thumbnail_alt) {
    $thumbnail_alt = sprintf('%s project thumbnail.', get_the_title($portfolio_post));
}
?>

<a class="fu-work-card fu-work-card--linked fu-work-card--short-media fu-work-card--client-work" href="<?php echo esc_url(get_permalink($portfolio_post)); ?>">
    <?php if ($thumbnail_id) : ?>
        <div class="fu-work-card__media">
            <?php
            echo get_the_post_thumbnail(
                $portfolio_post,
                'medium_large',
                array(
                    'loading'  => 'lazy',
                    'decoding' => 'async',
                    'alt'      => $thumbnail_alt,
                )
            );
            ?>
        </div>
    <?php endif; ?>

    <div class="fu-work-card__body">
        <?php if ($kicker !== '') : ?>
            <p class="fu-work-card__kicker"><?php echo esc_html($kicker); ?></p>
        <?php endif; ?>

        <div class="fu-work-card__heading">
            <<?php echo tag_escape($heading_level); ?> class="fu-work-card__title"><?php echo esc_html(get_the_title($portfolio_post)); ?></<?php echo tag_escape($heading_level); ?>>

            <?php if ($project_type !== '') : ?>
                <p class="fu-work-card__meta"><?php echo esc_html($project_type); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($excerpt !== '') : ?>
            <p class="fu-work-card__text"><?php echo esc_html($excerpt); ?></p>
        <?php endif; ?>

        <span class="fu-work-card__link">View case study</span>
    </div>
</a>
