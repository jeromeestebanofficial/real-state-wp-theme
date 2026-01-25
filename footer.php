<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package Figma_Custom_Theme
 */

?>

    <!-- Call to Action Section -->
    <?php
    // Get CTA content from Customizer
    $cta_title = get_theme_mod('footer_cta_title', 'Start Your Real Estate Journey Today');
    $cta_description = get_theme_mod('footer_cta_description', 'Your dream property is just a click away. Whether you\'re looking for a new home, a strategic investment, or expert real estate advice, Estatein is here to assist you every step of the way.');
    $cta_button_text = get_theme_mod('footer_cta_button_text', 'Explore Properties');
    $cta_button_link = get_theme_mod('footer_cta_button_link', '');
    
    // Fallback to properties page if no custom link is set
    if (empty($cta_button_link)) {
        $properties_page = get_page_by_path('properties');
        $cta_button_link = $properties_page ? get_permalink($properties_page->ID) : get_post_type_archive_link('property');
    }
    ?>
    <section class="cta-section py-8" style="background: linear-gradient(135deg, var(--color-bg-secondary) 0%, var(--color-bg-primary) 100%); border-top: 1px solid var(--color-bg-tertiary); border-bottom: 1px solid var(--color-bg-tertiary);">
        <div class="container">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: var(--space-12); flex-wrap: wrap;">
                <div style="flex: 1; min-width: 300px;">
                    <h2 style="font-size: var(--font-size-5xl); font-weight: 600; color: var(--color-text-primary); margin-bottom: var(--space-4);">
                        <?php echo esc_html($cta_title); ?>
                    </h2>
                    <p style="font-size: var(--font-size-lg); color: var(--color-text-secondary); max-width: 500px; margin: 0;">
                        <?php echo esc_html($cta_description); ?>
                    </p>
                </div>
                <a href="<?php echo esc_url($cta_button_link); ?>" class="btn btn-primary" style="flex-shrink: 0;">
                    <?php echo esc_html($cta_button_text); ?>
                </a>
            </div>
        </div>
    </section>

    <footer id="colophon" class="site-footer">
        <div class="footer-main">
            <div class="container">
                <div class="footer-grid">
                    
                    <!-- Newsletter Section -->
                    <div class="footer-newsletter">
                        <div class="footer-logo">
                            <div class="logo-icon" style="color: var(--color-primary);">
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                    <rect width="24" height="24" fill="currentColor"/>
                                    <rect x="24" width="24" height="24" fill="currentColor"/>
                                    <rect y="24" width="24" height="24" fill="currentColor"/>
                                    <rect x="24" y="24" width="24" height="24" fill="currentColor"/>
                                </svg>
                            </div>
                            <span class="site-title" style="font-size: var(--font-size-2xl);">
                                <?php bloginfo('name'); ?>
                            </span>
                        </div>
                        
                        <div class="footer-email-form">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" style="color: var(--color-text-secondary);">
                                <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="2"/>
                                <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2"/>
                            </svg>
                            <input type="email" placeholder="<?php echo esc_attr__('Enter Your Email', 'figma-custom-theme'); ?>" class="footer-email-input">
                            <button type="submit" class="footer-email-submit">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M22 2L11 13" stroke="currentColor" stroke-width="2"/>
                                    <polygon points="22,2 15,22 11,13 2,9 22,2" fill="currentColor"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Footer Menu Columns -->
                    <div class="footer-menu footer-menu-home">
                        <h3 class="footer-menu-title">
                            <?php echo esc_html__('Home', 'figma-custom-theme'); ?>
                        </h3>
                        <ul class="footer-menu-list">
                            <li><a href="#hero"><?php echo esc_html__('Hero Section', 'figma-custom-theme'); ?></a></li>
                            <li><a href="#features"><?php echo esc_html__('Features', 'figma-custom-theme'); ?></a></li>
                            <li><a href="#properties"><?php echo esc_html__('Properties', 'figma-custom-theme'); ?></a></li>
                            <li><a href="#testimonials"><?php echo esc_html__('Testimonials', 'figma-custom-theme'); ?></a></li>
                        </ul>
                    </div>

                    <div class="footer-menu footer-menu-about">
                        <h3 class="footer-menu-title">
                            <?php echo esc_html__('About Us', 'figma-custom-theme'); ?>
                        </h3>
                        <ul class="footer-menu-list">
                            <li><a href="#"><?php echo esc_html__('Our Story', 'figma-custom-theme'); ?></a></li>
                            <li><a href="#"><?php echo esc_html__('Our Works', 'figma-custom-theme'); ?></a></li>
                            <li><a href="#"><?php echo esc_html__('How It Works', 'figma-custom-theme'); ?></a></li>
                            <li><a href="#"><?php echo esc_html__('Our Team', 'figma-custom-theme'); ?></a></li>
                        </ul>
                    </div>

                    <div class="footer-menu footer-menu-properties">
                        <h3 class="footer-menu-title">
                            <?php echo esc_html__('Properties', 'figma-custom-theme'); ?>
                        </h3>
                        <ul class="footer-menu-list">
                            <li><a href="#"><?php echo esc_html__('Portfolio', 'figma-custom-theme'); ?></a></li>
                            <li><a href="#"><?php echo esc_html__('Categories', 'figma-custom-theme'); ?></a></li>
                        </ul>
                    </div>

                    <div class="footer-menu footer-menu-services">
                        <h3 class="footer-menu-title">
                            <?php echo esc_html__('Services', 'figma-custom-theme'); ?>
                        </h3>
                        <ul class="footer-menu-list">
                            <li><a href="#"><?php echo esc_html__('Valuation Mastery', 'figma-custom-theme'); ?></a></li>
                            <li><a href="#"><?php echo esc_html__('Strategic Marketing', 'figma-custom-theme'); ?></a></li>
                            <li><a href="#"><?php echo esc_html__('Negotiation Wizardry', 'figma-custom-theme'); ?></a></li>
                            <li><a href="#"><?php echo esc_html__('Property Management', 'figma-custom-theme'); ?></a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-menu footer-menu-contact">
                        <h3 class="footer-menu-title">
                            <?php echo esc_html__('Contact Us', 'figma-custom-theme'); ?>
                        </h3>
                        <ul class="footer-menu-list">
                            <li><a href="#"><?php echo esc_html__('Get in Touch', 'figma-custom-theme'); ?></a></li>
                            <li><a href="#"><?php echo esc_html__('Support', 'figma-custom-theme'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="footer-copyright">
                        <p class="footer-copyright-text">
                            <?php
                            printf(
                                esc_html__('@%1$s Estatein. All Rights Reserved.', 'figma-custom-theme'),
                                date('Y')
                            );
                            ?>
                        </p>
                        <a href="#" class="footer-terms-link">
                            <?php echo esc_html__('Terms & Conditions', 'figma-custom-theme'); ?>
                        </a>
                    </div>

                    <!-- Social Links -->
                    <div class="footer-social">
                        <a href="#" class="footer-social-link">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="footer-social-link">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="footer-social-link">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="footer-social-link">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
