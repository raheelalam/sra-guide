<?php
/**
 * Uninstall YB Security Plugin
 *
 * This file will remove all saved options when the plugin is deleted.
 *
 * @package YB_Security
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
  exit;
}

// Delete plugin options
delete_option( 'yb_security_options' );

