<?php
/**
 * Life at Yugabyte Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-life-at-yugabyte yb-sec' );
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
	<?php require 'life-at-yugabyte.css'; ?>
</style></svg>

<section class="life-at-yugabyte section-bg-dark <?php echo esc_attr( $class_name ); ?>">
	<div class="container">

	<div class="section-head">
			<h2><?php echo $acf_fields['heading']; ?></h2>
		</div>

		<div class="section-copy">
			<div class="content-area">
		<div class="short-detail"><?php echo $acf_fields['short_details']; ?></div>
		<?php
		if ( ! empty( $acf_fields['link'] ) ) {
			$link        = $acf_fields['link'];
			$link_target = '';
			if ( '_blank' === $acf_fields['link']['target'] ) {
				$link_target = ' target="_blank" rel="noopener"';
			}
			echo '<div class="cta">
            <a class="yb--link-black cta-button-small" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '>' . $link['title'] . '</a>
          </div>';
		}
		?>
		</div>

			<div class="isotops-images">
		<?php
		foreach ( $acf_fields['images'] as $team_member ) {
			if ( $team_member ) {
				$thumb = $team_member['start_image'];
				echo '<div class="isotops-image" data-order="' . $team_member['mobile_ordering'] . '">';
				if ( ! empty( $thumb ) ) {
					echo '<img ' . $data_pre . 'src="' . $thumb['url'] . '" alt="' . $thumb['alt'] . '" title="' . $thumb['title'] . '" width="' . $thumb['width'] . '" height="' . $thumb['height'] . '">';
				}
				echo '</div>';
			}
		}
		?>
		</div>
	</div>
	</div>
</section>
