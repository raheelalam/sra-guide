<?php
/**
 * Reviews Section Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-reviews-section yb-sec come-out' );
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
		<?php require 'reviews.css'; ?>
	</style>
</svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="reviews">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['heading']; ?></h2>
		</div>
		<div class="aside-reviews-container">
			<?php $customer_testimonials = $acf_fields['customer_testimonials']; ?>
			<div class="yb-reviews-items">
				<?php
				foreach ( $customer_testimonials['customer_testimonial'] as $key => $customer_testimonial_card ) {
					++$key;
					if ( $customer_testimonial_card ) {
						?>
					<div class="yb-review-item <?php echo ( $key < 5 ) ? 'open' : ''; ?>">
						<div class="yb-reviewer">
							<div class="yb-reviewer-name"><?php echo $customer_testimonial_card['company']; ?></div>
							<div class="yb-reviewer-desg"><?php echo $customer_testimonial_card['author_and_desig']; ?></div>
						</div>
						<div class="yb-review-details"><?php echo $customer_testimonial_card['details']; ?></div>
					</div>
						<?php
					}
				}
				?>
			</div>
		</div>
		<div class="cta text-center load-more hidden">
			<a class="yb--link-black cta-button-small" title="Load more">Load More</a>
		</div>
		<div class="widget-heading"><?php echo $acf_fields['widget_heading']; ?></div>
		<div class="aside-reviews-widgets">
			<div class="w-g2">
				<?php if ( ! empty( $acf_fields['show_widget_g2'] ) && 'yes' === $acf_fields['show_widget_g2'] ) { ?>
					<div class="g2-review-widget"></div>
				<?php } ?>
			</div>
			<div class="w-gartner">
				<?php if ( ! empty( $acf_fields['show_widget_gartner'] ) && 'yes' === $acf_fields['show_widget_gartner'] ) { ?>
					<div class="gatner-insides">
						<a target="_blank" rel="noopener" href="https://www.gartner.com/reviews/market/cloud-database-management-systems/vendor/yugabyte?utm_source=yugabyte&utm_medium=referral&utm_campaign=widget">
							<img <?php echo $data_pre; ?>src="/wp-content/themes/yugabyte/blocks/reviews-section/GartnerPeerInsightsLogo_onlight.svg" title="Read reviews on Gartner peer insights" width="250" height="56">
						</a>
						<div>
							<a target="_blank" rel="noopener" href="https://www.gartner.com/reviews/market/cloud-database-management-systems/vendor/yugabyte/reviews">Read Reviews</a>
							<a target="_blank" rel="noopener" href="https://gtnr.io/1KrtyVDpS">Write a Review</a>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>

<script>
function reviews() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/reviews-section/reviews.js?<?php echo $theme_version; ?>8.119', 'BODY', 'reviews');
}
</script>
