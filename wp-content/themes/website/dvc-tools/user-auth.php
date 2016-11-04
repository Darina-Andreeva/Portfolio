<?php

add_action('init', 'ajax_auth_init');

function ajax_auth_init() {
    wp_register_script('ajax-auth-script', get_template_directory_uri() . '/js/admin/ajax-auth-script.js', array('jquery'));
    wp_enqueue_script('ajax-auth-script');

    wp_localize_script('ajax-auth-script', 'ajax_auth_object', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'redirecturl' => home_url(),
//        'loadingmessage' => __('Sending user info, please wait...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action('wp_ajax_nopriv_ajaxlogin', 'ajax_login');
    // Enable the user with no privileges to run ajax_register() in AJAX
    add_action('wp_ajax_nopriv_ajaxregister', 'ajax_register');
    // Enable the user with no privileges to run ajax_forgotPassword() in AJAX
    add_action('wp_ajax_nopriv_ajaxforgotpassword', 'ajax_forgotPassword');
    if (is_user_logged_in()) {
        // Enable the user with no privileges to run ajax_profile() in AJAX
        add_action('wp_ajax_ajaxprofile', 'ajax_profile');
    }
}

// Execute the action only if the user isn't logged in
//    if (!is_user_logged_in()) {
//add_action('init', 'ajax_auth_init');
//    }

function ajax_login() {

    // First check the nonce, if it fails the function will break
    check_ajax_referer('ajax-login-nonce', 'security');

    // Nonce is checked, get the POST data and sign user on
    // Call auth_user_login
    auth_user_login($_POST['username'], $_POST['password'], 'Login');

    die();
}

function ajax_register() {

    // First check the nonce, if it fails the function will break
    check_ajax_referer('ajax-register-nonce', 'security');

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']);
    $info['user_pass'] = sanitize_text_field($_POST['password']);
    $info['user_email'] = sanitize_email($_POST['email']);

    // Register the user
    $user_register = wp_insert_user($info);
    if (is_wp_error($user_register)) {
        $error = $user_register->get_error_codes();

        if (in_array('empty_user_login', $error))
            echo json_encode(array('loggedin' => false, 'message' => nb_tm('error-empty')));
        elseif (in_array('existing_user_login', $error))
            echo json_encode(array('loggedin' => false, 'message' => nb_tm('error-email-exits')));
        elseif (in_array('existing_user_email', $error))
            echo json_encode(array('loggedin' => false, 'message' => nb_tm('error-user-exists')));
    } else {
        auth_user_login($info['nickname'], $info['user_pass'], 'Registration');
    }

    die();
}

function auth_user_login($user_login, $password, $login) {
    $info = array();
    $info['user_login'] = $user_login;
    $info['user_password'] = $password;
    $info['remember'] = true;

    $user_signon = wp_signon($info, false);
    if (is_wp_error($user_signon)) {
        echo json_encode(array('loggedin' => false, 'message' => nb_tm('error-wrong-user-or-pass')));
    } else {
        wp_set_current_user($user_signon->ID);
        echo json_encode(array('loggedin' => true));
    }

    die();
}

function ajax_forgotPassword() {

    // First check the nonce, if it fails the function will break
    check_ajax_referer('ajax-forgot-nonce', 'security');

    global $wpdb;

    $account = $_POST['user_login'];

    if (empty($account)) {
        $error = 'Enter an username or e-mail address.';
    } else {
        if (is_email($account)) {
            if (email_exists($account))
                $get_by = 'email';
            else
                $error = nb_tm('error-no-existing-user');
        }
        else if (validate_username($account)) {
            if (username_exists($account))
                $get_by = 'login';
            else
                $error = nb_tm('error-no-existing-user');
        } else
            $error = nb_tm('error-email');
    }

    if (empty($error)) {
        // lets generate our new password
        //$random_password = wp_generate_password( 12, false );
        $random_password = wp_generate_password();


        // Get user data by field and data, fields are id, slug, email and login
        $user = get_user_by($get_by, $account);

        $update_user = wp_update_user(array('ID' => $user->ID, 'user_pass' => $random_password));

        // if  update user return true then lets send user an email containing the new password
        if ($update_user) {

            $from = 'WRITE SENDER EMAIL ADDRESS HERE'; // Set whatever you want like mail@yourdomain.com

            if (!(isset($from) && is_email($from))) {
                $sitename = strtolower($_SERVER['SERVER_NAME']);
                if (substr($sitename, 0, 4) == 'www.') {
                    $sitename = substr($sitename, 4);
                }
                $from = 'admin@' . $sitename;
            }

            $to = $user->user_email;
            $subject = 'Your new password';
            $sender = 'From: ' . get_option('name') . ' <' . $from . '>' . "\r\n";

            $message = 'Your new password is: ' . $random_password;

            $headers[] = 'MIME-Version: 1.0' . "\r\n";
            $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers[] = "X-Mailer: PHP \r\n";
            $headers[] = $sender;

            $mail = wp_mail($to, $subject, $message, $headers);
            if ($mail)
                $success = 'Check your email address for you new password.';
            else
                $error = 'System is unable to send you mail containg your new password.';
        } else {
            $error = 'Oops! Something went wrong while updaing your account.';
        }
    }

    if (!empty($error))
        echo json_encode(array('loggedin' => false, 'message' => __($error)));

    if (!empty($success))
        echo json_encode(array('loggedin' => false, 'message' => __($success)));

    die();
}

function ajax_profile() {
//    require_once( ABSPATH . WPINC . '/registration.php');
    check_ajax_referer('ajax-register-nonce', 'security');
    $user = wp_get_current_user();
    if (is_email($_POST['email'])) {
        if (email_exists($_POST['email']) && $_POST['email'] != $user->user_email) {
            echo json_encode(array('updated' => false, 'message' => __('email exists')));
        } else {
            $user_login = $_POST['username'];
            $user_password = $_POST['password'];
            $user_email = $_POST['email'];
            $result = wp_update_user([
                'ID' => $user->ID,
                'user_login' => $user_login,
                'user_nicename' => $user_login,
                'display_name' => $user_login,
                'user_pass' => $user_password,
                'user_email' => $user_email
            ]);
            wp_cache_delete($new->ID, 'users');
            wp_cache_delete($new->user_login, 'userlogins');
            wp_cache_delete($new->user_email, 'useremail');
            wp_cache_delete($new->user_nicename, 'userslugs');
            do_action('profile_update');
            $result = $result == false ? false : true;
            echo json_encode(['updated' => $result]);
        }
    }
    die();
}
