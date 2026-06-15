<?php

/**
 * Template for single Resource posts
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();

$terms = get_the_terms(get_the_ID(), 'resource_category');
$primary_term = ($terms && ! is_wp_error($terms)) ? $terms[0] : null;

if (! function_exists('fu_resource_single_add_heading_id')) {
    function fu_resource_single_add_heading_id($heading_html, $heading_id)
    {
        $heading_html = (string) $heading_html;
        $heading_id   = sanitize_title($heading_id);

        if ($heading_id === '') {
            return $heading_html;
        }

        if (! preg_match('/<h2\b([^>]*)>/i', $heading_html, $matches)) {
            return $heading_html;
        }

        $attributes = preg_replace('/\s+id=(["\']).*?\1/i', '', $matches[1]);

        return preg_replace(
            '/<h2\b[^>]*>/i',
            '<h2' . $attributes . ' id="' . esc_attr($heading_id) . '">',
            $heading_html,
            1
        );
    }
}

if (! function_exists('fu_resource_single_parse_content')) {
    function fu_resource_single_parse_content($content)
    {
        $content = trim((string) $content);

        if ($content === '') {
            return [
                'intro'    => '',
                'sections' => [],
            ];
        }

        $parts = preg_split(
            '/(<h2\b[^>]*>.*?<\/h2>)/is',
            $content,
            -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );

        if (! $parts) {
            return [
                'intro'    => $content,
                'sections' => [],
            ];
        }

        $intro          = '';
        $sections       = [];
        $current        = null;
        $used_heading_ids = [];
        $highlighted_panel_headings = [
            'quality check',
            'how this can provide value to agencies',
            'how this can provide value to clients',
        ];

        foreach ($parts as $part) {
            if (preg_match('/^<h2\b[^>]*>.*?<\/h2>$/is', trim($part))) {
                if ($current) {
                    $sections[] = $current;
                }

                $heading_text = trim(wp_strip_all_tags($part));
                $heading_id_base = sanitize_title($heading_text);

                if ($heading_id_base === '') {
                    $heading_id_base = 'resource-section';
                }

                $heading_id = $heading_id_base;
                $heading_id_index = 2;

                while (isset($used_heading_ids[$heading_id])) {
                    $heading_id = $heading_id_base . '-' . $heading_id_index;
                    $heading_id_index++;
                }

                $used_heading_ids[$heading_id] = true;

                $current = [
                    'id'         => $heading_id,
                    'title'      => $heading_text,
                    'heading'    => fu_resource_single_add_heading_id($part, $heading_id),
                    'content'    => '',
                    'is_quality' => in_array(strtolower($heading_text), $highlighted_panel_headings, true),
                ];

                continue;
            }

            if ($current) {
                $current['content'] .= $part;
            } else {
                $intro .= $part;
            }
        }

        if ($current) {
            $sections[] = $current;
        }

        return [
            'intro'    => trim($intro),
            'sections' => $sections,
        ];
    }
}

if (! function_exists('fu_resource_single_get_format_label')) {
    function fu_resource_single_get_format_label($primary_term)
    {
        $term_name = $primary_term ? $primary_term->name : '';
        $formats = [
            'checklists' => 'Checklist',
            'guides'     => 'Guide',
            'templates'  => 'Template',
            'tools'      => 'Toolkit',
            'tutorials'  => 'Tutorial',
        ];

        return $formats[strtolower($term_name)] ?? 'Resource';
    }
}

if (! function_exists('fu_resource_single_get_first_use_case')) {
    function fu_resource_single_get_first_use_case($sections)
    {
        foreach ($sections as $section) {
            if (strcasecmp($section['title'], 'Use this when') !== 0) {
                continue;
            }

            if (! preg_match('/<li\b[^>]*>(.*?)<\/li>/is', $section['content'], $matches)) {
                return '';
            }

            return trim(html_entity_decode(wp_strip_all_tags($matches[1]), ENT_QUOTES, get_bloginfo('charset')));
        }

        return '';
    }
}

if (! function_exists('fu_resource_single_get_further_reading_links')) {
    function fu_resource_single_get_further_reading_links()
    {
        if (! function_exists('get_field')) {
            return [];
        }

        $rows = get_field('further_reading_links');

        if (! is_array($rows)) {
            return [];
        }

        $links = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $title = trim((string) ($row['link_title'] ?? ''));
            $url = trim((string) ($row['url'] ?? ''));
            $source = trim((string) ($row['source_label'] ?? ''));
            $description = trim((string) ($row['short_description'] ?? ''));

            if ($title === '' || $url === '' || $source === '') {
                continue;
            }

            $links[] = [
                'title'       => $title,
                'url'         => $url,
                'source'      => $source,
                'description' => $description,
            ];
        }

        return $links;
    }
}

$related_args = [
    'post_type'      => 'resource',
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
];

if ($primary_term) {
    $related_args['tax_query'] = [
        [
            'taxonomy' => 'resource_category',
            'field'    => 'term_id',
            'terms'    => $primary_term->term_id,
        ],
    ];
}

$related_resources = new WP_Query($related_args);
$resource_content = apply_filters('the_content', get_the_content());
$resource_content_parts = fu_resource_single_parse_content($resource_content);
$resource_sections = $resource_content_parts['sections'];
$resource_further_reading_links = fu_resource_single_get_further_reading_links();
$resource_glance_items = [
    [
        'label' => 'Resource type',
        'value' => $primary_term ? $primary_term->name : '',
    ],
    [
        'label' => 'Best for',
        'value' => fu_resource_single_get_first_use_case($resource_sections),
    ],
    [
        'label' => 'Format',
        'value' => fu_resource_single_get_format_label($primary_term),
    ],
];
$resource_glance_items = array_filter(
    $resource_glance_items,
    function ($item) {
        return trim((string) $item['value']) !== '';
    }
);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-resource-single'); ?>>
    <div class="container">
        <div class="fu-resource-single__inner">

            <nav class="fu-resource-single__back" aria-label="Back navigation">
                <a href="<?php echo esc_url(home_url('/filtered-content-grid/')); ?>">← Back to Resource Library</a>
            </nav>

            <header class="fu-resource-single__hero">
                <?php if ($terms && ! is_wp_error($terms)) : ?>
                    <div class="fu-resource-single__terms">
                        <?php foreach ($terms as $term) : ?>
                            <span class="fu-resource-single__term"><?php echo esc_html($term->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <h1 class="fu-resource-single__title"><?php the_title(); ?></h1>

                <?php if (has_excerpt()) : ?>
                    <div class="fu-resource-single__excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>

                <?php if (has_post_thumbnail()) : ?>
                    <figure class="fu-resource-single__media">
                        <?php the_post_thumbnail('large'); ?>
                    </figure>
                <?php endif; ?>
            </header>

            <?php if (! empty($resource_glance_items)) : ?>
                <div class="fu-resource-single__glance" aria-label="Resource summary">
                    <?php foreach ($resource_glance_items as $item) : ?>
                        <div class="fu-resource-single__glance-item">
                            <span class="fu-resource-single__glance-label"><?php echo esc_html($item['label']); ?></span>
                            <span class="fu-resource-single__glance-value"><?php echo esc_html($item['value']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (! empty($resource_sections)) : ?>
                <nav class="fu-resource-single__section-nav" aria-label="Resource section navigation">
                    <p class="fu-resource-single__section-nav-label">Jump to sections</p>
                    <div class="fu-resource-single__section-nav-links">
                        <?php foreach ($resource_sections as $section) : ?>
                            <a href="#<?php echo esc_attr($section['id']); ?>"><?php echo esc_html($section['title']); ?></a>
                        <?php endforeach; ?>
                        <?php if (! empty($resource_further_reading_links)) : ?>
                            <a href="#resource-further-reading-heading">Further reading</a>
                        <?php endif; ?>
                    </div>
                </nav>
            <?php endif; ?>

            <div class="fu-resource-single__content-wrap">
                <div class="fu-resource-single__content">
                    <?php
                    if ($resource_content_parts['intro']) :
                    ?>
                        <div class="fu-resource-single__intro">
                            <?php echo $resource_content_parts['intro']; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (! empty($resource_sections)) : ?>
                        <div class="fu-resource-single__sections">
                            <?php foreach ($resource_sections as $section) : ?>
                                <section class="fu-resource-single__panel<?php echo $section['is_quality'] ? ' fu-resource-single__panel--quality' : ''; ?>" aria-labelledby="<?php echo esc_attr($section['id']); ?>">
                                    <?php echo $section['heading']; ?>

                                    <?php if (trim($section['content']) !== '') : ?>
                                        <div class="fu-resource-single__panel-body">
                                            <?php echo $section['content']; ?>
                                        </div>
                                    <?php endif; ?>
                                </section>
                            <?php endforeach; ?>
                        </div>
                    <?php elseif (! $resource_content_parts['intro']) : ?>
                        <?php echo $resource_content; ?>
                    <?php endif; ?>

                    <?php

                    wp_link_pages(
                        [
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'tim-fetter-portfolio'),
                            'after'  => '</div>',
                        ]
                    );
                    ?>
                </div>
            </div>

            <?php if (! empty($resource_further_reading_links)) : ?>
                <section class="fu-resource-single__further-reading" aria-labelledby="resource-further-reading-heading">
                    <div class="fu-resource-single__further-reading-head">
                        <p class="fu-eyebrow">Trusted references</p>
                        <h2 id="resource-further-reading-heading">Further reading</h2>
                        <p>A few trusted references for teams that want to go deeper.</p>
                    </div>

                    <div class="fu-resource-single__further-reading-grid">
                        <?php foreach ($resource_further_reading_links as $link) : ?>
                            <article class="fu-resource-single__further-reading-card">
                                <a class="fu-resource-single__further-reading-link" href="<?php echo esc_url($link['url']); ?>" target="_blank" rel="noopener noreferrer">
                                    <span class="fu-resource-single__further-reading-source"><?php echo esc_html($link['source']); ?></span>
                                    <span class="fu-resource-single__further-reading-title"><?php echo esc_html($link['title']); ?></span>

                                    <?php if ($link['description'] !== '') : ?>
                                        <span class="fu-resource-single__further-reading-description"><?php echo esc_html($link['description']); ?></span>
                                    <?php endif; ?>

                                    <span class="fu-resource-single__further-reading-action" aria-hidden="true">Visit reference ↗</span>
                                    <span class="screen-reader-text"> opens external site</span>
                                </a>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($related_resources->have_posts()) : ?>
                <section class="fu-resource-single__related">
                    <div class="fu-resource-single__related-head">
                        <p class="fu-eyebrow">Related Resources</p>
                        <h2>You might also find these useful</h2>
                    </div>

                    <div class="fu-resource-single__related-grid">
                        <?php while ($related_resources->have_posts()) : $related_resources->the_post(); ?>
                            <article class="fu-resource-single__related-card">
                                <a class="fu-resource-single__related-card-link" href="<?php echo esc_url(get_permalink()); ?>">
                                    <h3><?php echo esc_html(get_the_title()); ?></h3>

                                    <?php if (has_excerpt()) : ?>
                                        <div class="fu-resource-single__related-excerpt">
                                            <?php echo wp_kses_post(wpautop(get_the_excerpt())); ?>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            </article>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                </section>
            <?php endif; ?>

        </div>
    </div>
</article>

<?php
get_footer();
