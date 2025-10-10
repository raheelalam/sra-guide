<?php
/**
 * FAQ Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-key-concepts-section yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}
$fields_data   = $block['data'];
$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];


?>
<svg style="display:none;">
	<style> <?php require 'key-concepts.css'; ?></style>
</svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="key_concepts">
	<div class="container">

	<?php if ( ! empty( $acf_fields['kc_heading'] ) ) : ?>
		<div class="section-head">
		<h2><?php echo esc_html( $acf_fields['kc_heading'] ); ?></h2>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $acf_fields['kc_points'] ) ) : ?>
		<div class="key-concepts-items">
		<?php
		foreach ( $acf_fields['kc_points'] as $key_concepts ) :
			$link      = $key_concepts['kc_bullet'];
			$link_desc = $key_concepts['kc_points_desc'];

			if ( ! empty( $link_desc ) || ! empty( $link ) ) :
				?>
			<div class="key-concepts-item">
				<?php
				if ( ! empty( $link ) ) :
					$link_target = ( '_blank' === $link['target'] ) ? ' target="_blank" rel="noopener"' : '';
					?>

				<a href="<?php echo esc_url( $link['url'] ); ?>"
					title="<?php echo esc_attr( $link['title'] ); ?>"
					<?php echo $link_target; ?>>
					<?php echo esc_html( $link['title'] ); ?>
					<?php if ( ! empty( $link_desc ) ) : ?>
						<div class="desc">
						<?php echo esc_html( $link_desc ); ?>
						</div>
					<?php endif; ?>
					</a>
				<?php endif; ?>
			</div>
				<?php
			endif;
		endforeach;
		?>
		</div>
	<?php endif; ?>
	</div>
</div>
