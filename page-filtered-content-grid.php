<?php

/**
 * Template Name: Filtered Content Grid Portfolio
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-portfolio-piece fu-portfolio-piece--hero-media'); ?>>
    <div class="entry-content">

        <section class="fu-portfolio-piece__lead">
            <div class="container">
                <div class="fu-portfolio-piece__lead-inner">
                    <div class="fu-portfolio-piece__lead-copy">
                        <p class="fu-eyebrow">Reusable WordPress Section</p>
                        <h1 class="fu-portfolio-piece__lead-heading"><?php the_title(); ?></h1>
                        <div class="fu-portfolio-piece__lead-body">
                            <p>Content libraries become less useful when visitors cannot quickly find what matters. This reusable WordPress section turns growing collections into a clear, filterable browsing experience without making content harder to manage.</p>
                            <ul class="fu-portfolio-piece__lead-points">
                                <li>Helps visitors narrow large content sets quickly</li>
                                <li>Keeps entries managed in WordPress instead of one-off layouts</li>
                                <li>Supports responsive browsing for resource libraries and similar collections</li>
                            </ul>
                        </div>
                    </div>

                    <div class="fu-portfolio-piece__lead-media">
                        <figure class="fu-portfolio-piece__lead-figure">
                            <img src="<?php echo esc_url(home_url('/wp-content/uploads/2026/05/page-filtered-content-grid-hero.webp')); ?>" alt="Planning, wireframing, and building process collage for the Filtered Content Grid project.">
                        </figure>
                        <p class="fu-portfolio-piece__lead-caption">Built as a focused WordPress content component: easier browsing for visitors, predictable management for editors.</p>
                    </div>

                    <div class="fu-portfolio-piece__meta fu-portfolio-piece__meta--hero-row">
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Use Case</span>
                            <span class="fu-portfolio-piece__meta-value">Resource Library</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Content Model</span>
                            <span class="fu-portfolio-piece__meta-value">WordPress content + categories</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Key Strength</span>
                            <span class="fu-portfolio-piece__meta-value">Fast content discovery</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Overview</p>
                <h2 class="fu-case-section__heading fu-section-heading">When Content Grows, Browsing Has to Stay Simple</h2>
                <div class="fu-case-section__body fu-section-body">
                    <p>As libraries expand, visitors need a faster way to get from a broad collection to the item that fits their need.</p>
                    <p>This section supports that search while keeping content manageable for editors. Entries stay structured in WordPress, and the front end gives users a clearer path through them.</p>
                </div>
            </div>
        </section>

        <section class="fu-portfolio-piece__demo-panel" id="live-demo">
            <div class="fu-portfolio-piece__demo-panel-inner container">
                <?php the_content(); ?>
                <p class="fu-portfolio-piece__demo-caption">This live example uses a Resource custom post type and taxonomy filters to update the grid instantly without reloading the page.</p>
            </div>
        </section>

        <section class="fu-principles">
            <div class="container container--page">
                <div class="fu-principles__inner">
                    <p class="fu-eyebrow">Design Principles Behind This Block</p>
                    <p class="fu-principles__lede">The goal is not just to add filters. The component needs to make content easier to find, safer to manage, and consistent as the library grows.</p>

                    <div class="fu-principles__grid">
                        <div class="fu-principles__item">
                            <h3>Start with structured content</h3>
                            <p>Filtering works best when the content model is clear, so categories reflect how people actually browse the library.</p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Keep interactions fast and predictable</h3>
                            <p>Visitors can explore without losing context, waiting through reloads, or backing out of archive pages.</p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Limit controls to what matters</h3>
                            <p>Editors get the controls they need without turning routine updates into layout decisions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Editor Experience</p>
                <h2 class="fu-case-section__heading fu-section-heading">Editors Don’t Need a Complex Settings Panel to Use This</h2>
                <div class="fu-case-section__body fu-section-body">
                    <p>The block focuses on a small set of meaningful controls: heading, intro text, CTA label, excerpt visibility, item count, and empty-state messaging.</p>

                    <p>Instead of exposing every possible option, the goal is to make common tasks easy and predictable. Editors can manage structured content normally, while the block handles how it’s presented.</p>
                </div>
            </div>
        </section>

        <section class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Implementation</p>
                <h2 class="fu-case-section__heading fu-section-heading">Reliable First Load, Faster Browsing Afterward</h2>
                <div class="fu-case-section__body fu-section-body">
                    <p>The grid loads with stable markup first, so content remains readable, accessible, and reliable before any enhanced interaction runs.</p>

                    <p>Filtering then updates the results in place, keeping the experience responsive while preserving a maintainable WordPress content structure.</p>
                </div>
            </div>
        </section>

        <section class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Outcome</p>
                <h2 class="fu-case-section__heading fu-section-heading">Reusable Across Real Content Systems</h2>
                <div class="fu-case-section__body fu-section-body">
                    <p>This block improves how structured content is browsed without adding complexity to how it is managed.</p>

                    <p>The same pattern can support resource libraries, case studies, service collections, or team directories where discoverability matters.</p>
                </div>
            </div>
        </section>

        <?php
        get_template_part(
            'parts/block-navigation',
            null,
            array(
                'current' => 'filtered-content-grid',
            )
        );
        ?>

        <section class="fu-portfolio-piece__closing">
            <div class="container container--page">
                <div class="fu-cta-panel--dark fu-portfolio-piece__closing-inner fu-cta-panel">
                    <p class="fu-eyebrow">Closing Thought</p>
                    <h2 class="fu-portfolio-piece__closing-heading">Need help implementing maintainable WordPress features?</h2>
                    <p class="fu-portfolio-piece__closing-body">I help agencies build responsive, editor-friendly WordPress features that are easier to ship, support, and hand off.</p>

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
