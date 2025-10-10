<?php
/**
 * Logos Catalog Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$block_data = yugabyte_block_data( $post_id, $block['name'], 'yb-logos-catalog-section yb-sec come-out' );
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
<svg style="display:none;">
<style>
<?php
require 'logos-catalog.css';
?>
</style>
</svg>

<section class="<?php echo esc_attr( $class_name ); ?>" data-lazy="logos_catalog">
	<div class="container">
    <div class="logos-catalog">
      <div class="logos-catalog-menu">
        <div class="catalog-menu-title">CATEGORY</div>
        <div class="cat-mob-menu">All</div>
        <div class="cat-mob-container">
          <div class="cat-mob-menu-close"></div>
          <span data-name="all" class="active">All</span>
          <?php
          foreach ( $acf_fields['catalogues'] as $catalogue ) {
            if ( $catalogue ) {
              $title = $catalogue['title'];
              $titleData = str_replace(" ", "-",$catalogue['title']);
              $titleData = strtolower($titleData);

              echo '<span data-name="'.$titleData.'">'.$title.'</span>';
            }
          }
          ?>
        </div>
      </div>
      <div class="logos-catalog-views" id="catalog-views"><?php
        foreach ( $acf_fields['catalogues'] as $key => $catalogue ) {
          if ( $catalogue ) {
            $title     = $catalogue['title'];
            $titleData = str_replace(" ", "-",$catalogue['title']);
            $titleData = strtolower($titleData);
            $desc      = $catalogue['desc'];
            $mobHidden = '';
            if($key > 3){
              $mobHidden = ' mob-hidden';
            }
            echo '<div class="cat-view'.$mobHidden.'" data-name="'.$titleData.'">
              <h3>'.$title.'</h3>
            ';
            if(!empty($desc)){
              echo '<div class="cat-desc">'.$desc.'</div>';
            }
            foreach ( $catalogue['logos'] as $logo ) {
              if ( $logo ) {
                $desc = $logo['desc'];
                $image = $logo['image'];
                $subs  = $logo['slider_subs'];

                if(!empty($desc)){
                  echo '<div class="cat-logo-desc">'.$logo['content'].'</div>';
                }else{
                  $tagStart = '<div class="cat-logo">';
                  $tagEnd   = '</div>';
                  $url      = $logo['url'];
                  if(!empty($url)){
                    $newTab = '';
                    if(!empty($logo['new_tab'])){
                      $newTab = ' target="_blank" rel="noopener"';
                    }
                    $tagStart = '<a href="'.$url.'" class="cat-logo"'.$newTab.'>';
                    $tagEnd   = '</a>';
                  }
                  
                  
                  echo $tagStart;
                    if(!empty($image)){
                        echo '<img ' . $data_pre . 'src="' . $image['url'] . '" alt="' . $image['alt'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '">';
                      } else {
                        echo '<img ' . $data_pre . 'src="/wp-content/themes/yugabyte/assets/images/rebrand/yugabyte-logomark-orange.svg" alt="Yugabyte" width="60" height="54">';
                      }
                    if(!empty($subs)){
                      echo '<div class="logo-sub">'.$subs.'</div>';
                    }                    
                  echo $tagEnd;
                  
                  
                }
              }
            }
            echo '</div>';
            
          }
        }
    ?>
        <div class="button-style yb--link-black cta-button-small link-cta-icon">View All</div>
      </div>
    </div>
    
	</div>
</section>

<script>
function logos_catalog() {
	yugabyteLoadJs('/wp-content/themes/yugabyte/blocks/logos-catalog/logos-catalog.js?<?php echo $theme_version; ?>', 'BODY','logos_catalog');
}
</script>
