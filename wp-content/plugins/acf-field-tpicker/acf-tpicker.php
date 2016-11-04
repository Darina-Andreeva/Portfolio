<?php

/*
  Plugin Name: Advanced Custom Fields: Template Picker
  Plugin URI:
  Description: Template Picker locations
  Version: 1.0.0
  Author: Ninja Berries
  Author URI: http://berry.ninja
  License: GPLv2 or later
  License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */




// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain('acf-tpicker', false, dirname(plugin_basename(__FILE__)) . '/lang/');

// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_tpicker($version) {

    include_once('acf-tpicker-v5.php');
}

add_action('acf/include_field_types', 'include_field_types_tpicker');

// 3. Include field type for ACF4
function register_fields_tpicker() {

    include_once('acf-tpicker-v4.php');
}

add_action('acf/register_fields', 'register_fields_tpicker');
?>