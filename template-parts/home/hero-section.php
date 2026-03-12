<?php
/**
 * Template part for displaying hero section
 *
 * @package Figma_Custom_Theme
 */
?>

<section class="hero-section">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <?php echo esc_html(get_theme_mod('hero_title', __('Discover Your Dream Property with Estatein', 'figma-custom-theme'))); ?>
                    </h1>
                    <p class="hero-subtitle">
                        <?php echo esc_html(get_theme_mod('hero_subtitle', __('Your journey to finding the perfect property begins here. Explore our listings to find the home that matches your dreams.', 'figma-custom-theme'))); ?>
                    </p>
                </div>

                <div class="hero-actions">
                    <a href="#properties" class="btn btn-outline">
                        <?php echo esc_html(get_theme_mod('hero_button_1_text', 'Learn More')); ?>
                    </a>
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('properties'))); ?>" class="btn btn-primary">
                        <?php echo esc_html(get_theme_mod('hero_button_2_text', 'Browse Properties')); ?>
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo esc_html(get_theme_mod('hero_stat_1_number', '200+')); ?></div>
                        <div class="stat-label"><?php echo esc_html(get_theme_mod('hero_stat_1_label', __('Happy Customers', 'figma-custom-theme'))); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo esc_html(get_theme_mod('hero_stat_2_number', '10k+')); ?></div>
                        <div class="stat-label"><?php echo esc_html(get_theme_mod('hero_stat_2_label', __('Properties For Clients', 'figma-custom-theme'))); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo esc_html(get_theme_mod('hero_stat_3_number', '16+')); ?></div>
                        <div class="stat-label"><?php echo esc_html(get_theme_mod('hero_stat_3_label', __('Years of Experience', 'figma-custom-theme'))); ?></div>
                    </div>
                </div>
            </div>

            <div class="hero-image">
                <div class="hero-image-container">
                    <?php
                    $hero_image_id = get_theme_mod('hero_image');
                    $hero_image_custom_url = get_theme_mod('hero_image_url', '');
                    $default_hero_image_url = 'https://cdn.confident-group.com/wp-content/uploads/2024/12/27103036/types-of-real-estate-overview-scaled.jpg';

                    if ($hero_image_id && wp_get_attachment_image_url($hero_image_id, 'large')) {
                        $hero_image_url = wp_get_attachment_image_url($hero_image_id, 'large');
                        $hero_image_alt = get_post_meta($hero_image_id, '_wp_attachment_image_alt', true);
                    } elseif (!empty($hero_image_custom_url)) {
                        $hero_image_url = $hero_image_custom_url;
                        $hero_image_alt = __('Hero section image', 'figma-custom-theme');
                    } else {
                        $hero_image_url = $default_hero_image_url;
                        $hero_image_alt = __('Types of real estate overview', 'figma-custom-theme');
                    }
                    ?>
                    <img src="<?php echo esc_url($hero_image_url); ?>" 
                         alt="<?php echo esc_attr($hero_image_alt ?: __('Dream property showcase', 'figma-custom-theme')); ?>"
                         loading="lazy">
                    <div class="hero-image-overlay"></div>
                </div>
            </div>
        </div>
    </div>
</section>
