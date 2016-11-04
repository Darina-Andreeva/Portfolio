<div class="field field-<?php echo $GLOBALS['formField']['place']; ?>">
    <div class="container-label">
        <label for="field_<?php echo $GLOBALS['formField']['place']; ?>">
            <?php echo $GLOBALS['formField']['object']['title']; ?>
            <?php if (get_form_field_requered($GLOBALS['formField']['object']['validations'])) echo '*'; ?>
        </label>
    </div>
    <div class="container-input">
        <input id="field_name" name="<?php echo get_form_object()->name; ?>[<?php echo $GLOBALS['formField']['place']; ?>]" type="text" class="name-field">
    </div>
    <div class="clear"></div>
    <div class="error-message error-<?php echo $GLOBALS['formField']['place']; ?>"></div>
</div>