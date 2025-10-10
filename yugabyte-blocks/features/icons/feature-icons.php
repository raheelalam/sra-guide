<?php
/**
 * Features Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-features-section yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields = $block_data['fields_data'];
$class_name = $block_data['classes'];
$data_pre   = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}
?>
<svg style="display:none;"><style>
	<?php require 'feature-icons.css'; ?>
</style></svg>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="section-head">
			<p><?php echo $acf_fields['features_heading']; ?></p>
		</div>

		<div class="yb-features-items">
	<?php
	foreach ( $acf_fields['feature_cards'] as $feature_card ) {
		if ( $feature_card ) {
			$thumb = $feature_card['feature_icon'];
			echo '<div class="yb-feature-item">';
			if ( ! empty( $thumb ) ) {
				echo '<img ' . $data_pre . 'src="' . $thumb['url'] . '" alt="' . $thumb['alt'] . '" title="' . $thumb['title'] . '" width="' . $thumb['width'] . '" height="' . $thumb['height'] . '">';
			}
			echo '<div class="feature-title">' . $feature_card['feature_title'] . '</div>
            <div class="feature-summary">' . $feature_card['feature_summary'] . '</div>
          </div>';
		}
	}

	?>
	</div>

	</div>
</div>
