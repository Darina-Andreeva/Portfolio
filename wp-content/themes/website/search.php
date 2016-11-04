<?php get_header(); ?>
<div class="search-box-page">
    <?php get_search_form(); ?>
    <span class="hidden-search-btn"></span>
</div>
<div class="container"> 
    <?php
    if (have_posts()) {
        foreach ($wp_query->posts as $resultPost) {
            ?>
            <div class="result-box">
                <h2>
                    <a class="project-name-search" href="<?php echo nb_get_permalink($resultPost->ID); ?>">
                        <?php echo $resultPost->post_title; ?>
                    </a> 
                </h2>
                <div class="content-text">
                    <p><?php echo content_short($resultPost->post_content, 400); ?></p>
                    <div class="clear"></div>
                </div>
            </div>
            <?php
        }
    } else {
        ?> 
        <div class="result-box">
            <h2 class="category-search"><?php echo nb_tm('search-noting-found'); ?>
                <span class="category-search"> :</span></h2>
            <p class="category-search">
                <?php echo nb_tm('search-noting-found-text01'); ?> 
                <b><?php echo get_search_query() ?></b>
                <?php echo nb_tm('search-noting-found-text02'); ?>
            </p>
        </div>
    <?php }
    ?>
    <div class="clear"></div>
</div>
<?php get_footer(); ?>
