<?php
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Frontend Features — apply plugin features via hooks/filters, no output
 */
class YB_Security_Frontend
{

  private $option_key = 'yb_security_options';
  private $options = array();
  private $customSlug = '';
  private $idle_time = '';

  public function __construct()
  {
    $this->options = get_option($this->option_key, array(
      'hide_wp_version' => 0,
      'custom_login_msg' => 0,
      'logout_idle_user' => 0,
      'disable_rest_api' => 0,
      'custom_login_url' => 0,
      'custom_login_url_slug' => '',
      'idle_logout_duration' => '',
    ));

    // Apply features for frontend & admin
    $this->apply_features();
  }

  /**
   * Apply selected features
   */
  private function apply_features()
  {
    if (!empty($this->options['hide_wp_version'])) {
      $this->feature_hide_wp_version();
    }

    if (!empty($this->options['custom_login_msg'])) {
      $this->feature_custom_login_msg();
    }

    if (!empty($this->options['logout_idle_user'])) {
      $this->feature_logout_idle_user();
    }


    if (!empty($this->options['disable_rest_api'])) {
      $this->feature_disable_rest_api();
    }
    if (!empty($this->options['custom_login_url_slug'])) {
      $this->feature_custom_login_url();
    }
  }

  /**
   * Hide WordPress version and
   */
  private function feature_hide_wp_version() {
    add_filter('style_loader_src', array($this, 'remove_version_from_assets'), 9999);
    add_filter('script_loader_src', array($this, 'remove_version_from_assets'), 9999);
    add_filter( 'wpseo_hide_version', '__return_true' );
  }


  /**
   * Modify login error messages
   */
  private function feature_custom_login_msg() {
    // Customize login errors
    add_filter('login_errors', array($this, 'custom_login_error_message'));
  }
  public function custom_login_error_message($error)
  {
    if (stripos($error, 'incorrect') !== false || stripos($error, 'not registered') !== false) {
      return '<strong>ERROR</strong>: The User or Password you entered is incorrect.';
    }
    return $error;
  }


  /**
   *  Logout idle users
   */
  private function feature_logout_idle_user() {
    add_action('init', array($this, 'logout_idle_user'));
  }
  public function logout_idle_user() {

    if (is_user_logged_in()) {
      $user_id = get_current_user_id();
      $current_time = current_time('timestamp');
      $idle_time = !empty($this->options['idle_logout_duration']) ? $this->options['idle_logout_duration'] : 7200 ;

      $last_activity = get_user_meta($user_id, 'last_activity', true);
      update_user_meta($user_id, 'last_activity', $current_time);

      if ($last_activity && ($current_time - $last_activity) > $idle_time) {
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
  }

  /**
   * Hide login errors
   */
  private function feature_disable_rest_api() {
    add_filter('rest_authentication_errors', array($this, 'only_allow_logged_in_rest_access'));
  }
  public function only_allow_logged_in_rest_access( $access ) {
    if ( !is_user_logged_in() ) {
      return new WP_Error( 'rest_cannot_access', __( 'Only authenticated users can access the REST API.', 'disable-json-api' ), array( 'status' => rest_authorization_required_code() ) );
    }

    return $access;
  }

  /**
   * Update login URL
   */
  private function feature_custom_login_url() {
    // Get the slug from options or fallback to default
    $customSlug = !empty($this->options['custom_login_url_slug']) ? sanitize_title($this->options['custom_login_url_slug']) : $this->customSlug;

    if (!defined('CUSTOM_LOGIN_SLUG')) {
      define('CUSTOM_LOGIN_SLUG', $customSlug);
    }
    // --- 1. Filter site URLs ---
    add_filter('site_url', array($this, 'custom_site_url_filter'), 10, 3);
    add_filter('network_site_url', array($this, 'custom_site_url_filter'), 10, 3);

    // --- 2. Filter wp_redirect ---
    add_filter('wp_redirect', array($this, 'custom_redirect_url_filter'), 10, 2);

    // --- 3. Handle login page access ---
    add_action('init', array($this, 'custom_login_security_handler'));
  }

  /**
   * Replace wp-login.php in site URL
   */
  public function custom_site_url_filter($url, $path, $scheme) {
    if (strpos($url, 'wp-login.php') !== false) {
      $url = str_replace('wp-login.php', CUSTOM_LOGIN_SLUG, $url);
    }
    return $url;
  }

  /**
   * Replace wp-login.php in redirect URL
   */
  public function custom_redirect_url_filter($location, $status) {
    if (strpos($location, 'wp-login.php') !== false) {
      $location = str_replace('wp-login.php', CUSTOM_LOGIN_SLUG, $location);
    }
    return $location;
  }

  /**
   * Block default login page and admin for non-logged-in users
   * Display login page at custom URL
   */
  public function custom_login_security_handler() {
    global $pagenow;

      $custom_slug = CUSTOM_LOGIN_SLUG;
      $request_uri = $_SERVER['REQUEST_URI'];

    // A. Block direct wp-login.php access
    if ($pagenow === 'wp-login.php' && strpos($request_uri, $custom_slug) === false) {
      wp_safe_redirect(home_url('/404'), 302);
      exit();
    }
    if(strpos($request_uri, $custom_slug) !== false  && is_user_logged_in() ){
      wp_safe_redirect(admin_url());
    }

    // B. Block wp-admin for non-logged-in users
    if (is_admin() && !is_user_logged_in() && strpos($request_uri, $custom_slug) === false) {
      wp_safe_redirect(home_url('/404'), 302);
      exit();
    }


    // C. Display wp-login.php at custom URL
    if (strpos($request_uri, '/' . $custom_slug) !== false) {
      global $error, $interim_login, $action, $user_login;

      $error = isset($error) ? $error : '';
      $user_login = isset($user_login) ? $user_login : '';

      if (isset($GLOBALS['errors']) && is_wp_error($GLOBALS['errors'])) {
        $error = $GLOBALS['errors']->get_error_message();
      }

      require_once ABSPATH . 'wp-login.php';
      exit();
    }
  }


  /**
 * Remove version from assets
   */
  public function remove_version_from_assets($src)
  {
    if (strpos($src, 'ver=') !== false) {
      $src = remove_query_arg('ver', $src);
    }
    return $src;
  }


}

