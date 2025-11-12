<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Simple settings page class (register + render).
 */
class YB_Security_Settings {

  private $option_key = 'yb_security_options';
  private $defaults = array(
    'hide_wp_version'   => 0,
    'custom_login_msg'    => 0,
    'logout_idle_user' => 0,
    'disable_rest_api' => 0,
    'custom_login_url' => 0,
    'custom_login_url_slug' => '',
    'idle_logout_duration' => '',
  );

  public function __construct() {
    add_action( 'admin_menu', array( $this, 'add_menu' ) );
    add_action( 'admin_init', array( $this, 'register_settings' ) );
  }

  public function add_menu() {
    add_menu_page(
      __( 'YB Security', 'yb-security' ),
      __( 'YB Security', 'yb-security' ),
      'manage_options',
      'yb-security',
      array( $this, 'render_page' ),
      'dashicons-shield',
      80
    );
  }

  public function register_settings() {
    register_setting(
      'yb_security_settings_group',
      $this->option_key,
      array( $this, 'sanitize_callback' )
    );
  }

  /**
   * Ensure checkboxes save 1 or 0.
   *
   * @param array $input
   * @return array
   */
  public function sanitize_callback( $input ) {
    $clean = $this->defaults;

    if ( is_array( $input ) ) {

        // Checkboxes
        $clean['hide_wp_version']      = !empty($input['hide_wp_version']) ? 1 : 0;
        $clean['custom_login_msg']     = !empty($input['custom_login_msg']) ? 1 : 0;
        $clean['logout_idle_user']     = !empty($input['logout_idle_user']) ? 1 : 0;
        $clean['disable_rest_api']     = !empty($input['disable_rest_api']) ? 1 : 0;
        $clean['custom_login_url']     = !empty($input['custom_login_url']) ? 1 : 0;
        // Text field (sanitize separately)
        $clean['custom_login_url_slug'] = !empty($input['custom_login_url_slug']) ? sanitize_title($input['custom_login_url_slug']) : '';
        $clean['idle_logout_duration'] = $input['idle_logout_duration'] ?? '7200'  ;
    }

    return $clean;
  }

  public function render_page() {
    $options = get_option( $this->option_key, $this->defaults );
    ?>
      <div class="wrap">
        <svg style="display:none">
            <style>
                input.logout_idle_user-check:not(:checked) ~ p{
                    display:none;
                }
            </style>
        </svg>
          <h1><?php esc_html_e( 'Customized Security added in Wordpress  ', 'yb-security' ); ?></h1>

          <form method="post" action="options.php">
            <?php 
            settings_fields( 'yb_security_settings_group' );
            do_settings_sections( 'yb_security_settings_group' );
            ?>

              <table class="form-table">
                  <tr>
                      <th scope="row"><?php esc_html_e('Hide WP Version', 'yb-security'); ?></th>
                      <td>
                          <label>
                              <input type="checkbox" name="yb_security_options[hide_wp_version]" value="1" <?php checked(1, $options['hide_wp_version'] ?? 0); ?> />
                              <span class="description"><?php esc_html_e('If enabled, hide the wordpress version'); ?></span>
                          </label>
                      </td>
                  </tr>

                  <tr>
                      <th scope="row"><?php esc_html_e('Update login Error Message', 'yb-security'); ?></th>
                      <td>
                          <label>
                              <input type="checkbox" name="yb_security_options[custom_login_msg]" value="1" <?php checked(1, $options['custom_login_msg'] ?? 0); ?> />
                              <span class="description"><?php esc_html_e('If enabled, custom message will show for any errors', 'yb-security'); ?></span>
                          </label>
                      </td>
                  </tr>

                  <tr>
                      <th scope="row"><?php esc_html_e('Logout idle Users', 'yb-security'); ?></th>
                      <td>
                          <label>
                              <input type="checkbox" class="logout_idle_user-check" name="yb_security_options[logout_idle_user]" value="1" <?php checked(1, $options['logout_idle_user'] ?? 0); ?> />
                              <span class="description"><?php esc_html_e('Logout idle users automatically after selected time', 'yb-security'); ?></span>
                              <p style="margin-top:6px;">
                                  <select name="yb_security_options[idle_logout_duration]" id="yb_security_idle_duration" style="width: 300px;">
                                    <?php
                                    $durations = [
                                      '3600' => '1 Hour',
                                      '7200' => '2 Hours',
                                      '14400' => '4 Hours',
                                      '28800' => '8 Hours',
                                      '86400' => '1 Day',
                                    ];
                                    $selected_duration =  $options['idle_logout_duration'];
                                    foreach ($durations as $seconds => $label) {
                                      echo '<option value="' . esc_attr($seconds) . '" ' . selected($selected_duration, $seconds, false) . '>' . esc_html($label) . '</option>';
                                    }
                                    ?>
                                  </select>
                          </label>
                      </td>
                  </tr>

                  <tr>
                      <th scope="row"><?php esc_html_e('Disable Rest API', 'yb-security'); ?></th>
                      <td>
                          <label>
                              <input type="checkbox" name="yb_security_options[disable_rest_api]" value="1" <?php checked(1, $options['disable_rest_api'] ?? 0); ?> />
                              <span class="description"><?php esc_html_e('Disable Rest API', 'yb-security'); ?></span>
                          </label>
                      </td>
                  </tr>
                  <tr>
                      <th><?php esc_html_e('Custom Login URL', 'yb-security'); ?></th>
                      <td>
                          <label>
                              <input type="text" name="yb_security_options[custom_login_url_slug]" value="<?php echo esc_attr($options['custom_login_url_slug']); ?>" placeholder="secure-url" style="width: 280px;" />
                              <br><small>Enter your custom login slug (no spaces).</small>
                          </label>
                      </td>
                  </tr>
              </table>

            <?php submit_button(); ?>
          </form>
      </div>
    <?php
  }
}
