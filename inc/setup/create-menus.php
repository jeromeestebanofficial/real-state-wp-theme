<?php
add_action('after_switch_theme', 'figma_custom_theme_create_menu_and_flush');
function figma_custom_theme_create_menu_and_flush() {

    $menu_name = 'Primary Menu';

    // Create menu if not exists
    $menu = wp_get_nav_menu_object($menu_name);
    $menu_id = $menu ? $menu->term_id : wp_create_nav_menu($menu_name);

    $menu_items = [
        'Home'       => 'home',     // special case for homepage
        'About Us'   => 'about',
        'Services'   => 'services',
        'Properties' => 'properties',
    ];

    foreach ($menu_items as $title => $slug) {

        // Special case: Home menu links to homepage
        if ($slug === 'home') {
            $url = home_url('/'); // will link to /
            $page_id = 0; // no page object needed
        } else {
            $page = get_page_by_path($slug);
            if (!$page) continue; // skip if page doesn't exist
            $url = get_permalink($page->ID);
            $page_id = $page->ID;
        }

        // Check if this page/url is already in the menu
        $items = wp_get_nav_menu_items($menu_id);
        $exists = false;
        if ($items) {
            foreach ($items as $item) {
                if (($slug === 'home' && $item->url === $url) || ($page_id && $item->object_id == $page_id)) {
                    $exists = true;
                    break;
                }
            }
        }

        // Add menu item only if it doesn't exist
        if (!$exists) {
            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title'      => $title,
                'menu-item-url'        => $slug === 'home' ? $url : '',
                'menu-item-object'     => $page_id ? 'page' : '',
                'menu-item-object-id'  => $page_id,
                'menu-item-type'       => $page_id ? 'post_type' : 'custom',
                'menu-item-status'     => 'publish',
            ]);
        }
    }

    // Assign menu to theme location
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);

    // -----------------------------
    // Force pretty permalinks programmatically
    // -----------------------------
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    flush_rewrite_rules();
}

// -----------------------------
// Redirect /home to /
// -----------------------------
add_action('template_redirect', 'figma_custom_theme_redirect_home_slug');
function figma_custom_theme_redirect_home_slug() {
    $request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
    if (untrailingslashit($request_uri) === '/home') {
        wp_safe_redirect(home_url('/'), 301);
        exit;
    }
}