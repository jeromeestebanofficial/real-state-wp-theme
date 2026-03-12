<?php
/**
 * Template part for displaying Properties Contact Form section
 *
 * @package Figma_Custom_Theme
 */

// Get content - check if on page template first, then archive (customizer), then defaults
if (is_page_template('page-properties.php') || (is_page() && get_queried_object() && get_queried_object()->post_name === 'properties')) {
    // Page template - use ACF fields
    $contact_title = get_field('properties_contact_title') ?: esc_html__('Let\'s Make it Happen', 'figma-custom-theme');
    $contact_description = get_field('properties_contact_description') ?: esc_html__('Ready to take the first step toward your dream property? Fill out the form below, and our real estate wizards will work their magic to find your perfect match. Don\'t wait; let\'s embark on this exciting journey together.', 'figma-custom-theme');
} elseif (is_post_type_archive('property') || is_tax('property_type') || is_tax('property_location')) {
    // Archive page - use Customizer settings
    $contact_title = get_theme_mod('properties_archive_contact_title', 'Let\'s Make it Happen');
    $contact_description = get_theme_mod('properties_archive_contact_description', 'Ready to take the first step toward your dream property? Fill out the form below, and our real estate wizards will work their magic to find your perfect match. Don\'t wait; let\'s embark on this exciting journey together.');
} else {
    // Defaults
    $contact_title = esc_html__('Let\'s Make it Happen', 'figma-custom-theme');
    $contact_description = esc_html__('Ready to take the first step toward your dream property? Fill out the form below, and our real estate wizards will work their magic to find your perfect match. Don\'t wait; let\'s embark on this exciting journey together.', 'figma-custom-theme');
}

$form_submitted_status = isset($_GET['form_submitted']) ? sanitize_key(wp_unslash($_GET['form_submitted'])) : '';

$posted_first_name = isset($_POST['first_name']) ? sanitize_text_field(wp_unslash($_POST['first_name'])) : '';
$posted_last_name = isset($_POST['last_name']) ? sanitize_text_field(wp_unslash($_POST['last_name'])) : '';
$posted_email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
$posted_phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
$posted_preferred_location = isset($_POST['preferred_location']) ? sanitize_title(wp_unslash($_POST['preferred_location'])) : '';
$posted_property_type = isset($_POST['property_type_select']) ? sanitize_title(wp_unslash($_POST['property_type_select'])) : '';
$posted_bathrooms = isset($_POST['bathrooms']) ? sanitize_text_field(wp_unslash($_POST['bathrooms'])) : '';
$posted_bedrooms = isset($_POST['bedrooms']) ? sanitize_text_field(wp_unslash($_POST['bedrooms'])) : '';
$posted_budget = isset($_POST['budget']) ? sanitize_text_field(wp_unslash($_POST['budget'])) : '';
$posted_contact_method = isset($_POST['contact_method']) ? sanitize_key(wp_unslash($_POST['contact_method'])) : 'phone';
$posted_message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';
?>

