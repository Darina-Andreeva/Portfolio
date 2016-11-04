<?php

function content_short($content, $size, $endLimited = '...', $ended = '') {
    $content = strip_tags($content);
    $short = mb_substr($content, 0, $size, 'UTF-8');
    $last_space = mb_strrpos($short, ' ', 0, 'UTF-8');
    if ($size >= mb_strlen($content)) {
        return $content . $ended;
    } else {
        return mb_substr($content, 0, $last_space, 'UTF-8') . $endLimited;
    }
}

function nb_get_page($slug) {
    return get_page_by_path($slug);
}

function nb_posts_by(
$type = "post", $limit = -1, $order = "asc", $order_by = "menu_order", $child = 0, $category = null, $categoryName = null, $taxonomy = null, $meta_query = null, $exclude = null, $slug = null, $offset = null) {
    $args = array(
        'posts_per_page' => $limit,
        'orderby' => $order_by,
        'order' => $order,
        'post_type' => $type,
        'post_status' => 'publish',
    );
    if ($offset) {
        $args['offset'] = $offset;
    }
    if ($category != null)
        $args['category'] = $category;
    if ($categoryName != null)
        $args['category_name'] = $categoryName;
    if ($taxonomy != null)
        $args['tax_query'] = $taxonomy;
    if ($meta_query != null) {
        $args['meta_query'] = $meta_query;
    }
    if ($exclude != null)
        $args['exclude'] = $exclude;
    if ($slug != null)
        $args['name'] = $slug;
    return get_posts($args);
}

function nb_content($folder, $file) {
    return get_template_directory_uri() . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $file;
}

function get_picture($picture = null, $settings = []) {

    if ($picture == null && $defaults[$settings['default']]) {
        $picture = $defaults[$settings['default']];
    }
    if ($picture != null) {
        $pictureUrl = $picture[$settings['url']];
        if ($settings['url'] == null) {
            $pictureUrl = $picture;
        }
        if ($settings['type'] == null) {
            $settings['type'] = 'img';
        }
        if ($settings['type'] == 'img') {
            if ($settings['class'] != null)
                $class = 'class="' . $settings['class'] . '"';
            return '<img src="' . $pictureUrl . '" ' . $class . ' />';
        }
        else if ($settings['type'] == 'background') {
            return "background: url('" . $pictureUrl . "');";
        }
    }
}

function get_404_content() {
    return (object) [
                'title' => get_field('404-title', nb_get_page('page-404')->ID),
                'description' => get_field('404-description', nb_get_page('page-404')->ID),
    ];
}

function is_header_sticky() {
    return get_field('header_sticky', 'option');
}

function get_language_switcher() {
    if (get_language_option() == 'replace')
        get_template_part('_language_switcher_replace');
    elseif (get_language_option() == 'dropdown')
        get_template_part('_language_switcher_dropdown');
    elseif (get_language_option() == 'custom')
        get_template_part('_language_switcher_dropdown_custom');
}

function get_language_option() {
    return get_field('language_switcher', 'option');
}

function nb_custom_pagination($numpages = '', $pagerange = '', $paged = '') {
    global $post;
    if (empty($pagerange)) {
        $pagerange = 2;
    }
    if (empty($paged)) {
        $paged = 1;
    }
    if ($numpages == '') {
        global $wp_query;
        $numpages = $wp_query->max_num_pages;
        if (!$numpages) {
            $numpages = 1;
        }
    }
    $pagination_args = array(
        'base' => get_permalink($post->ID) . '%_%',
        'format' => '?pagein=%#%',
        'total' => $numpages,
        'current' => get_pagination_page_current(),
        'show_all' => False,
        'end_size' => 1,
        'mid_size' => $pagerange,
        'prev_next' => True,
        'prev_text' => '<',
        'next_text' => '>',
        'type' => 'plain',
        'add_args' => false,
        'add_fragment' => ''
    );
    $paginate_links = paginate_links($pagination_args);

    if ($paginate_links) {
        return $paginate_links;
    }
}

function nb_pagination_next_link($label = "next") {

    if ($GLOBALS['search']['query']->max_num_pages > get_pagination_page_current()) {
        global $post;
        return '<a href="' . nb_pagination_link() . '">' . $label . '</a>';
    }
}

function nb_pagination_link($type = 'plus') {
    global $post;
    if ($type == 'plus') {
        $pageNumber = get_pagination_page_current() + 1;
    } else {
        $pageNumber = get_pagination_page_current() - 1;
    }
    $paged = '?pagein=' . $pageNumber;
    return get_permalink($post->ID) . $paged . urlService();
}

function nb_pagination_prev_link($label = "prev") {

    if (get_pagination_page_current() > 1) {
        global $post;
        $paged = '?pagein=' . (get_pagination_page_current() - 1);
        return '<a href="' . nb_pagination_link('minus') . '">' . $label . '</a>';
    }
}

function urlService() {
    return !empty($_GET['service']) ? '&service=' . $_GET['service'] : '';
}
