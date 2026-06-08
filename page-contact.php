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
                I’m available for focused front-end development support, WordPress improvements, reusable component work, custom UI implementation, and ongoing site updates for teams that need extra implementation help.
            </p>
        </div>

        <div class="fu-contact-page__layout">
            <div class="fu-contact-page__details">
                <p class="fu-contact-page__eyebrow">How I can help</p>
                <h2>Service lanes</h2>

                <div class="fu-contact-page__service-stack">
                    <article class="fu-contact-page__service-card">
                        <h3>WordPress Development Support</h3>
                        <p>
                            Theme and template work, ACF Blocks, structured content, page-builder cleanup, responsive fixes, reusable components, editor-friendly implementation, and ongoing site improvements.
                        </p>
                        <ul>
                            <li>WordPress theme and template work</li>
                            <li>ACF Blocks and structured content</li>
                            <li>Page-builder support or cleanup</li>
                            <li>Responsive fixes and reusable components</li>
                        </ul>
                    </article>

                    <article class="fu-contact-page__service-card">
                        <h3>Front-End Design &amp; UI Implementation</h3>
                        <p>
                            Responsive HTML, CSS, and JavaScript implementation for custom layouts, interface states, workflow screens, and front-end polish that may live inside WordPress or another production system.
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
                    Tell me a little about what you’re working on, where things are stuck, or what kind of front-end or WordPress help would make the next step easier.
                </p>

                <?php echo do_shortcode('[forminator_form id="2033"]'); ?>
            </div>
        </div>
    </div>
</main><!-- #main -->

<?php
get_footer();
