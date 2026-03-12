<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * @package Estatein_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">
            <div class="main-content">
                <?php if (have_posts()) : ?>

                    <header class="page-header">
                        <?php
                        the_archive_title('<h1 class="page-title">', '</h1>');
                        the_archive_description('<div class="archive-description">', '</div>');
                        ?>
                    </header><!-- .page-header -->

                    <div class="posts-grid">
                        <?php while (have_posts()) : ?>
                            <?php the_post(); ?>

                            <article id="post-<?php the_ID(); ?>" <?php post_class('post archive-post'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <header class="entry-header">
                                    <?php
                                    the_title('<h2 class="post-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                    ?>

                                    <?php if ('post' === get_post_type()) : ?>
                                        <div class="post-meta">
                                            <span class="posted-on">
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
                                        </div>
                                    <?php endif; ?>
                                </header>

                                <div class="post-content">
                                    <?php the_excerpt(); ?>
                                    <p>
                                        <a href="<?php echo esc_url(get_permalink()); ?>" class="read-more">
                                            <?php echo esc_html__('Read More', 'estatein-theme'); ?>
                                        </a>
                                    </p>
                                </div>

                                <footer class="entry-footer">
                                    <?php
                                    $categories_list = get_the_category_list(', ');
                                    if ($categories_list) {
                                        echo '<span class="cat-links">' . esc_html__('Categories:', 'estatein-theme') . ' ' . $categories_list . '</span>';
                                    }
                                    ?>
                                </footer>
                            </article>

                        <?php endwhile; ?>
                    </div>

                    <?php
                    // Archive pagination
                    the_posts_pagination(array(
                        'prev_text' => esc_html__('Previous', 'estatein-theme'),
                        'next_text' => esc_html__('Next', 'estatein-theme'),
                    ));
                    ?>

                <?php else : ?>

                    <section class="no-results not-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php esc_html_e('Nothing here', 'estatein-theme'); ?></h1>
                        </header>

                        <div class="page-content">
                            <p><?php esc_html_e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'estatein-theme'); ?></p>
                            <?php get_search_form(); ?>
                        </div>
                    </section>

                <?php endif; ?>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
