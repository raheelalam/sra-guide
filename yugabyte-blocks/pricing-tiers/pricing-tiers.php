<?php
/**
 * Pricing Tiers Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-pricing-tiers yb-sec section-bg-dark come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];

?>
<svg style="display:none;"><style>
	<?php require 'pricing-tiers.css'; ?>
</style></svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="pricing_tiers">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['heading']; ?></h2>
		</div>

		<div class="pricing-tier-cards">
			<?php
			foreach ( $acf_fields['cards'] as $card ) {
				if ( $card ) {
					echo '<div class="pricing-tier-card">
						<div class="pricing-tier-title">' . $card['title'] . '</div>
						<div class="pricing-tier-details">' . $card['details'] . '</div>
						<div class="pricing-tier-bottom">
							<div class="pricing-tier-eyebrow">' . $card['bottom']['eyebrow_text'] . '</div>';
					if ( ! empty( $card['bottom']['price'] ) && ! empty( $card['bottom']['price_subs'] ) ) {
						echo '<div class="pricing-tier-price">' . $card['bottom']['price'] . '
									<div class="pricing-tier-price-subs">' . $card['bottom']['price_subs'] . '</div></div>';
					} elseif ( ! empty( $card['bottom']['price_subs'] ) ) {
						echo '<div class="pricing-tier-price-subs">' . $card['bottom']['price_subs'] . '</div>';
					}
					$link = $card['bottom']['button'];
					if ( ! empty( $link ) ) {
						$link_target = '';
						if ( '_blank' === $link['target'] ) {
							$link_target = ' target="_blank" rel="noopener"';
						}
						echo '<a class="yb--link-white cta-button-small" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '"' . $link_target . '>' . $link['title'] . '</a>';
					}
					echo '</div>
					</div>';
				}
			}
			?>
		</div>
		<?php
		$viewsTxt = $acf_fields['table_views_text'];
		$viewsBtn = $acf_fields['table_views_button'];
		if ( ! empty( $viewsBtn ) ) {
			echo '<div class="table-view">' . $viewsTxt . ' <span class="table-view-span">' . $viewsBtn . '</span></div>';

			$tableHead    = $acf_fields['table']['head_area'];
			$tableContent = $acf_fields['table']['content_area'];
			$tableFoot    = $acf_fields['table']['foot_area'];

			echo '<div class="pricing-table hide-table"><table>
        <thead>
          <tr>
            <th>' . $tableHead['col-1_title'] . '</th>
            <th>' . $tableHead['col-2_title'] . '</th>
          </tr>
        </thead>
        <tbody>
        ';
			foreach ( $tableContent as $content ) {
				if ( $content ) {
					echo '<tr>
              <td>' . $content['col-1'] . '</td>
              <td>' . $content['col-2'] . '</td>
            </tr>';
				}
			}
			echo '</tbody>
        <tfoot>
          <tr>
            <td colspan="2">' . $tableFoot . '</td>
          </tr>
        </tfoot>
      </table></div>';
		}
		?>
	</div>
</div>

<script>
function pricing_tiers() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/pricing-tiers/pricing-tiers.js?1.3<?php echo $theme_version; ?>', 'BODY','pricing_tiers');
}
</script>
