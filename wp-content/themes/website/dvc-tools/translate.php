<?php

global $q_config;

DEFINE('TRANSLATE_FOLDER', DIRNAME(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'translate');
DEFINE('TRANSLATE_FILE', 'messages.php');

function lang_params() {
    return $GLOBALS['wp_object_cache']->cache['options']['alloptions'];
}

function nb_getLang() {
    global $q_config;
    return $q_config['language'];
}

function nb_getLangs() {
    global $q_config;
    return $q_config['enabled_languages'];
}

function nb_getOtherLang() {
    $langs = nb_getLangs();
    unset($langs[array_search(nb_getLang(), $langs)]);
    return reset($langs);
}

function nb_get_permalink($postID, $lang) {
    if (is_category() || is_tax()){
        return nb_get_permalink_cat($postID, $lang);
    }
    return qtrans_convertURL(get_permalink($postID), trim($lang));
}

function nb_get_permalink_cat($postID, $lang) {
    return qtrans_convertURL(get_category_link($postID), trim($lang));
}

function qtrans_convertURL($url = '', $lang = '', $forceadmin = false, $showDefaultLanguage = false) {
    return qtranxf_convertURL($url, $lang, $forceadmin, $showDefaultLanguage);
}

function nb_tm($message) {
    global $nbtm;
    return $nbtm[nb_getLang()][$message];
}

function nb_include_translation() {
    global $nbtm;
    foreach (nb_getLangs() as $lang) {
        if (is_file(nb_get_file_translate($lang))) {
            $nbtm[$lang] = include(nb_get_file_translate($lang));
        }
    }
}

function nb_get_file_translate($lang) {
    return TRANSLATE_FOLDER . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . TRANSLATE_FILE;
}

// set $nbtm language translates
nb_include_translation();
