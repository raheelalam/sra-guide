<?php
/**
 * Popup Cards Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-popup-card yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}
$fields_data   = $block['data'];
$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
$data_pre      = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}
$pagetheme = 'black';
if ( ! empty( $fields_data['theme_style'] ) ) {
	if ( 'white' !== $fields_data['theme_style'] ) {
		$pagetheme = 'white';
	}
}
?>
<svg style="display:none;">
	<style>
		<?php echo require 'popup-card.css'; ?>
	</style>
</svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="popup_card">
	<div class="container">

		<div class="section-head">
			<?php
			if ( ! empty( $acf_fields['popup_cards_heading'] ) ) {
				echo '<h2>' . $acf_fields['popup_cards_heading'] . '</h2>';
			}
			?>
		</div>

		<?php
		if ( 0 < $fields_data['popup_cards'] ) :
			?>
			<div class="yb-popup-card-items">
			<?php
			for ( $i = 0; $i < $fields_data['popup_cards']; ++$i ) {

				if ( ! isset( $fields_data[ 'popup_cards_' . $i . '_popup_cards_title' ], $fields_data[ 'popup_cards_' . $i . '_popup_cards_image' ] ) ) {
					continue;
				}

				$popup_url = '';
				if ( ! empty( $fields_data[ 'popup_cards_' . $i . '_popup_cards_url' ] ) ) {
					$popup_url = 'data-popup="' . $fields_data[ 'popup_cards_' . $i . '_popup_cards_url' ] . '"';
				}
				?>
				<div class="yb-popup-card-item" <?php echo $popup_url; ?> >
					<?php
					$image_id    = $fields_data[ 'popup_cards_' . $i . '_popup_cards_image' ];
					$image_data  = wp_get_attachment_image_src( $image_id, 'full' );
					$alt_text    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
					$image_post  = get_post( $image_id );
					$image_title = $image_post->post_title;
					?>
					<div class="yt-thumb">
						<?php
						if ( ! empty( $image_id ) ) {
							echo '<img ' . $data_pre . 'src="' . $image_data['0'] . '" alt="' . $alt_text . '" title="' . $image_title . '" width="' . $image_data['1'] . '" height="' . $image_data['2'] . '">';
						}
						?>
					</div>

					<?php
					if ( isset( $fields_data[ 'popup_cards_' . $i . '_popup_cards_title' ] ) && ! empty( $fields_data[ 'popup_cards_' . $i . '_popup_cards_title' ] )
					) {
						?>
						<span><?php echo $fields_data[ 'popup_cards_' . $i . '_popup_cards_title' ]; ?></span>
					<?php } ?>
				</div>
			<?php } ?>
			</div>
			<?php
		endif;
		?>
		<div class="cta-area">
			<?php
			if ( ! empty( $acf_fields['popup_card_cta'] ) && isset( $acf_fields['popup_card_cta'] ) ) {
				$link      = $acf_fields['popup_card_cta'];
				$btn_theme = 'yb--button-orange';
				if ( ! empty( $acf_fields['cta_theme'] ) ) {
					$btn_theme = $acf_fields['cta_theme'];
					if ( 'orange-button' !== $btn_theme ) {
						$btn_theme = 'yb--link-' . $pagetheme . ' cta-button-small';
					} else {
						$btn_theme = 'yb--button-orange';
					}
				}

				$link_target = '';
				if ( '_blank' === $link['target'] ) {
					$link_target = ' target="_blank" rel="noopener"';
				}

				echo '<a class="' . $btn_theme . '" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '>' . $link['title'] . '</a>';
			}
			?>
		</div>

	</div>
</div>

<script>
	function popup_card() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/popup-card/popup-card.js?1<?php echo $theme_version . time(); ?>', 'BODY', 'popup_card');
	}
</script>
