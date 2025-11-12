<?php
/**
 * Plugin Name: YB Security
 * Description: Basic security options for WordPress.
 * Version: 1.0.1
 * Author: Sami Ahmed Siddiqui
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define('YB_SEC_PATH', plugin_dir_path(__FILE__));
define( 'YB_SEC_FILE', __FILE__ );
define( 'YB_SEC_VERSION', '1.0.0' );

/* Include files */
require_once YB_SEC_PATH . 'includes/class-yb-security-settings.php';
require_once YB_SEC_PATH . 'includes/class-yb-security-frontend.php';

/**
 * Initialize simple loader for this test plugin.
 */
function yb_security_init_simple() {
	// Admin settings handler
	if ( is_admin() ) {
		new YB_Security_Settings();
	}

	// Features (test echo outputs)
	new YB_Security_Frontend();
}
add_action( 'plugins_loaded', 'yb_security_init_simple' );
