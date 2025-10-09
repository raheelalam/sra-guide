function modify_specific_block($block_content, $block) {
global $yb_lateload_enlighter;

if ( 'yugabytedb/tabs-code' === $block['blockName'] ) {
$yb_lateload_enlighter = 'true';
}
return $block_content;
}

function get_posts_using_acf_block($block_name) {
// WP_Query arguments
$args = array(
'post_type'      => 'any', // search all post types
'posts_per_page' => -1,
'post_status'    => 'publish',
's'              => '"yugabytedb/' . $block_name . '"',
);

$query = new WP_Query($args);
$posts_using_block = array();

if ($query->have_posts()) {
while ($query->have_posts()) {
$query->the_post();
$posts_using_block[] = array(
'ID'    => get_the_ID(),
'title' => get_the_title(),
'url'   => get_permalink(),
);
}
}

wp_reset_postdata();

return $posts_using_block;
}

// Example usage:
$block_posts = get_posts_using_acf_block('blog-section');
if (!empty($block_posts)) {
echo '<ul>';
    foreach ($block_posts as $post) {
    echo '<li><a href="' . esc_url($post['url']) . '">' . esc_html($post['title']) . '</a></li>';
    }
    echo '</ul>';
} else {
echo 'No posts found using this block.';
}