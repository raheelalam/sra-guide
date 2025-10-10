<?php
/**
 * HomePage Hero Section Block Template.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during backend preview render.
 * @param int    $post_id    The post ID the block is rendering content against.
 * @param array  $context    The context provided to the block by the post or it's parent block.
 */

$fields_data = $block['data'];
$class_name  = 'section section-bg-dark yb-sec';
if ( ! empty( $fields_data['extra_settings'] ) && is_array( $fields_data['extra_settings'] ) ) {
	foreach ( $fields_data['extra_settings'] as $setting ) {
		$class_name .= ' style-' . $setting;
	}
}

$image_id     = $fields_data['hero_image'];
$static_image = '';
if ( ! empty( $image_id ) ) {
	$class_name  .= ' static-image';
	$static_image = ' static-image';
}

$page_template = get_page_template_slug( $post_id );
if ( 'page-templates/cascaded-content-blocks.php' === $page_template
	&& ( ! isset( $fields_data['animate_to_second_slide'] )
		|| 1 === (int) $fields_data['animate_to_second_slide']
	)
) :
	?>

	<div tabindex="0" class="<?php echo esc_attr( $class_name ); ?>" id="section1">
		<svg style="display:none;"><style>
		<?php
		require 'style-animate.css';
		if ( 'ja' === YUGABYTE_CURRENT_LANGUAGE ) {
			require 'style-ja.css';
		}
		?>
		</style></svg>

		<div class="two-sec-parent">
			<div class="for-width"></div>
			<div class="container">
				<div class="left-side">
					<div class="yugabyte-hero-section">
						<div class="left-column">
							<div class="content-hero">
								<h1 class="fadein-property"><?php echo $fields_data['hero_heading']; ?></h1>
								<div class="section-copy fadein-property">
									<?php echo $fields_data['hero_description']; ?>
								</div>
								<div class="cta for-desktop fadein-property">
									<?php
									$counter = 0;
									for ( $i = 0; $i < $fields_data['hero_buttons']; ++$i ) :
										if ( 1 === (int) $fields_data[ 'hero_buttons_' . $i . '_popup_video' ] ) :
											$button_text = $fields_data[ 'hero_buttons_' . $i . '_button_text' ];
											$vid_id      = $fields_data[ 'hero_buttons_' . $i . '_youtube_id' ];
											if ( empty( $button_text ) || empty( $vid_id ) ) {
												continue;
											}

											++$counter;
											?>

											<a class="yb--link-black cta-button-small" role="button" data-vid="<?php echo $vid_id; ?>" title="<?php echo $button_text; ?>"><?php echo '<span>' . sprintf( '%02d. ', $counter ) . '</span>' . $button_text; ?></a>

											<?php
										elseif ( is_array( $fields_data[ 'hero_buttons_' . $i . '_button' ] )
											&& ! empty( $fields_data[ 'hero_buttons_' . $i . '_button' ] )
										) :
											$link_target = '';
											if ( isset( $fields_data[ 'hero_buttons_' . $i . '_button' ]['target'] )
												&& '_blank' === $fields_data[ 'hero_buttons_' . $i . '_button' ]['target']
											) {
												$link_target = 'target="_blank" rel="noopener"';
											}

											++$counter;
											?>

											<a class="yb--link-black cta-button-small" href="<?php echo esc_url( $fields_data[ 'hero_buttons_' . $i . '_button' ]['url'] ); ?>" title="<?php echo esc_attr( $fields_data[ 'hero_buttons_' . $i . '_button' ]['title'] ); ?>" <?php echo $link_target; ?>><?php echo '<span>' . sprintf( '%02d. ', $counter ) . '</span>' . $fields_data[ 'hero_buttons_' . $i . '_button' ]['title']; ?></a>

											<?php
										endif;
									endfor;
									?>
								</div>
							</div>
						</div>
					</div>

					<div class="yugabyte-postgresql-section">
						<div class="left-column sec-left">
							<div class="postgresql-col">
								<h2 class="fadein-property"><?php echo $fields_data['rp_heading']; ?></h2>
								<div class="section-copy for-desktop fadein-property">
									<?php echo $fields_data['rp_description']; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ani-tags2-bg">
					<div class="ani-tags2">
						<div class="tag1"></div>
						<div class="tag2"></div>
						<div class="tag3"></div>
						<div class="tag4"></div>
						<div class="tag5"></div>
						<div class="tag6"></div>
						<div class="tag7"></div>
						<div class="tag8"></div>
						<div class="tag9"></div>
						<div class="tag10"></div>
					</div>
				</div>
				<div class="right-column">
						<div class="right-columnm">
							<div class="hero-img">
								<div class="first-loti">
									<?php require 'hero-animation-image.svg'; ?>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
		<script><?php require 'script-animate.js'; ?></script>
	</div>

	<?php // Move all other sections of the page to this div. ?>
	<div class="other-snap">
	<?php
