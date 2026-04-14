<?php
/**
 * Template pages de categories WooCommerce
 * Applique exactement le meme rendu que archive-product.php (boutique)
 * en adaptant le hero au nom / description / image de la categorie.
 *
 * WooCommerce cherche ce fichier dans woocommerce/taxonomy-product_cat.php
 * avant tout autre template.
 */
defined( 'ABSPATH' ) || exit;
get_header();

function ads_s( $key, $default = '' ) {
    return wp_kses_post( get_theme_mod( $key, $default ) );
}

// --- Categorie courante ---
$cat      = get_queried_object();
$slug     = $cat ? $cat->slug        : '';
$slug_key = preg_replace( '/[^a-z0-9]/', '_', strtolower( $slug ) );
$name     = $cat ? $cat->name        : '';
$desc     = $cat ? $cat->description : '';
$count    = $cat ? $cat->count       : 0;

// Image de la categorie (optionnelle)
$thumb_id  = $cat ? absint( get_term_meta( $cat->term_id, 'thumbnail_id', true ) ) : 0;
$thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'ads-hero' ) : '';

// Textes customizer
$default_tag     = ads_s( 'ads_cat_default_tag', 'Collection' );
$default_ed_lbl  = ads_s( 'ads_cat_default_ed_label', 'La sélection' );
$default_ed_txt  = ads_s( 'ads_cat_default_ed_text',  '« Chaque forme, une expérience olfactive unique. »' );

$hero_tag    = ads_s( 'ads_cat_'.$slug_key.'_tag',      $default_tag );
$hero_sub    = ads_s( 'ads_cat_'.$slug_key.'_sub',      $desc );
$ed_label    = ads_s( 'ads_cat_'.$slug_key.'_ed_label', $default_ed_lbl );
$ed_text     = ads_s( 'ads_cat_'.$slug_key.'_ed_text',  $default_ed_txt );

$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url();
?>

