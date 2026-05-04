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
                                src="<?php echo esc_url(get_template_directory_uri() . '/images/portfolio/content-switcher-collage.jpg'); ?>"
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
                    <p class="fu-case-section__eyebrow">Live Demo</p>

                    <p class="fu-portfolio-piece__demo-caption">
                        The live block below is the same component used in production. Notice the display style (tabs, pills,
                        minimal, or vertical), the mobile accordion fallback, and the panel-level deep link behavior. Each
                        panel's layout, media, and content are controlled independently from within the editor.
                    </p>

                    <?php the_content(); ?>
                </div>
            </section>

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
                        <p>
                            The block uses a parent/child ACF architecture: the parent block registers the switcher and its
                            configuration, and each inner panel block registers its own content independently. This keeps the
                            data model clean and the editor controls focused.
                        </p>

                        <p>
                            Accessible tab and tabpanel semantics are rendered server-side, with keyboard navigation handled
                            in JavaScript. On mobile, the component falls back to an accordion pattern without requiring a
                            separate block or template.
                        </p>

                        <p>
                            Deep links are scoped per switcher instance, so multiple switchers on the same page don't collide.
                            Presentation variants—tabs, pills, minimal, vertical—are driven by modifier classes and scoped CSS
                            variables rather than duplicated stylesheets.
                        </p>
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
                        I build WordPress blocks that solve real content problems—structured panels, accessible interaction,
                        and editorial controls that hold up in production.
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
