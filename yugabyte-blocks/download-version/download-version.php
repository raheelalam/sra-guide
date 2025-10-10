<?php
/**
 * Download Version Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data($post_id, $block['name'], 'yugabyte-download-version-section yb-sec come-out section-bg-dark');
if (!isset($block_data['fields_data']) || empty($block_data['fields_data'])) {
  return;
}

$acf_fields = $block_data['fields_data'];
$class_name = $block_data['classes'];
$theme_version = $block_data['theme_version'];
?>

<svg style="display:none;">
    <style>
        <?php require 'download-version.css'; ?>
    </style>
</svg>

<div class="<?php echo esc_attr($class_name); ?>">
    <div class="container">
      <?php

      $link_target = '';
      if ('yes' === $acf_fields['new_tab']) {
        $link_target = ' target="_blank" rel="noopener"';
      }
      $altTitle = esc_attr($acf_fields['title']);
      if (!empty($acf_fields['title_alt'])) {
        $altTitle = esc_attr($acf_fields['title_alt']);
      }
      $colored = $acf_fields['colored_text'];
      $title = $acf_fields['title'];
      if (!empty($colored)) {
        $colored = explode(',', $colored);
        foreach ($colored as $color) {
          $title = str_replace($color, "<span class='primary-orange'>" . $color . '</span>', $title);
        }
      }
      if (!empty($acf_fields['link'])) {
        echo '<a class="full-anchor" href="' . esc_url($acf_fields['link']) . '" title="' . $altTitle . '"' . $link_target . '>';
        echo '<span class="eyebrow-text">' . $acf_fields['eyebrow_text'] . '</span>';
        echo '<h2>' . $title . '</h2> </a>';
      } else {
        echo '<div class="section-head"><h2>' . $title . '</h2></div>';
      }
      ?>
      <?php
      $linkArray = $acf_fields['multi_anchors'];

      if (!empty($linkArray) && is_array($linkArray)) {
        ?>
          <ul class="multi-anchor">
            <?php
            foreach ($linkArray as $innerLink) {
              $anchor = $innerLink['links'];
              $link_url = $anchor['url'];
              $link_title = $anchor['title'];
              $link_target = $anchor['target'] ? $anchor['target'] : '_self';
              ?>
                <li>
                    <a class="ic-link animate-out" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"> <?php echo esc_html($link_title); ?> </a>
                </li>
            <?php } ?>
          </ul>
      <?php } ?>
    </div>
</div>
