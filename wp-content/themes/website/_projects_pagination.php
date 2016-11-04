<?php get_project_services_list(); ?>
<div class="all-projects-box">
    <?php
    $products = nb_search_posts();
    if ($products)
        foreach ($products as $product) {
            ?>
            <a  class="projects-box" href="<?php echo get_permalink($product->ID); ?>">
                <?php
                echo get_picture(get_field('picture', $product->ID), [
                    'type' => 'img',
                    'default' => 'slider',
                    'url' => 'url'
                ]);
                ?>
                <div class="info-projects">
                    <h1><?php echo $product->post_title; ?></h1>
                    <p><?php echo content_short($product->post_content, 100); ?></p>
                     <p><?php echo get_price($product) ;?></p>
                </div>
            </a>
        <?php } ?>
</div>
<?php
if (get_projects_type() == 'pagination numbers') {
    if (function_exists('nb_search_pagination')) {
        ?>
        <div class="pagination">
            <?php echo nb_search_pagination(); ?>
        </div>
        <?php
    }
} else {
    ?>
<div class="pagination">
    <p class="prev"><?php echo nb_pagination_prev_link('Prev'); ?></p>
    <p class="next"><?php echo nb_pagination_next_link('Next'); ?></p>
</div>
<?php } ?>


