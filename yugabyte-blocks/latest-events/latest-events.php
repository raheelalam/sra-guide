<?php
/**
 * Latest Events Section Block Template.
 *
 * @param array  $block           The block settings and attributes.
 * @param string $content         The block inner HTML (empty).
 * @param bool   $is_preview True During backend preview render.
 * @param int    $post_id         The post ID the block is rendering content against.
 * @param array  $context         The context provided to the block by the post or it's parent block.
 */

$class_name  = 'yb-latest-events yb-sec come-out';
$fields_data = $block['data'];
$section_id  = strtolower( str_replace( ' ', '-', $fields_data['heading'] ) );

if ( isset( $fields_data['theme_style'] ) && ! empty( $fields_data['theme_style'] ) ) {
	$class_name .= ' section-bg-' . $fields_data['theme_style'];
}

if ( ! isset( $block['className'] )
	|| false === strpos( $block['className'], 'repeated-block' )
) :
	?>
	<svg style="display:none;"><style><?php require 'latest-events.css'; ?></style></svg>
<?php endif; ?>

<section class="testing <?php echo esc_attr( $class_name ); ?>" id="<?php echo esc_attr( $section_id ); ?>">
	<div class="container">
		<div class="section-head">
			<h2><a href="#<?php echo $section_id; ?>"><?php echo $fields_data['heading']; ?></a></h2>
		</div>

		<div class="yb-events-wrap">
			<div class="yb-events-content">
				<?php
				if ( ! empty( $fields_data['left_side_content_colored_text'] ) ) {
					$colored = explode( ',', $fields_data['left_side_content_colored_text'] );
					foreach ( $colored as $color ) {
						$fields_data['left_side_content_title'] = str_replace( $color, "<span class='primary-orange'>" . $color . '</span>', $fields_data['left_side_content_title'] );
					}
				}
				echo '<h3>' . $fields_data['left_side_content_title'] . '</h3>
					<div class="desc">' . $fields_data['left_side_content_description'] . '</div>';

				$link = $fields_data['left_side_content_link'];
				if ( ! empty( $link ) ) {
					$link_target = '';
					if ( '_blank' === $link['target'] ) {
						$link_target = 'target="_blank" rel="noopener"';
					}
					echo '<a class="yb--link-black cta-button-small" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '" ' . $link_target . '>' . $link['title'] . '</a>';
				}
				?>
			</div>

			<div class="event-cards">
				<?php
				$current_timestamp = time();
				$current_datetime  = date( 'Y-m-d h:i:a', $current_timestamp );
				$show_events       = $fields_data['left_side_content_show_latest_events'];

				if ( 'youtube-streams' === $fields_data['left_side_content_show_latest_event'] ) {
					$filter_title   = '';
					$youtube_events = apply_filters( 'youtube_data_stored_events', array() );

					if ( isset( $fields_data['left_side_content_title_includes'] ) && ! empty( $fields_data['left_side_content_title_includes'] ) ) {
						$filter_title = $fields_data['left_side_content_title_includes'];
					}

					foreach ( $youtube_events as $event_video ) {
						$timestamp      = strtotime( $event_video->published_at );
						$month          = date( 'M', $timestamp );
						$day            = date( 'd', $timestamp );
						$event_datetime = date( 'Y-m-d', $timestamp );
						$words          = explode( ' ', $event_video->description );
						$first_17_words = implode( ' ', array_slice( $words, 0, 40 ) );
						$upcoming_data  = '';
						$upcoming_event = '';

						if ( ! empty( $filter_title ) && false === strpos( $event_video->title, $filter_title ) ) {
							continue;
						}

						if ( 1 > $show_events ) {
							break;
						}

						if ( $event_datetime >= $current_datetime ) {
							$upcoming_event = '<span class="incoming">UPCOMING</span>';
							$upcoming_data  = ' data-upcoming="true"';
						}

						echo '<a href="https://www.youtube.com/watch?v=' . $event_video->video_id . '" title="' . $event_video->title . '" target="_blank" rel="noopener"' . $upcoming_data . '>
							<span class="date"><span class="month">' . $month . '</span>' . $day . '</span>
							<span class="details">' .
								$upcoming_event . '
								<span class="title">' . $event_video->title . '</span>
								<span class="desc">' . $first_17_words . '</span>
							</span>
						</a>';

						--$show_events;
					}
				} elseif ( 'speaker-events' === $fields_data['left_side_content_show_latest_event'] ) {
					$args         = array(
						'post_type'      => 'speaker_events',
						'posts_per_page' => $show_events,
						'post_status'    => 'publish',
						// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
						'meta_query'     => array(
							array(
								'key' => 'date',
							),
						),
						'orderby'        => 'meta_value',
						'order'          => 'DESC',
					);
					$events_query = new WP_Query( $args );
					if ( $events_query->have_posts() ) {
						while ( $events_query->have_posts() ) {
							$events_query->the_post();
							$total          = 0;
							$id             = get_the_ID();
							$date           = get_field( 'date', $id );
							$timestamp      = strtotime( $date );
							$month          = date( 'M', $timestamp );
							$day            = date( 'd', $timestamp );
							$event_datetime = date( 'Y-m-d H:i:a', $timestamp );
							$title          = get_the_title();
							$desc           = get_field( 'description', $id );
							$upcoming_event = '';
							$upcoming_data  = '';

							if ( $event_datetime >= $current_datetime ) {
								$upcoming_data  = ' data-upcoming="true"';
								$upcoming_event = '<span class="incoming">UPCOMING</span>';
							}

							echo '<a href="' . get_field( 'external_url', $id ) . '" title="' . $title . '" target="_blank" rel="noopener"' . $upcoming_data . '>
									<span class="date"><span class="month">' . $month . '</span>' . $day . '</span>
									<span class="details">' .
										$upcoming_event . '
										<span class="title">' . $title . '</span>
										<span class="desc">' . $desc . '</span>
									</span>
								</a>';
						}
						wp_reset_postdata();
					}
				} else {
					$args         = array(
						'post_type'      => 'ybevent',
						'posts_per_page' => $show_events,
						'post_status'    => 'publish',
						'orderby'        => 'date',
						'order'          => 'DESC',
					);
					$events_query = new WP_Query( $args );
					if ( $events_query->have_posts() ) {
						while ( $events_query->have_posts() ) {
							$events_query->the_post();

							$id             = get_the_ID();
							$desc           = get_the_content();
							$date           = get_field( 'start_time', $id );
							$timestamp      = strtotime( $date );
							$month          = date( 'M', $timestamp );
							$day            = date( 'd', $timestamp );
							$event_datetime = date( 'Y-m-d H:i:a', $timestamp );
							$title          = get_the_title();
							$total          = 0;
							$upcoming_data  = '';
							$upcoming_event = '';

							if ( empty( $desc ) ) {
								$desc = get_field( 'desc', $id );
							}
							$descWithoutTags = wp_strip_all_tags( $desc );
							$words           = explode( ' ', $descWithoutTags );
							$first_17_words  = implode( ' ', array_slice( $words, 0, 40 ) );

							if ( $event_datetime >= $current_datetime ) {
								$upcoming_data  = ' data-upcoming="true"';
								$upcoming_event = '<span class="incoming">UPCOMING</span>';
							}

							echo '<a href="' . get_field( 'ext_url', $id ) . '" title="' . $title . '" target="_blank" rel="noopener"' . $upcoming_data . '>
								<span class="date"><span class="month">' . $month . '</span>' . $day . '</span>
								<span class="details">' .
									$upcoming_event . '
									<span class="title">' . $title . '</span>
									<span class="desc">' . $first_17_words . '...</span>
								</span>
							</a>';
						}
						wp_reset_postdata();
					}
				}
				?>
			</div>
		</div>

		<?php
		// Friday Talk Page Events.
		if ( ! empty( $fields_data['left_side_content_2_title'] ) ) {
			?>
			<div class="yb-events-wrap">
				<div class="yb-events-content">
					<?php
					if ( ! empty( $fields_data['left_side_content_2_colored_text'] ) ) {
						$colored = explode( ',', $fields_data['left_side_content_2_colored_text'] );
						foreach ( $colored as $color ) {
							$fields_data['left_side_content_2_title'] = str_replace( $color, "<span class='primary-orange'>" . $color . '</span>', $fields_data['left_side_content_2_title'] );
						}
					}
					echo '<h3>' . $fields_data['left_side_content_2_title'] . '</h3>
						<div class="desc">' . $fields_data['left_side_content_2_description'] . '</div>';

					$link = $fields_data['left_side_content_2_link'];
					if ( ! empty( $link ) ) {
						$link_target = '';
						if ( '_blank' === $link['target'] ) {
							$link_target = 'target="_blank" rel="noopener"';
						}
						echo '<a class="yb--link-black cta-button-small" href="' . $link['url'] . '" title="' . $link['title'] . '" ' . $link_target . '>' . $link['title'] . '</a>';
					}
					?>
				</div>

				<div class="event-cards">
					<?php
					$args       = array(
						'post_type'      => 'yftt',
						'posts_per_page' => $fields_data['left_side_content_2_show_latest_events'],
						'post_status'    => 'publish',
						'orderby'        => 'date',
						'order'          => 'DESC',
					);
					$yftt_query = new WP_Query( $args );
					if ( $yftt_query->have_posts() ) {
						while ( $yftt_query->have_posts() ) {
							$yftt_query->the_post();

							$id            = get_the_ID();
							$date          = get_field( 'date', $id );
							$timestamp     = strtotime( $date );
							$month         = date( 'M', $timestamp );
							$day           = date( 'd', $timestamp );
							$yftt_datetime = date( 'Y-m-d', $timestamp ) . ' 10:00:am';
							$title         = get_the_title();
							$desc          = get_field( 'engineers', $id );
							$link          = get_field( 'talk_link', $id );

							$upcoming_data  = '';
							$upcoming_event = '';

							if ( $yftt_datetime >= $current_datetime ) {
								$upcoming_data  = ' data-upcoming="true"';
								$upcoming_event = '<span class="incoming">UPCOMING</span>';
							}

							echo '<a href="' . $link . '" title="' . $title . '" target="_blank" rel="noopener"' . $upcoming_data . '>
								<span class="date"><span class="month">' . $month . '</span>' . $day . '</span>
								<span class="details">' .
									$upcoming_event . '
									<span class="title">' . $title . '</span>
									<span class="desc">' . $desc . '</span>
								</span>
							</a>';
						}
					}
					?>
				</div>
			</div>
			<?php
		} // If friday ted talk title.
		?>
	</div>
</section>