<section class="properties-contact-section">
    <div class="container">
        <div class="section-header">
            <div class="decorative-pattern"></div>
            <h2 class="section-title"><?php echo esc_html($contact_title); ?></h2>
            <?php if ($contact_description) : ?>
                <p class="section-description"><?php echo esc_html($contact_description); ?></p>
            <?php endif; ?>
        </div>
        
        <div class="contact-form-wrapper">
            <?php
            // Display success/error messages
            if ('success' === $form_submitted_status) {
                echo '<div class="form-message form-success">';
                echo esc_html__('Thank you! Your message has been sent successfully. We will get back to you soon.', 'figma-custom-theme');
                echo '</div>';
            }
            if ('error' === $form_submitted_status) {
                echo '<div class="form-message form-error">';
                echo esc_html__('Sorry, there was an error sending your message. Please try again.', 'figma-custom-theme');
                echo '</div>';
            }
            ?>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="properties-contact-form" id="properties-contact-form">
                <input type="hidden" name="action" value="properties_contact_form">
                <?php wp_nonce_field('properties_contact_form', 'properties_contact_nonce'); ?>
                <div class="form-fields">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name"><?php echo esc_html__('First Name', 'figma-custom-theme'); ?></label>
                            <div class="form-input-wrapper">
                                <input type="text" id="first_name" name="first_name" placeholder="<?php echo esc_attr__('Enter First Name', 'figma-custom-theme'); ?>" value="<?php echo esc_attr($posted_first_name); ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name"><?php echo esc_html__('Last Name', 'figma-custom-theme'); ?></label>
                            <div class="form-input-wrapper">
                                <input type="text" id="last_name" name="last_name" placeholder="<?php echo esc_attr__('Enter Last Name', 'figma-custom-theme'); ?>" value="<?php echo esc_attr($posted_last_name); ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email"><?php echo esc_html__('Email', 'figma-custom-theme'); ?></label>
                            <div class="form-input-wrapper">
                                <input type="email" id="email" name="email" placeholder="<?php echo esc_attr__('Enter your Email', 'figma-custom-theme'); ?>" value="<?php echo esc_attr($posted_email); ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone"><?php echo esc_html__('Phone', 'figma-custom-theme'); ?></label>
                            <div class="form-input-wrapper">
                                <input type="tel" id="phone" name="phone" placeholder="<?php echo esc_attr__('Enter Phone Number', 'figma-custom-theme'); ?>" value="<?php echo esc_attr($posted_phone); ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="preferred_location"><?php echo esc_html__('Preferred Location', 'figma-custom-theme'); ?></label>
                            <div class="form-select-wrapper">
                                <select id="preferred_location" name="preferred_location" class="form-select">
                                    <option value=""><?php echo esc_html__('Select Location', 'figma-custom-theme'); ?></option>
                                    <?php
                                    $locations = get_terms(array(
                                        'taxonomy' => 'property_location',
                                        'hide_empty' => false,
                                    ));
                                    $selected_location = $posted_preferred_location;
                                    if ($locations && !is_wp_error($locations)) :
                                        foreach ($locations as $location) :
                                    ?>
                                        <option value="<?php echo esc_attr($location->slug); ?>" <?php selected($selected_location, $location->slug); ?>><?php echo esc_html($location->name); ?></option>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                                <div class="select-arrow">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M6 9L12 15L18 9" stroke="white" stroke-width="1.5"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="property_type_select"><?php echo esc_html__('Property Type', 'figma-custom-theme'); ?></label>
                            <div class="form-select-wrapper">
                                <select id="property_type_select" name="property_type_select" class="form-select">
                                    <option value=""><?php echo esc_html__('Select Property Type', 'figma-custom-theme'); ?></option>
                                    <?php
                                    $types = get_terms(array(
                                        'taxonomy' => 'property_type',
                                        'hide_empty' => false,
                                    ));
                                    $selected_type = $posted_property_type;
                                    if ($types && !is_wp_error($types)) :
                                        foreach ($types as $type) :
                                    ?>
                                        <option value="<?php echo esc_attr($type->slug); ?>" <?php selected($selected_type, $type->slug); ?>><?php echo esc_html($type->name); ?></option>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                                <div class="select-arrow">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M6 9L12 15L18 9" stroke="white" stroke-width="1.5"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bathrooms"><?php echo esc_html__('No. of Bathrooms', 'figma-custom-theme'); ?></label>
                            <div class="form-select-wrapper">
                                <select id="bathrooms" name="bathrooms" class="form-select">
                                    <option value=""><?php echo esc_html__('Select no. of Bathrooms', 'figma-custom-theme'); ?></option>
                                    <?php
                                    $selected_bathrooms = $posted_bathrooms;
                                    ?>
                                    <option value="1" <?php selected($selected_bathrooms, '1'); ?>>1</option>
                                    <option value="2" <?php selected($selected_bathrooms, '2'); ?>>2</option>
                                    <option value="3" <?php selected($selected_bathrooms, '3'); ?>>3</option>
                                    <option value="4" <?php selected($selected_bathrooms, '4'); ?>>4+</option>
                                </select>
                                <div class="select-arrow">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M6 9L12 15L18 9" stroke="white" stroke-width="1.5"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bedrooms"><?php echo esc_html__('No. of Bedrooms', 'figma-custom-theme'); ?></label>
                            <div class="form-select-wrapper">
                                <select id="bedrooms" name="bedrooms" class="form-select">
                                    <option value=""><?php echo esc_html__('Select no. of Bedrooms', 'figma-custom-theme'); ?></option>
                                    <?php
                                    $selected_bedrooms = $posted_bedrooms;
                                    ?>
                                    <option value="1" <?php selected($selected_bedrooms, '1'); ?>>1</option>
                                    <option value="2" <?php selected($selected_bedrooms, '2'); ?>>2</option>
                                    <option value="3" <?php selected($selected_bedrooms, '3'); ?>>3</option>
                                    <option value="4" <?php selected($selected_bedrooms, '4'); ?>>4+</option>
                                </select>
                                <div class="select-arrow">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M6 9L12 15L18 9" stroke="white" stroke-width="1.5"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row form-row-two-columns">
                        <div class="form-group">
                            <label for="budget"><?php echo esc_html__('Budget', 'figma-custom-theme'); ?></label>
                            <div class="form-select-wrapper">
                                <select id="budget" name="budget" class="form-select">
                                    <option value=""><?php echo esc_html__('Select Budget', 'figma-custom-theme'); ?></option>
                                    <?php
                                    $selected_budget = $posted_budget;
                                    ?>
                                    <option value="0-250000" <?php selected($selected_budget, '0-250000'); ?>>$0 - $250,000</option>
                                    <option value="250000-500000" <?php selected($selected_budget, '250000-500000'); ?>>$250,000 - $500,000</option>
                                    <option value="500000-1000000" <?php selected($selected_budget, '500000-1000000'); ?>>$500,000 - $1,000,000</option>
                                    <option value="1000000+" <?php selected($selected_budget, '1000000+'); ?>>$1,000,000+</option>
                                </select>
                                <div class="select-arrow">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M6 9L12 15L18 9" stroke="white" stroke-width="1.5"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo esc_html__('Preferred Contact Method', 'figma-custom-theme'); ?></label>
                            <div class="contact-method-group">
                                <?php
                                $selected_method = $posted_contact_method;
                                ?>
                                <label class="contact-method-option">
                                    <input type="radio" name="contact_method" value="phone" <?php checked($selected_method, 'phone'); ?>>
                                    <div class="method-content">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect x="5" y="2" width="14" height="20" rx="2" fill="white"/>
                                        </svg>
                                        <span class="method-label"><?php echo esc_html__('Enter Your Number', 'figma-custom-theme'); ?></span>
                                        <span class="method-radio"></span>
                                    </div>
                                </label>
                                <label class="contact-method-option">
                                    <input type="radio" name="contact_method" value="email" <?php checked($selected_method, 'email'); ?>>
                                    <div class="method-content">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect x="3" y="5" width="18" height="14" rx="2" fill="white"/>
                                            <path d="M3 7L12 13L21 7" stroke="white" stroke-width="1.5"/>
                                        </svg>
                                        <span class="method-label"><?php echo esc_html__('Enter Your Email', 'figma-custom-theme'); ?></span>
                                        <span class="method-radio"></span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="message"><?php echo esc_html__('Message', 'figma-custom-theme'); ?></label>
                        <div class="form-textarea-wrapper">
                            <textarea id="message" name="message" rows="5" placeholder="<?php echo esc_attr__('Enter your Message here..', 'figma-custom-theme'); ?>"><?php echo esc_textarea($posted_message); ?></textarea>
                        </div>
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
                    <button type="submit" class="btn btn-primary submit-btn">
                        <?php echo esc_html__('Send Your Message', 'figma-custom-theme'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

