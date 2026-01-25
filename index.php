<?php
get_header(); ?>

<main id="primary" class="site-main">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php the_excerpt(); ?>
            </article>
        <?php endwhile; ?>

        <?php
        the_posts_pagination([
            'prev_text' => __('Previous', 'figma-custom'),
            'next_text' => __('Next', 'figma-custom'),
        ]);
        ?>

    <?php else : ?>
        <p><?php esc_html_e('No posts found', 'figma-custom'); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
