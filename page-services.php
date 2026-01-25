<?php
/**
 * Template Name: Services Page
 * The template for displaying the Services page
 *
 * @package Figma_Custom_Theme
 */

get_header(); ?>

<main id="primary" class="site-main services-page">
    <?php
    // Hero Section with main service cards
    get_template_part('template-parts/services-hero-section');
    
    // Property Selling Service Section
    get_template_part('template-parts/services-property-selling-section');
    
    // Property Management Service Section
    get_template_part('template-parts/services-property-management-section');
    
    // Investment Advisory Service Section
    get_template_part('template-parts/services-investment-advisory-section');
    ?>
</main>

<?php get_footer(); ?>

