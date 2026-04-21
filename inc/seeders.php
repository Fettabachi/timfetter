<?php

/**
 * One-time Seeder: Create 12 Lab Components
 */
function fu_seed_lab_components()
{
    if (get_option('fu_lab_seeded')) return;

    $components = [
        ['title' => 'Animated Hero Banner', 'cat' => 'Layout'],
        ['title' => 'Sticky Property Stats Bar', 'cat' => 'UI'],
        ['title' => 'ACF Color Swatch Logic', 'cat' => 'Utility'],
        ['title' => 'SVG Icon System', 'cat' => 'Utility'],
        ['title' => 'Recipe Card (Schema.org)', 'cat' => 'Data'],
        ['title' => 'Custom Mobile Navigation', 'cat' => 'Navigation'],
        ['title' => 'Dynamic Filter Gallery', 'cat' => 'UI'],
        ['title' => 'Video Background Logic', 'cat' => 'Layout'],
        ['title' => 'ACF Repeater Accordion', 'cat' => 'UI'],
        ['title' => 'Portfolio Grid (Isotope)', 'cat' => 'Layout'],
        ['title' => 'Dark Mode Toggle', 'cat' => 'Utility'],
        ['title' => 'Contact Form 7 Stylizer', 'cat' => 'Utility'],
    ];

    foreach ($components as $comp) {
        $post_id = wp_insert_post(array(
            'post_title'   => $comp['title'],
            'post_status'  => 'publish',
            'post_type'    => 'fu_lab',
            'post_content' => 'Placeholder for ' . $comp['title'] . ' technical breakdown.',
        ));

        if ($post_id) {
            wp_set_object_terms($post_id, $comp['cat'], 'lab_category');
        }
    }

    update_option('fu_lab_seeded', true);
}
// add_action('admin_init', 'fu_seed_lab_components');

/**
 * One-time Seeder: Create 15 Resources
 */
if (! function_exists('fu_seed_resources')) {
    function fu_seed_resources()
    {
        if (! is_admin() || ! current_user_can('manage_options')) {
            return;
        }

        if (get_option('fu_resources_seeded')) {
            return;
        }

        $resources = [
            ['title' => 'Homepage Content Planning Guide', 'cat' => 'Guides', 'excerpt' => 'A practical framework for organizing homepage messaging, sections, and calls to action before design begins.'],
            ['title' => 'Small Business Website Launch Guide', 'cat' => 'Guides', 'excerpt' => 'A step-by-step guide for preparing content, QA, and launch tasks for a new marketing site.'],
            ['title' => 'Accessibility Review Starter Guide', 'cat' => 'Guides', 'excerpt' => 'An introduction to checking headings, contrast, focus states, and form behavior before launch.'],

            ['title' => 'Service Page Copy Template', 'cat' => 'Templates', 'excerpt' => 'A reusable content outline for building clearer, conversion-focused service pages.'],
            ['title' => 'Project Kickoff Questionnaire Template', 'cat' => 'Templates', 'excerpt' => 'A structured intake template for gathering goals, audiences, features, and content requirements.'],
            ['title' => 'Landing Page Wireframe Template', 'cat' => 'Templates', 'excerpt' => 'A simple page-planning template for structuring headline, proof, benefits, and CTA sections.'],

            ['title' => 'SVG Icon Workflow Reference', 'cat' => 'Tools', 'excerpt' => 'A reference for organizing, optimizing, and reusing SVG icons across a website build.'],
            ['title' => 'Image Optimization Toolkit', 'cat' => 'Tools', 'excerpt' => 'A summary of practical image sizing, compression, and format decisions for better performance.'],
            ['title' => 'Content QA Helper Toolkit', 'cat' => 'Tools', 'excerpt' => 'A collection of common checks for links, spacing, headings, forms, and responsive issues.'],

            ['title' => 'How to Structure a Reusable CTA Section', 'cat' => 'Tutorials', 'excerpt' => 'A walkthrough of building a flexible CTA layout that can be reused across multiple pages.'],
            ['title' => 'How to Plan a Better Resource Library', 'cat' => 'Tutorials', 'excerpt' => 'A tutorial on grouping content into useful categories so visitors can find items faster.'],
            ['title' => 'How to Improve Form UX on Service Sites', 'cat' => 'Tutorials', 'excerpt' => 'A guide to reducing friction in contact and lead-generation forms with clearer labels and layout.'],

            ['title' => 'Pre-Launch Website QA Checklist', 'cat' => 'Checklists', 'excerpt' => 'A checklist covering links, forms, mobile layout, SEO basics, and accessibility review.'],
            ['title' => 'Content Entry Checklist for Editors', 'cat' => 'Checklists', 'excerpt' => 'A quick list editors can use when publishing new resources, pages, or case studies.'],
            ['title' => 'Page Speed Improvement Checklist', 'cat' => 'Checklists', 'excerpt' => 'A checklist for images, scripts, fonts, layout stability, and basic front-end performance wins.'],
        ];

        foreach ($resources as $resource) {
            $existing = get_page_by_title($resource['title'], OBJECT, 'resource');

            if ($existing) {
                continue;
            }

            $post_id = wp_insert_post(
                [
                    'post_title'   => $resource['title'],
                    'post_status'  => 'publish',
                    'post_type'    => 'resource',
                    'post_content' => fu_generate_resource_content($resource['title'], $resource['cat']),
                    'post_excerpt' => $resource['excerpt'],
                ]
            );

            if ($post_id && ! is_wp_error($post_id)) {
                wp_set_object_terms($post_id, $resource['cat'], 'resource_category');
            }
        }

        update_option('fu_resources_seeded', true);
    }
}
// add_action('admin_init', 'fu_seed_resources');

