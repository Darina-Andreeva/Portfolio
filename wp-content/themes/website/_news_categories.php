<?php
$terms = get_news_categories();
if ($terms) { ?>
    <ul class="services-list">
        <?php foreach ($terms as $place => $term) { ?>
            <li<?php if ($term->term_id == $_GET['service'] || $place == 0) echo ' class="active"'; ?>>
                <a href="<?php
                if (get_dinamic_categories())
                    echo get_permalink($post->ID) . '?service=' . $term->slug;
                else
                    echo get_term_link($term->term_id);
                ?>" data-target="<?php echo $term->slug; ?>"><?php echo $term->name; ?></a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
<?php if (get_dinamic_categories()) { ?>
    <script type='text/javascript'>
        $(function () {
            $('.services-list').dinamic();
        });
    </script>
<?php } ?>
