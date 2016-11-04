<?php

/**
 * Template Name: About
 */
get_header();?>
<div style='text-align: center;text-align: justify; margin: 20px;'>
<h1><?php echo get_about_title(); ?></h1>
<br>
<p><?php echo get_about_description();?></p>
</div>
<div style='text-align: center;'>
<?php 
$aboutus=get_about_team();
foreach ($aboutus as $about){?>
<div class='projects-name' >
                 <?php   echo get_picture($about['person_picture'], [
                        'type' => 'img',
                        'default' => 'slider',
                        'url' => 'url'
                    ]);
                    ?>
<h1><?php echo $about['name'];?></h1>
<p ><?php echo $about['biografi'];?></p>
</div> 
<?php }?>
</div>

<?php get_footer();
