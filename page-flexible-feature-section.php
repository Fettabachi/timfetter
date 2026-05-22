<?php

/**
 * Template Name: Flexible Feature Section Portfolio
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-portfolio-piece fu-portfolio-piece--hero-media'); ?>>
    <div class="container">
        <div class="entry-content">
            <section id="lead" class="fu-portfolio-piece__lead">
                <div class="fu-portfolio-piece__lead-inner">
                    <div class="fu-portfolio-piece__lead-copy">
                        <p class="fu-eyebrow">WordPress / ACF Block</p>
                        <h1 class="fu-portfolio-piece__lead-heading">Flexible Feature Section</h1>
                        <div class="fu-portfolio-piece__lead-body">
                            <p>A reusable ACF-powered section block built to stay balanced with real content. It gives editors meaningful layout flexibility while preventing combinations that weaken the design or responsiveness.</p>
                        </div>
                    </div>

                    <div class="fu-portfolio-piece__lead-media">
                        <figure class="fu-portfolio-piece__lead-figure">
                            <img src="http://tim-fetter.local/wp-content/uploads/2026/05/page-flexible-feature-hero.webp" alt="Flexible Feature Section hero example showing content and media working together in a structured layout.">
                        </figure>
                        <p class="fu-portfolio-piece__lead-caption">Designed to handle real copy, responsive layout shifts, and visual variation without losing structure.</p>
                    </div>

                    <div class="fu-portfolio-piece__meta fu-portfolio-piece__meta--hero-row">
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Use Case</span>
                            <span class="fu-portfolio-piece__meta-value">Content sections, landing pages, calls to action</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Content Model</span>
                            <span class="fu-portfolio-piece__meta-value">Flexible layout + guided editor controls</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Key Strength</span>
                            <span class="fu-portfolio-piece__meta-value">Constraint-driven flexibility</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="overview" class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-eyebrow">Overview</p>
                    <h2 class="fu-case-section__heading">A More Reliable Way to Build Feature Sections</h2>
                    <div class="fu-case-section__body">
                        <p>Feature sections often break down when real content is introduced. Variations in copy length, imagery, and screen size can quickly create imbalance, especially at tablet widths.</p>
                        <p>This block was designed to reduce that friction by limiting unnecessary controls and preventing invalid layout combinations. The result is a component that stays predictable without sacrificing flexibility.</p>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__lead">
                <?php the_content(); ?>
            </section>

            <section id="outcome" class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-eyebrow">Outcome</p>
                    <h2 class="fu-case-section__heading">Flexible for Editors, Reliable on the Front End</h2>
                    <div class="fu-case-section__body">
                        <p>This block was built to solve a practical problem: creating flexible content sections that don’t break when real content is introduced. By limiting invalid layout combinations and focusing on predictable behavior, it produces consistent results across a wide range of use cases.</p>

                        <p>The same component can be reused across landing pages, service sections, and internal content without redesigning layouts for each scenario. Editors get meaningful flexibility, while the structure ensures the front-end remains balanced and reliable.</p>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__closing">
                <div class="fu-portfolio-piece__closing-inner">
                    <p class="fu-eyebrow">Closing Thought</p>
                    <h2 class="fu-portfolio-piece__closing-heading">Need a flexible section system that still feels controlled?</h2>
                    <p class="fu-portfolio-piece__closing-body">I build WordPress components that give editors useful flexibility without sacrificing layout consistency or front-end quality.</p>

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
