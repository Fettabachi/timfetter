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

            <section class="fu-portfolio-piece__lead">
                <div class="fu-portfolio-piece__lead-inner">
                    <div class="fu-portfolio-piece__lead-copy">
                        <p class="fu-case-section__eyebrow">WordPress / ACF Block</p>
                        <h1 class="fu-portfolio-piece__lead-heading"><?php the_title(); ?></h1>

                        <div class="fu-portfolio-piece__lead-body">
                            <p>
                                A structured content-switching block built to help editors organize dense information into clear,
                                accessible sections while giving developers predictable markup, reusable patterns, and flexible
                                presentation modes.
                            </p>

                            <p>
                                The same component can work as tabs, a section switcher, or a mobile accordion fallback—making it
                                useful for service comparisons, audience-based content, feature groups, and other structured page layouts.
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
                                <span class="fu-portfolio-piece__meta-value">Accessible interaction with editor parity</span>
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
                            A reusable switcher component designed to organize complex content without overwhelming
                            editors or visitors.
                        </p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="overview">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Overview</p>
                    <h2 class="fu-case-section__heading">Organize Dense Content Without Making Pages Feel Heavy</h2>

                    <div class="fu-case-section__body">
                        <p>
                            Content tabs and section switchers are a common need, but many implementations are either too rigid
                            for editors or too shallow to support meaningful content. This block was designed to strike a better balance.
                        </p>

                        <p>
                            Each panel is treated as a structured content item, making it easier to organize grouped information
                            while keeping layout, interaction, and styling consistent across the site.
                        </p>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__demo-panel" id="live-demo">
                <div class="fu-portfolio-piece__demo-panel-inner">
                    <p class="fu-case-section__eyebrow">Live Demo</p>

                    <p class="fu-portfolio-piece__demo-caption">
                        This example shows the same component organizing structured content into switchable panels, with support
                        for multiple presentation styles, mobile fallbacks, and deep linking between sections.
                    </p>

                    <?php the_content(); ?>
                </div>
            </section>

            <section class="fu-principles" id="design-principles">
                <div class="fu-principles__inner">
                    <p class="fu-principles__eyebrow">Design Principles Behind This Block</p>

                    <p class="fu-content-switcher-portfolio__principles-intro">
                        Flexible where it matters, consistent where it counts. This block gives editors meaningful control while
                        keeping layout, styling, and interaction predictable across the site.
                    </p>

                    <div class="fu-principles__grid">
                        <div class="fu-principles__item">
                            <h3>Controlled Flexibility</h3>
                            <p>
                                Editors can organize content into distinct panels without breaking the layout. Options are intentionally
                                limited to maintain consistency across pages.
                            </p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Built-In Branding</h3>
                            <p>
                                Colors, spacing, and presentation modes are driven by predefined styles, allowing teams to match their
                                brand without custom development.
                            </p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Reusable by Design</h3>
                            <p>
                                The same component supports multiple use cases—from service comparisons to audience-specific messaging—
                                without rebuilding layouts from scratch.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="editor-experience">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Editor Experience</p>
                    <h2 class="fu-case-section__heading">Structured Panels, Clear Controls, Better Editorial Confidence</h2>

                    <div class="fu-case-section__body">
                        <p>
                            The editor experience is built around clear roles: the parent block controls layout, behavior, and styling,
                            while each child panel owns a specific set of structured content.
                        </p>

                        <p>
                            That makes the block easier to reason about, easier to maintain, and less likely to drift visually as content
                            changes over time.
                        </p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="implementation">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Implementation</p>
                    <h2 class="fu-case-section__heading">Accessible Interaction with Reusable Architecture</h2>

                    <div class="fu-case-section__body">
                        <p>
                            This block uses a parent/child ACF architecture, accessible switching behavior, and progressive enhancement
                            to support tabs, vertical switchers, and mobile accordion patterns from a single reusable system.
                        </p>

                        <p>
                            The result is a component that can organize complex information cleanly while still feeling polished,
                            performant, and manageable for editors.
                        </p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="outcome">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Outcome</p>
                    <h2 class="fu-case-section__heading">A Flexible Section Switcher for Real WordPress Content</h2>

                    <div class="fu-case-section__body">
                        <p>
                            This block makes it easier to present grouped or comparative content without forcing users to scroll through
                            long, repetitive sections.
                        </p>

                        <p>
                            It gives teams a more structured way to publish rich content while reducing one-off layout work and preserving
                            consistency across different kinds of pages.
                        </p>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__closing">
                <div class="fu-portfolio-piece__closing-inner">
                    <p class="fu-case-section__eyebrow">Closing Thought</p>
                    <h2 class="fu-portfolio-piece__closing-heading">Need a smarter way to organize complex content without overwhelming editors?</h2>
                    <p class="fu-portfolio-piece__closing-body">
                        I build WordPress components that balance structured content, accessible interaction, and real editorial workflows.
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
