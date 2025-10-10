<?php
/**
 * Rebrand Hero Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-hero-section yb-sec come-out rebrand-hero-v6' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];

$content_section      = $acf_fields['content_section'];
$image_section        = $acf_fields['top_image_section'];
$bottom_image_section = $acf_fields['bottom_image_section'];
?>
<svg style="display:none;">
<style>
<?php require 'style.css'; ?>
</style>
</svg>

<section class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
	<?php
	$TopLeftImg  = $image_section['left_top_image'];
	$eyebrowText = $image_section['eyebrow_text'];
	$TopRightImg = $image_section['right_top_image'];

	if ( ! empty( $TopLeftImg ) || ! empty( $eyebrowText ) || ! empty( $TopRightImg ) ) {
		echo '<div class="hero-image">';
		if ( ! empty( $TopLeftImg ) ) {
			echo '<img src="' . $TopLeftImg['url'] . '" alt="' . $TopLeftImg['alt'] . '" title="' . $TopLeftImg['title'] . '" width="' . $TopLeftImg['width'] . '" height="' . $TopLeftImg['height'] . '">';
		}

		if ( ! empty( $eyebrowText ) ) {
			echo '<div class="hero-img-caption">' . $eyebrowText . '</div>';
		}

		if ( ! empty( $TopRightImg ) ) {
			echo '<img src="' . $TopRightImg['url'] . '" alt="' . $TopRightImg['alt'] . '" title="' . $TopRightImg['title'] . '" width="' . $TopRightImg['width'] . '" height="' . $TopRightImg['height'] . '">';
		}
		echo '</div>';
	}
	?>
	<div class="hero-content">
			<h1><?php echo $content_section['heading']; ?></h1>
	<?php
	$SubHeading = $content_section['sub_heading'];
	if ( ! empty( $SubHeading ) ) {
		echo '<div class="sub-heading">' . $SubHeading . '</div>';
	}

	$ctas = $content_section['ctas'];
	if ( ! empty( $ctas ) ) {
		echo '<div class="yb-hero-ctas">';
		foreach ( $content_section['ctas'] as $cta ) {
			if ( $cta ) {
				$icon        = $cta['cta_icon'];
				$theme       = $cta['cta_theme'];
				$cta         = $cta['cta'];
				$link_target = '';
				if ( '_blank' === $cta['target'] ) {
					$link_target = ' target="_blank" rel="noopener"';
				}
				echo '<a class="hero-btn ' . $icon . ' ' . $theme . '" href="' . esc_url( $cta['url'] ) . '" title="' . esc_attr( $cta['title'] ) . '"' . $link_target . '>' . $cta['title'] . '</a>';
			}
		}
		echo '</div>';
	}
	?>
	</div>
	<?php

	$BottomLeftImg  = $bottom_image_section['left_bottom_image'];
	$BottomRightImg = $bottom_image_section['right_bottom_image'];
	if ( ! empty( $BottomLeftImg ) || ! empty( $BottomRightImg ) ) {
		echo '<div class="hero-image-bottom">';
		if ( ! empty( $BottomLeftImg ) ) {
			echo '<img src="' . $BottomLeftImg['url'] . '" alt="' . $BottomLeftImg['alt'] . '" title="' . $BottomLeftImg['title'] . '" width="' . $BottomLeftImg['width'] . '" height="' . $BottomLeftImg['height'] . '">';
		}
		if ( ! empty( $BottomRightImg ) ) {
			echo '<img src="' . $BottomRightImg['url'] . '" alt="' . $BottomRightImg['alt'] . '" title="' . $BottomRightImg['title'] . '" width="' . $BottomRightImg['width'] . '" height="' . $BottomRightImg['height'] . '">';
		}
		echo '</div>';
	}
	?>
</div>
	<div class="hero-bg">
	<span></span>
	<span></span>
	<span></span>
	<span></span>
	<span></span>
	<span class="anigray"></span>
	<span class="anigray"></span>
	<span class="size-24"></span>
	<span class="purple size-26"></span>
	<span class="purple size-21"></span>
	<span class="purple size-22"></span>
	</div>
</section>
