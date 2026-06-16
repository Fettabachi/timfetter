<?php

/**
 * Portfolio Items archive template.
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();

$resolve_page_url = static function ($slug) {
    $page = get_page_by_path($slug);

    return $page ? get_permalink($page) : home_url('/' . trim($slug, '/') . '/');
};

$resolve_portfolio_item_url = static function ($slug) {
    $item = get_page_by_path($slug, OBJECT, 'portfolio-items');
    return $item ? get_permalink($item) : home_url('/work/' . trim($slug, '/') . '/');
};

$featured_systems = array(
    array(
        'title' => 'Editor-Friendly Sections',
        'slug' => 'acf-block-system',
        'summary' => 'A set of reusable WordPress sections built with ACF Blocks so pages can be updated without rebuilding layouts from scratch.',
        'image' => '/uploads/2026/05/page-block-system-hero-600x450.webp',
        'alt'   => 'Work example showing reusable WordPress block system overview and structured content.',
    ),
    array(
        'title' => 'Editor Experience & Handoff',
        'slug' => 'editor-experience',
        'summary' => 'How blocks are structured so editors can make real updates without breaking layout, accessibility, or the front end.',
        'image' => '/uploads/2026/06/page-editor-experience-handoff-hero.webp',
        'alt'   => 'Work example showing block editor experience and handoff with accessibility and layout controls.',
    ),
);

$acf_block_case_studies = array(
    array(
        'title' => 'Page Banner',
        'slug' => 'page-banner',
        'summary' => 'A flexible hero/header component with media controls, readability settings, and consistent responsive output.',
        'image' => '/uploads/2026/05/page-banner-hero-600x450.webp',
        'alt'   => 'Work example showing a flexible page banner with media and readability controls.',
    ),
    array(
        'title' => 'Flexible Feature Section',
        'slug' => 'flexible-feature-section',
        'summary' => 'A reusable content-and-media section designed to stay balanced with real-world copy and layouts.',
        'image' => '/uploads/2026/05/page-flexible-feature-hero-600x450.webp',
        'alt'   => 'Work example showing a flexible feature section with balanced content and media.',
    ),
    array(
        'title' => 'Filtered Content Grid',
        'slug' => 'filtered-content-grid',
        'summary' => 'A structured content system with instant filtering that stays stable on load and responsive in use.',
        'image' => '/uploads/2026/05/page-filtered-content-grid-hero-600x450.webp',
        'alt'   => 'Work example showing a filterable content grid with category and taxonomy controls.',
    ),
    array(
        'title' => 'Content Switcher',
        'slug' => 'content-switcher',
        'summary' => 'A parent/child block system for tabs, panels, and accessible switching with mobile fallback.',
        'image' => '/uploads/2026/05/page-switcher-hero-600x450.webp',
        'alt'   => 'Work example showing a content switcher block with tabs and accessible panel navigation.',
    ),
    array(
        'title' => 'Comparison Cards',
        'slug' => 'comparison-cards',
        'summary' => 'Structured comparison cards for plans, services, and options without relying on a dense repeater interface.',
        'image' => '/uploads/2026/05/page-comparison-cards-hero-600x450.webp',
        'alt'   => 'Work example showing comparison cards for plans, services, and product options.',
    ),
    array(
        'title' => 'Proof Cards',
        'slug' => 'proof-cards',
        'summary' => 'A social-proof system for outcomes, metrics, and credibility signals that still feels maintainable.',
        'image' => '/uploads/2026/05/page-proof-cards-hero-600x450.webp',
        'alt'   => 'Work example showing proof cards with testimonials, metrics, and credibility signals.',
    ),
);

$frontend_prototypes = array(
    array(
        'title' => 'Client Project Timeline',
        'slug' => 'client-project-timeline',
        'summary' => 'A configurable milestone tracker for testing workflow states, responsive timeline layouts, and handoff-ready UI behavior before production buildout.',
        'image' => content_url('/uploads/2026/05/client-project-timeline-cover.webp'),
        'alt' => 'Front-end UI example showing project milestones, timeline phases, and delivery status.',
        'eyebrow' => 'Front-End UI Example',
        'focus' => array('HTML', 'CSS', 'JavaScript', 'Responsive UI', 'Interaction Logic'),
        'cta' => 'View UI Example',
    ),
    array(
        'title' => 'Project Scope Estimator',
        'slug' => 'project-scope-estimator',
        'summary' => 'A guided interface that helps teams define project requirements, preview complexity, and generate a handoff-friendly summary before production planning.',
        'image' => content_url('/uploads/2026/05/client-project-scope-cover.webp'),
        'alt' => 'Front-end UI example showing project scope options, complexity indicators, and summary details.',
        'eyebrow' => 'Front-End UI Example',
        'focus' => array('HTML', 'CSS', 'JavaScript', 'Conditional UI', 'Form Logic'),
        'cta' => 'View UI Example',
    ),
    array(
        'title' => 'Content Approval Checklist',
        'slug' => 'content-approval-checklist',
        'summary' => 'A responsive checklist interface for tracking content readiness, review status, blockers, and launch approval across website production workflows.',
        'image' => content_url('/uploads/2026/06/client-project-content-approval-cover.webp'),
        'alt' => 'Front-end UI example showing content review tasks, approval status, and launch readiness.',
        'eyebrow' => 'Front-End UI Example',
        'focus' => array('HTML', 'CSS', 'JavaScript', 'Workflow UI', 'State Management'),
        'cta' => 'View UI Example',
    ),
);

$starting_examples = array(
    array(
        'title' => 'WordPress pages that are easier to update',
        'target' => '#reusable-wordpress-sections',
        'summary' => 'Reusable sections, editor-friendly controls, and handoff details for teams that need maintainable WordPress content.',
        'cta' => 'Scroll to WordPress sections ↓',
    ),
    array(
        'title' => 'Existing site support and implementation',
        'target' => '#contract-work',
        'summary' => 'Client work involving responsive polish, content updates, template cleanup, and production-ready front-end fixes.',
        'cta' => 'Scroll to selected client work ↓',
    ),
    array(
        'title' => 'Custom front-end UI examples',
        'target' => '#front-end-prototypes',
        'summary' => 'Interactive prototypes for workflows, planning tools, approval states, and interface logic before production buildout.',
        'cta' => 'Scroll to UI examples ↓',
    ),
);

// Prototype grouping and exclusion setup.
$prototype_slugs = array(
    'client-project-timeline',
    'project-scope-estimator',
    'content-approval-checklist',
);

$prototype_post_ids = array();

foreach ($prototype_slugs as $prototype_slug) {
    $prototype_post = get_page_by_path($prototype_slug, OBJECT, 'portfolio-items');

    if ($prototype_post && !empty($prototype_post->ID)) {
        $prototype_post_ids[] = (int) $prototype_post->ID;
    }
}

$get_portfolio_card_kicker = static function ($post_id) {
    $kicker_fields = array(
        'work_type',
        'portfolio_type',
        'card_kicker',
        'kicker',
        'website_sub_title',
    );

    foreach ($kicker_fields as $kicker_field_key) {
        $value = get_field($kicker_field_key, $post_id);

        if (is_string($value) && trim($value) !== '') {
            return trim($value);
        }
    }

    $portfolio_content = get_field('portfolio_content', $post_id);

    if (is_array($portfolio_content) && !empty($portfolio_content['website_sub_title']) && is_string($portfolio_content['website_sub_title'])) {
        return trim($portfolio_content['website_sub_title']);
    }

    $taxonomies = get_object_taxonomies(get_post_type($post_id));

    if (!empty($taxonomies)) {
        foreach ($taxonomies as $taxonomy) {
            $terms = get_the_terms($post_id, $taxonomy);
            if (is_array($terms) && !empty($terms[0]->name)) {
                return $terms[0]->name;
            }
        }
    }

    return '';
};

$get_portfolio_focus_labels = static function ($post_id) {
    $labels = array();

    $focus_fields = array(
        'focus_tags',
        'focus_areas',
        'skills',
    );

    foreach ($focus_fields as $focus_field_key) {
        $value = get_field($focus_field_key, $post_id);

        if (is_array($value)) {
            foreach ($value as $item) {
                if (is_array($item) && !empty($item['label'])) {
                    $labels[] = (string) $item['label'];
                } elseif (is_string($item) && trim($item) !== '') {
                    $labels[] = trim($item);
                }
            }
        } elseif (is_string($value) && trim($value) !== '') {
            $labels[] = trim($value);
        }
    }

    $portfolio_content = get_field('portfolio_content', $post_id);

    if (is_array($portfolio_content) && !empty($portfolio_content['skills']) && is_array($portfolio_content['skills'])) {
        foreach ($portfolio_content['skills'] as $skill_item) {
            if (is_array($skill_item) && !empty($skill_item['label'])) {
                $labels[] = (string) $skill_item['label'];
            } elseif (is_string($skill_item) && trim($skill_item) !== '') {
                $labels[] = trim($skill_item);
            }
        }
    }

    if (empty($labels)) {
        return array();
    }

    $labels = array_map('trim', $labels);
    $labels = array_filter($labels, static function ($item) {
        return $item !== '';
    });

    return array_values(array_unique($labels));
};
?>

<main id="primary" class="site-main">
    <section class="fu-content-section fu-work-archive" aria-labelledby="portfolio-archive-heading">
        <div class="fu-content-section__inner container container--page">
            <div class="fu-section-head">
                <h1 class="fu-section-heading" id="portfolio-archive-heading">Work</h1>
                <p class="fu-section-lede">A curated look at WordPress and front-end implementation work focused on reusable sections, responsive polish, editor-friendly workflows, and maintainable handoff.</p>
            </div>

            <section class="fu-section-body fu-work-archive__group fu-work-archive__group--start fu-work-archive__start" aria-labelledby="work-start-heading">
                <div class="fu-work-archive__start-inner">
                    <div class="fu-section-head fu-work-archive__start-head">
                        <p class="fu-eyebrow">Start Here</p>
                        <h2 class="fu-section-heading fu-section-heading--compact" id="work-start-heading">Find the examples closest to your project</h2>
                        <p class="fu-section-lede">Not every visitor needs to review the full portfolio. Use these starting points to jump to the work that best matches the kind of help you need.</p>
                    </div>

                    <nav class="fu-work-archive__start-grid" aria-label="Work section starting points">
                        <?php foreach ($starting_examples as $example) : ?>
                            <a class="fu-work-archive__start-card" href="<?php echo esc_url($example['target']); ?>">
                                <h3 class="fu-work-archive__start-card-title"><?php echo esc_html($example['title']); ?></h3>
                                <p class="fu-work-archive__start-card-text"><?php echo esc_html($example['summary']); ?></p>
                                <span class="fu-work-archive__start-card-link"><?php echo esc_html($example['cta']); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </section>

            <div id="reusable-wordpress-sections" class="fu-section-body fu-work-archive__group fu-work-archive__group--case-studies" aria-labelledby="reusable-wordpress-sections-heading">
                <div class="fu-section-head">
                    <h2 class="fu-section-heading fu-section-heading--compact" id="reusable-wordpress-sections-heading">Reusable WordPress Sections</h2>
                    <p class="fu-section-lede">Focused ACF block examples designed to solve common editing, layout, and content-management problems.</p>
                </div>

                <div class="fu-work-archive__acf-showcase">
                    <div class="fu-work-grid fu-work-grid--archive fu-wordpress-card-grid fu-work-archive__acf-grid" aria-label="Reusable WordPress section examples">
                        <?php foreach ($acf_block_case_studies as $case_study) : ?>
                            <?php $case_study_url = $resolve_page_url($case_study['slug']); ?>
                            <a class="fu-work-card fu-work-card--linked fu-work-card--wordpress" href="<?php echo esc_url($case_study_url); ?>">
                                <?php if (!empty($case_study['image'])) : ?>
                                    <div class="fu-work-card__media">
                                        <img
                                            src="<?php echo esc_url(content_url($case_study['image'])); ?>"
                                            alt="<?php echo esc_attr($case_study['alt'] ?? ''); ?>"
                                            loading="lazy"
                                            width="600"
                                            height="450">
                                    </div>
                                <?php endif; ?>

                                <div class="fu-work-card__body">
                                    <p class="fu-work-card__kicker">ACF block case study</p>
                                    <h3 class="fu-work-card__title"><?php echo esc_html($case_study['title']); ?></h3>
                                    <p class="fu-work-card__text"><?php echo esc_html($case_study['summary']); ?></p>
                                    <span class="fu-work-card__link">View case study</span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div id="wordpress-editing-handoff-examples" class="fu-section-body fu-work-archive__group fu-work-archive__group--featured" aria-labelledby="wordpress-editing-handoff-heading">
                <div class="fu-section-head">
                    <h2 class="fu-section-heading fu-section-heading--compact" id="wordpress-editing-handoff-heading">WordPress Editing &amp; Handoff Examples</h2>
                    <p class="fu-section-lede">A closer look at how reusable sections, editor controls, and handoff details help pages stay easier to maintain.</p>
                </div>

                <div class="fu-work-grid fu-work-grid--archive fu-wordpress-card-grid fu-wordpress-card-grid--featured fu-work-archive__grid--featured" aria-label="WordPress editing and handoff examples">
                    <?php foreach ($featured_systems as $system) : ?>
                        <?php $system_url = $resolve_page_url($system['slug']); ?>
                        <a class="fu-work-card fu-work-card--linked fu-work-card--wordpress" href="<?php echo esc_url($system_url); ?>">
                            <?php if (!empty($system['image'])) : ?>
                                <div class="fu-work-card__media">
                                    <img
                                        src="<?php echo esc_url(content_url($system['image'])); ?>"
                                        alt="<?php echo esc_attr($system['alt'] ?? ''); ?>"
                                        loading="lazy"
                                        width="600"
                                        height="450">
                                </div>
                            <?php endif; ?>

                            <div class="fu-work-card__body">
                                <p class="fu-work-card__kicker">Editor-friendly example</p>
                                <h3 class="fu-work-card__title"><?php echo esc_html($system['title']); ?></h3>
                                <p class="fu-work-card__text"><?php echo esc_html($system['summary']); ?></p>
                                <span class="fu-work-card__link">View case study</span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div id="contract-work" class="fu-section-body fu-work-archive__group fu-work-archive__group--earlier" aria-labelledby="selected-client-work-heading">
                <div class="fu-section-head">
                    <h2 class="fu-section-heading fu-section-heading--compact" id="selected-client-work-heading">Selected Client Work</h2>
                    <p class="fu-section-lede">Production projects where I supported existing teams with implementation, responsive polish, CMS updates, reusable templates, and steady front-end cleanup.</p>
                </div>

                <?php
                // Use explicit WP_Query to exclude prototype items from contract work
                $selected_contract_work_limit = 6;

                $contract_work_query = new WP_Query(array(
                    'post_type'      => 'portfolio-items',
                    'posts_per_page' => $selected_contract_work_limit,
                    'post__not_in'   => $prototype_post_ids,
                    'orderby'        => array(
                        'menu_order' => 'ASC',
                        'date'       => 'DESC',
                    ),
                ));
                ?>
                <?php if ($contract_work_query->have_posts()) : ?>
                    <div class="fu-work-grid fu-work-grid--archive" aria-label="Work case studies">
                        <?php while ($contract_work_query->have_posts()) : $contract_work_query->the_post(); ?>
                            <?php
                            $portfolio_card_link = get_permalink();
                            $portfolio_card_kicker = $get_portfolio_card_kicker(get_the_ID());
                            $portfolio_focus_labels = $get_portfolio_focus_labels(get_the_ID());
                            $portfolio_excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 26);
                            ?>

                            <a class="fu-work-card fu-work-card--linked" href="<?php echo esc_url($portfolio_card_link); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="fu-work-card__media">
                                        <?php
                                        $thumbnail_id = get_post_thumbnail_id();
                                        $alt          = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
                                        $fallback_alt = $alt ? $alt : get_the_title();

                                        the_post_thumbnail('medium_large', array(
                                            'loading'  => 'lazy',
                                            'decoding' => 'async',
                                            'alt'      => esc_attr($fallback_alt),
                                        ));
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <div class="fu-work-card__body">
                                    <?php if ($portfolio_card_kicker !== '') : ?>
                                        <p class="fu-work-card__kicker"><?php echo esc_html($portfolio_card_kicker); ?></p>
                                    <?php endif; ?>

                                    <h2 class="fu-work-card__title"><?php the_title(); ?></h2>

                                    <?php if ($portfolio_excerpt !== '') : ?>
                                        <p class="fu-work-card__text"><?php echo esc_html($portfolio_excerpt); ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($portfolio_focus_labels)) : ?>
                                        <p class="fu-work-card__text"><strong>Focus:</strong> <?php echo esc_html(implode(', ', array_slice($portfolio_focus_labels, 0, 4))); ?></p>
                                    <?php endif; ?>

                                    <span class="fu-work-card__link">View case study</span>
                                </div>
                            </a>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                <?php else : ?>
                    <div class="fu-prose">
                        <p>No earlier client work items are published yet. New projects will appear here soon.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="fu-section-body fu-work-archive__group fu-work-archive__group--prototypes" id="front-end-prototypes" aria-labelledby="frontend-prototypes-heading">
                <div class="fu-section-head">
                    <h2 class="fu-section-heading fu-section-heading--compact" id="frontend-prototypes-heading">Front-End UI Examples</h2>
                    <p class="fu-section-lede">HTML, CSS, and JavaScript examples that make workflows, states, interaction details, and handoff-ready UI thinking easier to review before production buildout.</p>
                </div>
                <div class="fu-work-grid fu-work-grid--archive fu-work-archive__prototype-list" aria-label="Front-End UI Examples">
                    <?php foreach ($frontend_prototypes as $prototype) : ?>
                        <?php $prototype_url = $resolve_portfolio_item_url($prototype['slug']); ?>
                        <a class="fu-work-card fu-work-card--linked fu-work-card--prototype" href="<?php echo esc_url($prototype_url); ?>">
                            <?php if (!empty($prototype['image'])) : ?>
                                <div class="fu-work-card__media">
                                    <img
                                        src="<?php echo esc_url($prototype['image']); ?>"
                                        alt="<?php echo esc_attr($prototype['alt'] ?? ''); ?>"
                                        loading="lazy"
                                        width="600"
                                        height="450">
                                </div>
                            <?php endif; ?>
                            <div class="fu-work-card__body">
                                <p class="fu-work-card__kicker"><?php echo esc_html($prototype['eyebrow']); ?></p>
                                <h3 class="fu-work-card__title"><?php echo esc_html($prototype['title']); ?></h3>
                                <p class="fu-work-card__text"><?php echo esc_html($prototype['summary']); ?></p>
                                <p class="fu-work-card__text"><strong>Focus:</strong> <?php echo esc_html(implode(', ', $prototype['focus'])); ?></p>
                                <span class="fu-work-card__link"><?php echo esc_html($prototype['cta']); ?></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </section>
</main>

<?php
get_footer();
