<?php
$pages = about_subpages();
if ($pages) { ?> 
    <ul class="about-menu">
        <?php if (abount_in_menu()) { ?>
            <li><a href="<?php echo get_permalink(get_about_page()->ID); ?>"><?php echo apply_filters('the_title', get_about_page()->post_title); ?></a></li>
        <?php } ?>
        <?php foreach ($pages as $page) { ?>
            <li<?php if ($page->ID == $post->ID) echo ' class="active"'; ?>>
                <a href="<?php echo get_permalink($page->ID); ?>"><?php echo $page->post_title; ?></a>
            </li>
        <?php } ?>
    </ul>
    <?php }

