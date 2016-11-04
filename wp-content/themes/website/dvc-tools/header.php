<?php

define('THEME_CONTENT_TYPE_CSS', 'css');
define('THEME_CONTENT_TYPE_JS', 'js');

define('THEME_URL', get_template_directory_uri());
define('THEME_CSS_URL', THEME_URL . DIRECTORY_SEPARATOR . THEME_CONTENT_TYPE_CSS . DIRECTORY_SEPARATOR);
define('THEME_JS_URL', THEME_URL . DIRECTORY_SEPARATOR . THEME_CONTENT_TYPE_JS . DIRECTORY_SEPARATOR);
define('THEME_DIR', get_template_directory());
define('THEME_CSS_DIR', THEME_DIR . DIRECTORY_SEPARATOR . THEME_CONTENT_TYPE_CSS . DIRECTORY_SEPARATOR);
define('THEME_JS_DIR', THEME_DIR . DIRECTORY_SEPARATOR . THEME_CONTENT_TYPE_JS . DIRECTORY_SEPARATOR);
define('THEME_STYLECSS', 'style.css');
define('THEME_JQUERY_VERSION', '2.1.3');

function title() {
    
}

function remove_from_array($array = array(), $elements = array()) {
    return array_diff($array, $elements);
}

function get_file_extention($dir, $file) {
    return pathinfo($dir . DIRECTORY_SEPARATOR . $file, PATHINFO_EXTENSION);
}

function getFilesByFormat($dir, $extention) {
    foreach (scandir($dir) as $file) {
        if (get_file_extention($dir, $file) == $extention) {
            $files[] = $file;
        }
    }
    return $files;
}

function getFiles($dir, $extention) {
    return remove_from_array(getFilesByFormat($dir, $extention), array('.', '..'));
}

function updateFilesUrl($files, $url) {
    foreach ($files as $place => $file) {
        $includes[] = $url . $file;
    }
    return $includes;
}

function getFilesCSS() {
    return add_style_css(updateFilesUrl(getFiles(THEME_CSS_DIR, THEME_CONTENT_TYPE_CSS), THEME_CSS_URL));
}

function add_style_css($list) {
    $list[] = get_template_directory_uri() . DIRECTORY_SEPARATOR . THEME_STYLECSS;
    return $list;
}

function getFilesJS() {
    return updateFilesUrl(getFiles(THEME_JS_DIR, THEME_CONTENT_TYPE_JS), THEME_JS_URL);
}

function header_html_content($url, $type) {
    if (THEME_CONTENT_TYPE_CSS == $type) {
        return header_html_content_css($url);
    } elseif (THEME_CONTENT_TYPE_JS == $type) {
        return header_html_content_js($url);
    }
}

function header_html_content_css($url) {
    return '<link rel="stylesheet" href="' . $url . '">';
}

function header_html_content_js($url) {
    return '<script type="text/javascript" src="' . $url . '"></script>';
}

function nb_header_includes() {
    foreach (getFilesCSS() as $file) {
        echo header_html_content($file, THEME_CONTENT_TYPE_CSS);
    }
    echo '<script type="text/javascript">
            var $ = jQuery;
        </script>';
    echo header_html_content_js('https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js');

    foreach (getFilesJS() as $file) {
        echo header_html_content($file, THEME_CONTENT_TYPE_JS);
    }
    echo nb_header_analytics();
}

function nb_header_analytics() {
    return get_field('header_analytics', 'option');
}

function hasPagePicture() {
    global $post;
    if (is_search()) {
        return false;
    } else if (is_404())
        return get_field('has_picture', nb_get_page('page-404')->ID);
    else
        return get_field('has_picture', $post->ID);
}

function get_header_picture() {
    global $post;
    if (is_404()) {
        $image = get_field('header_picture', nb_get_page('page-404')->ID);
    } else
        $image = get_field('header_picture', $post->ID);
    return get_picture($image, [
        'type' => 'background',
        'default' => 'default',
        'url' => 'url',
        'class' => 'header-picture',
    ]);
}

function get_header_title() {
    global $post;
    if (is_404())
        return false;
    else
        return $post->post_title;
}
