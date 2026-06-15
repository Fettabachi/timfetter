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
    <div class="fu-contact-page">
        <div class="fu-contact-page__intro">
            <p class="fu-kicker">Contact</p>
            <h1>Let’s talk about where I can help</h1>
            <p>
                Share a few details about the site, project, timeline, or problem you’re trying to solve. I can help with WordPress work, front-end implementation, responsive polish, cleanup, and editor-friendly enhancements across a range of web projects.
            </p>
        </div>

        <div class="fu-contact-page__layout">
            <div class="fu-contact-page__details">
                <p class="fu-contact-page__eyebrow">How I can help</p>
                <h2>Common requests</h2>

                <div class="fu-contact-page__service-stack">
                    <article class="fu-contact-page__service-card">
                        <h3>WordPress Development Support</h3>
                        <p>
                            Theme and template updates, ACF Blocks, page-builder cleanup, responsive fixes, and content structures that are easier for editors to maintain.
                        </p>
                        <ul>
                            <li>WordPress theme and template work</li>
                            <li>ACF Blocks and editor-friendly content fields</li>
                            <li>Page-builder support or cleanup</li>
                            <li>Responsive fixes and reusable components</li>
                        </ul>
                    </article>

                    <article class="fu-contact-page__service-card">
                        <h3>Front-End Design &amp; UI Implementation</h3>
                        <p>
                            Responsive HTML, CSS, and JavaScript implementation for custom layouts, interface states, workflow screens, and production-ready front-end polish.
                        </p>
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
                <p>
                    Share the page, block, bug, design file, or workflow that needs attention, plus any timeline, access, or review details that would help me understand the next step.
                </p>

                <?php echo do_shortcode('[forminator_form id="2033"]'); ?>
            </div>
        </div>
    </div>
</main><!-- #main -->

<?php
get_footer();
