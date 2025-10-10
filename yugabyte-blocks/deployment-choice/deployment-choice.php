<?php
/**
 * Deployment Choice Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-deployment-choice yb-sec come-out ' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
?>
<svg style="display:none;">
<style>
<?php
require 'deployment-choice.css';
if ( ! empty( $acf_fields['nav_srart_color'] ) ) {
	echo '.yb-choices-mark:before{background:' . $acf_fields['nav_srart_color'] . '}';
	echo '.purple-bar{background:' . $acf_fields['nav_srart_color'] . '}';
}
if ( ! empty( $acf_fields['nav_end_color'] ) ) {
	echo '.yb-choices-mark.mark-end:before{background:' . $acf_fields['nav_end_color'] . '}';
	echo '.yb-choices-range{background:' . $acf_fields['nav_end_color'] . '}';
}
?>
</style>
</svg>
<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="deployment_choice">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['yb_dply_choice_heading']; ?></h2>
		</div>
		<div class="section-copy">
			<div class="copy-details"><?php echo $acf_fields['yb_dply_choice_subs']; ?></div>
			<div class="yb-choices-wrap active-1">
		<?php
		$card_group = $acf_fields['yb_dply_choice_cards'];
		foreach ( $card_group as $card ) {
			if ( $card ) {
				?>
			<div class="yb-choice">
		<div class="choice-before"></div>
				<div class="yb-choice-heading"><?php echo $card['title']; ?></div>
				<?php
				foreach ( $card['points'] as $pointSection ) :
					if ( $pointSection ) :
						?>
					<div class="yb-choice-part">
					<div class="yb-choice-part-heading"><?php echo $pointSection['points_title']; ?></div>
					<ul>
						<?php
						foreach ( $pointSection['compare_points'] as $point ) {
							if ( $point ) {
								?>
							<li class="<?php echo $point['bullet_color']; ?>"><?php echo $point['point']; ?></li>
								<?php
							}
						}
						?>
					</ul>
					</div>
						<?php
					endif;
				endforeach;

				if ( ! empty( $card['button'] ) ) :
					?>
				<div class="copy-card-cta">
					<?php
					$link_target = '';
					if ( '_blank' === $card['button']['target'] ) {
						$link_target = ' target="_blank" rel="noopener"';
					}
					?>
					<a class="yb--link-black" href="<?php echo esc_url( $card['button']['url'] ); ?>" title="<?php echo esc_attr( $card['button']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $card['button']['title']; ?></a>
				</div>
				<?php endif; ?>
			</div>
				<?php
			}
		}
		?>
			</div>
			<div class="yb-choices-nav">
				<div class="yb-choices-range">
					<div class="purple-bar"></div>
					<div class="bar-thumb">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="14">
							<path fill="#121017" d="m13.4 12.6 9.2-9.2A2 2 0 0 0 21.2 0H2.8a2 2 0 0 0-1.4 3.4l9.2 9.2c.8.8 2 .8 2.8 0Z"/>
						</svg>
					</div>
				</div>
				<div class="yb-choices-mark mark-start"><?php echo $acf_fields['nav_srart_text']; ?></div>
				<div class="yb-choices-mark mark-end"><?php echo $acf_fields['nav_end_text']; ?></div>
			</div>
		</div>
		<div class="cta text-center">
			<?php
			if ( ! empty( $acf_fields['cta_section']['button'] ) ) {
				$link_target = '';
				if ( '_blank' === $acf_fields['cta_section']['button']['target'] ) {
					$link_target = ' target="_blank" rel="noopener"';
				}
				?>
				<a class="yb--link-black cta-button-small" href="<?php echo esc_url( $acf_fields['cta_section']['button']['url'] ); ?>" title="<?php echo esc_attr( $acf_fields['cta_section']['button']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $acf_fields['cta_section']['button']['title']; ?></a>
			<?php } ?>
		</div>
	</div>
</div>

<script>
function deployment_choice() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/deployment-choice/deployment-choice.js?1.491<?php echo $theme_version; ?>', 'BODY','deployment-choice');
}
</script>
