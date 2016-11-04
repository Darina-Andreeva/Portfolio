<?php

function nb_post_types() {
    $post_types = get_field('post_types', 'option');
    if (is_array($post_types))
        foreach ($post_types as $post_type) {
            register_post_type($post_type['name'], array(
                'labels' => array(
                    'name' => $post_type['label'],
                    'singular_name' => $post_type['single'],
                ),
                'taxonomies' => nb_taxonomies_list($post_type['taxonomies']),
                'public' => $post_type['public'],
                'has_archive' => false,
                'supports' => $post_type['support']
                    )
            );
        }
    $taxonomies = get_field('taxonomies', 'option');
    if (is_array($taxonomies))
        foreach ($taxonomies as $taxonomy) {
            register_taxonomy($taxonomy['name'], $taxonomy['post_type'], array(
                'hierarchical' => $taxonomy['hierarchical'],
                'labels' => array(
                    'name' => _x($taxonomy['label'], 'taxonomy general name'),
                    'singular_name' => _x($taxonomy['label_single'], 'taxonomy singular name'),
                ),
                'rewrite' => array(
                    'slug' => $taxonomy['name'],
                    'with_front' => false,
                    'hierarchical' => $taxonomy['hierarchical'],
                ),
            ));
        }
}

function nb_taxonomies_list($list) {
    foreach ($list as $taxonomy) {
        $taxonomies[] = $taxonomy['name'];
    }
    return $taxonomies;
}

function nb_add_post_types() {
    add_action('init', 'nb_post_types');
}

function nb_menus() {
    $locations = get_field('menu_locations', 'option');
    if ($locations)
        foreach ($locations as $location) {
            register_nav_menu($location['location'], _($location['description']));
        }
}

function nb_menu_locations() {
    add_action('init', 'nb_menus');
}

function nb_admin_css() {
    add_action('admin_head', 'nb_admin_css_content');
}

function nb_admin_css_content() {
    echo '<style type="text/css">';
    include(dirname(__FILE__) . '/../css/admin/style.css');
    echo '</style>';
}

function nb_admin_js() {
    add_action('admin_footer', 'nb_admin_js_content');
}

function nb_admin_js_content() {
    echo '
        <script type="text/javascript">
    var $ = jQuery;
    ';
    include(dirname(__FILE__) . '/../js/admin/main.js');
    echo '</script>';
}

function nb_disable() {
    add_action('admin_init', 'nb_disable_init');
    add_filter('manage_edit-post_columns', 'nb_disable_edit');
}

function nb_disable_init() {
    $post_types = get_post_types();
    $disabled = get_field('disable', 'option');
    foreach ($post_types as $post_type) {
        if (!empty($disabled))
            foreach ($disabled as $disable) {
                remove_post_type_support($post_type, $disable['name']);
            }
    }
}

function nb_disable_edit($columns) {
    $disabled = get_field('disable', 'option');
    if (!empty($disabled))
        foreach ($disabled as $disable) {
            unset($columns[$disable['name']]);
        }
    return $columns;
}

add_filter('upload_mimes', 'upload_file_types');

function upload_file_types($existing_mimes = array()) {
    $existing_mimes['svg'] = 'image/svg-xml';
    return $existing_mimes;
}

function filter_wp_title($title) {
    global $page, $paged;

    if (is_feed())
        return $title;

    $site_description = get_bloginfo('description');

    $filtered_title = $title . get_bloginfo('name');
    $filtered_title .= (!empty($site_description) && ( is_home() || is_front_page() ) ) ? ' | ' . $site_description : '';
    $filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf(__('Page %s'), max($paged, $page)) : '';

    return $filtered_title;
}

add_filter('wp_title', 'filter_wp_title');


