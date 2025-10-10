<?php
/**
 * Our Community Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yugabyte-our-community yb-sec' );
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

<div class="<?php echo esc_attr( $class_name ); ?>" data-lazy="oc_slider">
	<svg style="display:none;"><style><?php require 'our-community.css'; ?></style></svg>
	<div class="container">
		<div class="section-head">
			<p><?php echo $acf_fields['heading']; ?></p>
		</div>
		<div class="section-copy">
		<div class="our-community owl-carousel">
		<?php
		if ( ! empty( $acf_fields['card'] ) ) {
			echo '<div class="our-community-card">
			<div class="our-community-card-title">' . $acf_fields['card']['title'] . '</div>
			<div class="links">';
			foreach ( $acf_fields['card']['ctas'] as $cta ) {
				if ( $cta ) {
					$icon = $cta['icon'];
					if ( 'icon-less' === $icon ) {
						$classes = 'yb--link-black cta-button-small';
					} elseif ( 'git-icon' === $icon ) {
						$classes = 'yb--link-black cta-button-small git-icon';
					} else {
						$classes = 'yb--link-white cta-button-small ' . $icon;
					}
					$button = $cta['button'];
					if ( '_blank' === $button['target'] ) {
						$link_target = 'target="_blank" rel="noopener"';
					}
					echo '<a class="' . $classes . '" href="' . esc_url( $button['url'] ) . '" title="' . esc_attr( $button['title'] ) . '" ' . $link_target . '>' . $button['title'] . '</a>';
				}
			}
			echo '</div>
        </div>';
		}
		if ( 'dynamic' === $acf_fields['static_dynamic_blogs'] ) {
			$blogNumbers  = $acf_fields['show_latest_blog'];
			$recent_posts = wp_get_recent_posts(
				array(
					'numberposts' => $blogNumbers,
					'post_status' => 'publish',
				)
			);
			foreach ( $recent_posts as $post_item ) {
				if ( $post_item ) {
					$author      = $post_item['post_author'];
					$author_name = get_the_author_meta( 'display_name', $author );
					$author_img  = get_avatar_url( $author, 40 );

					// If Guest Author Get the Details.
					$post_id        = $post_item['ID'];
					$molonguiAuthor = get_post_meta( $post_id, '_molongui_author' );
					$chechGuestUser = strpos( $molonguiAuthor[0], 'guest' );
					if ( false !== $chechGuestUser ) {
						$guestUserID  = str_replace( 'guest-', '', $molonguiAuthor[0] );
						$molonguiData = get_post_meta( $guestUserID );

						if ( isset( $molonguiData['_molongui_guest_author_first_name'], $molonguiData['_molongui_guest_author_first_name'][0] ) ) {
							$author_fname = $molonguiData['_molongui_guest_author_first_name'][0];
						}
						if ( isset( $molonguiData['_molongui_guest_author_last_name'], $molonguiData['_molongui_guest_author_last_name'][0] ) ) {
							$author_lname = $molonguiData['_molongui_guest_author_last_name'][0];
						}
						if ( empty( $author_fname ) && empty( $author_lname ) ) {
							$author_lname = '';
							$author_fname = $molonguiData['_molongui_guest_author_display_name'][0];
						}

						$author_name = $author_fname . ' ' . $author_lname;

						$author_img = get_avatar_url( $guestUserID, 40 );

						if ( isset( $molonguiData['_thumbnail_id'], $molonguiData['_thumbnail_id'][0] ) ) {
							$thumbnail_id    = $molonguiData['_thumbnail_id'][0];
							$thumbnail_image = wp_get_attachment_image_src( $thumbnail_id, 40 );
							$thumbnail_url   = $thumbnail_image[0];
							$author_img      = $thumbnail_url;
						}
					}

					$excerpt = $post_item['post_excerpt'];
					?>

					<a class="our-community-blog" href="<?php echo esc_url( get_permalink( $post_item['ID'] ) ); ?>" title="<?php echo esc_attr( $post_item['post_title'] ); ?>">
						<span class="our-community-blog-info">
							<span class="our-community-blog-title"><?php echo $post_item['post_title']; ?></span>
							<?php if ( ! empty( $excerpt ) ) : ?>
								<span class="our-community-blog-desc"><?php echo $excerpt; ?></span>
								<?php
							elseif ( ! empty( $post_item['post_content'] ) ) :
								$post_content     = $post_item['post_content'];
								$stripped_content = wp_strip_all_tags( $post_content );
								$words            = str_word_count( $stripped_content, 1 );
								$trimmed_words    = array_slice( $words, 0, 30 );
								$trimmed_content  = implode( ' ', $trimmed_words );
								?>
								<span class="our-community-blog-desc"><?php echo $trimmed_content; ?></span>
							<?php endif; ?>
						</span>
						<span class="our-community-blog-author">
							<span class="img">
								<img <?php echo $data_pre; ?>src="<?php echo esc_url( $author_img ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" title="<?php echo esc_attr( $author_name ); ?>" width="40" height="40">
							</span>
							<?php echo $author_name; ?>
						</span>
					</a>
					<?php
				}
			}
		} else {
			$recent_posts = $acf_fields['dynamic_blogs'];
			foreach ( $recent_posts as $post_item ) {
				if ( $post_item ) {
					$title  = $post_item['title'];
					$desc   = $post_item['desc'];
					$author = $post_item['static_dynamic_author'];
					$link   = $post_item['link'];
					?>

					<a class="our-community-blog" href="<?php echo $link; ?>" title="<?php echo $title; ?>">
						<span class="our-community-blog-info">
							<span class="our-community-blog-title"><?php echo $title; ?></span>
							<span class="our-community-blog-desc"><?php echo $desc; ?></span>
						</span>
						<?php
						if ( 'static' === $author ) {
							$image       = $post_item['author_image'];
							$author_name = $post_item['author_name'];
							?>
							<span class="our-community-blog-author">
								<span class="img"><img <?php echo $data_pre; ?>src="<?php echo $image['url']; ?>" alt="<?php echo $author_name; ?>" title="<?php echo $author_name; ?>" width="40" height="40"></span><?php echo $author_name; ?>
							</span>
							<?php
						} else {
							$author        = $post_item['author'];
							$author_F_name = $author['user_firstname'];
							$author_L_name = $author['user_lastname'];
							$author_name   = $author_F_name . ' ' . $author_L_name;
							$author_img    = get_avatar_url( $author['ID'], 40 );
							?>
							<span class="our-community-blog-author">
								<span class="img"><img <?php echo $data_pre; ?>src="<?php echo $author_img; ?>" alt="<?php echo $author_name; ?>" title="<?php echo $author_name; ?>" width="40" height="40"></span><?php echo $author_name; ?>
							</span>
							<?php
						}
						?>
					</a>
					<?php
				}
			}
		}
		?>
		</div>
		</div>
	</div>
	<script>function oc_slider() {yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/our-community/our-community.js?<?php echo $theme_version; ?>', 'BODY','oc_slider');}</script>
</div>
