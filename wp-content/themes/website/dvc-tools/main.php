<?php

$config = include(DIRNAME(__FILE__) . DIRECTORY_SEPARATOR . 'config.php');
foreach ($config['include'] as $file) {
    if (is_file(getFile($file))) {
        include(getFile($file) );
    }
}

function getFile($file) {
    return DIRNAME(__FILE__) . DIRECTORY_SEPARATOR . $file . '.php';
}