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

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-hero-section yb-sec come-out rebrand-hero-v8' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];

if ( 'white' === $acf_fields['theme_style'] ) {
	$buttonTheme = 'dark';
} else {
	$buttonTheme = 'light';
}

$sub_heading = '';
if ( isset( $acf_fields['sub_heading'] ) && ! empty( $acf_fields['sub_heading'] ) ) {
	$sub_heading = '<div class="yb-hero-subhead">' . $acf_fields['sub_heading'] . '</div>';
}
?>

<svg style="display:none;">
<style><?php require 'style.css'; ?></style>
</svg>

<section class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="pre-section">
			<h1><?php echo $acf_fields['main_title']; ?></h1>
		</div>
		<?php echo $sub_heading; ?>
	</div>
</section>