else :
	?>
	<svg style="display:none;"><style>
	<?php
	require 'style.css';
	if ( 'ja' === YUGABYTE_CURRENT_LANGUAGE ) {
		require 'style-ja.css';
	}
	?>
	</style></svg>

	<div tabindex="0" class="<?php echo esc_attr( $class_name ); ?>" id="section1">
		<div class="two-sec-parent">
			<div class="container">
				<div class="left-side">
					<div class="yugabyte-hero-section<?php echo $static_image; ?>">
						<div class="left-column">
							<div class="content-hero">
								<h1 class="fadein-property"><?php echo $fields_data['hero_heading']; ?></h1>
								<div class="section-copy fadein-property">
									<?php echo $fields_data['hero_description']; ?>
								</div>
								<div class="cta for-desktop fadein-property">
									<?php
									$counter = 0;
									for ( $i = 0; $i < $fields_data['hero_buttons']; ++$i ) :
										if ( 1 === (int) $fields_data[ 'hero_buttons_' . $i . '_popup_video' ] ) :
											$button_text = $fields_data[ 'hero_buttons_' . $i . '_button_text' ];
											$vid_id      = $fields_data[ 'hero_buttons_' . $i . '_youtube_id' ];
											if ( empty( $button_text ) || empty( $vid_id ) ) {
												continue;
											}

											++$counter;
											?>

											<a class="yb--link-black cta-button-small" role="button" data-vid="<?php echo $vid_id; ?>" title="<?php echo $button_text; ?>"><?php echo '<span>' . sprintf( '%02d. ', $counter ) . '</span>' . $button_text; ?></a>

											<?php
										elseif ( is_array( $fields_data[ 'hero_buttons_' . $i . '_button' ] )
											&& ! empty( $fields_data[ 'hero_buttons_' . $i . '_button' ] )
										) :

											$link_target = '';
											if ( isset( $fields_data[ 'hero_buttons_' . $i . '_button' ]['target'] )
												&& '_blank' === $fields_data[ 'hero_buttons_' . $i . '_button' ]['target']
											) {
												$link_target = 'target="_blank" rel="noopener"';
											}

											++$counter;
											?>

											<a class="yb--link-black cta-button-small" href="<?php echo esc_url( $fields_data[ 'hero_buttons_' . $i . '_button' ]['url'] ); ?>" title="<?php echo esc_attr( $fields_data[ 'hero_buttons_' . $i . '_button' ]['title'] ); ?>" <?php echo $link_target; ?>><?php echo '<span>' . sprintf( '%02d. ', $counter ) . '</span>' . $fields_data[ 'hero_buttons_' . $i . '_button' ]['title']; ?></a>

											<?php
										endif;
									endfor;
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ani-tags2-bg">
					<div class="ani-tags2">
						<div class="tag1"></div>
						<div class="tag2"></div>
						<div class="tag3"></div>
						<div class="tag4"></div>
						<div class="tag5"></div>
						<div class="tag6"></div>
						<div class="tag7"></div>
						<div class="tag8"></div>
						<?php if ( empty( $image_id ) ) : ?>
							<div class="tag9"></div>
						<?php endif; ?>
						<div class="tag10"></div>
					</div>
				</div>
				<div class="right-column">
					<div class="right-columnm">
						<div class="hero-img">
							<?php
							if ( ! empty( $image_id ) ) {
								$image     = wp_get_attachment_image_src( $image_id, 'full' );
								$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

								if ( isset( $fields_data['image_url'] ) && ! empty( $fields_data['image_url'] ) ) :
									$link_attr = '';
									if ( isset( $fields_data['open_in_new_tab'] ) && ! empty( $fields_data['open_in_new_tab'] ) ) {
										$link_attr = ' target="_blank" rel="noopener"';
									}
									?>
									<a href="<?php echo esc_url( $fields_data['image_url'] ); ?>"<?php echo $link_attr; ?>>
										<img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php echo esc_attr( $image_alt ); ?>" width="<?php echo esc_attr( $image[1] ); ?>" height="<?php echo esc_attr( $image[2] ); ?>">
									</a>
								<?php else : ?>
									<img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php echo esc_attr( $image_alt ); ?>" width="<?php echo esc_attr( $image[1] ); ?>" height="<?php echo esc_attr( $image[2] ); ?>">
									<?php
								endif;
							} else {
								echo '<div class="first-loti">';
								require 'hero-animation-image.svg';
								echo '</div>';
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
endif;
