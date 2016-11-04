<?php

//including develoca tools files
include(get_template_directory() . "/dvc-tools/main.php");

function get_clients() {
    return get_field("clients");
}

function get_about_type() {
    return get_field("type");
}

function get_about_redirect() {
    return get_field("redirect");
}

function get_about_discription() {
    return get_field("description");
}

function get_about_content() {
    return get_field("content");
}

function about_subpages() {
    global $post;
    if ($post->post_parent)
        $id = $post->post_parent;
    else
        $id = $post->ID;


    return get_pages(array(
        'child_of' => $id,
        'post_type' => 'page',
        'post_status' => 'publish',
    ));
}

function get_contacts() {
    return get_field("contacts");
}

function get_categories_field() {
    return get_field("show_categories", $GLOBALS['search']['page']->ID);
}

function get_dinamic_categories() {
    return get_field("dinamic_url", $GLOBALS['search']['page']->ID);
}

function get_news_categories() {
    return nb_get_terms_by("category");
}

function get_news() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => get_pagination_posts_per_page(),
        'paged' => get_pagination_page_current(),
        'post_status' => 'publish',
        'order' => 'desc',
        'orderby' => 'post_date',
    );
    if (get_query_var('cat'))
        $args['cat'] = get_query_var('cat');
    return new WP_Query($args);
}

function get_picture_news($post) {
    return get_field("picture", $post->ID);
}

function get_page_services() {
    return nb_get_page('services');
}

function get_service_redirect() {
    return get_field("redirect", get_page_services()->ID);
}

function get_the_terms_description() {
    return get_field("description", get_page_services()->ID);
}

function get_the_all_taxonomy() {
    return get_field("services");
}

function get_service() {
    return get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
}

function nb_get_terms_by($name) {
    global $post;
    if (is_single() && $post->post_type == 'projects') {
        return getProjectTerms();
    } else
        return get_terms(array(
            'taxonomy' => $name,
            'exclude' => 1,
            'hide_empty' => FALSE,
        ));
}

function get_pagination_page_current() {
    return $_GET['pagein'] ? $_GET['pagein'] : 1;
}

function get_pagination_posts_per_page() {
    return (int) get_field('pagination_per_page', $GLOBALS['search']['page']->ID);
}

function get_pagination_page_range() {
    return (int) get_field('pagination_page_range', $GLOBALS['search']['page']->ID);
}

function get_projects() {

    $tax = [
        'relation' => 'AND',
        [
            'taxonomy' => 'services',
            'field' => 'slug',
            'terms' => $_GET['service'],
        ]
    ];
    $args = array(
        'post_type' => 'products',
        'posts_per_page' => get_pagination_posts_per_page(),
        'paged' => get_pagination_page_current(),
        'post_status' => 'publish',
        'order' => 'desc',
        'orderby' => 'menu_order',
    );
    if (!empty($_GET['service']))
        $args['tax_query'] = $tax;
    return new WP_Query($args);
}

function get_service_has_projects() {
    return get_field('related_products', 'services_' . get_related_term()->term_id);
}

function get_service_projects_type() {
    return get_field('related_products_type', 'services_' . get_related_term()->term_id);
}

function get_service_projects_limit() {
    $limit = get_field('related_products_limit', 'services_' . get_related_term()->term_id);
    return $limit ? $limit : 5;
}

function get_service_projects_items() {
    $projects = get_field('related_products_items', 'services_' . get_related_term()->term_id);
    foreach ($projects as $project) {
        $items[] = $project['product'];
    }
    return $items;
}

function get_project_similars() {
    global $post;
    $type = get_service_projects_type();
    if ($type == false || $type == 'service') {
        $service = get_service();
        if ($service) {
            $tax_slug = $service->slug;
        } else {
            $taxonomy = getProjectTerms();
            $tax_slug = $taxonomy[0]->slug;
        }
        $tax = [
            [
                'taxonomy' => 'services',
                'field' => 'slug',
                'terms' => $tax_slug,
            ],
        ];
        return nb_posts_by("projects", get_service_projects_limit(), "desc", "menu_order", 0, null, null, $tax, null, $post->ID);
    } else if ($type == 'choose') {
        return get_service_projects_items();
    }
}

