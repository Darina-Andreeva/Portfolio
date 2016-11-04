<form method="POST" action="<?php echo get_form_object()->submitUrl; ?>" class="<?php echo get_form_object()->name; ?>">
    <?php
    foreach (get_form_object()->fields as $place => $field) {
        $GLOBALS['formField']['object'] = $field;
        $GLOBALS['formField']['place'] = $place;
        ?>
        <?php get_template_part('forms/' . $field['type']); ?>
    <?php }
    ?>
</form>
<script type="text/javascript">
    $(function () {
        $('.<?php echo get_form_object()->name; ?>').forms();
    });
</script>