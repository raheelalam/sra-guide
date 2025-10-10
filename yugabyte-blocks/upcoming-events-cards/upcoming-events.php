<?php
/**
 * Upcoming Events Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-upcoming-events yb-sec come-out' );
if ( ! isset( $block_data['fields_data'] ) || empty( $block_data['fields_data'] ) ) {
	return;
}

$post          = get_post( get_the_ID() );
$blocks_others = parse_blocks( $post->post_content );

$acf_fields    = $block_data['fields_data'];
$class_name    = $block_data['classes'];
$current_date  = date( 'Y-m-d' );
$theme_version = $block_data['theme_version'];
$data_pre      = 'src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-';
if ( ! empty( $is_preview ) ) {
	$data_pre = '';
}

// Featured.
$featured_args = array(
	'post_type'      => 'ybevent',
	'posts_per_page' => 1,
	'post_status'    => 'publish',
	// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
	'meta_query'     => array(
		array(
			'key'     => 'featured',
			'value'   => '1',
			'compare' => '=',
		),
	),
	'orderby'        => 'date',
	'order'          => 'ASC',
);

$featured_query = new WP_Query( $featured_args );
if ( $featured_query->have_posts() ) {
	$featured_query->the_post();

	$id                      = get_the_ID();
	$timeStart               = get_field( 'start_time', $id );
	$StartDatevalidate       = new DateTime( $timeStart );
	$StartDateOnlyValidation = $StartDatevalidate->format( 'Y-m-d' );

	if ( $StartDateOnlyValidation >= $current_date ) {
		$title = get_the_title();
		if ( ! empty( get_field( 'alternate_title', $id ) ) ) {
			$title = get_field( 'alternate_title', $id );
		}

		$desc          = wp_strip_all_tags( get_the_content() );
		$event_details = '';
		$timeEnd       = get_field( 'end_time', $id );
		$hide_time     = (int) get_field( 'hide_time', $id );
		$link          = get_field( 'ext_url', $id );
		$featuredImage = get_field( 'featured_image', $id );

		$phyAddress = '';
		$is_online  = (int) get_field( 'is_online', $id );
		if ( 1 === $is_online ) {
			$phyAddress = 'Online';
		} else {
			$phyAddress = get_field( 'phys_loc', $id );
		}

		if ( ! empty( $timeStart ) ) {
			// Start Date Only.
			$StartDate         = new DateTime( $timeStart );
			$StartDateTime     = $StartDate->format( 'Y-m-d H:i:s' );
			$StartDateComplete = $StartDate->format( 'F d, g:ia' );

			if ( 1 === $hide_time ) {
				$StartDateComplete = $StartDate->format( 'F d' );
			}

			$StartDateOnly     = $StartDate->format( 'Y-m-d' );
			$ReadStartDateOnly = $StartDate->format( 'F d' );
			$StartTimeOnly     = $StartDate->format( 'g:ia' );

			if ( 1 === $hide_time ) {
				$StartTimeOnly = '';
			}

			if ( ! empty( $timeEnd ) ) {
				// End Date Only.
				$EndDate             = new DateTime( $timeEnd );
				$EndDateTime         = $EndDate->format( 'Y-m-d H:i:s' );
				$EndDateTimeComplete = $EndDate->format( 'F d, g:ia' );

				if ( 1 === $hide_time ) {
					$EndDateTimeComplete = $EndDate->format( 'F d' );
				}

				$EndDateOnly = $EndDate->format( 'Y-m-d' );
				if ( $StartDateTime === $EndDateTime || $StartDateOnly === $EndDateOnly ) {
					$event_details = $ReadStartDateOnly;
					if ( 1 !== $hide_time ) {
						$event_details .= ', ' . $StartTimeOnly;
					}
				} else {
					$event_details = $StartDateComplete . ' - ' . $EndDateTimeComplete;
				}
			} else {
				$event_details = $ReadStartDateOnly . ', ' . $StartTimeOnly;
			}
		}

		if ( ! empty( $phyAddress ) ) {
			$event_details .= '<br>' . $phyAddress;
		}

		if ( ! empty( $timeStart ) || ! empty( $phyAddress ) ) {
			$event_details .= '<br><br>';
		}

		if ( ! empty( $desc ) ) {
			$event_details .= $desc;
		}

		echo '<section class="yb-hero-section yb-sec come-out">
			<div class="container bordered-container section-bg-dark">
				<div class="hero-content">
					<div class="h1">' . $title . '</div>
					<div class="hero-subs">' . $event_details . '</div>
					<div class="yb-hero-ctas">
						<a class="hero-btn arrow-icon" href="' . esc_url( $link ) . '" title="Register Now" target="_blank" rel="noopener">Register Now</a>
					</div>
				</div>
				<div class="hero-image" style="background-image:url(' . $featuredImage['url'] . ')">
					<img src="' . $featuredImage['url'] . '" alt="' . $featuredImage['alt'] . '" width="' . $featuredImage['width'] . '" height="' . $featuredImage['height'] . '">
				</div>
			</div>
		</section>';

		wp_reset_postdata();
	}
}
// Featured.

$section_inline = '';
if ( ! empty( $acf_fields['top_space'] ) ) {
	$section_inline .= 'padding-top:' . esc_attr( $acf_fields['top_space'] . 'px;' );
}

if ( ! empty( $acf_fields['bottom_space'] ) ) {
	$section_inline .= 'padding-bottom:' . esc_attr( $acf_fields['bottom_space'] . 'px;' );
}
?>

<section class="<?php echo esc_attr( $class_name ); ?>" data-lazy="upcoming_events" style="<?php echo $section_inline; ?>">
	<svg style="display:none;"><style><?php require 'upcoming-events.css'; ?></style></svg>
	<div class="container">
		<div class="section-head">
			<h2><?php echo $acf_fields['heading']; ?></h2>
		</div>

		<div class="section-copy">
			<?php
			if ( ! empty( $acf_fields['subs'] ) ) {
				echo '<div class="copy-details">' . $acf_fields['subs'] . '</div>';
			}

			$args = array(
				'post_type'      => 'ybevent',
				'posts_per_page' => 50,
				'post_status'    => 'publish',
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				'meta_query'     => array(
					array(
						'key'     => 'end_time',
						'value'   => $current_date,
						'compare' => '>=',
						'type'    => 'DATE',
					),
				),
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_key'       => 'start_time',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
			);

			if ( isset( $featured_query->posts[0]->ID ) && ! empty( $featured_query->posts[0]->ID ) ) {
				$args['post__not_in'] = array( $featured_query->posts[0]->ID );
			}

			$event_query = new WP_Query( $args );
			if ( $event_query->have_posts() ) {
				$event_count = $event_query->found_posts;
			}

			$combined_event_location = array();
			$combined_event_type     = array();

			// Begin event cards container.
			echo '<div class="upcoming-event-cards">';

			if ( $event_query->have_posts() ) {
				$i         = 0;
				$hideClass = '';
				while ( $event_query->have_posts() ) {
					++$i;
					if ( $i > 6 ) {
						$hideClass = 'class="temp-hide" ';
					}
					$event_query->the_post();
					$total = 0;
					$id    = get_the_ID();

					$dataTyp         = '';
					$category_detail = get_the_terms( $id, 'event_types' );
					if ( ! empty( $category_detail ) ) {

						foreach ( $category_detail as $combined ) {
							if ( ! in_array( $combined->name, $combined_event_type ) ) {
								$combined_event_type[] = $combined->name;
							}
						}

						$typ                  = '';
						$lastIterationDetails = end( $category_detail );
						foreach ( $category_detail as $typ_cat ) {
							$typ .= $typ_cat->name;
							if ( $typ_cat !== $lastIterationDetails ) {
								$typ .= '| ';
							}
						}
						$dataTyp = ' data-typ="' . $typ . '"';
					}

					$dataReg             = '';
					$category_detail_reg = get_the_terms( $id, 'event_locations' );

					if ( ! empty( $category_detail_reg ) ) {
						foreach ( $category_detail_reg as $combined ) {
							if ( ! in_array( $combined->name, $combined_event_location ) ) {
								$combined_event_location[] = $combined->name;
							}
						}

						$reg                  = '';
						$lastIterationDetails = end( $category_detail_reg );
						foreach ( $category_detail_reg as $reg_reg ) {
							$reg .= $reg_reg->name;
							if ( $reg_reg !== $lastIterationDetails ) {
								$reg .= '| ';
							}
						}
						$dataReg = ' data-reg="' . $reg . '"';
					}

					$ConfImage  = get_field( 'conf_img', $id );
					$desc       = get_the_content();
					$desc       = wp_strip_all_tags( $desc );
					$title      = get_the_title();
					$link       = get_field( 'ext_url', $id );
					$hide_time  = (int) get_field( 'hide_time', $id );
					$phyAddress = '';
					$is_online  = (int) get_field( 'is_online', $id );
					if ( 1 === $is_online ) {
						$phyAddress = 'Online';
					} else {
						$phyAddress = get_field( 'phys_loc', $id );
					}

					$timeStart               = get_field( 'start_time', $id );
					$timeEnd                 = get_field( 'end_time', $id );
					$StartDatevalidate       = new DateTime( $timeStart );
					$StartDateOnlyValidation = $StartDatevalidate->format( 'Y-m-d' );

					echo '<a ' . $hideClass . 'href="' . esc_url( $link ) . '" title="' . esc_attr( $title ) . '"' . $dataTyp . $dataReg . ' target="_blank" rel="noopener">
          	<span class="details">';
					if ( ! empty( $category_detail ) ) {
						echo '<span class="event-cat">';
						$j = '';
						$c = count( $category_detail );
						$c = '+' . ( $c - 3 );
						foreach ( $category_detail as $sg_cat ) {
							++$j;
							if ( $j < 4 ) {
								echo '<span>' . $sg_cat->name . '</span>';
							}
						}
						if ( $c > 0 ) {
							echo '<span>' . $c . '</span>';
						}
						echo '</span>';
					}
					echo '<span class="feature-img">';
					if ( ! empty( $ConfImage ) ) {
						echo '<img ' . $data_pre . 'src="' . $ConfImage['sizes']['medium'] . '" alt="' . $ConfImage['alt'] . '" width="' . $ConfImage['sizes']['medium-width'] . '" height="' . $ConfImage['sizes']['medium-height'] . '">';
					}
					echo '</span>
					<span class="feature-mains">';
					if ( ! empty( $timeStart ) ) {
						// Start Date Only.
						$StartDate         = new DateTime( $timeStart );
						$StartDateTime     = $StartDate->format( 'Y-m-d H:i:s' );
						$StartDateComplete = $StartDate->format( 'F d, g:ia' );

						if ( 1 === $hide_time ) {
							$StartDateComplete = $StartDate->format( 'F d' );
						}
						$StartDateOnly     = $StartDate->format( 'Y-m-d' );
						$ReadStartDateOnly = $StartDate->format( 'F d' );
						$StartTimeOnly     = $StartDate->format( 'g:ia' );
						if ( 1 === $hide_time ) {
							$StartTimeOnly = '';
						}

						if ( ! empty( $timeEnd ) ) {
							// End Date Only.
							$EndDate             = new DateTime( $timeEnd );
							$EndDateTime         = $EndDate->format( 'Y-m-d H:i:s' );
							$EndDateTimeComplete = $EndDate->format( 'F d, g:ia' );
							if ( 1 === $hide_time ) {
								$EndDateTimeComplete = $EndDate->format( 'F d' );
							}
							$EndDateOnly = $EndDate->format( 'Y-m-d' );
							$EndTimeOnly = $EndDate->format( 'g:ia' );
							if ( $StartDateTime === $EndDateTime ) {
								echo $StartDateComplete;
							} elseif ( $StartDateOnly === $EndDateOnly ) {
								if ( 1 === $hide_time ) {
									echo $ReadStartDateOnly;
								} else {
									echo $ReadStartDateOnly . ', ' . $StartTimeOnly;
								}
							} else {
								echo $StartDateComplete . ' - ' . $EndDateTimeComplete;
							}
						} else {
							echo $StartDateComplete;
						}
					}
					echo '</span>';
					if ( ! empty( $phyAddress ) ) {
						echo '<span class="feature-mains">' . $phyAddress . '</span>';
					}

					if ( ! empty( $desc ) ) {
						echo '<span class="feature-summary">' . $desc . '</span>';
					}
					echo '</span>';

					echo '</a>';
				}
				wp_reset_postdata();
			}

			echo '<div class="no-data-message">No results for this filter option at this time. Please try another option or <a id="event-reset">Reset</a> the filter</div>';
			echo '</div>';
			?>

			<div class="filter-area">
				<div class="filter-event">
					<?php if ( isset( $combined_event_location ) && ! empty( $combined_event_location ) ) : ?>
					<div class="filter-regions" data-target="data-reg">
						<div class="active">All Regions</div>
						<div class="toggle"></div>
						<div class="filter-inner">
							<span>All Regions</span>
							<?php
							foreach ( $combined_event_location as $locations ) {
								echo '<span>' . $locations . '</span>';
							}
							?>
						</div>
					</div>
					<?php endif; ?>
					<div class="filter-types" data-target="data-typ">
						<div class="active">All Types</div>
						<div class="toggle"></div>
						<div class="filter-inner">
							<span>All Types</span>
							<?php
							foreach ( $combined_event_type as $type ) {
								echo '<span>' . $type . '</span>';
							}
							?>
						</div>
					</div>
				</div>
				<div class="total-events"><?php echo $event_count; ?> EVENTS</div>
			</div>

			<?php
			if ( ! empty( $acf_fields['cta'] ) && 6 < $event_count ) {
				$link = $acf_fields['cta'];
				echo '<div class="cta text-center"><a class="yb--link-white cta-button-small" role="button" title="' . $link . '">' . $link . '</a></div>';
			}
			?>
		</div>
	</div>

	<script>function upcoming_events() {yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/upcoming-events-cards/upcoming-events.js?<?php echo $theme_version; ?>', 'BODY', 'upcoming-events');}</script>
</section>
