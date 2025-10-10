<?php
/**
 * Get Started Today Section Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-get-ready-section section-bg-dark yb-sec' );
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
		require 'get-started-today.css';
		if ( 'ja' === YUGABYTE_CURRENT_LANGUAGE ) {
			require 'get-started-today-ja.css';
		}
		?>
	</style>
</svg>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="section-head">
			<p><?php echo $acf_fields['gst_heading']; ?></p>
		</div>
		<div class="yb-get-ready-section-cards">
			<div class="yb-get-ready-section-card section-bg-orange">
				<div class="yb-get-ready-section-card-head">
					<div class="yb-get-ready-section-card-content">
						<div class="yb-get-ready-section-card-title">
							<?php echo $acf_fields['gst_left_side']['heading']; ?>
						</div>
						<div class="yb-get-ready-section-card-subs"><?php echo $acf_fields['gst_left_side']['description']; ?></div>
					</div>
					<div class="yb-get-ready-section-card-image">
						<img <?php echo $data_pre; ?>src="<?php echo $acf_fields['gst_left_side']['logo']['url']; ?>" alt="<?php echo $acf_fields['gst_left_side']['logo']['alt']; ?>" title="<?php echo $acf_fields['gst_left_side']['logo']['title']; ?>"
							width="<?php echo $acf_fields['gst_left_side']['logo']['width']; ?>" height="<?php echo $acf_fields['gst_left_side']['logo']['height']; ?>">
					</div>
				</div>
				<div class="yb-get-ready-section-card-cta">
					<?php
					$counter = 0;
					foreach ( $acf_fields['gst_left_side']['buttons'] as $buttons ) {
						$link_target = '';
						++$counter;
						if ( $buttons ) {
							if ( 1 === $counter ) {
								$class = 'yb--link-white cta-button-small orange-icon-large';
							} else {
								$class = 'yb--link cta-button-small button-bg-transparent';
							}
							if ( isset( $buttons['button']['target'] ) && '_blank' === $buttons['button']['target'] ) {
								$link_target = ' target="_blank" rel="noopener"';
							}
							if ( ! empty( $buttons['button']['url'] ) ) {
								?>
							<a class="<?php echo $class; ?>" href="<?php echo esc_url( $buttons['button']['url'] ); ?>" title="<?php echo esc_attr( $buttons['button']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $buttons['button']['title']; ?></a>
								<?php
							}
						}
					}
					?>
				</div>
			</div>

			<div class="yb-get-ready-section-card section-bg-gray-12">
				<div class="yb-get-ready-section-card-head">
					<div class="yb-get-ready-section-card-title"><?php echo $acf_fields['gst_right_side']['heading']; ?></div>
				</div>
				<?php
				if ( isset( $acf_fields['gst_right_side']['button'] ) ) :
					$link_target = '';
					if ( isset( $acf_fields['gst_right_side']['button']['target'] ) && '_blank' === $acf_fields['gst_right_side']['button']['target'] ) {
						$link_target = ' target="_blank" rel="noopener"';
					}
					?>
					<div class="yb-get-ready-section-card-cta">
					<?php
					if ( ! empty( $acf_fields['gst_right_side']['button']['url'] ) ) {
						?>
						<a class="yb--link-black cta-button-small download-cta-icon" href="<?php echo esc_url( $acf_fields['gst_right_side']['button']['url'] ); ?>"
							title="<?php echo esc_attr( $acf_fields['gst_right_side']['button']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $acf_fields['gst_right_side']['button']['title']; ?></a>
						<?php
					}
					?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
