<?php


// A. Manual Script Loading for the Video Iframe Bridge
add_action('enqueue_block_editor_assets', function () {
    $script_rel_path = '/blocks/page-banner/page-banner.js';
    $script_path = get_template_directory() . $script_rel_path;
    $script_uri  = get_template_directory_uri() . $script_rel_path;

    if (file_exists($script_path)) {
        wp_enqueue_script(
            'fu-page-banner-editor-js',
            $script_uri,
            array('acf-blocks', 'wp-element', 'wp-dom-ready'),
            filemtime($script_path),
            true
        );
    }
});

/**
 * Block-specific Logic & Hooks
 */

if (! function_exists('fu_acf_color_previews')) {
    add_action('acf/input/admin_head', 'fu_acf_color_previews');
    function fu_acf_color_previews()
    {
?>
        <style type="text/css">
            .btn {
                padding: 0.6rem 1.25rem;
                background-color: #007cba;
                color: #ffffff;
                font-size: 0.75rem;
                cursor: pointer;
                overflow: hidden;
                border: none;
                outline: none;
                display: inline-block;
                text-decoration: none;
                border-radius: 4px;
                transition: background-color 0.3s ease;
            }

            .btn br {
                display: none;
            }

            .btn:hover {
                background-color: crimson;
            }

            /* Layout for the swatch list */
            .acf-field[data-name="btn_color"] ul.acf-radio-list li,
            .acf-field[data-name="banner_overlay_brand_color"] ul.acf-radio-list li {
                margin-bottom: 8px;
            }

            .acf-field[data-name="btn_color"] ul.acf-radio-list li label,
            .acf-field[data-name="banner_overlay_brand_color"] ul.acf-radio-list li label {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                cursor: pointer;
                font-weight: 500;
            }

            /* The circle swatch */
            .acf-field[data-name="btn_color"] ul.acf-radio-list li label::before,
            .acf-field[data-name="banner_overlay_brand_color"] ul.acf-radio-list li label::before {
                content: '';
                display: inline-block;
                width: 18px;
                height: 18px;
                border-radius: 50%;
                border: 1px solid rgba(0, 0, 0, 0.1);
                box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
                flex-shrink: 0;
                transition: transform 0.1s ease-in-out;
            }

            /* Color Mapping */
            label:has(input[value="orange"])::before,
            label:has(input[id*="f95738"])::before {
                background-color: #f95738;
            }

            label:has(input[id*="000000"])::before {
                background-color: #000000;
            }

            label:has(input[value="blue"])::before,
            label:has(input[id*="0d3b66"])::before {
                background-color: #0d3b66;
            }

            label:has(input[value="dark-yellow"])::before,
            label:has(input[id*="f4d35e"])::before {
                background-color: #f4d35e;
            }

            /* Highlight the selected circle */
            label.selected::before {
                outline: 2px solid #2271b1;
                outline-offset: 2px;
            }

            /* Hide the actual radio input */
            .acf-field[data-name="btn_color"] ul.acf-radio-list li input[type="radio"],
            .acf-field[data-name="banner_overlay_brand_color"] ul.acf-radio-list li input[type="radio"] {
                position: absolute;
                opacity: 0;
                width: 0;
                height: 0;
                margin: 0;
            }

            label:hover::before {
                transform: scale(1.1);
            }
        </style>
<?php
    }
}
