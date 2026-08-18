<?php
/**
 * Structured Mission Control case study.
 *
 * @package Tim_Fetter_Portfolio
 */

$live_link = isset($args['live_link']) && is_array($args['live_link'])
    ? $args['live_link']
    : array();

$resolve_attachment_id = static function ($slug) {
    $attachments = get_posts(array(
        'name'           => $slug,
        'post_type'      => 'attachment',
        'post_status'    => 'inherit',
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ));

    return !empty($attachments) ? (int) $attachments[0] : 0;
};

$images = array(
    'starting_point' => array(
        'id'      => $resolve_attachment_id('codex-starting-point'),
        'alt'     => 'Initial Mission Control dashboard with colorful priority cards and a five-column task board.',
        'label'   => 'Initial generated dashboard',
        'caption' => 'First working interpretation of the supplied moodboard and workshop brief.',
    ),
    'first_refinement' => array(
        'id'      => $resolve_attachment_id('first-refinement'),
        'alt'     => 'Refined Mission Control dashboard with reduced visual weight and clearer source and status cues.',
        'label'   => 'First UI/UX refinement',
        'caption' => 'Reduced visual weight, clearer source and status cues, and a more responsive task board.',
    ),
    'interaction_model' => array(
        'id'      => $resolve_attachment_id('interaction-design'),
        'alt'     => 'Mission Control task editor displayed in an off-canvas panel beside the dashboard.',
        'label'   => 'Off-canvas task editing',
        'caption' => 'Context-preserving task editing without leaving the dashboard.',
    ),
    'final_result' => array(
        'id'      => $resolve_attachment_id('mission-control-final'),
        'alt'     => 'Final Mission Control dashboard with a refined Today overview and work board.',
        'label'   => 'Final refined prototype',
        'caption' => 'Neutral overview surfaces, clearer hierarchy, and a more focused workday flow.',
    ),
);

$render_figure = static function ($image, $framed = false) {
    if (empty($image['id'])) {
        return;
    }

    $figure_classes = 'fu-mission-control-figure';

    if ($framed) {
        $figure_classes .= ' fu-mission-control-figure--framed';
    }
    ?>
    <figure class="<?php echo esc_attr($figure_classes); ?>">
        <div class="fu-mission-control-figure__media">
            <?php
            echo wp_get_attachment_image(
                $image['id'],
                'large',
                false,
                array(
                    'alt'      => $image['alt'],
                    'loading'  => 'lazy',
                    'decoding' => 'async',
                )
            );
            ?>
        </div>
        <figcaption class="fu-mission-control-figure__caption">
            <span class="fu-eyebrow fu-eyebrow--compact"><?php echo esc_html($image['label']); ?></span>
            <span class="fu-mission-control-figure__caption-text"><?php echo esc_html($image['caption']); ?></span>
        </figcaption>
    </figure>
    <?php
};
?>

