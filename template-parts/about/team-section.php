<?php
/**
 * Template part for displaying Team section
 *
 * @package Figma_Custom_Theme
 */

$team_title = get_field('about_team_title') ?: esc_html__('Meet the Estatein Team', 'figma-custom-theme');
$team_description = get_field('about_team_description') ?: '';

$team_query = new WP_Query(array(
    'post_type' => 'team_member',
    'posts_per_page' => 4,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC'
));
?>

<section class="about-team-section">
    <div class="container">
        <div class="team-header">
            <div class="decorative-pattern"></div>
            <h2 class="section-title"><?php echo esc_html($team_title); ?></h2>
            <?php if ($team_description) : ?>
                <p class="section-description"><?php echo esc_html($team_description); ?></p>
            <?php endif; ?>
        </div>
        
        <?php if ($team_query->have_posts()) : ?>
            <div class="team-grid">
                <?php while ($team_query->have_posts()) : $team_query->the_post(); 
                    $member_position = get_field('member_position');
                    $member_email = get_field('member_email');
                ?>
                    <div class="team-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="team-image">
                                <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                            </div>
                        <?php else : ?>
                            <div class="team-image">
                                <div class="image-placeholder"></div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="team-info">
                            <div class="team-details">
                                <h3 class="team-name"><?php the_title(); ?></h3>
                                <?php if ($member_position) : ?>
                                    <p class="team-position"><?php echo esc_html($member_position); ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="team-contact-btn">
                                <span><?php echo esc_html__('Say Hello', 'figma-custom-theme'); ?> 👋</span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M22 2L11 13" stroke="currentColor" stroke-width="2"/>
                                    <polygon points="22,2 15,22 11,13 2,9 22,2" fill="currentColor"/>
                                </svg>
                            </a>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="team-link-icon" aria-label="<?php echo esc_attr(sprintf(__('View %s profile', 'figma-custom-theme'), get_the_title())); ?>">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M18 13V19A2 2 0 0 1 16 21H5A2 2 0 0 1 3 19V8A2 2 0 0 1 5 6H11" stroke="currentColor" stroke-width="2"/>
                                <path d="M15 3H21V9" stroke="currentColor" stroke-width="2"/>
                                <path d="M10 14L21 3" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="no-team-found">
                <p><?php echo esc_html__('No team members found.', 'figma-custom-theme'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

