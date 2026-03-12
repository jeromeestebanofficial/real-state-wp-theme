<?php
/**
 * Template part for displaying Properties Listing section
 *
 * @package Estatein_Theme
 */

// Get content - check if on page template first, then archive (customizer), then defaults
if (is_page_template('page-properties.php') || (is_page() && get_queried_object() && get_queried_object()->post_name === 'properties')) {
    // Page template - use ACF fields
    $section_title = get_field('properties_section_title') ?: esc_html__('Discover a World of Possibilities', 'estatein-theme');
    $section_description = get_field('properties_section_description') ?: esc_html__('Our portfolio of properties is as diverse as your dreams. Explore the following categories to find the perfect property that resonates with your vision of home', 'estatein-theme');
} elseif (is_post_type_archive('property') || is_tax('property_type') || is_tax('property_location')) {
    // Archive page - use Customizer settings
    $section_title = get_theme_mod('properties_archive_section_title', 'Discover a World of Possibilities');
    $section_description = get_theme_mod('properties_archive_section_description', 'Our portfolio of properties is as diverse as your dreams. Explore the following categories to find the perfect property that resonates with your vision of home');
} else {
    // Defaults
    $section_title = esc_html__('Discover a World of Possibilities', 'estatein-theme');
    $section_description = esc_html__('Our portfolio of properties is as diverse as your dreams. Explore the following categories to find the perfect property that resonates with your vision of home', 'estatein-theme');
}

// Get filter parameters
$location_filter = isset($_GET['location']) ? sanitize_text_field($_GET['location']) : '';
$property_type_filter = isset($_GET['property_type']) ? sanitize_text_field($_GET['property_type']) : '';
$price_range_filter = isset($_GET['price_range']) ? sanitize_text_field($_GET['price_range']) : '';
$property_size_filter = isset($_GET['property_size']) ? sanitize_text_field($_GET['property_size']) : '';
$build_year_filter = isset($_GET['build_year']) ? sanitize_text_field($_GET['build_year']) : '';
$search_query = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

