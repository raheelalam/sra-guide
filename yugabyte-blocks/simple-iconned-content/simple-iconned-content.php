<?php
/**
 * Simple Iconned Content Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-simple-iconned-content-section come-out yb-sec' );
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
<?php require 'simple-iconned-content.css'; ?>
</style>
</svg>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<?php
		if ( ! empty( $acf_fields['heading'] ) ) {
			echo '<div class="section-head"><h2>' . $acf_fields['heading'] . '</h2></div>';
		}

		echo '<div class="points-content">';
		$i = 0;
		foreach ( $acf_fields['content_points'] as $point ) {
			++$i;
			$image   = $point['icon'];
			$title   = $point['title'];
			$content = $point['content'];

			echo '<div class="content-point">';
			if ( ! empty( $image ) ) {
				echo '<img ' . $data_pre . 'src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '">';
			}
			echo '<div class="content-point-data">';
			if ( ! empty( $title ) ) {
				echo '<h3>';
				echo $i . '. ' . $title . '</h3>';
			}
			if ( ! empty( $content ) ) {
				echo $content;
			}
			echo '</div>';
			echo '</div>';

		}
		echo '</div>';
		?>
	</div>
</div>
