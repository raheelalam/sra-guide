<?php
/**
 * Contact Us Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-contact-us yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
?>

<svg style="display:none;"><style>
	<?php require 'contact-us.css'; ?>
</style></svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="contact_form">
	<div class="container">
		<div class="aside-contact-container">
			<div class="yb-contact-addresses">
				<?php
				foreach ( $acf_fields['addresses'] as $card ) :
					if ( $card ) :
						?>

						<div class="yb-contact-address">
							<span></span>
							<div class="yb-contact-title"><?php echo $card['title']; ?></div>
							<div class="yb-contact-details"><?php echo $card['details']; ?></div>
						</div>

						<?php
					endif;
				endforeach;
				?>
			</div>

			<?php
			$hubspot_form_id = $acf_fields['hubspot_form_id'];
			if ( $hubspot_form_id ) {
				?>
				<div class="yb-contact-form" data-form-id="<?php echo esc_attr( $hubspot_form_id ); ?>">
					<script>
					function contact_form() {
						yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/contact-us/contact-us.js?<?php echo $theme_version; ?>', 'BODY','contact_form');
					}
					</script>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
