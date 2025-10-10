<?php
/**
 * Bullet Features Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True During backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$class_name  = 'partners-highlights yb-sec come-out section-bg-dark';
$fields_data = $block['data'];

$data_pre = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}

if ( ! isset( $block['className'] ) || false === strpos( $block['className'], 'repeated-block' ) ) : ?>
	<svg style="display:none;">
		<style>
			<?php require 'partners-highlights.css'; ?>
		</style>
	</svg>
	<?php
endif;

if ( isset( $fields_data['theme_style'] ) && ! empty( $fields_data['theme_style'] ) ) {
	$class_name .= ' section-bg-' . $fields_data['theme_style'];
}


$block_data = yugabyte_block_data( $post_id, $block['name'], 'partners-highlights yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$heading_tag = 'h2';
$wire_style  = '';
if ( isset( $fields_data['inline_heading'] ) && 1 === (int) $fields_data['inline_heading'] ) {
	$heading_tag = 'p';
	$wire_style  = ' wire-style';
}
?>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container<?php echo esc_attr( $wire_style ); ?>">
		<div class="section-head">
			<?php
			if ( isset( $fields_data['features_heading'] ) && ! empty( $fields_data['features_heading'] ) ) {
				echo '<' . $heading_tag . '>' . $fields_data['features_heading'] . '</' . $heading_tag . '>';
			}
			?>
		</div>

		<?php if ( ! empty( $fields_data['heading_sub'] ) ) : ?>
			<div class="section-copy">
				<div class="copy-details">
				<?php echo wpautop( $fields_data['heading_sub'] ); ?>
				</div>
			</div>
			<?php
		endif;

		if ( 0 < $fields_data['feature_cards'] ) :
			?>
			<div class="partners-highlights-features-items">
			<?php
			for ( $i = 0; $i < $fields_data['feature_cards']; ++$i ) {
				if ( ! isset( $fields_data[ 'feature_cards_' . $i . '_feature_title' ] ) || empty( $fields_data[ 'feature_cards_' . $i . '_feature_title' ] ) ) {
					continue;
				}
				?>
				<div class="partners-highlights-feature-item ">
					<?php
					if ( isset( $fields_data[ 'feature_cards_' . $i . '_feature_logo' ] ) && ! empty( $fields_data[ 'feature_cards_' . $i . '_feature_logo' ] ) ) {
						$image_id    = $fields_data[ 'feature_cards_' . $i . '_feature_logo' ];
						$image_data  = wp_get_attachment_image_src( $image_id, 'full' );
						$alt_text    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
						$image_post  = get_post( $image_id );
						$image_title = $image_post->post_title;
						if ( ! empty( $image_id ) ) {
							?>
						<div class="feature-logo">
							<?php echo '<img ' . $data_pre . 'src="' . $image_data['0'] . '" alt="' . $alt_text . '" title="' . $image_title . '" width="' . $image_data['1'] . '" height="' . $image_data['2'] . '">'; ?>
						</div>
						<?php } ?>
					<?php } ?>
					<div class="feature-title"><?php echo $fields_data[ 'feature_cards_' . $i . '_feature_title' ]; ?></div>
					<?php if ( ! empty( $fields_data[ 'feature_cards_' . $i . '_feature_content' ] ) ) { ?>
						<div class="feature-content"> <?php echo $fields_data[ 'feature_cards_' . $i . '_feature_content' ]; ?></div>
					<?php } ?>
					<?php if ( ! empty( $fields_data[ 'feature_cards_' . $i . '_quotation' ] ) ) { ?>
						<div class="feature-quotes">
							<q><?php echo $fields_data[ 'feature_cards_' . $i . '_quotation' ]; ?></q>
							<div class="author">— <?php echo $fields_data[ 'feature_cards_' . $i . '_quotation_author' ]; ?></div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
			</div>
			<?php
		endif;
		if ( isset( $fields_data['cta'], $fields_data['cta']['url'] ) && ! empty( $fields_data['cta']['url'] ) ) {
			$link_target = '';
			$external    = '';
			if ( isset( $fields_data['cta']['target'] ) && '_blank' === $fields_data['cta']['target'] ) {
				$link_target = ' target="_blank" rel="noopener"';
				$external    = ' external-icon';
			}
			?>

			<div class="cta text-center">
				<a class="yb--link-black cta-button-small<?php echo $external; ?>" href="<?php echo esc_url( $fields_data['cta']['url'] ); ?>" title="<?php echo esc_attr( $fields_data['cta']['title'] ); ?>"<?php echo $link_target; ?>><?php echo $fields_data['cta']['title']; ?></a>
			</div>
		<?php } ?>
	</div>
</div>
