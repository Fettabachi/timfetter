<?php

/**
 * ACF Block Development & Global Assets Loader
 */

// 1. Load shared compiled editor styles
function fu_add_editor_shared_styles()
{
    add_editor_style('build/style-index.css');
}
add_action('after_setup_theme', 'fu_add_editor_shared_styles');

// 2. Load Editor-Specific Assets (GLOBAL ONLY)
add_action('enqueue_block_editor_assets', function () {
    // Only put things here that EVERY block needs in the admin
    // e.g., a global editor-tweaks.js
});

// 3. Register all the ACF Blocks automatically
add_action('init', 'fu_register_acf_blocks');
function fu_register_acf_blocks()
{
    $blocks_path = get_template_directory() . '/blocks/';
    $blocks = glob($blocks_path . '*/block.json');

    foreach ($blocks as $block_json) {
        // A. Register the block
        register_block_type($block_json);

        // B. Look for an optional init.php in the same folder
        $block_dir = dirname($block_json);
        $init_file = $block_dir . '/init.php';

        if (file_exists($init_file)) {
            require_once $init_file;
        }
    }
}

// 4. ACF JSON Synchronization (Save/Load)
add_filter('acf/settings/save_json', 'fu_acf_json_save_point');
function fu_acf_json_save_point($path)
{
    return get_template_directory() . '/acf-json';
}

add_filter('acf/settings/load_json', 'fu_acf_json_load_point');
function fu_acf_json_load_point($paths)
{
    unset($paths[0]);
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
}
