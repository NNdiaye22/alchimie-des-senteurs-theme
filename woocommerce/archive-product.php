<?php
/**
 * Template archive produits — Page Boutique (/shop)
 * Retravaillé aux couleurs et typographie du thème Alchimie des Senteurs
 */
defined( 'ABSPATH' ) || exit;
get_header();

function ads_s( $key, $default = '' ) {
    return wp_kses_post( get_theme_mod( $key, $default ) );
}
?>

<div class="shop-wrap">

  <!-- HERO BOUTIQUE -->
  <div class="shop-hero">
    <div class="shop-hero-inner">
      <div class="shop-hero-tag"><?php echo ads_s('ads_shop_tag', 'Notre Sélection'); ?></div>
      <h1 class="shop-hero-title">
        <?php echo ads_s('ads_shop_title_l1', 'La Boutique'); ?><br>
        <em><?php echo ads_s('ads_shop_title_l2', 'Alchimie'); ?></em>
      </h1>
      <p class="shop-hero-sub"><?php echo ads_s('ads_shop_sub', 'Encens, résines et accessoires sélectionnés pour leur authenticité et leur intensité olfactive.'); ?></p>
    </div>
  </div>

  <!-- BARRE FILTRES -->
  <div class="shop-toolbar">
    <div class="shop-toolbar-left">
      <?php woocommerce_result_count(); ?>
    </div>
    <div class="shop-toolbar-right">
      <?php woocommerce_catalog_ordering(); ?>
    </div>
  </div>

  <!-- GRILLE PRODUITS -->
  <div class="shop-grid-wrap">

    <?php if ( woocommerce_product_loop() ) : ?>
    <div class="shop-grid">
      <?php while ( have_posts() ) : the_post();
        global $product;
        $product    = wc_get_product( get_the_ID() );
        if ( ! $product ) continue;
        $img_id     = $product->get_image_id();
        $img_url    = $img_id ? wp_get_attachment_image_url( $img_id, 'ads-product-card' ) : wc_placeholder_img_src();
        $reg        = $product->get_regular_price();
        $sale       = $product->get_sale_price();
        $in_stock   = $product->is_in_stock();
        $link       = get_permalink();
        $terms      = get_the_terms( get_the_ID(), 'product_cat' );
        $cat        = ( $terms && ! is_wp_error($terms) ) ? esc_html($terms[0]->name) : '';
        $short_desc = $product->get_short_description();
        if ( ! $short_desc ) $short_desc = wp_trim_words( $product->get_description(), 12 );
      ?>
      <article class="shop-card" onclick="window.location='<?php echo esc_url($link); ?>'">

        <div class="shop-card-img">
          <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy" />
          <?php if ( $sale ) : ?>
            <span class="shop-badge shop-badge-promo">Promo</span>
          <?php elseif ( ! $in_stock ) : ?>
            <span class="shop-badge shop-badge-out">Épuisé</span>
          <?php endif; ?>
          <a class="shop-card-quick" href="<?php echo esc_url($link); ?>">Voir le produit</a>
        </div>

        <div class="shop-card-body">
          <?php if ( $cat ) echo '<div class="shop-card-cat">'.$cat.'</div>'; ?>
          <h2 class="shop-card-name"><?php the_title(); ?></h2>
          <?php if ( $short_desc ) echo '<p class="shop-card-desc">'.wp_strip_all_tags($short_desc).'</p>'; ?>
          <div class="shop-card-foot">
            <div class="shop-card-price">
              <?php if ( $sale && $reg ) echo '<span class="shop-card-old">'.wc_price($reg).'</span>'; ?>
              <span class="shop-card-current"><?php echo strip_tags($product->get_price_html()); ?></span>
            </div>
            <?php if ( $in_stock ) : ?>
              <button class="shop-card-btn" onclick="event.stopPropagation();window.location='<?php echo esc_url($link); ?>'">
                Ajouter
              </button>
            <?php else : ?>
              <span class="shop-card-out">Épuisé</span>
            <?php endif; ?>
          </div>
        </div>

      </article>
      <?php endwhile; ?>
    </div>
    <?php else : ?>
      <div class="shop-empty">
        <p><?php echo ads_s('ads_shop_empty', 'Aucun produit trouvé.'); ?></p>
      </div>
    <?php endif; ?>

  </div><!-- .shop-grid-wrap -->

  <!-- PAGINATION -->
  <div class="shop-pagination">
    <?php woocommerce_pagination(); ?>
  </div>

</div><!-- .shop-wrap -->

<?php get_footer(); ?>
