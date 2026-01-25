<?php
/**
 * Template part for displaying Properties Hero/Search section
 *
 * @package Figma_Custom_Theme
 */

// Get content - check if on page template first, then archive (customizer), then defaults
if (is_page_template('page-properties.php') || (is_page() && get_queried_object() && get_queried_object()->post_name === 'properties')) {
    // Page template - use ACF fields
    $hero_title = get_field('properties_hero_title') ?: esc_html__('Find Your Dream Property', 'figma-custom-theme');
    $hero_description = get_field('properties_hero_description') ?: esc_html__('Welcome to Estatein, where your dream property awaits in every corner of our beautiful world. Explore our curated selection of properties, each offering a unique story and a chance to redefine your life. With categories to suit every dreamer, your journey', 'figma-custom-theme');
} elseif (is_post_type_archive('property') || is_tax('property_type') || is_tax('property_location')) {
    // Archive page - use Customizer settings
    $hero_title = get_theme_mod('properties_archive_hero_title', 'Find Your Dream Property');
    $hero_description = get_theme_mod('properties_archive_hero_description', 'Welcome to Estatein, where your dream property awaits in every corner of our beautiful world. Explore our curated selection of properties, each offering a unique story and a chance to redefine your life. With categories to suit every dreamer, your journey');
} else {
    // Defaults
    $hero_title = esc_html__('Find Your Dream Property', 'figma-custom-theme');
    $hero_description = esc_html__('Welcome to Estatein, where your dream property awaits in every corner of our beautiful world. Explore our curated selection of properties, each offering a unique story and a chance to redefine your life. With categories to suit every dreamer, your journey', 'figma-custom-theme');
}

// Get taxonomies for search form
$property_types = get_terms(array(
    'taxonomy' => 'property_type',
    'hide_empty' => true,
));

$property_locations = get_terms(array(
    'taxonomy' => 'property_location',
    'hide_empty' => true,
));
?>

