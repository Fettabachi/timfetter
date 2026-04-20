<?php

$heading = trim((string) get_field('heading'));
$intro_text = trim((string) get_field('intro_text'));
$cta_label = trim((string) get_field('cta_label'));
$empty_message = trim((string) get_field('empty_message'));

if ($cta_label === '') {
    $cta_label = 'View Item';
}

if ($empty_message === '') {
    $empty_message = 'No items found.';
}

$show_excerpt = fu_filtered_content_grid_normalize_boolean(get_field('show_excerpt'), true);
$item_count = fu_filtered_content_grid_normalize_count(get_field('item_count'), 12);

$source_settings = fu_filtered_content_grid_get_source_settings();
$terms = fu_filtered_content_grid_get_terms($source_settings['taxonomy']);
$initial_query = fu_filtered_content_grid_get_posts($source_settings, 0, $item_count);
$block_id = !empty($block['anchor']) ? sanitize_title($block['anchor']) : wp_unique_id('fu-filtered-content-grid-');
$transition_scope = sanitize_html_class($block_id . '-results');
$block_classes = ['fu-filtered-content-grid'];

if (!empty($block['className'])) {
    $block_classes[] = $block['className'];
}

if (!empty($block['align'])) {
    $block_classes[] = 'align' . $block['align'];
}

$config = [
    'endpoint' => rest_url('wp/v2/' . $source_settings['rest_base']),
    'taxonomy' => $source_settings['taxonomy'],
    'itemCount' => $item_count,
    'showExcerpt' => $show_excerpt,
    'ctaLabel' => $cta_label,
    'emptyMessage' => $empty_message,
    'transitionScope' => $transition_scope,
    'allLabel' => 'All',
];

$initial_markup = fu_filtered_content_grid_render_results(
    $initial_query,
    [
        'cta_label' => $cta_label,
        'show_excerpt' => $show_excerpt,
        'empty_message' => $empty_message,
        'transition_scope' => $transition_scope,
    ]
);
?>

<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr(implode(' ', array_filter($block_classes))); ?>"
    data-fu-filtered-content-grid
    data-fu-filtered-config="<?php echo esc_attr(wp_json_encode($config)); ?>"
    x-data="fuFilteredContentGridFactory()"
    x-init="init()">
    <?php if ($heading || $intro_text) : ?>
        <div class="fu-filtered-content-grid__intro">
            <?php if ($heading) : ?>
                <h2 class="fu-filtered-content-grid__heading"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php if ($intro_text) : ?>
                <div class="fu-filtered-content-grid__copy"><?php echo wp_kses_post(wpautop($intro_text)); ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="fu-filtered-content-grid__filters" aria-label="Filter content" data-grid-filters>
        <button class="fu-filtered-content-grid__filter is-active" type="button" data-filter-term="0" aria-pressed="true" x-on:click.prevent="filter(0)">
            All
        </button>
        <?php foreach ($terms as $term) : ?>
            <button class="fu-filtered-content-grid__filter" type="button" data-filter-term="<?php echo esc_attr((string) $term->term_id); ?>" aria-pressed="false" x-on:click.prevent="filter(<?php echo esc_attr((string) $term->term_id); ?>)">
                <?php echo esc_html($term->name); ?>
            </button>
        <?php endforeach; ?>
    </div>

    <div class="fu-filtered-content-grid__results-wrap">
        <p class="fu-filtered-content-grid__status" data-grid-status aria-live="polite"></p>
        <div
            class="fu-filtered-content-grid__results"
            data-grid-results
            aria-busy="false"
            style="view-transition-name: <?php echo esc_attr($transition_scope); ?>;">
            <?php echo $initial_markup; ?>
        </div>
    </div>
</section>