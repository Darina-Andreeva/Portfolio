<select class="language-switcher">
    <?php foreach (nb_getLangs() as $lang) { ?>
        <option value="<?php echo nb_get_permalink($post->ID, $lang); ?>"<?php if (nb_getLang() == $lang) echo " selected"; ?>><?php echo nb_tm('lang-' . $lang); ?></option>
    <?php } ?>
</select>
<script type="text/javascript">
    $(function () {
        $('.language-switcher').change(function () {
            window.location.href = $(this).val();
        });
    });
</script>