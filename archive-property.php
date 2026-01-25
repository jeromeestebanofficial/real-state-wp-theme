<?php
/**
 * The template for displaying property archives
 *
 * @package Figma_Custom_Theme
 */

get_header(); ?>

<main id="primary" class="site-main properties-page">
    <?php
    // Hero/Search Section
    get_template_part('template-parts/properties-hero-section');
    
    // Properties Listing Section
    get_template_part('template-parts/properties-listing-section');
    ?>
</main>

<?php 
// Only show contact form on first page
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
if ($paged == 1) :
    get_template_part('template-parts/properties-contact-section');
endif;

get_footer(); ?>
