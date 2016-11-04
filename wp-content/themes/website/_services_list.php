<?php $terms = nb_get_terms_by("services"); ?>
<?php if ($terms) { ?>
    <ul class="services-list">
        <?php foreach ($terms as $term) { ?>
            <li<?php if ($term->term_id == get_service()->term_id) echo ' class="active"'; ?>>
                <a href="<?php echo get_term_link($term->term_id); ?>" data-target="service-<?php echo $term->term_id; ?>"><?php echo $term->name; ?></a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>

<?php if (is_services_dinamic()) {
    ?>
    <script type="text/javascript">
        $('.services-list').tabs();
    </script>
<?php
} 
