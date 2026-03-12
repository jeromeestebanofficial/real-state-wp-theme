<?php
/**
 * Theme functions and definitions
 *
 * @package Figma_Custom_Theme
 * 
 * UI Design Reference: https://www.figma.com/community/file/1314076616839640516
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'figma_custom_theme_register_required_plugins' );

function figma_custom_theme_register_required_plugins() {

    $plugins = [
        [
            'name'     => 'Advanced Custom Fields',
            'slug'     => 'advanced-custom-fields',
            'required' => true,
        ],
    ];

    $config = [
        'id'           => 'figma-custom-theme',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => false,
        'is_automatic' => true,
    ];

    tgmpa( $plugins, $config );
}
add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary' => 'Primary Menu',
    ]);
});
require_once get_template_directory() . '/inc/setup-menus.php';
require_once get_template_directory() . '/inc/setup-create-pages.php';
require_once get_template_directory() . '/inc/setup-homepage.php';
require_once get_template_directory() . '/inc/setup-create-menus.php';

/**
 * Theme setup function
 */
if (!function_exists('figma_custom_theme_setup')) {
    function figma_custom_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');

    // Add support for editor styles
    add_theme_support('editor-styles');

    // Add support for wide and full alignment
    add_theme_support('align-wide');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // This theme uses wp_nav_menu() in one location
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'figma-custom-theme'),
        'footer'  => esc_html__('Footer Menu', 'figma-custom-theme'),
    ));

    // Add support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add support for custom background
    add_theme_support('custom-background', apply_filters('figma_custom_theme_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    )));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom colors
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => esc_html__('Primary', 'figma-custom-theme'),
            'slug'  => 'primary',
            'color' => '#007cba',
        ),
        array(
            'name'  => esc_html__('Secondary', 'figma-custom-theme'),
            'slug'  => 'secondary',
            'color' => '#666666',
        ),
        array(
            'name'  => esc_html__('Dark Gray', 'figma-custom-theme'),
            'slug'  => 'dark-gray',
            'color' => '#333333',
        ),
        array(
            'name'  => esc_html__('Light Gray', 'figma-custom-theme'),
            'slug'  => 'light-gray',
            'color' => '#f9f9f9',
        ),
        array(
            'name'  => esc_html__('White', 'figma-custom-theme'),
            'slug'  => 'white',
            'color' => '#ffffff',
        ),
    ));
    }
}
add_action('after_setup_theme', 'figma_custom_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet
 */
if (!function_exists('figma_custom_theme_content_width')) {
    function figma_custom_theme_content_width() {
        $GLOBALS['content_width'] = apply_filters('figma_custom_theme_content_width', 1200);
    }
}
add_action('after_setup_theme', 'figma_custom_theme_content_width', 0);

/**
 * Register widget area
 */
if (!function_exists('figma_custom_theme_widgets_init')) {
    function figma_custom_theme_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'figma-custom-theme'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'figma-custom-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area', 'figma-custom-theme'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add footer widgets here.', 'figma-custom-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    }
}
add_action('widgets_init', 'figma_custom_theme_widgets_init');

/**
 * Enqueue scripts and styles
 */
if (!function_exists('figma_custom_theme_scripts')) {
    function figma_custom_theme_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('figma-custom-theme-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

    // Enqueue component stylesheets
    wp_enqueue_style('figma-custom-theme-hero', get_template_directory_uri() . '/assets/css/components/hero.css', array('figma-custom-theme-style'), wp_get_theme()->get('Version'));
    wp_enqueue_style('figma-custom-theme-features', get_template_directory_uri() . '/assets/css/components/features.css', array('figma-custom-theme-style'), wp_get_theme()->get('Version'));
    wp_enqueue_style('figma-custom-theme-properties', get_template_directory_uri() . '/assets/css/components/properties.css', array('figma-custom-theme-style'), wp_get_theme()->get('Version'));
    wp_enqueue_style('figma-custom-theme-testimonials', get_template_directory_uri() . '/assets/css/components/testimonials.css', array('figma-custom-theme-style'), wp_get_theme()->get('Version'));
    
    // Enqueue About page styles
    if (is_page_template('page-about.php') || (is_page() && get_queried_object() && get_queried_object()->post_name === 'about') || (is_page() && get_query_var('pagename') === 'about')) {
        wp_enqueue_style('figma-custom-theme-about', get_template_directory_uri() . '/assets/css/components/about.css', array('figma-custom-theme-style'), wp_get_theme()->get('Version'));
        wp_enqueue_style('figma-custom-theme-about-journey', get_template_directory_uri() . '/assets/css/components/about-journey.css', array('figma-custom-theme-about'), wp_get_theme()->get('Version'));
        wp_enqueue_style('figma-custom-theme-about-values', get_template_directory_uri() . '/assets/css/components/about-values.css', array('figma-custom-theme-about'), wp_get_theme()->get('Version'));
        wp_enqueue_style('figma-custom-theme-about-achievements', get_template_directory_uri() . '/assets/css/components/about-achievements.css', array('figma-custom-theme-about'), wp_get_theme()->get('Version'));
        wp_enqueue_style('figma-custom-theme-about-process', get_template_directory_uri() . '/assets/css/components/about-process.css', array('figma-custom-theme-about'), wp_get_theme()->get('Version'));
        wp_enqueue_style('figma-custom-theme-about-team', get_template_directory_uri() . '/assets/css/components/about-team.css', array('figma-custom-theme-about'), wp_get_theme()->get('Version'));
        wp_enqueue_style('figma-custom-theme-about-clients', get_template_directory_uri() . '/assets/css/components/about-clients.css', array('figma-custom-theme-about'), wp_get_theme()->get('Version'));
    }
    
    // Enqueue Properties page styles
    $is_properties_page = is_page_template('page-properties.php') 
        || (is_page() && get_queried_object() && get_queried_object()->post_name === 'properties') 
        || (is_page() && get_query_var('pagename') === 'properties')
        || is_post_type_archive('property') 
        || is_tax('property_type') 
        || is_tax('property_location');
    
    if ($is_properties_page) {
        wp_enqueue_style('figma-custom-theme-properties-page', get_template_directory_uri() . '/assets/css/properties-page.css', array('figma-custom-theme-style'), wp_get_theme()->get('Version'));
    }
    
    // Enqueue Single Property page styles
    if (is_singular('property')) {
        wp_enqueue_style('figma-custom-theme-single-property', get_template_directory_uri() . '/assets/css/single-property.css', array('figma-custom-theme-style'), wp_get_theme()->get('Version'));
        wp_enqueue_script('figma-property-gallery', get_template_directory_uri() . '/assets/js/property-gallery.js', array('jquery'), wp_get_theme()->get('Version'), true);
    }
    
    // Enqueue Services page styles
    $is_services_page = is_page_template('page-services.php') 
        || (is_page() && get_queried_object() && get_queried_object()->post_name === 'services') 
        || (is_page() && get_query_var('pagename') === 'services');
    
    if ($is_services_page) {
        wp_enqueue_style('figma-custom-theme-services-page', get_template_directory_uri() . '/assets/css/services-page.css', array('figma-custom-theme-style'), wp_get_theme()->get('Version'));
    }
    
    // Enqueue layout stylesheets
    wp_enqueue_style('figma-custom-theme-blog', get_template_directory_uri() . '/assets/css/layout/blog.css', array('figma-custom-theme-style'), wp_get_theme()->get('Version'));
    
    // Enqueue footer styles (global)
    wp_enqueue_style('figma-custom-theme-footer', get_template_directory_uri() . '/assets/css/footer.css', array('figma-custom-theme-style'), wp_get_theme()->get('Version'));


    // Enqueue custom JavaScript
    wp_enqueue_script('figma-custom-theme-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), wp_get_theme()->get('Version'), true);

    // Add support for comment reply
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    }
}
add_action('wp_enqueue_scripts', 'figma_custom_theme_scripts');

/**
 * Custom template tags for this theme
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom excerpt length
 */
if (!function_exists('figma_custom_theme_excerpt_length')) {
    function figma_custom_theme_excerpt_length($length) {
        return 30;
    }
}
add_filter('excerpt_length', 'figma_custom_theme_excerpt_length');

/**
 * Custom excerpt more
 */
if (!function_exists('figma_custom_theme_excerpt_more')) {
    function figma_custom_theme_excerpt_more($more) {
        return '...';
    }
}
add_filter('excerpt_more', 'figma_custom_theme_excerpt_more');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments
 */
function figma_custom_theme_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'figma_custom_theme_pingback_header');

/**
 * Enqueue Google Fonts
 */
function figma_custom_theme_fonts() {
    wp_enqueue_style('figma-custom-theme-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null);
}
add_action('wp_enqueue_scripts', 'figma_custom_theme_fonts');

/**
 * Add custom body classes
 */
function figma_custom_theme_body_classes($classes) {
    // Add class if we're viewing the Customizer for easier styling of theme options
    if (is_customize_preview()) {
        $classes[] = 'wp-customizer';
    }

    return $classes;
}
add_filter('body_class', 'figma_custom_theme_body_classes');

/**
 * Fallback menu for when no menu is assigned
 */
function figma_custom_theme_default_menu() {
    echo '<ul id="primary-menu" class="nav-menu">';
    echo '<li class="current-menu-item"><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'figma-custom-theme') . '</a></li>';
    
    // Add pages to menu
    $pages = get_pages(array(
        'sort_column' => 'menu_order',
        'number' => 4
    ));
    
    foreach ($pages as $page) {
        echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
    }
    
    echo '</ul>';
}

// Include block patterns
require get_template_directory() . '/inc/block-patterns.php';

/**
 * Performance and Accessibility Optimizations
 */

// Add theme support for responsive embeds
add_theme_support('responsive-embeds');

// Add theme support for custom line height
add_theme_support('custom-line-height');

// Add theme support for custom spacing
add_theme_support('custom-spacing');

// Optimize WordPress queries
function figma_custom_theme_optimize_queries($query) {
    if (!is_admin() && $query->is_main_query()) {
        // Limit posts per page for performance
        if (is_home()) {
            $query->set('posts_per_page', 6);
        }
        
        // Exclude attachments from search
        if (is_search()) {
            $query->set('post_type', 'post');
        }
    }
}
add_action('pre_get_posts', 'figma_custom_theme_optimize_queries');

// Remove unnecessary WordPress features for performance
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

// Add preload for fonts
function figma_custom_theme_preload_fonts() {
    ?>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700&display=swap"></noscript>
    <?php
}
add_action('wp_head', 'figma_custom_theme_preload_fonts', 1);

// Optimize images
function figma_custom_theme_optimize_images($attr, $attachment, $size) {
    // Add loading="lazy" to images
    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }
    
    // Add decoding="async" for better performance
    if (!isset($attr['decoding'])) {
        $attr['decoding'] = 'async';
    }
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'figma_custom_theme_optimize_images', 10, 3);

// Add ARIA labels to navigation menus
function figma_custom_theme_nav_menu_args($args) {
    if ($args['theme_location'] === 'primary') {
        $args['menu_id'] = 'primary-menu';
        $args['container_aria_label'] = esc_attr__('Primary Navigation', 'figma-custom-theme');
    }
    
    if ($args['theme_location'] === 'footer') {
        $args['menu_id'] = 'footer-menu';
        $args['container_aria_label'] = esc_attr__('Footer Navigation', 'figma-custom-theme');
    }
    
    return $args;
}
add_filter('wp_nav_menu_args', 'figma_custom_theme_nav_menu_args');

