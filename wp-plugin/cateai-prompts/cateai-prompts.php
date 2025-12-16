<?php
/**
 * Plugin Name: CateAI Prompts
 * Description: Fetches and caches prompts from the Zerocater API using ACF, with options for automatic scheduling and cache clearing.
 * Version: 1.1
 * Author: Your Name
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class CateAIPrompts {

    private $default_api_url = 'https://app.zerocater.com/api/caterai/metadata/?format=json&type=prompt';
    private $option_api_url = 'cateai_api_url';
    // Removed $this->option_prompts as prompts are now stored via ACF
    private $option_log = 'cateai_last_fetch_log';
    private $option_interval = 'cateai_fetch_interval_hours';
    private $cron_hook = 'cateai_fetch_prompts_hourly';
    
    // ACF Field Keys
    private $acf_field_name = 'prompts'; // ACF Repeater Field Name
    private $acf_sub_field_name = 'prompt'; // ACF Repeater Sub-Field Name
    private $acf_options_page_id = 'option'; // Standard ID for ACF Options Page

    public function __construct() {
        // Setup Admin Menu and actions
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_post_cateai_manual_fetch', array( $this, 'handle_manual_fetch' ) );

        // Cron job setup
        add_filter( 'cron_schedules', array( $this, 'add_custom_cron_schedule' ) );
        add_action( $this->cron_hook, array( $this, 'fetch_prompts_data' ) );
        
        // Setup on plugin activation/deactivation
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
    }

    /**
     * Plugin activation: Sets default interval and schedules the cron event.
     */
    public function activate() {
        // Set default options
        if ( ! get_option( $this->option_interval ) ) {
            update_option( $this->option_interval, 6 );
        }
        
                              
        if ( ! get_option( $this->option_api_url ) ) {
            update_option( $this->option_api_url, $this->default_api_url );
        }
        
        // Schedule the event
        $this->schedule_event();
    }

    /**
     * Plugin deactivation: Clears the scheduled cron event.
     */
    public function deactivate() {
        wp_clear_scheduled_hook( $this->cron_hook );
    }

    /**
     * Schedules the cron event based on the saved interval.
     */
    private function schedule_event() {
        if ( wp_next_scheduled( $this->cron_hook ) ) {
            wp_clear_scheduled_hook( $this->cron_hook );
        }
        
        $hours = intval( get_option( $this->option_interval, 6 ) );
        $schedule = "cateai_{$hours}_hours";

        // Fallback to hourly if custom schedule creation fails or if interval is too small
        if ( ! array_key_exists( $schedule, wp_get_schedules() ) || $hours < 1 ) {
            $schedule = 'hourly'; 
        }

        wp_schedule_event( time(), $schedule, $this->cron_hook );
    }

    /**
     * Adds custom cron schedule intervals.
     */
    public function add_custom_cron_schedule( $schedules ) {
        $hours = intval( get_option( $this->option_interval, 6 ) );
        
        $schedules["cateai_{$hours}_hours"] = array(
            'interval' => $hours * HOUR_IN_SECONDS,
            'display'  => sprintf( __( 'Every %s Hours (CateAI)', 'cateai-prompts' ), $hours ),
        );
        return $schedules;
    }

    /**
     * Registers plugin settings (interval and API URL).
     */
    public function register_settings() {
        // 1. Automatic Run Interval
        register_setting( 'cateai_settings_group', $this->option_interval, array(
            'type'              => 'integer',
            'sanitize_callback' => 'intval',
            'default'           => 6,
        ) );
        
        // 2. API URL Source
        register_setting( 'cateai_settings_group', $this->option_api_url, array(
            'type'              => 'string',
            'sanitize_callback' => 'esc_url_raw',
            'default'           => $this->default_api_url,
        ) );
    }

    /**
     * Adds the admin menu item.
     */
    public function add_admin_menu() {
        add_menu_page(
            'CateAI Prompts Settings',
            'CateAI Prompts',
            'manage_options',
            'cateai-prompts',
            array( $this, 'render_admin_page' ),
            'dashicons-list-view'
        );
    }

    /**
     * Handles manual fetch button click from the admin page.
     */
    public function handle_manual_fetch() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'cateai_manual_fetch_nonce' ) ) {
            wp_die( __( 'Nonce verification failed.' ) );
        }

        $this->fetch_prompts_data();

        // Redirect back to the settings page
        wp_safe_redirect( add_query_arg( 'settings-updated', 'true', admin_url( 'admin.php?page=cateai-prompts' ) ) );
        exit;
    }

    /**
     * Core function to fetch data, save prompts, log status, and clear cache/files.
     */
    public function fetch_prompts_data() {
        // Check if ACF is active
        if ( ! function_exists( 'update_field' ) ) {
            $log_entry = array(
                'timestamp' => current_time( 'timestamp' ),
                'date'      => current_time( 'mysql' ),
                'status'    => 'Fetch Failed',
                'message'   => 'ACF is not active or update_field() is missing. Prompts not saved.',
            );
            update_option( $this->option_log, $log_entry );
            return;
        }

        // Use the saved URL from settings
        $current_api_url = get_option( $this->option_api_url, $this->default_api_url );
        
                                                
        if ( empty( $current_api_url ) || ! filter_var( $current_api_url, FILTER_VALIDATE_URL ) ) {
            $log_entry = array(
                'timestamp' => current_time( 'timestamp' ),
                'date'      => current_time( 'mysql' ),
                'status'    => 'Fetch Failed',
                'message'   => 'API URL is empty or invalid in settings.',
            );
            update_option( $this->option_log, $log_entry );
            return;
        }

        $response = wp_remote_get( $current_api_url );
        $log_entry = array(
            'timestamp' => current_time( 'timestamp' ),
            'date'      => current_time( 'mysql' ),
        );

        if ( is_wp_error( $response ) ) {
            $log_entry['status'] = 'Fetch Failed';
            $log_entry['message'] = 'WordPress HTTP Error: ' . $response->get_error_message();
            update_option( $this->option_log, $log_entry );
            return;
        }

        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        if ( wp_remote_retrieve_response_code( $response ) === 200 && is_array( $data ) && isset( $data['prompts'] ) ) {
            
            // Format data for ACF Repeater field
            $acf_rows = array();
            foreach ( $data['prompts'] as $prompt_text ) {
                $acf_rows[] = array(
                    $this->acf_sub_field_name => $prompt_text
                );
            }

            // 1. Save prompts using ACF update_field()
            // Assumes the ACF Options Page ID is 'option' (standard for options pages)
            update_field( $this->acf_field_name, $acf_rows, $this->acf_options_page_id ); 
            
            // 2. Log success
            $log_entry['status'] = 'Success';
            $log_entry['message'] = sprintf( 'Successfully fetched and saved %d prompts via ACF.', count( $acf_rows ) );
            update_option( $this->option_log, $log_entry );

            // 3. Clear file cache
            $this->clear_local_cache_files();

            // 4. Clear WP Engine Cache
//            $this->clear_wpe_cache();

        } else {
            // Log fetch failure
            $log_entry['status'] = 'Fetch Failed';
            $log_entry['message'] = 'API returned invalid data or non-200 status code. Response code: ' . wp_remote_retrieve_response_code( $response );
            update_option( $this->option_log, $log_entry );
        }

        // Re-schedule the cron event in case the interval was changed
        $this->schedule_event();
    }

    /**
     * Deletes all files in the target directory using WP_Filesystem.
     */
    private function clear_local_cache_files() {
        $cache_dir = trailingslashit( WP_CONTENT_DIR ) . 'uploads/zerocater/cache/page';

        if ( ! function_exists( 'WP_Filesystem' ) ) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        if ( WP_Filesystem() ) {
            global $wp_filesystem;
            
            if ( $wp_filesystem->is_dir( $cache_dir ) ) {
                // Delete the contents, but not the directory itself
                $files = $wp_filesystem->dirlist( $cache_dir );
                if ( is_array( $files ) ) {
                    foreach ( $files as $file => $details ) {
                        $file_path = $cache_dir . '/' . $file;
                        if ( $wp_filesystem->is_file( $file_path ) ) {
                            $wp_filesystem->delete( $file_path );
                        }
                    }
                }
            }
        }
    }

    /**
     * Attempts to clear WP Engine cache using their common hooks/functions.
     */
   /* private function clear_wpe_cache() {
                                                                          
        if ( has_action( 'wpe_purge_all' ) ) {
            do_action( 'wpe_purge_all' );
            return;
        }

        if ( class_exists( 'WpeCommon' ) && method_exists( 'WpeCommon', 'purge_memcached_global' ) ) {
            \WpeCommon::purge_memcached_global();
            return;
        }
    }*/
    
    /**
     * Helper function to retrieve prompts from ACF.
     * This is used internally for display in the admin page.
     * @return array
     */
    private function get_prompts_from_acf() {
        if ( ! function_exists( 'get_field' ) ) {
            return array();
        }

        // Fetch the repeater rows from the ACF Options Page
        $acf_prompts = get_field( $this->acf_field_name, $this->acf_options_page_id );
        $prompts_list = array();

        if ( is_array( $acf_prompts ) ) {
            foreach ( $acf_prompts as $row ) {
                if ( isset( $row[ $this->acf_sub_field_name ] ) ) {
                    $prompts_list[] = $row[ $this->acf_sub_field_name ];
                }
            }
        }
        return $prompts_list;
    }

    /**
     * Renders the plugin administration page.
     */
    public function render_admin_page() {
        // Retrieve settings and log
        $hours = intval( get_option( $this->option_interval, 6 ) );
        $log = get_option( $this->option_log, array( 'status' => 'Never run.' ) );
        
        // --- FETCH PROMPTS FROM ACF ---
        $prompts = $this->get_prompts_from_acf();
        // ------------------------------
        
        $next_schedule = wp_next_scheduled( $this->cron_hook );
        
        ?>
        <div class="wrap">
            <h1>CateAI Prompts Settings</h1>

            <div class="card">
                <h2>Cron Job Schedule</h2>
                <form method="post" action="options.php">
                    <?php settings_fields( 'cateai_settings_group' ); ?>
                    <?php do_settings_sections( 'cateai-prompts' ); ?>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="<?php echo esc_attr( $this->option_api_url ); ?>">API URL Source</label></th>
                            <td>
                                <input type="url" name="<?php echo esc_attr( $this->option_api_url ); ?>" id="<?php echo esc_attr( $this->option_api_url ); ?>" value="<?php echo esc_attr( get_option( $this->option_api_url, $this->default_api_url ) ); ?>" class="regular-text" style="width: 100%; max-width: 600px;" />
                                <p class="description">The external URL that returns the JSON data containing the prompts (e.g., must end with <code>format=json&type=prompt</code>).</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="<?php echo esc_attr( $this->option_interval ); ?>">Automatic Run Interval</label></th>
                            <td>
                                <input type="number" name="<?php echo esc_attr( $this->option_interval ); ?>" id="<?php echo esc_attr( $this->option_interval ); ?>" value="<?php echo esc_attr( $hours ); ?>" min="1" step="1" style="width: 80px;" /> hours
                                <p class="description">How often the plugin should automatically fetch new prompts and clear cache/files.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Next Scheduled Run</th>
                            <td>
                                <?php if ( $next_schedule ) : ?>
                                    <strong><?php echo date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $next_schedule ); ?></strong> (<?php echo human_time_diff( $next_schedule, current_time( 'timestamp' ) ); ?> from now)
                                <?php else: ?>
                                    <span style="color: red;">Not currently scheduled. Click 'Save Changes' to fix.</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    <?php submit_button(); ?>
                </form>
            </div>

            <div class="card">
                <h2>Manual Fetch & Status Log</h2>
                
                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                    <input type="hidden" name="action" value="cateai_manual_fetch">
                    <?php wp_nonce_field( 'cateai_manual_fetch_nonce' ); ?>
                    <?php submit_button( 'Fetch New Prompts Now', 'primary', 'cateai_fetch_button' ); ?>
                </form>

                <table class="form-table">
                    <tr>
                        <th scope="row">Last Fetch Status</th>
                        <td>
                            <strong style="color: <?php echo $log['status'] === 'Success' ? 'green' : 'red'; ?>;">
                                <?php echo esc_html( $log['status'] ); ?>
                            </strong>
                            <p class="description">
                                <?php echo isset( $log['date'] ) ? 'Timestamp: ' . esc_html( date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $log['timestamp'] ) ) . '<br>' : ''; ?>
                                Message: <?php echo esc_html( $log['message'] ?? 'Plugin has not run yet.' ); ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card">
                <h2>Current Saved Prompts (Total: <?php echo count( $prompts ); ?>)</h2>
                <p class="description">Data is saved to the ACF Options Page: <code>caterai-form-setting</code>.</p>
                <?php if ( ! empty( $prompts ) ) : ?>
                    <ol>
                        <?php foreach ( array_slice( $prompts, 0, 10 ) as $prompt ) : ?>
                            <li><?php echo esc_html( $prompt ); ?></li>
                        <?php endforeach; ?>
                        <?php if ( count( $prompts ) > 10 ) : ?>
                            <li>... and <?php echo count( $prompts ) - 10; ?> more.</li>
                        <?php endif; ?>
                    </ol>
                <?php else : ?>
                    <p>No prompts are currently saved. Click the "Fetch New Prompts Now" button above.</p>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}

// Instantiate the class
new CateAIPrompts();