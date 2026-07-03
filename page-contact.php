<?php

/**
 * The template for displaying the Contact page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="fu-contact-page container container--page">
        <div class="fu-contact-page__intro">
            <p class="fu-eyebrow fu-eyebrow--inverse fu-eyebrow--pill">Contact</p>
            <h1>Tell me what you need built, fixed, or improved</h1>
            <p class="fu-section-lede fu-section-lede--inverse fu-contact-page__lede">
                Share a few details about the site, project, timeline, or problem you’re trying to solve.<br> I can help with WordPress work, front-end implementation, responsive polish, cleanup, and editor-friendly enhancements across a range of web projects.
            </p>
        </div>

        <div class="fu-contact-page__layout">
            <div class="fu-contact-page__details">
                <p class="fu-eyebrow fu-eyebrow--inverse fu-contact-page__eyebrow">How I can help</p>
                <h2>Common requests</h2>

                <div class="fu-contact-page__service-stack">
                    <article class="fu-contact-page__service-card">
                        <h3>WordPress Development Support</h3>
                        <ul>
                            <li>WordPress theme and template work</li>
                            <li>ACF Blocks and editor-friendly content fields</li>
                            <li>Page-builder support or cleanup</li>
                            <li>Responsive fixes and reusable components</li>
                        </ul>
                    </article>

                    <article class="fu-contact-page__service-card">
                        <h3>Front-End Implementation</h3>
                        <ul>
                            <li>Responsive HTML/CSS/JS implementation</li>
                            <li>Custom UI layouts and content sections</li>
                            <li>Interactive states and workflow screens</li>
                            <li>Front-end polish for existing designs</li>
                        </ul>
                    </article>
                </div>
            </div>

            <div class="fu-contact-page__form">
                <h2>Send a message</h2>
                <p class="fu-contact-page__form-intro">
                    Share the page, block, bug, design file, or workflow that needs attention, plus any timeline, access, or review details that would help me understand the next step.
                </p>

                <?php echo do_shortcode('[forminator_form id="2033"]'); ?>
            </div>
        </div>
    </div>
</main><!-- #main -->

<?php
get_footer();
