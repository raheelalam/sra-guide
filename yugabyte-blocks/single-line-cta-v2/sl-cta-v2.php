<?php
/**
 * Single Line CTA V2 Block Template.
 *
 * @param array  $block           The block settings and attributes.
 * @param string $content         The block inner HTML (empty).
 * @param bool   $is_preview True During backend preview render.
 * @param int    $post_id         The post ID the block is rendering content against.
 * @param array  $context         The context provided to the block by the post or it's parent block.
 */

$fields_data = $block['data'];
$class_name  = 'standalone-cta yb-sec come-out';

if ( isset( $fields_data['theme_style'] ) && ! empty( $fields_data['theme_style'] ) ) {
	$class_name .= ' section-bg-' . $fields_data['theme_style'];
}

if ( ! isset( $block['className'] )
	|| false === strpos( $block['className'], 'repeated-block' )
) :
	?>
	<svg style="display:none;"><style><?php require 'sl-cta-v2.css'; ?></style></svg>
	<?php
endif;
?>
<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="cta-stand-alone cta-orange">
			<div class="cta-text"><?php echo $fields_data['text']; ?></div>
			<?php
			if ( ! empty( $fields_data['button'] ) ) :
				$link_target = '';
				if ( '_blank' === $fields_data['button']['target'] ) {
					$link_target = ' target="_blank" rel="noopener"';
				}
				?>
				<div class="links">
					<a class="yb--link-white cta-button-small" href="<?php echo esc_url( $fields_data['button']['url'] ); ?>" title="<?php echo esc_attr( $fields_data['button']['title'] ); ?>"<?php echo $link_target; ?>><?php echo esc_html( $fields_data['button']['title'] ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
