<?php
/**
 * Built & Run Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-built-n-run yb-sec come-out' );
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
	<?php require 'built-n-run.css'; ?>
</style></svg>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<?php
	if ( ! empty( $acf_fields['inline_heading'] ) ) {
		echo '<div class="container"><div class="section-head"><p>' . $acf_fields['inline_heading'] . '</p></div></div>';
	}
	?>
	<div class="container">
		<div class="section-copy">
		<?php

		if ( ! empty( $acf_fields['heading'] ) ) {
			echo '<h2>' . $acf_fields['heading'] . '</h2>';
		}

		if ( ! empty( $acf_fields['content'] ) ) {
			echo '<div class="details">' . $acf_fields['content'] . '</div>';
		}

		$link = $acf_fields['cta'];
		if ( ! empty( $link ) ) {
			$link_target = '';
			if ( '_blank' === $link['target'] ) {
				$link_target = ' target="_blank" rel="noopener"';
			}
			echo '<a class="yb--link-black cta-button-small" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '>' . $link['title'] . '</a>';
		}
		?>
		</div>
		<div class="section-image">
		<?php

		$image = $acf_fields['image'];
		if ( ! empty( $image ) ) {
			echo '<img ' . $data_pre . 'src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '">';
		}
		?>
		</div>
	</div>
</div>
