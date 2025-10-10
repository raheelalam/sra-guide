<?php
/**
 * Youtube Videos block template.
 *
 * @param array  $block           The block settings and attributes.
 * @param string $content         The block inner HTML (empty).
 * @param bool   $is_preview True During backend preview render.
 * @param int    $post_id         The post ID the block is rendering content against.
 * @param array  $context         The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-youtube-vids yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$data_pre      = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
$theme_version = $block_data['theme_version'];

$redirect_url  = '';
$redirect_link = $acf_fields['redirect_on_submission_link'];
if ( ! empty( $acf_fields['redirect_on_submission'] ) && 1 === (int) $acf_fields['redirect_on_submission'] ) {
	$redirect_url = 'data-redirect="' . esc_url( $redirect_link ) . '"';
}

$submission_cookie_name = '';
if ( ! empty( $acf_fields['submission_cookie_name'] ) ) {
	$submission_cookie_name = $acf_fields['submission_cookie_name'];
}

if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}

$section_to_show = 'on-demand-videos';
if ( 'show_form' === $acf_fields['ondemand_videos']
	&& ( ! isset( $_COOKIE, $_COOKIE[ $submission_cookie_name ] ) || 1 !== (int) $_COOKIE[ $submission_cookie_name ] )
) {
	$section_to_show = 'on-demand-form';
}

$cookie_name = '';
if ( $submission_cookie_name && ! empty( $submission_cookie_name ) ) {
	$cookie_name = 'data-cookiename="' . esc_attr( $submission_cookie_name ) . '"';
}

if ( ! is_admin() && ! empty( $submission_cookie_name ) ) {
	if ( 'show_form' === $acf_fields['ondemand_videos'] && ! empty( $redirect_link ) && isset( $_COOKIE, $_COOKIE[ $submission_cookie_name ] ) && 1 === (int) $_COOKIE[ $submission_cookie_name ] ) {
		wp_safe_redirect( $redirect_link, '302' );
		exit;
	}
	if ( 'redirected_from' === $acf_fields['ondemand_videos'] && ! empty( $redirect_link ) && ( ! isset( $_COOKIE, $_COOKIE[ $submission_cookie_name ] ) || 1 !== (int) $_COOKIE[ $submission_cookie_name ] ) ) {
		wp_safe_redirect( $redirect_link, '302' );
		exit;
	}
}
?>

<svg style="display:none;">
	<style>
		.yb-youtube-vids {
			overflow: hidden;
		}
		<?php
		if ( 'on-demand-videos' === $section_to_show ) {
			require 'youtube-videos.css';
		} else {
			require 'conditional-form.css';
		}
		?>
	</style>
</svg>

<section class="<?php echo esc_attr( $class_name ); ?>" data-lazy="dist_vids" <?php echo $redirect_url . ' ' . $cookie_name; ?>>
	<div class="container">
		<?php
		if ( 'on-demand-videos' === $section_to_show ) :
			foreach ( $acf_fields['ds_vid_video_section'] as $video_section ) :
				if ( $video_section ) :
					?>

					<div class="vid-section">
						<?php if ( ! empty( $video_section['heading'] ) ) : ?>
							<div class="section-head">
								<h2><?php echo $video_section['heading']; ?></h2>
							</div>
						<?php endif; ?>

						<div class="section-copy">
							<?php if ( 1 === (int) $video_section['make_it_slider'] ) : ?>
								<div class="sliding">
									<div class="nav">
										<button type="button" role="presentation" class="prev disabled"></button>
										<button type="button" role="presentation" class="next"></button>
								</div>
							<?php endif; ?>
							<div class="vid-items">
								<?php
								foreach ( $video_section['vids'] as $vid ) :
									if ( $vid ) :
										$video_thumb    = $vid['video_thumbnail'];
										$video_date     = $vid['date_time'];
										$formatted_date = '';
										if ( ! empty( $video_date ) ) {
											$date_time      = DateTime::createFromFormat( 'M d, Y h:i a', $video_date );
											$formatted_date = $date_time->format( 'Y-m-d H:i' );
										}
										?>

										<div class="vid-item" data-vid="<?php echo esc_attr( $vid['video_id'] ); ?>">
											<div class="video-thumb" style="background-image:url(<?php echo $video_thumb['url']; ?>);"></div>
											<time datetime="<?php echo $formatted_date; ?>"><?php echo $video_date; ?></time>
											<div class="vid-title"><?php echo esc_html( $vid['title'] ); ?></div>
											<div class="vid-desc"><?php echo esc_html( $vid['desc'] ); ?></div>
										</div>

										<?php
									endif;
								endforeach;
								?>
							</div>
							<?php
							if ( 1 === (int) $video_section['make_it_slider'] ) {
								echo '</div>';
							}
							?>
						</div>
					</div>
					<?php
				endif;
			endforeach;

			$cta_link = $acf_fields['cta_link'];
			if ( ! empty( $cta_link ) ) :
				$target = '';
				if ( '_blank' === $cta_link['target'] ) {
					$target = ' target="_blank" rel="noopener"';
				}
				?>

				<div class="cta text-center">
					<a class="yb--link-black cta-button-small" href="<?php echo $cta_link['url']; ?>"<?php echo $target; ?> title="<?php echo $cta_link['title']; ?>"><?php echo $cta_link['title']; ?></a>
				</div>

				<?php
			endif;

			if ( 1 === (int) $video_section['make_it_slider'] ) :
				?>
				<script>
				function dist_vids() {
					yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/video/youtube-videos/youtube-videos-sliding.js?<?php echo $theme_version; ?>', 'BODY', 'dist_vids', function () {
						yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/video-pop.js?<?php echo $theme_version; ?>', 'BODY', 'video-pop', function () {});
					});
				}
				</script>
			<?php else : ?>
				<script>
				function dist_vids() {
					yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/video/youtube-videos/youtube-videos-non-sliding.js?<?php echo $theme_version . '12'; ?>', 'BODY', 'dist_vids', function () {
						yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/video-pop.js?<?php echo $theme_version; ?>', 'BODY', 'video-pop', function () {});
					});
				}
				</script>
				<?php
			endif;
		else :
			$form_section = $acf_fields['form_section'];
			?>
			<div class="form-content-area" data-cookie="<?php echo esc_attr( $submission_cookie_name ); ?>">
				<div class="left-side-content wysiwyg-content">
					<?php echo $form_section['page_content']; ?>
				</div>
				<div class="right-form-area">
					<?php if ( ! empty( $form_section['form_title'] ) ) : ?>
						<h2><?php echo $form_section['form_title']; ?></h2>
					<?php endif; ?>

					<div class="hubspot-form-area" data-id="<?php echo $form_section ['hubspot_form_id']; ?>"></div>

					<?php if ( ! empty( $form_section['footer_note'] ) ) : ?>
						<div class="footer-note"><?php echo $form_section['footer_note']; ?></div>
					<?php endif; ?>
				</div>
			</div>

			<script>
			function dist_vids() {
				yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/video/youtube-videos/youtube-videos-form.js?<?php echo $theme_version; ?>', 'BODY','form-with-content', function () {});
			}
			</script>
		<?php endif; ?>
	</div>
</section>
