<?php
$terms = get_news_categories();?>
<ul class="news">
    <?php foreach ($terms as $place => $term) { ?>
        <li class="post-item service-<?php echo $term->slug; ?><?php if ($_GET['service'] == $term->term_id || $place == 0) echo ' active'; ?>">
            <?php $news = get_new_posts_by_cat($term->term_id);
            if ($news) {
                foreach ($news as $article) {
                    echo get_picture(get_picture_news($article, $post->ID), [
                        'type' => 'img',
                        'default' => 'slider',
                        'url' => 'url' ]); ?>
                    <h1><?php echo $article->post_title; ?></h1>
                     <p><time datetime="<?php echo format_date('d M  Y',  $article->post_date); ?>">
                            <?php echo format_date('d M  Y',  $article->post_date); ?></time></p>
                    <p><?php echo content_short($article->post_content, 50); ?></p>
                    <a href="<?php echo get_permalink($article->ID); ?>">
                        <?php echo nb_tm("see-more"); ?></a>
                    <?php }
            } ?>
        </li>
    <?php } ?>
</ul>
