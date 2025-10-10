<?php
/**
 * FAQ Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-faq-section yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}
$fields_data   = $block['data'];
$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];

$themeStyle = 'light';
if ( ! empty( $fields_data['theme_style'] ) ) {
	$themeStyle = $fields_data['theme_style'];
}
?>
<svg style="display:none;"><style>
	<?php require 'faq.css'; ?>

	</style></svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="faq">
	<div class="container">

	<div class="section-head">
		<h2><?php echo $acf_fields['faq_heading']; ?></h2>
	</div>

	<div class="aside-faq-container">

		<div class="yb-faq-items">
		<?php
		$counter = 0;
		foreach ( $acf_fields['faq_cards'] as $faq_card ) {
			++$counter;
			if ( $faq_card ) {
				$open = '';
				if ( 1 === $counter ) {
					$open = ' open';
				}
				echo '<div class="yb-faq-item' . $open . '">
					<span class="faq-button"></span>
					<div class="yb-faq-q">' . $faq_card['faq_q'] . '</div>
					<div class="yb-faq-a">' . $faq_card['faq_a'] . '</div>
				</div>';
			}
		}
		?>
		</div>
		<?php

		$asideTitle = $acf_fields['aside']['aside_title'];
		$link       = $acf_fields['aside']['faq_button'];
		if ( ! empty( $asideTitle ) || ! empty( $link ) ) {
			echo '<div class="yb-faq-aside">';
			if ( ! empty( $asideTitle ) ) {
				echo '<div class="yb-faq-aside-title">' . $asideTitle . '</div>';
			}
			if ( ! empty( $link ) ) {
				$link_target = '';
				if ( '_blank' === $link['target'] ) {
					$link_target = ' target="_blank" rel="noopener"';
				}
				$btnClass = 'yb--link-black';
				if ( 'dark' === $themeStyle ) {
					$btnClass = 'yb--link-white ';
				}
				echo '<a class="' . $btnClass . ' cta-button-small" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '>' . $link['title'] . '</a>';
			}
			echo '</div>';
		}
		?>
	</div>

	</div>
</div>

<script>
function faq() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/faq/faq.js?<?php echo $theme_version; ?>', 'BODY','faq');
}
</script>
