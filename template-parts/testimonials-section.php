<?php
/**
 * Template part for displaying testimonials section
 *
 * @package Figma_Custom_Theme
 */
?>

<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <div class="section-content">
                <h2 class="section-title" <?php if (is_customize_preview()) echo 'data-customize-setting-link="homepage_testimonials_title"'; ?>>
                    <?php echo esc_html(get_theme_mod('homepage_testimonials_title', 'What Our Clients Say')); ?>
                </h2>
                <p class="section-description" <?php if (is_customize_preview()) echo 'data-customize-setting-link="homepage_testimonials_description"'; ?>>
                    <?php echo esc_html(get_theme_mod('homepage_testimonials_description', 'Read the success stories and heartfelt testimonials from our valued clients. Discover why they chose Estatein for their real estate needs.')); ?>
                </p>
            </div>
            <div class="section-action">
                <a href="#" class="btn btn-outline" <?php if (is_customize_preview()) echo 'data-customize-setting-link="homepage_testimonials_button_text"'; ?>>
                    <?php echo esc_html(get_theme_mod('homepage_testimonials_button_text', 'View All Testimonials')); ?>
                </a>
            </div>
        </div>

        <div class="testimonials-grid">
            <?php
            // WordPress Loop for Testimonials using ACF
            $testimonials_query = new WP_Query(array(
                'post_type' => 'testimonial',
                'posts_per_page' => 3,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC'
            ));

            if ($testimonials_query->have_posts()) :
                while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                    $testimonial_rating = get_field('testimonial_rating') ?: 5;
                    $testimonial_client_name = get_field('testimonial_client_name');
                    $testimonial_client_location = get_field('testimonial_client_location');
                    $testimonial_client_avatar = get_field('testimonial_client_avatar');
                    
                    // Get avatar URL
                    if ($testimonial_client_avatar && is_array($testimonial_client_avatar)) {
                        $avatar_image_url = $testimonial_client_avatar['url'];
                        $avatar_image_alt = $testimonial_client_avatar['alt'] ?: $testimonial_client_name;
                    } elseif (has_post_thumbnail()) {
                        $avatar_image_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                        $avatar_image_alt = get_the_title();
                    } else {
                        $avatar_image_url = get_template_directory_uri() . '/assets/images/avatar-placeholder.jpg';
                        $avatar_image_alt = $testimonial_client_name ?: get_the_title();
                    }
            ?>
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <span class="star <?php echo $i <= $testimonial_rating ? 'filled' : ''; ?>">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" 
                                          fill="currentColor"/>
                                </svg>
                            </span>
                        <?php endfor; ?>
                    </div>

                    <div class="testimonial-content">
                        <h3 class="testimonial-title">
                            <?php the_title(); ?>
                        </h3>
                        <blockquote class="testimonial-text">
                            <?php echo esc_html(wp_trim_words(get_the_content(), 30)); ?>
                        </blockquote>
                    </div>

                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="<?php echo esc_url($avatar_image_url); ?>" 
                                 alt="<?php echo esc_attr($avatar_image_alt); ?>"
                                 loading="lazy">
                        </div>
                        <div class="author-info">
                            <div class="author-name">
                                <?php echo esc_html($testimonial_client_name ?: get_the_title()); ?>
                            </div>
                            <?php if ($testimonial_client_location) : ?>
                                <div class="author-location">
                                    <?php echo esc_html($testimonial_client_location); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Display message when no testimonials are found
                ?>
                <div class="no-testimonials-found">
                    <p class="no-testimonials-message">
                        <?php echo esc_html__('No testimonials found.', 'figma-custom-theme'); ?>
                    </p>
                </div>
                <?php
            endif;
            ?>
        </div>

        <div class="testimonials-pagination">
            <span class="pagination-info">
                <span class="current">01</span> 
                <span class="total"><?php echo esc_html__('of 10', 'figma-custom-theme'); ?></span>
            </span>
            <div class="pagination-nav">
                <button class="nav-btn nav-prev" disabled>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </button>
                <button class="nav-btn nav-next">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
