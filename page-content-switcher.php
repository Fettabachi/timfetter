<?php

/**
 * Template Name: Content Switcher Portfolio
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-portfolio-piece fu-content-switcher-portfolio'); ?>>
    <div class="container">
        <div class="entry-content">

            <section id="content-switcher-overview" class="fu-portfolio-piece__lead">
                <div class="fu-portfolio-piece__lead-inner">
                    <div class="fu-portfolio-piece__lead-copy">
                        <p class="fu-case-section__eyebrow">WordPress / ACF Block</p>
                        <h1 class="fu-portfolio-piece__lead-heading"><?php the_title(); ?></h1>

                        <div class="fu-portfolio-piece__lead-body">
                            <p>
                                This is not just a tabs block. It's a structured content system designed to help editors organize
                                complex page content into clearly scoped panels—with confidence that the layout, interaction, and
                                visual style will stay consistent across every use.
                            </p>

                            <p>
                                Editors choose the display style, control spacing and backgrounds, and manage panel content
                                independently—while the block enforces accessible interaction patterns and responsive behavior
                                without requiring any custom development.
                            </p>
                        </div>

                        <div class="fu-portfolio-piece__meta">
                            <div class="fu-portfolio-piece__meta-item">
                                <span class="fu-portfolio-piece__meta-label">Use Case</span>
                                <span class="fu-portfolio-piece__meta-value">Tabs, section switchers, audience-based content</span>
                            </div>

                            <div class="fu-portfolio-piece__meta-item">
                                <span class="fu-portfolio-piece__meta-label">Content Model</span>
                                <span class="fu-portfolio-piece__meta-value">Structured child panels with guided controls</span>
                            </div>

                            <div class="fu-portfolio-piece__meta-item">
                                <span class="fu-portfolio-piece__meta-label">Key Strength</span>
                                <span class="fu-portfolio-piece__meta-value">Structured panels with accessible interaction and reusable display styles</span>
                            </div>
                        </div>
                    </div>
                    <div class="fu-portfolio-piece__lead-media">
                        <figure class="fu-portfolio-piece__lead-figure">
                            <img
                                src="/wp-content/uploads/2026/05/content-switcher-page-hero.jpg"
                                alt="Content Switcher block process collage showing planning, editor controls, and front-end interaction.">
                        </figure>
                        <p class="fu-portfolio-piece__lead-caption">
                            A reusable content system—not just a tabs block—designed to handle structured information
                            at the component level while keeping editing predictable.
                        </p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="overview">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Overview</p>
                    <h2 class="fu-case-section__heading">The Problem with Content-Heavy Pages</h2>

                    <div class="fu-case-section__body">
                        <p>
                            Pages that cover a lot of ground tend to become long, repetitive, or hard to scan. Editors end up
                            stacking sections that cover similar topics, and visitors have to scroll through content that doesn't
                            apply to them.
                        </p>

                        <p>
                            Structured switcher panels offer a better model: group related content into clearly labeled sections,
                            let visitors navigate directly to what they need, and give editors a consistent publishing pattern
                            instead of rebuilding layouts from scratch each time.
                        </p>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__demo-panel" id="live-demo">
                <div class="fu-portfolio-piece__demo-panel-inner">
                    <p class="fu-case-section__eyebrow">Live Component Preview</p>

                    <p class="fu-portfolio-piece__demo-caption">
                        <strong>Try it:</strong> Click the settings button to explore curated front-end controls for display
                        style, backgrounds, radius, and panel height. These controls mirror a small subset of the options
                        available to editors inside WordPress.
                    </p>

                    <p class="fu-portfolio-piece__demo-caption">
                        Switch between panels to see how each section can manage its own layout, media, highlights, and
                        buttons while staying inside the same reusable component.
                    </p>

                    <div class="fu-content-switcher-demo-shell" data-fu-content-switcher-demo-target>
                        <button
                            type="button"
                            class="fu-content-switcher-config-toggle"
                            data-fu-content-switcher-demo-toggle
                            aria-label="Content Switcher Controls"
                            title="Content Switcher Controls"
                            aria-controls="fuContentSwitcherDemoPanel"
                            aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 24px; height: 24px">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <?php the_content(); ?>
                    </div>
                </div>
            </section>

            <?php get_template_part('parts/demo-panel-content-switcher'); ?>

            <section class="fu-principles" id="design-principles">
                <div class="fu-principles__inner">
                    <p class="fu-principles__eyebrow">Design Principles</p>

                    <p class="fu-content-switcher-portfolio__principles-intro">
                        Each decision in this block was made to reduce the gap between what an editor can do and what the front end
                        actually needs to support.
                    </p>

                    <div class="fu-principles__grid">
                        <div class="fu-principles__item">
                            <h3>Controlled Flexibility</h3>
                            <p>
                                The block exposes display style, spacing, border radius, and nav behavior as discrete options—not
                                open-ended fields. Editors get meaningful variation without the risk of breaking the layout.
                            </p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Editor-First Structure</h3>
                            <p>
                                Panels are structured content items, not freeform containers. Each one has a defined set of fields:
                                label, icon, media, content, highlights, and buttons. That structure makes editing faster and
                                publishing more consistent.
                            </p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Accessible by Default</h3>
                            <p>
                                Tab and tabpanel semantics, keyboard navigation, and mobile accordion fallback are built into the
                                component—not added as an afterthought. The interaction model works correctly whether or not
                                JavaScript has loaded.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="editor-experience">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Editor Experience</p>
                    <h2 class="fu-case-section__heading">Two Distinct Roles, One Consistent Component</h2>

                    <div class="fu-case-section__body">
                        <p>
                            The parent block owns the switcher-level configuration: display style, nav behavior, spacing,
                            backgrounds, border radius, and shared visual settings. These apply across all panels and define
                            how the component looks and behaves as a unit.
                        </p>

                        <p>
                            Each child panel controls its own content independently: label, icon, panel media, body content,
                            highlight items, call-to-action buttons, and a deep link anchor. That separation makes it easy to
                            update or reorder panels without affecting the overall structure.
                        </p>

                        <p>
                            The editor also includes utility controls that only appear in the block editor—panel identification
                            labels and a one-click deep link copy tool—so editors can navigate and share specific panels without
                            any of those utilities appearing on the public front end.
                        </p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="implementation">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Implementation</p>
                    <h2 class="fu-case-section__heading">One Component, Multiple Display Modes, Accessible by Architecture</h2>

                    <div class="fu-case-section__body">
                        <p class="fu-content-switcher-portfolio__implementation-intro">
                            The block uses a parent/child ACF architecture so the switcher owns the configuration while each
                            panel manages its own content. The front end is built around accessible tab semantics, scoped
                            instance data, responsive fallbacks, and modifier-driven display variants instead of one-off templates.
                        </p>
                    </div>

                    <div class="fu-principles__grid fu-principles__grid--compact" aria-label="Implementation capabilities">
                        <div class="fu-principles__item fu-principles__item--compact">
                            <h3>Parent/Child ACF Architecture</h3>
                            <p>Parent settings control the switcher while each panel manages its own content.</p>
                        </div>

                        <div class="fu-principles__item fu-principles__item--compact">
                            <h3>Accessible Tab Semantics</h3>
                            <p>Server-rendered tab and tabpanel markup supports assistive technology.</p>
                        </div>

                        <div class="fu-principles__item fu-principles__item--compact">
                            <h3>Keyboard Navigation</h3>
                            <p>Arrow-key interaction follows the selected horizontal or vertical orientation.</p>
                        </div>

                        <div class="fu-principles__item fu-principles__item--compact">
                            <h3>Instance-Safe Deep Links</h3>
                            <p>Panel hashes are scoped so multiple switchers can coexist on one page.</p>
                        </div>

                        <div class="fu-principles__item fu-principles__item--compact">
                            <h3>Responsive Accordion Fallback</h3>
                            <p>Small screens use a mobile-friendly panel pattern without a separate block.</p>
                        </div>

                        <div class="fu-principles__item fu-principles__item--compact">
                            <h3>Scoped CSS Variables</h3>
                            <p>Display variants share one system instead of duplicated stylesheets.</p>
                        </div>

                        <div class="fu-principles__item fu-principles__item--compact">
                            <h3>Matched Panel Height</h3>
                            <p>Editors can reduce layout shift when panel content varies.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="outcome">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Outcome</p>
                    <h2 class="fu-case-section__heading">Less One-Off Work, More Consistent Publishing</h2>

                    <div class="fu-case-section__body">
                        <p>
                            Teams using this block spend less time building custom layout sections for structured content and more
                            time publishing. The same component handles service comparisons, audience-based messaging, feature
                            groups, and tabbed reference content without requiring a new block for each use case.
                        </p>

                        <p>
                            Accessibility is built in rather than retrofitted, so there's no additional QA burden when the block
                            is reused. Editorial control stays with the team—display style, panel content, and deep link behavior
                            are all managed within the block editor, with no theme customization required.
                        </p>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__closing">
                <div class="fu-portfolio-piece__closing-inner">
                    <p class="fu-case-section__eyebrow">Closing Thought</p>
                    <h2 class="fu-portfolio-piece__closing-heading">Need a structured content component that editors can actually use?</h2>
                    <p class="fu-portfolio-piece__closing-body">
                        I build WordPress blocks that solve real content problems — structured panels, accessible interactions, and editor controls that hold up in production.
                    </p>

                    <div class="fu-portfolio-piece__actions">
                        <a class="fu-portfolio-piece__button fu-portfolio-piece__button--primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Start a Conversation</a>
                        <a class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary" href="<?php echo esc_url(home_url('/portfolio/')); ?>">Back to Portfolio</a>
                    </div>
                </div>
            </section>

        </div>
    </div>
</article>

<?php
get_footer();
