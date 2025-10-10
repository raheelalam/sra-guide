<?php
/**
 * Companies Logo Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'companies-logo cs-laypout loaded yb-sec' );
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
$bordered = '';
if ( empty( $acf_fields['cl_heading'] ) ) {
	$bordered = ' bordered';
}
?>

<?php if ( ! empty( $acf_fields['cl_heading'] ) ) : ?>
	<section class="<?php echo esc_attr( $class_name ) . '' . $bordered; ?>" data-lazy="market_leaders">
<?php else : ?>
	<div class="<?php echo esc_attr( $class_name ) . '' . $bordered; ?>" data-lazy="market_leaders">
<?php endif; ?>
	<svg style="display:none;"><style><?php require 'market-leaders.css'; ?></style></svg>
	<?php if ( ! empty( $acf_fields['cl_heading'] ) ) { ?>
		<div class="container">
			<div class="section-head">
				<h2><?php echo $acf_fields['cl_heading']; ?></h2>
			</div>
		</div>
		<?php
	} else {
		echo '<div class="companies-logos-bordered"></div>';
	}
	?>
	<div class="logo-wrap">
		<?php
		if ( $acf_fields['cl_logos'] ) {
			// Loop through rows.
			foreach ( $acf_fields['cl_logos'] as $logo_image ) {
				$logo_img     = $logo_image['cl_company_logo'];
				$logo_margin  = '';
				$logo_padding = '';
				$logo_height  = '';
				$logo_width   = '';

				if ( isset( $logo_image['margin'] ) && ! empty( $logo_image['margin'] ) ) {
					$logo_margin = ' style="margin:' . $logo_image['margin'] . '"';
				}

				if ( isset( $logo_image['padding'] ) && ! empty( $logo_image['padding'] ) ) {
					$logo_padding = ' style="padding:' . $logo_image['padding'] . '"';
				}

				if ( isset( $logo_img['height'] ) && ! empty( $logo_img['height'] ) ) {
					$logo_height = $logo_img['height'];
				}

				if ( isset( $logo_img['width'] ) && ! empty( $logo_img['width'] ) ) {
					$logo_width = $logo_img['width'];
				}
				echo '<div class="logo" ' . $logo_margin . '>
					<img ' . $data_pre . 'src="' . esc_url( $logo_img['url'] ) . '" alt="' . esc_attr( $logo_img['alt'] ) . '" title="' . esc_attr( $logo_img['title'] ) . '"' . $logo_padding . ' width="' . esc_attr( $logo_width ) . '" height="' . esc_attr( $logo_height ) . '">
				</div>';
			}
		}
		?>
	</div>
	<script>function market_leaders(){yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/market-leaders/market-leaders.js?<?php echo $theme_version; ?>', 'BODY', 'market-leaders', function () {});}</script>
<?php if ( ! empty( $acf_fields['cl_heading'] ) ) : ?>
	</section>
<?php else : ?>
	</div>
<?php endif; ?>
