<?php
/**
 * Template part for displaying Our Values section
 *
 * @package Figma_Custom_Theme
 */

$values_title = get_field('about_values_title') ?: esc_html__('Our Values', 'figma-custom-theme');
$values_description = get_field('about_values_description') ?: "Our story is one of continuous growth and evolution. We started as a small team with big dreams, determined to create a real estate platform that transcended the ordinary.";
$values = get_field('about_values') ?: array();
?>

<section class="about-values-section">
    <div class="container">
        <div class="values-content">
            <div class="values-header">
                <div class="decorative-pattern"></div>
                <h2 class="section-title"><?php echo esc_html($values_title); ?></h2>
                <?php if ($values_description) : ?>
                    <p class="section-description"><?php echo esc_html($values_description); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="values-grid">
                <?php 
                // Get values from individual ACF fields (ACF Free compatible)
                $values = array();
                
                // Value 1
                $value_1_title = get_field('value_1_title');
                $value_1_description = get_field('value_1_description');
                $value_1_icon = get_field('value_1_icon');
                if ($value_1_title) {
                    $values[] = array(
                        'title' => $value_1_title,
                        'description' => $value_1_description ?: '',
                        'icon' => $value_1_icon,
                    );
                }
                
                // Value 2
                $value_2_title = get_field('value_2_title');
                $value_2_description = get_field('value_2_description');
                $value_2_icon = get_field('value_2_icon');
                if ($value_2_title) {
                    $values[] = array(
                        'title' => $value_2_title,
                        'description' => $value_2_description ?: '',
                        'icon' => $value_2_icon,
                    );
                }
                
                // Value 3
                $value_3_title = get_field('value_3_title');
                $value_3_description = get_field('value_3_description');
                $value_3_icon = get_field('value_3_icon');
                if ($value_3_title) {
                    $values[] = array(
                        'title' => $value_3_title,
                        'description' => $value_3_description ?: '',
                        'icon' => $value_3_icon,
                    );
                }
                
                // Value 4
                $value_4_title = get_field('value_4_title');
                $value_4_description = get_field('value_4_description');
                $value_4_icon = get_field('value_4_icon');
                if ($value_4_title) {
                    $values[] = array(
                        'title' => $value_4_title,
                        'description' => $value_4_description ?: '',
                        'icon' => $value_4_icon,
                    );
                }
                
                // Display values
                if (!empty($values)) : ?>
                    <?php foreach ($values as $value) : ?>
                        <div class="value-card">
                            <div class="value-header">
                                <div class="value-icon">
                                    <?php 
                                    $icon = isset($value['icon']) ? $value['icon'] : null;
                                    if ($icon && is_array($icon) && isset($icon['ID'])) {
                                        echo wp_get_attachment_image($icon['ID'], 'thumbnail', false, array('alt' => esc_attr($value['title'] ?: '')));
                                    } elseif ($icon && is_numeric($icon)) {
                                        echo wp_get_attachment_image($icon, 'thumbnail', false, array('alt' => esc_attr($value['title'] ?: '')));
                                    } else {
                                    ?>
                                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none">
                                            <path d="M17 2L20.09 8.26L27 9.27L22 14.14L23.18 21.02L17 17.77L10.82 21.02L12 14.14L7 9.27L13.91 8.26L17 2Z" fill="#A685FA"/>
                                        </svg>
                                    <?php } ?>
                                </div>
                                <h3 class="value-title"><?php echo esc_html($value['title'] ?: ''); ?></h3>
                            </div>
                            <p class="value-description"><?php echo esc_html($value['description'] ?: ""); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