<section class="properties-hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="decorative-pattern"></div>

            <h1 class="hero-title" <?php if (is_customize_preview()) echo 'data-customize-setting-link="properties_archive_hero_title"'; ?>>
                    <?php echo esc_html(get_theme_mod('properties_archive_hero_title', 'Featured Properties')); ?>
            </h2>
            <?php if ($hero_description) : ?>
                <p class="hero-description"><?php echo esc_html($hero_description); ?></p>
            <?php endif; ?>
        </div>
        
        <div class="search-form-wrapper" style="display: block !important; visibility: visible !important;">
            <form method="get" action="<?php echo esc_url(is_post_type_archive('property') ? get_post_type_archive_link('property') : get_permalink()); ?>" class="properties-search-form" style="display: block !important; visibility: visible !important;">
                <div class="search-form-inner">
                    <div class="search-header-wrapper">
                        <div class="search-header">
                            <input type="text" name="search" class="search-input" placeholder="<?php echo esc_attr__('Search For A Property', 'figma-custom-theme'); ?>" value="<?php echo esc_attr(isset($_GET['search']) ? sanitize_text_field($_GET['search']) : ''); ?>">
                            <?php if (isset($_GET['location']) || isset($_GET['property_type']) || isset($_GET['price_range']) || isset($_GET['property_size']) || isset($_GET['build_year']) || isset($_GET['search'])) : ?>
                                <a href="<?php echo esc_url(is_post_type_archive('property') ? get_post_type_archive_link('property') : get_permalink()); ?>" class="clear-filters-btn" title="<?php echo esc_attr__('Clear All Filters', 'figma-custom-theme'); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <button type="submit" class="search-submit-btn">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <circle cx="11" cy="11" r="8" stroke="white" stroke-width="1.5"/>
                                    <path d="m21 21-4.35-4.35" stroke="white" stroke-width="1.5"/>
                                </svg>
                                <span><?php echo esc_html__('Find Property', 'figma-custom-theme'); ?></span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="search-filters">
                        <div class="filter-field">
                            <div class="filter-content">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="filter-icon">
                                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                </svg>
                                <div class="filter-divider"></div>
                                <select name="location" class="filter-select" data-filter="location">
                                    <option value=""><?php echo esc_html__('Location', 'figma-custom-theme'); ?></option>
                                    <?php if ($property_locations) : ?>
                                        <?php foreach ($property_locations as $location) : ?>
                                            <option value="<?php echo esc_attr($location->slug); ?>" <?php selected(isset($_GET['location']) ? $_GET['location'] : '', $location->slug); ?>>
                                                <?php echo esc_html($location->name); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <button type="button" class="filter-arrow" aria-label="<?php echo esc_attr__('Open dropdown', 'figma-custom-theme'); ?>" onclick="this.closest('.filter-field').querySelector('.filter-select').focus();">
                                <svg width="15" height="7.5" viewBox="0 0 15 7.5" fill="none">
                                    <path d="M1 6.5L7.5 1L14 6.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="filter-field">
                            <div class="filter-content">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="filter-icon">
                                    <path d="M3 7L12 2L21 7V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V7Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <path d="M9 21V12H15V21" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                </svg>
                                <div class="filter-divider"></div>
                                <select name="property_type" class="filter-select" data-filter="property_type">
                                    <option value=""><?php echo esc_html__('Property Type', 'figma-custom-theme'); ?></option>
                                    <?php if ($property_types) : ?>
                                        <?php foreach ($property_types as $type) : ?>
                                            <option value="<?php echo esc_attr($type->slug); ?>" <?php selected(isset($_GET['property_type']) ? $_GET['property_type'] : '', $type->slug); ?>>
                                                <?php echo esc_html($type->name); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <button type="button" class="filter-arrow" aria-label="<?php echo esc_attr__('Open dropdown', 'figma-custom-theme'); ?>" onclick="this.closest('.filter-field').querySelector('.filter-select').focus();">
                                <svg width="15" height="7.5" viewBox="0 0 15 7.5" fill="none">
                                    <path d="M1 6.5L7.5 1L14 6.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="filter-field">
                            <div class="filter-content">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="filter-icon">
                                    <path d="M12 2V22M17 5H9.5C8.57174 5 7.6815 5.36875 7.02513 6.02513C6.36875 6.6815 6 7.57174 6 8.5C6 9.42826 6.36875 10.3185 7.02513 10.9749C7.6815 11.6313 8.57174 12 9.5 12H14.5C15.4283 12 16.3185 12.3687 16.9749 13.0251C17.6313 13.6815 18 14.5717 18 15.5C18 16.4283 17.6313 17.3185 16.9749 17.9749C16.3185 18.6313 15.4283 19 14.5 19H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                </svg>
                                <div class="filter-divider"></div>
                                <select name="price_range" class="filter-select" data-filter="price_range">
                                    <option value=""><?php echo esc_html__('Pricing Range', 'figma-custom-theme'); ?></option>
                                    <option value="0-250000" <?php selected(isset($_GET['price_range']) ? $_GET['price_range'] : '', '0-250000'); ?>><?php echo esc_html__('$0 - $250,000', 'figma-custom-theme'); ?></option>
                                    <option value="250000-500000" <?php selected(isset($_GET['price_range']) ? $_GET['price_range'] : '', '250000-500000'); ?>><?php echo esc_html__('$250,000 - $500,000', 'figma-custom-theme'); ?></option>
                                    <option value="500000-1000000" <?php selected(isset($_GET['price_range']) ? $_GET['price_range'] : '', '500000-1000000'); ?>><?php echo esc_html__('$500,000 - $1,000,000', 'figma-custom-theme'); ?></option>
                                    <option value="1000000+" <?php selected(isset($_GET['price_range']) ? $_GET['price_range'] : '', '1000000+'); ?>><?php echo esc_html__('$1,000,000+', 'figma-custom-theme'); ?></option>
                                </select>
                            </div>
                            <button type="button" class="filter-arrow" aria-label="<?php echo esc_attr__('Open dropdown', 'figma-custom-theme'); ?>" onclick="this.closest('.filter-field').querySelector('.filter-select').focus();">
                                <svg width="15" height="7.5" viewBox="0 0 15 7.5" fill="none">
                                    <path d="M1 6.5L7.5 1L14 6.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="filter-field">
                            <div class="filter-content">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="filter-icon">
                                    <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <path d="M3 9H21M9 3V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                                </svg>
                                <div class="filter-divider"></div>
                                <select name="property_size" class="filter-select" data-filter="property_size">
                                    <option value=""><?php echo esc_html__('Property Size', 'figma-custom-theme'); ?></option>
                                    <option value="0-1000" <?php selected(isset($_GET['property_size']) ? $_GET['property_size'] : '', '0-1000'); ?>><?php echo esc_html__('0 - 1,000 sq ft', 'figma-custom-theme'); ?></option>
                                    <option value="1000-2000" <?php selected(isset($_GET['property_size']) ? $_GET['property_size'] : '', '1000-2000'); ?>><?php echo esc_html__('1,000 - 2,000 sq ft', 'figma-custom-theme'); ?></option>
                                    <option value="2000-3000" <?php selected(isset($_GET['property_size']) ? $_GET['property_size'] : '', '2000-3000'); ?>><?php echo esc_html__('2,000 - 3,000 sq ft', 'figma-custom-theme'); ?></option>
                                    <option value="3000+" <?php selected(isset($_GET['property_size']) ? $_GET['property_size'] : '', '3000+'); ?>><?php echo esc_html__('3,000+ sq ft', 'figma-custom-theme'); ?></option>
                                </select>
                            </div>
                            <button type="button" class="filter-arrow" aria-label="<?php echo esc_attr__('Open dropdown', 'figma-custom-theme'); ?>" onclick="this.closest('.filter-field').querySelector('.filter-select').focus();">
                                <svg width="15" height="7.5" viewBox="0 0 15 7.5" fill="none">
                                    <path d="M1 6.5L7.5 1L14 6.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="filter-field">
                            <div class="filter-content">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="filter-icon">
                                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <path d="M3 10H21M8 4V8M16 4V8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                                </svg>
                                <div class="filter-divider"></div>
                                <select name="build_year" class="filter-select" data-filter="build_year">
                                    <option value=""><?php echo esc_html__('Build Year', 'figma-custom-theme'); ?></option>
                                    <option value="2020+" <?php selected(isset($_GET['build_year']) ? $_GET['build_year'] : '', '2020+'); ?>><?php echo esc_html__('2020+', 'figma-custom-theme'); ?></option>
                                    <option value="2010-2019" <?php selected(isset($_GET['build_year']) ? $_GET['build_year'] : '', '2010-2019'); ?>><?php echo esc_html__('2010 - 2019', 'figma-custom-theme'); ?></option>
                                    <option value="2000-2009" <?php selected(isset($_GET['build_year']) ? $_GET['build_year'] : '', '2000-2009'); ?>><?php echo esc_html__('2000 - 2009', 'figma-custom-theme'); ?></option>
                                    <option value="1990-1999" <?php selected(isset($_GET['build_year']) ? $_GET['build_year'] : '', '1990-1999'); ?>><?php echo esc_html__('1990 - 1999', 'figma-custom-theme'); ?></option>
                                    <option value="before-1990" <?php selected(isset($_GET['build_year']) ? $_GET['build_year'] : '', 'before-1990'); ?>><?php echo esc_html__('Before 1990', 'figma-custom-theme'); ?></option>
                                </select>
                            </div>
                            <button type="button" class="filter-arrow" aria-label="<?php echo esc_attr__('Open dropdown', 'figma-custom-theme'); ?>" onclick="this.closest('.filter-field').querySelector('.filter-select').focus();">
                                <svg width="15" height="7.5" viewBox="0 0 15 7.5" fill="none">
                                    <path d="M1 6.5L7.5 1L14 6.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
