<?php

/**
 * Property Stats Block - Universal Data Bridge
 */

$post_id = get_the_ID();

// 1. Try to get data from the BLOCK first
$block_fields = get_fields();

// 2. Fallback logic with proper grouping to avoid Fatal Errors
$price  = !empty($block_fields['price']) ? $block_fields['price'] : get_field('price', $post_id);

// FIXED LINE: We group the first ternary, then apply the fallback
$status = (!empty($block_fields['property_status']) ? $block_fields['property_status'] : get_field('property_status', $post_id)) ?: 'available';

$beds   = !empty($block_fields['bedrooms']) ? $block_fields['bedrooms'] : get_field('bedrooms', $post_id);
$baths  = !empty($block_fields['bathrooms']) ? $block_fields['bathrooms'] : get_field('bathrooms', $post_id);
$sqft   = !empty($block_fields['square_feet']) ? $block_fields['square_feet'] : get_field('square_feet', $post_id);

// 2. Logic & Formatting
$clean_price = preg_replace('/[^0-9.]/', '', $price);
$formatted_price = $clean_price ? '$' . number_format((float)$clean_price) : '$0';

// 3. Determine if the block is "Empty"
$is_empty = (!$price && !$beds && !$baths);
// $is_property_post = ($post_type === 'fu_property');

// Clean and format price
$clean_price = preg_replace('/[^0-9.]/', '', $price);
$formatted_price = $clean_price ? '$' . number_format((float)$clean_price) : '$0';

// 3. Setup Classes
$classes = ['fu-property-stats-bar', 'status-' . esc_attr($status)];
if (!empty($block['className'])) $classes[] = $block['className'];
if ($is_empty) $classes[] = 'is-empty-state';
?>

<section class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <?php if ($is_empty && is_admin()) : ?>
        <div class="fu-prop-placeholder" style="padding: 20px; border: 2px dashed #ccc; text-align: center;">
            <strong>Property Stats:</strong> Please enter details in the sidebar to see the preview.
        </div>
    <?php else : ?>
        <div class="fu-prop-grid container">
            <!-- <div class="fu-prop-col fu-prop-col--status">
                <span class="fu-status-badge"><?php echo esc_html(ucfirst(str_replace('-', ' ', $status))); ?></span>
            </div> -->

            <div class="fu-prop-col fu-prop-col--price">
                <span class="label">Price</span>
                <span class="value"><?php echo esc_html($formatted_price); ?></span>
            </div>

            <div class="fu-prop-col">
                <span class="value"><?php echo esc_html($beds); ?></span>
                <span class="label">Beds</span>
            </div>
            <div class="fu-prop-col">
                <span class="value"><?php echo esc_html($baths); ?></span>
                <span class="label">Baths</span>
            </div>
            <div class="fu-prop-col">
                <span class="value"><?php echo number_format((float)$sqft); ?></span>
                <span class="label">Sq Ft</span>
            </div>
        </div>
    <?php endif; ?>
</section>