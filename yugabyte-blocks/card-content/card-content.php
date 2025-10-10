<?php
/**
 * Card Content Section Block Template.
 *
 * @param array  $block           The block settings and attributes.
 * @param string $content         The block inner HTML (empty).
 * @param bool   $is_preview True During backend preview render.
 * @param int    $post_id         The post ID the block is rendering content against.
 * @param array  $context         The context provided to the block by the post or it's parent block.
 */

$fields_data = $block['data'];
$class_name  = 'yb-card-content-section come-out yb-sec';

if ( ! empty( $fields_data['extra_settings'] ) && is_array( $fields_data['extra_settings'] ) ) {
	foreach ( $fields_data['extra_settings'] as $setting ) {
		$class_name .= ' style-' . $setting;
	}
}


if ( ! isset( $block['className'] )
	|| false === strpos( $block['className'], 'repeated-block' )
) :
	?>
	<svg style="display:none;"><style><?php require 'card-content.css'; ?></style></svg>
	<?php
endif;

if ( isset( $fields_data['theme_style'] ) && ! empty( $fields_data['theme_style'] ) ) {
	$class_name .= ' section-bg-' . $fields_data['theme_style'];
}
?>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<?php
		if ( isset( $fields_data['top_area_text'] ) && ! empty( $fields_data['top_area_text'] ) ) {
			echo '<div class="top-text">' . $fields_data['top_area_text'] . '</div>';
		}

		echo '<div class="card-content">';
		if ( ! empty( $fields_data['card_before_title'] ) ) {
			echo '<div class="top-title">' . $fields_data['card_before_title'] . '</div>';
		}
		if ( ! empty( $fields_data['card_title'] ) ) {
			echo '<h2>' . $fields_data['card_title'] . '</h2>';
		}
		if ( ! empty( $fields_data['card_content'] ) ) {
			echo '<div class="card-data">' . $fields_data['card_content'] . '</div>';
		}
		if ( ! empty( $fields_data['card_cta'] ) ) {
			$link_target = '';
			if ( isset( $fields_data['card_cta']['target'] ) && '_blank' === $fields_data['card_cta']['target'] ) {
				$link_target = ' target="_blank" rel="noopener"';
			}
			echo '<a class="yb--link-white cta-button-small" href="' . esc_url( $fields_data['card_cta']['url'] ) . '" title="' . esc_attr( $fields_data['card_cta']['title'] ) . '"' . $link_target . '>' . $fields_data['card_cta']['title'] . '</a>';
		}
		echo '</div>';
		?>
	</div>
</div>
