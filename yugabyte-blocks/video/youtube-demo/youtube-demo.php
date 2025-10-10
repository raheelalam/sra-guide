<?php
/**
 * Benefit Section Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-in-action-section section-bg-dark yb-sec come-out' );
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
$interactive_demo = $acf_fields['interactive_demo'];
$demo_video       = $interactive_demo ['demo_group'];
$section_title    = $interactive_demo['id_heading'];
$video_thumb      = $demo_video['video_thumbnail'];
$vid_ID           = $demo_video['video_id'];
?>

<svg style="display:none;">
	<style>
	<?php
	require 'youtube-demo.css';
	if ( 'ja' === YUGABYTE_CURRENT_LANGUAGE ) {
		require 'youtube-demo-ja.css';
	}
	?>
	</style>
</svg>
<section class="<?php echo esc_attr( $class_name ); ?>" data-lazy="plateform_inaction" id="interactive-demo">
	<div class="container">
		<div class="section-head">
			<h2>
				<?php echo $section_title; ?>
			</h2>
		</div>
		<div class="section-copy">
			<?php
			$show_Play      = $demo_video['show_play_icon'];
			$vid_ID         = $demo_video['video_id'];
			$video_autoplay = $demo_video['video_autoplay'];

			$data_vid = 'data-vid="' . $vid_ID . '"';
			$playIcon = '';

			if ( 1 === (int) $show_Play ) {
				$playIcon = ' data-play="true"';
			}
			if ( ! empty( $video_thumb ) && ! empty( $video_thumb ) ) :
				?>
				<div class="yb-inaction-inner for-mobile popup-area video-thumbnail">
					<div class="yb-popup-vid" <?php echo $data_vid; ?><?php echo $playIcon; ?> data-autoplay='<?php echo $video_autoplay; ?>'>
						<div class="yb-popup-vid-thumb">
							<img class="skip-lazy" <?php echo $data_pre; ?>src="<?php echo $video_thumb['url']; ?>" alt="<?php echo $video_thumb['alt']; ?>" title="<?php echo $video_thumb['title']; ?>" width="<?php echo $video_thumb['width']; ?>" height="<?php echo $video_thumb['height']; ?>">
						</div>
					</div>
				</div>
				<?php
			elseif ( ! empty( $vid_ID ) ) :
				?>
				<div class="yb-inaction-inner for-mobile popup-area no-thumbnail" data-autoplay="<?php echo $video_autoplay; ?>" <?php echo $data_vid; ?>>
					<iframe width="560" height="315" data-src="https://www.youtube.com/embed/<?php echo $vid_ID; ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen title="<?php echo $acf_fields['video_section']['pin_heading']; ?>"></iframe>
				</div>
				<?php
			endif;

			$interactive_demo_content = $interactive_demo['id_content_area'];
			?>
			<div class="yb-inaction-inner for-desktop">
				<div class="demo-section" data-video="video">
					<?php if ( ! empty( $video_thumb ) && ! empty( $video_thumb ) ) : ?>
						<div class="yb-popup-vid-thumb">
							<img class="skip-lazy" <?php echo $data_pre; ?>src="<?php echo $video_thumb['url']; ?>" alt="<?php echo $video_thumb['alt']; ?>" title="<?php echo $video_thumb['title']; ?>" width="<?php echo $video_thumb['width']; ?>" height="<?php echo $video_thumb['height']; ?>">
						</div>
					<?php endif; ?>
					<iframe width="560" height="315" data-demo="/youtube-video-demo/?id=<?php echo $vid_ID . '&v=' . $theme_version; ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" title="<?php echo $interactive_demo_content['demo_heading']; ?>"></iframe>
					<div class="demo-overlay">
						<div class="content-area">
							<div class="h3"><?php echo $interactive_demo_content['demo_heading']; ?></div>
							<div class="demo-detail"><?php echo $interactive_demo_content['short_detail']; ?></div>
							<div class="cta"><a role="button" class="yb--link-black cta-button-small" title="<?php echo $interactive_demo_content['button_text']; ?>"><?php echo $interactive_demo_content['button_text']; ?></a></div>
						</div>
					</div>
					<span class="close-demo"></span>
				</div>
			</div>
			<?php

			$signUpdText = $acf_fields['cta_section']['text'];
			$signUpdBtn  = $acf_fields['cta_section']['button'];
			if ( ! empty( $signUpdText ) && ! empty( $signUpdBtn ) ) :
				?>
				<div class="cta-full-single cta-orange">
					<span><?php echo $signUpdText; ?></span>
					<?php
					if ( ! empty( $signUpdBtn ) ) {
						$link_target = '';
						if ( '_blank' === $acf_fields['cta_section']['button']['target'] ) {
							$link_target = ' target="_blank" rel="noopener"';
						}
						?>
						<a href="<?php echo esc_url( $acf_fields['cta_section']['button']['url'] ); ?>" title="<?php echo esc_attr( $acf_fields['cta_section']['button']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $acf_fields['cta_section']['button']['title']; ?></a>
						<?php
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<script>
function plateform_inaction() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/video/youtube-demo/youtube-demo.js?<?php echo $theme_version; ?>', 'BODY', 'plateform_inaction', function () {
		yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/video-pop.js?<?php echo $theme_version; ?>', 'BODY', 'video-pop', function () {
		});
	});
}
</script>
