<?php

/* Contact Form { */
define('CONTACTS_FORM_EMAIL', 'form-email');

function submitConctactForm() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['custom'])) {
        $formName = $_POST['custom'];
        if (empty($formName))
            $formName = 'contact';
        if (!empty($_POST[$formName])) {
            $error = false;
            foreach ($_POST[$formName] as $field => $contact) {
                if (checkEmpty($contact)) {
                    $errors[$field] = nb_tm('form-error-required');
                    $error = true;
                } elseif ($field == 'email' && empty($errors[$field]) && checkEmail($contact)) {
                    $errors[$field] = nb_tm('form-error-email');
                    $error = true;
                }
            }

            if ($error) {
                echo json_encode(array('state' => 1, 'message' => $errors));
            } else {
                if (submitContactEmail($_POST[$formName]))
                    echo json_encode(array(
                        'state' => 0,
                        'message' => nb_tm('form-sent'),
                        'success' => 'callback',
                        'success_action' => 'success_' . $_POST['custom']
                    ));
                else
                    echo json_encode(array('state' => 1, 'message' => nb_tm('form-not-sent')));
            }
        }
        exit;
    }
}

function checkEmpty($value) {
    return empty($value);
}

function checkEmail($value) {
    return !filter_var($value, FILTER_VALIDATE_EMAIL);
}

function submitContactEmail($message) {
    global $post;
    return nb_send_email(get_field('email', $post->ID), (object) $message);
}

function nb_get_contacts_email() {
    global $post;
    if ($postin != null)
        $post = $postin;
    return get_field(CONTACTS_FORM_EMAIL, $post->ID);
}

function nb_send_email($email, $model) {
    $to = $email;
    $from = $model->email;
    $subject = nb_tm('email-subject-' . $_POST['custom']);
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers.= "From: <" . $from . ">" . "\r\n";
    return mail($to, $subject, nb_email_template($model), $headers);
}

function nb_email_template($form) {
    $GLOBALS['email'] = $form;
    $directory = dirname(__FILE__) . '/../emails/' . strtolower($_POST['custom']) . '.php';
    ob_start();
    include ($directory);
    $template = ob_get_contents();
    ob_end_clean();
    return $template;
}

function nb_email_template_body() {
    return $GLOBALS['email'];
}

/* Contact Form } */

