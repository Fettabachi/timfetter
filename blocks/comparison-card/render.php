<?php

/**
 * Comparison Card block template.
 *
 * Renders a single comparison card. Must be used inside an acf/fu-comparison-cards parent block.
 *
 * @param array $block      The block settings and attributes.
 * @param bool  $is_preview Whether preview is being shown.
 */

$is_preview = ! empty($is_preview);

// -------------------------------------------------------------------------
// Card content fields
// -------------------------------------------------------------------------

$card_title       = trim((string) get_field('card_title'));
$card_badge       = trim((string) get_field('card_badge'));
$card_description = trim((string) get_field('card_description'));

$featured_raw = get_field('card_featured');
$featured     = $featured_raw === null ? false : (bool) $featured_raw;

$show_pricing_raw = get_field('card_show_pricing');
$show_pricing     = $show_pricing_raw === null ? false : (bool) $show_pricing_raw;

// Button link — ACF link field returns an array.
$btn_link_field = get_field('card_btn_link');
$btn_link_field = is_array($btn_link_field) ? $btn_link_field : array();
$btn_url        = trim((string) ($btn_link_field['url'] ?? ''));
$btn_text       = trim((string) ($btn_link_field['title'] ?? ''));
$btn_target     = ! empty($btn_link_field['target']) ? $btn_link_field['target'] : '_self';

$has_complete_cta = ($btn_url !== '' && $btn_text !== '');
$show_editor_cta_placeholder = ($is_preview && $btn_text !== '' && $btn_url === '');

// Pricing fields — only read when pricing is enabled.
$price_prefix = '';
$price        = '';
$price_suffix = '';
$price_note   = '';

if ($show_pricing) {
    $price_prefix = trim((string) get_field('card_price_prefix'));
    $price        = trim((string) get_field('card_price'));
    $price_suffix = trim((string) get_field('card_price_suffix'));
    $price_note   = trim((string) get_field('card_price_note'));
}

$has_price_content = $show_pricing && ($price_prefix !== '' || $price !== '' || $price_suffix !== '' || $price_note !== '');

// Feature groups — WYSIWYG, one field per state; sanitized with wp_kses_post.
$feat_included     = wp_kses_post((string) get_field('card_feat_included'));
$feat_limited      = wp_kses_post((string) get_field('card_feat_limited'));
$feat_not_included = wp_kses_post((string) get_field('card_feat_not_included'));
$feat_highlighted  = wp_kses_post((string) get_field('card_feat_highlighted'));

// In preview mode with no title yet, show a placeholder label.
if ($is_preview && $card_title === '') {
    $card_title = 'Add card title';
}

// -------------------------------------------------------------------------
// Feature group config — visible label (read by all users) + decorative icon.
// Label text serves both sighted users and screen readers.
// Icon is aria-hidden and adds a non-color visual cue per state.
// -------------------------------------------------------------------------

$feature_groups_config = array(
    'included'     => array('label' => 'Included features',     'icon' => '✓'),
    'limited'      => array('label' => 'Limited features',      'icon' => '◐'),
    'not-included' => array('label' => 'Not included features', 'icon' => '✗'),
    'highlighted'  => array('label' => 'Highlighted features',  'icon' => '★'),
);

$feature_groups = array(
    'included'     => $feat_included,
    'limited'      => $feat_limited,
    'not-included' => $feat_not_included,
    'highlighted'  => $feat_highlighted,
);

$has_features = false;
foreach ($feature_groups as $group_content) {
    if (trim(strip_tags($group_content)) !== '') {
        $has_features = true;
        break;
    }
}

// -------------------------------------------------------------------------
// Build card wrapper classes.
// -------------------------------------------------------------------------

$card_classes = array('fu-comparison-card');

if ($featured) {
    $card_classes[] = 'fu-comparison-card--featured';
}

if ($card_badge !== '') {
    $card_classes[] = 'fu-comparison-card--has-badge';
}

?>
<div class="<?php echo esc_attr(implode(' ', $card_classes)); ?>" role="listitem">
    <article class="fu-comparison-card__article">

        <div class="fu-comparison-card__header">

            <?php if ($card_badge !== '') : ?>
                <p class="fu-comparison-card__badge">
                    <?php echo esc_html($card_badge); ?>
                </p>
            <?php endif; ?>

            <?php if ($card_title !== '') : ?>
                <h3 class="fu-comparison-card__title">
                    <?php echo esc_html($card_title); ?>
                </h3>
            <?php endif; ?>

            <?php if ($card_description !== '') : ?>
                <p class="fu-comparison-card__description">
                    <?php echo esc_html($card_description); ?>
                </p>
            <?php endif; ?>

        </div><!-- .fu-comparison-card__header -->

        <?php if ($has_price_content) : ?>
            <div class="fu-comparison-card__pricing">
                <?php if ($price_prefix !== '' || $price !== '' || $price_suffix !== '') : ?>
                    <div class="fu-comparison-card__price-line">

                        <?php if ($price_prefix !== '') : ?>
                            <span class="fu-comparison-card__price-prefix">
                                <?php echo esc_html($price_prefix); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($price !== '') : ?>
                            <span class="fu-comparison-card__price-value">
                                <?php echo esc_html($price); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($price_suffix !== '') : ?>
                            <span class="fu-comparison-card__price-suffix">
                                <?php echo esc_html($price_suffix); ?>
                            </span>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

                <?php if ($price_note !== '') : ?>
                    <p class="fu-comparison-card__price-note">
                        <?php echo esc_html($price_note); ?>
                    </p>
                <?php endif; ?>

            </div><!-- .fu-comparison-card__pricing -->
        <?php endif; ?>

        <?php if ($has_features) : ?>
            <div class="fu-comparison-card__features">

                <?php foreach ($feature_groups as $group_state => $group_content) : ?>
                    <?php if (trim(strip_tags($group_content)) !== '') : ?>
                        <?php $grp = $feature_groups_config[$group_state]; ?>

                        <div class="fu-comparison-card__feature-group fu-comparison-card__feature-group--<?php echo esc_attr($group_state); ?>">

                            <p class="fu-comparison-card__feature-group-label">
                                <span class="fu-comparison-card__feature-group-icon" aria-hidden="true"><?php echo esc_html($grp['icon']); ?></span>
                                <?php echo esc_html($grp['label']); ?>
                            </p>

                            <div class="fu-comparison-card__feature-content">
                                <?php echo $group_content; // Sanitized with wp_kses_post above. phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                ?>
                            </div>

                        </div><!-- .fu-comparison-card__feature-group -->
                    <?php endif; ?>
                <?php endforeach; ?>

            </div><!-- .fu-comparison-card__features -->
        <?php endif; ?>

        <?php if ($has_complete_cta || $show_editor_cta_placeholder) : ?>
            <div class="fu-comparison-card__actions">
                <a
                    href="<?php echo esc_url($has_complete_cta ? $btn_url : '#'); ?>"
                    class="fu-comparison-card__btn"
                    <?php if ($has_complete_cta && $btn_target === '_blank') : ?>
                    target="<?php echo esc_attr($btn_target); ?>"
                    rel="noopener noreferrer"
                    <?php endif; ?>>
                    <?php echo esc_html($btn_text); ?>
                </a>
            </div><!-- .fu-comparison-card__actions -->
        <?php endif; ?>

    </article><!-- .fu-comparison-card__article -->
</div><!-- .fu-comparison-card -->