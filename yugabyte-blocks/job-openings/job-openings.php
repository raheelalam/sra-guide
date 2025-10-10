<?php
/**
 * Career Job Openings Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-job-openings-section job-openings yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];

?>
<svg style="display:none;">
<style>
<?php require 'job-openings.css'; ?>
</style>
</svg>

<div class="<?php echo esc_attr( $class_name ); ?>" id="job-openings" data-lazy="job_openings">
	<div class="container">

		<div class="section-head">
			<h2><?php echo get_field( 'jo_heading' ); ?></h2>
		</div>

		<div class="jobs"></div>

		<div class="cta-full-single cta-purple">
			<span><?php echo $acf_fields['job_cta_section']['text']; ?></span>
			<div>
				<?php
				if ( ! empty( $acf_fields['job_cta_section']['ctas'] ) ) {
					foreach ( $acf_fields['job_cta_section']['ctas'] as $ctas ) {
						$link        = $ctas['button'];
						$link_target = '';
						if ( $link && '_blank' === $link['target'] ) {
							$link_target = ' target="_blank" rel="noopener"';
						}
						if ( ! empty( $ctas ) && ! empty( $link ) ) {
							echo '<a href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '>' . $link['title'] . '</a>';
						}
					}
				}
				?>
			</div>
		</div>
	</div>
</div>

<script>
function job_openings() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/job-openings/job-openings.js?<?php echo $theme_version; ?>', 'BODY','job-openings', function () {});
}
</script>
