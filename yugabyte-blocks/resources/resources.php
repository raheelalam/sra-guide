<?php
/**
 * Resources Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$class_name  = 'yugabyte-resources-section yb-sec';
$data_pre    = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
$fields_data = $block['data'];
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}

if ( isset( $fields_data['theme_style'] ) && ! empty( $fields_data['theme_style'] ) ) {
	$class_name .= ' section-bg-' . $fields_data['theme_style'];
}

if ( ! empty( $fields_data['extra_settings'] ) && is_array( $fields_data['extra_settings'] ) ) {
	foreach ( $fields_data['extra_settings'] as $setting ) {
		$class_name .= ' style-' . $setting;
	}
}

$icon_style = '';
if ( ! empty( $fields_data['icon_style'] ) ) {
	$icon_style = ' icon-style';
}
?>

<svg style="display:none;"><style><?php require 'resources.css'; ?></style></svg>

<section class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container<?php echo $icon_style; ?>">
		<div class="section-head">
			<h2><?php echo $fields_data['rc_heading']; ?></h2>
		</div>
		<div class="yb-resources-inner">
			<div class="yb-resources-left">
				<div class="section-copy">
					<?php echo $fields_data['rc_description']; ?>
				</div>
			</div>
			<div class="yb-resources-right">
				<?php
				for ( $rc_card = 0; $rc_card < $fields_data['rc_cards']; ++$rc_card ) {
					$eyebrow_style = '';
					if ( isset( $fields_data[ 'rc_cards_' . $rc_card . '_eyebrow_style' ] )
						&& 1 === (int) $fields_data[ 'rc_cards_' . $rc_card . '_eyebrow_style' ]
					) {
						$eyebrow_style = ' eyebrow-style';
					}

					$title         = $fields_data[ 'rc_cards_' . $rc_card . '_description' ];
					$title_cleaned = wp_strip_all_tags( $title );
					$link          = $fields_data[ 'rc_cards_' . $rc_card . '_link' ];
					$link_target   = '';
					if ( 'yes' === $fields_data[ 'rc_cards_' . $rc_card . '_new_tab' ] ) {
						$link_target = ' target="_blank" rel="noopener"';
					}

					echo '<div class="cta-full-single cta-black' . $eyebrow_style . '">';
					if ( isset( $fields_data[ 'rc_cards_' . $rc_card . '_icon' ] )
						&& ! empty( $fields_data[ 'rc_cards_' . $rc_card . '_icon' ] )
					) {
						$icon_url = wp_get_attachment_url( $fields_data[ 'rc_cards_' . $rc_card . '_icon' ] );
						if ( ! empty( $icon_url ) ) {
							$icon_meta  = wp_get_attachment_metadata( $fields_data[ 'rc_cards_' . $rc_card . '_icon' ] );
							$icon_title = get_the_title( $fields_data[ 'rc_cards_' . $rc_card . '_icon' ] );

							echo '<img ' . $data_pre . 'src="' . esc_url( $icon_url ) . '" alt="' . esc_attr( $icon_title ) . '" title="' . esc_attr( $icon_title ) . '" width="' . esc_attr( $icon_meta['width'] ) . '" height="' . esc_attr( $icon_meta['height'] ) . '">';
						}
					}
          $topText = $fields_data[ 'rc_cards_' . $rc_card . '_heading' ];
          if(!empty($topText)){
            echo '<span>' . $fields_data[ 'rc_cards_' . $rc_card . '_heading' ] . '</span>';
          }
					echo '<a href="' . esc_url( $link ) . '" title="' . esc_attr( $title_cleaned ) . '"' . $link_target . '>' . $title . '</a>
					</div>';
				}
				?>
			</div>
		</div>
	</div>
</section>
