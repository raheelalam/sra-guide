<?php
/**
 * Pricing Table Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-pricing-models yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
?>
<svg style="display:none;">
	<style>
		<?php require 'pricing-table.css'; ?>
	</style>
</svg>
<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="consumption_models">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['heading']; ?></h2>
		</div>
		<?php
			$table_columns = $acf_fields['columns'];
			$table_body    = $acf_fields['table_body'];
		?>
		<div class="section-copy">
			<div class="yb-cm-wrap">
				<div class="yb-cm table-col-<?php echo $table_columns; ?>">
					<table>
						<thead>
							<tr>
								<?php
								for ( $i = 1; $i <= $table_columns; ++$i ) :
									$headVar = $acf_fields['table_heads'][ 'table_head_' . $i ]
									?>
									<th>
										<span class="th-title"><?php echo $headVar['title']; ?></span>
									</th>
								<?php endfor; ?>
							</tr>
						</thead>
						<?php
						foreach ( $table_body as $bodyGroup ) :
							$content_rows = $bodyGroup['content_row'];
							?>
							<tbody>
								<?php foreach ( $content_rows as $single_row ) : ?>
									<tr>
										<?php
										for ( $j = 1; $j <= $table_columns; ++$j ) {
											$table_row = $single_row[ 'table_content_' . $j ];

											if ( isset( $table_row['display'] ) ) {
												if ( 'check' === $table_row['display'] ) {
													echo '<td class="td-check"><span><svg width="16" height="11" viewBox="0 0 16 11" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3745 1.70718L6.66739 10.4143L0.626953 4.37385L2.04117 2.95964L6.66739 7.58586L13.9603 0.292969L15.3745 1.70718Z" fill="#121017"/> </svg></span></td>';
												} elseif ( 'cross' === $table_row['display'] ) {
													echo '<td class="td-cross"><span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.99942 5.58521L11.6257 0.958984L13.0399 2.3732L8.41364 6.99942L13.0399 11.6257L11.6257 13.0399L6.99942 8.41364L2.3732 13.0399L0.958984 11.6257L5.58521 6.99942L0.958984 2.3732L2.3732 0.958984L6.99942 5.58521Z" fill="#B1AEBD"></path> </svg></span></td>';
												} elseif ( 'Add-on' === $table_row['display'] ) {
													echo '<td class="td-addon"><span>Add-on</span></td>';
												} elseif ( 'tool-tip' === $table_row['display'] ) {
													echo '<td class="td-tooltip"><i>i<b>' . $table_row['note'] . '</b></i></td>';
												}
											} else {
												echo '<td class="td-text"><span>' . $table_row['text'];
												if ( ! empty( $table_row['include_note'] ) && 1 === (int) $table_row['include_note'] ) {
													echo '<i>i<b>' . $table_row['note'] . '</b></i>';
												}
												echo '</span></td>';
											}
										}
										?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
		</div>
		<div class="cta text-center">
			<?php
			if ( ! empty( $acf_fields['cta_section']['button'] ) ) :
				$link_target = '';
				if ( '_blank' === $acf_fields['cta_section']['button']['target'] ) {
					$link_target = ' target="_blank" rel="noopener"';
				}
				?>
				<a class="yb--link-black cta-button-small" href="<?php echo esc_url( $acf_fields['cta_section']['button']['url'] ); ?>" title="<?php echo esc_attr( $acf_fields['cta_section']['button']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $acf_fields['cta_section']['button']['title']; ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>
