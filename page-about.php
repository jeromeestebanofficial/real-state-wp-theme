<?php
/**
 * Template for displaying About Us page
 * 
 * This template automatically applies to pages with slug "about"
 *
 * @package Estatein_Theme
 */

get_header();
?>

<main id="primary" class="site-main about-page">
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Our Journey Section -->
        <?php get_template_part('template-parts/about/journey-section'); ?>
        
        <!-- Our Values Section -->
        <?php get_template_part('template-parts/about/values-section'); ?>
        
        <!-- Our Achievements Section -->
        <?php get_template_part('template-parts/about/achievements-section'); ?>
        
        <!-- How It Works / Process Section -->
        <?php get_template_part('template-parts/about/process-section'); ?>
        
        <!-- Team Section -->
        <?php get_template_part('template-parts/about/team-section'); ?>
        
        <!-- Valued Clients Section -->
        <?php get_template_part('template-parts/about/clients-section'); ?>
        
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>

