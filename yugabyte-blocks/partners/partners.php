<?php
/**
 * Partners Data Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data($post_id, $block['name'], 'yb-partners-section yb-sec come-out');
if (!isset($block_data['fields_data']) || empty($block_data['fields_data'])) {
  return;
}
$acf_fields = $block_data['fields_data'];

$class_name = $block_data['classes'];
global $wpdb;

?>
<svg style="display:none;">
    <style>
        <?php require 'partners.css'; ?>
    </style>
</svg>
<?php
$partners_type = $acf_fields['partners_types_taxonomy'];
?>

<div class="<?php echo esc_attr($class_name); ?>" data-lazy="partners">

    <div class="container">
        <div class="partners-panel">
            <div class="partners-menu">
                <div class="catalog-menu-title">CATEGORY</div>
                <div class="partners-mob-menu">All</div>
                <div class="partners-mob-container">
                    <div class="partners-mob-menu-close"></div>
                    <span data-name="all" class="active">All</span>
                  <?php
                  if ($partners_type) {
                    foreach ($partners_type as $term) {
                      echo '<span data-name="' . sanitize_title($term->name) . '">' . esc_html($term->name) . '</span>';
                    }
                  }
                  ?>
                </div>
            </div>
          <?php
          if (!empty($partners_type) && !is_wp_error($partners_type)) {
            echo '<div class="partners-views" id="catalog-views">';
            foreach ($partners_type as $key => $partners) {
              $mobHidden = '';
              if ($key > 3) {
                $mobHidden = ' mob-hidden';
              }
              echo '<div class="partners-view' . $mobHidden . '" data-name="' . sanitize_title($partners->name) . '">';
              echo '<h3 class="partners-title">' . esc_html($partners->name) . '</h3>';
              $taxonomy = 'partners_type';
              $term_id = $partners->term_id;
              $query = $wpdb->prepare("
                    SELECT p.ID, p.post_title, p.post_type, p.post_date
                    FROM {$wpdb->posts} AS p
                    INNER JOIN {$wpdb->term_relationships} AS tr ON (p.ID = tr.object_id)
                    INNER JOIN {$wpdb->term_taxonomy} AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
                    WHERE p.post_type = 'partners'
                      AND p.post_status = 'publish'
                      AND tt.taxonomy = %s
                      AND tt.term_id = %d
                    ORDER BY p.post_date ASC
                ", $taxonomy, $term_id);
              $partners_posts = $wpdb->get_results($query);

              if (!empty($partners->description)) {
                echo '<p class="partners-description">' . $partners->description . '</p>';
              }
              foreach ($partners_posts as $parent_data) {
                $post_id = $parent_data->ID;
                $partner_link = get_field('link', $post_id);
                $partner_logo = get_field('company_logo', $post_id);
                $partner_name = get_field('partner_name', $post_id);
                $short_description = get_field('short_description', $post_id);
                $link_url = !empty($partner_link['url']) ? esc_url($partner_link['url']) : '';
                $link_target = !empty($partner_link['target']) ? esc_attr($partner_link['target']) : '_self';
                if (!empty($partner_logo)) {
                  $image_url = esc_url($partner_logo['url']);
                  $image_alt = esc_attr($partner_logo['alt']);
                  $image_html = '<img src="' . $image_url . '" alt="' . $image_alt . '" width="' . $partner_logo['width'] . '" height="' . $partner_logo['height'] . '" class="partner-logo" >';
                } else {
                  $image_html = '<img ' . $data_pre . 'src="/wp-content/themes/yugabyte/assets/images/rebrand/yugabyte-logomark-orange.svg" alt="Yugabyte" width="60" height="54">';
                }

                if (!empty($link_url) && $link_url !== '#') { ?>
                    <a  href="<?php echo $link_url ?>" class="partners-logo"  <?php echo ($link_target === "_blank") ?  ' target="_blank" rel="noopener"' : '';?>>
                      <?php
                      if (is_user_logged_in()) {
                        echo '<span style="font-size: 8px;line-height: normal;"  class="edit-link" href="' . esc_url(get_edit_post_link($post_id)) . '">Edit Post</span>';
                      } ?>
                      <?php echo $image_html; ?>

                      <?php if (!empty($short_description) || !empty($partner_name)) { ?>
                          <div class="partner-text"><?php echo (!empty($partner_name)) ? "<b>" . $partner_name . "</b>" : ''; ?><p><?php echo esc_html($short_description) ?></p></div>
                      <?php } ?>
                    </a>
                <?php } else { ?>
                    <div class="partners-logo">
                      <?php
                      if (is_user_logged_in()) {
                        echo '<a style="font-size: 8px;line-height: normal;"  class="edit-link" href="' . esc_url(get_edit_post_link($post_id)) . '">Edit Post</a>';
                      } ?>

                      <?php echo $image_html ?>
                      <?php if (!empty($short_description) || !empty($partner_name)) { ?>
                          <div class="partner-text"><?php echo (!empty($partner_name)) ? "<b>" . $partner_name . "</b>" : ''; ?><p><?php echo esc_html($short_description) ?></p></div>
                      <?php } ?>
                    </div>
                <?php }
              }

              $query = $wpdb->prepare("
                    SELECT t.term_id, t.name, t.slug, tt.parent, tt.description
                    FROM {$wpdb->terms} AS t
                    INNER JOIN {$wpdb->term_taxonomy} AS tt
                        ON t.term_id = tt.term_id
                    WHERE tt.taxonomy = %s
                      AND tt.parent = %d
                      AND tt.count > 0
                    ORDER BY t.name ASC
                ", $taxonomy, $partners->term_id);
              $child_terms = $wpdb->get_results($query);

              if (!empty($child_terms)) {
                foreach ($child_terms as $child) {
                  $custom_title = get_field('custom_title', 'partners_type_' . $child->term_id);
                  echo '<div class="child-partners-head">';
                  if (!empty($custom_title)) {
                    echo '<p>' . $custom_title . '</p>';
                  } else {
                    echo '<h3>' . esc_html($child->name) . '</h3>';
                  }
                  echo '</div>';
                  $query = $wpdb->prepare("
                    SELECT p.ID, p.post_title, p.post_type, p.post_date
                    FROM {$wpdb->posts} AS p
                    INNER JOIN {$wpdb->term_relationships} AS tr ON (p.ID = tr.object_id)
                    INNER JOIN {$wpdb->term_taxonomy} AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
                    WHERE p.post_type = 'partners'
                      AND p.post_status = 'publish'
                      AND tt.taxonomy = %s
                      AND tt.term_id = %d
                    ORDER BY p.post_date ASC
                ", $taxonomy, $child->term_id);
                  $partners_posts = $wpdb->get_results($query);

                  foreach ($partners_posts as $child_data) {
                    $post_id = $child_data->ID;
                    $partner_link = get_field('link', $post_id);
                    $partner_logo = get_field('company_logo', $post_id);
                    $partner_name = get_field('partner_name', $post_id);
                    $short_description = get_field('short_description', $post_id);
                    $link_url = !empty($partner_link['url']) ? esc_url($partner_link['url']) : '';
                    $link_target = !empty($partner_link['target']) ? esc_attr($partner_link['target']) : '_self';

                    if (!empty($partner_logo)) {
                      $image_url = esc_url($partner_logo['url']);
                      $image_alt = esc_attr($partner_logo['alt']);
                      $image_html = '<img src="' . $image_url . '" alt="' . $image_alt . '" width="' . $partner_logo['width'] . '" height="' . $partner_logo['height'] . '" class="partner-logo" >';
                    } else {
                      $image_html = '<img ' . $data_pre . 'src="/wp-content/themes/yugabyte/assets/images/rebrand/yugabyte-logomark-orange.svg" alt="Yugabyte" width="60" height="54">';
                    }

                    if (!empty($link_url) && $link_url !== '#') { ?>
                        <a href="<?php echo $link_url ?>" class="partners-logo">
                          <?php
                          if (is_user_logged_in()) {
                            echo '<span style="font-size: 8px;line-height: normal;"  class="edit-link" href="' . esc_url(get_edit_post_link($post_id)) . '">Edit Post</span>';
                          } ?>
                          <?php echo $image_html; ?>

                          <?php if (!empty($short_description) || !empty($partner_name)) { ?>
                              <div class="partner-text"><?php echo (!empty($partner_name)) ? "<b>" . $partner_name . "</b>" : ''; ?><p><?php echo esc_html($short_description) ?></p></div>
                          <?php } ?>
                        </a>
                    <?php } else { ?>
                        <div class="partners-logo">
                          <?php
                          if (is_user_logged_in()) {
                            echo '<a style="font-size: 8px;line-height: normal;"  class="edit-link" href="' . esc_url(get_edit_post_link($post_id)) . '">Edit Post</a>';
                          } ?>

                          <?php echo $image_html ?>
                          <?php if (!empty($short_description) || !empty($partner_name)) { ?>
                              <div class="partner-text"><?php echo (!empty($partner_name)) ? "<b>" . $partner_name . "</b>" : ''; ?><p><?php echo esc_html($short_description) ?></p></div>
                          <?php } ?>
                        </div>
                    <?php }
                  }

                }
              }
              echo '</div>';
            }?>
              <div class="button-style yb--link-black cta-button-small link-cta-icon">View All</div>

            <?php echo '</div>';
          }
          ?>

        </div>
    </div>
</div>

<script>
  function partners() {
    yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/partners/partners.js?1.02<?php echo $theme_version; ?>', 'BODY', 'partners');
  }
</script>
