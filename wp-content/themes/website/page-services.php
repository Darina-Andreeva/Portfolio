<?php
/**
 * Template Name: Services
 */
?>
<?php

if (get_service_redirect()) {

    $terms = nb_get_terms_by("services");

    wp_redirect(get_term_link($terms[0]->term_id));
    exit;
} else {
    get_header();
    ?>
    <?php if (is_services_dinamic()) { ?> 
        <?php get_template_part("_services_dinamic"); ?>
    <?php } else { ?>
        <?php get_template_part("_services_normal"); ?>
    <?php } ?>
<?php } ?>
<?php

get_footer();


