<style>
   .slider {
  margin: 10px 0;
  width: 100%; /* Update to your slider width */
  height: 500px; /* Update to your slider height */
  position: relative;
  overflow: hidden;
}

.slider li {
  display: none;
  position: absolute; 
  top: 0; 
  left: 0; 
} 
.img-item{
    list-style-type: none;
    width: 100%;
    height:500px;
        
}
</style>

<?php get_header(); ?>
<?php //get_template_part("_projects_services_list"); ?>
<?php
$images = get_field('gallery'); ?>
<div class="post-box-main">
  <div class="slider">      
        <?php foreach ($images as $image) { ?>    
                <li class="img-item" style="<?php
                echo get_picture($image, [
                    'type' => 'background',
                    'default' => 'slider',
                    'url' => 'url'
                ]);
                ?>background-size: cover; background-repeat:no-repeat; background-position: center center; w">    
           </li>      
        <?php } ?>      
    </div>
<div class="post-box">
<h1><?php echo $post->post_title; ?></h1>
<p><?php echo $post->post_content ?></p>
 <p>Price:  <?php echo get_price($post) ;?></p>
</div>
</div>
<?php
get_footer();?>


  <script type="text/javascript">
jQuery(function($) { 

  // settings
  var $slider = $('.slider'); // class or id of carousel slider
  var $slide = 'li'; // could also use 'img' if you're not using a ul
  var $transition_time = 1000; // 1 second
  var $time_between_slides = 4000; // 4 seconds

  function slides(){
    return $slider.find($slide);
  }

  slides().fadeOut();

  // set active classes
  slides().first().addClass('active');
  slides().first().fadeIn($transition_time);

  // auto scroll 
  $interval = setInterval(
    function(){
      var $i = $slider.find($slide + '.active').index();

      slides().eq($i).removeClass('active');
      slides().eq($i).fadeOut($transition_time);

      if (slides().length == $i + 1) $i = -1; // loop to start

      slides().eq($i + 1).fadeIn($transition_time);
      slides().eq($i + 1).addClass('active');
    }
    , $transition_time +  $time_between_slides 
  );

});
</script>

