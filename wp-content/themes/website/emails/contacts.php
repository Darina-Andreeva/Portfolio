<?php foreach (forms_email_body()->submit as $place => $field) {
    $content = forms_email_body()->form['fields'][$place];
    $title = $content['title'];
    if ($title == null) {
        $title = $content['values'];
    }?>
    <?php echo $title; ?> : <?php echo $field; ?><br />
<?php } ?>
<br><br>
<?php echo nb_tm('email-generated-from'); ?> <a href="<?php echo get_permalink(forms_email_body()->pageID); ?>"><?php echo get_permalink(forms_email_body()->pageID); ?></a>

