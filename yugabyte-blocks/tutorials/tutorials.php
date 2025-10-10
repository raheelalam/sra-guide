<?php
/**
 * Tutorials Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-tutorials yb-sec come-out' );
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
	<?php require 'tutorials.css'; ?>
</style></svg>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
	<?php

		echo '<div class="section-head">';

	if ( ! empty( $acf_fields['heading'] ) ) {
		echo '<h2>' . $acf_fields['heading'] . '</h2>';
	}

		$link = $acf_fields['cta'];
	if ( ! empty( $link ) ) {
		$link_target = '';
		if ( '_blank' === $link['target'] ) {
			$link_target = ' target="_blank" rel="noopener"';
		}
		echo '<a class="yb--link-black" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '>' . $link['title'] . '</a>';
	}

		echo '</div>
    <div class="section-copy">

    <div class="yb-tutorial-items">';
	foreach ( $acf_fields['toturials'] as $toturial ) {
		if ( $toturial ) {
			$link        = $toturial['link'];
			$image       = $toturial['image'];
			$txt         = $toturial['text'];
			$link_target = '';
			if ( ! empty( $link['target'] ) && '_blank' === $link['target'] ) {
				$link_target = 'target="_blank" rel="noopener"';
			}
			echo '<a href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '" ' . $link_target . '>';
			if ( ! empty( $image ) ) {
				echo '<img ' . $data_pre . 'src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '">';
			} elseif ( ! empty( $txt ) ) {
				echo '<b>' . $txt . '</b>';
			}
			echo '<span>' . $link['title'] . '</span>
      </a>';
		}
	}
		echo '</div>';

	if ( ! empty( $acf_fields['bottom_text'] ) ) {
		echo '<div class="bottom-text">' . $acf_fields['bottom_text'] . '</div>';
	}

	echo '</div>';

	?>
	</div>
</div>
