<?php

add_action('after_switch_theme', 'estatein_theme_create_menu');
function estatein_theme_create_menu() {

    $menu_name = 'Primary Menu';

    $menu = wp_get_nav_menu_object($menu_name);
    $menu_id = $menu ? $menu->term_id : wp_create_nav_menu($menu_name);

    $menu_items = [
        'Home'       => '',
        'About Us'   => 'about',
        'Services'   => 'services',
        'Properties' => 'properties',
    ];

    foreach ($menu_items as $title => $slug) {

        if ($slug === '') {
            $page = get_page_by_title('Home');
        } else {
            $page = get_page_by_path($slug);
        }

        if ($page) {
            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title'     => $title,
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $page->ID,
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
            ]);
        }
    }

    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}