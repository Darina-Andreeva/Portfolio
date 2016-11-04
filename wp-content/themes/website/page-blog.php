<?php
/**
 * Template Name: Blog
 */
get_header();
nb_search_page('news');
nb_search_query(get_news());
if (get_categories_field())
    get_template_part("_news_categories");
if (get_dinamic_categories()) {
    get_template_part("_news_dinamic");
} else if (get_type_new() == "normal") {
    get_template_part("_news_normal");
} elseif (get_type_new() == "pagination numbers" || get_type_new() == "pagination next prev") {
    get_template_part("_news_pagination");
} elseif (get_type_new() == "load more")
    get_template_part("_news_load_more");

get_footer();

