<?php
/**
 * Yugabyte Global Presence Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-global-presence-section section-bg-dark yb-sec' );
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
require 'global-presence.css';
foreach ( $acf_fields['locations'] as $location ) {
	if ( $location ) {
		$location_l    = strtolower( $location['location'] );
		$location_link = str_replace( ' ', '-', $location_l );
		$country_l     = strtolower( $location['country'] );
		$country_link  = str_replace( ' ', '-', $country_l );
	}
}
?>
</style>
</svg>
<section class="yb-gp <?php echo esc_attr( $class_name ); ?>" data-lazy="global_presence">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['heading']; ?></h2>
		</div>
	<div class="yb-gp-wrap">
		<div class="yb-gp-content">
		<?php

		echo $acf_fields['subs'];

		if ( ! empty( $acf_fields['support_link'] ) ) {
			$link        = $acf_fields['support_link'];
			$link_target = '';
			if ( '_blank' === $link['target'] ) {
				$link_target = ' target="_blank" rel="noopener"';
			}
			echo '<a href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '>';
			require 'support.svg';
			echo $link['title'] . '</a>';
		}

		?>
	</div>
		<div class="yb-gp-map">
		<?php

		foreach ( $acf_fields['locations'] as $location ) {

			if ( $location ) {
				$location_l    = strtolower( $location['location'] );
				$location_link = str_replace( ' ', '-', $location_l );
				$country_l     = strtolower( $location['country'] );
				$country_link  = str_replace( ' ', '-', $country_l );

				if ( 0 !== (int) $location['axis']['x-axis'] && 0 !== (int) $location['axis']['y-axis'] ) {
					echo '<div class="yb-location-point" data-country="' . $country_link . '" data-center="' . $location_link . '" style="top:' . $location['axis']['y-axis'] . '%;left:' . $location['axis']['x-axis'] . '%;">';
					echo '<b>' . $location['location'] . '</b>
              <div class="yb-location-details">';
					echo nl2br( $location['details'] );
					echo '</div>
              </div>';
				}
			}
		}
		require 'global-presence-map.svg';

		?>
	</div>
		<div class="yb-gp-slider">
		<?php

		echo '<div>' . $acf_fields['locations_title'] . '</div>';

		echo '<div class="yb-gp-slide" data-mobilehead="' . $acf_fields['locations_title'] . '">';

		foreach ( $acf_fields['locations'] as $location ) {
			if ( $location ) {
				$location_l    = strtolower( $location['location'] );
				$location_link = str_replace( ' ', '-', $location_l );
				$country_l     = strtolower( $location['country'] );
				$country_link  = str_replace( ' ', '-', $country_l );

				if ( 0 !== (int) $location['axis']['x-axis'] && 0 !== (int) $location['axis']['y-axis'] ) {
					echo '<div class="yb-location" data-country="' . $country_link . '" data-center="' . $location_link . '">';
					$image = $location['image'];
					echo '<img ' . $data_pre . 'src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '">';
					echo '<span class="yb-location-title">';
					echo '<b>' . $location['location'] . '</b>';
					echo $location['country'];
					echo '</span>';
					echo '</div>';
				}
			}
		}
		echo '</div>';

		?>
	</div>
	</div>
	</div>
</section>
<script>
function global_presence() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/global-presence/global-presence.js?<?php echo $theme_version; ?>', 'BODY','global-presence');
}
</script>
