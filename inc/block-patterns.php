<?php
/**
 * Block Patterns for Figma Custom Theme
 *
 * @package Figma_Custom_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register block patterns
 */
function figma_custom_theme_register_block_patterns() {
    // Check if block patterns are supported
    if (!function_exists('register_block_pattern')) {
        return;
    }

    // Register block pattern category
    register_block_pattern_category(
        'estatein',
        array('label' => esc_html__('Estatein Patterns', 'figma-custom-theme'))
    );

    // Hero Section Pattern
    register_block_pattern(
        'figma-custom-theme/hero-section',
        array(
            'title'       => esc_html__('Real Estate Hero Section', 'figma-custom-theme'),
            'description' => esc_html__('A hero section with title, description, CTA buttons and statistics.', 'figma-custom-theme'),
            'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"backgroundColor":"base","className":"hero-section"} -->
<div class="wp-block-group alignfull hero-section has-base-background-color has-background" style="padding-top:5rem;padding-bottom:5rem">
<!-- wp:columns {"verticalAlignment":"center","align":"wide"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center","width":"60%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:60%">
<!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"3.75rem","fontWeight":"600","lineHeight":"1.1"}},"textColor":"contrast"} -->
<h1 class="wp-block-heading has-contrast-color has-text-color" style="font-size:3.75rem;font-weight:600;line-height:1.1">Discover Your Dream Property with Estatein</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.125rem"}},"textColor":"secondary"} -->
<p class="has-secondary-color has-text-color" style="font-size:1.125rem">Your journey to finding the perfect property begins here. Explore our listings to find the home that matches your dreams.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"2rem","bottom":"3rem"}}}} -->
<div class="wp-block-buttons" style="margin-top:2rem;margin-bottom:3rem">
<!-- wp:button {"backgroundColor":"primary","style":{"border":{"radius":"0.75rem"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-radius:0.75rem">Browse Properties</a></div>
<!-- /wp:button -->

<!-- wp:button {"style":{"border":{"radius":"0.75rem"}},"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" style="border-radius:0.75rem">Learn More</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"spacing":{"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"}},"border":{"radius":"0.75rem"}},"backgroundColor":"secondary","className":"stat-card"} -->
<div class="wp-block-group stat-card has-secondary-background-color has-background" style="border-radius:0.75rem;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"2.25rem","fontWeight":"700"}},"textColor":"contrast"} -->
<h3 class="wp-block-heading has-contrast-color has-text-color" style="font-size:2.25rem;font-weight:700">200+</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"secondary"} -->
<p class="has-secondary-color has-text-color">Happy Customers</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"spacing":{"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"}},"border":{"radius":"0.75rem"}},"backgroundColor":"secondary","className":"stat-card"} -->
<div class="wp-block-group stat-card has-secondary-background-color has-background" style="border-radius:0.75rem;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"2.25rem","fontWeight":"700"}},"textColor":"contrast"} -->
<h3 class="wp-block-heading has-contrast-color has-text-color" style="font-size:2.25rem;font-weight:700">10k+</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"secondary"} -->
<p class="has-secondary-color has-text-color">Properties For Clients</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"spacing":{"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"}},"border":{"radius":"0.75rem"}},"backgroundColor":"secondary","className":"stat-card"} -->
<div class="wp-block-group stat-card has-secondary-background-color has-background" style="border-radius:0.75rem;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"2.25rem","fontWeight":"700"}},"textColor":"contrast"} -->
<h3 class="wp-block-heading has-contrast-color has-text-color" style="font-size:2.25rem;font-weight:700">16+</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"secondary"} -->
<p class="has-secondary-color has-text-color">Years of Experience</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"40%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:40%">
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":"0.75rem"}}} -->
<figure class="wp-block-image size-large" style="border-radius:0.75rem"><img alt="Dream property showcase"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->',
            'categories'  => array('estatein'),
            'keywords'    => array('hero', 'real estate', 'estatein', 'cta', 'stats'),
        )
    );

    // Features Grid Pattern
    register_block_pattern(
        'figma-custom-theme/features-grid',
        array(
            'title'       => esc_html__('Real Estate Features Grid', 'figma-custom-theme'),
            'description' => esc_html__('A grid of feature cards highlighting services and benefits.', 'figma-custom-theme'),
            'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"backgroundColor":"secondary","className":"features-section"} -->
<div class="wp-block-group alignfull features-section has-secondary-background-color has-background" style="padding-top:5rem;padding-bottom:5rem">
<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"spacing":{"padding":{"top":"2.5rem","right":"2.5rem","bottom":"2.5rem","left":"2.5rem"}},"border":{"radius":"0.75rem"}},"backgroundColor":"base","className":"feature-card"} -->
<div class="wp-block-group feature-card has-base-background-color has-background" style="border-radius:0.75rem;padding-top:2.5rem;padding-right:2.5rem;padding-bottom:2.5rem;padding-left:2.5rem">
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"3rem"}}} -->
<p class="has-text-align-center" style="font-size:3rem">🏠</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.25rem","fontWeight":"600"}},"textColor":"contrast"} -->
<h3 class="wp-block-heading has-text-align-center has-contrast-color has-text-color" style="font-size:1.25rem;font-weight:600">Find Your Dream Home</h3>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"spacing":{"padding":{"top":"2.5rem","right":"2.5rem","bottom":"2.5rem","left":"2.5rem"}},"border":{"radius":"0.75rem"}},"backgroundColor":"base","className":"feature-card"} -->
<div class="wp-block-group feature-card has-base-background-color has-background" style="border-radius:0.75rem;padding-top:2.5rem;padding-right:2.5rem;padding-bottom:2.5rem;padding-left:2.5rem">
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"3rem"}}} -->
<p class="has-text-align-center" style="font-size:3rem">💰</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.25rem","fontWeight":"600"}},"textColor":"contrast"} -->
<h3 class="wp-block-heading has-text-align-center has-contrast-color has-text-color" style="font-size:1.25rem;font-weight:600">Unlock Property Value</h3>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"spacing":{"padding":{"top":"2.5rem","right":"2.5rem","bottom":"2.5rem","left":"2.5rem"}},"border":{"radius":"0.75rem"}},"backgroundColor":"base","className":"feature-card"} -->
<div class="wp-block-group feature-card has-base-background-color has-background" style="border-radius:0.75rem;padding-top:2.5rem;padding-right:2.5rem;padding-bottom:2.5rem;padding-left:2.5rem">
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"3rem"}}} -->
<p class="has-text-align-center" style="font-size:3rem">⚡</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.25rem","fontWeight":"600"}},"textColor":"contrast"} -->
<h3 class="wp-block-heading has-text-align-center has-contrast-color has-text-color" style="font-size:1.25rem;font-weight:600">Effortless Property Management</h3>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"spacing":{"padding":{"top":"2.5rem","right":"2.5rem","bottom":"2.5rem","left":"2.5rem"}},"border":{"radius":"0.75rem"}},"backgroundColor":"base","className":"feature-card"} -->
<div class="wp-block-group feature-card has-base-background-color has-background" style="border-radius:0.75rem;padding-top:2.5rem;padding-right:2.5rem;padding-bottom:2.5rem;padding-left:2.5rem">
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"3rem"}}} -->
<p class="has-text-align-center" style="font-size:3rem">🎯</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.25rem","fontWeight":"600"}},"textColor":"contrast"} -->
<h3 class="wp-block-heading has-text-align-center has-contrast-color has-text-color" style="font-size:1.25rem;font-weight:600">Smart Investments, Informed Decisions</h3>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->',
            'categories'  => array('estatein'),
            'keywords'    => array('features', 'services', 'grid', 'benefits'),
        )
    );

    // Property Showcase Pattern
    register_block_pattern(
        'figma-custom-theme/property-showcase',
        array(
            'title'       => esc_html__('Property Showcase Card', 'figma-custom-theme'),
            'description' => esc_html__('A showcase card for displaying property details with image, features and CTA.', 'figma-custom-theme'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"2.5rem","right":"2.5rem","bottom":"2.5rem","left":"2.5rem"}},"border":{"radius":"0.75rem"}},"backgroundColor":"base","className":"property-card"} -->
