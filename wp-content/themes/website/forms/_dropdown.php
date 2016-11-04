<div class="field field-<?php echo $GLOBALS['formField']['place']; ?>">
    <div class="container-label">
        <label for="field_<?php echo $GLOBALS['formField']['place']; ?>">
            <?php echo $GLOBALS['formField']['object']['title']; ?>
            <?php if (get_form_field_requered($GLOBALS['formField']['object']['validations'])) echo '*'; ?>
        </label>
    </div>
    <div class="container-input">
        <select name="<?php echo get_form_object()->name; ?>[<?php echo $GLOBALS['formField']['place']; ?>]">
            <option value=""><?php echo $GLOBALS['formField']['object']['empty_text']; ?></option>
            <?php
            foreach (get_form_radios($GLOBALS['formField']['object']['values']) as $place => $option) {
                ?>
                <?php if (!empty($GLOBALS['formField']['object']['empty_text'])) { ?>
                <?php } ?>
                <option value="<?php echo $option['value']; ?>"
                <?php if ($option['checked']) { ?>
                            selected="selected"
                        <?php } ?>>
                            <?php echo $option['title']; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="clear"></div>
    <div class="error-message error-<?php echo $GLOBALS['formField']['place']; ?>"></div>
</div>