<?php
$contents = nb_search_posts();
?>

<?php foreach ($contents as $content) { ?>
    <a href="<?php echo get_permalink($content->ID); ?>">
        <?php
        echo get_picture(get_field('picture', $product->ID), [
            'type' => 'img',
            'default' => 'slider',
            'url' => 'url'
        ]);
        ?>
        <h1><?php echo $content->post_title; ?></h1>
        <p><time datetime="<?php echo format_date('d M  Y',  $content->post_date); ?>">
                            <?php echo format_date('d M  Y',  $content->post_date); ?></time></p>
        <p><?php echo content_short($content->post_content, 100); ?></p>
    </a>
<?php } ?>