<?php

/**
 * Template Name: Page Banner Portfolio
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

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-portfolio-piece fu-portfolio-piece--hero-media fu-page-banner-portfolio'); ?>>
    <div class="container">
        <div class="entry-content">

            <section class="fu-portfolio-piece__lead">
                <div class="fu-portfolio-piece__lead-inner">
                    <div class="fu-portfolio-piece__lead-copy">
                        <p class="fu-eyebrow">WordPress / ACF Block</p>
                        <h1 class="fu-portfolio-piece__lead-heading"><?php the_title(); ?></h1>

                        <div class="fu-portfolio-piece__lead-body">
                            <p>
                                A reusable page banner block built to help editors create flexible, high-impact headers, while giving developers predictable structure and maintainable output.

                                It supports both video and image backgrounds, overlay and readability controls, and flexible content layout—all within an editor experience that closely reflects the final front-end result.
                            </p>
                        </div>
                    </div>

                    <div class="fu-portfolio-piece__lead-media">
                        <figure class="fu-portfolio-piece__lead-figure">
                            <img
                                src="<?php echo esc_url(home_url('/wp-content/uploads/2026/05/page-banner-hero.webp')); ?>"
                                alt="Page Banner block process collage showing planning, front-end implementation, and editor controls.">
                        </figure>
                        <p class="fu-portfolio-piece__lead-caption">
                            Built as a reusable WordPress component with a polished front end, thoughtful defaults,
                            and a stronger editor experience behind the scenes.
                        </p>
                    </div>

                    <div class="fu-portfolio-piece__meta fu-portfolio-piece__meta--hero-row">
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Use Case</span>
                            <span class="fu-portfolio-piece__meta-value">Hero banners, page intros, campaign headers</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Content Model</span>
                            <span class="fu-portfolio-piece__meta-value">Media-driven layout + guided editor controls</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Key Strength</span>
                            <span class="fu-portfolio-piece__meta-value">Editor parity with flexible presentation</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-eyebrow">Overview</p>
                    <h2 class="fu-case-section__heading">A More Flexible Banner Without a Messy Editing Experience</h2>

                    <div class="fu-case-section__body">
                        <p>
                            Page banners are often either too rigid to be useful or so configurable that they become hard for editors to trust. This block was designed to strike a better balance.</p>

                        <p>It supports both video and image treatments, gives editors meaningful control over presentation, and keeps the experience grounded in a preview that closely reflects the front end.
                        </p>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__demo-panel fu-page-banner-portfolio__demo-panel" id="live-demo">
                <div class="fu-portfolio-piece__demo-panel-inner">
                    <div class="fu-portfolio__hint">
                        <span>Try the live controls</span>
                    </div>

                    <div class="fu-page-banner-portfolio__demo-head">
                        <p class="fu-eyebrow">Live Component Preview</p>
                        <h2 class="fu-page-banner-portfolio__demo-heading">Interactive Banner Configurations</h2>
                    </div>

                    <div class="fu-page-banner-portfolio__demo-note" role="note" aria-label="Demo instructions">
                        <p>
                            <strong>Try it:</strong> Open the settings button on each banner to explore the front-end
                            demo controls. These expose only a curated subset of the options available to editors
                            inside WordPress.
                        </p>
                    </div>

                    <div class="fu-page-banner-portfolio__demo-stage">
                        <?php the_content(); ?>
                    </div>

                    <p class="fu-portfolio-piece__demo-caption">
                        This example shows the same component configured in two different ways to demonstrate how it adapts to different content needs while maintaining a consistent editing experience.</p>

                    <p class="fu-portfolio-piece__demo-caption">
                        The front-end controls shown here expose a curated subset of the available options. The full set of controls is available to editors within the WordPress block editor.
                    </p>
                </div>

            </section>

            <section id="design-principles" class="fu-principles">
                <div class="fu-principles__inner">
                    <p class="fu-eyebrow">Design Principles Behind This Block</p>
                    <p class="fu-principles__lede">Flexible where it matters, consistent where it counts. This block gives editors meaningful control while keeping layout, styling, and output predictable across the site.</p>

                    <div class="fu-principles__grid">
                        <div class="fu-principles__item">
                            <h3>Controlled Flexibility</h3>
                            <p>
                                Editors can adjust layout, media, and alignment without breaking the design. Options are intentionally limited to maintain consistency across pages.
                            </p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Built-In Branding</h3>
                            <p>
                                Colors, overlays, and spacing are driven by predefined design tokens, allowing teams to match their brand without custom development.
                            </p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Reusable by Design</h3>
                            <p>
                                The same component supports multiple use cases—from high-impact video banners to simple image headers—without rebuilding layouts.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="editor-experience" class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-eyebrow">Editor Experience</p>
                    <h2 class="fu-case-section__heading">A Better Demo on the Front End, a Broader Toolset in the Editor</h2>

                    <div class="fu-case-section__body">
                        <p>
                            The front-end controls on this page are included to help reviewers interact with the component, but the real value lives in the editor experience.
                        </p>
                        <p>
                            Inside Gutenberg, editors have access to a broader set of controls for media, overlays, layout, visibility, and presentation. The block is designed so the editor preview closely reflects the final front-end result, reducing guesswork and iteration.
                        </p>
                    </div>
                </div>
            </section>

            <section id="implementation" class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-eyebrow">Implementation</p>
                    <h2 class="fu-case-section__heading">Flexible Media, Predictable Output</h2>

                    <div class="fu-case-section__body">
                        <p>
                            The block was built with ACF Pro inside a custom WordPress theme structure that keeps markup, styles, and behavior scoped and maintainable.
                        </p>

                        <p>
                            PHP handles rendering, CSS shapes the presentation, and JavaScript supports preview parity and richer media behavior. The result is a flexible component that remains predictable across different use cases.
                        </p>
                    </div>
                </div>
            </section>

            <section id="outcome" class="fu-case-section">
                <div class="fu-case-section__inner">
                    <p class="fu-eyebrow">Outcome</p>
                    <h2 class="fu-case-section__heading">A Reusable Hero Component for Real WordPress Builds</h2>

                    <div class="fu-case-section__body">
                        <p>
                            This component makes it easier to reuse high-impact page headers across different types of content without rebuilding layouts each time.
                        </p>

                        <p>
                            It reduces one-off development requests while giving content teams more control over presentation, making it a practical solution for real-world WordPress builds.
                        </p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section fu-editor-handoff-callout">
                <div class="fu-case-section__inner">
                    <div class="fu-principles__item">
                        <h3>Want to see how these blocks are handed off?</h3>
                        <p>The Editor Experience &amp; Handoff showcase explains how these blocks are structured for safe content updates, guided controls, and long-term maintainability.</p>
                        <a class="fu-editor-handoff-callout__link" href="<?php echo esc_url($editor_experience_url); ?>">View editor experience &rarr;</a>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__closing">
                <div class="fu-portfolio-piece__closing-inner">
                    <p class="fu-eyebrow">Closing Thought</p>
                    <h2 class="fu-portfolio-piece__closing-heading">Need a flexible banner system that stays consistent and still works well for editors?</h2>
                    <p class="fu-portfolio-piece__closing-body">
                        I build WordPress components that balance front-end presentation with practical editing workflows, so teams can publish with more confidence and fewer layout constraints.
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
