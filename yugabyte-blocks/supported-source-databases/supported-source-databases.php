<?php
/**
 * Supported Source Databases Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-supported-source yb-sec come-out' );
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
<?php require 'supported-source-databases.css'; ?>
</style>
</svg>
<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['ssd_heading']; ?></h2>
		</div>
		<div class="sources" data-child="<?php echo count( $acf_fields['ssd_sources'] ); ?>">
			<?php
			if ( $acf_fields['ssd_sources'] ) :
				foreach ( $acf_fields['ssd_sources'] as $source ) :
					$source_logo = $source['icon'];
					if ( 0 === (int) $source['boxes_type'] ) :
						?>
						<div class="single-source">
							<div class="source-icon">
							<img <?php echo $data_pre; ?>src="<?php echo esc_url( wp_make_link_relative( $source_logo['url'] ) ); ?>" alt="<?php echo esc_attr( $source_logo['alt'] ); ?>" title="<?php echo esc_attr( $source_logo['title'] ); ?>" width="<?php echo esc_attr( $source_logo['width'] ); ?>" height="<?php echo esc_attr( $source_logo['height'] ); ?>">
							</div>
							<div class="source-detail">
								<div class="source-title"><?php echo $source['title']; ?></div>
								<div class="points">
									<?php
									if ( $source['points'] ) :
										foreach ( $source['points'] as $points ) :
											$point_link = $points['link'];
											if ( ! empty( $point_link ) ) :
												$link_target = '';
												if ( '_blank' === $point_link['target'] ) :
													$link_target = 'target="_blank" rel="noopener"';
												endif;
											endif;
											?>
											<div class="single-point">
												<?php if ( 'text' === $points['select_choice'] ) { ?>
													<span><?php echo $points['text']; ?></span>
													<?php
												} elseif ( 'link' === $points['select_choice'] && '' !== $point_link['url'] ) {
													?>
													<a href="<?php echo esc_url( $point_link['url'] ); ?>" title="<?php echo esc_attr( $point_link['title'] ); ?>" <?php echo $link_target; ?>><?php echo $point_link['title']; ?></a>
												<?php } ?>
											</div>
											<?php
										endforeach;
									endif;
									?>
								</div>
							</div>
						</div>
					<?php else : ?>
						<div class="single-source cta-block">
							<div class="cta-copy">
								<?php echo $source['cta_copy']; ?>
							</div>
							<div class="cta text-left">
								<?php
								$cta_link    = $source['cta_link'];
								$link_target = '';
								if ( '_blank' === $cta_link['target'] ) {
									$link_target = 'target="_blank" rel="noopener"';
								}
								?>
								<a class="yb--link-black cta-button-small" href="<?php echo esc_url( $cta_link['url'] ); ?>" title="<?php echo esc_attr( $cta_link['title'] ); ?>" <?php echo $link_target; ?>><?php echo $cta_link['title']; ?></a>
							</div>
						</div>
						<?php
					endif;
				endforeach;
			endif;
			?>
		</div>
	</div>
</div>
