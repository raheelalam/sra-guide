<?php
/**
 * Clients Testimonials Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-client-testimonial yb-sec come-out' );
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
<svg style="display:none;"><style>
	<?php require 'testimonial.css'; ?>
</style></svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="c_testimonials">
	<div class="container">
		<div class="section-head">
			<p><?php echo $acf_fields['title']; ?></p>
		</div>

		<div class="c-testimonial-wrap owl-carousel">
			<?php
			global $wpdb;

			$testimonial_post = $wpdb->get_results(
				"SELECT ID, post_title from {$wpdb->prefix}posts WHERE post_type = 'testimonial' AND post_status = 'publish' ORDER BY menu_order LIMIT 5",
				OBJECT
			);

			foreach ( $testimonial_post as $single_tstmnl ) :
				$meta_data = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT * from {$wpdb->prefix}postmeta WHERE post_id = %d AND meta_key IN ('test_quote', 'name', 'company', 'job_title', 'headshot')",
						$single_tstmnl->ID
					)
				);

				$meta_values = array();
				foreach ( $meta_data as $row ) {
					$meta_values[ $row->meta_key ] = $row->meta_value;
				}

				$headshot = wp_get_attachment_image_src( $meta_values['headshot'] );
				?>

				<div class="quote-item">
					<q><?php echo $meta_values['test_quote']; ?></q>
					<div class="quote-by">
						<div class="img">
							<?php if ( is_array( $headshot ) ) : ?>
								<img <?php echo $data_pre; ?>src="<?php echo $headshot[0]; ?>" alt="<?php echo $meta_values['name']; ?>" title="<?php echo $meta_values['name']; ?>" width="<?php echo $headshot[1]; ?>" height="<?php echo $headshot[2]; ?>">
							<?php else : ?>
								<img <?php echo $data_pre; ?>src="/wp-content/themes/yugabyte/blocks/clients-testimonial/testimonial-avatar.png" alt="avatar" title="avatar" width="92" height="92">
							<?php endif; ?>
						</div>
						<div>
							<div class="name"><?php echo $meta_values['name']; ?></div>
							<span class="details">
								<?php
								if ( ! empty( $meta_values['company'] ) ) {
									echo $meta_values['company'];
								}
								if ( ! empty( $meta_values['company'] ) && ! empty( $meta_values['job_title'] ) ) {
									echo ', ';
								}
								if ( ! empty( $meta_values['job_title'] ) ) {
									echo $meta_values['job_title'];
								}
								?>
							</span>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<script>
function c_testimonials() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/clients-testimonial/testimonial.js?1.11<?php echo $theme_version; ?>', 'BODY','c_testimonials');
}
</script>
