<?php
/**
 * Use Cases Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-usecase-cards-section section-bg-gray-1 yb-sec' );
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
require 'use-cases.css';
if ( 'ja' === YUGABYTE_CURRENT_LANGUAGE ) {
	require 'use-cases-ja.css';
}
?>
</style>
</svg>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="section-head">
			<p><?php echo $acf_fields['tuc_heading']; ?></p>
		</div>
		<?php
		$use_case_cards = $acf_fields['tuc_use_case_card'];
		if ( isset( $use_case_cards ) && ! empty( $use_case_cards ) ) {
			?>
			<div class="section-copy">
				<div class="yb-usecase-cards">
					<?php
					$num = 1;
					foreach ( $use_case_cards as $use_case_card ) {
						?>
						<a class="yb-usecase-card" href="<?php echo esc_url( $use_case_card['link'] ); ?>">
							<span class="yb-usecase-card-count"><?php printf( '%02d', $num ); ?></span>
							<span class="yb-usecase-card-title"><?php echo $use_case_card['heading']; ?></span>
							<span class="yb-usecase-card-image">
								<img <?php echo $data_pre; ?>src="<?php echo $use_case_card['image']['url']; ?>" alt="<?php echo $use_case_card['image']['alt']; ?>" title="<?php echo $use_case_card['image']['title']; ?>" width="<?php echo $use_case_card['image']['width']; ?>" height="<?php echo $use_case_card['image']['height']; ?>">
							</span>
							<span class="yb-usecase-card-details"><span><?php echo $use_case_card['description']; ?></span></span>
						</a>
						<?php
						++$num;
					}
					?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
