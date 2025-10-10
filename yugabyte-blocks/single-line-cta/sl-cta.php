<?php
/**
 * Single Line CTA Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-sl-cta-section yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
?>
<svg style="display:none;"><style>
	<?php require 'sl-cta.css'; ?>
</style></svg>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="cta-full-single cta-orange">
			<span><?php echo $acf_fields['text']; ?></span>
			<?php
			if ( ! empty( $acf_fields['button'] ) ) {
				$link_target = '';
				if ( '_blank' === $acf_fields['button']['target'] ) {
					$link_target = ' target="_blank" rel="noopener"';
				}
				?>
				<a href="<?php echo esc_url( $acf_fields['button']['url'] ); ?>" title="<?php echo esc_attr( $acf_fields['button']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $acf_fields['button']['title']; ?></a>
				<?php
			}
			?>
		</div>
	</div>
</div>
