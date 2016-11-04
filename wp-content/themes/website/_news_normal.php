
<?php
$news = nb_search_posts();
?>
<div class="news-box-main">

    <?php
    if ($news) {
        foreach ($news as $article) {
            ?>
            <div class="news-box">
                <a href="<?php echo get_permalink($article->ID); ?>">
                    <?php
                    echo get_picture(get_picture_news($article), [
                        'type' => 'img',
                        'default' => 'slider',
                        'url' => 'url'
                    ]);
                    ?>

                    <h1> <?php echo $article->post_title; ?></h1>
                    <p><time datetime="<?php echo format_date('d M  Y', $article->post_date); ?>">
                            <?php echo format_date('d M  Y', $article->post_date); ?></time></p>
                    <p><?php echo content_short($article->post_content, 50); ?></p>
                </a>
                <a href="<?php echo get_permalink($article->ID); ?>">
                    <?php echo nb_tm("see-more"); ?></a>

            </div>
            <?php
        }
    }
    ?>
</div>
