<?php

/**
 * Proof Card child block template.
 *
 * Renders a single proof card. Must be used inside an acf/fu-proof-cards parent block.
 *
 * @param array $block      The block settings and attributes.
 * @param bool  $is_preview Whether preview is being shown.
 */

$is_preview = ! empty($is_preview);

$card_label   = trim((string) get_field('card_label'));
$metric_value = trim((string) get_field('metric_value'));
$metric_label = trim((string) get_field('metric_label'));
$statement    = (string) get_field('statement');
$source_name  = trim((string) get_field('source_name'));
$source_detail = trim((string) get_field('source_detail'));
$image         = get_field('image_logo');
$link_raw      = get_field('link');
$featured_raw  = get_field('featured_card');

$image      = is_array($image) ? $image : array();
$link_raw   = is_array($link_raw) ? $link_raw : array();
$is_featured = $featured_raw === null ? false : (bool) $featured_raw;
$is_quote    = (bool) get_field('treat_statement_as_quote');

$link_url    = trim((string) ($link_raw['url'] ?? ''));
$link_text   = trim((string) ($link_raw['title'] ?? ''));
$link_target = ! empty($link_raw['target']) ? $link_raw['target'] : '_self';

if ($link_url !== '' && $link_text === '') {
    $link_text = 'View proof source';
}

$statement_markup = wp_kses_post($statement);
$has_statement    = trim(wp_strip_all_tags($statement_markup)) !== '';
$has_metric       = ($metric_value !== '' && $metric_label !== '');
$has_image        = ! empty($image['ID']);
$has_source       = ($source_name !== '' || $source_detail !== '');
$has_source_block = ($has_image || $has_source);
$has_link         = ($link_url !== '');

if (! $is_preview && ! $has_statement && ! $has_metric && ! $has_source_block && ! $has_link) {
    return;
}

if ($is_preview && ! $has_statement && $card_label === '' && ! $has_metric && ! $has_source_block && ! $has_link) {
    $card_label = 'Proof Card';
    $statement_markup = '<p>Add quote, outcome, or proof statement.</p>';
    $has_statement = true;
}

$card_classes = array('fu-proof-card');

if ($is_featured) {
    $card_classes[] = 'fu-proof-card--featured';
}

if ($is_quote) {
    $card_classes[] = 'fu-proof-card--is-quote';
}

?>
<article class="<?php echo esc_attr(implode(' ', $card_classes)); ?>" role="listitem">

    <?php if ($card_label !== '') : ?>
        <p class="fu-proof-card__label"><?php echo esc_html($card_label); ?></p>
    <?php endif; ?>

    <?php if ($has_metric) : ?>
        <div class="fu-proof-card__metric">
            <p class="fu-proof-card__metric-value"><?php echo esc_html($metric_value); ?></p>
            <p class="fu-proof-card__metric-label"><?php echo esc_html($metric_label); ?></p>
        </div>
    <?php endif; ?>

    <?php if ($has_statement) : ?>
        <blockquote class="fu-proof-card__statement">
            <div class="fu-proof-card__statement-inner">
                <?php echo $statement_markup; // Sanitized with wp_kses_post above. phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                ?>
            </div>
        </blockquote>
    <?php endif; ?>

    <?php if ($has_source_block) : ?>
        <footer class="fu-proof-card__source">

            <?php if ($has_image) :
                // If source name is visible, image is decorative; use empty alt.
                $img_alt = $source_name !== '' ? '' : trim((string) ($image['alt'] ?? ''));
            ?>
                <div class="fu-proof-card__image-wrap">
                    <?php
                    echo wp_get_attachment_image(
                        (int) $image['ID'],
                        'thumbnail',
                        false,
                        array(
                            'class' => 'fu-proof-card__image',
                            'alt'   => $img_alt,
                        )
                    );
                    ?>
                </div>
            <?php endif; ?>

            <?php if ($has_source) : ?>
                <div class="fu-proof-card__source-text">
                    <?php if ($source_name !== '') : ?>
                        <p class="fu-proof-card__source-name"><?php echo esc_html($source_name); ?></p>
                    <?php endif; ?>
                    <?php if ($source_detail !== '') : ?>
                        <p class="fu-proof-card__source-detail"><?php echo esc_html($source_detail); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </footer>
    <?php endif; ?>

    <?php if ($has_link) : ?>
        <a
            class="fu-proof-card__link"
            href="<?php echo esc_url($link_url); ?>"
            <?php if ($link_target === '_blank') : ?>
            target="_blank"
            rel="noopener noreferrer"
            <?php endif; ?>><?php echo esc_html($link_text); ?></a>
    <?php endif; ?>

</article>