<div class="shop-wrap cat-wrap cat-<?php echo esc_attr($slug); ?>">

  <!-- ═══ HERO ═══ -->
  <div class="shop-hero<?php echo $thumb_url ? ' cat-hero--img' : ''; ?>"
    <?php if ( $thumb_url ) echo 'style="background-image:url(\'' . esc_url($thumb_url) . '\');background-size:cover;background-position:center;"'; ?>
  >
    <?php if ( $thumb_url ) : ?><div class="cat-hero-overlay"></div><?php endif; ?>

    <div class="shop-hero-inner">
      <!-- Fil d'Ariane -->
      <nav class="cat-breadcrumb">
        <a href="<?php echo esc_url($shop_url); ?>" class="cat-bc-link">Boutique</a>
        <span class="cat-bc-sep">/</span>
        <span class="cat-bc-current"><?php echo esc_html($name); ?></span>
      </nav>

      <div class="shop-hero-tag"><?php echo $hero_tag; ?></div>

      <h1 class="shop-hero-title"><?php echo esc_html($name); ?></h1>

      <?php if ( $hero_sub ) : ?>
        <p class="shop-hero-sub"><?php echo $hero_sub; ?></p>
      <?php endif; ?>
    </div>

    <?php if ( $count ) : ?>
    <div class="shop-hero-count">
      <div class="shop-hero-count-num"><?php echo $count; ?></div>
      <div class="shop-hero-count-label">Référence<?php echo $count > 1 ? 's' : ''; ?></div>
    </div>
    <?php endif; ?>
  </div>

  <!-- ═══ BARRE STICKY ═══ -->
  <div class="shop-toolbar">
    <div class="shop-tb-left">
      <div class="shop-tb-count">
        <?php
          global $wp_query;
          $found = $wp_query ? (int) $wp_query->found_posts : 0;
          echo '<strong>' . $found . '</strong>&nbsp;référence' . ( $found > 1 ? 's' : '' );
        ?>
      </div>
      <!-- Lien retour -->
      <a href="<?php echo esc_url($shop_url); ?>" class="shop-filter-btn">&larr; Toute la boutique</a>
      <?php
      // Sous-categories
      $sub_cats = get_terms( array(
          'taxonomy'   => 'product_cat',
          'parent'     => $cat ? $cat->term_id : 0,
          'hide_empty' => true,
      ) );
      if ( $sub_cats && ! is_wp_error($sub_cats) ) :
          foreach ( $sub_cats as $sub ) :
              $active = is_product_category( $sub->slug ) ? ' current-cat' : '';
      ?>
          <a href="<?php echo esc_url( get_term_link($sub) ); ?>"
             class="shop-filter-btn<?php echo $active; ?>"><?php echo esc_html($sub->name); ?></a>
      <?php endforeach; endif; ?>
    </div>
    <div class="shop-tb-right">
      <?php woocommerce_catalog_ordering(); ?>
    </div>
  </div>

  <!-- ═══ GRILLE PRODUITS ═══ -->
  <div class="shop-grid-wrap">
    <?php if ( woocommerce_product_loop() ) : ?>
    <div class="shop-grid">

    <?php
    $idx             = 0;
    $editorial_after = 4;

    while ( have_posts() ) : the_post();

        global $product;
        $product = wc_get_product( get_the_ID() );
        if ( ! $product ) { $idx++; continue; }

        $img_id   = $product->get_image_id();
        $img_url  = $img_id
                    ? wp_get_attachment_image_url( $img_id, 'ads-product-featured' )
                    : wc_placeholder_img_src();
        $reg      = $product->get_regular_price();
        $sale     = $product->get_sale_price();
        $stock    = $product->is_in_stock();
        $link     = get_permalink();
        $terms    = get_the_terms( get_the_ID(), 'product_cat' );
        $pcat     = ( $terms && ! is_wp_error($terms) ) ? esc_html($terms[0]->name) : '';
        $short    = $product->get_short_description();
        if ( ! $short ) $short = wp_trim_words( $product->get_description(), 14 );

        $featured   = ( $idx === 0 );
        $card_class = 'shop-card' . ( $featured ? ' card-featured' : '' );
        $num        = sprintf('%02d', $idx + 1);
        $loading    = $idx < 3 ? 'eager' : 'lazy';
    ?>

      <article class="<?php echo $card_class; ?>"
               onclick="window.location='<?php echo esc_url($link); ?>'">

        <div class="shop-card-img">
          <img src="<?php echo esc_url($img_url); ?>"
               alt="<?php echo esc_attr( get_the_title() ); ?>"
               loading="<?php echo $loading; ?>" />
          <span class="shop-card-num"><?php echo $num; ?></span>
          <?php if ( $sale ) : ?>
            <span class="shop-badge shop-badge-promo">Promo</span>
          <?php elseif ( ! $stock ) : ?>
            <span class="shop-badge shop-badge-out">Épuisé</span>
          <?php endif; ?>
          <div class="shop-card-overlay">
            <a class="shop-card-quick"
               href="<?php echo esc_url($link); ?>"
               onclick="event.stopPropagation()">Découvrir</a>
          </div>
        </div>

        <div class="shop-card-body">
          <?php if ( $pcat ) echo '<div class="shop-card-cat">' . $pcat . '</div>'; ?>
          <h2 class="shop-card-name"><?php the_title(); ?></h2>
          <?php if ( $short ) echo '<p class="shop-card-desc">' . wp_strip_all_tags($short) . '</p>'; ?>
          <div class="shop-card-sep"></div>
          <div class="shop-card-foot">
            <div class="shop-card-price-wrap">
              <?php if ( $sale && $reg ) echo '<span class="shop-card-old">' . wc_price($reg) . '</span>'; ?>
              <span class="shop-card-current"><?php echo strip_tags( $product->get_price_html() ); ?></span>
            </div>
            <?php if ( $stock ) : ?>
              <button class="shop-card-btn"
                onclick="event.stopPropagation();window.location='<?php echo esc_url($link); ?>'">
                Voir
              </button>
            <?php else : ?>
              <span class="shop-card-out">Indisponible</span>
            <?php endif; ?>
          </div>
        </div>

      </article>

    <?php
      $idx++;
      if ( $idx === $editorial_after ) :
    ?>
      <div class="shop-editorial">
        <div class="shop-editorial-label"><?php echo $ed_label; ?></div>
        <div class="shop-editorial-text"><?php echo $ed_text; ?></div>
      </div>
    <?php endif; ?>

    <?php endwhile; ?>
    </div>

    <?php else : ?>
    <div class="shop-grid">
      <div class="shop-empty">
        <p>Aucun produit dans cette catégorie pour le moment.</p>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <!-- ═══ PAGINATION ═══ -->
  <div class="shop-pagination">
    <?php woocommerce_pagination(); ?>
  </div>

</div>
<?php get_footer(); ?>
