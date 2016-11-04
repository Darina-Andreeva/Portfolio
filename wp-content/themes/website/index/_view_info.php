<h1 class="home-heading"><?php echo nb_get_page_row_data()->data['title']; ?></h1>
<div class="template-<?php echo nb_get_page_row_data()->data["type"]; ?> template-<?php echo nb_get_page_row_data()->place; ?>">
  
    <?php foreach (nb_get_page_row_data()->data["items"] as $info) { ?>
    <div class="info-box">
        <h1> <?php echo $info["title"]; ?></h1>
        <p> <?php echo $info["description"];?></p>
    </div>
    <div class="front-img">
   
     <?php
           echo get_picture($info["picture"], [
                        'type' => 'img',
                        'default' => 'slider',
                        'url' => 'url'
                    ]);
                    ?>
    </div>
</div>
    <?php }
    ?> 
    <?php get_view_button(); ?>
</div>