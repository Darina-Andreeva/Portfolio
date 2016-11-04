<?php if (nb_get_page_row_data()->data['button']) { ?>
<a class="view-btn" href="<?php echo nb_get_page_row_data()->data['button_link']; ?>">
        <?php echo nb_get_page_row_data()->data['button_title']; ?>
    </a>
<?php } ?>