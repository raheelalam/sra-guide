<?php
/**
 * Video Aside Content Section Block Template.
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

$section_title = '';
if ( '' !== $acf_fields['video_section']['pin_heading'] ) {
	$section_title = $acf_fields['video_section']['pin_heading'];
}
$detail_head     = $acf_fields['video_section']['vc_content']['vc_details_head'];
$detail_bottom   = $acf_fields['video_section']['vc_content']['vc_details_bottom'];
$container_class = '';
if ( ! empty( $detail_head ) && ! empty( $detail_bottom ) ) {
	$container_class = 'container-inner';
}

$desktop_video = '';
$desktop_video = 'for-desktop';
?>

<svg style="display:none;">
	<style>
		<?php require 'aside-content.css'; ?>
	</style>
</svg>
<section class="<?php echo esc_attr( $class_name ); ?>" data-lazy="plateform_inaction" id="interactive-demo">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $section_title; ?></h2>
		</div>
		<div class="section-copy">
			<?php
			echo ( ! empty( $container_class ) ) ? '<div class="container-inner">' : '';

			$show_Play      = $acf_fields['video_section']['show_play_icon'];
			$vid_ID         = $acf_fields['video_section']['video_id'];
			$vid_img        = $acf_fields['video_section']['video_thumb'];
			$video_autoplay = $acf_fields['video_section']['video_autoplay'];

			$data_vid = 'data-vid="' . $vid_ID . '"';
			$playIcon = '';

			if ( 1 === (int) $show_Play ) {
				$playIcon = ' data-play="true"';
			}

			if ( ! empty( $vid_img ) && ! empty( $vid_ID ) ) :
				?>
				<div class="yb-inaction-inner for-mobile popup-area video-thumbnail for-desktop">
					<div class="yb-popup-vid" <?php echo $data_vid; ?><?php echo $playIcon; ?> data-autoplay='<?php echo $video_autoplay; ?>'>
						<div class="yb-popup-vid-thumb">
							<img <?php echo $data_pre; ?>src="<?php echo $vid_img['url']; ?>" alt="<?php echo $vid_img['alt']; ?>" title="<?php echo $vid_img['title']; ?>" width="<?php echo $vid_img['width']; ?>" height="<?php echo $vid_img['height']; ?>">
						</div>
					</div>
				</div>
				<?php
			elseif ( ! empty( $vid_ID ) ) :
				?>
				<div class="yb-inaction-inner for-mobile popup-area no-thumbnail <?php echo $desktop_video; ?>" data-autoplay="<?php echo $video_autoplay; ?>" <?php echo $data_vid; ?>>
					<iframe width="560" height="315" data-src="https://www.youtube.com/embed/<?php echo $acf_fields['video_section']['video_id']; ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen title="<?php echo $acf_fields['video_section']['pin_heading']; ?>"></iframe>
				</div>
				<?php
			endif;

			if ( ! empty( $detail_head ) && ! empty( $detail_bottom ) ) :
				?>
				<div class="content-area">
					<div class="top-content">
						<?php echo $detail_head; ?>
					</div>
					<div class="bottom-content">
						<?php echo $detail_bottom; ?>
					</div>
				</div>
				<?php
			endif;

			echo ( ! empty( $container_class ) ) ? '</div>' : '';
			?>
		</div>
	</div>
</section>

<script>
function plateform_inaction() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/video/aside-content/aside-content.js?<?php echo $theme_version; ?>', 'BODY', 'plateform_inaction', function () {
		yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/video-pop.js?<?php echo $theme_version; ?>', 'BODY', 'video-pop', function () {
		});
	});
}
</script>
