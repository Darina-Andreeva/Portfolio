<?php

define('FORMS_ERRORS', 1);
define('FORMS_SUCCESS', 0);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_GET['submit'])) {
    forms_submit($_GET['submit'], $_GET['page']);
 
}

function get_form($name, $template = 'template') {
    set_form_object($name);
    if (get_form_object())
        get_template_part('forms/' . $template);
    else
        echo 'form not found';
}

function set_form_object($name) {
    global $post;
    $id = get_form_by_slug($name)->ID;
    $GLOBALS['customform'] = get_fields($id);
    $GLOBALS['customform']['submitUrl'] = home_url('?submit=' . $id . '&page=' . $post->ID);
    $GLOBALS['customform']['name'] = $name;
    $GLOBALS['customform'] = (object) $GLOBALS['customform'];
}

function get_form_object() {
    return $GLOBALS['customform'];
}

function get_form_by_slug($name) {
    $args = array(
        'post_type' => 'forms',
        'posts_per_page' => 1,
        'name' => $name,
        'post_status' => 'publish',
    );
    return reset(get_posts($args));
}

function get_form_radios($items) {
    $list = explode("\n", $items);
    foreach ($list as $place => $item) {
        if ($item[0] === '*') {
            $content = get_form_radios_content(strip_tags(str_replace('*', '', $item)));
            $radios[$place]['title'] = $content['title'];
            $radios[$place]['checked'] = true;
            $radios[$place]['value'] = $content['value'];
        } else {
            $content = get_form_radios_content(strip_tags($item));
            $radios[$place]['title'] = $content['title'];
            $radios[$place]['value'] = $content['value'];
        }
    }
    return $radios;
}

function get_form_radios_content($content) {
    $values = explode(':', $content);
    if (count($values) > 1) {
        return [
            'title' => $values[1],
            'value' => $values[0],
        ];
    } else {
        return[
            'title' => $values[0],
            'value' => $values[0],
        ];
    }
}

function get_form_field_requered($validations) {
    return array_search('empty', $validations) !== null;
}

function forms_submit($id, $pageID) {
    $formPage = get_post($id);
    $form = get_fields($formPage->ID);
    $errors = null;
    $submit = $_POST[$formPage->post_name];
    foreach ($form['fields'] as $place => $field) {
        if ($field['is_separator'] == false && $field['is_separator_end'] == false) {
            if (!empty($field['validations']))
                foreach ($field['validations'] as $validator) {
                    if ($errors[$place] == null) {
                        if (!forms_validator($validator, $submit[$place], $field['values'])) {
                            $errors[$place] = forms_validation_error_message($validator);
                        }
                    }
                }
        }
    }
    if ($errors == null) {
        if ($form['saving_data'] == true) {
            forms_save_data($form['fields'], $submit, $formPage);
        }
        if ($form['sending_email'] == true) {
            forms_send_email($form, $formPage, $pageID, $submit);
        }
        return forms_result_success(forms_success_actions($form));
    } else {
        return forms_result_errors($errors);
    }
}

function forms_send_email($form, $formPage, $pageID, $submit) {
    $to = forms_to_email($form, $formPage, $pageID, $submit);
    $from = forms_from_email($form, $formPage, $pageID, $submit);
    $subject = $form['email_subject'];
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers.= "From: <" . $from . ">" . "\r\n";
    return wp_mail($to, $subject, forms_email_template([
        'form' => $form,
        'formPage' => $formPage,
        'pageID' => $pageID,
        'submit' => $submit,
            ]), $headers);
}

function forms_from_email($form, $formPage, $pageID) {
    if ($form['sending_from'] == 'email') {
        $email = $form['sending_from_email'];
    } else if (trim($form['sending_from']) == 'page field') {
        $email = get_field($form['sending_from_page_field'], $pageID);
    } else if (trim($form['sending_from']) == 'form field') {
        $email = $_POST[$formPage->post_name][$form['sending_from_form_field']];
    }
    return $email;
}

function forms_to_email($form, $formPage, $pageID) {
    if ($form['sending_to'] == 'email') {
        $email = $form['sending_to_email'];
    } else if (trim($form['sending_to']) == 'page field') {
        $email = get_field($form['sending_to_page_field'], $pageID);
    } else if (trim($form['sending_to']) == 'form field') {
        $email = $_POST[$formPage->post_name][$form['sending_to_form_field']];
    }
    return $email;
}

