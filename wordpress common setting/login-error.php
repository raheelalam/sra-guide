<?php

/**
 * Customize error messages on login page
 */
function incountry_error_messages($error)
{
    global $errors;

    $error_codes = $errors->get_error_codes();
    if ($_GET && $_GET['action'] && 'lostpassword' === $_GET['action']) {
        if (in_array('invalid_email', $error_codes)
            || in_array('invalidcombo', $error_codes)
            || in_array('pass', $error_codes)
        ) {
            $error = 'Further instructions have been sent to your e-mail address.<style>.login #login_error {border-left-color: #00a0d2!important;}</style>';
        }

    } else {
        if (in_array('incorrect_password', $error_codes)
            || in_array('invalid_username', $error_codes)
            || in_array('invalid_email', $error_codes)
            || in_array('authentication_failed', $error_codes)
            || in_array('invalidkey', $error_codes)
        ) {
            $error = '<strong>ERROR</strong>: The User or Password you entered is incorrect.';
        }
    }

    return $error;
}

add_filter('login_errors', 'incountry_error_messages');