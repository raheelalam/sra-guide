<?php
/**
 * Supported Schedule a Demo Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'sec-form-with-content yb-sec come-out ' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
?>
<svg style="display:none;">
<style>
<?php require 'form-with-content.css'; ?>
</style>
</svg>
<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="schedule_demo">
	<div class="container">
		<div class="form-content-area">
			<div class="left-side-content wysiwyg-content">
				<?php echo $acf_fields['page_content']; ?>
			</div>
			<div class="right-form-area">
				<h2><?php echo $acf_fields['form_title']; ?></h2>
				<div class="hubspot-form-area" data-id="<?php echo $acf_fields['hubspot_form_id']; ?>"></div>
				<div class="footer-note"><?php echo $acf_fields['footer_note']; ?></div>
			</div>
		</div>
	</div>
</div>

<?php
// SET THE FORM.
$hubspot_form_id = $acf_fields['hubspot_form_id'];
if ( $hubspot_form_id ) {
	?>

	<script>
	function schedule_demo() {
		yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/form-with-content/form-with-content.js?<?php echo $theme_version; ?>', 'BODY','form-with-content', function () {});
	}
	</script>

	<?php
}
