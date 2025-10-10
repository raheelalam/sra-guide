<?php
/**
 * Enhanced Compatibility Block Template.
 *
 * @param array  $block           The block settings and attributes.
 * @param string $content         The block inner HTML (empty).
 * @param bool   $is_preview True During backend preview render.
 * @param int    $post_id         The post ID the block is rendering content against.
 * @param array  $context         The context provided to the block by the post or it's parent block.
 */

$class_name           = 'yb-enhanced-compatibility yb-sec come-out';
$fields_data          = $block['data'];
$background_image     = $fields_data['section_background'];
$background_image_url = wp_get_attachment_url( $background_image );
$background_image_css = '';
if ( ! empty( $background_image ) ) {
	$background_image_css = '.yb-enhanced-compatibility.come-in {
    background-image:url(' . esc_url( $background_image_url ) . ');
  }';
}

if ( ! isset( $block['className'] )
	|| false === strpos( $block['className'], 'repeated-block' )
) :
	?>
	<svg style="display:none;"><style>
		<?php
		echo $background_image_css;
		require 'enhanced-compatibility.css';
		?>
	</style></svg>
	<?php
endif;

$media_field = $fields_data['section_animated_image'];
?>

<div class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		<div class="section-bg-dark devided-sec">
			<div>
				<?php
				if ( $media_field ) {
					$media_url = wp_get_attachment_url( $media_field );
					$mime_type = get_post_mime_type( $media_field );

					if ( strpos( $mime_type, 'video' ) !== false ) {
						echo '<video autoplay muted loop playsinline>
                            <source src="' . esc_url( $media_url ) . '" type="' . esc_attr( $mime_type ) . '">
                          </video>';
					} elseif ( strpos( $mime_type, 'image' ) !== false ) {
						echo '<img src="' . esc_url( $media_url ) . '" alt="Animated Image" />';
					}
				}
				?>
			</div>
			<div>
				<h2><?php echo $fields_data['ec_heading']; ?></h2>
				<div><?php echo wpautop( $fields_data['ec_details'] ); ?></div>
			</div>
		</div>
	</div>
</div>
