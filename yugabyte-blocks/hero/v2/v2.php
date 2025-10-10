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

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-hero-section yb-sec come-out rebrand-hero-v2' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields = $block_data['fields_data'];
$class_name = $block_data['classes'];

$bg_image        = $acf_fields['image'];
$content_section = $acf_fields['content_section'];
if ( ! empty( $acf_fields['extra_class'] ) ) {
	$class_name = $class_name . ' ' . $acf_fields['extra_class'];
}
?>
<svg style="display:none;">
<style>
<?php require 'style.css'; ?>
</style>
</svg>

<section class="<?php echo esc_attr( $class_name ); ?>">
	<?php
	$noimage = ' no-image';
	if ( isset( $bg_image ) && ! empty( $bg_image ) ) {
		$noimage = '';
	}
	?>
	<div class="container<?php echo $noimage; ?>">
		<div class="hero-content">
			<h1><?php echo $content_section['heading']; ?></h1>
		<?php
		if ( isset( $bg_image ) && ! empty( $bg_image ) ) {
			echo '<div class="image-area">';
			echo '<img loading="eager" class="skip-lazy" src="' . $bg_image['url'] . '" alt="' . $bg_image['alt'] . '" title="' . $bg_image['title'] . '" width="' . $bg_image['width'] . '" height="' . $bg_image['height'] . '">';
			echo '</div>';
		}
		?>
		</div>
		<div class="hero-subs">
		<?php
		if ( isset( $content_section['sub_heads'] ) ) {
			echo '<div class="yb-hero-subheads">';
			foreach ( $content_section['sub_heads'] as $sub_head ) {
				if ( $sub_head ) {
					echo '<div class="yb-hero-subhead">' . $sub_head['sub_head'] . '</div>';
				}
			}
			echo '</div>';
		}
		if ( isset( $content_section['ctas'] ) && ! empty( $content_section['ctas'] ) ) {
			echo '<div class="yb-hero-ctas">';
			foreach ( $content_section['ctas'] as $cta ) {
				if ( $cta ) {
					$icon  = $cta['cta_icon'];
					$theme = ' ' . $cta['cta_theme'];
					if ( 'git-icon' === $icon ) {
						$theme = '';
					}
					$cta         = $cta['cta'];
					$link_target = '';
					if ( '_blank' === $cta['target'] ) {
						$link_target = ' target="_blank" rel="noopener"';
					}
					echo '<a class="hero-btn ' . $icon . $theme . '" href="' . esc_url( $cta['url'] ) . '" title="' . esc_attr( $cta['title'] ) . '"' . $link_target . '>' . $cta['title'] . '</a>';
				}
			}
			echo '</div>';
		}
		?>
	</div>
	</div>
</section>
