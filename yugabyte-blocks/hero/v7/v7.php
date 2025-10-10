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

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-hero-section yb-sec come-out rebrand-hero-v7' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];

$content_section = $acf_fields['content_section'];
$image_section   = $acf_fields['images'];
$data_pre        = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}
?>
<svg style="display:none;">
<style>
<?php
require 'style.css';
if ( ! empty( $acf_fields['animation'] ) ) {
	$t = $acf_fields['animation'];
	$a = '1';
	$b = '2';
	$c = '3';
	$d = '4';
	echo '.hero-image img {';
	echo 'animation-duration:' . $t . 's;';
	echo '}';
	echo '
.hero-image div:nth-child(1) img{
  animation-delay: ' . $t / ( $d + $d + $a ) . 's;
}
.hero-image div:nth-child(9) img{
  animation-delay: ' . $t / ( $d + $d ) . 's;
}
.hero-image div:nth-child(2) img{
  animation-delay: ' . $t / ( $d + $c ) . 's;
}
.hero-image div:nth-child(8) img{
  animation-delay: ' . $t / ( $d + $b ) . 's;
}
.hero-image div:nth-child(3) img{
  animation-delay: ' . $t / ( $b + $c ) . 's;
}
.hero-image div:nth-child(5) img{
  animation-delay: ' . $t / ( $d ) . 's;
}
.hero-image div:nth-child(7) img{
  animation-delay: ' . $t / ( $c ) . 's;
}
.hero-image div:nth-child(4) img{
  animation-delay: ' . $t / ( $b ) . 's;
}
.hero-image div:nth-child(6) img{
  animation-delay: ' . $t / ( $a ) . 's;
}
';
}

?>
</style>
</svg>

<section class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
	<?php

	echo '<div class="hero-content">
      <h1>' . $content_section['heading'] . '</h1>';
	if ( ! empty( $content_section['sub_heading'] ) ) {
		echo '<div class="hero-subs">' . $content_section['sub_heading'] . '</div>';
	}
	echo '</div>';

	echo '<div class="hero-image">';
	foreach ( $image_section as $image ) {
		if ( $image ) {
			$image = $image['image'];
			echo '<div><img ' . $data_pre . 'src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '"></div>';
		}
	}
	echo '</div>';

	?>
	</div>
</section>
