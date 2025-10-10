<?php
/**
 * YugabyteDB Community Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-yugabytedb-community-section yb-sec come-out' );
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
	require 'yugabytedb-community.css';
if ( 'ja' === YUGABYTE_CURRENT_LANGUAGE ) {
	require 'yugabytedb-community-ja.css';
}
?>
</style>
</svg>

<section class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="yb-connect-com-inner section-bg-dark">
			<div class="yb-connect-com-inner-top">
				<div class="section-head">
					<h2><?php echo $acf_fields['yc_heading']; ?></h2>
				</div>

				<div class="section-copy">
					<img <?php echo $data_pre; ?>src="<?php echo $acf_fields['yc_image']['url']; ?>" alt="<?php echo $acf_fields['yc_image']['alt']; ?>" title="<?php echo $acf_fields['yc_image']['title']; ?>" width="<?php echo $acf_fields['yc_image']['width']; ?>" height="<?php echo $acf_fields['yc_image']['height']; ?>">
				</div>
			</div>
			<div class="cta-full-single cta-black">
				<span><i><?php echo $acf_fields['yc_bottom_bar']; ?></i></span>
				<?php
				if ( isset( $acf_fields['yc_button'] ) ) :
					$link_target = '';
					if ( '_blank' === $acf_fields['yc_button']['target'] ) {
						$link_target = 'target="_blank" rel="noopener"';
					}
					?>
					<a href="<?php echo esc_url( $acf_fields['yc_button']['url'] ); ?>" title="<?php echo esc_attr( $acf_fields['yc_button']['title'] ); ?>" <?php echo $link_target; ?>><?php echo $acf_fields['yc_button']['title']; ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
