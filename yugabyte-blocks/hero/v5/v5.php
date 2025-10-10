<?php
/**
 * Rebrand Hero Block Template.
 *
 * @param array  $block           The block settings and attributes.
 * @param string $content         The block inner HTML (empty).
 * @param bool   $is_preview True During backend preview render.
 * @param int    $post_id         The post ID the block is rendering content against.
 * @param array  $context         The context provided to the block by the post or it's parent block.
 */

$class_name  = 'yb-hero-section yb-sec come-out rebrand-hero-v5';
$fields_data = $block['data'];

$section_class = '';
if ( isset( $fields_data['section_class'] ) && ! empty( $fields_data['section_class'] ) ) {
	$section_class = $fields_data['section_class'];
	$class_name   .= ' ' . $fields_data['section_class'];
}

if ( isset( $fields_data['theme_style'] ) && ! empty( $fields_data['theme_style'] ) ) {
	$class_name .= ' section-bg-' . $fields_data['theme_style'];
}

$hero_image_url = wp_get_attachment_url( $fields_data['image_section_image'] );
?>
<svg style="display:none;"><style>
	<?php require 'style.css'; ?>
</style></svg>

<section class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="hero-image">
			<?php
			if ( ! empty( $hero_image_url ) ) :
				$hero_image_meta  = wp_get_attachment_metadata( $fields_data['image_section_image'] );
				$hero_image_title = get_the_title( $fields_data['image_section_image'] );
				?>
				<img src="<?php echo esc_url( $hero_image_url ); ?>" alt="<?php echo esc_attr( $hero_image_title ); ?>" title="<?php echo esc_attr( $hero_image_title ); ?>" width="<?php echo esc_attr( $hero_image_meta['width'] ); ?>" height="<?php echo esc_attr( $hero_image_meta['height'] ); ?>">
				<?php
			endif;

			if ( isset( $fields_data['image_section_eyebrow_text'] ) && ! empty( $fields_data['image_section_eyebrow_text'] ) ) :
				?>
				<div class="hero-img-caption"><?php echo $fields_data['image_section_eyebrow_text']; ?></div>
			<?php endif; ?>
		</div>

		<div class="hero-content">
			<h1><?php echo $fields_data['content_section_heading']; ?></h1>
			<div class="yb-hero-ctas">
				<?php
				for ( $i = 0; $i < $fields_data['content_section_ctas']; ++$i ) {
					$hero_cta = $fields_data[ 'content_section_ctas_' . $i . '_cta' ];
					if ( ! isset( $hero_cta, $hero_cta['title'], $hero_cta['url'] ) ) {
						continue;
					}

					if ( empty( $hero_cta['title'] ) || empty( $hero_cta['url'] ) ) {
						continue;
					}

					$link_target = '';
					if ( isset( $hero_cta['target'] ) && '_blank' === $hero_cta['target'] ) {
						$link_target = ' target="_blank" rel="noopener"';
					}

					$icon  = $fields_data[ 'content_section_ctas_' . $i . '_cta_icon' ];
					$theme = $fields_data[ 'content_section_ctas_' . $i . '_cta_theme' ];
					?>

					<a class="hero-btn <?php echo esc_attr( $icon ) . ' ' . esc_attr( $theme ); ?>" href="<?php echo esc_url( $hero_cta['url'] ); ?>" title="<?php echo esc_attr( $hero_cta['title'] ); ?>"<?php echo $link_target; ?>><?php echo $hero_cta['title']; ?></a>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="hero-bg">
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span class="size-40"></span>
		<span class="size-24"></span>
		<span class="purple size-23"></span>
		<span class="purple size-26"></span>
		<span class="purple size-21"></span>
		<span class="purple size-22"></span>

		<?php if ( 'latest-release' === $section_class ) : ?>
			<!--<video autoplay muted loop><source src="/wp-content/themes/yugabyte/blocks/hero/v5/latest-release-left.mp4"></video>-->
<!--			<video autoplay muted loop playsinline><source src="/wp-content/themes/yugabyte/blocks/hero/v5/latest-release-right.mp4"></video>-->
		<?php endif; ?>
	</div>
</section>
