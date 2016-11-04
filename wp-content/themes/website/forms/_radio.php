<div class="field field-<?php echo $GLOBALS['formField']['place']; ?>">
    <div class="container-label">
        <label for="field_<?php echo $GLOBALS['formField']['place']; ?>">
            <?php echo $GLOBALS['formField']['object']['title']; ?>
            <?php if (get_form_field_requered($GLOBALS['formField']['object']['validations'])) echo '*'; ?>
        </label>
    </div>
    <div class="container-input">
        <?php
        foreach (get_form_radios($GLOBALS['formField']['object']['values']) as $place => $radio) {
            ?>
            <span class="radio-box"> 
                <input type="radio" 
                       name="<?php echo get_form_object()->name; ?>[<?php echo $GLOBALS['formField']['place']; ?>]" 
                       value="<?php echo $radio['title']; ?>"
                       <?php if ($radio['checked']) { ?>
                           checked="checked"
                       <?php } ?>
                       id="field-input-<?php echo $place; ?>">
                <label for="field-input-<?php echo $place; ?>">&nbsp;</label>
            </span>
            <span class="radio-title"><?php echo $radio['title']; ?></span>

        <?php } ?>
    </div>
    <div class="clear"></div>
    <div class="error-message error-<?php echo $GLOBALS['formField']['place']; ?>"></div>
</div>