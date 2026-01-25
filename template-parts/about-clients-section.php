<?php
/**
 * Template part for displaying Valued Clients section
 *
 * @package Figma_Custom_Theme
 */

$clients_title = get_field('about_clients_title') ?: esc_html__('Our Valued Clients', 'figma-custom-theme');
$clients_description = get_field('about_clients_description') ?: '';
?>

<section class="about-clients-section">
    <div class="container">
        <div class="clients-header">
            <div class="decorative-pattern"></div>
            <h2 class="section-title"><?php echo esc_html($clients_title); ?></h2>
            <?php if ($clients_description) : ?>
                <p class="section-description"><?php echo esc_html($clients_description); ?></p>
            <?php endif; ?>
        </div>
        
        <?php 
        // Get clients from individual ACF fields (ACF Free compatible)
        $clients = array();
        
        // Client 1
        $client_1_company = get_field('client_1_company_name');
        if ($client_1_company) {
            $clients[] = array(
                'company_name' => $client_1_company,
                'since_date' => get_field('client_1_since_date') ?: '',
                'website_url' => get_field('client_1_website_url') ?: '',
                'domain' => get_field('client_1_domain') ?: '',
                'category' => get_field('client_1_category') ?: '',
                'testimonial' => get_field('client_1_testimonial') ?: '',
            );
        }
        
        // Client 2
        $client_2_company = get_field('client_2_company_name');
        if ($client_2_company) {
            $clients[] = array(
                'company_name' => $client_2_company,
                'since_date' => get_field('client_2_since_date') ?: '',
                'website_url' => get_field('client_2_website_url') ?: '',
                'domain' => get_field('client_2_domain') ?: '',
                'category' => get_field('client_2_category') ?: '',
                'testimonial' => get_field('client_2_testimonial') ?: '',
            );
        }
        
        // Client 3
        $client_3_company = get_field('client_3_company_name');
        if ($client_3_company) {
            $clients[] = array(
                'company_name' => $client_3_company,
                'since_date' => get_field('client_3_since_date') ?: '',
                'website_url' => get_field('client_3_website_url') ?: '',
                'domain' => get_field('client_3_domain') ?: '',
                'category' => get_field('client_3_category') ?: '',
                'testimonial' => get_field('client_3_testimonial') ?: '',
            );
        }
        
        // Client 4
        $client_4_company = get_field('client_4_company_name');
        if ($client_4_company) {
            $clients[] = array(
                'company_name' => $client_4_company,
                'since_date' => get_field('client_4_since_date') ?: '',
                'website_url' => get_field('client_4_website_url') ?: '',
                'domain' => get_field('client_4_domain') ?: '',
                'category' => get_field('client_4_category') ?: '',
                'testimonial' => get_field('client_4_testimonial') ?: '',
            );
        }
        
        // For JavaScript pagination
        $clients_per_page = 2;
        $total_clients = count($clients);
        $total_pages = ceil($total_clients / $clients_per_page);
        
        if (!empty($clients)) : ?>
            <div class="clients-grid" data-clients-per-page="<?php echo esc_attr($clients_per_page); ?>" data-total-pages="<?php echo esc_attr($total_pages); ?>">
                <?php foreach ($clients as $index => $client) : ?>
                    <div class="client-card <?php echo ($index >= $clients_per_page) ? 'hidden' : ''; ?>" data-client-index="<?php echo esc_attr($index); ?>">
                        <div class="client-header">
                            <div class="client-info">
                                <?php if ($client['since_date']) : ?>
                                    <p class="client-since"><?php echo esc_html($client['since_date']); ?></p>
                                <?php endif; ?>
                                <h3 class="client-name"><?php echo esc_html($client['company_name'] ?: ''); ?></h3>
                            </div>
                            <?php if ($client['website_url']) : ?>
                                <a href="<?php echo esc_url($client['website_url']); ?>" target="_blank" rel="noopener noreferrer" class="client-website-btn">
                                    <?php echo esc_html__('Visit Website', 'figma-custom-theme'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="client-details">
                            <div class="client-detail-item">
                                <div class="detail-label">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="3" width="18" height="18" rx="3" stroke="currentColor" stroke-width="1.5"/>
                                    </svg>
                                    <span><?php echo esc_html__('Domain', 'figma-custom-theme'); ?></span>
                                </div>
                                <p class="detail-value"><?php echo esc_html($client['domain'] ?: ''); ?></p>
                            </div>
                            
                            <div class="client-detail-item">
                                <div class="detail-label">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="1.5"/>
                                    </svg>
                                    <span><?php echo esc_html__('Category', 'figma-custom-theme'); ?></span>
                                </div>
                                <p class="detail-value"><?php echo esc_html($client['category'] ?: ''); ?></p>
                            </div>
                        </div>
                        
                        <?php if ($client['testimonial']) : ?>
                            <div class="client-testimonial">
                                <p class="testimonial-label"><?php echo esc_html__('What They Said', 'figma-custom-theme'); ?> 🤗</p>
                                <p class="testimonial-text"><?php echo esc_html($client['testimonial']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if ($total_pages > 1) : ?>
                <div class="clients-pagination">
                    <div class="pagination-info">
                        <span class="current-page">01</span>
                        <span class="total-pages"><?php printf(esc_html__('of %02d', 'figma-custom-theme'), $total_pages); ?></span>
                    </div>
                    <div class="pagination-nav">
                        <button class="nav-btn nav-prev disabled" disabled>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </button>
                        <button class="nav-btn nav-next <?php echo ($total_pages <= 1) ? 'disabled' : ''; ?>" <?php echo ($total_pages <= 1) ? 'disabled' : ''; ?>>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <div class="no-clients-found">
                <p><?php echo esc_html__('No clients found.', 'figma-custom-theme'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