function forms_email_template($data) {
    $GLOBALS['email'] = $data;
    $directory = dirname(__FILE__) . '/../emails/' . strtolower($data['formPage']->post_name) . '.php';
    ob_start();
    include ($directory);
    $template = ob_get_contents();
    ob_end_clean();
    return $template;
}

function forms_email_body() {
    return (object) $GLOBALS['email'];
}

function forms_success_actions($form) {
    $result['type'] = $form['success'];
    if ($form['success'] != 'normal') {
        if ($form['success'] == 'popup') {
            $result['content'] = $form['success_message'];
        } else if ($form['success'] == 'popup page') {
            $result['content'] = $form['success_popup_page'];
        } else if ($form['success'] == 'popup_link') {
            $result['content'] = $form['success_popup_link'];
        } else if ($form['success'] == 'page') {
            $result['content'] = get_permalink($form['success_page']->ID);
        } else if ($form['success'] == 'link') {
            $result['content'] = $form['success_link'];
        }
    }
    return $result;
}

function forms_validator($name, $value, $values) {
    $validator = 'forms_validator_' . trim(str_replace(' ', '', $name));
    return $validator($value, $values);
}

function forms_validator_empty($value, $values) {
    return !empty($value);
}

function forms_validator_email($value, $values) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}

function forms_validator_emailexists($value, $values) {
    $data = get_field('data', $_GET['submit']);
    if ($data)
        foreach ($data as $item) {
            if (!empty($item['record'])) {
                if ($value == $item['record'][0]['value'])
                    return false;
            }
        }

    return true;
}

function forms_validation_error_message($validator) {
    $errorMessages = forms_validator_error_messages();
    return $errorMessages[$validator];
}

function forms_validator_error_messages() {
    return [
        'empty' => nb_tm('forms-error-empty'),
        'email' => nb_tm('forms-error-email'),
        'email exists' => nb_tm('forms-error-email-exists'),
        'phone' => nb_tm('forms-error-phone'),
    ];
}

function forms_result($result) {
    echo json_encode(array(
        'state' => $result['state'],
        'data' => $result['data'],
    ));
}

function forms_result_success($data = []) {
    return forms_result(['state' => FORMS_SUCCESS, 'data' => $data]);
}

function forms_result_errors($data = []) {
    return forms_result(['state' => FORMS_ERRORS, 'data' => $data]);
}

function forms_save_data($fields, $submit, $page) {
    $data = get_field('data', $page->ID);
    if ($data == false)
        $data = null;
    $field = get_field_object('data', $page->ID);
    $metaData = get_post_meta($page->ID, 'data', TRUE);
    $repeater_field = $field['name'];
    $repeater_key = $field['key'];
    $sub_field = 'record';
    $sub_field_name = 'name';
    $sub_field_value = 'value';
    $count = count($data) + 1;
    $countFields = count($fields) - 1;
    if ($metaData != '') {
        update_post_meta($page->ID, $repeater_field, $count);
    } else {
        $sub_field_key_data = 'field_' . uniqid();
        $repeater_field = 'data';
        add_post_meta($page->ID, $repeater_field, $count);
        add_post_meta($page->ID, '_' . $repeater_field, $repeater_key);
    }
    $sub_field_key_record = 'field_' . uniqid();
    $sub_field_record = $repeater_field . '_' . ($count - 1) . '_' . $sub_field;
    $place = 0;
    foreach ($fields as $p => $field) {
        if ($field['is_separator'] == false && $field['is_separator_end'] == false && $field['type'] != '_send' && !empty($submit[$p])) {
            $sub_field_key_name = 'field_' . uniqid();
            $name = $sub_field_record . '_' . $place . '_' . $sub_field_name;
            add_post_meta($page->ID, $name, $field['title'], false);
            add_post_meta($page->ID, '_' . $name, $sub_field_key_name, false);
            $sub_field_key_value = 'field_' . uniqid();
            $value = $sub_field_record . '_' . $place . '_' . $sub_field_value;
            add_post_meta($page->ID, $value, $submit[$p], false);
            add_post_meta($page->ID, '_' . $value, $sub_field_key_value, false);
            $place++;
        }
    }
    add_post_meta($page->ID, $sub_field_record, $place);
}
