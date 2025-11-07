<?php


// Define your custom login URL
define( 'CUSTOM_LOGIN_SLUG', 'yb-marketing-login' );

// --- 1. Filter for site_url and network_site_url (Requires 3 arguments) ---
function custom_site_url_filter( $url, $path, $scheme ) {
    if ( strpos( $url, 'wp-login.php' ) !== false ) {
        // Replace the old file name with the custom slug
        $url = str_replace( 'wp-login.php', CUSTOM_LOGIN_SLUG, $url );
    }
    return $url;
}
add_filter( 'site_url', 'custom_site_url_filter', 10, 3 );
add_filter( 'network_site_url', 'custom_site_url_filter', 10, 3 );


// --- 2. Filter for wp_redirect (Requires only 1 or 2 arguments) ---
function custom_redirect_url_filter( $location, $status ) {
    if ( strpos( $location, 'wp-login.php' ) !== false ) {
        // Replace the old file name with the custom slug
        $location = str_replace( 'wp-login.php', CUSTOM_LOGIN_SLUG, $location );
    }
    return $location;
}
add_filter( 'wp_redirect', 'custom_redirect_url_filter', 10, 2 );

// --- 3. Handle login and redirection using the early 'init' hook ---
function custom_login_security_handler() {
    global $pagenow;

    // Define the custom login slug (ensure this matches your earlier definition)
    $custom_slug = 'yb-marketing-login';

    $request_uri = $_SERVER['REQUEST_URI'];

    // A. BLOCK direct access to wp-login.php
    if ( $pagenow === 'wp-login.php' ) {
        // Only redirect if the request is NOT using the custom slug as a query var
        // (which sometimes happens during form submission processing)
        if ( strpos( $request_uri, $custom_slug ) === false ) {
            wp_safe_redirect( home_url( '/404' ), 302 );
            exit();
        }
    }

    // B. BLOCK access to wp-admin (only when NOT logged in) - MODIFIED HERE!
    if ( is_admin() && ! is_user_logged_in() && strpos( $request_uri, $custom_slug ) === false ) {

        // Redirect non-logged-in users hitting wp-admin to the 404 page.
        wp_safe_redirect( home_url( '/404' ), 302 ); // Changed to /404
        exit();
    }

    // C. DISPLAY wp-login.php content at the custom URL
    if ( strpos( $request_uri, '/' . $custom_slug ) !== false ) {

        // --- FIX for Login Errors and Undefined Variable Warnings ---
        global $error, $interim_login, $action, $user_login;

        if ( !isset( $error ) ) {
            $error = '';
        }
        if ( !isset( $user_login ) ) {
            $user_login = '';
        }

        // Correctly retrieve error messages after failed login attempts.
        if ( isset( $GLOBALS['errors'] ) && is_wp_error( $GLOBALS['errors'] ) ) {
            $error = $GLOBALS['errors']->get_error_message();
        }

        // Include the original wp-login.php file to render the page
        require_once( ABSPATH . 'wp-login.php' );
        exit();
    }
}
// Use the 'init' hook for early execution
add_action( 'init', 'custom_login_security_handler' );
