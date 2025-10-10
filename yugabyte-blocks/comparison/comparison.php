<?php
/**
 * Comparison Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-comparison-section yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$card_group_a  = $acf_fields['card_one'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
$fixedCard     = '';
if ( ! empty( $acf_fields['fixed_card_4'] ) ) {
	$fixedCard = $acf_fields['fixed_card_4'];
} elseif ( ! empty( $acf_fields['fixed_card_3'] ) ) {
	$fixedCard = $acf_fields['fixed_card_3'];
} elseif ( ! empty( $acf_fields['fixed_card_2'] ) ) {
	$fixedCard = $acf_fields['fixed_card_2'];
}
?>
<svg style="display:none;">
<style>
<?php
require 'comparison.css';
if ( 'ja' === YUGABYTE_CURRENT_LANGUAGE ) {
	require 'comparison-ja.css';
}
?>
</style>
</svg>
<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="comparison">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['comparison_heading']; ?></h2>
		</div>
		<div class="yb-comparison-groups" data-fixed="<?php echo $fixedCard; ?>">
			<div class="yb-comparison-group group-a">
				<?php
				$value = 0;
				foreach ( $card_group_a as $card_a ) :
					if ( $card_a ) :
						++$value;
						?>
						<div class="<?php echo ( $value !== (int) $fixedCard ) ? 'item' : 'item fixed-item'; ?>">
							<div class="yb-compare-title"><?php echo $card_a['compare_title']; ?></div>
							<div class="yb-compare-points">
								<?php
								foreach ( $card_a['compare_points'] as $point ) :
									if ( $point ) :
										$class_name = 'yb-compare-point';
										if ( 1 === (int) $point['check'] ) {
											$class_name .= ' checked';
										}
										?>
										<div class="<?php echo esc_attr( $class_name ); ?>"><?php echo $point['point']; ?></div>
										<?php
									endif;
								endforeach;
								?>
							</div>
						</div>
						<?php
					endif;
				endforeach;
				?>
			</div>
			<div class="yb-comparison-group group-b"></div>
		</div>
		<div class="cta-full-single cta-purple">
			<span><?php echo $acf_fields['cta_section']['text']; ?></span>
			<div>
				<?php
				if ( ! empty( $acf_fields['cta_section']['ctas'] ) ) {
					foreach ( $acf_fields['cta_section']['ctas'] as $ctas ) {
						$link_target = '';
						if ( $ctas['button'] && '_blank' === $ctas['button']['target'] ) {
							$link_target = ' target="_blank" rel="noopener"';
						}
						if ( ! empty( $ctas ) && ! empty( $ctas['button'] ) ) {
							?>
							<a href="<?php echo esc_url( $ctas['button']['url'] ); ?>" title="<?php echo esc_attr( $ctas['button']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $ctas['button']['title']; ?></a>
							<?php
						}
					}
				}
				?>
			</div>
		</div>
	</div>
</div>

<script>
function comparison() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/comparison/comparison.js?<?php echo $theme_version; ?>', 'BODY','comparison');
}
</script>
