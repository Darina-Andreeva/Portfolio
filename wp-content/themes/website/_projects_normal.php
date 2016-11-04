<?php get_project_services_list(); ?>
<?php
$products = nb_search_posts();
?>
<div class="news-box-main">
    <?php
    if ($products)
        foreach ($products as $product) {
            ?>
    <div class="news-box">
            <a  href="<?php echo get_permalink($product->ID); ?>">
                <?php
                echo get_picture(get_field('picture', $product->ID), [
                    'type' => 'img',
                    'default' => 'slider',
                    'url' => 'url'
                ]);
                ?>
                    <h1><?php echo $product->post_title; ?></h1>
                    <p><?php echo content_short($product->post_content, 100); ?></p>
                    <p> <?php echo nb_tm('price'); ?><?php echo get_price($product) ;?></p> 
                    <?php echo nb_tm("see-more"); ?></a>
            </a>
         </div>
    <?php } ?>
</div>


