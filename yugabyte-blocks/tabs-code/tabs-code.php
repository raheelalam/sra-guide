<?php
/**
 * Tabs With Code Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data($post_id, $block['name'], 'yugabyte-tabs-code-section section-bg-dark yb-sec come-out');
if (!isset($block_data['fields_data']) || empty($block_data['fields_data'])) {
  return;
}

$acf_fields = $block_data['fields_data'];
$class_name = $block_data['classes'];
$theme_version = $block_data['theme_version'];

?>
<svg style="display:none;">
    <style>
        <?php require 'tabs-code.css'; ?>
    </style>
</svg>

<div class="<?php echo esc_attr($class_name); ?>" data-lazy="tabs_code">
    <div class="container">
      <?php if (isset($acf_fields['heading']) && !empty($acf_fields['heading'])) { ?>
          <div class="section-head">
              <h2><?php echo $acf_fields['heading']; ?></h2>
          </div>
      <?php } ?>
      <?php
      if (!empty($acf_fields['short_description'])) { ?>
          <div class="sub-header"><?php echo esc_html($acf_fields['short_description']); ?></div>
      <?php } ?>
        <div class="tabs-container">
            <div class="vertical-tabs">
                <div class="active-tab" tabindex="0"><?php echo $acf_fields['tabs_cards'][0]['vertical_tab_name'] ?></div>
                <div class="dropdown-list">
                  <?php
                  $cou = '0';
                  foreach ($acf_fields['tabs_cards'] as $tabs_card) {
                    ++$cou;
                    if ($tabs_card) {
                      $count = '';
                      if ($cou == 1) {
                        $count = ' class=" active"';
                      }
                      echo '<span data-tab="' . sanitize_title($tabs_card['vertical_tab_name']) . '" ' . $count . '>' . $tabs_card['vertical_tab_name'] . '</span>';
                    }
                  }
                  ?>
                </div>
            </div>
            <div class="vt-content">
              <?php
              $cou = '0';
              foreach ($acf_fields['tabs_cards'] as $tabs_card) :
                ++$cou;
                if (!empty($tabs_card)) :
                  $count = '';
                  if ($cou == 1) :
                    $count = ' active';
                  endif;
                  ?>
                    <div class="vt-data <?php echo $count; ?>" <?php echo 'data-tab="' . sanitize_title($tabs_card['vertical_tab_name']) . '" ' ?>>
                        <div class="vt-data-heads">
                          <?php
                          $counter = '0';
                          if (!empty($tabs_card['right_code_area'])) :
                            foreach ($tabs_card['right_code_area'] as $data) :
                              ++$counter;
                              if ($data) :
                                $horizontal_tab = $data['code_tab_head'];
                                $icon = $horizontal_tab['icon'];
                                $title = $horizontal_tab['title'];
                                $titleClass = str_replace(' ', '-', $title);
                                $titleClass = strtolower($titleClass);
                                $active = '';
                                if (1 === (int)$counter) {
                                  $active = ' active';
                                }
                                echo '<div class="ht-data-head' . $active . '" data-name="' . $titleClass . '">';
                                echo '<img src="/wp-content/themes/yugabyte/assets/images/lazy_placeholder.png" data-src="' . $icon['url'] . '" alt="' . $icon['alt'] . '" title="' . $icon['title'] . '" width="' . $icon['width'] . '" height="' . $icon['height'] . '">';
                                echo '<span>' . $title . '</span>';
                                echo '</div>';
                              endif;
                            endforeach;
                          endif;
                          ?>
                        </div>
                        <div class="ht-data-contents">
                          <?php
                          $counter = '0';
                          if (!empty($tabs_card['right_code_area'])) :
                            foreach ($tabs_card['right_code_area'] as $data) :
                              ++$counter;
                              if ($data) :
                                $horizontal_tab = $data['code_tab_head'];
                                $title = $horizontal_tab['title'];
                                $titleClass = str_replace(' ', '-', $title);
                                $titleClass = strtolower($titleClass);

                                $active_tab = '';
                                if (1 === (int)$counter) {
                                  $active_tab = ' active';
                                }
                                ?>

                                  <div class="ht-data-content<?php echo $active_tab; ?>" data-name="<?php echo $titleClass; ?>">
                                      <div class="codes-wrap">
                                        <?php echo $data['code']; ?>
                                      </div>
                                  </div>
                              <?php
                              endif;
                            endforeach;
                          endif;
                          ?>
                        </div>
                    </div>
                <?php
                endif; // tabs card
              endforeach;
              ?>
            </div>
        </div>
      <?php
      if (!empty($acf_fields['cta'])) :
        $link_target = '';
        if ('_blank' === $acf_fields['cta']['target']) {
          $link_target = ' target="_blank" rel="noopener"';
        }
        ?>
          <div class="cta text-center">
              <a class="yb--link-white cta-button-small" href="<?php echo esc_url($acf_fields['cta']['url']); ?>" title="<?php echo esc_attr($acf_fields['cta']['title']); ?>"<?php echo $link_target; ?>><?php echo $acf_fields['cta']['title']; ?></a>
          </div>
      <?php endif;

      ?>
    </div>
</div>

<script>
  function tabs_code() {
    yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/tabs-code/tabs-code.js?1.01<?php echo $theme_version . time(); ?>', 'BODY', 'comparison');

  }
</script>

