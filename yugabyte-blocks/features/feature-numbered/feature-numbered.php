<?php
/**
 * Feature Numbered Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True During backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$fields_data = $block['data'];
$class_name  = 'yugabyte-feature-number-section yb-sec come-out';
if(!empty($fields_data['features_to_top'])){
  $class_name .= ' features-to-top';
}
if ( ! empty( $fields_data['extra_settings'] ) && is_array( $fields_data['extra_settings'] ) ) {
	foreach ( $fields_data['extra_settings'] as $setting ) {
		$class_name .= ' style-' . $setting;
	}
}

if ( ! isset( $block['className'] )
	|| false === strpos( $block['className'], 'repeated-block' )
) :
	?>
	<svg style="display:none;">
		<style>
			<?php require 'feature-numbered.css'; ?>
		</style>
	</svg>
	<?php
endif;

if ( isset( $fields_data['theme_style'] ) && ! empty( $fields_data['theme_style'] ) ) {
	$class_name .= ' section-bg-' . $fields_data['theme_style'];
}
?>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<?php if ( isset( $fields_data['fn_heading'] ) && ! empty( $fields_data['fn_heading'] ) ) { ?>
			<div class="section-head <?php echo ( isset( $fields_data['inline_heading'] ) && 1 === (int) $fields_data['inline_heading'] ) ? ' inline' : ''; ?>">
				<h2><?php echo $fields_data['fn_heading']; ?></h2>
			</div>
		<?php } ?>
		<?php
		if ( ! empty( $fields_data['fn_subs'] ) ) :
			?>
			<h3 class="sub-header"><?php echo esc_html( $fields_data['fn_subs'] ); ?></h3>
			<?php
		endif;

		if ( isset( $fields_data['fn_cards'] ) && 0 < $fields_data['fn_cards'] ) {
			$total_features = '';
			if ( 3 === $fields_data['fn_cards'] ) {
				$total_features = ' three-childs';
			}
			?>

			<div class="yb-features-items<?php echo esc_attr( $total_features ); ?>">
			<?php
			for ( $i = 0; $i <= $fields_data['fn_cards']; ++$i ) :
				if (
				! isset(
					$fields_data[ 'fn_cards_' . $i . '_feature_title' ],
					$fields_data[ 'fn_cards_' . $i . '_feature_summary' ],
				)
				|| empty( $fields_data[ 'fn_cards_' . $i . '_feature_title' ] )
				|| empty( $fields_data[ 'fn_cards_' . $i . '_feature_summary' ] )
				) {
					continue;
				}

				$feature_number = $i + 1;
				?>
				<div class="yb-feature-item">
					<div class="feature-numbers"><?php printf( '%02d', $feature_number ); ?></div>
					<div class="feature-title"><?php echo $fields_data[ 'fn_cards_' . $i . '_feature_title' ]; ?></div>
					<div class="feature-summary"><?php echo $fields_data[ 'fn_cards_' . $i . '_feature_summary' ]; ?></div>
				</div>
			<?php endfor; ?>
			</div>
		<?php } ?>

		<?php
		if ( isset( $fields_data['fn_button'] ) && ! empty( $fields_data['fn_button'] ) ) {
			$link_target = '';
			if ( isset( $fields_data['fn_button']['target'] ) && '_blank' === $fields_data['fn_button']['target'] ) {
				$link_target = ' target="_blank" rel="noopener"';
			}
			?>
			<div class="cta text-center">
				<a class="yb--link-black cta-button-small" href="<?php echo esc_url( $fields_data['fn_button']['url'] ); ?>" title="<?php echo esc_attr( $fields_data['fn_button']['title'] ); ?>"<?php echo $link_target; ?>><?php echo esc_html( $fields_data['fn_button']['title'] ); ?></a>
			</div>
		<?php } ?>

		<?php if ( isset( $fields_data['fn_buttons'] ) && ! empty( $fields_data['fn_buttons'] ) ) { ?>
			<div class="cta cta-loop text-center">
			<?php
			for ( $i = 0; $i <= $fields_data['fn_buttons']; ++$i ) {
				if ( isset( $fields_data[ 'fn_buttons_' . $i . '_fn_button' ] ) && ! empty( $fields_data[ 'fn_buttons_' . $i . '_fn_button' ] ) ) {
					$inner_button = $fields_data[ 'fn_buttons_' . $i . '_fn_button' ];
					if ( isset( $inner_button ) && ! empty( $inner_button ) ) {
						$link_target = '';
						if ( isset( $inner_button['target'] ) && '_blank' === $inner_button['target'] ) {
							$link_target = ' target="_blank" rel="noopener"';
						}
						?>
					<a class="yb--link-black cta-button-small" href="<?php echo esc_url( $inner_button['url'] ); ?>" title="<?php echo esc_attr( $inner_button['title'] ); ?>"<?php echo $link_target; ?>><?php echo esc_html( $inner_button['title'] ); ?></a>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			</div>

		<?php } ?>
	</div>
</div>
