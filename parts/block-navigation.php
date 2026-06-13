<?php
/**
 * Contextual navigation for ACF block case-study pages.
 *
 * @package Tim_Fetter_Portfolio
 */

$current = isset($args['current']) ? sanitize_key($args['current']) : '';

$blocks = array(
    'page-banner'              => array(
        'label'       => 'Page Banner',
        'description' => 'Media-driven hero sections with editor-friendly controls.',
    ),
    'flexible-feature-section' => array(
        'label'       => 'Flexible Feature Section',
        'description' => 'Flexible media and content layouts for reusable page sections.',
    ),
    'filtered-content-grid'    => array(
        'label'       => 'Filtered Content Grid',
        'description' => 'A dynamic resource grid with taxonomy filtering and smooth interactions.',
    ),
    'content-switcher'         => array(
        'label'       => 'Content Switcher',
        'description' => 'Tabbed and accordion-style content patterns with accessible controls.',
    ),
    'comparison-cards'         => array(
        'label'       => 'Comparison Cards',
        'description' => 'Structured comparison layouts for plans, features, and decision points.',
    ),
    'proof-cards'              => array(
        'label'       => 'Proof Cards',
        'description' => 'Reusable testimonial, outcome, and metric cards for credibility sections.',
    ),
);

if (! isset($blocks[$current])) {
    return;
}

$resolve_block_url = static function ($slug) {
    $page = get_page_by_path($slug);

    return $page ? get_permalink($page) : home_url('/' . trim((string) $slug, '/') . '/');
};

$block_keys    = array_keys($blocks);
$current_index = array_search($current, $block_keys, true);
$previous_key  = $current_index > 0 ? $block_keys[$current_index - 1] : '';
$next_key      = $current_index < count($block_keys) - 1 ? $block_keys[$current_index + 1] : '';
?>

<section class="fu-block-navigation" aria-labelledby="fu-block-navigation-heading">
    <div class="container container--page">
        <div class="fu-block-navigation__inner">
            <nav class="fu-block-navigation__pager" aria-label="Previous and next ACF block builds">
                <?php if ($previous_key !== '') : ?>
                    <a class="fu-block-navigation__pager-link fu-block-navigation__pager-link--previous" href="<?php echo esc_url($resolve_block_url($previous_key)); ?>">
                        <span class="fu-block-navigation__pager-kicker">&larr; Previous block</span>
                        <span class="fu-block-navigation__pager-title"><?php echo esc_html($blocks[$previous_key]['label']); ?></span>
                    </a>
                <?php else : ?>
                    <span class="fu-block-navigation__pager-spacer" aria-hidden="true"></span>
                <?php endif; ?>

                <?php if ($next_key !== '') : ?>
                    <a class="fu-block-navigation__pager-link fu-block-navigation__pager-link--next" href="<?php echo esc_url($resolve_block_url($next_key)); ?>">
                        <span class="fu-block-navigation__pager-kicker">Next block &rarr;</span>
                        <span class="fu-block-navigation__pager-title"><?php echo esc_html($blocks[$next_key]['label']); ?></span>
                    </a>
                <?php else : ?>
                    <span class="fu-block-navigation__pager-spacer" aria-hidden="true"></span>
                <?php endif; ?>
            </nav>

            <div class="fu-block-navigation__header">
                <p class="fu-eyebrow">ACF block collection</p>
                <h2 id="fu-block-navigation-heading" class="fu-block-navigation__heading">Explore more ACF block builds</h2>
                <p class="fu-block-navigation__intro">
                    These blocks are part of a reusable WordPress editing system designed for flexible layouts, cleaner handoff, and a better editor experience.
                </p>
            </div>

            <nav class="fu-block-navigation__collection" aria-label="ACF block build collection">
                <ul class="fu-block-navigation__grid">
                    <?php foreach ($blocks as $key => $block) : ?>
                        <li class="fu-block-navigation__item">
                            <?php if ($key === $current) : ?>
                                <div class="fu-block-navigation__card fu-block-navigation__card--current" aria-current="page">
                                    <span class="fu-block-navigation__status">Currently viewing</span>
                                    <h3 class="fu-block-navigation__card-title"><?php echo esc_html($block['label']); ?></h3>
                                    <p class="fu-block-navigation__card-description"><?php echo esc_html($block['description']); ?></p>
                                </div>
                            <?php else : ?>
                                <a class="fu-block-navigation__card fu-block-navigation__card--link" href="<?php echo esc_url($resolve_block_url($key)); ?>">
                                    <h3 class="fu-block-navigation__card-title"><?php echo esc_html($block['label']); ?></h3>
                                    <p class="fu-block-navigation__card-description"><?php echo esc_html($block['description']); ?></p>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </div>
</section>
