<?php
/**
 * Press Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-press-section yb-sec' );
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

<div class="<?php echo esc_attr( $class_name ); ?>">
	<svg style="display:none;"><style><?php require 'press.css'; ?></style></svg>
	<div class="container">
		<div class="section-head">
			<p><?php echo $acf_fields['section_title']; ?></p>
		</div>

		<div class="yb-press-items">
			<?php
			foreach ( $acf_fields['press_cards'] as $press_cards ) {
				if ( $press_cards ) {
					$target = '';
					if ( 'yes' === $press_cards['new_tab'] ) {
						$target = ' target="_blank" rel="noopener"';
					}
					echo '<a class="yb-press-item" href="' . esc_url( $press_cards['link'] ) . '"' . $target . '>
					<span class="yb-press-title">';
					if ( ! empty( $press_cards['eyebrow_text'] ) ) {
						echo '<span class="yb-press-eyebrow">' . $press_cards['eyebrow_text'] . '</span>';
					}
					echo '<span class="yb-press-heading">' . $press_cards['heading'] . '</span>
					</span>';
					if ( ! empty( $press_cards['logo'] ) ) {
						echo '<img ' . $data_pre . 'src="' . $press_cards['logo']['url'] . '" alt="' . $press_cards['logo']['alt'] . '" title="' . $press_cards['logo']['title'] . '" width="' . $press_cards['logo']['width'] . '" height="' . $press_cards['logo']['height'] . '">';
					}
					echo '</a>';
				}
			}
			?>
		</div>
		<?php

		if ( ! empty( $acf_fields['cta'] ) ) {
			$link        = $acf_fields['cta'];
			$link_target = '';
			if ( '_blank' === $link['target'] ) {
				$link_target = ' target="_blank" rel="noopener"';
			}

			echo '<div class="cta text-center">
				<a class="yb--link-black cta-button-small" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '>' . $link['title'] . '</a>
			</div>';
		}
		?>
	</div>
</div>
