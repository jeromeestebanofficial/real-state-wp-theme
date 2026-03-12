<?php
/**
 * Figma Custom Theme Customizer
 *
 * @package Figma_Custom_Theme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if (!function_exists('figma_custom_theme_customize_register')) {
    function figma_custom_theme_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'figma_custom_theme_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'figma_custom_theme_customize_partial_blogdescription',
            )
        );
    }

    // Theme Options Section
    $wp_customize->add_section('figma_custom_theme_options', array(
        'title'    => esc_html__('Theme Options', 'figma-custom-theme'),
        'priority' => 130,
    ));

    // Header Layout
    $wp_customize->add_setting('header_layout', array(
        'default'           => 'default',
        'sanitize_callback' => 'figma_custom_theme_sanitize_select',
    ));

    $wp_customize->add_control('header_layout', array(
        'label'    => esc_html__('Header Layout', 'figma-custom-theme'),
        'section'  => 'figma_custom_theme_options',
        'type'     => 'select',
        'choices'  => array(
            'default' => esc_html__('Default', 'figma-custom-theme'),
            'centered' => esc_html__('Centered', 'figma-custom-theme'),
        ),
    ));

    // Footer Text
    $wp_customize->add_setting('footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('footer_text', array(
        'label'    => esc_html__('Footer Text', 'figma-custom-theme'),
        'section'  => 'figma_custom_theme_options',
        'type'     => 'text',
    ));

    // Color Options Section
    $wp_customize->add_section('figma_custom_theme_colors', array(
        'title'    => esc_html__('Color Options', 'figma-custom-theme'),
        'priority' => 140,
    ));

    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#007cba',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'    => esc_html__('Primary Color', 'figma-custom-theme'),
        'section'  => 'figma_custom_theme_colors',
        'settings' => 'primary_color',
    )));

    // Secondary Color
    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#666666',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'    => esc_html__('Secondary Color', 'figma-custom-theme'),
        'section'  => 'figma_custom_theme_colors',
        'settings' => 'secondary_color',
    )));

    // Images Section
    $wp_customize->add_section('figma_custom_theme_images', array(
        'title'    => esc_html__('Theme Images', 'figma-custom-theme'),
        'priority' => 150,
        'description' => esc_html__('Customize images throughout your website. Upload your own images to replace the default ones.', 'figma-custom-theme'),
    ));

    // Hero Image
    $wp_customize->add_setting('hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh', // Images need refresh for proper display
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_image', array(
        'label'     => esc_html__('Hero Section Image', 'figma-custom-theme'),
        'section'   => 'figma_custom_theme_images',
        'mime_type' => 'image',
        'description' => esc_html__('Upload an image for the hero section. Recommended size: 600x600px. This takes priority over the URL field below.', 'figma-custom-theme'),
    )));

    // Hero Image URL (fallback when no upload is selected)
    $wp_customize->add_setting('hero_image_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('hero_image_url', array(
        'label'       => esc_html__('Hero Section Image URL', 'figma-custom-theme'),
        'section'     => 'figma_custom_theme_images',
        'type'        => 'url',
        'description' => esc_html__('Paste a direct image URL. Used only when no uploaded Hero Section Image is selected.', 'figma-custom-theme'),
    ));

    // Property Images
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("property_image_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "property_image_{$i}", array(
            'label'     => sprintf(esc_html__('Property Image %d', 'figma-custom-theme'), $i),
            'section'   => 'figma_custom_theme_images',
            'mime_type' => 'image',
            'description' => esc_html__('Upload an image for the properties section. Recommended size: 400x240px', 'figma-custom-theme'),
        )));
    }

    // Testimonial Avatar Images
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("testimonial_avatar_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "testimonial_avatar_{$i}", array(
            'label'     => sprintf(esc_html__('Testimonial Avatar %d', 'figma-custom-theme'), $i),
            'section'   => 'figma_custom_theme_images',
            'mime_type' => 'image',
            'description' => esc_html__('Upload an avatar image for testimonials. Recommended size: 60x60px', 'figma-custom-theme'),
        )));
    }

    // Content Section
    $wp_customize->add_section('figma_custom_theme_content', array(
        'title'    => esc_html__('Theme Content', 'figma-custom-theme'),
        'priority' => 160,
        'description' => esc_html__('Customize text content throughout your website.', 'figma-custom-theme'),
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default'           => 'Discover Your Dream Property with Estatein',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'    => esc_html__('Hero Title', 'figma-custom-theme'),
        'section'  => 'figma_custom_theme_content',
        'type'     => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => 'Your journey to finding the perfect property begins here. Explore our listings to find the home that matches your dreams.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label'    => esc_html__('Hero Subtitle', 'figma-custom-theme'),
        'section'  => 'figma_custom_theme_content',
        'type'     => 'textarea',
    ));

    // Hero Button 1 Text
    $wp_customize->add_setting('hero_button_1_text', array(
        'default'           => 'Learn More',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_button_1_text', array(
        'label'    => esc_html__('Hero - Button 1 Text (Learn More)', 'figma-custom-theme'),
        'section'  => 'figma_custom_theme_content',
        'type'     => 'text',
    ));

    // Hero Button 2 Text
    $wp_customize->add_setting('hero_button_2_text', array(
        'default'           => 'Browse Properties',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_button_2_text', array(
        'label'    => esc_html__('Hero - Button 2 Text (Browse Properties)', 'figma-custom-theme'),
        'section'  => 'figma_custom_theme_content',
        'type'     => 'text',
    ));

    // Hero Stats
    for ($i = 1; $i <= 3; $i++) {
        $defaults = array(
            1 => array('number' => '200+', 'label' => 'Happy Customers'),
            2 => array('number' => '10k+', 'label' => 'Properties For Clients'),
            3 => array('number' => '16+', 'label' => 'Years of Experience'),
        );

        $wp_customize->add_setting("hero_stat_{$i}_number", array(
            'default'           => $defaults[$i]['number'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ));

        $wp_customize->add_control("hero_stat_{$i}_number", array(
            'label'    => sprintf(esc_html__('Hero Stat %d Number', 'figma-custom-theme'), $i),
            'section'  => 'figma_custom_theme_content',
            'type'     => 'text',
        ));

        $wp_customize->add_setting("hero_stat_{$i}_label", array(
            'default'           => $defaults[$i]['label'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ));

        $wp_customize->add_control("hero_stat_{$i}_label", array(
            'label'    => sprintf(esc_html__('Hero Stat %d Label', 'figma-custom-theme'), $i),
            'section'  => 'figma_custom_theme_content',
            'type'     => 'text',
        ));
    }

    // Homepage Sections
    $wp_customize->add_section('figma_homepage_sections', array(
        'title'    => esc_html__('Homepage Sections', 'figma-custom-theme'),
        'priority' => 165,
        'description' => esc_html__('Customize content for homepage sections (Features, Properties, Testimonials).', 'figma-custom-theme'),
    ));

    // Features Section - Feature 1
    $wp_customize->add_setting('feature_1_title', array(
        'default'           => 'Find Your Dream Home',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('feature_1_title', array(
        'label'    => esc_html__('Feature 1 - Title', 'figma-custom-theme'),
        'section'  => 'figma_homepage_sections',
        'type'     => 'text',
    ));

    // Features Section - Feature 2
    $wp_customize->add_setting('feature_2_title', array(
        'default'           => 'Unlock Property Value',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('feature_2_title', array(
        'label'    => esc_html__('Feature 2 - Title', 'figma-custom-theme'),
        'section'  => 'figma_homepage_sections',
        'type'     => 'text',
    ));

    // Features Section - Feature 3
    $wp_customize->add_setting('feature_3_title', array(
        'default'           => 'Effortless Property Management',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('feature_3_title', array(
        'label'    => esc_html__('Feature 3 - Title', 'figma-custom-theme'),
        'section'  => 'figma_homepage_sections',
        'type'     => 'text',
    ));

    // Features Section - Feature 4
    $wp_customize->add_setting('feature_4_title', array(
        'default'           => 'Smart Investments, Informed Decisions',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('feature_4_title', array(
        'label'    => esc_html__('Feature 4 - Title', 'figma-custom-theme'),
        'section'  => 'figma_homepage_sections',
        'type'     => 'text',
    ));

    // Properties Section Title
    $wp_customize->add_setting('homepage_properties_title', array(
        'default'           => 'Featured Properties',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('homepage_properties_title', array(
        'label'    => esc_html__('Properties Section - Title', 'figma-custom-theme'),
        'section'  => 'figma_homepage_sections',
        'type'     => 'text',
    ));

    // Properties Section Description
    $wp_customize->add_setting('homepage_properties_description', array(
        'default'           => 'Explore our handpicked selection of featured properties. Each listing offers a glimpse into exceptional homes and investments available through Estatein. Click "View Details" for more information.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('homepage_properties_description', array(
        'label'    => esc_html__('Properties Section - Description', 'figma-custom-theme'),
        'section'  => 'figma_homepage_sections',
        'type'     => 'textarea',
    ));

    // Properties Section Button Text
    $wp_customize->add_setting('homepage_properties_button_text', array(
        'default'           => 'View All Properties',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('homepage_properties_button_text', array(
        'label'    => esc_html__('Properties Section - Button Text', 'figma-custom-theme'),
        'section'  => 'figma_homepage_sections',
        'type'     => 'text',
    ));

    // Testimonials Section Title
    $wp_customize->add_setting('homepage_testimonials_title', array(
        'default'           => 'What Our Clients Say',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('homepage_testimonials_title', array(
        'label'    => esc_html__('Testimonials Section - Title', 'figma-custom-theme'),
        'section'  => 'figma_homepage_sections',
        'type'     => 'text',
    ));

    // Testimonials Section Description
    $wp_customize->add_setting('homepage_testimonials_description', array(
        'default'           => 'Read the success stories and heartfelt testimonials from our valued clients. Discover why they chose Estatein for their real estate needs.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('homepage_testimonials_description', array(
        'label'    => esc_html__('Testimonials Section - Description', 'figma-custom-theme'),
        'section'  => 'figma_homepage_sections',
        'type'     => 'textarea',
    ));

    // Testimonials Section Button Text
    $wp_customize->add_setting('homepage_testimonials_button_text', array(
        'default'           => 'View All Testimonials',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('homepage_testimonials_button_text', array(
        'label'    => esc_html__('Testimonials Section - Button Text', 'figma-custom-theme'),
        'section'  => 'figma_homepage_sections',
        'type'     => 'text',
    ));

    // Properties Archive Page Section
    $wp_customize->add_section('figma_properties_archive', array(
        'title'    => esc_html__('Properties Archive Page', 'figma-custom-theme'),
        'priority' => 170,
        'description' => esc_html__('Customize the content for the Properties Archive page (/properties). These settings apply to the archive page where all properties are listed.', 'figma-custom-theme'),
    ));

    // Hero Section Title
    $wp_customize->add_setting('properties_archive_hero_title', array(
        'default'           => 'Find Your Dream Property',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('properties_archive_hero_title', array(
        'label'    => esc_html__('Hero Section Title', 'figma-custom-theme'),
        'section'  => 'figma_properties_archive',
        'type'     => 'text',
        'description' => esc_html__('The main title displayed in the hero section of the properties archive page.', 'figma-custom-theme'),
    ));

    // Hero Section Description
    $wp_customize->add_setting('properties_archive_hero_description', array(
        'default'           => 'Welcome to Estatein, where your dream property awaits in every corner of our beautiful world. Explore our curated selection of properties, each offering a unique story and a chance to redefine your life. With categories to suit every dreamer, your journey',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('properties_archive_hero_description', array(
        'label'    => esc_html__('Hero Section Description', 'figma-custom-theme'),
        'section'  => 'figma_properties_archive',
        'type'     => 'textarea',
        'description' => esc_html__('The description text displayed below the hero title.', 'figma-custom-theme'),
    ));

    // Listing Section Title
    $wp_customize->add_setting('properties_archive_section_title', array(
        'default'           => 'Discover a World of Possibilities',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('properties_archive_section_title', array(
        'label'    => esc_html__('Properties Listing Section Title', 'figma-custom-theme'),
        'section'  => 'figma_properties_archive',
        'type'     => 'text',
        'description' => esc_html__('The title displayed above the properties listing grid.', 'figma-custom-theme'),
    ));

    // Listing Section Description
    $wp_customize->add_setting('properties_archive_section_description', array(
        'default'           => 'Our portfolio of properties is as diverse as your dreams. Explore the following categories to find the perfect property that resonates with your vision of home',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('properties_archive_section_description', array(
        'label'    => esc_html__('Properties Listing Section Description', 'figma-custom-theme'),
        'section'  => 'figma_properties_archive',
        'type'     => 'textarea',
        'description' => esc_html__('The description text displayed below the listing section title.', 'figma-custom-theme'),
    ));

    // Contact Section Title
    $wp_customize->add_setting('properties_archive_contact_title', array(
        'default'           => 'Let\'s Make it Happen',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('properties_archive_contact_title', array(
        'label'    => esc_html__('Contact Form Section Title', 'figma-custom-theme'),
        'section'  => 'figma_properties_archive',
        'type'     => 'text',
        'description' => esc_html__('The title displayed above the contact form.', 'figma-custom-theme'),
    ));

    // Contact Section Description
    $wp_customize->add_setting('properties_archive_contact_description', array(
        'default'           => 'Ready to take the first step toward your dream property? Fill out the form below, and our real estate wizards will work their magic to find your perfect match. Don\'t wait; let\'s embark on this exciting journey together.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('properties_archive_contact_description', array(
        'label'    => esc_html__('Contact Form Section Description', 'figma-custom-theme'),
        'section'  => 'figma_properties_archive',
        'type'     => 'textarea',
        'description' => esc_html__('The description text displayed below the contact form title.', 'figma-custom-theme'),
    ));

    // Add selective refresh for homepage content (with edit indicators)
    if (isset($wp_customize->selective_refresh)) {
        // Hero Section
        $wp_customize->selective_refresh->add_partial('hero_title', array(
            'selector'        => '.hero-section .hero-title',
            'primarySetting' => 'hero_title',
            'render_callback' => function() {
                return get_theme_mod('hero_title', 'Discover Your Dream Property with Estatein');
            },
        ));

        $wp_customize->selective_refresh->add_partial('hero_subtitle', array(
            'selector'        => '.hero-section .hero-subtitle',
            'primarySetting' => 'hero_subtitle',
            'render_callback' => function() {
                return get_theme_mod('hero_subtitle', 'Your journey to finding the perfect property begins here. Explore our listings to find the home that matches your dreams.');
            },
        ));

        $wp_customize->selective_refresh->add_partial('hero_button_1_text', array(
            'selector'        => '.hero-section .hero-actions a.btn-outline',
            'primarySetting' => 'hero_button_1_text',
            'render_callback' => function() {
                return get_theme_mod('hero_button_1_text', 'Learn More');
            },
        ));

        $wp_customize->selective_refresh->add_partial('hero_button_2_text', array(
            'selector'        => '.hero-section .hero-actions a.btn-primary',
            'primarySetting' => 'hero_button_2_text',
            'render_callback' => function() {
                return get_theme_mod('hero_button_2_text', 'Browse Properties');
            },
        ));

        // Hero Stats
        for ($i = 1; $i <= 3; $i++) {
            $wp_customize->selective_refresh->add_partial("hero_stat_{$i}_number", array(
                'selector'        => ".hero-section .stat-card:nth-child({$i}) .stat-number",
                'primarySetting' => "hero_stat_{$i}_number",
                'render_callback' => function() use ($i) {
                    $defaults = array(1 => '200+', 2 => '10k+', 3 => '16+');
                    return get_theme_mod("hero_stat_{$i}_number", $defaults[$i]);
                },
            ));

            $wp_customize->selective_refresh->add_partial("hero_stat_{$i}_label", array(
                'selector'        => ".hero-section .stat-card:nth-child({$i}) .stat-label",
                'primarySetting' => "hero_stat_{$i}_label",
                'render_callback' => function() use ($i) {
                    $defaults = array(1 => 'Happy Customers', 2 => 'Properties For Clients', 3 => 'Years of Experience');
                    return get_theme_mod("hero_stat_{$i}_label", $defaults[$i]);
                },
            ));
        }

        // Features Section
        for ($i = 1; $i <= 4; $i++) {
            $wp_customize->selective_refresh->add_partial("feature_{$i}_title", array(
                'selector'        => ".features-section .feature-card:nth-child({$i}) .feature-title",
                'primarySetting' => "feature_{$i}_title",
                'render_callback' => function() use ($i) {
                    $defaults = array(
                        1 => 'Find Your Dream Home',
                        2 => 'Unlock Property Value',
                        3 => 'Effortless Property Management',
                        4 => 'Smart Investments, Informed Decisions'
                    );
                    return get_theme_mod("feature_{$i}_title", $defaults[$i]);
                },
            ));
        }

        // Properties Section
        $wp_customize->selective_refresh->add_partial('homepage_properties_title', array(
            'selector'        => '.properties-section .section-header .section-title',
            'primarySetting' => 'homepage_properties_title',
            'render_callback' => function() {
                return get_theme_mod('homepage_properties_title', 'Featured Properties');
            },
        ));

        $wp_customize->selective_refresh->add_partial('homepage_properties_description', array(
            'selector'        => '.properties-section .section-header .section-description',
            'primarySetting' => 'homepage_properties_description',
            'render_callback' => function() {
                return get_theme_mod('homepage_properties_description', 'Explore our handpicked selection of featured properties. Each listing offers a glimpse into exceptional homes and investments available through Estatein. Click "View Details" for more information.');
            },
        ));

        $wp_customize->selective_refresh->add_partial('homepage_properties_button_text', array(
            'selector'        => '.properties-section .section-header .section-action a.btn-outline',
            'primarySetting' => 'homepage_properties_button_text',
            'render_callback' => function() {
                return get_theme_mod('homepage_properties_button_text', 'View All Properties');
            },
        ));

        // Testimonials Section
        $wp_customize->selective_refresh->add_partial('homepage_testimonials_title', array(
            'selector'        => '.testimonials-section .section-header .section-title',
            'primarySetting' => 'homepage_testimonials_title',
            'render_callback' => function() {
                return get_theme_mod('homepage_testimonials_title', 'What Our Clients Say');
            },
        ));

        $wp_customize->selective_refresh->add_partial('homepage_testimonials_description', array(
            'selector'        => '.testimonials-section .section-header .section-description',
            'primarySetting' => 'homepage_testimonials_description',
            'render_callback' => function() {
                return get_theme_mod('homepage_testimonials_description', 'Read the success stories and heartfelt testimonials from our valued clients. Discover why they chose Estatein for their real estate needs.');
            },
        ));

        $wp_customize->selective_refresh->add_partial('homepage_testimonials_button_text', array(
            'selector'        => '.testimonials-section .section-header .section-action a.btn-outline',
            'primarySetting' => 'homepage_testimonials_button_text',
            'render_callback' => function() {
                return get_theme_mod('homepage_testimonials_button_text', 'View All Testimonials');
            },
        ));
    }

    // Add selective refresh for properties archive content
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('properties_archive_hero_title', array(
            'selector'        => '.properties-hero-section .hero-title',
            'primarySetting' => 'properties_archive_hero_title',
            'render_callback' => function() {
                return get_theme_mod('properties_archive_hero_title', 'Find Your Dream Property');
            },
        ));

        $wp_customize->selective_refresh->add_partial('properties_archive_hero_description', array(
            'selector'        => '.properties-hero-section .hero-description',
            'primarySetting' => 'properties_archive_hero_description',
            'render_callback' => function() {
                return get_theme_mod('properties_archive_hero_description', 'Welcome to Estatein, where your dream property awaits in every corner of our beautiful world. Explore our curated selection of properties, each offering a unique story and a chance to redefine your life. With categories to suit every dreamer, your journey');
            },
        ));

        $wp_customize->selective_refresh->add_partial('properties_archive_section_title', array(
            'selector'        => '.properties-listing-section .section-title',
            'primarySetting' => 'properties_archive_section_title',
            'render_callback' => function() {
                return get_theme_mod('properties_archive_section_title', 'Discover a World of Possibilities');
            },
        ));

        $wp_customize->selective_refresh->add_partial('properties_archive_section_description', array(
            'selector'        => '.properties-listing-section .section-description',
            'primarySetting' => 'properties_archive_section_description',
            'render_callback' => function() {
                return get_theme_mod('properties_archive_section_description', 'Our portfolio of properties is as diverse as your dreams. Explore the following categories to find the perfect property that resonates with your vision of home');
            },
        ));

        $wp_customize->selective_refresh->add_partial('properties_archive_contact_title', array(
            'selector'        => '.properties-contact-section .section-title',
            'primarySetting' => 'properties_archive_contact_title',
            'render_callback' => function() {
                return get_theme_mod('properties_archive_contact_title', 'Let\'s Make it Happen');
            },
        ));

        $wp_customize->selective_refresh->add_partial('properties_archive_contact_description', array(
            'selector'        => '.properties-contact-section .section-description',
            'primarySetting' => 'properties_archive_contact_description',
            'render_callback' => function() {
                return get_theme_mod('properties_archive_contact_description', 'Ready to take the first step toward your dream property? Fill out the form below, and our real estate wizards will work their magic to find your perfect match. Don\'t wait; let\'s embark on this exciting journey together.');
            },
        ));
    }

    // Footer Section
    $wp_customize->add_section('figma_footer_settings', array(
        'title'    => esc_html__('Footer Settings', 'figma-custom-theme'),
        'priority' => 180,
        'description' => esc_html__('Customize the footer content including the call-to-action section.', 'figma-custom-theme'),
    ));

    // Footer CTA Title
    $wp_customize->add_setting('footer_cta_title', array(
        'default'           => 'Start Your Real Estate Journey Today',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_cta_title', array(
        'label'    => esc_html__('CTA Section Title', 'figma-custom-theme'),
        'section'  => 'figma_footer_settings',
        'type'     => 'text',
        'description' => esc_html__('The main title in the footer call-to-action section.', 'figma-custom-theme'),
    ));

    // Footer CTA Description
    $wp_customize->add_setting('footer_cta_description', array(
        'default'           => 'Your dream property is just a click away. Whether you\'re looking for a new home, a strategic investment, or expert real estate advice, Estatein is here to assist you every step of the way.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_cta_description', array(
        'label'    => esc_html__('CTA Section Description', 'figma-custom-theme'),
        'section'  => 'figma_footer_settings',
        'type'     => 'textarea',
        'description' => esc_html__('The description text in the footer call-to-action section.', 'figma-custom-theme'),
    ));

    // Footer CTA Button Text
    $wp_customize->add_setting('footer_cta_button_text', array(
        'default'           => 'Explore Properties',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_cta_button_text', array(
        'label'    => esc_html__('CTA Button Text', 'figma-custom-theme'),
        'section'  => 'figma_footer_settings',
        'type'     => 'text',
        'description' => esc_html__('The text displayed on the call-to-action button.', 'figma-custom-theme'),
    ));

    // Footer CTA Button Link
    $wp_customize->add_setting('footer_cta_button_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_cta_button_link', array(
        'label'    => esc_html__('CTA Button Link', 'figma-custom-theme'),
        'section'  => 'figma_footer_settings',
        'type'     => 'url',
        'description' => esc_html__('The URL for the call-to-action button. Leave empty to use the Properties page link.', 'figma-custom-theme'),
    ));

    // Add selective refresh for footer CTA
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('footer_cta_title', array(
            'selector'        => '.cta-section h2',
            'primarySetting' => 'footer_cta_title',
            'render_callback' => function() {
                return get_theme_mod('footer_cta_title', 'Start Your Real Estate Journey Today');
            },
        ));

        $wp_customize->selective_refresh->add_partial('footer_cta_description', array(
            'selector'        => '.cta-section p',
            'primarySetting' => 'footer_cta_description',
            'render_callback' => function() {
                return get_theme_mod('footer_cta_description', 'Your dream property is just a click away. Whether you\'re looking for a new home, a strategic investment, or expert real estate advice, Estatein is here to assist you every step of the way.');
            },
        ));

        $wp_customize->selective_refresh->add_partial('footer_cta_button_text', array(
            'selector'        => '.cta-section a.btn',
            'primarySetting' => 'footer_cta_button_text',
            'render_callback' => function() {
                return get_theme_mod('footer_cta_button_text', 'Explore Properties');
            },
        ));
    }
    }
}
add_action('customize_register', 'figma_custom_theme_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function figma_custom_theme_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function figma_custom_theme_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function figma_custom_theme_customize_preview_js() {
    wp_enqueue_script('figma-custom-theme-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), wp_get_theme()->get('Version'), true);
}
add_action('customize_preview_init', 'figma_custom_theme_customize_preview_js');

/**
 * Sanitize select options
 */
function figma_custom_theme_sanitize_select($input, $setting) {
    // Ensure input is a slug.
    $input = sanitize_key($input);

    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control($setting->id)->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return array_key_exists($input, $choices) ? $input : $setting->default;
}
