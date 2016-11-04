<div class="language-container">
    <a href="javascript:;" class="switcher"><?php echo nb_tm('lang-' . nb_getLang()); ?></a>
    <ul class="lang-list col">
        <?php foreach (nb_getLangs() as $lang) { ?>
            <li <?php if (nb_getLang() == $lang) echo ' class="active"'; ?>> 
                <a href="<?php echo nb_get_permalink($post->ID, $lang); ?>">
                    <?php echo nb_tm('lang-' . $lang); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
<script type="text/javascript">
    $(function () {
        $('.language-container').langSwitch();
    });
</script>