<div class="wp-block-group property-card has-base-background-color has-background" style="border-radius:0.75rem;padding-top:2.5rem;padding-right:2.5rem;padding-bottom:2.5rem;padding-left:2.5rem">
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":"0.5rem"}}} -->
<figure class="wp-block-image size-large" style="border-radius:0.5rem"><img alt="Property showcase"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.5rem","fontWeight":"600"}},"textColor":"contrast"} -->
<h3 class="wp-block-heading has-contrast-color has-text-color" style="font-size:1.5rem;font-weight:600">Seaside Serenity Villa</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"secondary"} -->
<p class="has-secondary-color has-text-color">A stunning 4-bedroom, 3-bathroom villa in a peaceful suburban neighborhood... <a href="#">Read More</a></p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"1.5rem","bottom":"1.5rem"}}}} -->
<div class="wp-block-group" style="margin-top:1.5rem;margin-bottom:1.5rem">
<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast","className":"feature-badges"} -->
<p class="feature-badges has-contrast-color has-text-color has-link-color">🏠 4-Bedroom  🚿 3-Bathroom  🏡 Villa</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group">
<!-- wp:group -->
<div class="wp-block-group">
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.875rem"}},"textColor":"secondary"} -->
<p class="has-secondary-color has-text-color" style="font-size:0.875rem">Price</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"1.5rem","fontWeight":"600"}},"textColor":"contrast"} -->
<h4 class="wp-block-heading has-contrast-color has-text-color" style="font-size:1.5rem;font-weight:600">$550,000</h4>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:button {"backgroundColor":"primary","style":{"border":{"radius":"0.5rem"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-radius:0.5rem">View Property Details</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
            'categories'  => array('estatein'),
            'keywords'    => array('property', 'showcase', 'card', 'real estate', 'listing'),
        )
    );

    // Testimonial Pattern
    register_block_pattern(
        'figma-custom-theme/testimonial-card',
        array(
            'title'       => esc_html__('Customer Testimonial Card', 'figma-custom-theme'),
            'description' => esc_html__('A testimonial card with rating, quote, and customer details.', 'figma-custom-theme'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"3rem","right":"3rem","bottom":"3rem","left":"3rem"}},"border":{"radius":"0.75rem"}},"backgroundColor":"base","className":"testimonial-card"} -->
