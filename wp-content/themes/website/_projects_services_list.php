<?php $terms = nb_get_terms_by("services"); ?>
<?php if ($terms) { ?>
    <ul class='services-list'>
        <?php foreach ($terms as $term) { ?>
            <li<?php if ($term->slug == $_GET['service']) echo ' class="active"'; ?>>
                <a href="<?php echo get_permalink(nb_get_page('projects')->ID); ?>?service=<?php echo $term->slug; ?>" data-target="<?php echo $term->slug; ?>"><?php echo $term->name; ?></a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
<?php if (get_projects_type() == 'rearrange') { ?>
    <script type='text/javascript'>
        $(function () {
            $('.services-list').rearrange();
        });
    </script>
<?php } ?>
