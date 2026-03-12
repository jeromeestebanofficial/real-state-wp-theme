<?php
/**
 * Template part for displaying How It Works / Process section
 *
 * @package Figma_Custom_Theme
 */

$process_title = get_field('about_process_title') ?: esc_html__('Navigating the Estatein Experience', 'figma-custom-theme');
$process_description = get_field('about_process_description') ?: '';
$process_steps = get_field('about_process_steps') ?: array();
?>

<section class="about-process-section">
    <div class="container">
        <div class="process-header">
            <div class="decorative-pattern"></div>
            <h2 class="section-title"><?php echo esc_html($process_title); ?></h2>
            <?php if ($process_description) : ?>
                <p class="section-description"><?php echo esc_html($process_description); ?></p>
            <?php endif; ?>
        </div>
        
        <div class="process-steps">
            <?php 
            // Get process steps from individual ACF fields (ACF Free compatible)
            $process_steps = array();
            
            // Step 1
            $step_1_title = get_field('step_1_title');
            $step_1_description = get_field('step_1_description');
            if ($step_1_title) {
                $process_steps[] = array(
                    'title' => $step_1_title,
                    'description' => $step_1_description ?: '',
                );
            }
            
            // Step 2
            $step_2_title = get_field('step_2_title');
            $step_2_description = get_field('step_2_description');
            if ($step_2_title) {
                $process_steps[] = array(
                    'title' => $step_2_title,
                    'description' => $step_2_description ?: '',
                );
            }
            
            // Step 3
            $step_3_title = get_field('step_3_title');
            $step_3_description = get_field('step_3_description');
            if ($step_3_title) {
                $process_steps[] = array(
                    'title' => $step_3_title,
                    'description' => $step_3_description ?: '',
                );
            }
            
            // Step 4
            $step_4_title = get_field('step_4_title');
            $step_4_description = get_field('step_4_description');
            if ($step_4_title) {
                $process_steps[] = array(
                    'title' => $step_4_title,
                    'description' => $step_4_description ?: '',
                );
            }
            
            // Step 5
            $step_5_title = get_field('step_5_title');
            $step_5_description = get_field('step_5_description');
            if ($step_5_title) {
                $process_steps[] = array(
                    'title' => $step_5_title,
                    'description' => $step_5_description ?: '',
                );
            }
            
            // Step 6
            $step_6_title = get_field('step_6_title');
            $step_6_description = get_field('step_6_description');
            if ($step_6_title) {
                $process_steps[] = array(
                    'title' => $step_6_title,
                    'description' => $step_6_description ?: '',
                );
            }
            
            // Display process steps
            if (!empty($process_steps)) : ?>
                <?php foreach ($process_steps as $index => $step) : ?>
                    <div class="process-step">
                        <div class="step-number">
                            <span><?php printf(esc_html__('Step %02d', 'figma-custom-theme'), $index + 1); ?></span>
                        </div>
                        <div class="step-content">
                            <h3 class="step-title"><?php echo esc_html($step['title'] ?: ''); ?></h3>
                            <p class="step-description"><?php echo esc_html($step['description'] ?: ''); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

