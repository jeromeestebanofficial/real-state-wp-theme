<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Figma_Custom_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">
            <div class="main-content">
                <section class="error-404 not-found">
                    <header class="page-header">
                        <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'figma-custom-theme'); ?></h1>
                    </header><!-- .page-header -->

                    <div class="page-content">
                        <div class="error-404-content">
                            <div class="error-number">
                                <span>404</span>
                            </div>
                            
                            <div class="error-message">
                                <h2><?php esc_html_e('Page Not Found', 'figma-custom-theme'); ?></h2>
                                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'figma-custom-theme'); ?></p>
                            </div>
                        </div>

                        <div class="error-404-search">
                            <?php get_search_form(); ?>
                        </div>

                        <div class="error-404-widgets">
                            <div class="widget-area">
                                <aside class="widget">
                                    <h2 class="widget-title"><?php esc_html_e('Most Used Categories', 'figma-custom-theme'); ?></h2>
                                    <ul>
                                        <?php
                                        wp_list_categories(
                                            array(
                                                'orderby'    => 'count',
                                                'order'      => 'DESC',
                                                'show_count' => 1,
                                                'title_li'   => '',
                                                'number'     => 10,
                                            )
                                        );
                                        ?>
                                    </ul>
                                </aside>

                                <aside class="widget">
                                    <h2 class="widget-title"><?php esc_html_e('Recent Posts', 'figma-custom-theme'); ?></h2>
                                    <ul>
                                        <?php
                                        $recent_posts = wp_get_recent_posts(array(
                                            'numberposts' => 5,
                                            'post_status' => 'publish'
                                        ));
                                        foreach ($recent_posts as $recent) {
                                            echo '<li><a href="' . get_permalink($recent['ID']) . '">' . $recent['post_title'] . '</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </aside>

                                <aside class="widget">
                                    <h2 class="widget-title"><?php esc_html_e('Archives', 'figma-custom-theme'); ?></h2>
                                    <ul>
                                        <?php wp_get_archives(array('type' => 'monthly')); ?>
                                    </ul>
                                </aside>

                                <aside class="widget">
                                    <h2 class="widget-title"><?php esc_html_e('Tag Cloud', 'figma-custom-theme'); ?></h2>
                                    <?php
                                    wp_tag_cloud(
                                        array(
                                            'smallest' => 1,
                                            'largest'  => 1,
                                            'unit'     => 'em',
                                            'format'   => 'flat',
                                        )
                                    );
                                    ?>
                                </aside>
                            </div>
                        </div>
                    </div><!-- .page-content -->
                </section><!-- .error-404 -->
            </div>

            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
