<?php
/**
 * Contextual navigation for front-end UI example pages.
 *
 * @package Tim_Fetter_Portfolio
 */

$current = isset($args['current']) ? sanitize_key($args['current']) : '';

$prototypes = array(
    'client-project-timeline'       => array(
        'label'       => 'Client Project Timeline',
        'description' => 'A configurable milestone tracker for testing workflow states, responsive timeline layouts, and handoff-ready UI behavior before production buildout.',
    ),
    'project-scope-estimator'       => array(
        'label'       => 'Project Scope Estimator',
        'description' => 'A guided interface that helps teams define project requirements, preview complexity, and generate a handoff-friendly summary before production planning.',
    ),
    'content-approval-checklist'    => array(
        'label'       => 'Content Approval Checklist',
        'description' => 'A responsive checklist interface for tracking content readiness, review status, blockers, and launch approval across website production workflows.',
    ),
);

if (! isset($prototypes[$current])) {
    return;
}

$resolve_prototype_url = static function ($slug) {
    $prototype = get_page_by_path($slug, OBJECT, 'portfolio-items');

    return $prototype ? get_permalink($prototype) : home_url('/work/' . trim((string) $slug, '/') . '/');
};

$prototype_keys = array_keys($prototypes);
$current_index  = array_search($current, $prototype_keys, true);
$previous_key   = $current_index > 0 ? $prototype_keys[$current_index - 1] : '';
$next_key       = $current_index < count($prototype_keys) - 1 ? $prototype_keys[$current_index + 1] : '';
?>

<section class="fu-block-navigation fu-prototype-navigation" aria-labelledby="fu-prototype-navigation-heading">
    <div class="container container--page">
        <div class="fu-block-navigation__inner">
            <nav class="fu-block-navigation__pager" aria-label="Previous and next Front-End UI Examples">
                <?php if ($previous_key !== '') : ?>
                    <a class="fu-block-navigation__pager-link fu-block-navigation__pager-link--previous" href="<?php echo esc_url($resolve_prototype_url($previous_key)); ?>">
                        <span class="fu-block-navigation__pager-kicker">&larr; Previous example</span>
                        <span class="fu-block-navigation__pager-title"><?php echo esc_html($prototypes[$previous_key]['label']); ?></span>
                    </a>
                <?php else : ?>
                    <span class="fu-block-navigation__pager-spacer" aria-hidden="true"></span>
                <?php endif; ?>

                <?php if ($next_key !== '') : ?>
                    <a class="fu-block-navigation__pager-link fu-block-navigation__pager-link--next" href="<?php echo esc_url($resolve_prototype_url($next_key)); ?>">
                        <span class="fu-block-navigation__pager-kicker">Next example &rarr;</span>
                        <span class="fu-block-navigation__pager-title"><?php echo esc_html($prototypes[$next_key]['label']); ?></span>
                    </a>
                <?php else : ?>
                    <span class="fu-block-navigation__pager-spacer" aria-hidden="true"></span>
                <?php endif; ?>
            </nav>

            <div class="fu-block-navigation__header">
                <p class="fu-eyebrow">Front-End UI Examples</p>
                <h2 id="fu-prototype-navigation-heading" class="fu-block-navigation__heading">Explore more Front-End UI Examples</h2>
                <p class="fu-block-navigation__intro">
                    Interactive front-end examples showing how workflows, decision points, state changes, and handoff details can be clarified before full production development.
                </p>
            </div>

            <nav class="fu-block-navigation__collection" aria-label="Front-End UI Example collection">
                <ul class="fu-block-navigation__grid">
                    <?php foreach ($prototypes as $key => $prototype) : ?>
                        <li class="fu-block-navigation__item">
                            <?php if ($key === $current) : ?>
                                <div class="fu-block-navigation__card fu-block-navigation__card--current" aria-current="page">
                                    <span class="fu-block-navigation__status">Currently viewing</span>
                                    <h3 class="fu-block-navigation__card-title"><?php echo esc_html($prototype['label']); ?></h3>
                                    <p class="fu-block-navigation__card-description"><?php echo esc_html($prototype['description']); ?></p>
                                </div>
                            <?php else : ?>
                                <a class="fu-block-navigation__card fu-block-navigation__card--link" href="<?php echo esc_url($resolve_prototype_url($key)); ?>">
                                    <h3 class="fu-block-navigation__card-title"><?php echo esc_html($prototype['label']); ?></h3>
                                    <p class="fu-block-navigation__card-description"><?php echo esc_html($prototype['description']); ?></p>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </div>
</section>
