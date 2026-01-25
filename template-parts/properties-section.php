<?php
/**
 * Template part for displaying properties section
 *
 * @package Figma_Custom_Theme
 */
?>

<section class="properties-section" id="properties">
    <div class="container">
        <div class="section-header">
            <div class="section-content">
                <h2 class="section-title" <?php if (is_customize_preview()) echo 'data-customize-setting-link="homepage_properties_title"'; ?>>
                    <?php echo esc_html(get_theme_mod('homepage_properties_title', 'Featured Properties')); ?>
                </h2>
                <p class="section-description" <?php if (is_customize_preview()) echo 'data-customize-setting-link="homepage_properties_description"'; ?>>
                    <?php echo esc_html(get_theme_mod('homepage_properties_description', 'Explore our handpicked selection of featured properties. Each listing offers a glimpse into exceptional homes and investments available through Estatein. Click "View Details" for more information.')); ?>
                </p>
            </div>
            <div class="section-action">
                <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="btn btn-outline" <?php if (is_customize_preview()) echo 'data-customize-setting-link="homepage_properties_button_text"'; ?>>
                    <?php echo esc_html(get_theme_mod('homepage_properties_button_text', 'View All Properties')); ?>
                </a>
            </div>
        </div>

        <div class="properties-grid">
            <?php
            // WordPress Loop for Featured Properties
            $featured_properties = new WP_Query(array(
                'post_type' => 'property',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC'
            ));

            if ($featured_properties->have_posts()) :
                while ($featured_properties->have_posts()) : $featured_properties->the_post();
                    $property_price = get_field('property_price');
                    $property_description = get_field('property_description');
                    $property_location = get_field('property_location');
                    $property_bedrooms = get_field('property_bedrooms');
                    $property_bathrooms = get_field('property_bathrooms');
                    $property_area = get_field('property_area');
                    $property_types = get_the_terms(get_the_ID(), 'property_type');
            ?>
                <div class="property-card">
                        
                    <?php
                    // Get thumbnail image (the one with thumbnail checkbox checked) or first image
                    $display_image = null;
                    $display_alt = get_the_title();
                    $is_placeholder = false;
                    $thumbnail_image = null;
                    
                    // Find the thumbnail image
                    for ($i = 1; $i <= 10; $i++) {
                        $image = get_field('property_image_' . $i);
                        $is_thumbnail = get_field('property_image_' . $i . '_thumbnail');
                        
                        if ($image && $is_thumbnail) {
                            $thumbnail_image = $image;
                            break;
                        }
                    }
                    
                    // If no thumbnail found, use first available image
                    if (!$thumbnail_image) {
                        for ($i = 1; $i <= 10; $i++) {
                            $image = get_field('property_image_' . $i);
                            if ($image) {
                                $thumbnail_image = $image;
                                break;
                            }
                        }
                    }
                    
                    if ($thumbnail_image) {
                        if (isset($thumbnail_image['sizes']['property-image'])) {
                            $display_image = $thumbnail_image['sizes']['property-image'];
                            $display_alt = isset($thumbnail_image['alt']) ? $thumbnail_image['alt'] : get_the_title();
                        } elseif (isset($thumbnail_image['url'])) {
                            $display_image = $thumbnail_image['url'];
                            $display_alt = isset($thumbnail_image['alt']) ? $thumbnail_image['alt'] : get_the_title();
                        }
                    } elseif (has_post_thumbnail()) {
                        $display_image = get_the_post_thumbnail_url(get_the_ID(), 'property-image');
                        $display_alt = get_the_title();
                    } else {
                        // Use placeholder - SVG with property icon
                        $placeholder_svg = '<svg width="432" height="318" xmlns="http://www.w3.org/2000/svg"><rect width="432" height="318" fill="#1A1A1A"/><g transform="translate(216, 130)"><path d="M-40 -20L-20 -40L20 -40L40 -20L40 20L20 40L-20 40L-40 20Z" fill="none" stroke="#262626" stroke-width="2"/><path d="M-20 -20L0 -40L20 -20" fill="none" stroke="#262626" stroke-width="2"/><path d="M-20 20L0 0L20 20" fill="none" stroke="#262626" stroke-width="2"/></g><text x="216" y="200" text-anchor="middle" fill="#666" font-family="Arial, sans-serif" font-size="14" font-weight="500">No Image Available</text></svg>';
                        $display_image = 'data:image/svg+xml;base64,' . base64_encode($placeholder_svg);
                        $is_placeholder = true;
                    }
                    ?>
                    <div class="property-image <?php echo $is_placeholder ? 'property-image-placeholder' : ''; ?>">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo esc_url($display_image); ?>" 
                                     alt="<?php echo esc_attr($display_alt); ?>"
                                     loading="lazy">
                            </a>
                        </div>
                        
                        <div class="property-content">
                            <div class="property-info">
                                <h3 class="property-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>

                                <?php if (has_excerpt()) : ?>
                                    <p class="property-description">
                                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), 15)); ?>
                                        <span> </span>
                                        <a href="<?php the_permalink(); ?>" class="read-more">
                                            <?php echo esc_html__('Read More', 'figma-custom-theme'); ?>
                                        </a>  
                                    </p>
                                <?php endif; ?>
                            </div>

                            <?php if ($property_bedrooms || $property_bathrooms || $property_types) : ?>
                                <div class="property-features">
                                    <?php if ($property_bedrooms) : ?>
                                        <span class="feature-badge">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2"/>
                                                <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2"/>
                                            </svg>
                                            <?php echo esc_html($property_bedrooms . '-Bedroom'); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($property_bathrooms) : ?>
                                        <span class="feature-badge">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                <path d="M12 2C13.1046 2 14 2.89543 14 4V5H18C19.1046 5 20 5.89543 20 7V19C20 20.1046 19.1046 21 18 21H6C4.89543 21 4 20.1046 4 19V7C4 5.89543 4.89543 5 6 5H10V4C10 2.89543 10.8954 2 12 2Z" stroke="currentColor" stroke-width="2"/>
                                            </svg>
                                            <?php echo esc_html($property_bathrooms . '-Bathroom'); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($property_types && !is_wp_error($property_types)) : ?>
                                        <span class="feature-badge">
                                            <?php echo esc_html($property_types[0]->name); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="property-footer">
                                <?php if ($property_price) : ?>
                                    <div class="property-price">
                                        <span class="price-label"><?php echo esc_html__('Price', 'figma-custom-theme'); ?></span>
                                        <span class="price-value"><?php echo esc_html($property_price); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary property-cta">
                                    <?php echo esc_html__('View Details', 'figma-custom-theme'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Display message when no properties are found
                ?>
                <div class="no-properties-found">
                    <p class="no-properties-message">
                        <?php echo esc_html__('No properties found.', 'figma-custom-theme'); ?>
                    </p>
                </div>
                <?php
            endif;
            ?>
        </div>

        <div class="properties-pagination">
            <span class="pagination-info">
                <span class="current">01</span> 
                <span class="total"><?php echo esc_html__('of 60', 'figma-custom-theme'); ?></span>
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
