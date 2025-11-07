<?php

/**
 * Disable Rest Api for logout users (/wp-json/wp/v2/users/,/wp-json/wp/v2/posts/ )
 * Returning an authentication error if a user who is not logged in tries to query the REST API
 * @param $access
 * @return WP_Error
 */
function only_allow_logged_in_rest_access( $access ) {
    if ( !is_user_logged_in() ) {
        return new WP_Error( 'rest_cannot_access', __( 'Only authenticated users can access the REST API.', 'disable-json-api' ), array( 'status' => rest_authorization_required_code() ) );
    }

    return $access;
}
add_filter( 'rest_authentication_errors', 'only_allow_logged_in_rest_access' );