<?php
/**
 * Press Framework Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-press-framework section-bg-dark yb-sec' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
?>
<svg style="display:none;">
<style>
<?php require 'press-framework.css'; ?>
</style>
</svg>

<section class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
	<?php

	echo '<div class="section-head">
		<h2>' . $acf_fields['section_title'] . '</h2>
	</div>
	<div class="section-copy">';

	if ( ! empty( $acf_fields['subs'] ) ) {
		echo '<div class="copy-details">' . $acf_fields['subs'] . '</div>';
	}

	echo '<div class="yb-framework-items">';
	foreach ( $acf_fields['cards'] as $card ) {
		if ( $card ) {
			echo '<div class="yb-framework-item">
              <div class="yb-framework-eyebrow">' . $card['eyebrow'] . '</div>
              <div class="yb-framework-title">' . $card['heading'] . '</div>
              <div class="yb-framework-content">' . $card['content'] . '</div>
              <span class="yb-framework-plus"></span>
            </div>';
		}
	}
	echo '</div>
    </div>';

	if ( ! empty( $acf_fields['cta'] ) ) {
		$link        = $acf_fields['cta'];
		$link_target = '';
		if ( '_blank' === $link['target'] ) {
			$link_target = ' target="_blank" rel="noopener"';
		}

		echo '<div class="cta text-center">
        <a class="yb--link-white cta-button-small" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '>' . $link['title'] . '</a>
      </div>';
	}

	?>
	</div>
</section>
