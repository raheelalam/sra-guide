<?php
/**
 * Success Stories Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-success-story yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

global $wpdb;

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$theme_version = $block_data['theme_version'];
$data_pre      = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}
?>

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="success_story">
	<svg style="display:none;"><style><?php require 'success-story.css'; ?></style></svg>
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['ss_heading']; ?></h2>
		</div>

		<div class="section-copy">
			<?php
			if ( ! empty( $acf_fields['subs'] ) ) {
				echo '<div class="copy-details">' . $acf_fields['subs'] . '</div>';
			}
			?>

			<div class="filter-area">
				<div class="filter-story">
					<div class="filter-industries" data-target="data-ind">
						<div class="active">All Industries</div>
						<div class="toggle"></div>
						<div class="filter-inner">
							<span>All Industries</span>
							<?php
							$terms = get_terms(
								array(
									'taxonomy'   => 'industries',
									'hide_empty' => false,
								)
							);
							if ( ! is_wp_error( $terms ) ) {
								foreach ( $terms as $term ) {
									echo '<span>' . $term->name . '</span>';
								}
							}
							?>
				</div>
			</div>

			<div class="filter-features" data-target="data-fea">
				<div class="active">All Features</div>
				<div class="toggle"></div>
				<div class="filter-inner">
				<span>All Features</span>
							<?php
							$terms = get_terms(
								array(
									'taxonomy'   => 'features',
									'hide_empty' => false,
								)
							);
							if ( ! is_wp_error( $terms ) ) {
								foreach ( $terms as $term ) {
									echo '<span>' . $term->name . '</span>';
								}
							}
							?>
						</div>
			</div>
					<?php // Usecases. ?>
				</div>
				<?php // Cards filter. ?>

		</div>

			<div class="story-cards">
				<?php
				/*-- Success Story Cards --*/
				$success_stories_posts = $wpdb->get_results(
					"SELECT ID, post_title, post_date, post_type,
					(
						SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = `ID` AND meta_key = 'card_image'
					) AS card_image,
					(
						SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = `ID` AND meta_key = 'logo'
					) AS logo,
					(
						SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = `ID` AND meta_key = 'summary'
					) AS summary,
					(
						SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = `ID` AND meta_key = 'hero_logo'
					) AS hero_logo,
					(
						SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = `ID` AND meta_key = 'card_logo'
					) AS card_logo,
					(
						SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = `ID` AND meta_key = 'external_success_story_url'
					) AS external_url

					FROM {$wpdb->prefix}posts
					WHERE post_type = 'success-story' AND post_status = 'publish' ORDER BY post_date DESC LIMIT 100",
				);

				$blog_posts = $wpdb->get_results(
					"SELECT ID, post_title, post_date, post_type,
					(
						SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = `ID` AND meta_key = 'success_story_card_story_card_image'
					) AS card_image,
					(
						SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = `ID` AND meta_key = 'success_story_card_short_desc'
					) AS summary,
					(
						SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = `ID` AND meta_key = 'success_story_card_logo'
					) AS card_logo,
					(
						SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = `ID` AND meta_key = 'success_story_card_story_date'
					) AS story_date,
					(
						SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = `ID` AND meta_key = 'success_story_card_tax-ind'
					) AS story_industries,
					(
						SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = `ID` AND meta_key = 'success_story_card_tax-fea'
					) AS story_features
					FROM {$wpdb->prefix}posts AS p
					INNER JOIN {$wpdb->prefix}postmeta AS pm ON pm.post_id = p.ID
					WHERE p.post_type = 'post' AND p.post_status = 'publish' AND pm.meta_key = 'success_story_page' AND pm.meta_value = 1
					LIMIT 100",
				);

				$total_stories_unsorted = array_merge( $success_stories_posts, $blog_posts );
				$total_stories_sorted   = array();
				if ( ! empty( $total_stories_unsorted ) ) {
					foreach ( $total_stories_unsorted as $sort_story ) {
						if ( ! empty( $sort_story->story_date ) ) {
							$total_stories_sorted[ $sort_story->story_date ] = $sort_story;
						} else {
							$total_stories_sorted[ $sort_story->post_date ] = $sort_story;
						}
					}
				}

				krsort( $total_stories_sorted );
				if ( ! empty( $total_stories_sorted ) ) :
					$i         = 0;
					$hideClass = '';
					foreach ( $total_stories_sorted as $single_story ) :
						++$i;
						if ( $i > 12 ) {
							$hideClass = ' class="temp-hide"';
						}

						$ind   = '';
						$title = $single_story->post_title;

						$card_logo_class = '';
						$card_logo_id    = 0;
						if ( ! empty( $single_story->card_logo ) ) {
							$card_logo_class = ' class="card-logo"';
							$card_logo_id    = $single_story->card_logo;
						} elseif ( ! empty( $single_story->hero_logo ) ) {
							$card_logo_id = $single_story->hero_logo;
						}

						$card_image_id = 0;
						if ( ! empty( $single_story->card_image ) ) {
							$card_image_id = $single_story->card_image;
						} elseif ( ! empty( $single_story->logo ) ) {
							$card_image_id = $single_story->logo;
						}

						if ( 'post' === $single_story->post_type ) {
							$industries_detail = maybe_unserialize( $single_story->story_industries );
						} else {
							$industries_detail = get_the_terms( $single_story->ID, 'industries' );
						}

						$data_industry = '';
						$industry_list = '';
						$story_cat     = '';
						if ( ! empty( $industries_detail ) ) {
							$count_industries     = count( $industries_detail );
							$lastIterationDetails = end( $industries_detail );

							foreach ( $industries_detail as $index => $sg_cat ) {
								if ( is_numeric( $sg_cat ) ) {
									$sg_cat = get_term( $sg_cat );
								}

								if ( 3 > $index ) {
									$story_cat .= '<span>' . $sg_cat->name . '</span>';
								}

								$industry_list .= $sg_cat->name;
								if ( $sg_cat !== $lastIterationDetails ) {
									$industry_list .= ', ';
								}
							}

							if ( 3 < $count_industries ) {
								$story_cat .= '<span>+' . ( $count_industries - 3 ) . '</span>';
							}

							$data_industry = ' data-ind="' . $industry_list . '"';
						}

						$data_feature = '';
						$feature_list = '';
						if ( 'post' === $single_story->post_type ) {
							$features_detail = maybe_unserialize( $single_story->story_features );
						} else {
							$features_detail = get_the_terms( $single_story->ID, 'features' );
						}

						if ( ! empty( $features_detail ) ) {
							$lastIterationCategory = end( $features_detail );
							foreach ( $features_detail as $sg_fea ) {
								if ( is_numeric( $sg_fea ) ) {
									$sg_fea = get_term( $sg_fea );
								}

								$feature_list .= $sg_fea->name;
								if ( $sg_fea !== $lastIterationCategory ) {
									$feature_list .= ', ';
								}
							}

							$data_feature = ' data-fea="' . $feature_list . '"';
						}

						if ( ! isset( $single_story->external_url ) || empty( $single_story->external_url ) ) {
							$success_story_link = get_permalink( $single_story->ID );
						} else {
							$success_story_link = $single_story->external_url;
						}
						?>

						<a href="<?php echo esc_url( $success_story_link ); ?>" title="<?php echo esc_attr( $title ); ?>" target="_blank" rel="noopener"<?php echo $data_industry . $data_feature . $hideClass; ?>>
							<span class="details">
								<span class="story-cat">
									<?php echo $story_cat; ?>
								</span>
								<span class="feature-img">
									<?php
									if ( ! empty( $card_image_id ) ) :
										$card_image_details = wp_get_attachment_image_src( $card_image_id, 'full' );
										$image_alt          = get_post_meta( $card_image_id, '_wp_attachment_image_alt', true );
										$image_title        = get_the_title( $card_image_id );

										if ( empty( $image_alt ) ) {
											$image_alt = $image_title;
										}
										?>

										<img <?php echo $data_pre; ?>src="<?php echo esc_url( $card_image_details[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php echo esc_attr( $image_title ); ?>" width="<?php echo esc_attr( $card_image_details[1] ); ?>" height="<?php echo esc_attr( $card_image_details[2] ); ?>"<?php echo $card_logo_class; ?>>
									<?php endif; ?>
								</span>
								<span class="feature-summary"><?php echo $single_story->summary; ?></span>
							</span>

							<?php
							if ( isset( $card_logo_id ) ) :
								$card_logo_details = wp_get_attachment_image_src( $card_logo_id, 'full' );
								$logo_alt          = get_post_meta( $card_logo_id, '_wp_attachment_image_alt', true );
								$logo_title        = get_the_title( $card_logo_id );

								if ( empty( $logo_alt ) ) {
									$logo_alt = $logo_title;
								}
								?>
								<span class="story-logo">
									<img <?php echo $data_pre; ?>src="<?php echo esc_url( $card_logo_details[0] ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" title="<?php echo esc_attr( $logo_title ); ?>" width="<?php echo esc_attr( $card_logo_details[1] ); ?>" height="<?php echo esc_attr( $card_logo_details[2] ); ?>"<?php echo $card_logo_class; ?>>
								</span>
							<?php endif; ?>
						</a>

						<?php
					endforeach;
				endif;
				?>

				<div class="no-data-message">No results for this filter option at this time. Please try another option or <a id="story-reset" role="button">Reset</a> the filter.</div>
			</div>

			<div class="cta text-center">
				<?php
				$card_cta = 'Explore All Stories';
				if ( ! empty( $acf_fields['cta'] ) ) :
					$card_cta = $acf_fields['cta'];
				endif;
				?>

				<a class="yb--link-white cta-button-small" role="button" title="<?php echo esc_attr( $card_cta ); ?>"><?php echo esc_html( $card_cta ); ?></a>
			</div>
		</div>
	</div>
	<script>function success_story() {yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/success-story-cards/success-story.js?<?php echo $theme_version; ?>', 'BODY', 'success-story');}</script>
</div>
