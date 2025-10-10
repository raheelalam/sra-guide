<?php
/**
 * About Leadership Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-about-leadership-section yb-sec come-out' );
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
	<?php echo require 'about-leadership.css'; ?>
</style></svg>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">

	<div class="section-head">
		<h2><?php echo $acf_fields['heading']; ?></h2>
	</div>

	<div class="section-copy">

		<div class="about-leadership-wrap">
		<?php
		echo '<div class="about-leadership-details"><span>' . $acf_fields['summary'] . '</span></div>';
		foreach ( $acf_fields['cards'] as $card ) {
			if ( $card ) {
				$image       = $card['image'];
				$name        = $card['name'];
				$designation = $card['designation'];
				echo '<div class="about-leadership-card">';
				echo '<img ' . $data_pre . 'src="' . esc_url( $image['url'] ) . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '">';
				echo '<div class="about-leadership-name">' . $name . '</div>';
				echo '<div class="about-leadership-desg">' . $designation . '</div>';
				echo '</div>';
			}
		}
		?>
		</div>
		<div class="about-staff-wrap">
		<?php
		foreach ( $acf_fields['staff'] as $staff ) {
			if ( $staff ) {
				echo '<div class="about-staff-title">' . $staff['title'] . '</div>';
				foreach ( $staff['cards'] as $card ) {
					if ( $card ) {
						$card  = $card['staff_member'];
						$image = $card['image'];
						$name  = $card['name'];
						echo '<div class="about-staff-card">';
						echo '<img ' . $data_pre . 'src="' . esc_url( $image['url'] ) . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '">';
						echo '<div class="about-staff-name">' . $name . '</div>';
						if ( ! empty( $card['designation'] ) ) {
							echo '<div class="about-staff-desg">' . $card['designation'] . '</div>';
						}
						echo '</div>';
					}
				}
			}
		}
		?>
		</div>

		</div>

	</div>
</div>
