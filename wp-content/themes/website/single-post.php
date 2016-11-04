<?php get_header(); ?>
<div class="post-box-main">
    <?php
    echo get_picture(get_picture_news($post), [
        'type' => 'img',
        'default' => 'slider',
        'url' => 'url'
    ]);
    ?>
    <div class="post-box">
        <h1><?php echo $post->post_title; ?></h1>
        <p><time datetime="<?php echo format_date('d M  Y', $post->post_date); ?>">
    <?php echo format_date('d M  Y', $post->post_date); ?></time></p>
        <p><?php echo $post->post_content ;?></p>
    </div>
</div>
<?php 
get_footer();
