<?php
/**
 * Landing Page Template
 * Automatically loads Figma sections
 */
get_header(); ?>

<main id="primary" class="site-main">

    <!-- Hero Section -->
    <?php get_template_part('template-parts/hero-section'); ?>

    <!-- Features Section -->
    <?php get_template_part('template-parts/features-section'); ?>

    <!-- Properties Section -->
    <?php get_template_part('template-parts/properties-section'); ?>

    <!-- Testimonials Section -->
    <?php get_template_part('template-parts/testimonials-section'); ?>

</main>

<?php get_footer(); ?>