// Check if we're on archive page - modify main query, otherwise create custom query
if (is_post_type_archive('property') || is_tax('property_type') || is_tax('property_location')) {
    // Modify the main query for archive pages
    global $wp_query;
    
    // Get current query args
    $query_args = $wp_query->query_vars;
    
    // Build tax query for filters
    $tax_query = array('relation' => 'AND');
    
    // Add existing taxonomy filters if on taxonomy page
    if (is_tax('property_type')) {
        $tax_query[] = array(
            'taxonomy' => 'property_type',
            'field' => 'slug',
            'terms' => get_queried_object()->slug,
        );
    }
    
    if (is_tax('property_location')) {
        $tax_query[] = array(
            'taxonomy' => 'property_location',
            'field' => 'slug',
            'terms' => get_queried_object()->slug,
        );
    }
    
    // Add filter taxonomies
    if (!empty($location_filter)) {
        $tax_query[] = array(
            'taxonomy' => 'property_location',
            'field' => 'slug',
            'terms' => $location_filter,
        );
    }
    
    if (!empty($property_type_filter)) {
        $tax_query[] = array(
            'taxonomy' => 'property_type',
            'field' => 'slug',
            'terms' => $property_type_filter,
        );
    }
    
    // Build meta query for ACF fields
    $meta_query = array('relation' => 'AND');
    
    // Note: Price range filter will be handled in post-processing since price is stored as text
    // We'll add a placeholder to ensure properties have a price field
    if (!empty($price_range_filter)) {
        $meta_query[] = array(
            'key' => 'property_price',
            'compare' => 'EXISTS',
        );
    }
    
    // Property size filter
    if (!empty($property_size_filter)) {
        $size_parts = explode('-', $property_size_filter);
        if (count($size_parts) == 2) {
            $min_size = intval($size_parts[0]);
            $max_size = intval($size_parts[1]);
            $meta_query[] = array(
                'key' => 'property_area',
                'value' => array($min_size, $max_size),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC',
            );
        } elseif (strpos($property_size_filter, '+') !== false) {
            $min_size = intval(str_replace('+', '', $property_size_filter));
            $meta_query[] = array(
                'key' => 'property_area',
                'value' => $min_size,
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }
    }
    
    // Build year filter (if ACF field exists)
    if (!empty($build_year_filter)) {
        if (strpos($build_year_filter, '+') !== false) {
            $min_year = intval(str_replace('+', '', $build_year_filter));
            $meta_query[] = array(
                'key' => 'property_build_year',
                'value' => $min_year,
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        } else {
            $year_parts = explode('-', $build_year_filter);
            if (count($year_parts) == 2) {
                $min_year = intval($year_parts[0]);
                $max_year = intval($year_parts[1]);
                $meta_query[] = array(
                    'key' => 'property_build_year',
                    'value' => array($min_year, $max_year),
                    'compare' => 'BETWEEN',
                    'type' => 'NUMERIC',
                );
            } elseif ($build_year_filter === 'before-1990') {
                $meta_query[] = array(
                    'key' => 'property_build_year',
                    'value' => 1990,
                    'compare' => '<',
                    'type' => 'NUMERIC',
                );
            }
        }
    }
    
    // Update query args
    if (count($tax_query) > 1 || (count($tax_query) == 1 && !is_tax())) {
        $query_args['tax_query'] = $tax_query;
    }
    
    if (count($meta_query) > 1) {
        $query_args['meta_query'] = $meta_query;
    }
    
    if (!empty($search_query)) {
        $query_args['s'] = $search_query;
    }
    
    $query_args['posts_per_page'] = 9;
    $query_args['paged'] = get_query_var('paged') ? get_query_var('paged') : 1;
    
    // Re-run query
    $properties_query = new WP_Query($query_args);
    
    // Filter by price range in post processing (since price is stored as text)
    if (!empty($price_range_filter) && $properties_query->have_posts()) {
        $filtered_posts = array();
        $price_parts = explode('-', $price_range_filter);
        $all_posts = $properties_query->posts;
        
        foreach ($all_posts as $post) {
            $price_text = get_field('property_price', $post->ID);
            if ($price_text) {
                // Extract numeric value from price string (e.g., "$450,000" -> 450000)
                $price_numeric = preg_replace('/[^0-9]/', '', $price_text);
                $price_numeric = intval($price_numeric);
                
                $include_post = false;
                
                if (count($price_parts) == 2) {
                    $min_price = intval($price_parts[0]);
                    $max_price = intval($price_parts[1]);
                    if ($price_numeric >= $min_price && $price_numeric <= $max_price) {
                        $include_post = true;
                    }
                } elseif (strpos($price_range_filter, '+') !== false) {
                    $min_price = intval(str_replace('+', '', $price_range_filter));
                    if ($price_numeric >= $min_price) {
                        $include_post = true;
                    }
                }
                
                if ($include_post) {
                    $filtered_posts[] = $post->ID;
                }
            }
        }
        
        // Re-query with filtered post IDs
        if (!empty($filtered_posts)) {
            $query_args['post__in'] = $filtered_posts;
            $query_args['orderby'] = 'post__in';
            // Remove price from meta_query since we're filtering manually
            if (isset($query_args['meta_query'])) {
                foreach ($query_args['meta_query'] as $key => $meta) {
                    if (isset($meta['key']) && $meta['key'] === 'property_price') {
                        unset($query_args['meta_query'][$key]);
                    }
                }
                $query_args['meta_query'] = array_values($query_args['meta_query']);
                if (count($query_args['meta_query']) <= 1) {
                    unset($query_args['meta_query']);
                }
            }
            $properties_query = new WP_Query($query_args);
        } else {
            // No posts match, create empty query
            $query_args['post__in'] = array(0);
            unset($query_args['meta_query']);
            $properties_query = new WP_Query($query_args);
        }
    }
} else {
    // Query properties for page template
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // Build tax query for filters
    $tax_query = array('relation' => 'AND');

    if (!empty($location_filter)) {
        $tax_query[] = array(
            'taxonomy' => 'property_location',
            'field' => 'slug',
            'terms' => $location_filter,
        );
    }

    if (!empty($property_type_filter)) {
        $tax_query[] = array(
            'taxonomy' => 'property_type',
            'field' => 'slug',
            'terms' => $property_type_filter,
        );
    }

    // Build meta query for ACF fields
    $meta_query = array('relation' => 'AND');
    
    // Price range filter - need to parse price strings like "$450,000"
    if (!empty($price_range_filter)) {
        $price_parts = explode('-', $price_range_filter);
        if (count($price_parts) == 2) {
            $min_price = intval($price_parts[0]);
            $max_price = intval($price_parts[1]);
            // We'll filter this in post processing since price is stored as text
            $meta_query[] = array(
                'key' => 'property_price',
                'compare' => 'EXISTS',
            );
        } elseif (strpos($price_range_filter, '+') !== false) {
            $min_price = intval(str_replace('+', '', $price_range_filter));
            $meta_query[] = array(
                'key' => 'property_price',
                'compare' => 'EXISTS',
            );
        }
    }
    
    // Property size filter
    if (!empty($property_size_filter)) {
        $size_parts = explode('-', $property_size_filter);
        if (count($size_parts) == 2) {
            $min_size = intval($size_parts[0]);
            $max_size = intval($size_parts[1]);
            $meta_query[] = array(
                'key' => 'property_area',
                'value' => array($min_size, $max_size),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC',
            );
        } elseif (strpos($property_size_filter, '+') !== false) {
            $min_size = intval(str_replace('+', '', $property_size_filter));
            $meta_query[] = array(
                'key' => 'property_area',
                'value' => $min_size,
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        }
    }
    
    // Build year filter
    if (!empty($build_year_filter)) {
        if (strpos($build_year_filter, '+') !== false) {
            $min_year = intval(str_replace('+', '', $build_year_filter));
            $meta_query[] = array(
                'key' => 'property_build_year',
                'value' => $min_year,
                'compare' => '>=',
                'type' => 'NUMERIC',
            );
        } else {
            $year_parts = explode('-', $build_year_filter);
            if (count($year_parts) == 2) {
                $min_year = intval($year_parts[0]);
                $max_year = intval($year_parts[1]);
                $meta_query[] = array(
                    'key' => 'property_build_year',
                    'value' => array($min_year, $max_year),
                    'compare' => 'BETWEEN',
                    'type' => 'NUMERIC',
                );
            } elseif ($build_year_filter === 'before-1990') {
                $meta_query[] = array(
                    'key' => 'property_build_year',
                    'value' => 1990,
                    'compare' => '<',
                    'type' => 'NUMERIC',
                );
            }
        }
    }

    $query_args = array(
        'post_type' => 'property',
        'posts_per_page' => 9,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if (count($tax_query) > 1) {
        $query_args['tax_query'] = $tax_query;
    }
    
    if (count($meta_query) > 1) {
        $query_args['meta_query'] = $meta_query;
    }
    
    if (!empty($search_query)) {
        $query_args['s'] = $search_query;
    }

    $properties_query = new WP_Query($query_args);
    
    // Filter by price range in post processing (since price is stored as text)
    if (!empty($price_range_filter) && $properties_query->have_posts()) {
        $filtered_posts = array();
        $price_parts = explode('-', $price_range_filter);
        $all_posts = $properties_query->posts;
        
        foreach ($all_posts as $post) {
            $price_text = get_field('property_price', $post->ID);
            if ($price_text) {
                // Extract numeric value from price string (e.g., "$450,000" -> 450000)
                $price_numeric = preg_replace('/[^0-9]/', '', $price_text);
                $price_numeric = intval($price_numeric);
                
                $include_post = false;
                
                if (count($price_parts) == 2) {
                    $min_price = intval($price_parts[0]);
                    $max_price = intval($price_parts[1]);
                    if ($price_numeric >= $min_price && $price_numeric <= $max_price) {
                        $include_post = true;
                    }
                } elseif (strpos($price_range_filter, '+') !== false) {
                    $min_price = intval(str_replace('+', '', $price_range_filter));
                    if ($price_numeric >= $min_price) {
                        $include_post = true;
                    }
                }
                
                if ($include_post) {
                    $filtered_posts[] = $post->ID;
                }
            }
        }
        
        // Re-query with filtered post IDs
        if (!empty($filtered_posts)) {
            // Preserve all other query args
            $query_args['post__in'] = $filtered_posts;
            $query_args['orderby'] = 'post__in';
            // Remove price from meta_query since we're filtering manually
            if (isset($query_args['meta_query'])) {
                foreach ($query_args['meta_query'] as $key => $meta) {
                    if (isset($meta['key']) && $meta['key'] === 'property_price') {
                        unset($query_args['meta_query'][$key]);
                    }
                }
                $query_args['meta_query'] = array_values($query_args['meta_query']);
                if (count($query_args['meta_query']) <= 1) {
                    unset($query_args['meta_query']);
                }
            }
            $properties_query = new WP_Query($query_args);
        } else {
            // No posts match, create empty query
            $query_args['post__in'] = array(0);
            unset($query_args['meta_query']);
            $properties_query = new WP_Query($query_args);
        }
    }
}
?>

<section class="properties-listing-section">
    <div class="container">
        <div class="section-header">
            <div class="decorative-pattern"></div>
            <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
            <?php if ($section_description) : ?>
                <p class="section-description"><?php echo esc_html($section_description); ?></p>
            <?php endif; ?>
        </div>
        
        <?php if ($properties_query->have_posts()) : ?>
            <div class="properties-grid">
                <?php while ($properties_query->have_posts()) : $properties_query->the_post(); ?>
                    <?php
                    $property_price = get_field('property_price');
                    $property_location = get_field('property_location');
                    $property_bedrooms = get_field('property_bedrooms');
                    $property_bathrooms = get_field('property_bathrooms');
                    $property_area = get_field('property_area');
                    $property_category = get_the_terms(get_the_ID(), 'property_type');
                    $property_category_name = $property_category && !is_wp_error($property_category) ? $property_category[0]->name : '';
                    ?>
                    
                    <article class="property-card">
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
                                <div class="property-info-inner">
                                    <?php if ($property_category_name) : ?>
                                        <div class="property-category">
                                            <?php echo esc_html($property_category_name); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="property-title-section">
                                        <h3 class="property-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        
                                        <?php if (has_excerpt() || get_the_content()) : ?>
                                            <div class="property-description">
                                                <?php
                                                $excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 20);
                                                echo esc_html($excerpt);
                                                ?>
                                                <span> </span>
                                                <a href="<?php the_permalink(); ?>" class="read-more">
                                                    <?php echo esc_html__('Read More', 'estatein-theme'); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="property-footer">
                                <?php if ($property_price) : ?>
                                    <div class="property-price">
                                        <span class="price-label"><?php echo esc_html__('Price', 'estatein-theme'); ?></span>
                                        <span class="price-value"><?php echo esc_html($property_price); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="property-cta">
                                    <?php echo esc_html__('View Property Details', 'estatein-theme'); ?>
                                </a>
                            </div>
                        </div>
                    </article>
                    
                <?php endwhile; ?>
            </div>
            
            <?php
            // Pagination
            if (is_post_type_archive('property') || is_tax('property_type') || is_tax('property_location')) {
                // Use WordPress pagination for archive
                $total_pages = $properties_query->max_num_pages;
                $current_page = max(1, get_query_var('paged'));
            } else {
                // Custom query pagination
                $total_pages = $properties_query->max_num_pages;
                $current_page = max(1, $paged);
            }
            
            if ($total_pages > 1) :
            ?>
                <div class="properties-pagination">
                    <div class="pagination-info">
                        <span class="current-page"><?php printf('%02d', $current_page); ?></span>
                        <span class="total-pages"><?php printf(esc_html__(' of %02d', 'estatein-theme'), $total_pages); ?></span>
                    </div>
                    <div class="pagination-nav">
                        <?php
                        // Preserve all filter parameters in pagination
                        $filter_params = array();
                        if (!empty($location_filter)) $filter_params['location'] = $location_filter;
                        if (!empty($property_type_filter)) $filter_params['property_type'] = $property_type_filter;
                        if (!empty($price_range_filter)) $filter_params['price_range'] = $price_range_filter;
                        if (!empty($property_size_filter)) $filter_params['property_size'] = $property_size_filter;
                        if (!empty($build_year_filter)) $filter_params['build_year'] = $build_year_filter;
                        if (!empty($search_query)) $filter_params['search'] = $search_query;
                        
                        if (is_post_type_archive('property') || is_tax('property_type') || is_tax('property_location')) {
                            // Archive pagination
                            $base_url = get_post_type_archive_link('property');
                            if (is_tax()) {
                                $base_url = get_term_link(get_queried_object());
                            }
                            $prev_page = ($current_page > 1) ? $current_page - 1 : 0;
                            $next_page = ($current_page < $total_pages) ? $current_page + 1 : 0;
                            
                            $prev_params = array_merge($filter_params, array('paged' => $prev_page));
                            $next_params = array_merge($filter_params, array('paged' => $next_page));
                            
                            $prev_link = ($prev_page > 0) ? add_query_arg($prev_params, $base_url) : '#';
                            $next_link = ($next_page > 0) ? add_query_arg($next_params, $base_url) : '#';
                        } else {
                            // Page template pagination
                            $base_url = get_permalink();
                            $prev_page = ($current_page > 1) ? $current_page - 1 : 0;
                            $next_page = ($current_page < $total_pages) ? $current_page + 1 : 0;
                            
                            $prev_params = array_merge($filter_params, array('paged' => $prev_page));
                            $next_params = array_merge($filter_params, array('paged' => $next_page));
                            
                            $prev_link = ($prev_page > 0) ? add_query_arg($prev_params, $base_url) : '#';
                            $next_link = ($next_page > 0) ? add_query_arg($next_params, $base_url) : '#';
                        }
                        ?>
                        <a href="<?php echo esc_url($prev_link); ?>" class="nav-btn nav-prev <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>" <?php echo ($current_page <= 1) ? 'aria-disabled="true" onclick="return false;"' : ''; ?>>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path d="M18 9L12 15L6 9" stroke="#808080" stroke-width="1.5" transform="rotate(90 12 12)"/>
                            </svg>
                        </a>
                        <a href="<?php echo esc_url($next_link); ?>" class="nav-btn nav-next <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>" <?php echo ($current_page >= $total_pages) ? 'aria-disabled="true" onclick="return false;"' : ''; ?>>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path d="M6 15L12 9L18 15" stroke="white" stroke-width="1.5" transform="rotate(-90 12 12)"/>
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php 
            if (!is_post_type_archive('property') && !is_tax('property_type') && !is_tax('property_location')) {
                wp_reset_postdata(); 
            }
            ?>
            
        <?php else : ?>
            <div class="no-properties-found">
                <p><?php echo esc_html__('No properties found. Please try different search criteria.', 'estatein-theme'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

