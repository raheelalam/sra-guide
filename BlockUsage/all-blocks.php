

$block_usage = [];

$args = [
'post_type'      => ['post', 'page'],
'posts_per_page' => -1,
'post_status'    => 'publish',
];

$query = new WP_Query($args);

while ( $query->have_posts() ) {
$query->the_post();

$post_id   = get_the_ID();
$post_url  = get_permalink($post_id);
$blocks    = parse_blocks( get_the_content() );

foreach ( $blocks as $block ) {
if ( empty( $block['blockName'] ) ) {
continue;
}

$block_name = $block['blockName'];

if ( ! isset( $block_usage[ $block_name ] ) ) {
$block_usage[ $block_name ] = [
'count' => 0,
'urls'  => [],
];
}

$block_usage[ $block_name ]['count']++;

// Avoid duplicate URLs for same block on same page
if ( ! in_array( $post_url, $block_usage[ $block_name ]['urls'], true ) ) {
$block_usage[ $block_name ]['urls'][] = $post_url;
}
}
}

wp_reset_postdata();

echo '<pre style="position: static; background: #00e5ff; width: 90%; z-index: 9999; top: 0; padding: 100px 40px; overflow: auto; height: auto;">';

foreach ( $block_usage as $block => $data ) {
  echo "<h3>🔹 {$block}</h3>\n";
  echo "Used: {$data['count']} times\n";
  echo "Pages:\n";

  foreach ( $data['urls'] as $url ) {
    echo "  - {$url}\n";
  }

  echo "\n-------------------------\n\n";
}

echo '</pre>';