// Improve accessibility for skip links
function figma_custom_theme_skip_link_focus_fix() {
    ?>
    <script>
    /(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
    </script>
    <?php
}
add_action('wp_print_footer_scripts', 'figma_custom_theme_skip_link_focus_fix');

// Add schema markup
function figma_custom_theme_add_schema() {
    if (is_front_page()) {
        ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "<?php bloginfo('name'); ?>",
            "url": "<?php echo esc_url(home_url('/')); ?>",
            "description": "<?php bloginfo('description'); ?>",
            "sameAs": [
                "#",
                "#",
                "#"
            ]
        }
        </script>
        <?php
    }
}
add_action('wp_head', 'figma_custom_theme_add_schema');

// Security enhancements
function figma_custom_theme_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'figma_custom_theme_security_headers');

/**
 * Add custom image sizes for theme
 */
if (!function_exists('figma_custom_theme_add_image_sizes')) {
    function figma_custom_theme_add_image_sizes() {
        // Hero image size
        add_image_size('hero-image', 600, 600, true);
        
        // Property image size
        add_image_size('property-image', 400, 240, true);
        
        // Testimonial avatar size
        add_image_size('testimonial-avatar', 80, 80, true);
        
        // Feature image size
        add_image_size('feature-image', 300, 200, true);
    }
}
add_action('after_setup_theme', 'figma_custom_theme_add_image_sizes');

/**
 * Add theme support for responsive images
 */
if (!function_exists('figma_custom_theme_responsive_images')) {
    function figma_custom_theme_responsive_images() {
        // Add support for responsive images
        add_theme_support('responsive-embeds');
        
        // Add support for custom header
        add_theme_support('custom-header', array(
            'default-image' => get_template_directory_uri() . '/assets/images/header-bg.jpg',
            'width'         => 1200,
            'height'        => 600,
            'flex-width'    => true,
            'flex-height'   => true,
        ));
    }
}
add_action('after_setup_theme', 'figma_custom_theme_responsive_images');

/**
 * Enqueue additional mobile-specific styles
 */
if (!function_exists('figma_custom_theme_mobile_styles')) {
    function figma_custom_theme_mobile_styles() {
        // Add mobile-specific CSS
        wp_add_inline_style('figma-custom-theme-style', '
            @media (max-width: 768px) {
                .site-header.scrolled {
                    background-color: rgba(26, 26, 26, 0.95);
                    backdrop-filter: blur(10px);
                }
                
                .animate-in {
                    animation: fadeInUp 0.6s ease-out;
                }
                
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                
                .hover-scale {
                    transform: scale(1.02);
                }
                
                .pulse {
                    animation: pulse 0.5s ease-in-out;
                }
                
                @keyframes pulse {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.05); }
                    100% { transform: scale(1); }
                }
            }
        ');
    }
}
add_action('wp_enqueue_scripts', 'figma_custom_theme_mobile_styles');

/**
 * Add viewport meta tag for better mobile experience
 */
if (!function_exists('figma_custom_theme_viewport_meta')) {
    function figma_custom_theme_viewport_meta() {
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">';
    }
}
add_action('wp_head', 'figma_custom_theme_viewport_meta', 1);


/* ========================================
   CUSTOM POST TYPES
======================================== */

/**
 * Register Properties Custom Post Type
 */
