<?php
/**
 * Template archive produits — Page Boutique (/shop)
 */
defined( 'ABSPATH' ) || exit;
get_header();

function ads_s( $key, $default = '' ) {
    return wp_kses_post( get_theme_mod( $key, $default ) );
}

$total_products = absint( wp_count_posts('product')->publish );
?>

<div class="shop-wrap">

  <!-- HERO -->
  <div class="shop-hero">
    <div class="shop-hero-inner">
      <div class="shop-hero-tag"><?php echo ads_s('ads_shop_tag', 'Notre Selection'); ?></div>
      <h1 class="shop-hero-title">
        <?php echo ads_s('ads_shop_title_l1', 'La Boutique'); ?><br>
        <em><?php echo ads_s('ads_shop_title_l2', 'Alchimie'); ?></em>
      </h1>
      <p class="shop-hero-sub"><?php echo ads_s('ads_shop_sub', 'Encens, resines et accessoires selectionnes pour leur authenticite et leur intensite olfactive.'); ?></p>
    </div>
    <?php if ( $total_products ) : ?>
    <div class="shop-hero-count">
      <div class="shop-hero-count-num"><?php echo $total_products; ?></div>
      <div class="shop-hero-count-label">References</div>
    </div>
    <?php endif; ?>
  </div>

  <!-- BARRE STICKY -->
  <div class="shop-toolbar">
    <div class="shop-tb-left">
      <div class="shop-tb-count">
        <?php
          global $wp_query;
          $found = $wp_query ? $wp_query->found_posts : 0;
          echo '<strong>' . $found . '</strong>&nbsp;reference' . ( $found > 1 ? 's' : '' );
        ?>
      </div>
      <?php
      $cats = get_terms( array('taxonomy'=>'product_cat','hide_empty'=>true) );
      if ( $cats && ! is_wp_error( $cats ) ) : ?>
        <div class="shop-filters">
          <?php foreach ( $cats as $cat ) :
            $active = is_product_category( $cat->slug ) ? ' current-cat' : ''; ?>
            <a href="<?php echo esc_url( get_term_link($cat) ); ?>"
               class="shop-filter-btn<?php echo $active; ?>">
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

  <!-- GRILLE PRODUITS -->
  <div class="shop-grid-wrap">
    <?php if ( woocommerce_product_loop() ) : ?>
    <div class="shop-grid">

      <?php
      $idx             = 0;
      $editorial_after = 4;

      while ( have_posts() ) : the_post();

        global $product;
        $product  = wc_get_product( get_the_ID() );
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
        $cat_name = ( $terms && ! is_wp_error($terms) ) ? esc_html($terms[0]->name) : '';
        $desc     = $product->get_short_description();
        if ( ! $desc ) $desc = wp_trim_words( $product->get_description(), 14 );

        $badge      = ads_card_badge( $product );
        $featured   = ( $idx === 0 );
        $card_class = 'shop-card' . ( $featured ? ' card-featured' : '' );
        $num        = sprintf( '%02d', $idx + 1 );
        $loading    = ( $idx < 3 ) ? 'eager' : 'lazy';
      ?>

      <article class="<?php echo $card_class; ?>"
               onclick="window.location='<?php echo esc_url($link); ?>'">

        <div class="shop-card-img">
          <img src="<?php echo esc_url($img_url); ?>"
               alt="<?php echo esc_attr( get_the_title() ); ?>"
               loading="<?php echo $loading; ?>" />
          <span class="shop-card-num"><?php echo $num; ?></span>
          <?php if ( $badge ) : ?>
            <span class="shop-badge shop-badge-<?php echo esc_attr($badge['id']); ?>"><?php echo $badge['label']; ?></span>
          <?php endif; ?>
          <div class="shop-card-overlay">
            <a class="shop-card-quick"
               href="<?php echo esc_url($link); ?>"
               onclick="event.stopPropagation()">
              Decouvrir
            </a>
          </div>
        </div>

        <div class="shop-card-body">
          <?php if ( $cat_name ) echo '<div class="shop-card-cat">' . $cat_name . '</div>'; ?>
          <h2 class="shop-card-name"><?php the_title(); ?></h2>
          <?php if ( $desc ) echo '<p class="shop-card-desc">' . wp_strip_all_tags($desc) . '</p>'; ?>
          <div class="shop-card-sep"></div>
          <div class="shop-card-foot">
            <div class="shop-card-price-wrap">
              <?php if ( $sale && $reg ) echo '<span class="shop-card-old">' . wc_price($reg) . '</span>'; ?>
              <span class="shop-card-current"><?php echo strip_tags( $product->get_price_html() ); ?></span>
            </div>
            <?php if ( $stock || $product->backorders_allowed() ) : ?>
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
        <div class="shop-editorial-label"><?php echo ads_s('ads_shop_editorial_label','La philosophie'); ?></div>
        <div class="shop-editorial-text"><?php echo ads_s('ads_shop_editorial','&laquo; L&rsquo;encens comme rituel. &raquo;'); ?></div>
      </div>
      <?php endif; ?>

      <?php endwhile; ?>
    </div>

    <?php else : ?>
    <div class="shop-grid">
      <div class="shop-empty">
        <p><?php echo ads_s('ads_shop_empty','Aucun produit disponible pour le moment.'); ?></p>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <!-- PAGINATION -->
  <div class="shop-pagination">
    <?php woocommerce_pagination(); ?>
  </div>

</div>
<?php get_footer(); ?>
