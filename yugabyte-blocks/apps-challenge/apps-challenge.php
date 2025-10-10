<?php
/**
 * Apps Challenge Block Template.
 *
 * @param array  $block           The block settings and attributes.
 * @param string $content         The block inner HTML (empty).
 * @param bool   $is_preview True During backend preview render.
 * @param int    $post_id         The post ID the block is rendering content against.
 * @param array  $context         The context provided to the block by the post or it's parent block.
 */

$class_name  = 'yb-apps-challenge yb-sec come-out section-bg-dark';
$fields_data = $block['data'];
$data_pre    = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}

if ( ! isset( $block['className'] )
	|| false === strpos( $block['className'], 'repeated-block' )
) :
	?>
	<svg style="display:none;"><style><?php require 'apps-challenge.css'; ?></style></svg>
	<?php
endif;
?>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="apps-challenge-box">
			<div>
				<h2><?php echo $fields_data['ec_heading']; ?></h2>
				<div><?php echo wpautop( $fields_data['ec_details'] ); ?></div>
				<?php
				if ( isset( $fields_data['ec_link'] ) && is_array( $fields_data['ec_link'] ) ) :
					$link_target = '';
					if ( isset( $fields_data['ec_link']['target'] ) && '_blank' === $fields_data['ec_link']['target'] ) {
						$link_target = ' target="_blank" rel="noopener"';
					}
					?>
					<a class="yb--link-white cta-button-small" href="<?php echo esc_url( $fields_data['ec_link']['url'] ); ?>" title="<?php echo esc_attr( $fields_data['ec_link']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $fields_data['ec_link']['title']; ?></a>
				<?php endif; ?>
			</div>
			<div>
				<?php
				for ( $i = 0; $i < $fields_data['logos']; ++$i ) :
					$logo_url = wp_get_attachment_url( $fields_data[ 'logos_' . $i . '_logo' ] );
					if ( is_string( $logo_url ) ) {
						$logo_meta  = wp_get_attachment_metadata( $fields_data[ 'logos_' . $i . '_logo' ] );
						$logo_title = get_the_title( $fields_data[ 'logos_' . $i . '_logo' ] );
						echo '<img ' . $data_pre . 'src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $logo_title ) . '" title="' . esc_attr( $logo_title ) . '" width="' . esc_attr( $logo_meta['width'] ) . '" height="' . esc_attr( $logo_meta['height'] ) . '">';
					}
				endfor;
				?>
			</div>
		</div>
	</div>
</div>
