<?php
/**
 * The template for displaying single property posts
 *
 * @package Figma_Custom_Theme
 */

get_header(); 

/**
 * Helper function to parse textarea fields (format: "Name: Amount")
 */
if (!function_exists('parse_property_field')) {
    function parse_property_field($field_value) {
        if (empty($field_value)) {
            return array();
        }
        $items = array();
        $lines = explode("\n", $field_value);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            // Check if line contains colon separator
            if (strpos($line, ':') !== false) {
                $parts = explode(':', $line, 2);
                $items[] = array(
                    'name' => trim($parts[0]),
                    'amount' => trim($parts[1])
                );
            } else {
                // If no colon, treat entire line as name
                $items[] = array(
                    'name' => $line,
                    'amount' => ''
                );
            }
        }
        return $items;
    }
}
?>

<main id="primary" class="site-main property-single-page">
    <div class="container property-single-container">
        <?php
        while (have_posts()) :
            the_post();
            
            $property_price = get_field('property_price');
            $property_location = get_field('property_location');
            $property_listing_price = get_field('property_listing_price');
            $property_bedrooms = get_field('property_bedrooms');
            $property_bathrooms = get_field('property_bathrooms');
            $property_area = get_field('property_area');
            
            // Get all feature fields
            $property_features = array();
            for ($i = 1; $i <= 10; $i++) {
                $feature = get_field('property_feature_' . $i);
                if ($feature && trim($feature) !== '') {
                    $property_features[] = $feature;
                }
            }
            
            $property_additional_fees = get_field('property_additional_fees');
            $property_monthly_costs = get_field('property_monthly_costs');
            $property_total_initial_costs = get_field('property_total_initial_costs');
            $property_monthly_expenses = get_field('property_monthly_expenses');
            
            // Get property images from individual fields
            $property_images = array();
            $thumbnail_image = null;
            
            // Collect all images and find the thumbnail
            for ($i = 1; $i <= 10; $i++) {
                $image = get_field('property_image_' . $i);
                $is_thumbnail = get_field('property_image_' . $i . '_thumbnail');
                
                if ($image) {
                    $property_images[] = $image;
                    // If this image is marked as thumbnail, save it
                    if ($is_thumbnail && !$thumbnail_image) {
                        $thumbnail_image = $image;
                    }
                }
            }
            
            // If no thumbnail was selected, use the first image
            if (!$thumbnail_image && !empty($property_images)) {
                $thumbnail_image = $property_images[0];
            }
            
            // Fallback to featured image if no ACF images
            if (empty($property_images) && has_post_thumbnail()) {
                $featured_image_id = get_post_thumbnail_id();
                $property_images[] = array(
                    'ID' => $featured_image_id,
                    'url' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
                    'sizes' => array(
                        'large' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
                    ),
                    'alt' => get_the_title(),
                );
                $thumbnail_image = $property_images[0];
            }
            
            // Create placeholder if no images at all
            $placeholder_svg = '<svg width="800" height="600" xmlns="http://www.w3.org/2000/svg"><rect width="800" height="600" fill="#1A1A1A"/><g transform="translate(400, 250)"><path d="M-60 -30L-30 -60L30 -60L60 -30L60 30L30 60L-30 60L-60 30Z" fill="none" stroke="#262626" stroke-width="3"/><path d="M-30 -30L0 -60L30 -30" fill="none" stroke="#262626" stroke-width="3"/><path d="M-30 30L0 0L30 30" fill="none" stroke="#262626" stroke-width="3"/></g><text x="400" y="380" text-anchor="middle" fill="#666" font-family="Arial, sans-serif" font-size="20" font-weight="500">No Image Available</text></svg>';
            $placeholder_image = 'data:image/svg+xml;base64,' . base64_encode($placeholder_svg);
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('property-single'); ?>>
                
                <!-- Property Header Section -->
                <div class="property-header-section">
                    <div class="property-header-top">
                        <div class="property-title-wrapper">
                            <h1 class="property-title"><?php the_title(); ?></h1>
                            <?php if ($property_location) : ?>
                                <div class="property-location-badge">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M21 10C21 17L12 23L3 10C3 6.13 7.03 3 12 3S21 6.13 21 10Z" stroke="currentColor" stroke-width="2"/>
                                        <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                    <span><?php echo esc_html($property_location); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="property-price-wrapper">
                            <div class="price-label"><?php echo esc_html__('Price', 'figma-custom-theme'); ?></div>
                            <div class="price-value">
                                <?php 
                                if ($property_listing_price) {
                                    echo esc_html($property_listing_price);
                                } elseif ($property_price) {
                                    echo esc_html($property_price);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Property Gallery Section -->
                <div class="property-gallery-section">
                    <div class="property-gallery-container">
                        <!-- Thumbnail Strip -->
                        <?php if (!empty($property_images) && count($property_images) > 1) : ?>
                            <div class="property-thumbnails">
                                <?php 
                                $thumb_count = 0;
                                foreach ($property_images as $index => $image) : 
                                    if ($thumb_count >= 9) break; // Limit to 9 thumbnails
                                    $thumb_count++;
                                    $image_url = isset($image['sizes']['medium']) ? $image['sizes']['medium'] : (isset($image['url']) ? $image['url'] : '');
                                    $image_alt = isset($image['alt']) ? $image['alt'] : get_the_title();
                                    $is_active = ($index === 0) ? 'active' : '';
                                ?>
                                    <div class="thumbnail-item <?php echo $is_active; ?>" data-index="<?php echo $index; ?>">
                                        <?php if ($image_url) : ?>
                                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy">
                                        <?php else : ?>
                                            <div class="thumbnail-placeholder"></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                        <!-- Main Gallery Images -->
                        <div class="property-main-gallery">
                        <?php if (!empty($property_images)) : ?>
                                        <?php
                                // Show first 2 images side by side
                                $main_images = array_slice($property_images, 0, 2);
                                foreach ($main_images as $index => $image) :
                                        $image_url = isset($image['sizes']['large']) ? $image['sizes']['large'] : (isset($image['url']) ? $image['url'] : '');
                                        $image_alt = isset($image['alt']) ? $image['alt'] : get_the_title();
                                ?>
                                    <div class="main-gallery-item">
                                        <?php if ($image_url) : ?>
                                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy">
                                        <?php else : ?>
                                            <div class="gallery-placeholder">
                                                <img src="<?php echo esc_url($placeholder_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                                
                                <!-- If only one image, duplicate it for the second slot -->
                                <?php if (count($main_images) === 1) : ?>
                                    <div class="main-gallery-item">
                                        <?php 
                                        $single_image = $main_images[0];
                                        $single_url = isset($single_image['sizes']['large']) ? $single_image['sizes']['large'] : (isset($single_image['url']) ? $single_image['url'] : '');
                                        $single_alt = isset($single_image['alt']) ? $single_image['alt'] : get_the_title();
                                        ?>
                                        <?php if ($single_url) : ?>
                                            <img src="<?php echo esc_url($single_url); ?>" alt="<?php echo esc_attr($single_alt); ?>" loading="lazy">
                                        <?php else : ?>
                                            <div class="gallery-placeholder">
                                                <img src="<?php echo esc_url($placeholder_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                            </div>
                                        <?php endif; ?>
                            </div>
                                <?php endif; ?>
                        <?php else : ?>
                                <!-- Placeholder if no images -->
                                <div class="main-gallery-item">
                                    <div class="gallery-placeholder">
                                        <img src="<?php echo esc_url($placeholder_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                    </div>
                                </div>
                                <div class="main-gallery-item">
                                    <div class="gallery-placeholder">
                                        <img src="<?php echo esc_url($placeholder_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                    </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                        <!-- Gallery Navigation -->
                        <?php if (!empty($property_images) && count($property_images) > 2) : ?>
                            <div class="gallery-navigation">
                                <button class="gallery-nav-btn prev-btn" aria-label="<?php echo esc_attr__('Previous', 'figma-custom-theme'); ?>">
                                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none">
                                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                </button>
                                <div class="gallery-dots">
                                <?php
                                    $total_images = count($property_images);
                                    $dots_to_show = min(6, ceil($total_images / 2)); // Show dots for image pairs
                                    for ($i = 0; $i < $dots_to_show; $i++) :
                                        $is_active = ($i === 0) ? 'active' : '';
                                    ?>
                                        <div class="gallery-dot <?php echo $is_active; ?>" data-slide="<?php echo $i; ?>"></div>
                                    <?php endfor; ?>
                                </div>
                                <button class="gallery-nav-btn next-btn" aria-label="<?php echo esc_attr__('Next', 'figma-custom-theme'); ?>">
                                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none">
                                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                </button>
                            </div>
                                <?php endif; ?>
                            </div>
                </div>
                
                
                <!-- Property Details Section -->
                <div class="property-details-section">
                    <div class="property-details-grid">
                        <!-- Left Column: Description & Features -->
                        <div class="property-description-column">
                            <div class="description-content">
                                <h2 class="section-title"><?php echo esc_html__('Description', 'figma-custom-theme'); ?></h2>
                                <div class="description-text">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                            
                            <div class="property-specs">
                                <?php if ($property_bedrooms) : ?>
                                    <div class="spec-item">
                                        <div class="spec-header">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2"/>
                                                <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                            <span class="spec-label"><?php echo esc_html__('Bedrooms', 'figma-custom-theme'); ?></span>
                                        </div>
                                        <div class="spec-value"><?php echo esc_html($property_bedrooms); ?></div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($property_bathrooms) : ?>
                                    <div class="spec-divider"></div>
                                    <div class="spec-item">
                                        <div class="spec-header">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M12 2C13.1046 2 14 2.89543 14 4V5H18C19.1046 5 20 5.89543 20 7V19C20 20.1046 19.1046 21 18 21H6C4.89543 21 4 20.1046 4 19V7C4 5.89543 4.89543 5 6 5H10V4C10 2.89543 10.8954 2 12 2Z" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                            <span class="spec-label"><?php echo esc_html__('Bathrooms', 'figma-custom-theme'); ?></span>
                                        </div>
                                        <div class="spec-value"><?php echo esc_html($property_bathrooms); ?></div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($property_area) : ?>
                                    <div class="spec-divider"></div>
                                    <div class="spec-item">
                                        <div class="spec-header">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                            <span class="spec-label"><?php echo esc_html__('Area', 'figma-custom-theme'); ?></span>
                                        </div>
                                        <div class="spec-value"><?php echo esc_html($property_area); ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Right Column: Key Features -->
                        <div class="property-features-column">
                            <h2 class="section-title"><?php echo esc_html__('Key Features and Amenities', 'figma-custom-theme'); ?></h2>
                            <?php if (!empty($property_features)) : ?>
                                <div class="features-list">
                                    <?php foreach ($property_features as $feature) : ?>
                                        <div class="feature-item">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2"/>
                                            </svg>
                                            <span><?php echo esc_html($feature); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                            </div>
                            <?php else : ?>
                                <p class="no-features"><?php echo esc_html__('No features listed.', 'figma-custom-theme'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form Section -->
                <div class="property-contact-section">
                    <div class="contact-section-wrapper">
                        <div class="contact-header">
                            <div class="decorative-pattern"></div>
                            <h2 class="section-title-large"><?php echo esc_html__('Inquire About', 'figma-custom-theme'); ?> <?php the_title(); ?></h2>
                            <p class="section-description"><?php echo esc_html__('Interested in this property? Fill out the form below, and our real estate experts will get back to you with more details, including scheduling a viewing and answering any questions you may have.', 'figma-custom-theme'); ?></p>
                        </div>
                        
                        <div class="contact-form-container">
                            <?php
                            // Display success/error messages
                            if (isset($_GET['form_submitted']) && $_GET['form_submitted'] === 'success') {
                                echo '<div class="form-message form-success">';
                                echo esc_html__('Thank you! Your message has been sent successfully. We will get back to you soon.', 'figma-custom-theme');
                                echo '</div>';
                            }
                            if (isset($_GET['form_submitted']) && $_GET['form_submitted'] === 'error') {
                                echo '<div class="form-message form-error">';
                                echo esc_html__('Sorry, there was an error sending your message. Please try again.', 'figma-custom-theme');
                                echo '</div>';
                            }
                            ?>
                            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="property-inquiry-form" id="property-inquiry-form">
                                <input type="hidden" name="action" value="properties_contact_form">
                                <?php wp_nonce_field('properties_contact_form', 'properties_contact_nonce'); ?>
                                <input type="hidden" name="selected_property" value="<?php echo esc_attr(get_the_title() . ($property_location ? ', ' . $property_location : '')); ?>">
                                
                                <div class="form-fields-grid">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="first_name"><?php echo esc_html__('First Name', 'figma-custom-theme'); ?></label>
                                            <input type="text" id="first_name" name="first_name" placeholder="<?php echo esc_attr__('Enter First Name', 'figma-custom-theme'); ?>" value="<?php echo isset($_POST['first_name']) ? esc_attr($_POST['first_name']) : ''; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="last_name"><?php echo esc_html__('Last Name', 'figma-custom-theme'); ?></label>
                                            <input type="text" id="last_name" name="last_name" placeholder="<?php echo esc_attr__('Enter Last Name', 'figma-custom-theme'); ?>" value="<?php echo isset($_POST['last_name']) ? esc_attr($_POST['last_name']) : ''; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="email"><?php echo esc_html__('Email', 'figma-custom-theme'); ?></label>
                                            <input type="email" id="email" name="email" placeholder="<?php echo esc_attr__('Enter your Email', 'figma-custom-theme'); ?>" value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone"><?php echo esc_html__('Phone', 'figma-custom-theme'); ?></label>
                                            <input type="tel" id="phone" name="phone" placeholder="<?php echo esc_attr__('Enter Phone Number', 'figma-custom-theme'); ?>" value="<?php echo isset($_POST['phone']) ? esc_attr($_POST['phone']) : ''; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group full-width">
                                        <label for="selected_property_display"><?php echo esc_html__('Selected Property', 'figma-custom-theme'); ?></label>
                                        <div class="property-select-display">
                                            <span><?php echo esc_html(get_the_title() . ($property_location ? ', ' . $property_location : '')); ?></span>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M21 10C21 17L12 23L3 10C3 6.13 7.03 3 12 3S21 6.13 21 10Z" stroke="currentColor" stroke-width="2"/>
                                                <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"/>
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group full-width">
                                        <label for="message"><?php echo esc_html__('Message', 'figma-custom-theme'); ?></label>
                                        <textarea id="message" name="message" rows="5" placeholder="<?php echo esc_attr__('Enter your Message here..', 'figma-custom-theme'); ?>" required><?php echo isset($_POST['message']) ? esc_textarea($_POST['message']) : ''; ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-footer">
                                    <label class="terms-checkbox">
                                        <input type="checkbox" name="terms" required>
                                        <span><?php echo esc_html__('I agree with ', 'figma-custom-theme'); ?>
                                            <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" target="_blank"><?php echo esc_html__('Terms of Use', 'figma-custom-theme'); ?></a>
                                            <?php echo esc_html__(' and ', 'figma-custom-theme'); ?>
                                            <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" target="_blank"><?php echo esc_html__('Privacy Policy', 'figma-custom-theme'); ?></a>
                                        </span>
                                    </label>
                                    <button type="submit" class="btn-submit">
                                        <?php echo esc_html__('Send Your Message', 'figma-custom-theme'); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Comprehensive Pricing Details Section -->
                <?php if ($property_listing_price || $property_price || $property_additional_fees || $property_monthly_costs || $property_total_initial_costs || $property_monthly_expenses) : ?>
                    <div class="pricing-details-section">
                        <div class="pricing-header">
                            <div class="pricing-title-wrapper">
                                <div class="decorative-pattern"></div>
                                <h2 class="section-title-large"><?php echo esc_html__('Comprehensive Pricing Details', 'figma-custom-theme'); ?></h2>
                                <p class="section-description"><?php echo esc_html__('At Estatein, transparency is key. We want you to have a clear understanding of all costs associated with your property investment. Below, we break down the pricing to help you make an informed decision.', 'figma-custom-theme'); ?></p>
                            </div>
                        </div>
                        
                        <div class="pricing-note">
                            <div class="note-label"><?php echo esc_html__('Note', 'figma-custom-theme'); ?></div>
                            <div class="note-divider"></div>
                            <div class="note-text"><?php echo esc_html__('The figures provided above are estimates and may vary depending on the property, location, and individual circumstances.', 'figma-custom-theme'); ?></div>
                        </div>
                        
                        <div class="pricing-content-wrapper">
                            <!-- Listing Price Sidebar -->
                            <div class="listing-price-sidebar">
                                <div class="price-label-small"><?php echo esc_html__('Listing Price', 'figma-custom-theme'); ?></div>
                                <div class="price-value-large">
                <?php
                                    if ($property_listing_price) {
                                        echo esc_html($property_listing_price);
                                    } elseif ($property_price) {
                                        echo esc_html($property_price);
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <!-- Pricing Cards -->
                            <div class="pricing-cards">
                                <?php 
                                $additional_fees_parsed = parse_property_field($property_additional_fees);
                                if (!empty($additional_fees_parsed)) : ?>
                                    <div class="pricing-card">
                                        <div class="pricing-card-header">
                                            <h3 class="pricing-card-title"><?php echo esc_html__('Additional Fees', 'figma-custom-theme'); ?></h3>
                                            <button class="learn-more-btn"><?php echo esc_html__('Learn More', 'figma-custom-theme'); ?></button>
                                        </div>
                                        <div class="pricing-card-divider"></div>
                                        <div class="pricing-card-content">
                            <?php
                                            $fee_pairs = array_chunk($additional_fees_parsed, 2);
                                            foreach ($fee_pairs as $pair) : ?>
                                                <div class="pricing-row">
                                                    <?php foreach ($pair as $fee) : ?>
                                                        <div class="pricing-item">
                                                            <div class="pricing-item-label"><?php echo esc_html($fee['name']); ?></div>
                                                            <div class="pricing-item-value-wrapper">
                                                                <div class="pricing-item-value"><?php echo esc_html($fee['amount']); ?></div>
                                                                <?php if (!empty($fee['amount'])) : ?>
                                                                    <div class="pricing-item-badge"><?php echo esc_html__('Details', 'figma-custom-theme'); ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <?php if (count($pair) === 2 && $fee !== end($pair)) : ?>
                                                            <div class="pricing-row-divider"></div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                                <?php if ($pair !== end($fee_pairs)) : ?>
                                                    <div class="pricing-card-divider"></div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                        </div>
                                    <?php endif; ?>
                                
                                        <?php
                                $monthly_costs_parsed = parse_property_field($property_monthly_costs);
                                if (!empty($monthly_costs_parsed)) : ?>
                                    <div class="pricing-card">
                                        <div class="pricing-card-header">
                                            <h3 class="pricing-card-title"><?php echo esc_html__('Monthly Costs', 'figma-custom-theme'); ?></h3>
                                            <button class="learn-more-btn"><?php echo esc_html__('Learn More', 'figma-custom-theme'); ?></button>
                                        </div>
                                        <div class="pricing-card-divider"></div>
                                        <div class="pricing-card-content">
                                            <?php foreach ($monthly_costs_parsed as $cost) : ?>
                                                <div class="pricing-item-single">
                                                    <div class="pricing-item-label"><?php echo esc_html($cost['name']); ?></div>
                                                    <div class="pricing-item-value-wrapper">
                                                        <div class="pricing-item-value"><?php echo esc_html($cost['amount']); ?></div>
                                                        <?php if (!empty($cost['amount'])) : ?>
                                                            <div class="pricing-item-badge"><?php echo esc_html__('Monthly', 'figma-custom-theme'); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                                <?php if ($cost !== end($monthly_costs_parsed)) : ?>
                                                    <div class="pricing-card-divider"></div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php 
                                $initial_costs_parsed = parse_property_field($property_total_initial_costs);
                                if (!empty($initial_costs_parsed)) : ?>
                                    <div class="pricing-card">
                                        <div class="pricing-card-header">
                                            <h3 class="pricing-card-title"><?php echo esc_html__('Total Initial Costs', 'figma-custom-theme'); ?></h3>
                                            <button class="learn-more-btn"><?php echo esc_html__('Learn More', 'figma-custom-theme'); ?></button>
                                        </div>
                                        <div class="pricing-card-divider"></div>
                                        <div class="pricing-card-content">
                                            <?php 
                                            $cost_pairs = array_chunk($initial_costs_parsed, 2);
                                            foreach ($cost_pairs as $pair) : ?>
                                                <div class="pricing-row">
                                                    <?php foreach ($pair as $cost) : ?>
                                                        <div class="pricing-item">
                                                            <div class="pricing-item-label"><?php echo esc_html($cost['name']); ?></div>
                                                            <div class="pricing-item-value"><?php echo esc_html($cost['amount']); ?></div>
                                                        </div>
                                                        <?php if (count($pair) === 2 && $cost !== end($pair)) : ?>
                                                            <div class="pricing-row-divider"></div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                                <?php if ($pair !== end($cost_pairs)) : ?>
                                                    <div class="pricing-card-divider"></div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php 
                                $monthly_expenses_parsed = parse_property_field($property_monthly_expenses);
                                if (!empty($monthly_expenses_parsed)) : ?>
                                    <div class="pricing-card">
                                        <div class="pricing-card-header">
                                            <h3 class="pricing-card-title"><?php echo esc_html__('Monthly Expenses', 'figma-custom-theme'); ?></h3>
                                            <button class="learn-more-btn"><?php echo esc_html__('Learn More', 'figma-custom-theme'); ?></button>
                                        </div>
                                        <div class="pricing-card-divider"></div>
                                        <div class="pricing-card-content">
                                <?php
                                            $expense_pairs = array_chunk($monthly_expenses_parsed, 2);
                                            foreach ($expense_pairs as $pair) : ?>
                                                <div class="pricing-row">
                                                    <?php foreach ($pair as $expense) : ?>
                                                        <div class="pricing-item">
                                                            <div class="pricing-item-label"><?php echo esc_html($expense['name']); ?></div>
                                                            <div class="pricing-item-value"><?php echo esc_html($expense['amount']); ?></div>
                                                        </div>
                                                        <?php if (count($pair) === 2 && $expense !== end($pair)) : ?>
                                                            <div class="pricing-row-divider"></div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                                <?php if ($pair !== end($expense_pairs)) : ?>
                                                    <div class="pricing-card-divider"></div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Frequently Asked Questions Section -->
                <div class="property-faq-section">
                    <div class="faq-header">
                        <div class="faq-title-wrapper">
                            <div class="decorative-pattern"></div>
                            <h2 class="section-title-large"><?php echo esc_html__('Frequently Asked Questions', 'figma-custom-theme'); ?></h2>
                            <p class="section-description"><?php echo esc_html__('Find answers to common questions about Estatein\'s services, property listings, and the real estate process. We\'re here to provide clarity and assist you every step of the way.', 'figma-custom-theme'); ?></p>
                        </div>
                        <a href="#" class="view-all-faqs-btn"><?php echo esc_html__('View All FAQ\'s', 'figma-custom-theme'); ?></a>
                    </div>
                    
                    <div class="faq-content">
                        <div class="faq-grid">
                            <div class="faq-card">
                                <h3 class="faq-question"><?php echo esc_html__('How do I search for properties on Estatein?', 'figma-custom-theme'); ?></h3>
                                <p class="faq-answer"><?php echo esc_html__('Learn how to use our user-friendly search tools to find properties that match your criteria.', 'figma-custom-theme'); ?></p>
                                <button class="faq-read-more-btn"><?php echo esc_html__('Read More', 'figma-custom-theme'); ?></button>
                            </div>
                            
                            <div class="faq-card">
                                <h3 class="faq-question"><?php echo esc_html__('What documents do I need to sell my property through Estatein?', 'figma-custom-theme'); ?></h3>
                                <p class="faq-answer"><?php echo esc_html__('Find out about the necessary documentation for listing your property with us.', 'figma-custom-theme'); ?></p>
                                <button class="faq-read-more-btn"><?php echo esc_html__('Read More', 'figma-custom-theme'); ?></button>
                            </div>
                            
                            <div class="faq-card">
                                <h3 class="faq-question"><?php echo esc_html__('How can I contact an Estatein agent?', 'figma-custom-theme'); ?></h3>
                                <p class="faq-answer"><?php echo esc_html__('Discover the different ways you can get in touch with our experienced agents.', 'figma-custom-theme'); ?></p>
                                <button class="faq-read-more-btn"><?php echo esc_html__('Read More', 'figma-custom-theme'); ?></button>
                            </div>
                        </div>
                        
                        <div class="faq-pagination">
                            <div class="faq-pagination-info">
                                <span class="current-page">01</span>
                                <span class="total-pages"> of 10</span>
                            </div>
                            <div class="faq-pagination-nav">
                                <button class="faq-nav-btn prev-btn" aria-label="<?php echo esc_attr__('Previous', 'figma-custom-theme'); ?>" disabled>
                                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none">
                                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                </button>
                                <button class="faq-nav-btn next-btn" aria-label="<?php echo esc_attr__('Next', 'figma-custom-theme'); ?>">
                                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none">
                                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                

                
            </article>
            
        <?php endwhile; // End of the loop. ?>
    </div>
</main>

<?php
get_footer();
