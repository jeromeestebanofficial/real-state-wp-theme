<?php


add_action('after_switch_theme', 'estatein_theme_create_pages');
function estatein_theme_create_pages() {

    $pages = [
        ['title' => 'Home',       'slug' => ''],
        ['title' => 'About Us',   'slug' => 'about'],
        ['title' => 'Services',   'slug' => 'services'],
        ['title' => 'Properties', 'slug' => 'properties'],
    ];

    foreach ($pages as $page) {

        if ($page['slug'] === '') {
            // Home page
            if (!get_page_by_title('Home')) {
                wp_insert_post([
                    'post_title'  => 'Home',
                    'post_status' => 'publish',
                    'post_type'   => 'page',
                ]);
            }
        } else {
            if (!get_page_by_path($page['slug'])) {
                wp_insert_post([
                    'post_title'  => $page['title'],
                    'post_name'   => $page['slug'],
                    'post_status' => 'publish',
                    'post_type'   => 'page',
                ]);
            }
        }
    }
}
