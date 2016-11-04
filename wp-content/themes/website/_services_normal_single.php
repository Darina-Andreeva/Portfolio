<?php $term = get_service(); ?> 

<?php get_template_part("_services_list"); ?>
<h1><?php echo $term->name; ?></h1>
<div class="services">
    <p><?php echo apply_filters('the_content', $term->description); ?></p>
</div>
<h1>Projects</h1>
<?php get_service_related_projects(); ?>