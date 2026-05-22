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
                        <p class="fu-eyebrow">WordPress / ACF Block</p>
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
                    <p class="fu-eyebrow">Overview</p>
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

            <section class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-eyebrow">Editor Controls</p>
                    <h2 class="fu-case-section__heading">Focused Controls Instead of an Overloaded Settings Panel</h2>
                    <div class="fu-case-section__body">
                        <p>The control set was intentionally kept tight: heading, intro text, CTA label, excerpt visibility, item count, and empty-state messaging.</p>
                        <p>The goal is to give editors flexibility where it matters without turning the block into a universal data-builder UI.</p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-eyebrow">Implementation</p>
                    <h2 class="fu-case-section__heading">Server-Rendered First, Enhanced on the Front End</h2>
                    <div class="fu-case-section__body">
                        <p>The block uses a server-rendered initial state for stability, then enhances the experience with front-end filtering through the WordPress REST API.</p>
                        <p>The implementation was kept intentionally restrained to prioritize portability, editor/frontend parity, and a clean editing experience.</p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-eyebrow">Outcome</p>
                    <h2 class="fu-case-section__heading">Adaptable Beyond This Demo</h2>
                    <div class="fu-case-section__body">
                        <p>This example uses a Resource content model, but the same block pattern can support case studies, service libraries, team directories, or other structured content collections.</p>
                        <p>The result is a reusable component that improves content discovery while keeping the editing workflow simple and scalable.</p>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio__section">
                <div class="fu-portfolio__closing">
                    <span class="fu-portfolio__eyebrow">Closing Thought</span>
                    <h2>Need a better way to organize and browse structured content?</h2>
                    <p>
                        I build WordPress components that make content easier to manage, easier to scale, and easier for visitors to use.
                    </p>
                    <div class="fu-portfolio__actions" style="margin-top:1.5rem;">
                        <a class="fu-portfolio__button fu-portfolio__button--primary" href="http://tim-fetter.local/contact/">Start a Conversation</a>
                        <a class="fu-portfolio__button fu-portfolio__button--secondary" href="http://tim-fetter.local/portfolio/">Back to Portfolio</a>
                    </div>
                </div>
            </section>

        </div>
    </div>
</article>

<?php
get_footer();
