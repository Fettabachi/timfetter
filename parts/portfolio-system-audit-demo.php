<?php
/**
 * Live portfolio system audit demo.
 *
 * @package Tim_Fetter_Portfolio
 */

$audit_endpoint = rest_url('timfetter/v1/portfolio-system-audit');
$audit_nonce = is_user_logged_in() ? wp_create_nonce('wp_rest') : '';
$audit_resource = get_page_by_path('wordpress-abilities-api-site-features', OBJECT, 'resource');
$audit_resource_url = $audit_resource ? get_permalink($audit_resource) : home_url('/resources/wordpress-abilities-api-site-features/');
$audit_resource_url = wp_make_link_relative($audit_resource_url);
?>

<section class="fu-case-section fu-portfolio-audit" id="portfolio-system-audit" aria-labelledby="portfolio-system-audit-heading">
    <div class="fu-case-section__inner container container--readable">
        <div
            class="fu-portfolio-audit__panel"
            data-fu-portfolio-audit
            data-endpoint="<?php echo esc_url($audit_endpoint); ?>"
            data-nonce="<?php echo esc_attr($audit_nonce); ?>">
            <div class="fu-portfolio-audit__header">
                <p class="fu-eyebrow">WordPress Abilities API Demo</p>
                <h2 class="fu-section-heading fu-section-heading--compact" id="portfolio-system-audit-heading">Live Portfolio System Audit</h2>
                <p class="fu-section-lede">This demo shows how a WordPress site can safely explain maintenance checks without exposing private site details. Public visitors see what the checks are designed to evaluate; authorized editors can see live results and fix guidance.</p>
            </div>

            <div class="fu-portfolio-audit__actions">
                <button class="fu-portfolio-piece__button fu-portfolio-piece__button--primary fu-portfolio-audit__button" type="button" data-audit-run>
                    Run system audit
                </button>
                <p class="fu-portfolio-audit__status" data-audit-status aria-live="polite">Ready to run a safe read-only audit.</p>
            </div>

            <p class="fu-portfolio-audit__resource-link">
                <a href="<?php echo esc_url($audit_resource_url); ?>">Read the full resource: How the WordPress Abilities API Can Make Site Features Safer and More Useful</a>
            </p>

            <div class="fu-portfolio-audit__fallback" data-audit-fallback hidden>
                Abilities API unavailable in this environment. Showing the public endpoint fallback.
            </div>

            <div class="fu-portfolio-audit__results" data-audit-results aria-busy="false"></div>
        </div>
    </div>
</section>
