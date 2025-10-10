<?php
/**
 * Careers Benefits Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-career-benefits yb-sec' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
?>
<svg style="display:none;">
<style>
<?php require 'career-benefits.css'; ?>
</style>
</svg>

<section class="career-benefits <?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['heading']; ?></h2>
		</div>
		<?php

		if ( isset( $acf_fields['benefits'] ) && ! empty( $acf_fields['benefits'] ) ) {
			echo '<div class="points">';
			foreach ( $acf_fields['benefits'] as $benefits ) {
				echo '<div class="point">' . $benefits['benefit'] . '</div>';
			}
			echo '</div>';
		}

		?>
		</div>
</section>
