<?php
$similar= get_project_similars();
foreach($similar as $similars){?>
 <a  class="projects-box" href="<?php echo get_permalink($similars->ID); ?>">
                <?php
                echo get_picture(get_field('picture', $similars->ID), [
                    'type' => 'img',
                    'default' => 'slider',
                    'url' => 'url'
                ]);
                ?>
            <h1><?php echo $similars->post_title; ?></h1>
<?php }?>