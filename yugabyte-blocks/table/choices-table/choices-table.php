<?php
/**
 * Choices Table Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-choices-table yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
?>
<svg style="display:none;">
<style>
<?php
require 'choices-table.css';
if ( ! empty( $acf_fields['nav_srart_color'] ) ) {
	echo '.yb-ct-nav .purple-bar{background:' . $acf_fields['nav_srart_color'] . '}';
}
if ( ! empty( $acf_fields['nav_end_color'] ) ) {
	echo '.yb-ct-range{background:' . $acf_fields['nav_end_color'] . '}';
}
?>
</style>
</svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="choice_table" id="deployment-choices">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['heading']; ?></h2>
			<?php
			if ( ! empty( $acf_fields['link'] ) ) {
				$link_target = '';
				if ( '_blank' === $acf_fields['link']['target'] ) {
					$link_target = ' target="_blank" rel="noopener"';
				}
				?>
				<a class="yb--link-white" href="<?php echo esc_url( $acf_fields['link']['url'] ); ?>" title="<?php echo esc_attr( $acf_fields['link']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $acf_fields['link']['title']; ?></a>
				<?php
			}

			$table        = $acf_fields['table'];
			$tableLabel   = $table['table_labels'];
			$tableHead    = $table['table_heads'];
			$tableContent = $table['table_content'];

			$tdBorderCol = array(
				'column1' => '',
				'column2' => '#fff',
				'column3' => '#fff',
				'column4' => '#fff',
				'column5' => '#fff',
			);
			?>
		</div>
		<div class="section-copy">
			<div class="yb-ct-wrap active-1">
				<div class="yb-ct table-col-<?php echo $table['columns']; ?>">
					<div class="mobile-thead-title"><?php echo $tableHead['table_head_1']['title']; ?></div>
					<table>
						<thead>
							<tr>
								<th class="th-label"><?php echo $tableLabel['table_label_1']['title']; ?></th>
								<?php
								for ( $tth = 2; $tth <= $table['columns']; $tth++ ) :
									$thColor   = $tableLabel[ 'table_label_' . $tth ]['color'];
									$thLabel   = $tableLabel[ 'table_label_' . $tth ]['title'];
									$thColspan = $tableLabel[ 'table_label_' . $tth ]['colspan'];
									$styleAttr = '';

									$tdBorderCol[ 'column' . $tth ] = $thColor;
									if ( 2 === (int) $thColspan ) {
										++$tth;
										$tdBorderCol[ 'column' . $tth ] = $thColor;
									}

									if ( '#fff' !== $thColor ) {
										$styleAttr = 'style="color:#fff; background:' . $thColor . '"';
									}

									if ( '' !== $thLabel ) :
										?>
									<th class="th-label" colspan="<?php echo $thColspan; ?>" <?php echo $styleAttr; ?>>
										<?php echo $thLabel; ?>
									</th>
										<?php
									endif;
								endfor;
								?>
							</tr>
							<tr>
								<?php for ( $tth = 1;$tth <= $table['columns']; $tth++ ) : ?>
								<th>
									<?php
									echo $tableHead[ 'table_head_' . $tth ]['title'];
									if ( isset( $tableHead[ 'table_head_' . $tth ]['sub_text'] ) && ! empty( $tableHead[ 'table_head_' . $tth ]['sub_text'] ) ) {
										?>
										<span class="th-sub-text"><?php echo $tableHead[ 'table_head_' . $tth ]['sub_text']; ?></span>
										<?php
									}

									if ( array_key_exists( 'link', $tableHead[ 'table_head_' . $tth ] ) && ! empty( $tableHead[ 'table_head_' . $tth ]['link'] ) ) {
										$link        = $tableHead[ 'table_head_' . $tth ]['link'];
										$link_target = '';
										if ( '_blank' === $link['target'] ) {
											$link_target = ' target="_blank" rel="noopener"';
										}
										?>
										<a class="yb--link-white thead-link" href="<?php echo esc_url( $link['url'] ); ?>" title="<?php echo esc_attr( $link['title'] ); ?>"<?php echo $link_target; ?>><span><?php echo $link['title']; ?></span></a>
									<?php } ?>
								</th>
								<?php endfor; ?>
							</tr>
						</thead>
						<tbody>
							<?php
							if ( ! empty( $table['heading_td'] ) ) {
								echo '<tr><th colspan="' . $table['columns'] . '">' . $table['heading_td'] . '</th></tr>';
							}

							foreach ( $tableContent['content_row'] as $contentRow ) :
								echo '<tr>';
								if ( $contentRow ) :
									for ( $td = 1; $td <= $table['columns']; $td++ ) :
										$display_class   = $contentRow[ 'table_content_' . $td ]['display'];
										$display_content = $contentRow[ 'table_content_' . $td ]['text'];
										$styleBrdAttr    = '';
										if ( '' !== $tdBorderCol[ 'column' . $td ] ) {
											$styleBrdAttr = 'style=" border-color:' . $tdBorderCol[ 'column' . $td ] . '"';
										}
										?>
										<td class="<?php echo $display_class; ?>" <?php echo $styleBrdAttr; ?>>
											<?php
											if ( ! empty( $display_content ) ) {
												echo $display_content;
											}
											?>
										</td>
										<?php
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

<script>
function choice_table() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/table/choices-table/choices-table.js?1<?php echo $theme_version; ?>', 'BODY','choice-table');
}
</script>
