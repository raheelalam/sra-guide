<?php
/**
 * Success Stories Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-success-stories-section yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
$data_pre      = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}
?>
<svg style="display:none;">
<style>
<?php require 'success-stories.css'; ?>
</style>
</svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="success_stories">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['ss_heading']; ?></h2>
		</div>
		<div class="container-inner-aside">
			<div class="yb-success-items success-story owl-carousel">
				<?php
				$imgeTitleinitial = 'Customer Success Story:';
				if ( 'ja' === YUGABYTE_CURRENT_LANGUAGE ) {
					$imgeTitleinitial = '顧客成功事例:';
				}
				foreach ( $acf_fields['ss_cards'] as $ss_card ) :
					if ( $ss_card ) :
						$vid_thumb        = $ss_card['video_thumbnail'];
						$last_achievement = '';
						if ( empty( $vid_thumb ) ) {
							$last_achievement = ' last-achievement';
						}
						$two_achievement = '';
						if ( 2 === count( $ss_card['performance_points'] ) ) {
							$two_achievement = ' two-achievements';
						}

						if ( '' === $ss_card['performance_points'][0]['performance'] && 'yes' !== $ss_card['show_video_section'] ) {
							$two_achievement = ' no-achievement-video';
						}

						?>
						<div class="yb-success-item item<?php echo $last_achievement . $two_achievement; ?>">
							<span class="yb-success-thumb">
							<?php
							if ( ! empty( $ss_card['logo']['url'] ) ) {
									echo '<img ' . $data_pre . 'src="' . $ss_card['logo']['url'] . '" alt="' . $imgeTitleinitial . ' ' . $ss_card['logo']['alt'] . '" title="' . $imgeTitleinitial . ' ' . $ss_card['logo']['title'] . '" width="' . $ss_card['logo']['width'] . '" height="' . $ss_card['logo']['height'] . '">';
							}
							?>
							</span>
							<span class="yb-success-quote">
								<q><?php echo str_replace( array( '<p>', '</p>' ), '', $ss_card['description'] ); ?></q>
							</span>

							<?php if ( $ss_card['author_details'] ) : ?>
								<span class="yb-success-quote-autor"><?php echo $ss_card['author_details']; ?></span>
								<?php
							endif;

							foreach ( $ss_card['performance_points'] as $performance_point ) :
								if ( $performance_point ) :
									?>
									<span class="yb-success-achievement">
										<b><?php echo htmlspecialchars( $performance_point['performance'], ENT_QUOTES, 'UTF-8' ); ?></b>
										<u><?php echo $performance_point['detail']; ?></u>
									</span>
									<?php
								endif;
							endforeach;

							if ( 'yes' === $ss_card['show_video_section'] ) :
								$data_vid = '';
								if ( isset( $ss_card['youtube_id'] ) && '' !== $ss_card['youtube_id'] ) {
									$data_vid = 'data-vid="' . $ss_card['youtube_id'] . '"';
								}
								$iframeSrc = 'https://www.youtube.com/embed/' . $ss_card['youtube_id'] . '?autoplay=true&controls=0&mute=1';
								?>
								<span class="yb-success-vid" <?php echo $data_vid; ?>>
									<span class="yb-success-vid-thumb">
										<img <?php echo $data_pre; ?>src="<?php echo $vid_thumb['url']; ?>" alt="<?php echo $vid_thumb['alt']; ?>" title="<?php echo $vid_thumb['title']; ?>" width="<?php echo $vid_thumb['width']; ?>" height="<?php echo $vid_thumb['height']; ?>">
									</span>
									<span class="yb-success-vid-author"><?php echo $ss_card['vd_author_details']; ?></span>
									<?php
									if ( isset( $ss_card['youtube_id'] ) && '' !== $ss_card['youtube_id'] ) :
										?>
										<span class="yb-success-vid-preview">
											<?php echo '<iframe class="yt-iframe" src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-src="' . $iframeSrc . '" allow="autoplay" title="' . $ss_card['vd_author_details'] . '"></iframe>'; ?>
										</span>
									<?php endif; ?>
								</span>
								<?php
							endif;
							if ( ! empty( $ss_card['story_link'] ) ) {
								$author_name = '';
								if ( '' !== $ss_card['vd_author_details'] ) {
									$author      = $ss_card['vd_author_details'];
									$author_name = explode( ',', $author );
									$author_name = $author_name[0];
								}
								$logo_title = '';
								if ( ! empty( $ss_card['logo']['title'] ) ) {
									$logo_title = $ss_card['logo']['title'];
								}
								?>
								<a href="<?php echo esc_url( $ss_card['story_link'] ); ?>" title="<?php echo $imgeTitleinitial; ?> <?php echo esc_attr( $logo_title ); ?>"><?php echo $author_name; ?></a>
							<?php } ?>
						</div>
						<?php
					endif;
				endforeach;
				?>
			</div>
		</div>
		<?php
		if ( $acf_fields['ss_button'] ) :
			$link_target = '';
			if ( '_blank' === $acf_fields['ss_button']['target'] ) {
				$link_target = ' target="_blank" rel="noopener"';
			}
			?>
			<div class="cta text-center">
				<a class="yb--link-black cta-button-small" href="<?php echo esc_url( $acf_fields['ss_button']['url'] ); ?>" title="<?php echo esc_attr( $acf_fields['ss_button']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $acf_fields['ss_button']['title']; ?></a>
			</div>
		<?php endif; ?>
	</div>
</div>

<script>
function success_stories() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/success-stories/success-stories.js?<?php echo $theme_version; ?>', 'BODY','success-stories', function () {
		yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/video-pop.js?<?php echo $theme_version; ?>', 'BODY','video-pop', function () {});
	});
}
</script>
