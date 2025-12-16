<?php
/*
Plugin Name: Email Domain Against ZC
Description: Fetches domains from a Google Sheet and alternates storage between two tables every 4 hours.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class EmailDomainAgainstZC {
    private $option_key = 'edazc_active_table';
    private $table1 = 'wp_email_domains_1';
    private $table2 = 'wp_email_domains_2';
    private $google_sheet_option = 'edazc_google_sheet_url';

    public function __construct() {
        register_activation_hook(__FILE__, [$this, 'install']);
        add_action('admin_menu', [$this, 'create_admin_menu']);
        add_action('edazc_fetch_domains_cron', [$this, 'fetch_and_store_domains']);
    }

    public function install() {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $sql = "CREATE TABLE IF NOT EXISTS {$this->table1} (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			web_domain VARCHAR(255) NOT NULL,
            email_domain VARCHAR(255) NOT NULL,
            time DATETIME DEFAULT CURRENT_TIMESTAMP
        );";
        dbDelta($sql);

        $sql = "CREATE TABLE IF NOT EXISTS {$this->table2} (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			web_domain VARCHAR(255) NOT NULL,
            email_domain VARCHAR(255) NOT NULL,
            time DATETIME DEFAULT CURRENT_TIMESTAMP
        );";
        dbDelta($sql);

        if (!get_option($this->option_key)) {
            update_option($this->option_key, $this->table1);
        }
    }

    public function create_admin_menu() {
        add_menu_page('Email Domains ZC', 'Email Domains ZC', 'manage_options', 'email-domain-zc', [$this, 'admin_page']);
		//add_menu_page('Email Domains ZC', 'Email Domains ZC', 'manage_options', 'email-domain-zc', '<h1>Email Domain</h1>');
    }


public function admin_page() {
    if (isset($_POST['google_sheet_url'])) {
        update_option($this->google_sheet_option, esc_url($_POST['google_sheet_url']));
        wp_redirect(add_query_arg('cron_success', 'saved'));
        exit;
    }

    if (isset($_POST['edazc_save_settings'])) {
        update_option('edazc_icon', esc_url($_POST['edazc_icon']));
        update_option('edazc_heading', sanitize_text_field($_POST['edazc_heading']));
        update_option('edazc_details', wp_kses_post($_POST['edazc_details']));
        update_option('edazc_link1_text', sanitize_text_field($_POST['edazc_link1_text']));
        update_option('edazc_link2_text', sanitize_text_field($_POST['edazc_link2_text']));
		update_option('edazc_link1_link', sanitize_text_field($_POST['edazc_link1_link']));
        update_option('edazc_link2_link', sanitize_text_field($_POST['edazc_link2_link']));
        wp_redirect(add_query_arg('settings_updated', 'true'));
        exit;
    }

    // Show success messages
    if (isset($_GET['cron_success']) && $_GET['cron_success'] == '1') {
        echo '<div class="updated notice is-dismissible"><p>Cron job executed successfully.</p></div>';
    } elseif (isset($_GET['cron_success']) && $_GET['cron_success'] == 'saved') {
        echo '<div class="updated notice is-dismissible"><p>Google Sheet URL saved successfully.</p></div>';
    } elseif (isset($_GET['settings_updated'])) {
        echo '<div class="updated notice is-dismissible"><p>Settings saved successfully.</p></div>';
    }

    $last_cron_run = get_option('edazc_last_cron_run', 'Never');
    $next_cron_run = wp_next_scheduled('edazc_fetch_domains_cron');
    $last_row_count = get_option('edazc_last_cron_count', 0);

    // Get custom field values
    $icon = get_option('edazc_icon', '');
    $heading = get_option('edazc_heading', '');
    $details = get_option('edazc_details', '');
    $link1_text = get_option('edazc_link1_text', '');
	$link1_link = get_option('edazc_link1_link', '');
	
	$link2_text = get_option('edazc_link2_text', '');
	$link2_link = get_option('edazc_link2_link', '');
	
    //$link2 = get_option('edazc_link2', '');
	
	

    ?>

    <div class="wrap">
        <h1>Email Domain Against ZC</h1>

        <!-- Google Sheet URL Form -->		
		<form method="POST" class="card" style="min-width:100%; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <label for="google_sheet_url"><strong style="font-size: 16px; padding-bottom: 10px; display: inline-block;">Google Sheet URL</strong></label>
            <input type="text" id="google_sheet_url" name="google_sheet_url" 
                   value="<?php echo esc_attr(get_option($this->google_sheet_option, '')); ?>" 
                   class="regular-text" style="width: calc(100% - 106px); margin-bottom: 10px;" />
            <button type="submit" class="button button-primary" style="min-width:100px;">Save</button>
        </form>

        <!-- Cron Job Status -->
        <h2 style="margin-top: 20px;">Cron Job Status</h2>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Current Server Time</th>
                    <th>Last Cron Run</th>
                    <th>Next Cron Run</th>
                    <th>Rows Fetched in Last Cron</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo date('Y-m-d H:i:s'); ?></td>
                    <td><?php echo esc_html($last_cron_run); ?></td>
                    <td><?php echo ($next_cron_run ? date('Y-m-d H:i:s', $next_cron_run) : 'Not Scheduled'); ?></td>
                    <td><?php echo esc_html($last_row_count); ?></td>
                </tr>
            </tbody>
        </table><br>
        <button onclick="runCronNow()" class="button button-secondary">Run Cron Now</button>

        <!-- Custom Fields -->
        
        <style>
			.edazc-settings-card {
				background: #fff;
				padding: 20px;
				border-radius: 8px;
				box-shadow: 0 2px 4px rgba(0,0,0,0.1);
				max-width: 100%;
			}
			.edazc-settings-card h2 {
				font-size: 20px;
				margin-bottom: 15px;
			}
			.edazc-settings-card label {
				font-weight: bold;
				font-size: 14px;
				display: block;
				margin-bottom: 5px;
			}
			.edazc-settings-card input[type="text"],
			.edazc-settings-card input[type="url"] {
				width: 100%;
				padding: 8px;
				border: 1px solid #ccc;
				border-radius: 4px;
				font-size: 14px;
			}
			.edazc-settings-card textarea {
				width: 100%;
				height: 100px;
				border: 1px solid #ccc;
				border-radius: 4px;
				padding: 8px;
				font-size: 14px;
			}
			.edazc-settings-card button {
				margin-top: 10px;
			}
			.edazc-link-buttons {
				display: flex;
				align-items: center;
				gap: 10px;
			}
			input#edazc_icon {
				max-width: calc(100% - 121px);
			}
			button#edazc_icon_button {
				padding: 8px 20px;
			}
			.dp-flex{
				display:flex;
				gap:20px;
			}
		</style>

		<div class="wrap">
			<h1>Popup Fields</h1>
			<form method="POST" class="edazc-settings-card">
				<input type="hidden" name="edazc_save_settings" value="1" />

				<div style="margin-bottom:20px;">
					<label for="edazc_icon">Icon URL:</label>
					<input type="text" id="edazc_icon" name="edazc_icon" value="<?php echo esc_attr($icon); ?>" />
					<button type="button" class="button" id="edazc_icon_button">Select Image</button>
					<br>
					<img id="edazc_icon_preview" src="<?php echo esc_attr($icon); ?>" style="max-width:100px; margin-top:10px; display:<?php echo $icon ? 'block' : 'none'; ?>;" />
				</div>

				<script>
				jQuery(document).ready(function($){
					$('#edazc_icon_button').click(function(e) {
						e.preventDefault();
						var image_frame;
						if(image_frame){
							image_frame.open();
							return;
						}
						image_frame = wp.media({
							title: 'Select or Upload an Image',
							library: { type: 'image' },
							button: { text: 'Use this image' },
							multiple: false
						});
						image_frame.on('select', function(){
							var attachment = image_frame.state().get('selection').first().toJSON();
							$('#edazc_icon').val(attachment.url);
							$('#edazc_icon_preview').attr('src', attachment.url).show();
						});
						image_frame.open();
					});

					// Show preview when input field value changes (useful for manual URL entry)
					$('#edazc_icon').on('input', function() {
						var imgUrl = $(this).val();
						if(imgUrl) {
							$('#edazc_icon_preview').attr('src', imgUrl).show();
						} else {
							$('#edazc_icon_preview').hide();
						}
					});
				});
				</script>


				<div style="margin-bottom:20px;">
					<label for="edazc_heading">Heading:</label>
					<input type="text" id="edazc_heading" name="edazc_heading" value="<?php echo esc_attr($heading); ?>" />
				</div>

				<div style="margin-bottom:20px;">
					<label for="edazc_details">Details (WYSIWYG Editor):</label>
					<?php 
					wp_editor(stripslashes( $details ), 'edazc_details', [
						'textarea_name' => 'edazc_details',
						'media_buttons' => true,
						'textarea_rows' => 5
					]);
					?>
				</div>
				

				<div style="margin-bottom:25px; border-bottom:1px solid #ccc;padding-bottom:20px;">
					<h3>Request a Demo Button:</h3>
					<div class="dp-flex">
					<div style="flex-grow:1;">
						<label for="edazc_link1">Button Text</label>
						<input type="text" id="edazc_link1_text" name="edazc_link1_text" value="<?php echo $link1_text; ?>"/>
					</div>
					<div style="flex-grow:1;">
						<label for="edazc_link1_link">Button Link</label>
						<input type="text" id="edazc_link1_link" name="edazc_link1_link" value="<?php echo $link1_link; ?>" />
					</div>
					</div>
				</div>
				
				
				<div style="margin-bottom:20px;">
					<h3>Login Button:</h3>
					<div class="dp-flex">
					<div style="flex-grow:1;">
						<label for="edazc_link1">Button Text</label>
						<input type="text" id="edazc_link2_text" name="edazc_link2_text" value="<?php echo $link2_text; ?>" />
					</div>
					<div style="flex-grow:1;">
						<label for="edazc_link1">Button Link</label>
						<input type="text" id="edazc_link2_link" name="edazc_link2_link" value="<?php echo $link2_link; ?>" />
					</div>
					</div>
				</div>
				
				<button type="submit" class="button button-primary">Save Settings</button>
			</form>
		</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('input[name="emial"]').forEach(function (input) {
        input.addEventListener("input", function (event) {
            if (event.data === ".") {
                alert("You typed a dot (.) in the email field!");
            }
        });
    });
});

</script

		
		

        <!-- Web Domains -->
        <h2 style="margin-top: 20px;">Web Domains</h2>
        <?php
        global $wpdb;
        $active_table = get_option('edazc_active_table', 'wp_email_domains_1');
        $web_domains = $wpdb->get_col("SELECT DISTINCT web_domain FROM $active_table");
        ?>

        <table class="widefat striped">
            <tbody>
                <?php
                if (!empty($web_domains)) {
                    $count = 0;
                    $email_num = 0;
                    echo '<tr>';
					$all_domain = '';
					$all_domain = implode(', ', array_map('esc_html', $web_domains));
					update_option('all_domain_email', $all_domain);
                    foreach ($web_domains as $email) {
						
                        $email_num++;
                        echo '<td>'.$email_num.'- '. esc_html($email) . '</td>';
                        $count++;
                        if ($count % 4 == 0) {
                            echo '</tr><tr>';
                        }
                    }
					
                    echo '</tr>';
                } else {
                    echo '<tr><td colspan="4">No email domains found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
		
		
		
		<!-- Email Domains -->
        <h2 style="margin-top: 20px;">Email Domains</h2>
        <?php
        //global $wpdb;
        //$active_table = get_option('edazc_active_table', 'wp_email_domains_1');
        $email_domains = $wpdb->get_col("SELECT email_domain FROM $active_table");
        ?>

        <table class="widefat striped">
            <tbody>
                <?php
                if (!empty($email_domains)) {
                    $count = 0;
                    $email_num = 0;
                    echo '<tr>';
					$all_domain = '';
					$all_domain = implode(', ', array_map('esc_html', $email_domains));
					update_option('all_domain_email', $all_domain);
                    foreach ($email_domains as $eemail) {
						if($eemail){
							$email_num++;						
							echo '<td>'.$email_num.'- '. esc_html($eemail) . '</td>';
							$count++;
							if ($count % 4 == 0) {
								echo '</tr><tr>';
							}
						}
						
                    }
					
                    echo '</tr>';
                } else {
                    echo '<tr><td colspan="4">No email domains found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
		
		
		<?php //print '<br>=========<br>'.get_option('all_domain_email').'<br>=========<br>';?>

    </div>

    <script>
        function runCronNow() {
            fetch("<?php echo admin_url('admin-ajax.php?action=run_cron_now'); ?>")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = "<?php echo add_query_arg('cron_success', '1'); ?>";
                } else {
                    alert('Error running cron.');
                }
            })
            .catch(error => alert('Error running cron.'));
        }
    </script>

    <?php
}






	public function fetch_and_store_domains() {
		$sheet_url = get_option($this->google_sheet_option);
		if (!$sheet_url) return;

		$csv_url = str_replace('/edit?gid=', '/gviz/tq?tqx=out:csv&gid=', $sheet_url);
		$data = wp_remote_get($csv_url);
		if (is_wp_error($data)) {
			error_log('Google Sheet Fetch Error: ' . $data->get_error_message());
			return;
		}

		$csv = wp_remote_retrieve_body($data);
		$rows = str_getcsv($csv, "\n");
		
		array_shift($rows);
		
		global $wpdb;

		$inactive_table = get_option($this->option_key) === $this->table1 ? $this->table2 : $this->table1;
		$wpdb->query("TRUNCATE TABLE $inactive_table");
		
		$seen_domains = []; // Array to track unique domains
		
		foreach ($rows as $row) {
			 $cols = str_getcsv($row);
			$email_domain = sanitize_text_field($cols[0]);
			
			$email_domain = rtrim($email_domain, '/');

			// Only insert if the domain is not already in the array
			if (!empty($email_domain) && !in_array($email_domain, $seen_domains)) {
				
				$seen_domains[] = $email_domain; // Add to array to track
				
				$com_email_domain = sanitize_text_field($cols[1]);
				$com_email_domain = rtrim($com_email_domain, '/');
				
				
				/*if (!empty($com_email_domain && !in_array($com_email_domain, $seen_domains))){
					$wpdb->insert($inactive_table, ['web_domain' => $email_domain, 'email_domain' => $com_email_domain]);
					$seen_domains[] = $com_email_domain; // Add to array to track
					
				}else{
					$wpdb->insert($inactive_table, ['web_domain' => $email_domain]);
				}*/
				
				if (!empty($com_email_domain && !in_array($com_email_domain, $seen_domains))){
					
					$domains = array_map('trim', explode(',', $com_email_domain));
									
					if(count($domains) > 1 ){
						foreach ($domains as $domain) {
							if (!empty($domain) && !in_array($domain, $seen_domains)) {
								$wpdb->insert($inactive_table, [
									'web_domain'  => $email_domain,
									'email_domain'=> $domain
								]);
								$seen_domains[] = $domain; // Add to array to track
							}
						}
					}else{
						$wpdb->insert($inactive_table, ['web_domain' => $email_domain, 'email_domain' => $com_email_domain]);
						$seen_domains[] = $com_email_domain; // Add to array to track
					}
					
				}else{
					$wpdb->insert($inactive_table, ['web_domain' => $email_domain]);
				}
				
				
			}
		}
		
		update_option($this->option_key, $inactive_table);
		update_option('edazc_last_cron_count', count($rows)); // Save last row count
		update_option('edazc_last_cron_run', date('Y-m-d H:i:s')); // Save last run time
	}


}

new EmailDomainAgainstZC();

add_filter('cron_schedules', function($schedules) {
    $schedules['four_hours'] = array(
        'interval' => 3600*4, // 120 seconds = 2 minutes :: 3600 for 1 hour :: 60 for 1 sec
        'display'  => __('Every Five Minutes')
    );
    return $schedules;
});

add_action('wp_ajax_run_cron_now', function() {
    (new EmailDomainAgainstZC())->fetch_and_store_domains();
    wp_send_json_success('Cron job executed.');
});
/*
if (!wp_next_scheduled('edazc_fetch_domains_cron')) {
    wp_schedule_event(time(), 'four_hours', 'edazc_fetch_domains_cron');
}
*/
if (!wp_next_scheduled('edazc_fetch_domains_cron')) {
    wp_schedule_event(time(), 'four_hours', 'edazc_fetch_domains_cron');
}



