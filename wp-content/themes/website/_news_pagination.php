
<?php
$news = nb_search_posts();
?>
<div class="news-box-main">
    <?php
    if ($news) {
        foreach ($news as $article) {
            ?>
            <div class="news-box">
                <?php
                echo get_picture(get_picture_news($article, $post->ID), [
                    'type' => 'img',
                    'default' => 'slider',
                    'url' => 'url'
                ]);
                ?>

                <h1><?php echo $article->post_title; ?></h1>
                <p><time datetime="<?php echo format_date('d M  Y', $article->post_date); ?>">
                        <?php echo format_date('d M  Y', $article->post_date); ?></time></p>
                <p><?php echo content_short($article->post_content, 50); ?></p>
                <p><?php echo content_short($article->post_content, 50); ?></p>
                <a href="<?php echo get_permalink($article->ID); ?>">
                    <?php echo nb_tm("see-more"); ?></a>
            </div>
            <?php
        }
    }
    ?>

</div>
<?php
if (get_type_new() == 'pagination numbers') {
    if (function_exists('nb_search_posts')) {
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


