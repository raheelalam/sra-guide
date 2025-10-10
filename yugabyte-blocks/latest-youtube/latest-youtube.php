<?php
/**
 * Latest Youtube Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-latest-youtube yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];

?>
<svg style="display:none;"><style>
	<?php echo require 'latest-youtube.css'; ?>
</style></svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="latest_youtube">
	<div class="container">

	<div class="section-head">
	<?php
	if ( ! empty( $acf_fields['heading'] ) ) {
		echo '<h2>' . $acf_fields['heading'] . '</h2>';
	}

		$link = $acf_fields['cta'];
	if ( ! empty( $link ) ) {
		$link_target = '';
		if ( '_blank' === $link['target'] ) {
			$link_target = 'target="_blank" rel="noopener"';
		}
		echo '<a class="yb--link-black" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '" ' . $link_target . '>' . $link['title'] . '</a>';
	}
	?>
	</div>

	<div class="yb-latest-youtube-items">
	<?php
		$youtube_section = get_option( 'yugabyte_devhub_youtube_section', '' );
	if ( ! empty( $youtube_section ) ) {
		echo $youtube_section;
	}
	?>
	</div>

	</div>
</div>

<script>
function latest_youtube() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/latest-youtube/latest-youtube.js?<?php echo $theme_version; ?>', 'BODY','latest-youtube', function () {
		yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/video-pop.js?<?php echo $theme_version; ?>', 'BODY','video-pop', function () {});
	});
}
</script>
