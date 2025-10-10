<?php
/**
 * Success Stories Section Block Version-2 Template.
 *
 * @param array  $block           The block settings and attributes.
 * @param string $content         The block inner HTML (empty).
 * @param bool   $is_preview True During backend preview render.
 * @param int    $post_id         The post ID the block is rendering content against.
 * @param array  $context         The context provided to the block by the post or it's parent block.
 */

$class_name    = 'yb-success-stories yb-sec section-bg-dark come-out';
$fields_data   = $block['data'];
$items_class   = 'single-item';
$theme_version = yugabyte_theme_version();
$data_pre      = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}

if ( isset( $fields_data['theme_style'] ) && ! empty( $fields_data['theme_style'] ) ) {
	$class_name .= ' section-bg-' . $fields_data['theme_style'];
}

if ( 1 < $fields_data['ss_cards'] ) {
	$items_class = 'owl-carousel multiple-items';
}
?>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="success_stories_v2">
	<?php
	if ( ! isset( $block['className'] )
		|| false === strpos( $block['className'], 'repeated-block' )
	) :
		?>
		<svg style="display:none;"><style><?php require 'success-stories-v2.css'; ?></style></svg>
	<?php endif; ?>
	<div class="container">
		<?php if ( isset( $fields_data['ss_heading'] ) && ! empty( $fields_data['ss_heading'] ) ) : ?>
			<div class="section-head">
				<p><?php echo $fields_data['ss_heading']; ?></p>
			</div>
		<?php endif; ?>

		<?php if ( isset( $fields_data['ss_cards'] ) && 0 < $fields_data['ss_cards'] ) : ?>
			<div class="container-inner-aside">
				<div class="yb-success-items yb-ss-v2 <?php echo esc_attr( $items_class ); ?>">
					<?php
					for ( $i = 0; $i < $fields_data['ss_cards']; ++$i ) {
						$data_vid = '';
						if ( isset( $fields_data[ 'ss_cards_' . $i . '_youtube_id' ] )
							&& ! empty( $fields_data[ 'ss_cards_' . $i . '_youtube_id' ] )
						) {
							$data_vid = 'data-vid="' . $fields_data[ 'ss_cards_' . $i . '_youtube_id' ] . '"';
						}

						$success_video = '';
						if ( isset( $fields_data[ 'ss_cards_' . $i . '_video_thumbnail' ] ) && is_numeric( $fields_data[ 'ss_cards_' . $i . '_video_thumbnail' ] ) ) {
							$video_thumbnail_url = wp_get_attachment_url( $fields_data[ 'ss_cards_' . $i . '_video_thumbnail' ] );
							if ( is_string( $video_thumbnail_url ) ) {
								$thumbnail_title = get_the_title( $fields_data[ 'ss_cards_' . $i . '_video_thumbnail' ] );
								$video_thumbnail = wp_get_attachment_metadata( $fields_data[ 'ss_cards_' . $i . '_video_thumbnail' ] );
								$success_video   = '<span class="yb-success-vid-thumb">
									<img ' . $data_pre . 'src="' . esc_url( $video_thumbnail_url ) . '" alt="' . esc_attr( $thumbnail_title ) . '" title="' . esc_attr( $thumbnail_title ) . '" width="' . esc_attr( $video_thumbnail['width'] ) . '" height="' . esc_attr( $video_thumbnail['height'] ) . '">
								</span>';
							}
						}

						$logo_title   = '';
						$success_logo = '';
						if ( isset( $fields_data[ 'ss_cards_' . $i . '_logo' ] ) && is_numeric( $fields_data[ 'ss_cards_' . $i . '_logo' ] ) ) {
							$image_url = wp_get_attachment_url( $fields_data[ 'ss_cards_' . $i . '_logo' ] );
							if ( is_string( $image_url ) ) {
								$image        = wp_get_attachment_metadata( $fields_data[ 'ss_cards_' . $i . '_logo' ] );
								$logo_title   = get_the_title( $fields_data[ 'ss_cards_' . $i . '_logo' ] );
								$success_logo = '<img ' . $data_pre . 'src="' . esc_url( $image_url ) . '" alt="Customer Success Story: ' . esc_attr( $logo_title ) . '" title="Customer Success Story: ' . esc_attr( $logo_title ) . '" width="' . esc_attr( $image['width'] ) . '" height="' . esc_attr( $image['height'] ) . '">';
							}
						}

						$success_matrix = '';
						for ( $j = 0; $j < $fields_data[ 'ss_cards_' . $i . '_performance_points' ]; ++$j ) {
							$matrix_detail = '';
							$matrix_number = '';
							if ( isset( $fields_data[ 'ss_cards_' . $i . '_performance_points_' . $j . '_detail' ] )
								&& ! empty( $fields_data[ 'ss_cards_' . $i . '_performance_points_' . $j . '_detail' ] )
							) {
								$matrix_detail = $fields_data[ 'ss_cards_' . $i . '_performance_points_' . $j . '_detail' ];
							}

							if ( isset( $fields_data[ 'ss_cards_' . $i . '_performance_points_' . $j . '_performance' ] )
								&& ! empty( $fields_data[ 'ss_cards_' . $i . '_performance_points_' . $j . '_performance' ] )
							) {
								$matrix_number = $fields_data[ 'ss_cards_' . $i . '_performance_points_' . $j . '_performance' ];
							}

							if ( ! empty( $matrix_detail ) && ! empty( $matrix_number ) ) {
								$success_matrix .= '<span class="yb-success-achievement">
									<b>' . htmlspecialchars( $matrix_number, ENT_QUOTES, 'UTF-8' ) . '</b>
									<u>' . $matrix_detail . '</u>
								</span>';
							}
						}

						$story_link = '';
						if ( ! empty( $fields_data[ 'ss_cards_' . $i . '_story_link' ] ) ) {
							$author_name = '';
							if ( ! empty( $fields_data[ 'ss_cards_' . $i . '_vd_author_details' ] ) ) {
								$author      = $fields_data[ 'ss_cards_' . $i . '_vd_author_details' ];
								$author_name = explode( ',', $author );
								$author_name = $author_name[0];
							}

							$story_link = '<a href="' . esc_url( $fields_data[ 'ss_cards_' . $i . '_story_link' ] ) . '" title="Customer Success Story: ' . esc_attr( $logo_title ) . '">' . $author_name . '</a>';
						}
						?>

						<div class="yb-success-item item">
							<span class="yb-success-vid" <?php echo $data_vid; ?>>
								<?php echo $success_video; ?>
								<span class="yb-success-vid-author"><?php echo $fields_data[ 'ss_cards_' . $i . '_vd_author_details' ]; ?></span>
							</span>

							<div class="yb-success-content">
								<div class="yb-success-content-top">
									<span class="yb-success-thumb">
										<?php echo $success_logo; ?>
									</span>
									<div class="yb-success-quote">
										<?php echo '<blockquote>' . wpautop( $fields_data[ 'ss_cards_' . $i . '_description' ] ) . '</blockquote>'; ?>
									</div>
								</div>

								<?php echo $success_matrix; ?>
							</div>

							<?php echo $story_link; ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php
		endif;

		if ( isset( $fields_data['ctas'] ) && 0 < $fields_data['ctas'] ) {
			?>
			<div class="text-center">
				<?php
				for ( $i = 0; $i < $fields_data['ctas']; ++$i ) :
					$hero_cta = $fields_data[ 'ctas_' . $i . '_cta' ];
					if ( ! isset( $hero_cta, $hero_cta['title'], $hero_cta['url'] ) ) {
						continue;
					}

					if ( empty( $hero_cta['title'] ) || empty( $hero_cta['url'] ) ) {
						continue;
					}

					$link_target = '';
					if ( isset( $hero_cta['target'] ) && '_blank' === $hero_cta['target'] ) {
						$link_target = ' target="_blank" rel="noopener"';
					}

					$icon  = $fields_data[ 'ctas_' . $i . '_cta_icon' ];
					$theme = $fields_data[ 'ctas_' . $i . '_cta_theme' ];
					?>

					<a class="hero-btn <?php echo esc_attr( $icon ) . ' ' . esc_attr( $theme ); ?>" href="<?php echo esc_url( $hero_cta['url'] ); ?>" title="<?php echo esc_attr( $hero_cta['title'] ); ?>"<?php echo $link_target; ?>><?php echo $hero_cta['title']; ?></a>
				<?php endfor; ?>
			</div>
		<?php } ?>
	</div>

	<?php if ( ! isset( $block['className'] ) || false === strpos( $block['className'], 'repeated-block' ) ) : ?>
		<script>function success_stories_v2() {yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/success-stories-v2/success-stories-v2.js?v=<?php echo $theme_version; ?>', 'BODY','success-stories-v2', function () {yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/video-pop.js?v=<?php echo $theme_version; ?>', 'BODY','video-pop', function () {});});}</script>
	<?php endif; ?>
</div>