if (!function_exists('figma_custom_theme_register_properties')) {
    function figma_custom_theme_register_properties() {
        $labels = array(
            'name'                  => _x('Properties', 'Post Type General Name', 'figma-custom-theme'),
            'singular_name'         => _x('Property', 'Post Type Singular Name', 'figma-custom-theme'),
            'menu_name'             => __('Properties', 'figma-custom-theme'),
            'name_admin_bar'        => __('Property', 'figma-custom-theme'),
            'archives'              => __('Property Archives', 'figma-custom-theme'),
            'attributes'            => __('Property Attributes', 'figma-custom-theme'),
            'parent_item_colon'     => __('Parent Property:', 'figma-custom-theme'),
            'all_items'             => __('All Properties', 'figma-custom-theme'),
            'add_new_item'          => __('Add New Property', 'figma-custom-theme'),
            'add_new'               => __('Add New', 'figma-custom-theme'),
            'new_item'              => __('New Property', 'figma-custom-theme'),
            'edit_item'             => __('Edit Property', 'figma-custom-theme'),
            'update_item'           => __('Update Property', 'figma-custom-theme'),
            'view_item'             => __('View Property', 'figma-custom-theme'),
            'view_items'            => __('View Properties', 'figma-custom-theme'),
            'search_items'          => __('Search Property', 'figma-custom-theme'),
            'not_found'             => __('Not found', 'figma-custom-theme'),
            'not_found_in_trash'    => __('Not found in Trash', 'figma-custom-theme'),
        );
        
        $args = array(
            'label'                 => __('Property', 'figma-custom-theme'),
            'description'           => __('Real Estate Properties', 'figma-custom-theme'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
            'taxonomies'            => array('property_type', 'property_location'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-building',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'properties',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );
        register_post_type('property', $args);
    }
}
add_action('init', 'figma_custom_theme_register_properties', 0);

/**
 * Register Team Members Custom Post Type
 */
if (!function_exists('figma_custom_theme_register_team')) {
    function figma_custom_theme_register_team() {
        $labels = array(
            'name'                  => _x('Team Members', 'Post Type General Name', 'figma-custom-theme'),
            'singular_name'         => _x('Team Member', 'Post Type Singular Name', 'figma-custom-theme'),
            'menu_name'             => __('Team', 'figma-custom-theme'),
            'name_admin_bar'        => __('Team Member', 'figma-custom-theme'),
            'add_new_item'          => __('Add New Team Member', 'figma-custom-theme'),
            'add_new'               => __('Add New', 'figma-custom-theme'),
            'new_item'              => __('New Team Member', 'figma-custom-theme'),
            'edit_item'             => __('Edit Team Member', 'figma-custom-theme'),
            'view_item'             => __('View Team Member', 'figma-custom-theme'),
            'all_items'             => __('All Team Members', 'figma-custom-theme'),
            'search_items'          => __('Search Team Members', 'figma-custom-theme'),
            'not_found'             => __('No team members found.', 'figma-custom-theme'),
            'not_found_in_trash'    => __('No team members found in Trash.', 'figma-custom-theme'),
        );
        
        $args = array(
            'label'                 => __('Team Member', 'figma-custom-theme'),
            'description'           => __('Team Members', 'figma-custom-theme'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 21,
            'menu_icon'             => 'dashicons-groups',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'team',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );
        register_post_type('team_member', $args);
    }
}
add_action('init', 'figma_custom_theme_register_team', 0);

/**
 * Register Services Custom Post Type
 */
if (!function_exists('figma_custom_theme_register_services')) {
    function figma_custom_theme_register_services() {
        $labels = array(
            'name'                  => _x('Services', 'Post Type General Name', 'figma-custom-theme'),
            'singular_name'         => _x('Service', 'Post Type Singular Name', 'figma-custom-theme'),
            'menu_name'             => __('Services', 'figma-custom-theme'),
            'name_admin_bar'        => __('Service', 'figma-custom-theme'),
            'add_new_item'          => __('Add New Service', 'figma-custom-theme'),
            'add_new'               => __('Add New', 'figma-custom-theme'),
            'new_item'              => __('New Service', 'figma-custom-theme'),
            'edit_item'             => __('Edit Service', 'figma-custom-theme'),
            'view_item'             => __('View Service', 'figma-custom-theme'),
            'all_items'             => __('All Services', 'figma-custom-theme'),
            'search_items'          => __('Search Services', 'figma-custom-theme'),
            'not_found'             => __('No services found.', 'figma-custom-theme'),
            'not_found_in_trash'    => __('No services found in Trash.', 'figma-custom-theme'),
        );
        
        $args = array(
            'label'                 => __('Service', 'figma-custom-theme'),
            'description'           => __('Services offered', 'figma-custom-theme'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 22,
            'menu_icon'             => 'dashicons-admin-tools',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'service-archive',
            'rewrite'               => array(
                'slug'       => 'service',
                'with_front' => false,
            ),
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );
        register_post_type('service', $args);
    }
}
add_action('init', 'figma_custom_theme_register_services', 0);

/**
 * Register Testimonials Custom Post Type
 */
if (!function_exists('figma_custom_theme_register_testimonials')) {
    function figma_custom_theme_register_testimonials() {
        $labels = array(
            'name'                  => _x('Testimonials', 'Post Type General Name', 'figma-custom-theme'),
            'singular_name'         => _x('Testimonial', 'Post Type Singular Name', 'figma-custom-theme'),
            'menu_name'             => __('Testimonials', 'figma-custom-theme'),
            'name_admin_bar'        => __('Testimonial', 'figma-custom-theme'),
            'add_new_item'          => __('Add New Testimonial', 'figma-custom-theme'),
            'add_new'               => __('Add New', 'figma-custom-theme'),
            'new_item'              => __('New Testimonial', 'figma-custom-theme'),
            'edit_item'             => __('Edit Testimonial', 'figma-custom-theme'),
            'view_item'             => __('View Testimonial', 'figma-custom-theme'),
            'all_items'             => __('All Testimonials', 'figma-custom-theme'),
            'search_items'          => __('Search Testimonials', 'figma-custom-theme'),
            'not_found'             => __('No testimonials found.', 'figma-custom-theme'),
            'not_found_in_trash'    => __('No testimonials found in Trash.', 'figma-custom-theme'),
        );
        
        $args = array(
            'label'                 => __('Testimonial', 'figma-custom-theme'),
            'description'           => __('Customer testimonials', 'figma-custom-theme'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 23,
            'menu_icon'             => 'dashicons-format-quote',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );
        register_post_type('testimonial', $args);
    }
}
add_action('init', 'figma_custom_theme_register_testimonials', 0);

/**
 * Register Contact Form Submissions Custom Post Type
 */
if (!function_exists('figma_custom_theme_register_contact_submissions')) {
    function figma_custom_theme_register_contact_submissions() {
        $labels = array(
            'name'                  => _x('Contact Submissions', 'Post Type General Name', 'figma-custom-theme'),
            'singular_name'         => _x('Contact Submission', 'Post Type Singular Name', 'figma-custom-theme'),
            'menu_name'             => __('Contact Submissions', 'figma-custom-theme'),
            'name_admin_bar'        => __('Contact Submission', 'figma-custom-theme'),
            'add_new_item'          => __('Add New Submission', 'figma-custom-theme'),
            'add_new'               => __('Add New', 'figma-custom-theme'),
            'new_item'              => __('New Submission', 'figma-custom-theme'),
            'edit_item'             => __('View Submission', 'figma-custom-theme'),
            'view_item'             => __('View Submission', 'figma-custom-theme'),
            'all_items'             => __('All Submissions', 'figma-custom-theme'),
            'search_items'          => __('Search Submissions', 'figma-custom-theme'),
            'not_found'             => __('No submissions found', 'figma-custom-theme'),
            'not_found_in_trash'    => __('No submissions found in Trash', 'figma-custom-theme'),
        );

        $args = array(
            'label'                 => __('Contact Submission', 'figma-custom-theme'),
            'description'           => __('Contact form submissions from properties page', 'figma-custom-theme'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor'),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 25,
            'menu_icon'             => 'dashicons-email-alt',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type'       => 'post',
            'show_in_rest'          => false,
        );

        register_post_type('contact_submission', $args);
    }
}
add_action('init', 'figma_custom_theme_register_contact_submissions', 0);

/* ========================================
   CUSTOM TAXONOMIES
======================================== */

/**
 * Register Property Type Taxonomy
 */
if (!function_exists('figma_custom_theme_register_property_type')) {
    function figma_custom_theme_register_property_type() {
        $labels = array(
            'name'              => _x('Property Types', 'taxonomy general name', 'figma-custom-theme'),
            'singular_name'     => _x('Property Type', 'taxonomy singular name', 'figma-custom-theme'),
            'search_items'      => __('Search Property Types', 'figma-custom-theme'),
            'all_items'         => __('All Property Types', 'figma-custom-theme'),
            'edit_item'         => __('Edit Property Type', 'figma-custom-theme'),
            'update_item'       => __('Update Property Type', 'figma-custom-theme'),
            'add_new_item'      => __('Add New Property Type', 'figma-custom-theme'),
            'new_item_name'     => __('New Property Type Name', 'figma-custom-theme'),
            'menu_name'         => __('Property Types', 'figma-custom-theme'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'property-type'),
            'show_in_rest'      => true,
        );

        register_taxonomy('property_type', array('property'), $args);
    }
}
add_action('init', 'figma_custom_theme_register_property_type', 0);

/**
 * Register Property Location Taxonomy
 */
if (!function_exists('figma_custom_theme_register_property_location')) {
    function figma_custom_theme_register_property_location() {
        $labels = array(
            'name'              => _x('Property Locations', 'taxonomy general name', 'figma-custom-theme'),
            'singular_name'     => _x('Property Location', 'taxonomy singular name', 'figma-custom-theme'),
            'search_items'      => __('Search Property Locations', 'figma-custom-theme'),
            'all_items'         => __('All Property Locations', 'figma-custom-theme'),
            'edit_item'         => __('Edit Property Location', 'figma-custom-theme'),
            'update_item'       => __('Update Property Location', 'figma-custom-theme'),
            'add_new_item'      => __('Add New Property Location', 'figma-custom-theme'),
            'new_item_name'     => __('New Property Location Name', 'figma-custom-theme'),
            'menu_name'         => __('Locations', 'figma-custom-theme'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'location'),
            'show_in_rest'      => true,
        );

        register_taxonomy('property_location', array('property'), $args);
    }
}
add_action('init', 'figma_custom_theme_register_property_location', 0);

/* ========================================
   ADVANCED CUSTOM FIELDS (ACF) INTEGRATION
======================================== */

/**
 * ACF Options Page
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Options',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-admin-customizer',
    ));
    
    acf_add_options_sub_page(array(
        'page_title' => 'Header Settings',
        'menu_title' => 'Header',
        'parent_slug' => 'theme-general-settings',
    ));
    
    acf_add_options_sub_page(array(
        'page_title' => 'Footer Settings',
        'menu_title' => 'Footer',
        'parent_slug' => 'theme-general-settings',
    ));
}

/**
 * Auto-create ACF field groups programmatically
 */
if (!function_exists('figma_custom_theme_create_acf_fields')) {
    function figma_custom_theme_create_acf_fields() {
        if (function_exists('acf_add_local_field_group')) {
            
            // Property Details Field Group
            acf_add_local_field_group(array(
                'key' => 'group_property_details',
                'title' => 'Property Details',
                'fields' => array(
                    // Location - Required
                    array(
                        'key' => 'field_property_location',
                        'label' => 'Location',
                        'name' => 'property_location',
                        'type' => 'text',
                        'required' => 1,
                        'instructions' => 'Enter the property location (e.g., "Malibu, California")',
                        'placeholder' => 'Malibu, California',
                    ),
                    // Price - Required
                    array(
                        'key' => 'field_property_price',
                        'label' => 'Price',
                        'name' => 'property_price',
                        'type' => 'text',
                        'required' => 1,
                        'instructions' => 'Enter the property price (e.g., "$1,250,000")',
                        'placeholder' => '$1,250,000',
                    ),
                    // Bedrooms - Required
                    array(
                        'key' => 'field_property_bedrooms',
                        'label' => 'Bedrooms',
                        'name' => 'property_bedrooms',
                        'type' => 'text',
                        'required' => 1,
                        'instructions' => 'Enter the number of bedrooms (e.g., "04")',
                        'placeholder' => '04',
                    ),
                    // Bathrooms - Required
                    array(
                        'key' => 'field_property_bathrooms',
                        'label' => 'Bathrooms',
                        'name' => 'property_bathrooms',
                        'type' => 'text',
                        'required' => 1,
                        'instructions' => 'Enter the number of bathrooms (e.g., "03")',
                        'placeholder' => '03',
                    ),
                    // Area/Square Footage - Required
                    array(
                        'key' => 'field_property_area',
                        'label' => 'Area/Square Footage',
                        'name' => 'property_area',
                        'type' => 'text',
                        'required' => 1,
                        'instructions' => 'Enter the area/square footage (e.g., "2,500 Square Feet")',
                        'placeholder' => '2,500 Square Feet',
                    ),
                    // Key Features and Amenities - Multiple individual fields
                    array(
                        'key' => 'field_property_feature_1',
                        'label' => 'Feature 1',
                        'name' => 'property_feature_1',
                        'type' => 'text',
                        'required' => 0,
                        'instructions' => 'Enter the first key feature or amenity',
                        'placeholder' => 'Oceanfront terrace',
                    ),
                    array(
                        'key' => 'field_property_feature_2',
                        'label' => 'Feature 2',
                        'name' => 'property_feature_2',
                        'type' => 'text',
                        'required' => 0,
                        'instructions' => 'Enter the second key feature or amenity',
                        'placeholder' => 'Swimming pool',
                    ),
                    array(
                        'key' => 'field_property_feature_3',
                        'label' => 'Feature 3',
                        'name' => 'property_feature_3',
                        'type' => 'text',
                        'required' => 0,
                        'instructions' => 'Enter the third key feature or amenity',
                        'placeholder' => 'Modern kitchen',
                    ),
                    array(
                        'key' => 'field_property_feature_4',
                        'label' => 'Feature 4',
                        'name' => 'property_feature_4',
                        'type' => 'text',
                        'required' => 0,
                        'instructions' => 'Enter the fourth key feature or amenity',
                        'placeholder' => 'Garden view',
                    ),
                    array(
                        'key' => 'field_property_feature_5',
                        'label' => 'Feature 5',
                        'name' => 'property_feature_5',
                        'type' => 'text',
                        'required' => 0,
                        'instructions' => 'Enter the fifth key feature or amenity',
                        'placeholder' => 'Parking space',
                    ),
                    array(
                        'key' => 'field_property_feature_6',
                        'label' => 'Feature 6',
                        'name' => 'property_feature_6',
                        'type' => 'text',
                        'required' => 0,
                        'instructions' => 'Enter the sixth key feature or amenity',
                        'placeholder' => 'Balcony',
                    ),
                    array(
                        'key' => 'field_property_feature_7',
                        'label' => 'Feature 7',
                        'name' => 'property_feature_7',
                        'type' => 'text',
                        'required' => 0,
                        'instructions' => 'Enter the seventh key feature or amenity',
                        'placeholder' => 'Fireplace',
                    ),
                    array(
                        'key' => 'field_property_feature_8',
                        'label' => 'Feature 8',
                        'name' => 'property_feature_8',
                        'type' => 'text',
                        'required' => 0,
                        'instructions' => 'Enter the eighth key feature or amenity',
                        'placeholder' => 'Home office',
                    ),
                    array(
                        'key' => 'field_property_feature_9',
                        'label' => 'Feature 9',
                        'name' => 'property_feature_9',
                        'type' => 'text',
                        'required' => 0,
                        'instructions' => 'Enter the ninth key feature or amenity',
                        'placeholder' => 'Walk-in closet',
                    ),
                    array(
                        'key' => 'field_property_feature_10',
                        'label' => 'Feature 10',
                        'name' => 'property_feature_10',
                        'type' => 'text',
                        'required' => 0,
                        'instructions' => 'Enter the tenth key feature or amenity',
                        'placeholder' => 'Security system',
                    ),
                    // Listing Price - Required
                    array(
                        'key' => 'field_property_listing_price',
                        'label' => 'Listing Price',
                        'name' => 'property_listing_price',
                        'type' => 'text',
                        'required' => 1,
                        'instructions' => 'Enter the listing price (e.g., "$1,250,000"). This should match the main price.',
                        'placeholder' => '$1,250,000',
                    ),
                    // Additional Fees - Optional (Textarea format: "Fee Name: Amount" per line)
                    array(
                        'key' => 'field_property_additional_fees',
                        'label' => 'Additional Fees',
                        'name' => 'property_additional_fees',
                        'type' => 'textarea',
                        'required' => 0,
                        'instructions' => 'Enter additional fees, one per line in format: "Fee Name: Amount" (e.g., "Property Transfer Tax: $5,000")',
                        'placeholder' => 'Property Transfer Tax: $5,000' . "\n" . 'Legal Fees: $2,500',
                        'rows' => 5,
                    ),
                    // Monthly Costs - Optional (Textarea format: "Cost Name: Amount" per line)
                    array(
                        'key' => 'field_property_monthly_costs',
                        'label' => 'Monthly Costs',
                        'name' => 'property_monthly_costs',
                        'type' => 'textarea',
                        'required' => 0,
                        'instructions' => 'Enter monthly costs, one per line in format: "Cost Name: Amount" (e.g., "Property Taxes: $500")',
                        'placeholder' => 'Property Taxes: $500' . "\n" . 'HOA Fee: $200',
                        'rows' => 5,
                    ),
                    // Total Initial Costs - Optional (Textarea format: "Cost Name: Amount" per line)
                    array(
                        'key' => 'field_property_total_initial_costs',
                        'label' => 'Total Initial Costs',
                        'name' => 'property_total_initial_costs',
                        'type' => 'textarea',
                        'required' => 0,
                        'instructions' => 'Enter total initial costs, one per line in format: "Cost Name: Amount" (e.g., "Down Payment: $250,000")',
                        'placeholder' => 'Down Payment: $250,000' . "\n" . 'Mortgage Amount: $1,000,000',
                        'rows' => 5,
                    ),
                    // Monthly Expenses - Optional (Textarea format: "Expense Name: Amount" per line)
                    array(
                        'key' => 'field_property_monthly_expenses',
                        'label' => 'Monthly Expenses',
                        'name' => 'property_monthly_expenses',
                        'type' => 'textarea',
                        'required' => 0,
                        'instructions' => 'Enter monthly expenses, one per line in format: "Expense Name: Amount" (e.g., "Mortgage Payment: $3,500")',
                        'placeholder' => 'Mortgage Payment: $3,500' . "\n" . 'Insurance: $150',
                        'rows' => 5,
                    ),
                    // Property Images - Individual fields with thumbnail checkboxes
                    array(
                        'key' => 'field_property_image_1',
                        'label' => 'Image 1',
                        'name' => 'property_image_1',
                        'type' => 'image',
                        'instructions' => 'Upload the first property image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_property_image_1_thumbnail',
                        'label' => 'Use Image 1 as Thumbnail',
                        'name' => 'property_image_1_thumbnail',
                        'type' => 'true_false',
                        'instructions' => 'Check this box to use Image 1 as the thumbnail/featured image',
                        'default_value' => 1,
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_property_image_2',
                        'label' => 'Image 2',
                        'name' => 'property_image_2',
                        'type' => 'image',
                        'instructions' => 'Upload the second property image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_property_image_2_thumbnail',
                        'label' => 'Use Image 2 as Thumbnail',
                        'name' => 'property_image_2_thumbnail',
                        'type' => 'true_false',
                        'instructions' => 'Check this box to use Image 2 as the thumbnail/featured image',
                        'default_value' => 0,
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_property_image_3',
                        'label' => 'Image 3',
                        'name' => 'property_image_3',
                        'type' => 'image',
                        'instructions' => 'Upload the third property image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_property_image_3_thumbnail',
                        'label' => 'Use Image 3 as Thumbnail',
                        'name' => 'property_image_3_thumbnail',
                        'type' => 'true_false',
                        'instructions' => 'Check this box to use Image 3 as the thumbnail/featured image',
                        'default_value' => 0,
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_property_image_4',
                        'label' => 'Image 4',
                        'name' => 'property_image_4',
                        'type' => 'image',
                        'instructions' => 'Upload the fourth property image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_property_image_4_thumbnail',
                        'label' => 'Use Image 4 as Thumbnail',
                        'name' => 'property_image_4_thumbnail',
                        'type' => 'true_false',
                        'instructions' => 'Check this box to use Image 4 as the thumbnail/featured image',
                        'default_value' => 0,
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_property_image_5',
                        'label' => 'Image 5',
                        'name' => 'property_image_5',
                        'type' => 'image',
                        'instructions' => 'Upload the fifth property image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_property_image_5_thumbnail',
                        'label' => 'Use Image 5 as Thumbnail',
                        'name' => 'property_image_5_thumbnail',
                        'type' => 'true_false',
                        'instructions' => 'Check this box to use Image 5 as the thumbnail/featured image',
                        'default_value' => 0,
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_property_image_6',
                        'label' => 'Image 6',
                        'name' => 'property_image_6',
                        'type' => 'image',
                        'instructions' => 'Upload the sixth property image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_property_image_6_thumbnail',
                        'label' => 'Use Image 6 as Thumbnail',
                        'name' => 'property_image_6_thumbnail',
                        'type' => 'true_false',
                        'instructions' => 'Check this box to use Image 6 as the thumbnail/featured image',
                        'default_value' => 0,
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_property_image_7',
                        'label' => 'Image 7',
                        'name' => 'property_image_7',
                        'type' => 'image',
                        'instructions' => 'Upload the seventh property image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_property_image_7_thumbnail',
                        'label' => 'Use Image 7 as Thumbnail',
                        'name' => 'property_image_7_thumbnail',
                        'type' => 'true_false',
                        'instructions' => 'Check this box to use Image 7 as the thumbnail/featured image',
                        'default_value' => 0,
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_property_image_8',
                        'label' => 'Image 8',
                        'name' => 'property_image_8',
                        'type' => 'image',
                        'instructions' => 'Upload the eighth property image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_property_image_8_thumbnail',
                        'label' => 'Use Image 8 as Thumbnail',
                        'name' => 'property_image_8_thumbnail',
                        'type' => 'true_false',
                        'instructions' => 'Check this box to use Image 8 as the thumbnail/featured image',
                        'default_value' => 0,
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_property_image_9',
                        'label' => 'Image 9',
                        'name' => 'property_image_9',
                        'type' => 'image',
                        'instructions' => 'Upload the ninth property image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_property_image_9_thumbnail',
                        'label' => 'Use Image 9 as Thumbnail',
                        'name' => 'property_image_9_thumbnail',
                        'type' => 'true_false',
                        'instructions' => 'Check this box to use Image 9 as the thumbnail/featured image',
                        'default_value' => 0,
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_property_image_10',
                        'label' => 'Image 10',
                        'name' => 'property_image_10',
                        'type' => 'image',
                        'instructions' => 'Upload the tenth property image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_property_image_10_thumbnail',
                        'label' => 'Use Image 10 as Thumbnail',
                        'name' => 'property_image_10_thumbnail',
                        'type' => 'true_false',
                        'instructions' => 'Check this box to use Image 10 as the thumbnail/featured image',
                        'default_value' => 0,
                        'ui' => 1,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'property',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
            ));
            
            // Team Member Details Field Group
            acf_add_local_field_group(array(
                'key' => 'group_team_member_details',
                'title' => 'Team Member Details',
                'fields' => array(
                    array(
                        'key' => 'field_member_position',
                        'label' => 'Position',
                        'name' => 'member_position',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_member_email',
                        'label' => 'Email',
                        'name' => 'member_email',
                        'type' => 'email',
                    ),
                    array(
                        'key' => 'field_member_phone',
                        'label' => 'Phone',
                        'name' => 'member_phone',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_member_social',
                        'label' => 'Social Media Links',
                        'name' => 'member_social',
                        'type' => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_social_platform',
                                'label' => 'Platform',
                                'name' => 'social_platform',
                                'type' => 'select',
                                'choices' => array(
                                    'facebook' => 'Facebook',
                                    'twitter' => 'Twitter',
                                    'linkedin' => 'LinkedIn',
                                    'instagram' => 'Instagram',
                                ),
                            ),
                            array(
                                'key' => 'field_social_url',
                                'label' => 'URL',
                                'name' => 'social_url',
                                'type' => 'url',
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'team_member',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
            ));
            
            // Testimonial Details Field Group
            acf_add_local_field_group(array(
                'key' => 'group_testimonial_details',
                'title' => 'Testimonial Details',
                'fields' => array(
                    array(
                        'key' => 'field_testimonial_rating',
                        'label' => 'Rating',
                        'name' => 'testimonial_rating',
                        'type' => 'range',
                        'min' => 1,
                        'max' => 5,
                        'step' => 1,
                        'default_value' => 5,
                    ),
                    array(
                        'key' => 'field_testimonial_client_name',
                        'label' => 'Client Name',
                        'name' => 'testimonial_client_name',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_testimonial_client_location',
                        'label' => 'Client Location',
                        'name' => 'testimonial_client_location',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_testimonial_client_avatar',
                        'label' => 'Client Avatar',
                        'name' => 'testimonial_client_avatar',
                        'type' => 'image',
                        'return_format' => 'array',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'testimonial',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
            ));
            
            // About Page Settings Field Group
            acf_add_local_field_group(array(
                'key' => 'group_about_page_settings',
                'title' => 'About Page Settings',
                'fields' => array(
                    // Tab: Journey Section
                    array(
                        'key' => 'field_tab_journey',
                        'label' => 'Journey Section',
                        'name' => '',
                        'type' => 'tab',
                        'placement' => 'top',
                    ),
                    array(
                        'key' => 'field_about_journey_title',
                        'label' => 'Section Title',
                        'name' => 'about_journey_title',
                        'type' => 'text',
                        'default_value' => 'Our Journey',
                        'instructions' => 'Enter the title for the Journey section',
                    ),
                    array(
                        'key' => 'field_about_journey_description',
                        'label' => 'Section Description',
                        'name' => 'about_journey_description',
                        'type' => 'textarea',
                        'instructions' => 'Enter the description text for the Journey section',
                        'rows' => 4,
                    ),
                    array(
                        'key' => 'field_about_journey_image',
                        'label' => 'Section Image',
                        'name' => 'about_journey_image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'instructions' => 'Upload an image for the Journey section',
                        'preview_size' => 'medium',
                    ),
                    array(
                        'key' => 'field_about_stat_1_number',
                        'label' => 'Stat 1 - Number',
                        'name' => 'about_stat_1_number',
                        'type' => 'text',
                        'default_value' => '200+',
                        'instructions' => 'Enter the number for the first statistic',
                    ),
                    array(
                        'key' => 'field_about_stat_1_label',
                        'label' => 'Stat 1 - Label',
                        'name' => 'about_stat_1_label',
                        'type' => 'text',
                        'default_value' => 'Happy Customers',
                        'instructions' => 'Enter the label for the first statistic',
                    ),
                    array(
                        'key' => 'field_about_stat_2_number',
                        'label' => 'Stat 2 - Number',
                        'name' => 'about_stat_2_number',
                        'type' => 'text',
                        'default_value' => '10k+',
                        'instructions' => 'Enter the number for the second statistic',
                    ),
                    array(
                        'key' => 'field_about_stat_2_label',
                        'label' => 'Stat 2 - Label',
                        'name' => 'about_stat_2_label',
                        'type' => 'text',
                        'default_value' => 'Properties For Clients',
                        'instructions' => 'Enter the label for the second statistic',
                    ),
                    array(
                        'key' => 'field_about_stat_3_number',
                        'label' => 'Stat 3 - Number',
                        'name' => 'about_stat_3_number',
                        'type' => 'text',
                        'default_value' => '16+',
                        'instructions' => 'Enter the number for the third statistic',
                    ),
                    array(
                        'key' => 'field_about_stat_3_label',
                        'label' => 'Stat 3 - Label',
                        'name' => 'about_stat_3_label',
                        'type' => 'text',
                        'default_value' => 'Years of Experience',
                        'instructions' => 'Enter the label for the third statistic',
                    ),
                    // Tab: Values Section
                    array(
                        'key' => 'field_tab_values',
                        'label' => 'Values Section',
                        'name' => '',
                        'type' => 'tab',
                        'placement' => 'top',
                    ),
                    array(
                        'key' => 'field_about_values_title',
                        'label' => 'Section Title',
                        'name' => 'about_values_title',
                        'type' => 'text',
                        'default_value' => 'Our Values',
                        'instructions' => 'Enter the title for the Values section',
                    ),
                    array(
                        'key' => 'field_about_values_description',
                        'label' => 'Section Description',
                        'name' => 'about_values_description',
                        'type' => 'textarea',
                        'instructions' => 'Enter the description text for the Values section',
                        'rows' => 4,
                    ),
                    // Value 1
                    array(
                        'key' => 'field_value_1_title',
                        'label' => 'Value 1 - Title',
                        'name' => 'value_1_title',
                        'type' => 'text',
                        'default_value' => 'Trust',
                        'placeholder' => 'e.g., Trust',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                            array(
                        'key' => 'field_value_1_description',
                        'label' => 'Value 1 - Description',
                        'name' => 'value_1_description',
                        'type' => 'textarea',
                        'default_value' => 'Trust is the cornerstone of every successful real estate transaction.',
                        'rows' => 3,
                        'placeholder' => 'Describe this value...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_value_1_icon',
                        'label' => 'Value 1 - Icon (Optional)',
                        'name' => 'value_1_icon',
                        'type' => 'image',
                        'return_format' => 'array',
                        'instructions' => 'Upload an icon for this value. If not provided, a default icon will be used.',
                        'preview_size' => 'thumbnail',
                    ),
                    // Value 2
                    array(
                        'key' => 'field_value_2_title',
                        'label' => 'Value 2 - Title',
                        'name' => 'value_2_title',
                                'type' => 'text',
                        'default_value' => 'Excellence',
                        'placeholder' => 'e.g., Excellence',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                            ),
                            array(
                        'key' => 'field_value_2_description',
                        'label' => 'Value 2 - Description',
                        'name' => 'value_2_description',
                                'type' => 'textarea',
                        'default_value' => 'We set the bar high for ourselves. From the properties we list to the services we provide.',
                        'rows' => 3,
                        'placeholder' => 'Describe this value...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                            ),
                            array(
                        'key' => 'field_value_2_icon',
                        'label' => 'Value 2 - Icon (Optional)',
                        'name' => 'value_2_icon',
                                'type' => 'image',
                                'return_format' => 'array',
                        'instructions' => 'Upload an icon for this value. If not provided, a default icon will be used.',
                        'preview_size' => 'thumbnail',
                    ),
                    // Value 3
                    array(
                        'key' => 'field_value_3_title',
                        'label' => 'Value 3 - Title',
                        'name' => 'value_3_title',
                        'type' => 'text',
                        'default_value' => 'Client-Centric',
                        'placeholder' => 'e.g., Client-Centric',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_value_3_description',
                        'label' => 'Value 3 - Description',
                        'name' => 'value_3_description',
                        'type' => 'textarea',
                        'default_value' => 'Your dreams and needs are at the center of our universe. We listen, understand.',
                        'rows' => 3,
                        'placeholder' => 'Describe this value...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_value_3_icon',
                        'label' => 'Value 3 - Icon (Optional)',
                        'name' => 'value_3_icon',
                        'type' => 'image',
                        'return_format' => 'array',
                        'instructions' => 'Upload an icon for this value. If not provided, a default icon will be used.',
                        'preview_size' => 'thumbnail',
                    ),
                    // Value 4
                    array(
                        'key' => 'field_value_4_title',
                        'label' => 'Value 4 - Title',
                        'name' => 'value_4_title',
                        'type' => 'text',
                        'default_value' => 'Our Commitment',
                        'placeholder' => 'e.g., Our Commitment',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_value_4_description',
                        'label' => 'Value 4 - Description',
                        'name' => 'value_4_description',
                        'type' => 'textarea',
                        'default_value' => 'We are dedicated to providing you with the highest level of service, professionalism, and support.',
                        'rows' => 3,
                        'placeholder' => 'Describe this value...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_value_4_icon',
                        'label' => 'Value 4 - Icon (Optional)',
                        'name' => 'value_4_icon',
                        'type' => 'image',
                        'return_format' => 'array',
                        'instructions' => 'Upload an icon for this value. If not provided, a default icon will be used.',
                        'preview_size' => 'thumbnail',
                    ),
                    // Tab: Achievements Section
                    array(
                        'key' => 'field_tab_achievements',
                        'label' => 'Achievements Section',
                        'name' => '',
                        'type' => 'tab',
                        'placement' => 'top',
                    ),
                    array(
                        'key' => 'field_about_achievements_title',
                        'label' => 'Section Title',
                        'name' => 'about_achievements_title',
                        'type' => 'text',
                        'default_value' => 'Our Achievements',
                        'instructions' => 'Enter the title for the Achievements section',
                    ),
                    array(
                        'key' => 'field_about_achievements_description',
                        'label' => 'Section Description',
                        'name' => 'about_achievements_description',
                        'type' => 'textarea',
                        'instructions' => 'Enter the description text for the Achievements section (optional)',
                        'rows' => 4,
                    ),
                    // Achievement 1
                    array(
                        'key' => 'field_achievement_1_title',
                        'label' => 'Achievement 1 - Title',
                        'name' => 'achievement_1_title',
                        'type' => 'text',
                        'default_value' => '3+ Years of Excellence',
                        'placeholder' => 'e.g., 3+ Years of Excellence',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                            array(
                        'key' => 'field_achievement_1_description',
                        'label' => 'Achievement 1 - Description',
                        'name' => 'achievement_1_description',
                        'type' => 'textarea',
                        'default_value' => 'With over 3 years in the industry, we\'ve amassed a wealth of knowledge and experience, becoming a go-to resource for all things real estate.',
                        'rows' => 3,
                        'placeholder' => 'Describe this achievement...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    // Achievement 2
                    array(
                        'key' => 'field_achievement_2_title',
                        'label' => 'Achievement 2 - Title',
                        'name' => 'achievement_2_title',
                                'type' => 'text',
                        'default_value' => 'Happy Clients',
                        'placeholder' => 'e.g., Happy Clients',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                            ),
                            array(
                        'key' => 'field_achievement_2_description',
                        'label' => 'Achievement 2 - Description',
                        'name' => 'achievement_2_description',
                                'type' => 'textarea',
                        'default_value' => 'Our greatest achievement is the satisfaction of our clients. Their success stories fuel our passion for what we do.',
                        'rows' => 3,
                        'placeholder' => 'Describe this achievement...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    // Achievement 3
                    array(
                        'key' => 'field_achievement_3_title',
                        'label' => 'Achievement 3 - Title',
                        'name' => 'achievement_3_title',
                        'type' => 'text',
                        'default_value' => 'Industry Recognition',
                        'placeholder' => 'e.g., Industry Recognition',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_achievement_3_description',
                        'label' => 'Achievement 3 - Description',
                        'name' => 'achievement_3_description',
                        'type' => 'textarea',
                        'default_value' => 'We\'ve earned the respect of our peers and industry leaders, with accolades and awards that reflect our commitment to excellence.',
                        'rows' => 3,
                        'placeholder' => 'Describe this achievement...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    // Tab: Process Section
                    array(
                        'key' => 'field_tab_process',
                        'label' => 'Process Section',
                        'name' => '',
                        'type' => 'tab',
                        'placement' => 'top',
                    ),
                    array(
                        'key' => 'field_about_process_title',
                        'label' => 'Section Title',
                        'name' => 'about_process_title',
                        'type' => 'text',
                        'default_value' => 'Navigating the Estatein Experience',
                        'instructions' => 'Enter the title for the Process section',
                    ),
                    array(
                        'key' => 'field_about_process_description',
                        'label' => 'Section Description',
                        'name' => 'about_process_description',
                        'type' => 'textarea',
                        'instructions' => 'Enter the description text for the Process section (optional)',
                        'rows' => 4,
                    ),
                    // Step 1
                    array(
                        'key' => 'field_step_1_title',
                        'label' => 'Step 1 - Title',
                        'name' => 'step_1_title',
                        'type' => 'text',
                        'default_value' => 'Discover a World of Possibilities',
                        'placeholder' => 'e.g., Discover a World of Possibilities',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                            array(
                        'key' => 'field_step_1_description',
                        'label' => 'Step 1 - Description',
                        'name' => 'step_1_description',
                        'type' => 'textarea',
                        'default_value' => 'Your journey begins with exploring our carefully curated property listings. Use our intuitive search tools to filter properties based on your preferences, including location, type, size, and budget.',
                        'rows' => 4,
                        'placeholder' => 'Describe this step in detail...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    // Step 2
                    array(
                        'key' => 'field_step_2_title',
                        'label' => 'Step 2 - Title',
                        'name' => 'step_2_title',
                                'type' => 'text',
                        'default_value' => 'Narrowing Down Your Choices',
                        'placeholder' => 'e.g., Narrowing Down Your Choices',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                            ),
                            array(
                        'key' => 'field_step_2_description',
                        'label' => 'Step 2 - Description',
                        'name' => 'step_2_description',
                                'type' => 'textarea',
                        'default_value' => 'Once you\'ve found properties that catch your eye, save them to your account or make a shortlist. This allows you to compare and revisit your favorites as you make your decision.',
                        'rows' => 4,
                        'placeholder' => 'Describe this step in detail...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    // Step 3
                    array(
                        'key' => 'field_step_3_title',
                        'label' => 'Step 3 - Title',
                        'name' => 'step_3_title',
                        'type' => 'text',
                        'default_value' => 'Personalized Guidance',
                        'placeholder' => 'e.g., Personalized Guidance',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_step_3_description',
                        'label' => 'Step 3 - Description',
                        'name' => 'step_3_description',
                        'type' => 'textarea',
                        'default_value' => 'Have questions about a property or need more information? Our dedicated team of real estate experts is just a call or message away.',
                        'rows' => 4,
                        'placeholder' => 'Describe this step in detail...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    // Step 4
                    array(
                        'key' => 'field_step_4_title',
                        'label' => 'Step 4 - Title',
                        'name' => 'step_4_title',
                        'type' => 'text',
                        'default_value' => 'See It for Yourself',
                        'placeholder' => 'e.g., See It for Yourself',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_step_4_description',
                        'label' => 'Step 4 - Description',
                        'name' => 'step_4_description',
                        'type' => 'textarea',
                        'default_value' => 'Arrange viewings of the properties you\'re interested in. We\'ll coordinate with the property owners and accompany you to ensure you get a firsthand look at your potential new home.',
                        'rows' => 4,
                        'placeholder' => 'Describe this step in detail...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    // Step 5
                    array(
                        'key' => 'field_step_5_title',
                        'label' => 'Step 5 - Title',
                        'name' => 'step_5_title',
                        'type' => 'text',
                        'default_value' => 'Making Informed Decisions',
                        'placeholder' => 'e.g., Making Informed Decisions',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_step_5_description',
                        'label' => 'Step 5 - Description',
                        'name' => 'step_5_description',
                        'type' => 'textarea',
                        'default_value' => 'Before making an offer, our team will assist you with due diligence, including property inspections, legal checks, and market analysis. We want you to be fully informed and confident in your choice.',
                        'rows' => 4,
                        'placeholder' => 'Describe this step in detail...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    // Step 6
                    array(
                        'key' => 'field_step_6_title',
                        'label' => 'Step 6 - Title',
                        'name' => 'step_6_title',
                        'type' => 'text',
                        'default_value' => 'Getting the Best Deal',
                        'placeholder' => 'e.g., Getting the Best Deal',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_step_6_description',
                        'label' => 'Step 6 - Description',
                        'name' => 'step_6_description',
                        'type' => 'textarea',
                        'default_value' => 'We\'ll help you negotiate the best terms and prepare your offer. Our goal is to secure the property at the right price and on favorable terms.',
                        'rows' => 4,
                        'placeholder' => 'Describe this step in detail...',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    // Tab: Team Section
                    array(
                        'key' => 'field_tab_team',
                        'label' => 'Team Section',
                        'name' => '',
                        'type' => 'tab',
                        'placement' => 'top',
                    ),
                    array(
                        'key' => 'field_about_team_title',
                        'label' => 'Section Title',
                        'name' => 'about_team_title',
                        'type' => 'text',
                        'default_value' => 'Meet the Estatein Team',
                        'instructions' => 'Enter the title for the Team section',
                    ),
                    array(
                        'key' => 'field_about_team_description',
                        'label' => 'Section Description',
                        'name' => 'about_team_description',
                        'type' => 'textarea',
                        'instructions' => 'Enter the description text for the Team section (optional). Note: Team members are managed separately in the Team Members custom post type.',
                        'rows' => 4,
                    ),
                    // Tab: Clients Section
                    array(
                        'key' => 'field_tab_clients',
                        'label' => 'Clients Section',
                        'name' => '',
                        'type' => 'tab',
                        'placement' => 'top',
                    ),
                    array(
                        'key' => 'field_about_clients_title',
                        'label' => 'Section Title',
                        'name' => 'about_clients_title',
                        'type' => 'text',
                        'default_value' => 'Our Valued Clients',
                        'instructions' => 'Enter the title for the Clients section',
                    ),
                    array(
                        'key' => 'field_about_clients_description',
                        'label' => 'Section Description',
                        'name' => 'about_clients_description',
                        'type' => 'textarea',
                        'instructions' => 'Enter the description text for the Clients section (optional)',
                        'rows' => 4,
                    ),
                    // Client 1
                    array(
                        'key' => 'field_client_1_company_name',
                        'label' => 'Client 1 - Company Name',
                        'name' => 'client_1_company_name',
                        'type' => 'text',
                        'placeholder' => 'e.g., Acme Corporation',
                        'wrapper' => array(
                            'width' => '33',
                        ),
                    ),
                            array(
                        'key' => 'field_client_1_since_date',
                        'label' => 'Client 1 - Since Date',
                        'name' => 'client_1_since_date',
                                'type' => 'text',
                        'placeholder' => 'Since 2019',
                        'instructions' => 'Enter when you started working with this client',
                        'wrapper' => array(
                            'width' => '33',
                        ),
                            ),
                            array(
                        'key' => 'field_client_1_website_url',
                        'label' => 'Client 1 - Website URL',
                        'name' => 'client_1_website_url',
                        'type' => 'url',
                        'instructions' => 'Enter the client\'s website URL',
                        'wrapper' => array(
                            'width' => '34',
                        ),
                    ),
                    array(
                        'key' => 'field_client_1_domain',
                        'label' => 'Client 1 - Domain',
                        'name' => 'client_1_domain',
                        'type' => 'text',
                        'placeholder' => 'e.g., Real Estate, Technology',
                        'instructions' => 'Enter the business domain/industry',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_client_1_category',
                        'label' => 'Client 1 - Category',
                        'name' => 'client_1_category',
                        'type' => 'text',
                        'placeholder' => 'e.g., Enterprise Client',
                        'instructions' => 'Enter the client category',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_client_1_testimonial',
                        'label' => 'Client 1 - Testimonial (Optional)',
                        'name' => 'client_1_testimonial',
                        'type' => 'textarea',
                        'rows' => 3,
                        'instructions' => 'Enter a testimonial from this client (optional)',
                        'placeholder' => 'What the client said about working with you...',
                    ),
                    // Client 2
                    array(
                        'key' => 'field_client_2_company_name',
                        'label' => 'Client 2 - Company Name',
                        'name' => 'client_2_company_name',
                        'type' => 'text',
                        'placeholder' => 'e.g., Acme Corporation',
                        'wrapper' => array(
                            'width' => '33',
                        ),
                    ),
                    array(
                        'key' => 'field_client_2_since_date',
                        'label' => 'Client 2 - Since Date',
                        'name' => 'client_2_since_date',
                                'type' => 'text',
                                'placeholder' => 'Since 2019',
                        'instructions' => 'Enter when you started working with this client',
                        'wrapper' => array(
                            'width' => '33',
                        ),
                            ),
                            array(
                        'key' => 'field_client_2_website_url',
                        'label' => 'Client 2 - Website URL',
                        'name' => 'client_2_website_url',
                                'type' => 'url',
                        'instructions' => 'Enter the client\'s website URL',
                        'wrapper' => array(
                            'width' => '34',
                        ),
                            ),
                            array(
                        'key' => 'field_client_2_domain',
                        'label' => 'Client 2 - Domain',
                        'name' => 'client_2_domain',
                                'type' => 'text',
                        'placeholder' => 'e.g., Real Estate, Technology',
                        'instructions' => 'Enter the business domain/industry',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                            ),
                            array(
                        'key' => 'field_client_2_category',
                        'label' => 'Client 2 - Category',
                        'name' => 'client_2_category',
                                'type' => 'text',
                        'placeholder' => 'e.g., Enterprise Client',
                        'instructions' => 'Enter the client category',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                            ),
                            array(
                        'key' => 'field_client_2_testimonial',
                        'label' => 'Client 2 - Testimonial (Optional)',
                        'name' => 'client_2_testimonial',
                                'type' => 'textarea',
                        'rows' => 3,
                        'instructions' => 'Enter a testimonial from this client (optional)',
                        'placeholder' => 'What the client said about working with you...',
                    ),
                    // Client 3
                    array(
                        'key' => 'field_client_3_company_name',
                        'label' => 'Client 3 - Company Name',
                        'name' => 'client_3_company_name',
                        'type' => 'text',
                        'placeholder' => 'e.g., Acme Corporation',
                        'wrapper' => array(
                            'width' => '33',
                        ),
                    ),
                    array(
                        'key' => 'field_client_3_since_date',
                        'label' => 'Client 3 - Since Date',
                        'name' => 'client_3_since_date',
                        'type' => 'text',
                        'placeholder' => 'Since 2019',
                        'instructions' => 'Enter when you started working with this client',
                        'wrapper' => array(
                            'width' => '33',
                        ),
                    ),
                    array(
                        'key' => 'field_client_3_website_url',
                        'label' => 'Client 3 - Website URL',
                        'name' => 'client_3_website_url',
                        'type' => 'url',
                        'instructions' => 'Enter the client\'s website URL',
                        'wrapper' => array(
                            'width' => '34',
                        ),
                    ),
                    array(
                        'key' => 'field_client_3_domain',
                        'label' => 'Client 3 - Domain',
                        'name' => 'client_3_domain',
                        'type' => 'text',
                        'placeholder' => 'e.g., Real Estate, Technology',
                        'instructions' => 'Enter the business domain/industry',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_client_3_category',
                        'label' => 'Client 3 - Category',
                        'name' => 'client_3_category',
                        'type' => 'text',
                        'placeholder' => 'e.g., Enterprise Client',
                        'instructions' => 'Enter the client category',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_client_3_testimonial',
                        'label' => 'Client 3 - Testimonial (Optional)',
                        'name' => 'client_3_testimonial',
                        'type' => 'textarea',
                        'rows' => 3,
                        'instructions' => 'Enter a testimonial from this client (optional)',
                        'placeholder' => 'What the client said about working with you...',
                    ),
                    // Client 4
                    array(
                        'key' => 'field_client_4_company_name',
                        'label' => 'Client 4 - Company Name',
                        'name' => 'client_4_company_name',
                        'type' => 'text',
                        'placeholder' => 'e.g., Acme Corporation',
                        'wrapper' => array(
                            'width' => '33',
                        ),
                    ),
                    array(
                        'key' => 'field_client_4_since_date',
                        'label' => 'Client 4 - Since Date',
                        'name' => 'client_4_since_date',
                        'type' => 'text',
                        'placeholder' => 'Since 2019',
                        'instructions' => 'Enter when you started working with this client',
                        'wrapper' => array(
                            'width' => '33',
                        ),
                    ),
                    array(
                        'key' => 'field_client_4_website_url',
                        'label' => 'Client 4 - Website URL',
                        'name' => 'client_4_website_url',
                        'type' => 'url',
                        'instructions' => 'Enter the client\'s website URL',
                        'wrapper' => array(
                            'width' => '34',
                        ),
                    ),
                    array(
                        'key' => 'field_client_4_domain',
                        'label' => 'Client 4 - Domain',
                        'name' => 'client_4_domain',
                        'type' => 'text',
                        'placeholder' => 'e.g., Real Estate, Technology',
                        'instructions' => 'Enter the business domain/industry',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_client_4_category',
                        'label' => 'Client 4 - Category',
                        'name' => 'client_4_category',
                        'type' => 'text',
                        'placeholder' => 'e.g., Enterprise Client',
                        'instructions' => 'Enter the client category',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_client_4_testimonial',
                        'label' => 'Client 4 - Testimonial (Optional)',
                        'name' => 'client_4_testimonial',
                        'type' => 'textarea',
                        'rows' => 3,
                        'instructions' => 'Enter a testimonial from this client (optional)',
                        'placeholder' => 'What the client said about working with you...',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'page_template',
                            'operator' => '==',
                            'value' => 'page-about.php',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
            ));
            
            // Properties Page Settings
            acf_add_local_field_group(array(
                'key' => 'group_properties_page_settings',
                'title' => 'Properties Page Settings',
                'fields' => array(
                    array(
                        'key' => 'field_properties_hero_title',
                        'label' => 'Hero Title',
                        'name' => 'properties_hero_title',
                        'type' => 'text',
                        'default_value' => 'Find Your Dream Property',
                        'instructions' => 'Enter the hero section title',
                    ),
                    array(
                        'key' => 'field_properties_hero_description',
                        'label' => 'Hero Description',
                        'name' => 'properties_hero_description',
                        'type' => 'textarea',
                        'default_value' => 'Welcome to Estatein, where your dream property awaits in every corner of our beautiful world. Explore our curated selection of properties, each offering a unique story and a chance to redefine your life. With categories to suit every dreamer, your journey',
                        'rows' => 4,
                        'instructions' => 'Enter the hero section description',
                    ),
                    array(
                        'key' => 'field_properties_section_title',
                        'label' => 'Properties Section Title',
                        'name' => 'properties_section_title',
                        'type' => 'text',
                        'default_value' => 'Discover a World of Possibilities',
                        'instructions' => 'Enter the properties listing section title',
                    ),
                    array(
                        'key' => 'field_properties_section_description',
                        'label' => 'Properties Section Description',
                        'name' => 'properties_section_description',
                        'type' => 'textarea',
                        'default_value' => 'Our portfolio of properties is as diverse as your dreams. Explore the following categories to find the perfect property that resonates with your vision of home',
                        'rows' => 3,
                        'instructions' => 'Enter the properties listing section description',
                    ),
                    array(
                        'key' => 'field_properties_contact_title',
                        'label' => 'Contact Section Title',
                        'name' => 'properties_contact_title',
                        'type' => 'text',
                        'default_value' => 'Let\'s Make it Happen',
                        'instructions' => 'Enter the contact form section title',
                    ),
                    array(
                        'key' => 'field_properties_contact_description',
                        'label' => 'Contact Section Description',
                        'name' => 'properties_contact_description',
                        'type' => 'textarea',
                        'default_value' => 'Ready to take the first step toward your dream property? Fill out the form below, and our real estate wizards will work their magic to find your perfect match. Don\'t wait; let\'s embark on this exciting journey together.',
                        'rows' => 4,
                        'instructions' => 'Enter the contact form section description',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'page_template',
                            'operator' => '==',
                            'value' => 'page-properties.php',
                        ),
                    ),
                    array(
                        array(
                            'param' => 'page_slug',
                            'operator' => '==',
                            'value' => 'properties',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
            ));
            
        }
    }
}
add_action('acf/init', 'figma_custom_theme_create_acf_fields');

/**
 * Custom location rule to match pages by slug
 * This ensures About Page Settings appear on pages with slug "about"
 */
if (!function_exists('figma_custom_theme_match_about_page')) {
    function figma_custom_theme_match_about_page($match, $rule, $screen, $field_group) {
        // Only process for About Page Settings field group
        if (!isset($field_group['key']) || $field_group['key'] !== 'group_about_page_settings') {
            return $match;
        }
        
        // Only on page edit screens
        if (!isset($screen['post_id']) || get_post_type($screen['post_id']) !== 'page') {
            return $match;
        }
        
        $post = get_post($screen['post_id']);
        if (!$post) {
            return $match;
        }
        
        // Check if page slug is "about" or page uses about template
        $page_slug = $post->post_name;
        $page_template = get_page_template_slug($post->ID);
        
        if ($page_slug === 'about' || $page_template === 'page-about.php') {
            return true;
        }
        
        return $match;
    }
}
add_filter('acf/location/rule_match', 'figma_custom_theme_match_about_page', 10, 4);

/**
 * Custom location rule to match Properties page by slug
 * This ensures Properties Page Settings appear on pages with slug "properties"
 */
if (!function_exists('figma_custom_theme_match_properties_page')) {
    function figma_custom_theme_match_properties_page($match, $rule, $screen, $field_group) {
        // Only process for Properties Page Settings field group
        if (!isset($field_group['key']) || $field_group['key'] !== 'group_properties_page_settings') {
            return $match;
        }
        
        // Only on page edit screens
        if (!isset($screen['post_id']) || get_post_type($screen['post_id']) !== 'page') {
            return $match;
        }
        
        $post = get_post($screen['post_id']);
        if (!$post) {
            return $match;
        }
        
        // Check if page slug is "properties" or page uses properties template
        $page_slug = $post->post_name;
        $page_template = get_page_template_slug($post->ID);
        
        if ($page_slug === 'properties' || $page_template === 'page-properties.php') {
            return true;
        }
        
        return $match;
    }
}
add_filter('acf/location/rule_match/page_slug', 'figma_custom_theme_match_properties_page', 10, 4);

/**
 * Force properties page template for pages with slug "properties"
 */
if (!function_exists('figma_custom_theme_properties_page_template')) {
    function figma_custom_theme_properties_page_template($template) {
        if (is_page('properties') || (is_page() && get_queried_object() && get_queried_object()->post_name === 'properties')) {
            $properties_template = locate_template('page-properties.php');
            if ($properties_template) {
                return $properties_template;
            }
        }
        return $template;
    }
}
add_filter('template_include', 'figma_custom_theme_properties_page_template', 99);

/**
 * Force services page template for pages with slug "services"
 * Prevents service post type archive from overriding the static page
 */
if (!function_exists('figma_custom_theme_services_page_template')) {
    function figma_custom_theme_services_page_template($template) {
        global $wp_query;
        
        // Check if URL is /services/ and if a page with that slug exists
        $request_uri = $_SERVER['REQUEST_URI'] ?? '';
        $pagename = get_query_var('pagename');
        
        // If it's the services page slug, check if it's actually a page
        if ($pagename === 'services' || (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/services') !== false && !strpos($_SERVER['REQUEST_URI'], '/service-archive'))) {
            // Check if a page with slug "services" exists
            $services_page = get_page_by_path('services');
            
            if ($services_page && $services_page->post_status === 'publish') {
                // Force WordPress to treat this as a page, not an archive
                $wp_query->is_page = true;
                $wp_query->is_singular = true;
                $wp_query->is_archive = false;
                $wp_query->is_post_type_archive = false;
                $wp_query->queried_object = $services_page;
                $wp_query->queried_object_id = $services_page->ID;
                
                $services_template = locate_template('page-services.php');
                if ($services_template) {
                    return $services_template;
                }
            }
        }
        
        // Also check if page template is set
        if (is_page()) {
            $queried_object = get_queried_object();
            if ($queried_object && isset($queried_object->post_name) && $queried_object->post_name === 'services') {
                $services_template = locate_template('page-services.php');
                if ($services_template) {
                    return $services_template;
                }
            } elseif (get_page_template_slug() === 'page-services.php') {
                $services_template = locate_template('page-services.php');
                if ($services_template) {
                    return $services_template;
                }
            }
        }
        
        return $template;
    }
}
add_filter('template_include', 'figma_custom_theme_services_page_template', 1);

/**
 * Modify query early to prevent service archive from overriding services page
 */
if (!function_exists('figma_custom_theme_prevent_service_archive_override')) {
    function figma_custom_theme_prevent_service_archive_override($query) {
        if (is_admin() || !$query->is_main_query()) {
            return;
        }
        
        // Check if requesting /services/ URL
        $request_uri = isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI'], '/') : '';
        $pagename = get_query_var('pagename');
        
        // If URL is exactly /services/ or pagename is services
        if ($pagename === 'services' || $request_uri === 'services') {
            // Check if a page with slug "services" exists
            $services_page = get_page_by_path('services');
            
            if ($services_page && $services_page->post_status === 'publish') {
                // Force WordPress to treat this as a page query, not an archive
                $query->set('post_type', 'page');
                $query->set('page_id', $services_page->ID);
                $query->set('name', '');
                $query->set('pagename', 'services');
                $query->set('post_type', 'page');
                $query->is_page = true;
                $query->is_singular = true;
                $query->is_archive = false;
                $query->is_post_type_archive = false;
                $query->is_home = false;
            }
        }
    }
}
add_action('pre_get_posts', 'figma_custom_theme_prevent_service_archive_override', 1);


/* ========================================
   WORDPRESS LOOP ENHANCEMENTS
======================================== */

/**
 * Custom query modifications
 */
if (!function_exists('figma_custom_theme_modify_main_query')) {
    function figma_custom_theme_modify_main_query($query) {
        if (!is_admin() && $query->is_main_query()) {
            // Show properties on front page
            if (is_home()) {
                $query->set('post_type', array('post', 'property'));
                $query->set('posts_per_page', 6);
            }
            
            // Properties archive pagination
            if (is_post_type_archive('property')) {
                $query->set('posts_per_page', 9);
                $query->set('orderby', 'date');
                $query->set('order', 'DESC');
            }
        }
    }
}
add_action('pre_get_posts', 'figma_custom_theme_modify_main_query');

/**
 * Add custom body classes for different post types
 */
if (!function_exists('figma_custom_theme_custom_body_classes')) {
    function figma_custom_theme_custom_body_classes($classes) {
        global $post;
        
        if (is_singular()) {
            $classes[] = 'single-' . $post->post_type;
        }
        
        if (is_post_type_archive()) {
            $classes[] = 'archive-' . get_query_var('post_type');
        }
        
        
        return $classes;
    }
}
add_filter('body_class', 'figma_custom_theme_custom_body_classes');

/* ========================================
   ADMIN INTERFACE ENHANCEMENTS
======================================== */

/**
 * Add admin styles and enhancements
 */
if (!function_exists('figma_custom_theme_admin_styles')) {
    function figma_custom_theme_admin_styles() {
        wp_add_inline_style('wp-admin', '
            /* Custom Post Type Icons */
            #menu-posts-property .wp-menu-image:before { content: "\f102"; }
            #menu-posts-team_member .wp-menu-image:before { content: "\f307"; }
            #menu-posts-service .wp-menu-image:before { content: "\f111"; }
            #menu-posts-testimonial .wp-menu-image:before { content: "\f122"; }
            
            /* Admin Bar Styling */
            .figma-admin-notice {
                background: linear-gradient(135deg, #703BF7 0%, #A685FA 100%);
                border-left: 4px solid #703BF7;
                color: white;
                padding: 12px;
                margin: 5px 15px 2px;
                border-radius: 8px;
            }
            
            /* Property Meta Box Styling */
            .acf-field-group .acf-field {
                background: #f9f9f9;
                border-radius: 8px;
                margin-bottom: 15px;
                padding: 15px;
            }
            
            /* Custom Dashboard Widget */
            .figma-dashboard-widget {
                background: linear-gradient(135deg, #703BF7 0%, #A685FA 100%);
                color: white;
                border-radius: 12px;
                padding: 20px;
                margin-bottom: 20px;
            }
            
            .figma-dashboard-widget h3 {
                color: white !important;
                margin-bottom: 15px;
            }
            
            .figma-quick-stats {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                gap: 15px;
                margin-top: 15px;
            }
            
            .figma-stat-item {
                text-align: center;
                background: rgba(255, 255, 255, 0.1);
                padding: 15px;
                border-radius: 8px;
            }
            
            .figma-stat-number {
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 5px;
            }
            
            .figma-stat-label {
                font-size: 12px;
                opacity: 0.9;
            }
        ');
    }
}
add_action('admin_enqueue_scripts', 'figma_custom_theme_admin_styles');

/**
 * Enqueue admin scripts for property thumbnail checkboxes and features
 */
if (!function_exists('figma_custom_theme_admin_scripts')) {
    function figma_custom_theme_admin_scripts($hook) {
        // Only load on post edit screens for property post type
        global $post_type;
        if ($post_type === 'property' && ($hook === 'post.php' || $hook === 'post-new.php')) {
            wp_enqueue_script(
                'figma-property-thumbnails',
                get_template_directory_uri() . '/assets/js/admin-property-thumbnails.js',
                array('jquery', 'acf-input'),
                wp_get_theme()->get('Version'),
                true
            );
            wp_enqueue_script(
                'figma-property-features',
                get_template_directory_uri() . '/assets/js/admin-property-features.js',
                array('jquery', 'acf-input'),
                wp_get_theme()->get('Version'),
                true
            );
            wp_enqueue_script(
                'figma-property-images',
                get_template_directory_uri() . '/assets/js/admin-property-images.js',
                array('jquery', 'acf-input'),
                wp_get_theme()->get('Version'),
                true
            );
        }
    }
}
add_action('admin_enqueue_scripts', 'figma_custom_theme_admin_scripts');

/**
 * Process Properties Contact Form Submission
 */
if (!function_exists('figma_custom_theme_process_contact_form')) {
    function figma_custom_theme_process_contact_form() {
        $referer_url = wp_get_referer();
        $redirect_base = $referer_url ? $referer_url : home_url('/');

        $redirect_with_status = static function ($status) use ($redirect_base) {
            wp_safe_redirect(add_query_arg('form_submitted', $status, $redirect_base));
            exit;
        };

        // Check if form was submitted
        if (
            !isset($_POST['properties_contact_nonce']) ||
            !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['properties_contact_nonce'])), 'properties_contact_form')
        ) {
            $redirect_with_status('error');
        }

        // Sanitize and validate form data
        $first_name = isset($_POST['first_name']) ? sanitize_text_field(wp_unslash($_POST['first_name'])) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field(wp_unslash($_POST['last_name'])) : '';
        $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
        $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
        $preferred_location = isset($_POST['preferred_location']) ? sanitize_title(wp_unslash($_POST['preferred_location'])) : '';
        $property_type = isset($_POST['property_type_select']) ? sanitize_title(wp_unslash($_POST['property_type_select'])) : '';
        $bathrooms = isset($_POST['bathrooms']) ? sanitize_text_field(wp_unslash($_POST['bathrooms'])) : '';
        $bedrooms = isset($_POST['bedrooms']) ? sanitize_text_field(wp_unslash($_POST['bedrooms'])) : '';
        $budget = isset($_POST['budget']) ? sanitize_text_field(wp_unslash($_POST['budget'])) : '';
        $contact_method = isset($_POST['contact_method']) ? sanitize_key(wp_unslash($_POST['contact_method'])) : 'phone';
        $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';
        $selected_property = isset($_POST['selected_property']) ? sanitize_text_field(wp_unslash($_POST['selected_property'])) : '';
        $terms = isset($_POST['terms']) ? true : false;

        $allowed_contact_methods = array('phone', 'email');
        $allowed_bathroom_values = array('', '1', '2', '3', '4');
        $allowed_bedroom_values = array('', '1', '2', '3', '4');
        $allowed_budget_ranges = array('', '0-250000', '250000-500000', '500000-1000000', '1000000+');

        if (!in_array($contact_method, $allowed_contact_methods, true)) {
            $contact_method = 'phone';
        }

        if (!in_array($bathrooms, $allowed_bathroom_values, true)) {
            $bathrooms = '';
        }

        if (!in_array($bedrooms, $allowed_bedroom_values, true)) {
            $bedrooms = '';
        }

        if (!in_array($budget, $allowed_budget_ranges, true)) {
            $budget = '';
        }

        if ($preferred_location && !term_exists($preferred_location, 'property_location')) {
            $preferred_location = '';
        }

        if ($property_type && !term_exists($property_type, 'property_type')) {
            $property_type = '';
        }

        // Validate required fields
        if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || !$terms) {
            $redirect_with_status('error');
        }

        // Validate email
        if (!is_email($email)) {
            $redirect_with_status('error');
        }

        // Create submission post
        $submission_data = array(
            'post_title'    => wp_strip_all_tags($first_name . ' ' . $last_name . ' - ' . current_time('mysql')),
            'post_content'  => $message,
            'post_status'   => 'private',
            'post_type'     => 'contact_submission',
        );

        $submission_id = wp_insert_post($submission_data);

        if (is_wp_error($submission_id)) {
            $redirect_with_status('error');
        }

        // Save form data as post meta
        update_post_meta($submission_id, '_contact_first_name', $first_name);
        update_post_meta($submission_id, '_contact_last_name', $last_name);
        update_post_meta($submission_id, '_contact_email', $email);
        update_post_meta($submission_id, '_contact_phone', $phone);
        update_post_meta($submission_id, '_contact_preferred_location', $preferred_location);
        update_post_meta($submission_id, '_contact_property_type', $property_type);
        update_post_meta($submission_id, '_contact_bathrooms', $bathrooms);
        update_post_meta($submission_id, '_contact_bedrooms', $bedrooms);
        update_post_meta($submission_id, '_contact_budget', $budget);
        update_post_meta($submission_id, '_contact_method', $contact_method);
        update_post_meta($submission_id, '_contact_selected_property', $selected_property);
        update_post_meta($submission_id, '_contact_submission_date', current_time('mysql'));

        // Send email notification to admin
        $admin_email = get_option('admin_email');
        $subject = sprintf(__('New Contact Form Submission from %s %s', 'figma-custom-theme'), $first_name, $last_name);
        
        $email_message = sprintf(__('You have received a new contact form submission:\n\n', 'figma-custom-theme'));
        $email_message .= sprintf(__('Name: %s %s\n', 'figma-custom-theme'), $first_name, $last_name);
        $email_message .= sprintf(__('Email: %s\n', 'figma-custom-theme'), $email);
        $email_message .= sprintf(__('Phone: %s\n', 'figma-custom-theme'), $phone);
        
        if ($preferred_location) {
            $location_term = get_term_by('slug', $preferred_location, 'property_location');
            $email_message .= sprintf(__('Preferred Location: %s\n', 'figma-custom-theme'), $location_term ? $location_term->name : $preferred_location);
        }
        
        if ($property_type) {
            $type_term = get_term_by('slug', $property_type, 'property_type');
            $email_message .= sprintf(__('Property Type: %s\n', 'figma-custom-theme'), $type_term ? $type_term->name : $property_type);
        }
        
        $email_message .= sprintf(__('Bedrooms: %s\n', 'figma-custom-theme'), $bedrooms ?: 'N/A');
        $email_message .= sprintf(__('Bathrooms: %s\n', 'figma-custom-theme'), $bathrooms ?: 'N/A');
        $email_message .= sprintf(__('Budget: %s\n', 'figma-custom-theme'), $budget ?: 'N/A');
        if ($selected_property) {
            $email_message .= sprintf(__('Selected Property: %s\n', 'figma-custom-theme'), $selected_property);
        }
        $email_message .= sprintf(__('Preferred Contact Method: %s\n', 'figma-custom-theme'), $contact_method);
        $email_message .= sprintf(__('Message: %s\n\n', 'figma-custom-theme'), $message);
        $email_message .= sprintf(__('View submission in admin: %s', 'figma-custom-theme'), admin_url('post.php?post=' . $submission_id . '&action=edit'));

        wp_mail($admin_email, $subject, $email_message);

        // Redirect with success message
        $redirect_with_status('success');
    }
}
add_action('admin_post_nopriv_properties_contact_form', 'figma_custom_theme_process_contact_form');
add_action('admin_post_properties_contact_form', 'figma_custom_theme_process_contact_form');

/**
 * Add custom columns to Contact Submissions admin list
 */
if (!function_exists('figma_custom_theme_contact_submission_columns')) {
    function figma_custom_theme_contact_submission_columns($columns) {
        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['title'] = __('Name', 'figma-custom-theme');
        $new_columns['email'] = __('Email', 'figma-custom-theme');
        $new_columns['phone'] = __('Phone', 'figma-custom-theme');
        $new_columns['property_type'] = __('Property Type', 'figma-custom-theme');
        $new_columns['date'] = __('Date', 'figma-custom-theme');
        return $new_columns;
    }
}
add_filter('manage_contact_submission_posts_columns', 'figma_custom_theme_contact_submission_columns');

/**
 * Populate custom columns in Contact Submissions admin list
 */
if (!function_exists('figma_custom_theme_contact_submission_column_content')) {
    function figma_custom_theme_contact_submission_column_content($column, $post_id) {
        switch ($column) {
            case 'email':
                $email = get_post_meta($post_id, '_contact_email', true);
                echo $email ? '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>' : '—';
                break;
            case 'phone':
                $phone = get_post_meta($post_id, '_contact_phone', true);
                echo $phone ? '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>' : '—';
                break;
            case 'property_type':
                $property_type = get_post_meta($post_id, '_contact_property_type', true);
                if ($property_type) {
                    $term = get_term_by('slug', $property_type, 'property_type');
                    echo $term ? esc_html($term->name) : esc_html($property_type);
                } else {
                    echo '—';
                }
                break;
        }
    }
}
add_action('manage_contact_submission_posts_custom_column', 'figma_custom_theme_contact_submission_column_content', 10, 2);

/**
 * Add meta box to display submission details
 */
if (!function_exists('figma_custom_theme_add_submission_meta_box')) {
    function figma_custom_theme_add_submission_meta_box() {
        add_meta_box(
            'contact_submission_details',
            __('Submission Details', 'figma-custom-theme'),
            'figma_custom_theme_submission_meta_box_callback',
            'contact_submission',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'figma_custom_theme_add_submission_meta_box');

/**
 * Meta box callback to display submission details
 */
if (!function_exists('figma_custom_theme_submission_meta_box_callback')) {
    function figma_custom_theme_submission_meta_box_callback($post) {
        $first_name = get_post_meta($post->ID, '_contact_first_name', true);
        $last_name = get_post_meta($post->ID, '_contact_last_name', true);
        $email = get_post_meta($post->ID, '_contact_email', true);
        $phone = get_post_meta($post->ID, '_contact_phone', true);
        $preferred_location = get_post_meta($post->ID, '_contact_preferred_location', true);
        $property_type = get_post_meta($post->ID, '_contact_property_type', true);
        $bathrooms = get_post_meta($post->ID, '_contact_bathrooms', true);
        $bedrooms = get_post_meta($post->ID, '_contact_bedrooms', true);
        $budget = get_post_meta($post->ID, '_contact_budget', true);
        $contact_method = get_post_meta($post->ID, '_contact_method', true);
        $submission_date = get_post_meta($post->ID, '_contact_submission_date', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label><?php echo esc_html__('First Name', 'figma-custom-theme'); ?></label></th>
                <td><strong><?php echo esc_html($first_name); ?></strong></td>
            </tr>
            <tr>
                <th><label><?php echo esc_html__('Last Name', 'figma-custom-theme'); ?></label></th>
                <td><strong><?php echo esc_html($last_name); ?></strong></td>
            </tr>
            <tr>
                <th><label><?php echo esc_html__('Email', 'figma-custom-theme'); ?></label></th>
                <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
            </tr>
            <tr>
                <th><label><?php echo esc_html__('Phone', 'figma-custom-theme'); ?></label></th>
                <td><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></td>
            </tr>
            <tr>
                <th><label><?php echo esc_html__('Preferred Location', 'figma-custom-theme'); ?></label></th>
                <td><?php 
                    if ($preferred_location) {
                        $location_term = get_term_by('slug', $preferred_location, 'property_location');
                        echo $location_term ? esc_html($location_term->name) : esc_html($preferred_location);
                    } else {
                        echo '—';
                    }
                ?></td>
            </tr>
            <tr>
                <th><label><?php echo esc_html__('Property Type', 'figma-custom-theme'); ?></label></th>
                <td><?php 
                    if ($property_type) {
                        $type_term = get_term_by('slug', $property_type, 'property_type');
                        echo $type_term ? esc_html($type_term->name) : esc_html($property_type);
                    } else {
                        echo '—';
                    }
                ?></td>
            </tr>
            <tr>
                <th><label><?php echo esc_html__('Bedrooms', 'figma-custom-theme'); ?></label></th>
                <td><?php echo $bedrooms ? esc_html($bedrooms) : '—'; ?></td>
            </tr>
            <tr>
                <th><label><?php echo esc_html__('Bathrooms', 'figma-custom-theme'); ?></label></th>
                <td><?php echo $bathrooms ? esc_html($bathrooms) : '—'; ?></td>
            </tr>
            <tr>
                <th><label><?php echo esc_html__('Budget', 'figma-custom-theme'); ?></label></th>
                <td><?php echo $budget ? esc_html($budget) : '—'; ?></td>
            </tr>
            <tr>
                <th><label><?php echo esc_html__('Preferred Contact Method', 'figma-custom-theme'); ?></label></th>
                <td><?php echo esc_html(ucfirst($contact_method)); ?></td>
            </tr>
            <tr>
                <th><label><?php echo esc_html__('Submission Date', 'figma-custom-theme'); ?></label></th>
                <td><?php echo $submission_date ? esc_html($submission_date) : get_the_date('Y-m-d H:i:s', $post->ID); ?></td>
            </tr>
        </table>
        <?php
    }
}

/**
 * Add custom admin dashboard widget
 */
if (!function_exists('figma_custom_theme_dashboard_widget')) {
    function figma_custom_theme_dashboard_widget() {
        wp_add_dashboard_widget(
            'figma_theme_stats',
            'Real Estate Dashboard',
            'figma_custom_theme_dashboard_widget_content'
        );
    }
}
add_action('wp_dashboard_setup', 'figma_custom_theme_dashboard_widget');

/**
 * Dashboard widget content
 */
if (!function_exists('figma_custom_theme_dashboard_widget_content')) {
    function figma_custom_theme_dashboard_widget_content() {
        $properties_count = wp_count_posts('property')->publish;
        $team_count = wp_count_posts('team_member')->publish;
        $services_count = wp_count_posts('service')->publish;
        $testimonials_count = wp_count_posts('testimonial')->publish;
        $submissions_count = wp_count_posts('contact_submission')->publish;
        
        echo '<div class="figma-dashboard-widget">';
        echo '<h3>Your Real Estate Business Overview</h3>';
        echo '<div class="figma-quick-stats">';
        echo '<div class="figma-stat-item"><div class="figma-stat-number">' . esc_html($properties_count) . '</div><div class="figma-stat-label">Properties</div></div>';
        echo '<div class="figma-stat-item"><div class="figma-stat-number">' . esc_html($team_count) . '</div><div class="figma-stat-label">Team Members</div></div>';
        echo '<div class="figma-stat-item"><div class="figma-stat-number">' . esc_html($services_count) . '</div><div class="figma-stat-label">Services</div></div>';
        echo '<div class="figma-stat-item"><div class="figma-stat-number">' . esc_html($testimonials_count) . '</div><div class="figma-stat-label">Testimonials</div></div>';
        echo '<div class="figma-stat-item"><div class="figma-stat-number">' . esc_html($submissions_count) . '</div><div class="figma-stat-label">Contact Submissions</div></div>';
        echo '</div>';
        echo '<p style="margin-top: 15px; opacity: 0.9;">Manage your real estate content easily with custom post types and ACF fields.</p>';
        if ($submissions_count > 0) {
            echo '<p style="margin-top: 10px;"><a href="' . esc_url(admin_url('edit.php?post_type=contact_submission')) . '" class="button button-primary">View Contact Submissions</a></p>';
        }
        echo '</div>';
    }
}

/**
 * Add helpful admin notices
 */
if (!function_exists('figma_custom_theme_admin_notices')) {
    function figma_custom_theme_admin_notices() {
        $screen = get_current_screen();
        
        // Show notice on theme-related pages
        if (in_array($screen->id, array('themes', 'customize', 'edit-property', 'edit-team_member', 'edit-service', 'edit-testimonial', 'edit-contact_submission'))) {
            echo '<div class="notice figma-admin-notice">';
            echo '<p><strong>Figma Custom Theme:</strong> Your real estate website is powered by custom post types and ACF fields for easy content management.</p>';
            echo '</div>';
        }
    }
}
add_action('admin_notices', 'figma_custom_theme_admin_notices');

/**
 * Add custom columns to property admin list
 */
if (!function_exists('figma_custom_theme_property_columns')) {
    function figma_custom_theme_property_columns($columns) {
        $new_columns = array();
        foreach ($columns as $key => $value) {
            $new_columns[$key] = $value;
            if ($key === 'title') {
                $new_columns['property_location'] = 'Location';
                $new_columns['property_price'] = 'Price';
                $new_columns['property_bedrooms'] = 'Bedrooms';
            }
        }
        return $new_columns;
    }
}
add_filter('manage_property_posts_columns', 'figma_custom_theme_property_columns');

/**
 * Fill custom columns with data
 */
if (!function_exists('figma_custom_theme_property_column_data')) {
    function figma_custom_theme_property_column_data($column, $post_id) {
        switch ($column) {
            case 'property_location':
                $location = get_field('property_location', $post_id);
                echo $location ? esc_html($location) : '—';
                break;
            case 'property_price':
                $price = get_field('property_price', $post_id);
                echo $price ? esc_html($price) : '—';
                break;
            case 'property_bedrooms':
                $bedrooms = get_field('property_bedrooms', $post_id);
                echo $bedrooms ? esc_html($bedrooms) : '—';
                break;
        }
    }
}
add_action('manage_property_posts_custom_column', 'figma_custom_theme_property_column_data', 10, 2);

