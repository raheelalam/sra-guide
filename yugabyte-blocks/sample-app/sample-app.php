<?php
/**
 * Yugabyte Sample app Section Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-sample-app yb-sec' );
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
		<?php require 'sample-app.css'; ?>
	</style>
</svg>

<section class="<?php echo esc_attr( $class_name ); ?> section-bg-dark" data-lazy="ybsa">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['heading']; ?></h2>
		</div>
		<?php $apps_data = $acf_fields['sa_app_tabs']; ?>

		<div class="yb-sample-app-tabs">
			<?php foreach ( $apps_data as $key => $choice ) { ?>
				<div class="tab
				<?php
				if ( 0 === $key ) {
					echo 'active';}
				?>
				" data-tab="<?php echo ++$key; ?>"><?php echo $choice['app_title']; ?></div>
			<?php } ?>
		</div>
		<div class="yb-sample-app-window">
			<?php foreach ( $apps_data as $key => $details ) { ?>
				<?php $app_details = $details['app_details']; ?>
				<div class="content
				<?php
				if ( 0 === $key ) {
					echo 'active';}
				?>
				" data-content="<?php echo ++$key; ?>">
				<?php
					$type    = $app_details['image_type'];
					$image   = $app_details['image'];
					$multi   = '';
					$BGimage = '';
				if ( 'complex' === $type ) {
					$image2  = $app_details['image_2'];
					$BGimage = $app_details['image_3'];
					if ( ! empty( $BGimage ) ) {
						$BGimage = ' style=background-image:url(' . $BGimage . ')';
					}
					$multi = ' data-multi="true"';
				}
					echo '<div class="img"' . $multi . $BGimage . '>
						<img ' . $data_pre . 'src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['alt'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '">';
				if ( ! empty( $image2 ) ) {
					echo '<img ' . $data_pre . 'src="' . $image2['url'] . '" alt="' . $image2['alt'] . '" title="' . $image2['alt'] . '" width="' . $image2['width'] . '" height="' . $image2['height'] . '">';
				}
				if ( ! empty( $app_details['alternate_mobile'] ) && 1 === (int) $app_details['alternate_mobile'] && ! empty( $app_details['image_4'] ) ) {
					$image4 = $app_details['image_4'];
					echo '<img class="mob-sec" ' . $data_pre . 'src="' . $image4['url'] . '" alt="' . $image4['alt'] . '" title="' . $image4['alt'] . '" width="' . $image4['width'] . '" height="' . $image4['height'] . '">';
				}
				if ( 'light' === $app_details['button_theme'] ) {
					$buttonClass = 'yb--link-white cta-button-small';
				} else {
					$buttonClass = 'yb--link-black cta-button-small';
				}
				$link       = $app_details['button'];
				$vertical   = $app_details['position']['from_v'];
				$valueV     = $app_details['position']['percent_v'];
				$horizontal = $app_details['position']['from_h'];
				$valueH     = $app_details['position']['percent_h'];
				if ( ! empty( $link ) ) {
					$link_target = '';
					if ( '_blank' === $link['target'] ) {
						$link_target = 'target="_blank" rel="noopener"';
						$buttonClass = $buttonClass . ' new-tab';
					}
						echo '<a class="' . $buttonClass . '" href="' . esc_url( $link['url'] ) . '" style="' . $vertical . ':' . $valueV . '%;' . $horizontal . ':' . $valueH . '%" title="' . esc_attr( $link['title'] ) . '" ' . $link_target . '>' . $link['title'] . '</a>';
				}
					echo '</div>';
				?>
				</div>
				<?php
			}
			?>
		</div>

		<?php
		$link = $acf_fields['cta'];
		if ( ! empty( $link ) ) {
			$link_target = '';
			if ( '_blank' === $link['target'] ) {
				$link_target = 'target="_blank" rel="noopener"';
			}
			echo '<div class="cta text-center">
        <a class="yb--link-white cta-button-small" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '" ' . $link_target . '>' . $link['title'] . '</a>
      </div>';
		}
		?>
	</div>
</section>
<script>
function ybsa() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/sample-app/sample-app.js?<?php echo $theme_version; ?>', 'BODY', 'ybsa');
}
</script>
