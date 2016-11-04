
<h1 class="home-heading"><?php echo nb_get_page_row_data()->data['title']; ?></h1>
<div class="template-<?php echo nb_get_page_row_data()->data["type"]; ?> template-<?php echo nb_get_page_row_data()->place; ?>">
    
    <?php
    foreach (nb_get_post_type_items(nb_get_page_row_data()->data) as $content) {?>
    <div class="post-box">
         <a class='projects-box' href="<?php echo get_permalink($content->ID); ?>">
            
                    <?php
                    echo get_picture(get_picture_news($content), [
                        'type' => 'img',
                        'default' => 'slider',
                        'url' => 'url'
                    ]);
                    ?>
            
        <h1> <?php echo $content->post_title; ?></h1>
        <p><time datetime="<?php echo format_date('d M  Y', $content->post_date); ?>">
                        <?php echo format_date('d M  Y', $content->post_date); ?></time></p>
        <p> <?php echo content_short($content->post_content, 50); ?></p>
        <?php echo nb_tm("see-more"); ?></a>
   </div>
    <?php } ?> 
           
</div>
<?php get_view_button(); ?>

