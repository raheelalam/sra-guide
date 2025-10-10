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

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-press-kit-section yb-sec' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
?>
<svg style="display:none;">
<style>
<?php require 'press-kit.css'; ?>
</style>
</svg>

<section class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['pk_heading']; ?></h2>
		</div>
		<div class="yb-press-kit-inner">
			<div class="yb-press-kit-left">
				<div class="section-copy">
					<?php echo $acf_fields['pk_description']; ?>
				</div>
				<div class="section-button">
				<?php

				$file = $acf_fields['cta']['pk_button'];
				$link = $acf_fields['cta']['link'];

				if ( isset( $file ) && ! empty( $file ) ) {
					$button = $file;
					$type   = $button['subtype'];
					$size   = $button['filesize'];
					$size   = $size / 1024 / 1024;
					$size   = round( $size, 1 );

					echo '<a class="yb--link-black cta-button-small download-icon" href="' . esc_url( $button['url'] ) . '" title="' . esc_attr( $button['title'] ) . '" download>Download All <span class="yb-type">' . $type . ', </span><span class="yb-size">' . $size . 'Mb</span></a>';

				} elseif ( isset( $link ) && ! empty( $link ) ) {
					$link_target = '';
					if ( $link && '_blank' === $link['target'] ) {
						$link_target = ' target="_blank" rel="noopener"';
					}
					echo '<a class="yb--link-black cta-button-small" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '>' . $link['title'] . '</a>';
				}

				?>
			</div>
			</div>
			<div class="yb-press-kit-right">
			<?php

			foreach ( $acf_fields['pk_cards'] as $pk_card ) {
				if ( $pk_card ) {
					$eyebrow_style = '';
					$file          = $pk_card['cta']['pk_button'];
					$link          = $pk_card['cta']['link'];

					if ( isset( $pk_card['eyebrow_style'] ) && 1 === (int) $pk_card['eyebrow_style'] ) {
						$eyebrow_style = ' eyebrow-style';
					}

					if ( isset( $file ) && ! empty( $file ) ) {
						$button = $file;
						echo '<a class="cta-full-single cta-black' . $eyebrow_style . ' download-icon" href="' . esc_url( $button['url'] ) . '" title="' . esc_attr( $button['title'] ) . '" download><span>' . $pk_card['heading'] . '</span>' . $pk_card['description'] . '</a>';
					} elseif ( isset( $link ) && ! empty( $link ) ) {
							$link_target = '';
						if ( $link && '_blank' === $link['target'] ) {
							$link_target = ' target="_blank" rel="noopener"';
						}
						echo '<a class="cta-full-single cta-black' . $eyebrow_style . '" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '><span>' . $pk_card['heading'] . '</span>' . $pk_card['description'] . '</a>';
					}
				}
			}

			?>
	</div>
		</div>
	</div>
</section>
