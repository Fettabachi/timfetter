<?php
/**
 * Contextual navigation for featured WordPress system pages.
 *
 * @package Tim_Fetter_Portfolio
 */

$current = isset($args['current']) ? sanitize_key($args['current']) : '';

$systems = array(
    'acf-block-system'  => array(
        'label'       => 'ACF Block System Overview',
        'description' => 'A broader look at the block system approach, including reusable patterns, structured content, and safer handoff.',
    ),
    'editor-experience' => array(
        'label'       => 'Editor Experience & Handoff',
        'description' => 'How blocks are structured so editors can make real updates without breaking layout, accessibility, or the front end.',
    ),
);

if (! isset($systems[$current])) {
    return;
}

$resolve_system_url = static function ($slug) {
    $page = get_page_by_path($slug);

    return $page ? get_permalink($page) : home_url('/' . trim((string) $slug, '/') . '/');
};

$system_keys   = array_keys($systems);
$current_index = array_search($current, $system_keys, true);
$previous_key  = $current_index > 0 ? $system_keys[$current_index - 1] : '';
$next_key      = $current_index < count($system_keys) - 1 ? $system_keys[$current_index + 1] : '';
?>

<section class="fu-block-navigation fu-wordpress-system-navigation" aria-labelledby="fu-wordpress-system-navigation-heading">
    <div class="container container--page">
        <div class="fu-block-navigation__inner">
            <nav class="fu-block-navigation__pager" aria-label="Previous and next featured WordPress systems">
                <?php if ($previous_key !== '') : ?>
                    <a class="fu-block-navigation__pager-link fu-block-navigation__pager-link--previous" href="<?php echo esc_url($resolve_system_url($previous_key)); ?>">
                        <span class="fu-block-navigation__pager-kicker">&larr; Previous system</span>
                        <span class="fu-block-navigation__pager-title"><?php echo esc_html($systems[$previous_key]['label']); ?></span>
                    </a>
                <?php else : ?>
                    <span class="fu-block-navigation__pager-spacer" aria-hidden="true"></span>
                <?php endif; ?>

                <?php if ($next_key !== '') : ?>
                    <a class="fu-block-navigation__pager-link fu-block-navigation__pager-link--next" href="<?php echo esc_url($resolve_system_url($next_key)); ?>">
                        <span class="fu-block-navigation__pager-kicker">Next system &rarr;</span>
                        <span class="fu-block-navigation__pager-title"><?php echo esc_html($systems[$next_key]['label']); ?></span>
                    </a>
                <?php else : ?>
                    <span class="fu-block-navigation__pager-spacer" aria-hidden="true"></span>
                <?php endif; ?>
            </nav>

            <div class="fu-block-navigation__header">
                <p class="fu-eyebrow">Featured WordPress systems</p>
                <h2 id="fu-wordpress-system-navigation-heading" class="fu-block-navigation__heading">Explore more WordPress systems</h2>
                <p class="fu-block-navigation__intro">
                    Larger WordPress examples showing how reusable blocks, editor workflows, and structured templates can work together as a maintainable site-building system.
                </p>
            </div>

            <nav class="fu-block-navigation__collection" aria-label="Featured WordPress system collection">
                <ul class="fu-block-navigation__grid">
                    <?php foreach ($systems as $key => $system) : ?>
                        <li class="fu-block-navigation__item">
                            <?php if ($key === $current) : ?>
                                <div class="fu-block-navigation__card fu-block-navigation__card--current" aria-current="page">
                                    <span class="fu-block-navigation__status">Currently viewing</span>
                                    <h3 class="fu-block-navigation__card-title"><?php echo esc_html($system['label']); ?></h3>
                                    <p class="fu-block-navigation__card-description"><?php echo esc_html($system['description']); ?></p>
                                </div>
                            <?php else : ?>
                                <a class="fu-block-navigation__card fu-block-navigation__card--link" href="<?php echo esc_url($resolve_system_url($key)); ?>">
                                    <h3 class="fu-block-navigation__card-title"><?php echo esc_html($system['label']); ?></h3>
                                    <p class="fu-block-navigation__card-description"><?php echo esc_html($system['description']); ?></p>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </div>
</section>
