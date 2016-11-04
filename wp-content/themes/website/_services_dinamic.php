<?php $terms = nb_get_terms_by("services"); ?>

<?php get_template_part("_services_list"); ?>
<div class="services">
    <?php if (!get_service_redirect()) { ?>
        <div class="service-single active">
            <p><?php echo get_the_terms_description(); ?></p>
        </div>
    <?php } ?>
    <?php foreach ($terms as $place => $term) { ?>
        <div class="service-single service-<?php
        echo $term->term_id;
        if (get_service_redirect() && $place == 0)
            echo ' active';
        ?>">
            <div class="service-single-box">
                <h1><?php echo $term->name; ?></h1>
                <p><?php echo apply_filters('the_content', $term->description); ?></p>
            </div>
            <div class="related-box">
                <?php get_service_related_projects($term); ?>
            </div>
        </div>
    <?php } ?>
</div>


