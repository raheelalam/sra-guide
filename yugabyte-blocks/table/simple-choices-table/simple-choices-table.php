<?php
/**
 * Simple Choices Table Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-simple-choices-table yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}
$fields_data   = $block['data'];
$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];

if ( ! empty( $fields_data['extra_settings'] ) && is_array( $fields_data['extra_settings'] ) ) {
	foreach ( $fields_data['extra_settings'] as $setting ) {
		$class_name .= ' style-' . $setting;
	}
}
?>
<svg style="display:none;">
<style>
<?php require 'simple-choices-table.css'; ?>
</style>
</svg>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="section-head">
			<?php
			if ( ! empty( $acf_fields['heading'] ) ) {
				echo '<h2>' . $acf_fields['heading'] . '</h2>';
			}

			$table         = $acf_fields['table'];
			$table_label   = $table['table_labels'];
			$table_content = $table['table_content'];
			?>
		</div>
		<div class="section-copy">
			<?php
			if ( ! empty( $acf_fields['subs'] ) ) {
				echo '<div class="subs">' . $acf_fields['subs'] . '</div>';
			}
			$table['columns'] = '4';
			?>
			<div class="yb-ct-wrap">
				<div class="yb-ct table-col-<?php echo $table['columns']; ?>">
					<table>
						<thead>
							<tr>
								<?php
								if ( isset( $table['hide_first_col'] ) && 1 !== (int) $table['hide_first_col'] ) {
									echo '<th class="th-label label-first">' . $table_label['table_label_1']['title'] . '</th>';
								}

								for ( $tth = 2; $tth <= $table['columns']; $tth++ ) :
									$th_color   = $table_label[ 'table_label_' . $tth ]['color'];
									$th_label   = $table_label[ 'table_label_' . $tth ]['title'];
									$style_attr = '';

									if ( '#fff' !== $th_color ) {
										$style_attr = 'style="color:#fff; background:' . $th_color . '"';
									}

									if ( '' !== $th_label ) :
										?>
										<th class="th-label" <?php echo $style_attr; ?>>
											<?php echo $th_label; ?>
										</th>

										<?php
									endif;
								endfor;
								?>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ( $table_content['content_row'] as $contentRow ) :
								echo '<tr>';
								if ( $contentRow ) :
									for ( $td = 1; $td <= $table['columns']; $td++ ) :
										$display_class   = $contentRow[ 'table_content_' . $td ]['display'];
										$display_content = $contentRow[ 'table_content_' . $td ]['text'];
										if ( isset( $contentRow[ 'table_content_' . $td ]['row_span'] ) ) {
											$row_span = $contentRow[ 'table_content_' . $td ]['row_span'];
											if ( 2 <= $row_span ) {
												echo '<td rowspan="' . $row_span . '" class="' . $display_class . '">';
												if ( ! empty( $display_content ) ) {
													echo $display_content;
												}
												echo '</td>';
											}
										} elseif ( ! empty( $display_content ) || 'Text' !== $display_class ) {
											echo '<td class="' . $display_class . '">';
											if ( ! empty( $display_content ) ) {
												echo $display_content;
											}

											if ( isset( $contentRow[ 'table_content_' . $td ]['append_text'] )
												&& ! empty( $contentRow[ 'table_content_' . $td ]['append_text'] )
											) {
												echo '<span>' . $contentRow[ 'table_content_' . $td ]['append_text'] . '</span>';
											}

											echo '</td>';
										}
									endfor;
								endif;
								echo '</tr>';
							endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
