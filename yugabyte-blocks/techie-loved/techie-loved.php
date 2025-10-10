<?php
/**
 * Techie Loved Business Approved Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-cards-section yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
?>
<svg style="display:none;">
<style>
<?php require 'techie-loved.css'; ?>
</style>
</svg>
<?php
$is_flip_cards = true;
if ( isset( $acf_fields['flip_behavior'] ) && 1 !== (int) $acf_fields['flip_behavior'] ) {
	$is_flip_cards = false;
}

$extra_class = '';
if ( $is_flip_cards ) {
	$extra_class = '-flip';
}
?>
<section class="<?php echo esc_attr( $class_name ); ?>" data-lazy="techie_loved">
	<div class="container">
		<div class="section-head">
			<h2><?php echo str_replace( $acf_fields['heading_colored_text'], "<span class='primary-orange'>" . $acf_fields['heading_colored_text'] . '</span>', $acf_fields['heading'] ); ?></h2>
		</div>
		<div class="section-copy">
			<div class="copy-details">
				<?php echo $acf_fields['description']; ?>
			</div>

			<?php
			$content_boxes = $acf_fields['content_box'];
			if ( $content_boxes ) :
				?>
				<div class="copy-cards">
					<?php
					foreach ( $content_boxes as $content_box ) :
						$link_target = '';
						?>
						<div class="copy-card<?php echo $extra_class; ?>">
							<?php if ( $is_flip_cards ) : ?>
								<div class="copy-card-title"><?php echo $content_box['heading']; ?></div>
							<?php endif; ?>
							<div class="copy-card-details">
								<?php echo $content_box['content']; ?>
							</div>

							<?php
							if ( $content_box['button'] ) :
								if ( '_blank' === $content_box['button']['target'] ) {
									$link_target = ' target="_blank" rel="noopener"';
								}
								?>
								<div class="copy-card-cta">
									<a class="yb--link-black" href="<?php echo esc_url( $content_box['button']['url'] ); ?>" title="<?php echo esc_attr( $content_box['button']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $content_box['button']['title']; ?></a>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<script>
	function techie_loved() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/techie-loved/techie-loved.js?<?php echo $theme_version; ?>', 'BODY','techie-loved');
	}
	</script>
</section>
