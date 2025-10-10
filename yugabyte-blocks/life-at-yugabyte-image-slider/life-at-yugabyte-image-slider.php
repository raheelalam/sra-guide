<?php
/**
 * Life at Yugabyte Image Slider Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'life-at-yugabyte-image-slider yb-sec section-bg-dark come-out' );
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
<svg style="display:none;"><style>
	<?php require 'life-at-yugabyte-image-slider.css'; ?>
</style></svg>

<section class="<?php echo esc_attr( $class_name ); ?>" data-lazy="life_at_yugabyte_image_slider">
	<div class="container">

		<div class="section-head">
			<p><?php echo $acf_fields['heading']; ?></p>
		</div>

	<div class="lay-slider owl-carousel">
	<?php
	if ( isset( $acf_fields['images_slider'] ) ) {
		foreach ( $acf_fields['images_slider'] as $slider_image ) {
			$image     = $slider_image['image'];
			$maxHeight = 480;
			if ( isset( $image['height'] ) ) {
				$height = $image['height'];
			}
			$newHeight = min( $height, $maxHeight );
			$newWidth  = intval( $newHeight * $image['width'] / $height );

			echo '<div class="item">
            <img ' . $data_pre . 'src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" width="' . $newWidth . '" height="' . $newHeight . '">
          </div>';
		}
	}
	?>
	</div>

	</div>
</section>

<script>
	function life_at_yugabyte_image_slider() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/life-at-yugabyte-image-slider/life-at-yugabyte-image-slider.js?<?php echo $theme_version; ?>', 'BODY','life-at-yugabyte-image-slider')
	}
</script>