<div class="wp-block-group testimonial-card has-base-background-color has-background" style="border-radius:0.75rem;padding-top:3rem;padding-right:3rem;padding-bottom:3rem;padding-left:3rem">
<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.5rem"}},"textColor":"primary"} -->
<p class="has-primary-color has-text-color" style="font-size:1.5rem">⭐⭐⭐⭐⭐</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.5rem","fontWeight":"600"}},"textColor":"contrast"} -->
<h3 class="wp-block-heading has-contrast-color has-text-color" style="font-size:1.5rem;font-weight:600">Exceptional Service!</h3>
<!-- /wp:heading -->

<!-- wp:quote {"style":{"typography":{"fontSize":"1.125rem"}},"textColor":"contrast","className":"is-style-plain"} -->
<blockquote class="wp-block-quote is-style-plain has-contrast-color has-text-color" style="font-size:1.125rem"><p>Our experience with Estatein was outstanding. Their team\'s dedication and professionalism made finding our dream home a breeze. Highly recommended!</p></blockquote>
<!-- /wp:quote -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group">
<!-- wp:image {"width":"60px","height":"60px","sizeSlug":"thumbnail","linkDestination":"none","style":{"border":{"radius":"50px"}}} -->
<figure class="wp-block-image size-thumbnail is-resized" style="border-radius:50px"><img alt="Wade Warren" style="width:60px;height:60px"/></figure>
<!-- /wp:image -->

<!-- wp:group -->
<div class="wp-block-group">
<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"1.25rem","fontWeight":"500"}},"textColor":"contrast"} -->
<h4 class="wp-block-heading has-contrast-color has-text-color" style="font-size:1.25rem;font-weight:500">Wade Warren</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.125rem"}},"textColor":"secondary"} -->
<p class="has-secondary-color has-text-color" style="font-size:1.125rem">USA, California</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
            'categories'  => array('estatein'),
            'keywords'    => array('testimonial', 'review', 'customer', 'feedback', 'rating'),
        )
    );

    // Call to Action Pattern
    register_block_pattern(
        'figma-custom-theme/cta-section',
        array(
            'title'       => esc_html__('Call to Action Section', 'figma-custom-theme'),
            'description' => esc_html__('A prominent call to action section with gradient background.', 'figma-custom-theme'),
            'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}},"color":{"gradient":"linear-gradient(135deg,var(--wp--preset--color--secondary) 0%,var(--wp--preset--color--base) 100%)"}},"className":"cta-section"} -->
<div class="wp-block-group alignfull cta-section has-background" style="background:linear-gradient(135deg,var(--wp--preset--color--secondary) 0%,var(--wp--preset--color--base) 100%);padding-top:5rem;padding-bottom:5rem">
<!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group alignwide">
<!-- wp:group {"style":{"flex":{"basis":"60%"}}} -->
<div class="wp-block-group">
<!-- wp:heading {"style":{"typography":{"fontSize":"3rem","fontWeight":"600"}},"textColor":"contrast"} -->
<h2 class="wp-block-heading has-contrast-color has-text-color" style="font-size:3rem;font-weight:600">Start Your Real Estate Journey Today</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.125rem"}},"textColor":"secondary"} -->
<p class="has-secondary-color has-text-color" style="font-size:1.125rem">Your dream property is just a click away. Whether you\'re looking for a new home, a strategic investment, or expert real estate advice, Estatein is here to assist you every step of the way.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:button {"backgroundColor":"primary","style":{"border":{"radius":"0.5rem"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-radius:0.5rem">Explore Properties</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
            'categories'  => array('estatein'),
            'keywords'    => array('cta', 'call to action', 'button', 'contact'),
        )
    );
}
add_action('init', 'figma_custom_theme_register_block_patterns');
