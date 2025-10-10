<?php
/**
 * Beyond Technology Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-beyond-tech-section yb-sec' );
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
require 'beyond-technology.css';
if ( 'ja' === YUGABYTE_CURRENT_LANGUAGE ) {
	require 'beyond-technology-ja.css';
}
?>
</style>
</svg>

<section class="<?php echo esc_attr( $class_name ); ?>" data-lazy="beyond_tech">
	<div class="container">
		<div class="section-inner">
			<div class="section-left">
				<h2><?php echo $acf_fields['btt_left_side']['heading']; ?></h2>
				<div class="section-copy">
					<p><?php echo $acf_fields['btt_left_side']['description']; ?></p>
				</div>
			</div>

			<div class="section-right">
				<div class="yb-beyond-tech-slider">
					<div class="yb-beyond-tech-slides">
						<?php
						$cards   = $acf_fields['cards'];
						$counter = 0;
						foreach ( $cards as $card ) {
							++$counter;
							$link_target = '';
							?>
							<div <?php echo ( 1 === $counter ) ? 'class="active"' : ''; ?>>
								<span></span>
								<div style="background-image:url(<?php echo $card['icon']; ?>);">
									<div class="yb-beyond-tech-title"><?php echo $card['title']; ?></div>
									<div class="yb-beyond-tech-details"><span><?php echo $card['description']; ?></span></div>
									<?php
									if ( isset( $card['button'] ) ) {
										if ( '_blank' === $card['button']['target'] ) {
											$link_target = 'target="_blank" rel="noopener"';
										}
										?>
										<div class="yb-beyond-tech-cta"><a class="yb--link-black" href="<?php echo esc_url( $card['button']['url'] ); ?>" title="<?php echo esc_attr( $card['button']['title'] ); ?>" <?php echo $link_target; ?>><?php echo $card['button']['title']; ?></a></div>
									<?php } ?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="yb-beyond-tech-nav">
					<i class="active"></i>
					<i></i>
					<i></i>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
function beyond_tech(){
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/beyond-technology/beyond-technology.js?<?php echo $theme_version; ?>', 'BODY','beyond-technology', function () {});
}
</script>
