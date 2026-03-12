<?php
/**
 * Template part for displaying Our Achievements section
 *
 * @package Estatein_Theme
 */

$achievements_title = get_field('about_achievements_title') ?: esc_html__('Our Achievements', 'estatein-theme');
$achievements_description = get_field('about_achievements_description') ?: '';
$achievements = get_field('about_achievements') ?: array();
?>

<section class="about-achievements-section">
    <div class="container">
        <div class="achievements-header">
            <div class="decorative-pattern"></div>
            <h2 class="section-title"><?php echo esc_html($achievements_title); ?></h2>
            <?php if ($achievements_description) : ?>
                <p class="section-description"><?php echo esc_html($achievements_description); ?></p>
            <?php endif; ?>
        </div>
        
        <div class="achievements-grid">
            <?php 
            // Get achievements from individual ACF fields (ACF Free compatible)
            $achievements = array();
            
            // Achievement 1
            $achievement_1_title = get_field('achievement_1_title');
            $achievement_1_description = get_field('achievement_1_description');
            if ($achievement_1_title) {
                $achievements[] = array(
                    'title' => $achievement_1_title,
                    'description' => $achievement_1_description ?: '',
                );
            }
            
            // Achievement 2
            $achievement_2_title = get_field('achievement_2_title');
            $achievement_2_description = get_field('achievement_2_description');
            if ($achievement_2_title) {
                $achievements[] = array(
                    'title' => $achievement_2_title,
                    'description' => $achievement_2_description ?: '',
                );
            }
            
            // Achievement 3
            $achievement_3_title = get_field('achievement_3_title');
            $achievement_3_description = get_field('achievement_3_description');
            if ($achievement_3_title) {
                $achievements[] = array(
                    'title' => $achievement_3_title,
                    'description' => $achievement_3_description ?: '',
                );
            }
            
            // Display achievements
            if (!empty($achievements)) : ?>
                <?php foreach ($achievements as $achievement) : ?>
                    <div class="achievement-card">
                        <h3 class="achievement-title"><?php echo esc_html($achievement['title'] ?: ''); ?></h3>
                        <p class="achievement-description"><?php echo esc_html($achievement['description'] ?: ''); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

