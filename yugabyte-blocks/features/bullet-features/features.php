<?php
/**
 * Bullet Features Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True During backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$class_name = 'yugabyte-bullet-features-section yb-sec come-out';

$fields_data = $block['data'];
$page_theme  = '';
if ( ! empty( $fields_data['extra_settings'] ) && is_array( $fields_data['extra_settings'] ) ) {
	foreach ( $fields_data['extra_settings'] as $setting ) {
		$class_name .= ' style-' . $setting;
		$page_theme  = ( 'pricing-area' === $setting ) ? 'have-pricing-area' : '';
	}
}
$data_pre = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}

if ( ! isset( $block['className'] ) || false === strpos( $block['className'], 'repeated-block' ) ) : ?>
	<svg style="display:none;">
		<style>
			<?php require 'features.css'; ?>
		</style>
	</svg>
	<?php
endif;

if ( isset( $fields_data['theme_style'] ) && ! empty( $fields_data['theme_style'] ) ) {
	$class_name .= ' section-bg-' . $fields_data['theme_style'];
}

$heading_tag = 'h2';
$wire_style  = '';
if ( isset( $fields_data['inline_heading'] ) && 1 === (int) $fields_data['inline_heading'] ) {
	$heading_tag = 'p';
	$wire_style  = ' wire-style';
}
?>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container<?php echo esc_attr( $wire_style ); ?>">
		<div class="section-head">
			<?php
			if ( isset( $fields_data['features_heading'] ) && ! empty( $fields_data['features_heading'] ) ) {
				echo '<' . $heading_tag . '>' . $fields_data['features_heading'] . '</' . $heading_tag . '>';
			}
			?>
		</div>

		<?php if ( ! empty( $fields_data['heading_sub'] ) ) : ?>
			<div class="section-copy">
				<div class="copy-details">
				<?php echo wpautop( $fields_data['heading_sub'] ); ?>
				</div>
			</div>
			<?php
		endif;

		if ( 0 < $fields_data['feature_cards'] ) :

			if ( 'have-pricing-area' !== $page_theme ) :
				?>
			<div class="yb-b-features-items">
				<?php
				for ( $i = 0; $i < $fields_data['feature_cards']; ++$i ) {
					if ( ! isset( $fields_data[ 'feature_cards_' . $i . '_feature_title' ] ) || empty( $fields_data[ 'feature_cards_' . $i . '_feature_title' ] ) ) {
						continue;
					}
					?>
					<div class="yb-b-feature-item ">
					<?php
					if ( isset( $fields_data[ 'feature_cards_' . $i . '_feature_logo' ] ) ) {
						$image_id    = $fields_data[ 'feature_cards_' . $i . '_feature_logo' ];
						$image_data  = wp_get_attachment_image_src( $image_id, 'full' );
						$alt_text    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
						$image_post  = get_post( $image_id );
						$image_title = $image_post->post_title;
						if ( ! empty( $image_id ) ) {
							?>
							<div class="feature-logo">
								<?php echo '<img ' . $data_pre . 'src="' . $image_data['0'] . '" alt="' . $alt_text . '" title="' . $image_title . '" width="' . $image_data['1'] . '" height="' . $image_data['2'] . '">'; ?>
							</div>
							<?php
						}
					}
					?>
						<div class="feature-title"><?php echo $fields_data[ 'feature_cards_' . $i . '_feature_title' ]; ?></div>
						<?php if ( ! empty( $fields_data[ 'feature_cards_' . $i . '_feature_content' ] ) ) { ?>
						<div class="feature-content"> <?php echo wpautop( $fields_data[ 'feature_cards_' . $i . '_feature_content' ] ); ?></div>
					<?php } else { ?>
						<div class="feature-summary"> <?php echo $fields_data[ 'feature_cards_' . $i . '_feature_summary' ]; ?></div>
					<?php } ?>
					</div>
				<?php } ?>
			</div>
			<?php else : ?>
			<div class="yb-b-features-items">
				<?php
				for ( $i = 0; $i < $fields_data['feature_cards']; ++$i ) {
					if ( ! isset( $fields_data[ 'feature_cards_' . $i . '_feature_title' ], $fields_data[ 'feature_cards_' . $i . '_feature_summary' ] ) ) {
						continue;
					}

					if ( empty( $fields_data[ 'feature_cards_' . $i . '_feature_title' ] ) || empty( $fields_data[ 'feature_cards_' . $i . '_feature_summary' ] ) ) {
						continue;
					}

					$pricing_area     = '';
					$pricing_sub_text = '';
					$pricing_text     = '';
					if ( isset( $fields_data[ 'feature_cards_' . $i . '_pricing_area_price' ] )
					&& ! empty( $fields_data[ 'feature_cards_' . $i . '_pricing_area_price' ] )
					) {
						$pricing_area = ' pricing-area';
						$pricing_text = $fields_data[ 'feature_cards_' . $i . '_pricing_area_price' ];

						if ( isset( $fields_data[ 'feature_cards_' . $i . '_pricing_area_price_subs' ] )
						&& ! empty( $fields_data[ 'feature_cards_' . $i . '_pricing_area_price_subs' ] )
						) {
							$pricing_sub_text = $fields_data[ 'feature_cards_' . $i . '_pricing_area_price_subs' ];
						}
					}
					?>

					<div class="yb-b-feature-item<?php echo $pricing_area; ?>">
						<div class="feature-title"><?php echo $fields_data[ 'feature_cards_' . $i . '_feature_title' ]; ?></div>
						<div class="feature-summary">
						<?php
						echo $fields_data[ 'feature_cards_' . $i . '_feature_summary' ];
						if ( ! empty( $pricing_text ) ) :
							?>
							<div class="feature-price">
								<?php
								echo $pricing_text;
								if ( ! empty( $pricing_sub_text ) ) :
									?>
									<div class="feature-price-sub"><?php echo $pricing_sub_text; ?></div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						</div>
						<?php
						if ( isset( $fields_data[ 'feature_cards_' . $i . '_feature_logo' ] ) ) {
							$image_id    = $fields_data[ 'feature_cards_' . $i . '_feature_logo' ];
							$image_data  = wp_get_attachment_image_src( $image_id, 'full' );
							$alt_text    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
							$image_post  = get_post( $image_id );
							$image_title = $image_post->post_title;
							?>
							<div class="feature-logo">
								<?php echo '<img ' . $data_pre . 'src="' . $image_data['0'] . '" alt="' . $alt_text . '" title="' . $image_title . '" width="' . $image_data['1'] . '" height="' . $image_data['2'] . '">'; ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
				<?php
		endif;
		endif;

		if ( isset( $fields_data['cta'], $fields_data['cta']['url'] ) && ! empty( $fields_data['cta']['url'] ) ) {
			$external    = '';
			$link_target = '';
			if ( isset( $fields_data['cta']['target'] ) && '_blank' === $fields_data['cta']['target'] ) {
				$external    = ' external-icon';
				$link_target = ' target="_blank" rel="noopener"';
			}
			?>

			<div class="cta text-center">
				<a class="yb--link-black cta-button-small<?php echo $external; ?>" href="<?php echo esc_url( $fields_data['cta']['url'] ); ?>" title="<?php echo esc_attr( $fields_data['cta']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $fields_data['cta']['title']; ?></a>
			</div>
		<?php } ?>
	</div>
</div>
