<?php
/**
 * Book Slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-book-slider-section yb-sec come-out' );
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
<?php
require 'book-slider.css';
if ( 'ja' === YUGABYTE_CURRENT_LANGUAGE ) {
	require 'book-slider-ja.css';
}
?>
</style>
</svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="book_slider">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['book_slider_heading']; ?></h2>
		</div>
		<div class="yb-book-slider-items owl-carousel">
			<?php
			foreach ( $acf_fields['book_slider_cards'] as $book_slider_card ) {
				if ( $book_slider_card ) {
					?>
				<div class="yb-book-slider-item item">
					<div class="yb-book-slide-left">
						<div class="yb-book-slide-title"><?php echo $book_slider_card['slider_title']; ?></div>
						<div class="yb-book-slide-details">
							<?php
							if ( ! empty( $book_slider_card['slider_points'] ) ) {
								echo '<div class="yb-book-slide-points">';
								foreach ( $book_slider_card['slider_points'] as $slider_point ) {
									if ( $slider_point ) {
										$checked = '';
										if ( 1 === (int) $slider_point['check'] ) {
											$checked = ' checked';
										}

										echo '<div class="yb-book-slide-point' . $checked . '">' .
											$slider_point['point'] . '
										</div>';
									}
								}
								echo '</div>';
							}
							if ( $book_slider_card['slider_subs'] ) {
								echo '<div class="yb-book-slide-subs">';
								echo $book_slider_card['slider_subs'];
								echo '</div>';
							}
							?>
						</div>
					</div>
					<div class="yb-book-slide-right">
							<?php
							if ( ! empty( $book_slider_card['slider_image'] ) ) {
								echo '<img ' . $data_pre . 'src="' . $book_slider_card['slider_image']['url'] . '" alt="' . $book_slider_card['slider_image']['alt'] . '" title="' . $book_slider_card['slider_image']['title'] . '" width="' . $book_slider_card['slider_image']['width'] . '" height="' . $book_slider_card['slider_image']['height'] . '">';
							} else {
								echo '<img ' . $data_pre . 'src="/wp-content/themes/yugabyte/assets/images/rebrand/yugabyte-logomark-orange.svg" alt="Yugabyte" title="Yugabyte" style="width:648px;height:588px">';
							}
							?>
					</div>
				</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>

<script>
function book_slider() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/book-slider/book-slider.js?1.1<?php echo $theme_version; ?>', 'BODY','book_slider');
}
</script>
