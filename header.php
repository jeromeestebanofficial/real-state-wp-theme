<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package Figma_Custom_Theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e('Skip to content', 'figma-custom-theme'); ?>
    </a>

    <header id="masthead" class="site-header">
        <!-- Top Banner -->
        <div class="header-banner">
            <div class="container">
                ✨<?php echo esc_html__('Discover Your Dream Property with Estatein', 'figma-custom-theme'); ?>
                <a href="#about" class="banner-link">
                    <?php echo esc_html__('Learn More', 'figma-custom-theme'); ?>
                </a>
            </div>
        </div>

        <!-- Main Header -->
        <div class="header-main">
            <div class="container">
                <div class="header-content">
                    <div class="site-logo">
                        <?php
                        if (has_custom_logo()) :
                            the_custom_logo();
                        else :
                            ?>
                            <div class="logo-icon">
                                <!-- Estatein Logo Icon -->
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                    <rect width="24" height="24" fill="currentColor"/>
                                    <rect x="24" width="24" height="24" fill="currentColor"/>
                                    <rect y="24" width="24" height="24" fill="currentColor"/>
                                    <rect x="24" y="24" width="24" height="24" fill="currentColor"/>
                                </svg>
                            </div>
                            <?php
                        endif;

                        if (is_front_page() && is_home()) :
                            ?>
                            <h1 class="site-title">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </h1>
                            <?php
                        else :
                            ?>
                            <p class="site-title">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </p>
                            <?php
                        endif;
                        ?>
                    </div><!-- .site-logo -->

                    <nav id="site-navigation" class="main-navigation">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'primary',
                                'menu_id'        => 'primary-menu',
                                'menu_class'     => 'nav-menu',
                                'container'      => false,
                                'fallback_cb'    => 'figma_custom_theme_default_menu',
                            )
                        );
                        ?>
                        
                        <?php
                        // Add About Us link
                        $about_page = get_page_by_path('about');
                        $about_url = home_url('/about/');
                        $about_class = 'nav-link-about';
                        
                        // Check if we're on the about page
                        if (is_page('about') || (is_page() && get_queried_object() && get_queried_object()->post_name === 'about')) {
                            $about_class .= ' current_page_item';
                        }
                        
                        // Use page permalink if page exists, otherwise use direct URL
                        if ($about_page) {
                            $about_url = get_permalink($about_page->ID);
                        }
                        ?>
                        
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn-outline">
                            <?php echo esc_html__('Contact Us', 'figma-custom-theme'); ?>
                        </a>
                    </nav><!-- #site-navigation -->

                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle Menu', 'figma-custom-theme'); ?>">
                        <span class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                        <span class="sr-only"><?php esc_html_e('Toggle Menu', 'figma-custom-theme'); ?></span>
                    </button>
                </div>
            </div>
        </div>
    </header><!-- #masthead -->
