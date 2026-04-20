<?php

/**
 * Component Lab Grid Block Template
 */
$terms = get_terms([
    'taxonomy' => 'lab_category',
    'hide_empty' => true
]);
?>

<div class="fu-lab-grid container" x-data="labFilter()" x-init="init()">

    <div class="fu-lab-filters">
        <button :class="activeCat === 0 ? 'is-active' : ''" @click="filterPosts(0)">All</button>
        <?php foreach ($terms as $term) : ?>
            <button :class="activeCat === <?php echo (int)$term->term_id; ?> ? 'is-active' : ''"
                @click="filterPosts(<?php echo (int)$term->term_id; ?>)">
                <?php echo esc_html($term->name); ?>
            </button>
        <?php endforeach; ?>
    </div>

    <div class="fu-lab-container" :class="loading ? 'is-loading' : ''">
        <template x-for="(post, index) in posts" :key="post.id">
            <div class="fu-lab-card"
                :style="'view-transition-name: card-' + post.id + '; --i: ' + index">

                <div class="fu-lab-card__image">
                    <img :src="post.featured_image_url" :alt="post.title.rendered">
                </div>

                <div class="fu-lab-card__content">
                    <h3 x-html="post.title.rendered"></h3>
                    <div x-html="post.excerpt.rendered"></div>
                    <a :href="post.link" class="btn btn--blue">View Component</a>
                </div>
            </div>
        </template>

        <div x-show="posts.length === 0 && !loading" class="no-results" x-cloak>
            <p>No components found in this category.</p>
        </div>
    </div>

    <script>
        function labFilter() {
            return {
                posts: [],
                activeCat: 0,
                loading: false,
                async init() {
                    await this.filterPosts(0);
                },
                async filterPosts(catId) {
                    this.loading = true;
                    this.activeCat = catId;

                    let url = '/wp-json/wp/v2/fu_lab?per_page=12';
                    if (catId !== 0) url += '&lab_category=' + catId;

                    try {
                        const response = await fetch(url);
                        const newData = await response.json();

                        // 1. Check for API support
                        if (!document.startViewTransition) {
                            this.posts = newData;
                            this.loading = false;
                            return;
                        }

                        // 2. The "Magic" Move
                        // Wrapping the state change here tells the browser: 
                        // "The height is changing AND the cards are moving. Sync them."
                        document.startViewTransition(() => {
                            this.posts = newData;
                            this.loading = false;
                        });

                    } catch (error) {
                        console.error("Filter failed:", error);
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</div>