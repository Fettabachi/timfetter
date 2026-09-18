<?php

/**
 * Template Name: Targeted Resume PDF
 *
 * A printable letter and a copy of the public resume, kept separate from /resume/.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tim_Fetter_Portfolio
 */

add_filter('body_class', static function ($classes) {
    $classes[] = 'page-resume';
    $classes[] = 'page-targeted-resume';
    return $classes;
});

wp_enqueue_style(
    'targeted-resume',
    get_theme_file_uri('/css/pages/targeted-resume.css'),
    array('our-main-styles'),
    filemtime(get_theme_file_path('/css/pages/targeted-resume.css'))
);
wp_enqueue_script(
    'targeted-resume',
    get_theme_file_uri('/src/targeted-resume.js'),
    array(),
    filemtime(get_theme_file_path('/src/targeted-resume.js')),
    true
);

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

<main id="primary" class="site-main resume-page targeted-resume-page">
    <section class="targeted-resume-editor section" aria-labelledby="targeted-resume-editor-title">
        <div class="container container--readable">
            <p class="fu-eyebrow">Targeted résumé</p>
            <h1 id="targeted-resume-editor-title">Cover letter + résumé</h1>
            <p>Edit the letter below, then print or save this two-page document as a PDF. Review the print preview before saving if your letter changes substantially.</p>
            <form class="targeted-resume-form" id="targeted-resume-form">
                <div class="targeted-resume-form__row">
                    <label>Company name <input name="company" value="The Mauldin Group" required></label>
                    <label>Company location <input name="location" value="Roswell, GA"></label>
                    <label>Date <input name="date" value="September 18, 2026" required></label>
                    <label>Greeting <input name="greeting" value="Hello," required></label>
                </div>
                <label>Opening <textarea name="opening" rows="3" required>I'm reaching out to introduce myself in case The Mauldin Group needs additional WordPress or front-end development support for client websites.</textarea></label>
                <label>Experience <textarea name="experience" rows="4" required>I'm a WordPress and front-end developer with 15+ years of experience helping agencies turn approved designs and project requirements into polished, responsive websites. I build custom themes and reusable content sections, work with Advanced Custom Fields and Elementor, and refine interfaces for accessibility and long-term maintenance.</textarea></label>
                <label>Why this company <textarea name="fit" rows="4" required>Your focus on websites and ongoing digital support for nonprofits, associations, and membership organizations is a strong fit for my work. Those sites need clear content, dependable editing tools, and careful implementation across devices. I can help your team build and improve client pages while respecting existing designs and workflows.</textarea></label>
                <label>Close <textarea name="close" rows="4" required>I would welcome a conversation if freelance or overflow development support would be useful. My résumé is on the next page, and selected work is available at timfetter.com. Thank you for your time and consideration.</textarea></label>
                <div class="targeted-resume-form__actions">
                    <button class="fu-portfolio-piece__button fu-portfolio-piece__button--primary" type="button" id="targeted-resume-print">Print or save PDF</button>
                    <button class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary" type="reset">Restore Mauldin letter</button>
                </div>
                <p class="targeted-resume-form__status" id="targeted-resume-status" role="status" aria-live="polite"></p>
            </form>
        </div>
    </section>

    <section class="targeted-resume-letter" aria-label="Cover letter">
        <div class="container container--readable">
            <div class="targeted-resume-letter__heading">
                <div>
                    <p class="targeted-resume-letter__name">Tim Fetter</p>
                    <p class="targeted-resume-letter__role">WordPress &amp; Front-End Developer</p>
                </div>
                <div class="targeted-resume-letter__contact">
                    <a href="https://timfetter.com">timfetter.com</a>
                    <a href="mailto:contact@timfetter.com">contact@timfetter.com</a>
                    <a href="https://www.linkedin.com/in/tim-fetter/">linkedin.com/in/tim-fetter</a>
                </div>
            </div>
            <div class="targeted-resume-letter__body">
                <p class="targeted-resume-letter__date" data-targeted-output="date">September 18, 2026</p>
                <p class="targeted-resume-letter__recipient"><span data-targeted-output="company">The Mauldin Group</span><br><span data-targeted-output="location">Roswell, GA</span></p>
                <p data-targeted-output="greeting">Hello,</p>
                <p data-targeted-output="opening">I'm reaching out to introduce myself in case The Mauldin Group needs additional WordPress or front-end development support for client websites.</p>
                <p data-targeted-output="experience">I'm a WordPress and front-end developer with 15+ years of experience helping agencies turn approved designs and project requirements into polished, responsive websites. I build custom themes and reusable content sections, work with Advanced Custom Fields and Elementor, and refine interfaces for accessibility and long-term maintenance.</p>
                <p data-targeted-output="fit">Your focus on websites and ongoing digital support for nonprofits, associations, and membership organizations is a strong fit for my work. Those sites need clear content, dependable editing tools, and careful implementation across devices. I can help your team build and improve client pages while respecting existing designs and workflows.</p>
                <p data-targeted-output="close">I would welcome a conversation if freelance or overflow development support would be useful. My résumé is on the next page, and selected work is available at timfetter.com. Thank you for your time and consideration.</p>
                <p class="targeted-resume-letter__signoff">Sincerely,<br><strong>Tim Fetter</strong></p>
            </div>
        </div>
    </section>

    <div class="targeted-resume-sheet" aria-label="Résumé">
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
                </ul>
            </div>

            <p class="fu-section-lede resume-hero__summary">
                I help agencies, designers, and businesses turn approved designs and project requirements into polished, maintainable WordPress and front-end interfaces. My work focuses on custom theme implementation, reusable WordPress sections, responsive layouts, interactive UI, and practical improvements that are easier to maintain after launch. My workflow is AI-accelerated but developer-led — using AI to speed up implementation and debugging, while owning accessibility, testing, and production quality end to end.
            </p>

        </div>
    </section>

    <section class="resume-content section" aria-label="Resume details">
        <div class="container container--readable">
            <div class="resume-document" aria-label="Tim Fetter resume">
                <section class="resume-section resume-section--divided" aria-labelledby="resume-skills-heading">
                    <h2 id="resume-skills-heading">Core Skills</h2>
                    <ul class="resume-skill-list resume-skills">
                        <li>WordPress theme development</li>
                        <li>Advanced Custom Fields (ACF) block development</li>
                        <li>Semantic HTML, modern CSS, and JavaScript</li>
                        <li>Responsive and cross-browser implementation</li>
                        <li>Structured content modeling</li>
                        <li>Accessible UI and keyboard interaction</li>
                        <li>Legacy site support, cleanup, and debugging</li>
                        <li>Git-based version control</li>
                    </ul>
                </section>

                <section class="resume-section resume-section--divided" aria-labelledby="resume-experience-heading">
                    <h2 id="resume-experience-heading">Experience</h2>

                    <article class="resume-role">
                        <div class="resume-role__header">
                            <h3>Independent WordPress &amp; Front-End Developer</h3>
                            <p>2020-Present | Remote, United States</p>
                        </div>

                        <ul>
                            <li>Build and refine custom WordPress templates, ACF-powered content systems, and reusable page sections.</li>
                            <li>Translate approved designs and production requirements into responsive front-end interfaces with clean markup, scoped styles, and practical editor controls.</li>
                            <li>Support with overflow development, responsive fixes, page-builder cleanup, and ongoing site improvements.</li>
                            <li>Collaborate comfortably with designers, project managers, developers, and content teams throughout implementation.</li>
                        </ul>

                        <div class="resume-client-work">
                            <h3 class="resume-client-work__heading">Selected Agency Partnerships & Client Work</h3>
                            <em class="resume-client-work__description">Client names link to detailed case studies.</em>

                            <ul class="resume-project-list">
                                <li>
                                    <strong>Rare Medium </strong>— Contract front-end implementation, responsive styling, and accessibility support for <?php echo $resume_link('Omni Hotels & Resorts', $resume_client_work_links['omni']); ?> and <?php echo $resume_link('Blackberry Farm & Blackberry Mountain', $resume_client_work_links['blackberry']); ?>.
                                </li>
                                <li>
                                    <strong>The Brick Factory </strong>— WordPress, Elementor, custom JavaScript, content-system, and production support for <?php echo $resume_link('Plastic Makers', $resume_client_work_links['plastic_makers']); ?>, <?php echo $resume_link('National University', $resume_client_work_links['national_university']); ?>, <?php echo $resume_link('Fibroid Foundation', $resume_client_work_links['fibroid_foundation']); ?>, and <?php echo $resume_link('Good Chemistry Lives Here', $resume_client_work_links['good_chemistry']); ?>.
                                </li>
                                <li>
                                    <strong>Portfolio:</strong>
                                    <span><?php echo $resume_link('Reusable WordPress Sections', $resume_client_work_links['reusable_sections']); ?> • <?php echo $resume_link('Editor Experience & Handoff', $resume_client_work_links['editor_handoff']); ?></span>
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
    </div>
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
