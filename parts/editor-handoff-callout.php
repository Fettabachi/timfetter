<?php

/**
 * Reusable editor handoff callout for ACF block case-study pages.
 *
 * @package Tim_Fetter_Portfolio
 */

$defaults = array(
    'heading'    => 'See how this supports safer editing',
    'body'       => 'The Editor Experience & Handoff showcase explains how reusable blocks are structured for safer content updates, guided controls, and long-term maintainability.',
    'url'        => '',
    'link_label' => 'View editor experience',
);

$callout_args = wp_parse_args(is_array($args) ? $args : array(), $defaults);

if ($callout_args['url'] === '') {
    $editor_experience_page = get_page_by_path('editor-experience');
    $callout_args['url'] = $editor_experience_page ? get_permalink($editor_experience_page) : home_url('/editor-experience/');
}
?>

<section class="fu-case-section fu-editor-handoff-callout">
    <div class="fu-case-section__inner container container--readable">
        <div class="fu-editor-handoff-callout__card">
            <h3><?php echo esc_html($callout_args['heading']); ?></h3>
            <p><?php echo esc_html($callout_args['body']); ?></p>
            <a class="fu-editor-handoff-callout__link" href="<?php echo esc_url($callout_args['url']); ?>">
                <span class="fu-editor-handoff-callout__link-text"><?php echo esc_html($callout_args['link_label']); ?></span>
                <span class="fu-editor-handoff-callout__link-arrow" aria-hidden="true">&rarr;</span>
            </a>
        </div>
    </div>
</section>