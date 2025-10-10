<?php
/**
 * Yugabyte University Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-university yb-sec' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
$data_pre      = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}
?>
<svg style="display:none;"><style>
<?php require 'university.css'; ?>
</style></svg>

<section class="<?php echo esc_attr( $class_name ); ?>" data-lazy="ybuni">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['heading']; ?></h2>
		</div>
		<?php
		$field_object = get_field_object( 'field_6582aaff211fb' ); // Field fixed key.
		echo '<div class="yb-uni-tabs">
      <div class="tab active">Popular</div>';
		foreach ( $field_object['choices'] as $key => $choice ) {
			echo '<div class="tab">' . $choice . '</div>';
		}
		echo '</div>
      <div class="yb-uni-wrap owl-carousel">';
		foreach ( $acf_fields['cards'] as $card ) {
			if ( $card && 1 === (int) $card['popular'] ) {
				$image   = $card['image'];
				$details = $card['details'];
				$title   = $details['title'];
				$lessons = $details['lessons'];
				$price   = $details['price'];
				$url     = $card['url'];
				echo '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '" target="_blank" rel="noopener">
					<span class="img"><img ' . $data_pre . 'src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . esc_attr( $image['title'] ) . '" width="' . $image['width'] . '" height="' . $image['height'] . '"></span>
					<span class="details">
						<span class="title">' . $title . '</span>
						<span class="lessons">
							<span class="duration">' . $lessons . ' LESSONS</span>
							<span class="price">' . $price . '</span>
						</span>
					</span>
				</a>';
			}
		}
		echo '</div>';
		$types = array();
		foreach ( $acf_fields['cards'] as $card ) {
			if ( $card && isset( $card['type'] ) && ! in_array( $card['type'], $types ) ) {
				$types[] = $card['type'];
			}
		}

		foreach ( $types as $type ) {
			echo '<div class="yb-uni-wrap owl-carousel" style="display:none">';
			foreach ( $acf_fields['cards'] as $card ) {
				if ( $card && $card['type'] === $type ) {
					$image   = $card['image'];
					$details = $card['details'];
					$title   = $details['title'];
					$lessons = $details['lessons'];
					$price   = $details['price'];
					$url     = $card['url'];
					echo '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '" target="_blank" rel="noopener">
						<span class="img"><img ' . $data_pre . 'src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . esc_attr( $image['title'] ) . '" width="' . $image['width'] . '" height="' . $image['height'] . '"></span>
						<span class="details">
							<span class="title">' . $title . '</span>
							<span class="lessons">
								<span class="duration">' . $lessons . ' LESSONS</span>
								<span class="price">' . $price . '</span>
							</span>
						</span>
					</a>';
				}
			}
			echo '</div>';
		}

		$link = $acf_fields['cta'];
		if ( ! empty( $link ) ) {
			$link_target = '';
			if ( '_blank' === $link['target'] ) {
				$link_target = 'target="_blank" rel="noopener"';
			}
			echo '<div class="cta text-center">
        <a class="yb--link-black cta-button-small" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '" ' . $link_target . '>' . $link['title'] . '</a>
      </div>';
		}
		?>
		</div>
</section>
<script>
function ybuni() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/university/university.js?<?php echo $theme_version; ?>', 'BODY','ybuni');
}
</script>
