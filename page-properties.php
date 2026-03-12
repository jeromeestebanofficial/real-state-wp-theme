<?php
/**
 * Template Name: Properties Page
 * The template for displaying the Properties page
 *
 * @package Figma_Custom_Theme
 */

get_header(); ?>

<main id="primary" class="site-main properties-page">
    <?php
    // Hero/Search Section
    get_template_part('template-parts/properties/hero-section');
    
    // Properties Listing Section
    get_template_part('template-parts/properties/listing-section');
    
    // Contact Form Section
    get_template_part('template-parts/properties/contact-section');
    ?>
</main>

<?php get_footer(); ?>

