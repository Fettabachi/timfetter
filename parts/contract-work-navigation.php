<?php
/**
 * Contextual navigation for selected contract work case-study pages.
 *
 * @package Tim_Fetter_Portfolio
 */

$current = isset($args['current']) ? sanitize_key($args['current']) : '';

$projects = array(
    'plastic-makers'                         => array(
        'label'       => 'Plastic Makers',
        'description' => 'Elementor-based WordPress support with reusable components, JavaScript widgets, responsive page builds, bug fixes, and production content updates.',
    ),
    'omni-hotels-resorts'                    => array(
        'label'       => 'Omni Hotels & Resorts',
        'description' => 'Contract front-end support for hospitality UI implementation, accessibility fixes, responsive styling, and a custom Special Offers component.',
    ),
    'national-university'                    => array(
        'label'       => 'National University',
        'description' => 'Front-end UI support for enrollment experiences, including a JavaScript-driven Program Finder and Form.io-powered application styling.',
    ),
    'fibroid-foundation'                     => array(
        'label'       => 'Fibroid Foundation',
        'description' => 'Nonprofit WordPress support with Elementor-friendly shortcodes, a donation widget, event listings, blog logic, and responsive updates.',
    ),
    'good-chemistry-lives-here'              => array(
        'label'       => 'Good Chemistry Lives Here',
        'description' => 'Front-end presentation updates including navigation and footer refinements, homepage implementation, and Essential Grid resource styling.',
    ),
    'blackberry-farm-blackberry-mountain'    => array(
        'label'       => 'Blackberry Farm & Blackberry Mountain',
        'description' => 'UI/UX and responsive front-end support for luxury hospitality booking flows, booking bars, calendars, and reservation components.',
    ),
);

if (! isset($projects[$current])) {
    return;
}

$resolve_project_url = static function ($slug) {
    $project = get_page_by_path($slug, OBJECT, 'portfolio-items');

    return $project ? get_permalink($project) : home_url('/work/' . trim((string) $slug, '/') . '/');
};

$project_keys  = array_keys($projects);
$current_index = array_search($current, $project_keys, true);
$previous_key  = $current_index > 0 ? $project_keys[$current_index - 1] : '';
$next_key      = $current_index < count($project_keys) - 1 ? $project_keys[$current_index + 1] : '';
?>

<section class="fu-block-navigation fu-contract-work-navigation" aria-labelledby="fu-contract-work-navigation-heading">
    <div class="container container--page">
        <div class="fu-block-navigation__inner">
            <nav class="fu-block-navigation__pager" aria-label="Previous and next selected contract work projects">
                <?php if ($previous_key !== '') : ?>
                    <a class="fu-block-navigation__pager-link fu-block-navigation__pager-link--previous" href="<?php echo esc_url($resolve_project_url($previous_key)); ?>">
                        <span class="fu-eyebrow fu-eyebrow--compact fu-block-navigation__pager-kicker">&larr; Previous project</span>
                        <span class="fu-block-navigation__pager-title"><?php echo esc_html($projects[$previous_key]['label']); ?></span>
                    </a>
                <?php else : ?>
                    <span class="fu-block-navigation__pager-spacer" aria-hidden="true"></span>
                <?php endif; ?>

                <?php if ($next_key !== '') : ?>
                    <a class="fu-block-navigation__pager-link fu-block-navigation__pager-link--next" href="<?php echo esc_url($resolve_project_url($next_key)); ?>">
                        <span class="fu-eyebrow fu-eyebrow--compact fu-block-navigation__pager-kicker">Next project &rarr;</span>
                        <span class="fu-block-navigation__pager-title"><?php echo esc_html($projects[$next_key]['label']); ?></span>
                    </a>
                <?php else : ?>
                    <span class="fu-block-navigation__pager-spacer" aria-hidden="true"></span>
                <?php endif; ?>
            </nav>

            <div class="fu-block-navigation__header">
                <p class="fu-eyebrow">Selected contract work</p>
                <h2 id="fu-contract-work-navigation-heading" class="fu-block-navigation__heading">Explore more selected contract work</h2>
                <p class="fu-section-lede fu-block-navigation__intro">
                    A few examples of production WordPress and front-end implementation work completed in support of larger client and agency projects.
                </p>
            </div>

            <nav class="fu-block-navigation__collection" aria-label="Selected contract work collection">
                <ul class="fu-block-navigation__grid">
                    <?php foreach ($projects as $key => $project) : ?>
                        <li class="fu-block-navigation__item">
                            <?php if ($key === $current) : ?>
                                <div class="fu-block-navigation__card fu-block-navigation__card--current" aria-current="page">
                                    <span class="fu-eyebrow fu-eyebrow--compact fu-block-navigation__status">Currently viewing</span>
                                    <h3 class="fu-block-navigation__card-title"><?php echo esc_html($project['label']); ?></h3>
                                    <p class="fu-block-navigation__card-description"><?php echo esc_html($project['description']); ?></p>
                                </div>
                            <?php else : ?>
                                <a class="fu-block-navigation__card fu-block-navigation__card--link" href="<?php echo esc_url($resolve_project_url($key)); ?>">
                                    <h3 class="fu-block-navigation__card-title"><?php echo esc_html($project['label']); ?></h3>
                                    <p class="fu-block-navigation__card-description"><?php echo esc_html($project['description']); ?></p>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </div>
</section>
