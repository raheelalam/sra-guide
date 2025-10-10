<?php
/**
 * Consumption Models Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-consumption-models yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
?>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="consumption_models">
	<svg style="display:none;"><style><?php require 'consumption-models.css'; ?></style></svg>
	<div class="container">
		<?php
			$table_columns = $acf_fields['columns'];
			$tableBody     = $acf_fields['table_body'];
		?>
		<div class="section-copy">
			<div class="yb-cm-wrap">
				<div class="yb-cm table-col-<?php echo $table_columns; ?>" data-col="<?php echo $table_columns; ?>">
					<table>
						<thead>
						<tr>
							<?php
							for ( $i = 1; $i <= $table_columns; ++$i ) :
								$headVar = $acf_fields['table_heads'][ 'table_head_' . $i ]
								?>
								<th>
									<span class="th-title"><?php echo $headVar['title']; ?></span>
									<?php if ( isset( $headVar['sub_text'] ) && ! empty( $headVar['sub_text'] ) ) : ?>
										<span class="th-sub-text"><?php echo $headVar['sub_text']; ?></span>
										<?php
									endif;
									if ( ! empty( $headVar['link'] ) ) :
										?>
										<a class="yb--link-black" href="<?php echo esc_url( $headVar['link']['url'] ); ?>"
											title="<?php echo esc_attr( $headVar['link']['title'] ); ?>"
											<?php
											if ( '_blank' === $headVar['link']['target'] ) {
												echo 'target="_blank" rel="noopener"';
											}
											?>
											>
											<span><?php echo $headVar['link']['title']; ?></span>
										</a>
									<?php endif; ?>
								</th>
							<?php endfor; ?>
						</tr>
						</thead>
						<?php
						$headingArray = array();
						foreach ( $tableBody as $bodyGroup ) :
							$contentRow = $bodyGroup['content_row'];

							array_push( $headingArray, $bodyGroup['heading_td'] );
							?>
							<tbody>
								<tr class="heading-row">
									<td class="heading" colspan="<?php echo $table_columns; ?>">
										<span id="<?php echo strtolower( str_replace( ' ', '-', $bodyGroup['heading_td'] ) ); ?>"></span><?php echo $bodyGroup['heading_td']; ?>
									</td>
								</tr>
								<?php foreach ( $contentRow as $contentRows ) : ?>
									<tr>
										<?php
										for ( $j = 1; $j <= $table_columns; ++$j ) {
											$tdVar = $contentRows[ 'table_content_' . $j ];
											if ( isset( $tdVar['display'] ) && 'check' === $tdVar['display'] ) {
												echo '<td class="td-check"><span><svg width="16" height="11" viewBox="0 0 16 11" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3745 1.70718L6.66739 10.4143L0.626953 4.37385L2.04117 2.95964L6.66739 7.58586L13.9603 0.292969L15.3745 1.70718Z" fill="#121017"/> </svg></span></td>';
											} elseif ( isset( $tdVar['display'] ) && 'cross' === $tdVar['display'] ) {
												echo '<td class="td-cross"><span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.99942 5.58521L11.6257 0.958984L13.0399 2.3732L8.41364 6.99942L13.0399 11.6257L11.6257 13.0399L6.99942 8.41364L2.3732 13.0399L0.958984 11.6257L5.58521 6.99942L0.958984 2.3732L2.3732 0.958984L6.99942 5.58521Z" fill="#B1AEBD"/> </svg></span></td>';
											} else {
												echo '<td class="td-text"><span>' . $tdVar['text'] . '</span></td>';
											}
											?>
										<?php } ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						<?php endforeach; ?>
					</table>
					<div class="float-menu">
						<span class="active-heading"><?php echo $headingArray[0]; ?></span>
						<ul>
							<?php foreach ( $headingArray as $key => $items ) : ?>
								<li class="
								<?php
								if ( 0 === $key ) {
									echo 'active';
								}
								?>
								">
									<a href="<?php echo '#' . strtolower( str_replace( ' ', '-', $items ) ); ?>"><span><?php echo $items; ?></span></a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="differences-menu">
						<div class="check-btn"></div>
						<span class="text">Show only differences</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>function consumption_models() {yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/table/consumption-models/consumption-models.js?<?php echo $theme_version; ?>', 'BODY','consumption-models');}</script>
</div>
