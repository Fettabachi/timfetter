<?php

/**
 * Template Name: Comparison Cards Portfolio
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();

$resolve_portfolio_page_url = static function ($slug) {
    $page = get_page_by_path($slug);

    return $page ? get_permalink($page) : '';
};

$editor_experience_url = $resolve_portfolio_page_url('editor-experience');

if ($editor_experience_url === '') {
    $editor_experience_url = home_url('/editor-experience/');
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-portfolio-piece fu-portfolio-piece--hero-media fu-comparison-cards-portfolio'); ?>>
    <div class="entry-content">

        <section class="fu-portfolio-piece__lead">
            <div class="container">
                <div class="fu-portfolio-piece__lead-inner">
                    <div class="fu-portfolio-piece__lead-copy">
                        <p class="fu-eyebrow">Reusable WordPress Section</p>
                        <h1 class="fu-portfolio-piece__lead-heading"><?php the_title(); ?></h1>
                        <div class="fu-portfolio-piece__lead-body">
                            <p>When visitors need to compare options, the content has to stay clear, consistent, and easy to update. Comparison Cards gives editors a reusable way to manage plans, services, packages, or product options without rebuilding the layout every time.</p>
                            <ul class="fu-portfolio-piece__lead-points">
                                <li>One editable card per option instead of dense repeater fields</li>
                                <li>Optional pricing and feature states without rigid table markup</li>
                                <li>Responsive comparison layouts that stay readable on small screens</li>
                            </ul>
                        </div>
                    </div>
                    <div class="fu-portfolio-piece__lead-media">
                        <figure class="fu-portfolio-piece__lead-figure">
                            <img
                                src="/wp-content/uploads/2026/05/page-comparison-cards-hero.webp"
                                alt="Comparison Cards ACF block planning, code, and editor preview">
                        </figure>
                        <p class="fu-portfolio-piece__lead-caption">
                            A parent/child block system—built for the canvas, not for nested repeaters—designed to keep comparison content natural to edit while staying visually consistent.
                        </p>
                    </div>

                    <div class="fu-portfolio-piece__meta fu-portfolio-piece__meta--hero-row">
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Use Case</span>
                            <span class="fu-portfolio-piece__meta-value">Pricing, membership tiers, plan comparisons</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Content Model</span>
                            <span class="fu-portfolio-piece__meta-value">Parent/child block architecture</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Key Strength</span>
                            <span class="fu-portfolio-piece__meta-value">Canvas editing, no dense repeaters</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">The Problem</p>
                <h2 class="fu-case-section__heading fu-section-heading">Comparison Content Is Common, But Editing It Shouldn't Be Difficult</h2>
                <div class="fu-case-section__body fu-section-body">
                    <p>Comparison content is everywhere on client sites—pricing tables, membership tiers, service packages, product options. But building it often means asking editors to work inside dense repeater fields, nested tables, or overly rigid pricing layouts that feel disconnected from the actual page content.</p>

                    <p>A comparison block needs to be structured enough to stay consistent while still feeling natural for editors to update and expand.</p>
                </div>
            </div>
        </section>

        <section class="fu-portfolio-piece__demo-panel" id="live-demo">
            <div class="fu-portfolio-piece__demo-panel-inner container">
                <p class="fu-eyebrow">Live Component Preview</p>

                <p class="fu-portfolio-piece__demo-caption">
                    <strong>Try it:</strong> Click the settings button to preview layout, card style,
                    and background variants. These controls mirror a curated subset of the
                    options available to editors inside WordPress.
                </p>

                <div class="fu-content-switcher-demo-shell fu-comparison-cards-demo-shell" data-fu-comparison-cards-demo-target>
                    <button
                        type="button"
                        class="fu-content-switcher-config-toggle fu-comparison-cards-config-toggle"
                        data-fu-comparison-cards-demo-toggle
                        aria-label="Open Comparison Cards demo controls"
                        title="Open Comparison Cards demo controls"
                        aria-controls="fuComparisonCardsDemoPanel"
                        aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 24px; height: 24px">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <div class="fu-comparison-cards-portfolio__demo-stage">
                        <?php the_content(); ?>
                    </div>
                </div>
                <p class="fu-portfolio-piece__demo-caption">Live example: A membership program comparison using Community, Coaching, and Premium Support tiers.</p>
            </div>
        </section>

        <?php get_template_part('parts/demo-panel-comparison-cards'); ?>

        <section class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">The Approach</p>
                <h2 class="fu-case-section__heading fu-section-heading">One Layout. Independent Content.</h2>
                <div class="fu-case-section__body fu-section-body">
                    <p>The block keeps shared presentation in one place while each comparison option stays easy to manage on its own:</p>

                    <ul class="fu-case-section__list">
                        <li><strong>The parent block</strong> owns the section heading, intro text, layout choice, card style, and background styling.</li>
                        <li><strong>Each child card block</strong> manages its own plan or package name, description, pricing, CTA, and feature list.</li>
                        <li><strong>Editors add, reorder, and duplicate cards</strong> directly in the block canvas.</li>
                        <li><strong>Pricing is optional</strong>, so the block works for more than traditional pricing tables—it can compare anything.</li>
                        <li><strong>Feature groups are semantic</strong>: included, limited, not included, and highlighted—not color-coded.</li>
                        <li><strong>Feature content is rich</strong>, allowing lists, descriptions, and context instead of one-line-only text.</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Editor Experience</p>
                <h2 class="fu-case-section__heading fu-section-heading">Designed for the Block Canvas, Not a Settings Panel</h2>
                <div class="fu-case-section__body fu-section-body">
                    <p>Editors work with the comparison directly in the block canvas instead of digging through a crowded settings interface. This keeps the editing surface focused and natural.</p>

                    <ul class="fu-case-section__list">
                        <li><strong>No nested repeaters</strong>—cards are visible as blocks, not hidden in a field stack.</li>
                        <li><strong>Canvas-based controls</strong>—section and card options are accessible without leaving the editor.</li>
                        <li><strong>Guided card fields</strong>—each card has a clear place for its title, description, pricing, and feature list.</li>
                        <li><strong>Editor/frontend parity</strong>—what editors see in the canvas matches what visitors see on the front end.</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Accessible Design</p>
                <h2 class="fu-case-section__heading fu-section-heading">Feature States That Work Without Color Alone</h2>
                <div class="fu-case-section__body fu-section-body">
                    <p>Comparison cards often rely on color to communicate feature inclusion or limitations. This block uses semantic structure and multiple cues:</p>

                    <ul class="fu-case-section__list">
                        <li><strong>Labeled feature groups</strong>—each state (included, limited, not included, highlighted) has a visible text label and icon.</li>
                        <li><strong>Strikethrough for not-included</strong>—text-decoration adds a non-color cue for items that are not part of the plan.</li>
                        <li><strong>Bold for highlighted items</strong>—emphasis that works across all contexts.</li>
                        <li><strong>Focus-visible outlines</strong>—keyboard users see clear focus states on all interactive elements.</li>
                        <li><strong>Contrast-conscious color choices</strong>—theme variants and featured states are designed with WCAG contrast targets in mind.</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Technical Highlights</p>
                <h2 class="fu-case-section__heading fu-section-heading">Built to Stay Reliable Over Time</h2>
                <div class="fu-case-section__body fu-section-body">
                    <ul class="fu-case-section__list">
                        <li><strong>Native block management</strong>—editors can add, duplicate, and reorder cards using familiar WordPress controls.</li>
                        <li><strong>Responsive CSS Grid</strong>—cards move from one to three columns with intentional breakpoints.</li>
                        <li><strong>No JavaScript required</strong>—layout and card presentation rely on CSS and semantic markup.</li>
                        <li><strong>Matched editor output</strong>—Gutenberg wrapper styles are handled so the canvas stays close to the front end.</li>
                        <li><strong>Flexible pricing fields</strong>—prefix, value, suffix, and note fields work independently.</li>
                        <li><strong>Filtered feature content</strong>—rich feature copy still renders through WordPress content filters.</li>
                        <li><strong>Design-token theming</strong>—CSS custom properties keep visual variants portable and easier to rebrand.</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Outcome</p>
                <h2 class="fu-case-section__heading fu-section-heading">A Reusable Comparison System That Works Across Contexts</h2>
                <div class="fu-case-section__body fu-section-body">
                    <p>The result is a comparison block that feels polished on the front end and manageable in the editor. It works for memberships, service tiers, packages, programs, or product options—without locking the client into a rigid pricing-table model.</p>

                    <p>Editors can add, reorder, or update options without asking for a new layout each time. That keeps comparison content easier to maintain as offers change.</p>
                </div>
            </div>
        </section>

        <?php
        get_template_part(
            'parts/editor-handoff-callout',
            null,
            array(
                'url' => $editor_experience_url,
            )
        );
        ?>

        <?php
        get_template_part(
            'parts/block-navigation',
            null,
            array(
                'current' => 'comparison-cards',
            )
        );
        ?>

        <section class="fu-portfolio-piece__closing">
            <div class="container container--page">
                <div class="fu-cta-panel--dark fu-portfolio-piece__closing-inner fu-cta-panel">
                    <p class="fu-eyebrow">Closing Thought</p>
                    <h2 class="fu-portfolio-piece__closing-heading">Need WordPress components your clients can actually maintain?</h2>
                    <p class="fu-portfolio-piece__closing-body">I help agencies build dependable WordPress sections with thoughtful front-end implementation, guided editor controls, and clean handoff.</p>

                    <div class="fu-portfolio-piece__actions fu-cta-panel__actions">
                        <a class="fu-portfolio-piece__button fu-portfolio-piece__button--primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Start a Conversation</a>
                        <a class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary" href="<?php echo esc_url(home_url('/work/')); ?>">Back to Work</a>
                    </div>
                </div>
            </div>
        </section>

    </div>
</article>

<?php
get_footer();
