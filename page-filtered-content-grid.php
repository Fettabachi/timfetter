<?php

/**
 * Template Name: Filtered Content Grid Portfolio
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-portfolio-piece'); ?>>
    <div class="container">
        <div class="entry-content">

            <section class="fu-portfolio-piece__lead">
                <div class="fu-portfolio-piece__lead-inner">
                    <div class="fu-portfolio-piece__lead-copy">
                        <p class="fu-case-section__eyebrow">WordPress / ACF Block</p>
                        <h1 class="fu-portfolio-piece__lead-heading"><?php the_title(); ?></h1>
                        <div class="fu-portfolio-piece__lead-body">
                            <p>A reusable ACF-powered block for browsing structured content by category with smooth, no-reload filtering. Built to make growing content libraries easier to explore without making the editing experience harder.</p>
                        </div>

                        <div class="fu-portfolio-piece__meta">
                            <div class="fu-portfolio-piece__meta-item">
                                <span class="fu-portfolio-piece__meta-label">Use Case</span>
                                <span class="fu-portfolio-piece__meta-value">Resource Library</span>
                            </div>
                            <div class="fu-portfolio-piece__meta-item">
                                <span class="fu-portfolio-piece__meta-label">Content Model</span>
                                <span class="fu-portfolio-piece__meta-value">CPT + Taxonomy</span>
                            </div>
                            <div class="fu-portfolio-piece__meta-item">
                                <span class="fu-portfolio-piece__meta-label">Key Strength</span>
                                <span class="fu-portfolio-piece__meta-value">Smooth front-end filtering</span>
                            </div>
                        </div>
                    </div>

                    <div class="fu-portfolio-piece__lead-media">
                        <figure class="fu-portfolio-piece__lead-figure">
                            <img src="<?php echo esc_url(home_url('/wp-content/uploads/2026/04/planning-and-execution.jpg')); ?>" alt="Planning, wireframing, and building process collage for the Filtered Content Grid project.">
                        </figure>
                        <p class="fu-portfolio-piece__lead-caption">Built as a focused WordPress content component: structured data underneath, polished interaction on the front end.</p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Overview</p>
                    <h2 class="fu-case-section__heading">A Better Way to Browse Structured Content</h2>
                    <div class="fu-case-section__body">
                        <p>As content libraries grow, they often become harder to browse. Category archive pages can feel clunky, and manually curated layouts become difficult to maintain.</p>
                        <p>This block provides instant category filtering without page reloads, helping visitors narrow content quickly while editors continue managing entries as structured WordPress content.</p>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__demo-panel" id="live-demo">
                <div class="fu-portfolio-piece__demo-panel-inner">
                    <?php the_content(); ?>
                    <p class="fu-portfolio-piece__demo-caption">This live example uses a Resource custom post type and taxonomy filters to update the grid instantly without reloading the page.</p>
                </div>
            </section>

            <section class="fu-principles">
                <div class="fu-principles__inner">
                    <p class="fu-principles__eyebrow">Design Principles Behind This Block</p>
                    <p class="fu-principles__lede">Flexible where it matters, consistent where it counts. This block gives editors meaningful control while keeping layout, styling, and output predictable across the site.</p>

                    <div class="fu-principles__grid">
                        <div class="fu-principles__item">
                            <h3>Start with structured content</h3>
                            <p>The block is built around a clear content model using post types and taxonomies, so filtering feels natural instead of forced.</p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Keep interactions fast and predictable</h3>
                            <p>Filtering happens instantly without page reloads, allowing users to explore content quickly without losing context.</p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Limit controls to what matters</h3>
                            <p>Editors can adjust key content and display options without turning the block into a complex configuration interface.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Editor Experience</p>
                    <h2 class="fu-case-section__heading">Editors Don’t Need a Complex Settings Panel to Use This</h2>
                    <div class="fu-case-section__body">
                        <p>The block focuses on a small set of meaningful controls: heading, intro text, CTA label, excerpt visibility, item count, and empty-state messaging.</p>

                        <p>Instead of exposing every possible option, the goal is to make common tasks easy and predictable. Editors can manage structured content normally, while the block handles how it’s presented.</p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Implementation</p>
                    <h2 class="fu-case-section__heading">Stable First Load, Enhanced Interaction</h2>
                    <div class="fu-case-section__body">
                        <p>The grid is server-rendered on initial load to ensure consistent output and avoid layout shifts. From there, filtering is handled on the front end using the WordPress REST API.</p>

                        <p>This approach keeps the experience fast and responsive while maintaining a reliable baseline for SEO, accessibility, and content rendering.</p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Outcome</p>
                    <h2 class="fu-case-section__heading">Reusable Across Real Content Systems</h2>
                    <div class="fu-case-section__body">
                        <p>This block was built to improve how structured content is browsed, without adding complexity to how it’s managed. By combining a clear content model with fast front-end filtering, it produces a smoother experience for both editors and users.</p>

                        <p>The same pattern can be applied to resource libraries, case studies, service collections, or team directories—making it a flexible solution for content-heavy sites that need better organization and discoverability.</p>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__closing">
                <div class="fu-portfolio-piece__closing-inner">
                    <p class="fu-case-section__eyebrow">Closing Thought</p>
                    <h2 class="fu-portfolio-piece__closing-heading">Need a better way to organize and browse structured content?</h2>
                    <p class="fu-portfolio-piece__closing-body">I build WordPress components that make content easier to manage, easier to scale, and easier for visitors to use.</p>

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
