<?php
/**
 * Benefit Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-benefit-section come-out yb-sec' );
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
require 'benefit.css';
if ( 'ja' === YUGABYTE_CURRENT_LANGUAGE ) {
	require 'benefit-ja.css';
}
?>
</style>
</svg>

<div tabindex="0" id="section2" class="<?php echo esc_attr( $class_name ); ?>" data-lazy="yugabyte_benefit">
	<div class="container">
		<div class="animated-img dots-animate">
			<div class="dot-ami first"></div>
			<div class="dot-ami sec"></div>
			<div class="dot-ami third"></div>
		</div>

		<div class="yb-benefit-inner">
			<div class="yb-benefit-tabs">
				<?php
				$counter = 0;
				$images  = '';
				foreach ( $acf_fields['bt_benefits'] as $benefits ) {
					++$counter;
					$active_class     = '';
					$img_active_class = '';
					if ( 1 === $counter ) {
						$active_class     = 'class="active"';
						$img_active_class = 'class="active" data-svg="' . $benefits['image']['sizes']['medium'] . '"';
					}
					if ( $benefits ) {
						?>
						<div <?php echo $active_class; ?>>
							<u><?php echo $benefits['tab_name']; ?></u>
							<div class="yb-benefit-copy">
								<h3><?php echo $benefits['content_area']['heading']; ?></h3>
								<?php echo $benefits['content_area']['short_detail']; ?>
							</div>
						</div>
						<?php
						$images .= '<div ' . $img_active_class . '>';
						if ( $counter > 1 ) {
							$images .= '<img ' . $data_pre . 'src="' . $benefits['image']['sizes']['medium'] . '" alt="' . $benefits['image']['alt'] . '" title="' . $benefits['image']['title'] . '" width="' . $benefits['image']['sizes']['medium-width'] . '" height="' . $benefits['image']['sizes']['medium-height'] . '">';
						}

						$images .= '</div>';
					}
				}
				?>
			</div>

			<div class="yb-benefit-tabs-mob">
				<div>
					<?php
					$counter = 0;
					foreach ( $acf_fields['bt_benefits'] as $benefits ) {
						if ( isset( $benefits['tab_name'] ) ) :
							++$counter;
							$active_class = '';
							if ( 1 === $counter ) {
								$active_class = 'class="active"';
							}
							?>
							<div <?php echo $active_class; ?>>
								<u><span><?php echo $benefits['tab_name']; ?></span></u>
							</div>
							<?php
						endif;
					}
					?>
				</div>
			</div>
			<div class="yb-benefit-img">
				<?php echo $images; ?>
			</div>
		</div>
	</div>
</div>

<script>
function yugabyte_benefit() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/benefit/benefit.js?<?php echo $theme_version; ?>', 'BODY','yugabyte-benefit', function () {});
}
</script>
