<?php
/**
 * Template pages de categories produit WooCommerce
 * S'applique a : /product-category/batonnets/
 *               /product-category/cones/
 *               et toutes les categories futures
 *
 * Le hero s'adapte automatiquement a chaque categorie :
 *   - Nom et description depuis l'admin WP
 *   - Image de la categorie si definie
 *   - Fallback sur le fond sombre --ink si pas d'image
 */
defined( 'ABSPATH' ) || exit;
get_header();

// --- Donnees de la categorie courante ---
$cat        = get_queried_object();          // WP_Term
$cat_name   = $cat ? $cat->name        : '';
$cat_desc   = $cat ? $cat->description : '';
$cat_slug   = $cat ? $cat->slug        : '';
$cat_count  = $cat ? $cat->count       : 0;

// Image de la categorie (definie dans Produits > Categories > modifier)
$thumb_id  = $cat ? get_term_meta( $cat->term_id, 'thumbnail_id', true ) : 0;
$thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'ads-hero' ) : '';

// Lien retour boutique
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url();

// Slug sans accents pour la cle customizer
$slug_key = preg_replace('/[^a-z0-9_]/', '_', strtolower( $cat_slug ) );

// Textes personnalisables via le Customizer
$hero_tag       = get_theme_mod( 'ads_cat_'.$slug_key.'_tag',      get_theme_mod( 'ads_cat_default_tag', 'Collection' ) );
$hero_sub       = get_theme_mod( 'ads_cat_'.$slug_key.'_sub',      $cat_desc );
$editorial_lbl  = get_theme_mod( 'ads_cat_'.$slug_key.'_ed_label', get_theme_mod( 'ads_cat_default_ed_label', 'La sélection' ) );
$editorial_txt  = get_theme_mod( 'ads_cat_'.$slug_key.'_ed_text',  get_theme_mod( 'ads_cat_default_ed_text',  '« Chaque forme, une expérience olfactive unique. »' ) );
?>

<div class="shop-wrap cat-wrap cat-<?php echo esc_attr($cat_slug); ?>">

  <!-- ==========================================================
       HERO CATEGORIE
  ========================================================== -->
  <div class="shop-hero cat-hero<?php echo $thumb_url ? ' cat-hero--img' : ''; ?>"
    <?php if ( $thumb_url ) : ?>
      style="background-image: url('<?php echo esc_url($thumb_url); ?>');background-size:cover;background-position:center;"
    <?php endif; ?>
  >
    <?php if ( $thumb_url ) : ?>
    <!-- Overlay sombre sur l'image -->
    <div class="cat-hero-overlay"></div>
    <?php endif; ?>

    <div class="shop-hero-inner">

      <!-- Fil d'Ariane discret -->
      <div class="cat-breadcrumb">
        <a href="<?php echo esc_url($shop_url); ?>" class="cat-bc-link">Boutique</a>
        <span class="cat-bc-sep">/</span>
        <span class="cat-bc-current"><?php echo esc_html($cat_name); ?></span>
      </div>

      <div class="shop-hero-tag"><?php echo wp_kses_post($hero_tag); ?></div>

      <h1 class="shop-hero-title">
        <?php echo esc_html($cat_name); ?>
      </h1>

      <?php if ( $hero_sub ) : ?>
      <p class="shop-hero-sub"><?php echo wp_kses_post($hero_sub); ?></p>
      <?php endif; ?>

    </div>

    <!-- Compteur produits -->
    <?php if ( $cat_count ) : ?>
    <div class="shop-hero-count">
      <div class="shop-hero-count-num"><?php echo $cat_count; ?></div>
      <div class="shop-hero-count-label">Référence<?php echo $cat_count > 1 ? 's' : ''; ?></div>
    </div>
    <?php endif; ?>
  </div>

  <!-- ==========================================================
       BARRE STICKY
  ========================================================== -->
  <div class="shop-toolbar">
    <div class="shop-tb-left">
      <div class="shop-tb-count">
        <?php
          global $wp_query;
          $found = $wp_query ? $wp_query->found_posts : 0;
          echo '<strong>' . $found . '</strong>&nbsp;référence' . ( $found > 1 ? 's' : '' );
        ?>
      </div>
      <!-- Lien retour boutique -->
      <a href="<?php echo esc_url($shop_url); ?>" class="shop-filter-btn">
        &larr; Toute la boutique
      </a>
      <?php
      // Sous-categories de cette categorie
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
           class="shop-filter-btn<?php echo $active; ?>">
          <?php echo esc_html($sub->name); ?>
        </a>
      <?php endforeach; endif; ?>
    </div>
    <div class="shop-tb-right">
      <?php woocommerce_catalog_ordering(); ?>
    </div>
  </div>

  <!-- ==========================================================
       GRILLE PRODUITS
  ========================================================== -->
  <div class="shop-grid-wrap">
    <?php if ( woocommerce_product_loop() ) : ?>
    <div class="shop-grid">

      <?php
      $idx             = 0;
      $editorial_after = 4;

      while ( have_posts() ) : the_post();
        global $product;
        $product = wc_get_product( get_the_ID() );
        if ( ! $product ) continue;

        $img_id  = $product->get_image_id();
        $img_url = $img_id
                   ? wp_get_attachment_image_url( $img_id, 'ads-product-featured' )
                   : wc_placeholder_img_src();
        $reg     = $product->get_regular_price();
        $sale    = $product->get_sale_price();
        $stock   = $product->is_in_stock();
        $link    = get_permalink();
        $terms   = get_the_terms( get_the_ID(), 'product_cat' );
        $pcat    = ( $terms && ! is_wp_error($terms) ) ? esc_html($terms[0]->name) : '';
        $desc    = $product->get_short_description();
        if ( ! $desc ) $desc = wp_trim_words( $product->get_description(), 14 );

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
          <?php if ( $pcat ) echo '<div class="shop-card-cat">'.$pcat.'</div>'; ?>
          <h2 class="shop-card-name"><?php the_title(); ?></h2>
          <?php if ( $desc ) echo '<p class="shop-card-desc">'.wp_strip_all_tags($desc).'</p>'; ?>
          <div class="shop-card-sep"></div>
          <div class="shop-card-foot">
            <div class="shop-card-price-wrap">
              <?php if ( $sale && $reg ) echo '<span class="shop-card-old">'.wc_price($reg).'</span>'; ?>
              <span class="shop-card-current"><?php echo strip_tags($product->get_price_html()); ?></span>
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
        <div class="shop-editorial-label"><?php echo wp_kses_post($editorial_lbl); ?></div>
        <div class="shop-editorial-text"><?php echo wp_kses_post($editorial_txt); ?></div>
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

  <!-- ==========================================================
       PAGINATION
  ========================================================== -->
  <div class="shop-pagination">
    <?php woocommerce_pagination(); ?>
  </div>

</div>
<?php get_footer(); ?>
