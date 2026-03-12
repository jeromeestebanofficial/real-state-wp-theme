<?php
/**
 * Template part for displaying Our Journey section
 *
 * @package Figma_Custom_Theme
 */

$journey_title = get_field('about_journey_title') ?: esc_html__('Our Journey', 'figma-custom-theme');
$journey_description = get_field('about_journey_description') ?: "Our story is one of continuous growth and evolution. We started as a small team with big dreams, determined to create a real estate platform that transcended the ordinary. Over the years, we've expanded our reach, forged valuable partnerships, and gained the trust of countless clients.";
$stat_1_number = get_field('about_stat_1_number') ?: '200+';
$stat_1_label = get_field('about_stat_1_label') ?: esc_html__('Happy Customers', 'figma-custom-theme');
$stat_2_number = get_field('about_stat_2_number') ?: '10k+';
$stat_2_label = get_field('about_stat_2_label') ?: esc_html__('Properties For Clients', 'figma-custom-theme');
$stat_3_number = get_field('about_stat_3_number') ?: '16+';
$stat_3_label = get_field('about_stat_3_label') ?: esc_html__('Years of Experience', 'figma-custom-theme');
$journey_image = get_field('about_journey_image');
?>

<section class="about-journey-section">
    <div class="container">
        <div class="journey-content">
            <div class="journey-text">
                <div class="section-header">
                    <div class="decorative-pattern"></div>
                    <h2 class="section-title"><?php echo esc_html($journey_title); ?></h2>
                    <?php if ($journey_description) : ?>
                        <p class="section-description"><?php echo esc_html($journey_description); ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="journey-stats">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo esc_html($stat_1_number); ?></div>
                        <div class="stat-label"><?php echo esc_html($stat_1_label); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo esc_html($stat_2_number); ?></div>
                        <div class="stat-label"><?php echo esc_html($stat_2_label); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo esc_html($stat_3_number); ?></div>
                        <div class="stat-label"><?php echo esc_html($stat_3_label); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="journey-image">
                <?php 
                if ($journey_image) {
                    if (is_array($journey_image) && isset($journey_image['ID'])) {
                        echo wp_get_attachment_image($journey_image['ID'], 'large', false, array('alt' => esc_attr($journey_title)));
                    } elseif (is_numeric($journey_image)) {
                        echo wp_get_attachment_image($journey_image, 'large', false, array('alt' => esc_attr($journey_title)));
                    } else {
                        echo '<div class="image-placeholder"></div>';
                    }
                } else {
                    echo '<div class="image-placeholder"></div>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

