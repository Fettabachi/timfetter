<?php

/**
 * Property Stats - Block Specific Logic
 */

// Example: Restrict this block to only the Property Post Type
// This keeps your block inserter clean!
add_filter('allowed_block_types_all', function ($allowed_blocks, $editor_context) {
    if ($editor_context->post->post_type !== 'fu_property') {
        // You could remove the block here if you wanted to be strict
        // but for a portfolio, it's better to let it be seen everywhere.
    }
    return $allowed_blocks;
}, 10, 2);

// Add your custom color swatches for Property Status here if needed
if (!function_exists('fu_property_status_swatches')) {
    add_action('acf/input/admin_head', 'fu_property_status_swatches');
    function fu_property_status_swatches()
    {
?>
        <style>
            /* Custom CSS for Property Status selection (e.g. Green for Available) */
            .acf-field[data-name="property_status"] label:has(input[value="available"])::before {
                background-color: #2ecc71;
            }

            .acf-field[data-name="property_status"] label:has(input[value="sold"])::before {
                background-color: #e74c3c;
            }
        </style>
<?php
    }
}
