<?php
/**
 * Events Community Meetup Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-events-community-meetup yb-sec section-bg-gray come-out' );
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
	<?php require 'events-community-meetup.css'; ?>
</style></svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="events_community_meetup">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['heading']; ?></h2>
		</div>
		<div class="sub-header"><?php echo $acf_fields['short_desc']; ?></div>

		<div class="yb-event-meetup-cards">
			<?php
			$i = 0;
			foreach ( $acf_fields['cards'] as $ss_card ) {
				if ( $ss_card ) {
					++$i;
					$formatted_i = sprintf( '%02d', $i );
					$title       = $ss_card['mu_loc'];
					$image       = $ss_card['img'];
					$desc        = $ss_card['desc'];
					$tempHide    = '';
					if ( $i > 6 ) {
						$tempHide = ' temp-hide';
					}
					echo '<a class="yb-emc-card' . $tempHide . '" href="' . esc_url( $ss_card['mu_url'] ) . '" title="' . esc_attr( $title ) . '" target="_blank" rel="noopener">
						<span class="yb-emc-number">' . $formatted_i . '</span>
						<span class="yb-emc-title">' . $title . '</span>
						<span class="yb-emc-thumb">
							<img ' . $data_pre . 'src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" title="' . esc_attr( $image['title'] ) . '" width="' . esc_attr( $image['width'] ) . '" height="' . esc_attr( $image['height'] ) . '">
						</span>';
					if ( ! empty( $desc ) ) {
						echo '<span class="yb-emc-desc">' . $desc . '</span>';
					}
					echo '</a>';
				}
			}
			?>
		</div>
		<?php
		if ( ! empty( $acf_fields['load_more'] ) ) {
			echo '<div class="cta text-center hidden"><a class="yb--link-black cta-button-small load-more" role="button" title="' . esc_attr( $acf_fields['load_more'] ) . '">' . esc_html( $acf_fields['load_more'] ) . '</a></div>';
		}
		?>
	</div>
</div>
<script>
function events_community_meetup() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/events-community-meetup/events-community-meetup.js?<?php echo $theme_version; ?>', 'BODY','events-community-meetup');
}
</script>
