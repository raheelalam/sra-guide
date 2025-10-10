<?php
/**
 * History Slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-history-slider-section yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$fields_data = $block['data'];

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
$data_pre      = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}

$page_theme = '';
if ( ! empty( $fields_data['extra_settings'] ) && is_array( $fields_data['extra_settings'] ) ) {
	foreach ( $fields_data['extra_settings'] as $setting ) {
		$class_name .= ' style-' . $setting;
	}
}

?>
<svg style="display:none;"><style>
	<?php require 'history-slider.css'; ?>
</style></svg>
<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="history_slider">
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['book_slider_heading']; ?></h2>
		</div>

		<?php if ( ! empty( $fields_data['short_description'] ) ) : ?>
		<div class="section-copy">
			<div class="copy-details">
				<?php echo wpautop( $fields_data['short_description'] ); ?>
			</div>
		</div>
		<?php endif; ?>

		<div class="yb-history-slider-items owl-carousel">
			<?php
			foreach ( $acf_fields['book_slider_cards'] as $book_slider_card ) {
				if ( $book_slider_card ) {
					echo '<div class="yb-history-slider-item item" data-dot="' . $book_slider_card['caption'] . '">
					<div class="yb-history-slide-left">
						<div class="yb-history-slide-title">'
						. $book_slider_card['slider_title'];

					echo '</div>';

					if ( ! empty( $book_slider_card['slider_subs'] ) ) {
						echo '<div  class="yb-history-slide-subtitle">' . $book_slider_card['slider_subs'] . '</div>';
					}

					echo '<div class="yb-history-slide-details">';
					if ( $book_slider_card['slider_description'] ) {
						echo '<div class="yb-history-slide-subs">' . $book_slider_card['slider_description'] . '</div>';
					}
					echo '</div>
					</div>
					<div class="yb-history-slide-right">';
					$option = $book_slider_card['image_cards'];
					if ( ! empty( $option ) && 'single-logo' === $option ) {
						$imgCard    = $book_slider_card['custom_bg_and_logo'];
						$BgImage    = $imgCard['background_image'];
						$FgImage    = $imgCard['foreground_logo'];
						$FgImageTxt = $imgCard['foreground_logo_text'];
						if ( ! empty( $imgCard ) ) {
							echo '<div class="custom-card">';
							if ( ! empty( $BgImage ) ) {
								echo '<img ' . $data_pre . 'src="' . $BgImage['url'] . '" alt="' . $BgImage['alt'] . '" title="' . $BgImage['title'] . '" width="' . $BgImage['width'] . '" height="' . $BgImage['height'] . '">';
							}
							echo '<div class="foreground-logo">';
							if ( ! empty( $FgImage ) ) {
								echo '<img ' . $data_pre . 'src="' . $FgImage['url'] . '" alt="' . $FgImage['alt'] . '" title="' . $FgImage['title'] . '" width="' . $FgImage['width'] . '" height="' . $FgImage['height'] . '">';
							}
							if ( ! empty( $FgImageTxt ) ) {
								echo '<div>' . $FgImageTxt . '</div>';
							}
							echo '</div>
							</div>';
						} else {
							echo '<img ' . $data_pre . 'src="/wp-content/themes/yugabyte/assets/images/rebrand/yugabyte-logomark-orange.svg" alt="Yugabyte" title="Yugabyte" style="width:648px;height:588px">';
						}
					} elseif ( ! empty( $option ) && 'content' === $option ) {
						$content = $book_slider_card['content'];
						$logo    = $content['logo'];
						$author  = $content['author_image'];
						echo '<div class="content-card">
							<div class="content-card-logo">
								<img ' . $data_pre . 'src="' . $logo['url'] . '" alt="' . $logo['alt'] . '" title="' . $logo['title'] . '" width="' . $logo['width'] . '" height="' . $logo['height'] . '">
							</div>
							<div class="content-card-content">' . $content['content'] . '</div>
							<div class="content-card-author">
								<div class="content-card-author-image">
									<img ' . $data_pre . 'src="' . $author['url'] . '" alt="' . $author['alt'] . '" title="' . $author['title'] . '" width="' . $author['width'] . '" height="' . $author['height'] . '">
								</div>
								<div class="content-card-author-details">
									<div class="content-card-author-name">' . $content['author_name'] . '</div>
									<div class="content-card-author-desg">' . $content['author_desg'] . '</div>
								</div>
							</div>
						</div>';
					} elseif ( ! empty( $option ) && 'cards' === $option ) {
						echo '<div class="subcards">';
						$cardOption = $book_slider_card['icons_content'];
						foreach ( $book_slider_card['cards'] as $sub_card ) {
							if ( $sub_card ) {
								if ( ! empty( $cardOption ) && 'content' === $cardOption ) {
									echo '<div>
										<div class="sub-titles">';
									if ( ! empty( $sub_card['title'] ) ) {
										echo '<span>' . $sub_card['title'] . '</span>';
									}
									if ( ! empty( $sub_card['title_2'] ) ) {
										echo '<span class="primary-orange"> ' . $sub_card['title_2'] . '</span>';
									}
									echo '</div>
										<div class="sub-desc">' . $sub_card['subs'] . '</div>
									</div>';
								} else {
									$orangeOption = '';
									if ( ! empty( $sub_card['orange_card'] ) && 1 === (int) $sub_card['orange_card'] ) {
										$orangeOption = ' orange-bg';
									}
									$fixedText        = '';
									$fixedTextContent = '';
									if ( ! empty( $sub_card['icon_text'] ) ) {
										$fixedText        = ' fixed-txt';
										$fixedTextContent = '<div class="icon-text">' . $sub_card['icon_text'] . '</div>';
									}
									$icon = $sub_card['icon'];
									echo '<div class="iconType' . $orangeOption . $fixedText . '">
										<div class="icon">
											<img ' . $data_pre . 'src="' . $icon['url'] . '" alt="' . $icon['alt'] . '" title="' . $icon['title'] . '" width="' . $icon['width'] . '" height="' . $icon['height'] . '">
										</div>
										' . $fixedTextContent . '
									</div>';
								}
							}
						}

						echo '</div>';
					} elseif ( ! empty( $option ) && 'image' === $option ) {
						$image = $book_slider_card['slider_image'];
						if ( ! empty( $image ) ) {
							echo '<img ' . $data_pre . 'src="' . $image['url'] . '" alt="' . $image['alt'] . '" title="' . $image['title'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '">';
						} else {
							echo '<img ' . $data_pre . 'src="/wp-content/themes/yugabyte/assets/images/rebrand/yugabyte-logomark-orange.svg" alt="Yugabyte" title="Yugabyte" style="width:648px;height:588px">';
						}
					}
					echo '</div></div>';
				}
			}
			?>
		</div>
		<div class="autoplay-data come-out"></div>
	</div>
</div>

<script>
function history_slider() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/history-slider/history-slider.js?2.2 <?php echo $theme_version; ?>', 'BODY','history_slider');
}
</script>
