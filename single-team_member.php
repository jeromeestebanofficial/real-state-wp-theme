<?php
/**
 * The template for displaying single team member posts
 *
 * @package Estatein_Theme
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            
            $member_position = get_field('member_position');
            $member_email = get_field('member_email');
            $member_phone = get_field('member_phone');
            $member_social = get_field('member_social');
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('team-member-single'); ?>>
                
                <div class="team-member-content">
                    <div class="member-profile">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="member-photo">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="member-contact-info">
                            <h1 class="member-name"><?php the_title(); ?></h1>
                            
                            <?php if ($member_position) : ?>
                                <div class="member-position"><?php echo esc_html($member_position); ?></div>
                            <?php endif; ?>
                            
                            <div class="member-contact-details">
                                <?php if ($member_email) : ?>
                                    <div class="contact-item">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                            <rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="2"/>
                                            <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                        <a href="mailto:<?php echo esc_attr($member_email); ?>">
                                            <?php echo esc_html($member_email); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($member_phone) : ?>
                                    <div class="contact-item">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                            <path d="M22 16.92V19.92C22 20.52 21.52 21 20.92 21H20.8C10.28 21 3 13.72 3 3.2V3.08C3 2.48 3.48 2 4.08 2H7.12C7.6 2 8 2.4 8 2.88V5.64C8 6.12 7.6 6.52 7.12 6.52H5.52C6.08 9.88 8.12 11.92 11.48 12.48V10.88C11.48 10.4 11.88 10 12.36 10H15.12C15.6 10 16 10.4 16 10.88V13.84C16 14.32 15.6 14.72 15.12 14.72H12.36C12.08 17.36 14.64 19.92 17.28 19.64C20.48 19.28 22 16.92 22 16.92Z" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                        <a href="tel:<?php echo esc_attr($member_phone); ?>">
                                            <?php echo esc_html($member_phone); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($member_social) : ?>
                                <div class="member-social-links">
                                    <?php foreach ($member_social as $social) : ?>
                                        <?php if ($social['social_url']) : ?>
                                            <a href="<?php echo esc_url($social['social_url']); ?>" 
                                               target="_blank" rel="noopener"
                                               class="social-link social-<?php echo esc_attr($social['social_platform']); ?>">
                                                <?php
                                                switch ($social['social_platform']) {
                                                    case 'facebook':
                                                        echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>';
                                                        break;
                                                    case 'twitter':
                                                        echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>';
                                                        break;
                                                    case 'linkedin':
                                                        echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>';
                                                        break;
                                                    case 'instagram':
                                                        echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>';
                                                        break;
                                                }
                                                ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="member-bio">
                        <?php the_content(); ?>
                    </div>
                </div>
                
            </article>
            
        <?php endwhile; // End of the loop. ?>
    </div>
</main>

<?php get_footer(); ?>
