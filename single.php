<?php
/**
 * The template for displaying all single posts
 *
 * @package Estatein_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">
            <div class="main-content">
                <?php while (have_posts()) : ?>
                    <?php the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('post single-post'); ?>>
                        <header class="entry-header">
                            <?php the_title('<h1 class="post-title">', '</h1>'); ?>
                            
                            <div class="post-meta">
                                <span class="posted-on">
                                    <?php echo esc_html__('Posted on', 'estatein-theme'); ?>
                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo esc_html(get_the_date()); ?>
                                    </time>
                                </span>
                                <span class="byline">
                                    <?php echo esc_html__('by', 'estatein-theme'); ?>
                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                        <?php echo esc_html(get_the_author()); ?>
                                    </a>
                                </span>
                                <?php if (has_category()) : ?>
                                    <span class="cat-links">
                                        <?php echo esc_html__('in', 'estatein-theme'); ?>
                                        <?php the_category(', '); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <div class="post-content">
                            <?php
                            the_content(
                                sprintf(
                                    wp_kses(
                                        /* translators: %s: Name of current post. Only visible to screen readers */
                                        __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'estatein-theme'),
                                        array(
                                            'span' => array(
                                                'class' => array(),
                                            ),
                                        )
                                    ),
                                    wp_kses_post(get_the_title())
                                )
                            );

                            wp_link_pages(
                                array(
                                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'estatein-theme'),
                                    'after'  => '</div>',
                                )
                            );
                            ?>
                        </div>

                        <footer class="entry-footer">
                            <?php
                            $tags_list = get_the_tag_list('', ', ');
                            if ($tags_list) {
                                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'estatein-theme') . '</span>', $tags_list);
                            }
                            ?>
                        </footer>
                    </article>

                    <?php
                    // Post navigation
                    the_post_navigation(
                        array(
                            'prev_text'                  => '<span class="nav-subtitle">' . esc_html__('Previous:', 'estatein-theme') . '</span> <span class="nav-title">%title</span>',
                            'next_text'                  => '<span class="nav-subtitle">' . esc_html__('Next:', 'estatein-theme') . '</span> <span class="nav-title">%title</span>',
                        )
                    );

                    // If comments are open or we have at least one comment, load up the comment template
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; ?>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
