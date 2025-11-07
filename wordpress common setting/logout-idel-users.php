<?php

//logout if user is in idle mode for 2 hours
add_action('init', function () {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $current_time = current_time('timestamp');

        $last_activity = get_user_meta($user_id, 'last_activity', true);
        update_user_meta($user_id, 'last_activity', $current_time);

        // echo 'Test'.$current_time.'---'.$last_activity.' >>'.($current_time - $last_activity);
        if ($last_activity && ($current_time - $last_activity) > (60*60*2)) {
            global $wpdb;
            $wpdb->query(
                $wpdb->prepare(
                    "DELETE FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = 'session_tokens'",
                    $user_id
                )
            );

            wp_logout();
            wp_redirect(wp_login_url() . '?session_expired=1');
            exit;
        }
    }
});