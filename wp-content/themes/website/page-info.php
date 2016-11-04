<?php
/**
 * Template Name: About Info
 */
get_header();
?>
<?php get_template_part("_about_list_subpages"); ?>
<h1><?php echo $post->post_title; ?></h1>
<div class="about-description">
    <p><?php echo apply_filters("the_content", $post->post_content); ?></p>
</div>
<?php
get_footer();

