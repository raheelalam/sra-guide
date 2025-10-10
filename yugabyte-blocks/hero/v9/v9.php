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

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-hero-section yb-sec come-out rebrand-hero-v9' );
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
			<?php if ( ! empty( $content_section['sup_heading'] ) ) { ?>
				<div class="sup-text"><?php echo $content_section['sup_heading']; ?></div>
			<?php } ?>

			<h1><?php echo $content_section['heading']; ?></h1>
			<div class="yb-hero-subhead"><?php echo $content_section['sub_head']; ?></div>
			<?php if ( ! empty( $content_section['cta_sub_head'] ) && isset( $content_section['cta_sub_head'] ) ) { ?>
				<div class="content-cta-area">
				<?php
				$link        = $content_section['cta_sub_head'];
				$link_target = '';
				if ( '_blank' === $link['target'] ) {
					$link_target = ' target="_blank" rel="noopener"';
				}
				echo '<a class="yb--button-orange" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '>' . $link['title'] . '</a>';
				?>
				</div>
			<?php } ?>
		</div>
		<?php
		if ( isset( $image_section['image'] ) && ! empty( $image_section['image'] ) ) :
			$image_class = '';
			if ( isset( $image_section['image_sticky'] ) && 1 === (int) $image_section['image_sticky'] ) {
				$image_class = ' sticky';
			}
			?>
			<div class="hero-image <?php echo $image_class; ?>">
				<img class="skip-lazy" src="<?php echo $image_section['image']['url']; ?>" alt="<?php echo $image_section['image']['alt']; ?>" title="<?php echo $image_section['image']['title']; ?>" width="<?php echo $image_section['image']['width']; ?>" height="<?php echo $image_section['image']['height']; ?>">
			</div>
		<?php endif; ?>

		<?php
		if ( ! empty( $content_section['ctas'] ) ) {
			$fixedWidthClass = '';
			$fixedWidth      = $content_section['ctas_fixed_width'];
			if ( $fixedWidth ) {
				$fixedWidthClass = ' cta-fixed';
			}
			echo '<div class="yb-hero-ctas ' . $fixedWidthClass . '">';
			foreach ( $content_section['ctas'] as $cta ) {
				if ( $cta ) {
					$cta         = $cta['cta'];
					$link_target = '';
					if ( '_blank' === $cta['target'] ) {
						$link_target = ' target="_blank" rel="noopener"';
					}
					echo '<a class="hero-btn orange-arrow-icon " href="' . esc_url( $cta['url'] ) . '" title="' . esc_attr( $cta['title'] ) . '"' . $link_target . '><span>' . $cta['title'] . '</span></a>';
				}
			}
			echo '</div>';
		}
		?>

	</div>

</section>