<div class="fu-section-body fu-mission-control-case-study">
    <section class="fu-mission-control-section" aria-labelledby="mission-control-overview-heading">
        <h2 class="fu-section-heading fu-section-heading--compact" id="mission-control-overview-heading">Overview</h2>
        <p>Mission Control is a responsive workday dashboard that brings priorities, calendar events, deadlines, messages awaiting a response, dependencies, and tasks into one focused interface. The prototype uses fictional Slack, Gmail, Calendar, and GitHub data rather than connecting to real accounts.</p>
        <p>The project began during master.dev's <em>Agentic Frontend Development with OpenAI Codex</em> workshop, hosted with Katia Gil Guzman from OpenAI. The workshop provided the initial prompt, fixture data, moodboard, and starter materials used to kick off the project. After Codex generated the first working dashboard, I continued developing it through hands-on UI/UX review, responsive and accessibility testing, and iterative refinement with Codex.</p>
    </section>

    <section class="fu-mission-control-section" aria-labelledby="mission-control-starting-point-heading">
        <h2 class="fu-section-heading fu-section-heading--compact" id="mission-control-starting-point-heading">Generated Starting Point</h2>
        <p>The first generated version translated the supplied moodboard into a playful bento layout with bold colors, rounded surfaces, and generous spacing. It established the core dashboard successfully, but testing it in the browser revealed opportunities to improve hierarchy, density, responsiveness, and how color communicated meaning.</p>
        <?php $render_figure($images['starting_point']); ?>
    </section>

    <section class="fu-mission-control-section" aria-labelledby="mission-control-first-refinement-heading">
        <h2 class="fu-section-heading fu-section-heading--compact" id="mission-control-first-refinement-heading">First Refinement</h2>
        <p>I reduced the visual weight of the branding and priority cards so the workday content became the focus. The task board moved to more neutral surfaces, while color shifted into smaller status indicators and source labels where it carried useful information. Search was added, and the five-column board was redesigned to reflow across desktop, tablet, and mobile layouts.</p>
        <p>The result retained the softer shapes and personality of the original visual direction while making the interface calmer and easier to scan.</p>
        <?php $render_figure($images['first_refinement']); ?>
    </section>

    <section class="fu-mission-control-section" aria-labelledby="mission-control-interaction-heading">
        <h2 class="fu-section-heading fu-section-heading--compact" id="mission-control-interaction-heading">Improving the Interaction Model</h2>
        <p>Task editing evolved from centered dialogs into contextual off-canvas panels that preserve the dashboard behind them. Add and Edit task actions use the same interaction pattern, while read-only content such as replies and calendar details expands within the dashboard instead of unnecessarily opening an editing interface.</p>
        <p>These changes kept actions connected to their original context and reduced the number of interaction patterns someone has to learn.</p>
        <?php $render_figure($images['interaction_model'], true); ?>
    </section>

    <section class="fu-mission-control-section" aria-labelledby="mission-control-hierarchy-heading">
        <h2 class="fu-section-heading fu-section-heading--compact" id="mission-control-hierarchy-heading">Rethinking the Workday Hierarchy</h2>
        <p>As the dashboard evolved, I reorganized the Today overview around the questions someone is likely to ask at the beginning of a workday: What should I work on? Where do I need to be? What is due? What am I waiting for? Who needs something from me?</p>
        <p>That thinking led to the final <strong>Start here</strong>, <strong>On the calendar</strong>, <strong>Deadlines</strong>, <strong>Waiting on</strong>, and <strong>Need replies</strong> hierarchy. Mobile ordering was considered separately so important information remains prioritized when the desktop layout collapses.</p>
    </section>

    <section class="fu-mission-control-section fu-mission-control-section--final" aria-labelledby="mission-control-final-heading">
        <h2 class="fu-section-heading fu-section-heading--compact" id="mission-control-final-heading">Final Result</h2>
        <?php $render_figure($images['final_result']); ?>
        <p>The finished prototype preserves the character and core structure of the generated starting point while making the interface more focused, responsive, and consistent. Later refinements addressed keyboard focus, scroll behavior, task persistence, source links, read-only calendar behavior, and other details that became apparent through browser testing.</p>
        <p>Mission Control demonstrates how I approach an existing implementation: preserve what works, identify specific usability and interface problems, test changes in context, and continue refining until the experience feels coherent across screen sizes and interaction methods.</p>

        <?php if (!empty($live_link['url'])) : ?>
            <div class="fu-portfolio__actions fu-mission-control__closing-actions">
                <a
                    class="fu-portfolio__button fu-portfolio__button--primary"
                    href="<?php echo esc_url($live_link['url']); ?>"
                    <?php if (!empty($live_link['target'])) : ?>target="<?php echo esc_attr($live_link['target']); ?>"<?php endif; ?>
                    <?php if (!empty($live_link['target']) && $live_link['target'] === '_blank') : ?>rel="noopener noreferrer"<?php endif; ?>>View Live Prototype</a>
            </div>
        <?php endif; ?>
    </section>
</div>
