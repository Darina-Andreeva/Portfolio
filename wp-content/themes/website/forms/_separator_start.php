<?php
if (isset($GLOBALS['formField']['separators']))
    $GLOBALS['formField']['separators'] = $GLOBALS['formField']['separators'] + 1;
else
    $GLOBALS['formField']['separators'] = 0;
?>
<div class="separator field-<?php echo $GLOBALS['formField']['place']; ?> separator-<?php echo $GLOBALS['formField']['separators']; ?>">