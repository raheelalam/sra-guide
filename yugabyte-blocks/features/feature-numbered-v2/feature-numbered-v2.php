<?php
/**
 * Feature Numbered V2 Block Template.
 *
 * @param array  $block           The block settings and attributes.
 * @param string $content         The block inner HTML (empty).
 * @param bool   $is_preview True During backend preview render.
 * @param int    $post_id         The post ID the block is rendering content against.
 * @param array  $context         The context provided to the block by the post or it's parent block.
 */

$class_name  = 'yugabyte-feature-number-v2-section yb-sec come-out';
$fields_data = $block['data'];

if ( ! isset( $block['className'] )
	|| false === strpos( $block['className'], 'repeated-block' )
) :
	?>
	<svg style="display:none;"><style><?php require 'feature-numbered-v2.css'; ?></style></svg>
	<?php
endif;

if ( isset( $fields_data['theme_style'] ) && ! empty( $fields_data['theme_style'] ) ) {
	$class_name .= ' section-bg-' . $fields_data['theme_style'];
}

if ( isset( $fields_data['section_class'] ) && ! empty( $fields_data['section_class'] ) ) {
	$class_name .= ' ' . $fields_data['section_class'];
}

$video_url = '';
if ( isset( $fields_data['fn_animation_video'] ) && ! empty( $fields_data['fn_animation_video'] ) ) {
	$video_url = wp_get_attachment_url( $fields_data['fn_animation_video'] );
}
?>
<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
			<div class="section-head">
				<h2>
					<?php
					echo esc_html( $fields_data['fn_heading'] );
					if ( ! empty( $video_url ) ) :
						?>
						<span class="video-text">
							<?php echo esc_html( $fields_data['fn_heading_ani'] ); ?>
							<video autoplay muted loop playsinline><source src="<?php echo esc_url( $video_url ); ?>"></video>
						</span>
					<?php endif; ?>
				</h2>
			</div>
			<?php

			if ( isset( $fields_data['fn_cards'] ) && 0 < $fields_data['fn_cards'] ) {
				$total_features = '';
				if ( 3 === $fields_data['fn_cards'] ) {
					$total_features = ' three-childs';
				}
				?>

				<div class="yb-features-items<?php echo esc_attr( $total_features ); ?>">
					<?php
					for ( $i = 0; $i < $fields_data['fn_cards']; ++$i ) :
						if (
							! isset(
								$fields_data[ 'fn_cards_' . $i . '_feature_title' ]
							)
							|| empty( $fields_data[ 'fn_cards_' . $i . '_feature_title' ] )
						) {
							continue;
						}
						$feature_number = $i + 1;

						$feature_url = '';
						if ( ! empty( $fields_data[ 'fn_cards_' . $i . '_url' ] ) ) {
							$feature_url = $fields_data[ 'fn_cards_' . $i . '_url' ];
						}
						?>

						<div class="yb-feature-item">
							<div class="feature-numbers"><?php printf( '%02d', $feature_number ); ?></div>
							<div class="feature-title">
								<?php
								if ( isset( $fields_data[ 'fn_cards_' . $i . '_url' ] ) && ! empty( $fields_data[ 'fn_cards_' . $i . '_url' ] ) ) :
									$link_target = '';
									if ( $fields_data[ 'fn_cards_' . $i . '_new_window' ] ) {
										$link_target = 'target="_blank" rel="noopener"';
									}
									?>
									<a href="<?php echo esc_url( $fields_data[ 'fn_cards_' . $i . '_url' ] ); ?>" <?php echo $link_target; ?>>
										<?php echo $fields_data[ 'fn_cards_' . $i . '_feature_title' ]; ?>
									</a>
									<?php
								else :
									echo $fields_data[ 'fn_cards_' . $i . '_feature_title' ];
								endif;
								?>
							</div>
						</div>
					<?php endfor; ?>
				</div>

				<?php
			}

			if ( ! empty( $fields_data['bottom_text'] ) ) {
				?>

				<div class="feature-details">
					<div class="section-head">
						<?php if ( ! empty( $fields_data['bottom_heading'] ) ) : ?>
							<h2><?php echo esc_html( $fields_data['bottom_heading'] ); ?></h2>
						<?php endif; ?>
					</div>
					<?php echo wpautop( $fields_data['bottom_text'] ); ?>
				</div>

				<?php
			}
			?>
	</div>
</div>
