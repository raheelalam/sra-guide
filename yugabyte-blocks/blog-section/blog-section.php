<?php
/**
 * Blog Section Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-blog-cards-section yb-sec' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}
$acf_fields    = $block_data['fields_data'];
$themeStyle    = $acf_fields['theme_styling'];
$class_name    = $block_data['classes'];

if ( !empty($themeStyle) && ($themeStyle == 'white') ) {
  $class_name  .= ' section-bg-white';
  $buttonClass = 'yb--link-black cta-button-small';
}else{
  $class_name  .= ' section-bg-dark';
  $buttonClass = 'yb--link-white cta-button-small';
}

$theme_version = $block_data['theme_version'];
$data_pre      = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}
?>
<svg style="display:none;">
<style>
<?php require 'blog-section.css'; ?>
</style>
</svg>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="blog_section">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['heading']; ?></h2>
		</div>
		<?php if ( ! empty( $acf_fields['sub_heading'] ) ) { ?>
			<div class="sub-header"><?php echo $acf_fields['sub_heading']; ?></div>
			<?php
		}
		$blog_cards = $acf_fields['blog_cards'];
		if ( isset( $blog_cards ) && ! empty( $blog_cards ) ) {
			?>
			<div class="section-copy">
				<div class="yb-blog-cards owl-carousel">
					<?php
					foreach ( $blog_cards as $blog_card ) {
						$link_target = '';
						if ( 'yes' === $blog_card['new_tab'] ) {
							$link_target = 'target="_blank" rel="noopener"';
						}
						?>
						<a class="yb-blog-card item" href="<?php echo esc_url( $blog_card['link'] ); ?>" <?php echo $link_target; ?>>
							<span class="yb-blog-card-image"><img <?php echo $data_pre; ?>src="<?php echo $blog_card['image']['url']; ?>" alt="<?php echo $blog_card['image']['alt']; ?>" title="<?php echo $blog_card['image']['title']; ?>" width="<?php echo $blog_card['image']['width']; ?>" height="<?php echo $blog_card['image']['height']; ?>"></span>
							<span class="yb-blog-card-title"><?php echo $blog_card['heading']; ?></span>
              <?php
              if($blog_card['eyebrow_text']){
                echo '<span class="yb-blog-read-time">'.$blog_card['eyebrow_text'].'</span>';
              }
              ?>
						</a>
						<?php
					}
					?>
				</div>
				<?php
				if ( isset( $acf_fields['cta'] ) && ! empty( $acf_fields['cta'] ) ) {
					$link_target = '';
					if ( '_blank' === $acf_fields['cta']['target'] ) {
						$link_target = 'target="_blank" rel="noopener"';
					}
					?>
					<div class="cta text-center">
						<a class="<?php echo $buttonClass; ?>" href="<?php echo esc_url( $acf_fields['cta']['url'] ); ?>" title="<?php echo esc_attr( $acf_fields['cta']['title'] ); ?>" <?php echo $link_target; ?>><?php echo $acf_fields['cta']['title']; ?></a>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</div>
<script>
function blog_section() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/blog-section/blog-section.js?<?php echo $theme_version; ?>', 'BODY','blog-section', function () {});
}
</script>
