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

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-hero-section yb-sec come-out rebrand-hero-v1' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields = $block_data['fields_data'];
$class_name = $block_data['classes'];

if ( ! empty( $acf_fields['extra_class'] ) ) {
	$class_name = $class_name . ' ' . $acf_fields['extra_class'];
}
$content_section = $acf_fields['content_section'];
$image_section   = $acf_fields['image_section'];
?>
<svg style="display:none;"><style>
	<?php require 'style.css'; ?>
</style></svg>

<section class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="hero-content">
			<h1><?php echo $content_section['heading']; ?></h1>

			<?php
			foreach ( $content_section['sub_heads'] as $sub_head ) {
				if ( $sub_head ) {
					echo '<div class="yb-hero-subhead">' . $sub_head['sub_head'] . '</div>';
				}
			}

			if ( ! empty( $content_section['ctas'] ) ) {
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
		if ( isset( $image_section['image'] ) && ! empty( $image_section['image'] ) ) :
			$image_class = '';
			if ( isset( $image_section['image_sticky'] ) && 1 === (int) $image_section['image_sticky'] ) {
				$image_class = ' sticky';
			}
			?>
			<div class="hero-image<?php echo $image_class; ?>">
				<img class="skip-lazy" src="<?php echo $image_section['image']['url']; ?>" alt="<?php echo $image_section['image']['alt']; ?>" title="<?php echo $image_section['image']['title']; ?>" width="<?php echo $image_section['image']['width']; ?>" height="<?php echo $image_section['image']['height']; ?>">
			</div>
		<?php endif; ?>
	</div>
	<div class="hero-bg">
		<?php
		if ( ! empty( $acf_fields['extra_class'] )
			&& ( 'contact-page' === $acf_fields['extra_class'] || false !== strpos( $acf_fields['extra_class'], 'yb-vs' ) )
		) :
			?>

			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>

			<?php
		endif;
		?>
	</div>
</section>
