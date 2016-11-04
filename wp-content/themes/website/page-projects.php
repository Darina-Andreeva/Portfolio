<?php

/**
 * Template Name: Products
 */
get_header();
nb_search_page('products');
nb_search_query(get_projects());
if (get_projects_type() == false || get_projects_type() == 'normal')
    get_template_part('_projects_normal');
elseif (get_projects_type() == 'rearrange')
    get_template_part('_projects_rearrange');
elseif (get_projects_type() == 'pagination numbers' || get_projects_type() == 'pagination next prev')
    get_template_part('_projects_pagination');
elseif (get_projects_type() == 'load more')
    get_template_part('_projects_load_more');
get_footer();