function getProjectTerms($postin = null) {
    global $post;
    if ($postin == null)
        $postin = $post;
    return get_the_terms($postin, 'services');
}

function get_slider_url($slide) {
    $link2 = '';
    if ($slide["link2"]) {
        $link2 = "?position=" . $slide["link2"];
    }
    return $slide['link'] . $link2;
}

function get_first_subpage() {
    global $post;
    $subpages = get_children([
        'post_parent' => $post->ID,
        'post_type' => 'page',
        'post_status' => 'publish',
    ]);
    return reset($subpages);
}

function get_about_page() {
    return nb_get_page('aboutus');
}

function abount_in_menu() {
    return get_field('in_menu', get_about_page()->ID);
}

function get_social() {
    get_template_part('_social');
}

function get_social_links() {
    return get_field('social', 'option');
}

function contacts_single($contacts) {
    return count($contacts) == 1 ? (object) $contacts[0] : false;
}

function is_services_dinamic() {
    return get_field('dinamic_url', get_page_services()->ID);
}

function get_services_has_related_projects() {
    return get_field('related_products', get_page_services()->ID);
}

function get_service_related_projects($term) {
    $GLOBALS['related'] = $term;
    if (get_services_has_related_projects() && get_service_has_projects())
        get_template_part('_projects_related');
}

function get_related_term() {
    return (object) $GLOBALS['related'];
}

function get_page_projects() {
    return nb_get_page('projects');
}

function get_project_services_list() {
    if (get_projects_has_services_list())
        get_template_part("_projects_services_list");
}

function get_projects_has_services_list() {
    return get_field('show_services', $GLOBALS['search']['page']->ID);
}

function get_projects_type() {
    return get_field('type', $GLOBALS['search']['page']->ID);
}

function nb_search_query($items) {
    $GLOBALS['search']['query'] = $items;
    $GLOBALS['search']['paged'] = get_pagination_page_current();
}

function nb_search_page($page) {
    $GLOBALS['search']['page'] = nb_get_page($page);
}

function nb_search_pagination() {
    return nb_custom_pagination($GLOBALS['search']['query']->max_num_pages, get_pagination_page_range(), $GLOBALS['search']['paged']);
}

function nb_search_posts() {
    return $GLOBALS['search']['query']->posts;
}

function get_load_more_button_title() {
    return get_field('button_title');
}

function get_load_more_type() {
    return get_field('load_type');
}

function load_more() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_GET['pagein']) && !empty($_GET['page'])) {
        nb_search_page($_GET['page']);
        $items = 'get_' . $_GET['page'];
        nb_search_query($items());
        if ($GLOBALS['search']['query']->found_posts > 0)
            get_template_part('_load_more_content');
        else
            echo 'none';
        exit;
    }
}

add_action('wp', 'load_more', 10, 2);

function header_sticky_classes($class) {
    return is_header_sticky() ? $class : '';
}

function get_type_new() {
    return get_field("type_news", $GLOBALS['search']['page']->ID);
}

function get_news_pagination_page_range() {
    return (int) get_field("pagination_page_range", $GLOBALS['search']['page']->ID);
}

function get_post_button() {
    return get_field("button_title", $GLOBALS['search']['page']->ID);
}

function get_new_posts_by_cat($term_id) {
    return nb_posts_by('post', get_pagination_posts_per_page(), 'desc', 'post_date', 0, $term_id);
}
function mh_load_my_script() {
    wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'mh_load_my_script');

function format_date($format = "d.m.Y", $date) {
    return date($format, strtotime($date));
}

function get_gallery(){
    return get_field('gallery');
}
function get_price($post){
    return get_field('price',$post->ID);
}
function get_about_title(){
    return get_field('title');
}
function get_about_description(){
    return get_field('description');
}
function get_about_team(){
    return get_field('about_team');
}