if (! function_exists('fu_generate_resource_content')) {
    function fu_generate_resource_content($title, $category)
    {
        $category_openers = [
            'Guides' => "This guide is designed to help teams approach {$title} in a more structured and practical way.",
            'Templates' => "This template is intended to make {$title} easier to plan, organize, and reuse across a project.",
            'Tools' => "This resource supports {$title} by giving teams a clearer reference point during implementation.",
            'Tutorials' => "This tutorial breaks down {$title} into a process that is easier to apply in real project work.",
            'Checklists' => "This checklist helps teams use {$title} more consistently by focusing on the most important steps.",
        ];

        $open = $category_openers[$category] ?? "This resource is designed to support {$title} in a more structured and reliable way.";

        $paragraph_1 = $open . " It focuses on practical decisions that improve consistency and reduce unnecessary rework.";
        $paragraph_2 = "It works best when used early in planning or implementation, especially when teams need clearer structure, better content hierarchy, or a more predictable publishing workflow.";

        $list_by_category = [
            'Guides' => [
                'Clarifying structure before layout decisions',
                'Improving consistency across content',
                'Reducing avoidable revision cycles',
            ],
            'Templates' => [
                'Establishing a repeatable starting point',
                'Speeding up content planning',
                'Keeping formatting more consistent',
            ],
            'Tools' => [
                'Supporting implementation decisions',
                'Improving team reference materials',
                'Reducing small process inefficiencies',
            ],
            'Tutorials' => [
                'Breaking work into repeatable steps',
                'Helping editors or developers get started faster',
                'Making complex tasks easier to follow',
            ],
            'Checklists' => [
                'Reducing missed steps',
                'Improving review consistency',
                'Supporting cleaner handoff and QA',
            ],
        ];

        $list_items = $list_by_category[$category] ?? [
            'Clarifying structure before layout decisions',
            'Reducing avoidable revisions',
            'Keeping content more consistent',
        ];

        $content  = '<p>' . esc_html($paragraph_1) . '</p>';
        $content .= '<p>' . esc_html($paragraph_2) . '</p>';
        $content .= '<h2>What this helps with</h2>';
        $content .= '<ul>';

        foreach ($list_items as $item) {
            $content .= '<li>' . esc_html($item) . '</li>';
        }

        $content .= '</ul>';

        return $content;
    }
}

if (! function_exists('fu_fill_resource_content_once')) {
    function fu_fill_resource_content_once()
    {
        if (! is_admin() || ! current_user_can('manage_options')) {
            return;
        }

        if (empty($_GET['fu_fill_resource_content'])) {
            return;
        }

        $resources = get_posts(
            [
                'post_type'      => 'resource',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            ]
        );

        foreach ($resources as $resource) {
            $terms    = get_the_terms($resource->ID, 'resource_category');
            $category = ($terms && ! is_wp_error($terms)) ? $terms[0]->name : '';

            wp_update_post(
                [
                    'ID'           => $resource->ID,
                    'post_content' => fu_generate_resource_content($resource->post_title, $category),
                ]
            );
        }

        update_option('fu_resources_content_filled', true);

        wp_die('Resource content fill completed.');
    }
}
// add_action('admin_init', 'fu_fill_resource_content_once');
