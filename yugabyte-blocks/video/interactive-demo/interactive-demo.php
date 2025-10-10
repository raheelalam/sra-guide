<?php
/**
 * Interactive Demo Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
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
?>
<svg style="display:none;">
<style>
<?php
require 'interactive-demo.css';
if ( 'ja' === YUGABYTE_CURRENT_LANGUAGE ) {
	require 'interactive-demo-ja.css';
}
?>
</style>
</svg>
<section class="<?php echo esc_attr( $class_name ); ?>" data-lazy="plateform_inaction">
	<div class="container">
		<div class="section-head">
			<h2 data-mobile="<?php echo $acf_fields['video_section']['pin_heading']; ?>" data-desktop="<?php echo $acf_fields['interactive_demo']['id_heading']; ?>"><?php echo $acf_fields['interactive_demo']['id_heading']; ?></h2>
		</div>
		<div class="section-copy">
			<?php
			$show_Play = $acf_fields['video_section']['show_play_icon'];
			$vid_ID    = $acf_fields['video_section']['video_id'];
			$vid_img   = $acf_fields['video_section']['video_thumb'];
			$data_vid  = 'data-vid="' . $vid_ID . '"';
			if ( ! empty( $vid_img ) && ! empty( $vid_ID ) ) :
				$playIcon = '';
				if ( 'true' === $show_Play ) {
					$playIcon = ' data-play="true"';
				}
				?>
				<div class="yb-inaction-inner for-mobile">
					<div class="yb-popup-vid" <?php echo $data_vid; ?><?php echo $playIcon; ?>>
						<div class="yb-popup-vid-thumb">
							<img <?php echo $data_pre; ?>src="<?php echo $vid_img['url']; ?>" alt="<?php echo $vid_img['alt']; ?>" title="<?php echo $vid_img['title']; ?>" width="<?php echo $vid_img['width']; ?>" height="<?php echo $vid_img['height']; ?>">
						</div>
					</div>
				</div>
				<?php
			elseif ( ! empty( $vid_ID ) ) :
				?>
				<div class="yb-inaction-inner for-mobile">
					<iframe width="560" height="315" data-src="https://www.youtube.com/embed/<?php echo $acf_fields['video_section']['video_id']; ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen title="<?php echo $acf_fields['pin_heading']; ?>"></iframe>
				</div>
				<?php
			endif;

			if ( 'Yes' === $acf_fields['show_interactive_demo'] ) :
				$interactive_demo         = $acf_fields['interactive_demo'];
				$interactive_demo_content = $interactive_demo['id_content_area'];
				?>
				<div class="yb-inaction-inner for-desktop">
					<div class="demo-section">
						<iframe width="560" height="315" data-src="<?php echo $interactive_demo['demo_url']; ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen title="<?php echo $acf_fields['video_section']['pin_heading']; ?>"></iframe>
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
			<?php endif; ?>

			<div class="cta-full-single cta-orange">
				<span><?php echo $acf_fields['cta_section']['text']; ?></span>
				<?php
				if ( ! empty( $acf_fields['cta_section']['button'] ) ) {
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
		</div>
	</div>
</section>

<script>
function plateform_inaction(){
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/video/interactive-demo/interactive-demo.js?<?php echo $theme_version; ?>', 'BODY','plateform_inaction', function () {
		yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/video-pop.js?<?php echo $theme_version; ?>', 'BODY','video-pop', function () {});
	});
}
</script>
