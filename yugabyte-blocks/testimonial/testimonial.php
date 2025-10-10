<?php
/**
 * Testimonial Section Block Template.
 *
 * @param array  $block           The block settings and attributes.
 * @param string $content         The block inner HTML (empty).
 * @param bool   $is_preview True During backend preview render.
 * @param int    $post_id         The post ID the block is rendering content against.
 * @param array  $context         The context provided to the block by the post or it's parent block.
 */

$class_name    = 'yugabyte-testimonial-section yb-sec come-out';
$fields_data   = $block['data'];
$theme_version = yugabyte_theme_version();
$data_pre      = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}
if ( isset( $fields_data['theme_style'] ) && ! empty( $fields_data['theme_style'] ) ) {
	$class_name .= ' section-bg-' . $fields_data['theme_style'];
}

$sliderCount = 1;
if ( $fields_data['quotes'] ) {
	$sliderCount = ceil( $fields_data['quotes'] / 2 );
}
?>

<svg style="display:none;"><style><?php require 'testimonial.css'; ?>
.testimonial-wrap .owl-nav button + button::before {
		content:"1/<?php echo $sliderCount; ?>";
}</style></svg>

<section class="testimonial <?php echo esc_attr( $class_name ); ?>" data-lazy="testimonials">
	<div class="container">
		<div class="section-head">
			<h2><?php echo str_replace( $fields_data['colored_text'], "<span class='primary-orange'>" . $fields_data['colored_text'] . '</span>', $fields_data['heading'] ); ?></h2>
		</div>
		<div class="testimonial-wrap owl-carousel">
			<?php
			if ( 0 < $fields_data['quotes'] ) {
				for ( $i = 0; $i <= $fields_data['quotes']; ++$i ) :
					if (
						! isset(
							$fields_data[ 'quotes_' . $i . '_author_name' ],
							$fields_data[ 'quotes_' . $i . '_author_quote' ],
							$fields_data[ 'quotes_' . $i . '_author_designation' ],
							$fields_data[ 'quotes_' . $i . '_author_image' ]
						)
						|| empty( $fields_data[ 'quotes_' . $i . '_author_name' ] )
						|| empty( $fields_data[ 'quotes_' . $i . '_author_quote' ] )
						|| empty( $fields_data[ 'quotes_' . $i . '_author_designation' ] )
						|| empty( $fields_data[ 'quotes_' . $i . '_author_image' ] )
					) {
						continue;
					}

					$author_image = $fields_data[ 'quotes_' . $i . '_author_image' ];
					$image        = wp_get_attachment_metadata( $author_image );
					$image_title  = get_the_title( $author_image );

					$link     = '';
					$withlink = '';
					if ( isset( $fields_data[ 'quotes_' . $i . '_link' ] ) && ! empty( $fields_data[ 'quotes_' . $i . '_link' ] ) ) {
						$link_title = '';
						if ( isset( $fields_data[ 'quotes_' . $i . '_link_title' ] ) ) {
							$link_title = $fields_data[ 'quotes_' . $i . '_link_title' ];
						}

						$target = '';
						if ( isset( $fields_data[ 'quotes_' . $i . '_new_tab' ] )
							&& 'yes' === $fields_data[ 'quotes_' . $i . '_new_tab' ]
						) {
							$target = ' target="_blank" rel="noopener"';
						}

						$link     = '<a href="' . esc_url( $fields_data[ 'quotes_' . $i . '_link' ] ) . '" title="' . esc_attr( $link_title ) . '"' . $target . '>' . $fields_data[ 'quotes_' . $i . '_author_name' ] . 's details</a>';
						$withlink = ' with-link';
					}
					?>

					<div class="quote<?php echo esc_attr( $withlink ); ?>">
						<div class="img">
							<img <?php echo $data_pre; ?>src="<?php echo esc_attr( '/wp-content/uploads/' . $image['file'] ); ?>" alt="<?php echo esc_attr( $image_title ); ?>" title="<?php echo esc_attr( $image_title ); ?>" width="<?php echo esc_attr( $image['width'] ); ?>" height="<?php echo esc_attr( $image['height'] ); ?>">
						</div>
						<div class="quote-data">
							<q><?php echo esc_html( $fields_data[ 'quotes_' . $i . '_author_quote' ] ); ?></q>
							<div class="quote-author">
								<?php echo esc_html( $fields_data[ 'quotes_' . $i . '_author_name' ] ); ?>
								<div class="quote-author-desg"><?php echo esc_html( $fields_data[ 'quotes_' . $i . '_author_designation' ] ); ?></div>
							</div>
							<?php echo $link; ?>
						</div>
					</div>
					<?php
				endfor;
			}
			?>
		</div>
	</div>
</section>
<script>
function testimonials() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/testimonial/testimonial.js?<?php echo $theme_version; ?>', 'BODY','testimonials');
}
</script>
