<div class="field field-submit">
    <div class="container-input btn-submit-form fright">
        <div class="inner">
            <div class="load-container load1">
                <div class="loader">Loading...</div>
            </div>
        </div>
        <?php $states = get_form_radios($GLOBALS['formField']['object']['values']); ?>
        <input type="submit" 
               class="btn fright" 
               name="contact[submit]" 
               id="field_submit" 
               value=" <?php echo $GLOBALS['formField']['object']['title']; ?>" 
               data-sending="<?php echo strip_tags($states[0]['title']); ?>"
               data-sent="<?php echo strip_tags($states[1]['title']); ?>" >
    </div>
</div>