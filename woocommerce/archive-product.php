<?php
/**
 * Template archive produits — Page Boutique (/shop)
 * Version premium — Alchimie des Senteurs
 */
defined( 'ABSPATH' ) || exit;
get_header();

function ads_s( $key, $default = '' ) {
    return wp_kses_post( get_theme_mod( $key, $default ) );
}

// Nombre total de produits publiés
$total_products = wp_count_posts( 'product' )->publish ?? '';
?>

<div class="shop-wrap">

  <!-- ═══ HERO ═══ -->
  <div class="shop-hero">
    <div class="shop-hero-inner">
      <div class="shop-hero-tag"><?php echo ads_s('ads_shop_tag', 'Notre Sélection'); ?></div>
      <h1 class="shop-hero-title">
        <?php echo ads_s('ads_shop_title_l1', 'La Boutique'); ?><br>
        <em><?php echo ads_s('ads_shop_title_l2', 'Alchimie'); ?></em>
      </h1>
      <p class="shop-hero-sub"><?php echo ads_s('ads_shop_sub', 'Encens, résines et accessoires sélectionnés pour leur authenticité et leur intensité olfactive.'); ?></p>
    </div>
    <?php if ( $total_products ) : ?>
    <div class="shop-hero-count">
      <div class="count-num"><?php echo esc_html( $total_products ); ?></div>
      <div class="count-label">Références</div>
    </div>
    <?php endif; ?>
  </div>

  <!-- ═══ BARRE OUTILS ═══ -->
  <div class="shop-toolbar">
    <div class="shop-tb-left">
      <div class="shop-tb-results">
        <?php
          global $wp_query;
          $found = $wp_query->found_posts ?? 0;
          echo '<strong>' . $found . '</strong> référence' . ( $found > 1 ? 's' : '' );
        ?>
      </div>
      <?php
      // Filtres catégories dynamiques
      $cats = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true ) );
      if ( $cats && ! is_wp_error( $cats ) ) : ?>
      <div class="shop-filters">
        <?php foreach ( $cats as $cat ) : ?>
          <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="shop-filter-btn">
            <?php echo esc_html( $cat->name ); ?>
          </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
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
      $card_index = 0;
      // Position du bandeau éditorial (après la 4e carte)
      $editorial_after = 4;

      while ( have_posts() ) : the_post();
        global $product;
        $product   = wc_get_product( get_the_ID() );
        if ( ! $product ) continue;

        $img_id    = $product->get_image_id();
        $img_url   = $img_id
          ? wp_get_attachment_image_url( $img_id, 'woocommerce_single' )
          : wc_placeholder_img_src();
        $reg       = $product->get_regular_price();
        $sale      = $product->get_sale_price();
        $in_stock  = $product->is_in_stock();
        $link      = get_permalink();
        $terms     = get_the_terms( get_the_ID(), 'product_cat' );
        $cat       = ( $terms && ! is_wp_error($terms) ) ? esc_html($terms[0]->name) : '';
        $short     = $product->get_short_description();
        if ( ! $short ) $short = wp_trim_words( $product->get_description(), 14 );

        $is_featured = ( $card_index === 0 );
        $card_class  = 'shop-card' . ( $is_featured ? ' card-featured' : '' );
        $num_label   = sprintf( '%02d', $card_index + 1 );
      ?>

      <article class="<?php echo $card_class; ?>" onclick="window.location='<?php echo esc_url($link); ?>'">

        <div class="shop-card-img">
          <img src="<?php echo esc_url($img_url); ?>"
               alt="<?php echo esc_attr(get_the_title()); ?>"
               loading="<?php echo $card_index < 3 ? 'eager' : 'lazy'; ?>" />
          <span class="shop-card-num"><?php echo $num_label; ?></span>
          <?php if ( $sale ) : ?>
            <span class="shop-badge shop-badge-promo">Promo</span>
          <?php elseif ( ! $in_stock ) : ?>
            <span class="shop-badge shop-badge-out">Épuisé</span>
          <?php endif; ?>
          <div class="shop-card-overlay">
            <a class="shop-card-quick" href="<?php echo esc_url($link); ?>">Découvrir</a>
          </div>
        </div>

        <div class="shop-card-body">
          <?php if ( $cat ) echo '<div class="shop-card-cat">'.$cat.'</div>'; ?>
          <h2 class="shop-card-name"><?php the_title(); ?></h2>
          <?php if ( $short ) echo '<p class="shop-card-desc">'.wp_strip_all_tags($short).'</p>'; ?>
          <div class="shop-card-sep"></div>
          <div class="shop-card-foot">
            <div class="shop-card-price">
              <?php if ( $sale && $reg ) echo '<span class="shop-card-old">'.wc_price($reg).'</span>'; ?>
              <span class="shop-card-current"><?php echo strip_tags($product->get_price_html()); ?></span>
            </div>
            <?php if ( $in_stock ) : ?>
              <button class="shop-card-btn"
                onclick="event.stopPropagation();window.location='<?php echo esc_url($link); ?>'">
                Ajouter
              </button>
            <?php else : ?>
              <span class="shop-card-out">Indisponible</span>
            <?php endif; ?>
          </div>
        </div>

      </article>

      <?php
        $card_index++;

        // Insère le bandeau éditorial après la 4e carte
        if ( $card_index === $editorial_after ) :
          $editorial_text = ads_s('ads_shop_editorial', 'L’encens comme rituel.');
          $editorial_label = ads_s('ads_shop_editorial_label', 'La philosophie');
      ?>
      <div class="shop-editorial">
        <div class="shop-editorial-label"><?php echo $editorial_label; ?></div>
        <div class="shop-editorial-text"><?php echo $editorial_text; ?></div>
      </div>
      <?php endif; ?>

      <?php endwhile; ?>

    </div><!-- .shop-grid -->

    <?php else : ?>
    <div class="shop-empty">
      <p><?php echo ads_s('ads_shop_empty', 'Aucun produit disponible pour le moment.'); ?></p>
    </div>
    <?php endif; ?>
  </div><!-- .shop-grid-wrap -->

  <!-- ═══ PAGINATION ═══ -->
  <div class="shop-pagination">
    <?php woocommerce_pagination(); ?>
  </div>

</div><!-- .shop-wrap -->

<?php get_footer(); ?>