(function() {
    'use strict';
    
    const searchForm = document.querySelector('.properties-search-form');
    if (!searchForm) return;
    
    const filterSelects = searchForm.querySelectorAll('.filter-select');
    const searchInput = searchForm.querySelector('.search-input');
    const submitBtn = searchForm.querySelector('.search-submit-btn');
    const listingSection = document.querySelector('.properties-listing-section');
    
    // Auto-submit on filter change
    filterSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            // Add loading state
            if (listingSection) {
                listingSection.style.opacity = '0.5';
                listingSection.style.pointerEvents = 'none';
            }
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
            }
            
            // Submit form
            searchForm.submit();
        });
    });
    
    // Handle search input with debounce
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            // Don't auto-submit on every keystroke, wait for Enter or button click
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (listingSection) {
                    listingSection.style.opacity = '0.5';
                    listingSection.style.pointerEvents = 'none';
                }
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.6';
                }
                searchForm.submit();
            }
        });
    }
    
    // Add loading state on form submit
    searchForm.addEventListener('submit', function() {
        if (listingSection) {
            listingSection.style.opacity = '0.5';
            listingSection.style.pointerEvents = 'none';
        }
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
        }
    });
    
    // Mark active filters
    function markActiveFilters() {
        filterSelects.forEach(function(select) {
            const filterField = select.closest('.filter-field');
            if (select.value && select.value !== '') {
                filterField.classList.add('active-filter');
            } else {
                filterField.classList.remove('active-filter');
            }
        });
    }
    
    // Initialize active filter indicators
    markActiveFilters();
    
    // Update active indicators on change
    filterSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            markActiveFilters();
        });
    });
    
    // Restore state if page loads with filters
    const urlParams = new URLSearchParams(window.location.search);
    const hasFilters = urlParams.has('location') || urlParams.has('property_type') || 
                       urlParams.has('price_range') || urlParams.has('property_size') || 
                       urlParams.has('build_year') || urlParams.has('search');
    
    if (hasFilters && listingSection) {
        // Scroll to listing section smoothly
        setTimeout(function() {
            listingSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    }
})();
</script>

