<?php
/**
 * Rebrand Hero Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-hero-section yb-sec come-out rebrand-hero-v4' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields      = $block_data['fields_data'];
$class_name      = $block_data['classes'];
$theme_version   = $block_data['theme_version'];
$content_section = $acf_fields['content_section'];
$image_section   = $acf_fields['image_section'];

if ( ! empty( $acf_fields['section_class'] ) ) {
	$class_name .= ' ' . $acf_fields['section_class'];
}
?>
<svg style="display:none;">
	<style>
		<?php require 'style.css'; ?>
	</style>
</svg>

<section class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="hero-content">
			<h1><?php echo $content_section['heading']; ?></h1>
			<?php
			foreach ( $content_section['sub_heads'] as $sub_head ) {
				if ( $sub_head ) {
					?>
					<div class="yb-hero-subhead"><?php echo $sub_head['sub_head']; ?></div>
					<?php
				}
			}

			if ( ! empty( $content_section['ctas'] ) ) {
				?>
				<div class="yb-hero-ctas">
				<?php
				foreach ( $content_section['ctas'] as $cta ) {
					if ( $cta ) {
						$icon     = $cta['cta_icon'];
						$theme    = $cta['cta_theme'];
						$cta_link = $cta['cta'];
						if ( '_blank' === $cta_link['target'] ) {
							$link_target = ' target="_blank" rel="noopener"';
						}

						?>
						<a class="hero-btn <?php echo $icon . ' ' . $theme; ?>" href="<?php echo esc_url( $cta_link['url'] ); ?>" title="<?php echo esc_attr( $cta_link['title'] ); ?>"<?php echo $link_target; ?>><?php echo $cta_link['title']; ?></a>
						<?php
					}
				}
				?>
				</div>
			<?php } ?>
		</div>
		<?php if ( $image_section['image'] ) : ?>
			<div class="hero-image">
				<?php
				if ( false !== strpos( $image_section['image']['filename'], '.svg' ) ) {
					$upload_dir = wp_upload_dir();
					$svgPath    = explode( '/uploads', $image_section['image']['url'] );

					$svg_image = wp_remote_get( $image_section['image']['url'] );

					if ( is_array( $svg_image ) && ! is_wp_error( $svg_image ) ) {
						$headers = $svg_image['headers']; // Array of http header lines.
						$body    = $svg_image['body']; // Use the content.

						echo str_replace( '<?xml version="1.0" encoding="UTF-8"?>', '', $svg_image['body'] );
					}
				} else {
					?>
					<img class="skip-lazy" src="<?php echo $image_section['image']['url']; ?>" alt="<?php echo $image_section['image']['alt']; ?>" title="<?php echo $image_section['image']['title']; ?>" width="<?php echo $image_section['image']['width']; ?>"
						height="<?php echo $image_section['image']['height']; ?>">
					<?php
				}
				?>
			</div>
		<?php endif; ?>
	</div>
	<div class="hero-bg"></div>
</section>
