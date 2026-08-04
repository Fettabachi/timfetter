<?php

/**
 * The template for displaying the Resume page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();

$resume_home_url     = wp_make_link_relative(home_url('/'));
$resume_contact_url  = wp_make_link_relative(home_url('/contact/'));
$resume_work_url     = wp_make_link_relative(home_url('/work/'));
$resume_linkedin_url = 'https://www.linkedin.com/in/tim-fetter/';
$resume_print_origin = 'https://timfetter.com';

$resume_portfolio_item_url = static function ($slug) {
    $post = get_page_by_path($slug, OBJECT, 'portfolio-items');

    if ($post instanceof WP_Post) {
        return wp_make_link_relative(get_permalink($post));
    }

    return wp_make_link_relative(home_url('/work/' . trim($slug, '/') . '/'));
};

$resume_page_url = static function ($slugs, $fallback_path) {
    foreach ((array) $slugs as $slug) {
        $page = get_page_by_path($slug);

        if ($page instanceof WP_Post) {
            return wp_make_link_relative(get_permalink($page));
        }
    }

    return wp_make_link_relative(home_url($fallback_path));
};

$resume_print_url = static function ($url) use ($resume_print_origin) {
    if ($url === '' || strpos($url, '/') !== 0) {
        return $url;
    }

    return $resume_print_origin . $url;
};

$resume_link_attrs = static function ($url) use ($resume_print_url) {
    $attrs     = sprintf('href="%s"', esc_url($url));
    $print_url = $resume_print_url($url);

    if ($print_url !== $url) {
        $attrs .= sprintf(' data-print-href="%s"', esc_url($print_url));
    }

    return $attrs;
};

$resume_link = static function ($text, $url) use ($resume_link_attrs) {
    if ($url === '') {
        return esc_html($text);
    }

    return sprintf(
        '<a %s>%s</a>',
        $resume_link_attrs($url),
        esc_html($text)
    );
};

$resume_client_work_links = array(
    'omni'                   => $resume_portfolio_item_url('omni-hotels-resorts'),
    'blackberry'             => $resume_portfolio_item_url('blackberry-farm-blackberry-mountain'),
    'plastic_makers'         => $resume_portfolio_item_url('plastic-makers'),
    'national_university'    => $resume_portfolio_item_url('national-university'),
    'fibroid_foundation'     => $resume_portfolio_item_url('fibroid-foundation'),
    'good_chemistry'         => $resume_portfolio_item_url('good-chemistry-lives-here'),
    'reusable_sections'      => $resume_page_url(array('acf-block-system', 'acf-block-system-for-editor-friendly-wordpress-builds'), '/acf-block-system-for-editor-friendly-wordpress-builds/'),
    'editor_handoff'         => $resume_page_url(array('editor-experience', 'editor-experience-handoff'), '/editor-experience-handoff/'),
    'front_end_ui_examples'  => wp_make_link_relative(home_url('/work/#front-end-prototypes')),
);
?>

<main id="primary" class="site-main resume-page">
    <section class="resume-hero section" aria-labelledby="resume-title">
        <div class="container container--readable">
            <p class="fu-eyebrow">Resume</p>
            <div class="resume-hero__header">
                <div class="resume-hero__identity">
                    <h1 id="resume-title">Tim Fetter</h1>
                    <p class="resume-hero__role">WordPress &amp; Front-End Developer</p>
                </div>

                <ul class="resume-contact-list" aria-label="Contact details">
                    <li><a <?php echo $resume_link_attrs($resume_home_url); ?>>timfetter.com</a></li>
                    <li><a href="mailto:contact@timfetter.com">contact@timfetter.com</a></li>
                    <li><a href="<?php echo esc_url($resume_linkedin_url); ?>" target="_blank" rel="noopener noreferrer">linkedin.com/in/tim-fetter</a></li>
                    <li>United States</li>
                </ul>
            </div>

            <p class="fu-section-lede resume-hero__summary">
                I help agencies, designers, and businesses turn approved designs and project requirements into polished, maintainable WordPress and front-end interfaces. My work focuses on custom theme implementation, reusable WordPress sections, responsive layouts, interactive UI, and practical improvements that are easier to maintain after launch.
            </p>

            <div class="resume-hero__actions" aria-label="Resume actions">
                <button class="fu-portfolio-piece__button fu-portfolio-piece__button--primary resume-print-button" type="button" onclick="window.print()">Print or Save PDF</button>
                <a class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary" <?php echo $resume_link_attrs($resume_work_url); ?>>View Selected Work</a>
            </div>
        </div>
    </section>

    <section class="resume-content section" aria-label="Resume details">
        <div class="container container--readable">
            <div class="resume-document" aria-label="Tim Fetter resume">
                <section class="resume-section resume-section--divided" aria-labelledby="resume-skills-heading">
                    <h2 id="resume-skills-heading">Core Skills</h2>
                    <ul class="resume-skill-list resume-skills">
                        <li>WordPress theme development</li>
                        <li>ACF Blocks and structured fields</li>
                        <li>Responsive HTML, CSS, and JavaScript</li>
                        <li>Custom templates and reusable content sections</li>
                        <li>Editor-friendly implementation and handoff</li>
                        <li>Accessibility-minded UI patterns</li>
                        <li>Front-end polish, cleanup, and bug fixes</li>
                        <li>Interactive prototypes and workflow screens</li>
                    </ul>
                </section>

                <section class="resume-section resume-section--divided" aria-labelledby="resume-experience-heading">
                    <h2 id="resume-experience-heading">Experience</h2>

                    <article class="resume-role">
                        <div class="resume-role__header">
                            <h3>Independent WordPress &amp; Front-End Developer</h3>
                        </div>

                        <ul>
                            <li>Build and refine custom WordPress templates, ACF-powered content systems, and reusable page sections for maintainable client sites.</li>
                            <li>Translate approved designs and production requirements into responsive front-end interfaces with clean markup, scoped styles, and practical editor controls.</li>
                            <li>Support agency and business teams with overflow development, responsive fixes, page-builder cleanup, and ongoing site improvements.</li>
                            <li>Create interactive prototypes and workflow screens that help teams clarify behavior, states, and implementation details before production.</li>
                            <li>Collaborate comfortably with designers, project managers, developers, and content teams throughout implementation.</li>
                        </ul>

                        <div class="resume-client-work">
                            <h3 class="resume-client-work__heading">Selected Client Work</h3>

                            <ul class="resume-project-list">
                                <li>
                                    <strong>Rare Medium:</strong>
                                    <span><?php echo $resume_link('Omni Hotels & Resorts', $resume_client_work_links['omni']); ?>, <?php echo $resume_link('Blackberry Farm & Blackberry Mountain', $resume_client_work_links['blackberry']); ?></span>
                                </li>
                                <li>
                                    <strong>The Brick Factory:</strong>
                                    <span><?php echo $resume_link('Plastic Makers', $resume_client_work_links['plastic_makers']); ?>, <?php echo $resume_link('National University', $resume_client_work_links['national_university']); ?>, <?php echo $resume_link('Fibroid Foundation', $resume_client_work_links['fibroid_foundation']); ?>, <?php echo $resume_link('Good Chemistry Lives Here', $resume_client_work_links['good_chemistry']); ?></span>
                                </li>
                                <li>
                                    <strong>Portfolio:</strong>
                                    <span><?php echo $resume_link('Reusable WordPress Sections', $resume_client_work_links['reusable_sections']); ?> • <?php echo $resume_link('Editor Experience & Handoff', $resume_client_work_links['editor_handoff']); ?> • <?php echo $resume_link('Front-End UI Examples', $resume_client_work_links['front_end_ui_examples']); ?></span>
                                </li>
                            </ul>
                        </div>
                    </article>
                </section>

                <section class="resume-section resume-section--divided" aria-labelledby="resume-approach-heading">
                    <h2 id="resume-approach-heading">Working Approach</h2>
                    <ul>
                        <li>Thoughtful implementation that respects the design system, content model, and production constraints.</li>
                        <li>Clear collaboration with designers, project managers, developers, and non-technical stakeholders.</li>
                        <li>Handoff-minded development that considers the editor updating content and the developer maintaining the site later.</li>
                    </ul>
                </section>

                <section class="resume-section resume-section--divided resume-section--screen" aria-labelledby="resume-links-heading">
                    <h2 id="resume-links-heading">Links</h2>
                    <p>
                        View selected work at <a <?php echo $resume_link_attrs($resume_work_url); ?>>timfetter.com/work</a> or send project details through the <a <?php echo $resume_link_attrs($resume_contact_url); ?>>contact page</a>.
                    </p>
                </section>
            </div>
        </div>
    </section>
</main><!-- #main -->

<script>
    (function() {
        var printLinks = Array.prototype.slice.call(document.querySelectorAll('[data-print-href]'));

        if (!printLinks.length) {
            return;
        }

        function usePrintLinks() {
            printLinks.forEach(function(link) {
                if (!link.dataset.screenHref) {
                    link.dataset.screenHref = link.getAttribute('href') || '';
                }

                link.setAttribute('href', link.dataset.printHref);
            });
        }

        function useScreenLinks() {
            printLinks.forEach(function(link) {
                if (link.dataset.screenHref) {
                    link.setAttribute('href', link.dataset.screenHref);
                }
            });
        }

        if (window.matchMedia) {
            var printMedia = window.matchMedia('print');
            var handlePrintChange = function(event) {
                if (event.matches) {
                    usePrintLinks();
                } else {
                    useScreenLinks();
                }
            };

            if (printMedia.addEventListener) {
                printMedia.addEventListener('change', handlePrintChange);
            } else if (printMedia.addListener) {
                printMedia.addListener(handlePrintChange);
            }
        }

        window.addEventListener('beforeprint', usePrintLinks);
        window.addEventListener('afterprint', useScreenLinks);
    })();
</script>

<?php
get_footer();
