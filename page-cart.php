<?php
/**
 * Template page Panier — Alchimie des Senteurs
 */
defined( 'ABSPATH' ) || exit;
get_header();

$shop_url     = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url();
$checkout_url = function_exists('wc_get_checkout_url')  ? wc_get_checkout_url()         : home_url();

if ( function_exists('WC') && WC()->cart ) {
    WC()->cart->calculate_totals();
}
?>

<div class="cart-wrap">

  <!-- HERO -->
  <div class="cart-hero">
    <div class="cart-hero-inner">
      <div class="cart-hero-tag">Mon Panier</div>
      <h1 class="cart-hero-title">Votre<br><em>Sélection</em></h1>
    </div>
    <div class="cart-hero-count">
      <div class="cart-hero-count-num"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
      <div class="cart-hero-count-label">Article<?php echo WC()->cart->get_cart_contents_count() > 1 ? 's' : ''; ?></div>
    </div>
  </div>

  <?php if ( WC()->cart->is_empty() ) : ?>

  <div class="cart-empty">
    <div class="cart-empty-icon">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
    </div>
    <p class="cart-empty-text">Votre panier est vide.</p>
    <a href="<?php echo esc_url($shop_url); ?>" class="cart-btn-primary">Voir la boutique</a>
  </div>

  <?php else : ?>

  <div class="cart-layout">

    <!-- COLONNE ARTICLES -->
    <div class="cart-items-col">
      <div class="cart-items-head">
        <span class="cart-items-head-product">Produit</span>
        <span class="cart-items-head-qty">Qté</span>
        <span class="cart-items-head-price">Prix</span>
      </div>

      <form class="cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

        <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
          $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
          $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
          if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] === 0 ) continue;

          $permalink = $_product->is_visible() ? get_permalink( $product_id ) : '';
          $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('ads-product-card'), $cart_item, $cart_item_key );
          $name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
          $subtotal  = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
          $terms     = get_the_terms( $product_id, 'product_cat' );
          $cat_name  = ( $terms && ! is_wp_error($terms) ) ? $terms[0]->name : '';
          $short     = $_product->get_short_description();
          if ( ! $short ) $short = wp_trim_words( $_product->get_description(), 10 );
        ?>
        <div class="cart-item">
          <div class="cart-item-img">
            <?php echo $permalink ? '<a href="'.esc_url($permalink).'">'.$thumbnail.'</a>' : $thumbnail; ?>
          </div>
          <div class="cart-item-info">
            <?php if ( $cat_name ) echo '<div class="cart-item-cat">'.esc_html($cat_name).'</div>'; ?>
            <div class="cart-item-name">
              <?php echo $permalink ? '<a href="'.esc_url($permalink).'">'.esc_html($name).'</a>' : esc_html($name); ?>
            </div>
            <?php if ( $short ) echo '<div class="cart-item-desc">'.wp_strip_all_tags($short).'</div>'; ?>
            <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
            <?php echo apply_filters( 'woocommerce_cart_item_remove_link',
              sprintf( '<a href="%s" class="cart-item-remove" data-product_id="%s" data-cart_item_key="%s">&#10005; Retirer</a>',
                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                esc_attr( $product_id ),
                esc_attr( $cart_item_key )
              ), $cart_item_key
            ); ?>
          </div>
          <div class="cart-item-qty">
            <?php if ( $_product->is_sold_individually() ) :
              echo '<span class="cart-item-qty-solo">1</span><input type="hidden" name="cart['.esc_attr($cart_item_key).'][qty]" value="1">';
            else :
              woocommerce_quantity_input( array(
                'input_name'  => 'cart['.esc_attr($cart_item_key).'][qty]',
                'input_value' => $cart_item['quantity'],
                'max_value'   => $_product->get_max_purchase_quantity(),
                'min_value'   => '0',
              ), $_product );
            endif; ?>
          </div>
          <div class="cart-item-subtotal"><?php echo $subtotal; ?></div>
        </div>
        <?php endforeach; ?>

        <div class="cart-actions">
          <?php do_action( 'woocommerce_cart_actions' ); ?>
          <button type="submit" class="cart-btn-update" name="update_cart" value="1">Mettre à jour</button>
          <a href="<?php echo esc_url($shop_url); ?>" class="cart-btn-continue">&larr; Continuer les achats</a>
        </div>
      </form>
    </div>

    <!-- COLONNE RECAPITULATIF -->
    <div class="cart-summary-col">
      <div class="cart-summary">

        <div class="cart-summary-title">Récapitulatif</div>

        <div class="cart-summary-totals">
          <div class="cart-summary-row">
            <span>Sous-total</span>
            <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
          </div>
          <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
          <div class="cart-summary-row">
            <span>Code promo <small><?php echo esc_html($code); ?></small></span>
            <span class="cart-summary-discount">&minus; <?php echo wc_price( WC()->cart->get_coupon_discount_amount($code) ); ?></span>
          </div>
          <?php endforeach; ?>
          <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
          <div class="cart-summary-row">
            <span>Livraison</span>
            <span><?php woocommerce_shipping_calculator(); ?></span>
          </div>
          <?php endif; ?>
          <div class="cart-summary-row cart-summary-total">
            <span>Total</span>
            <span><?php echo WC()->cart->get_total(); ?></span>
          </div>
        </div>

        <?php if ( wc_coupons_enabled() ) : ?>
        <div class="cart-coupon">
          <div class="cart-coupon-label">Code promo</div>
          <form method="post" action="">
            <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
            <div class="cart-coupon-row">
              <input type="text" name="coupon_code" class="cart-coupon-input" placeholder="Votre code…" />
              <button type="submit" name="apply_coupon" class="cart-coupon-btn">Appliquer</button>
            </div>
          </form>
        </div>
        <?php endif; ?>

        <a href="<?php echo esc_url($checkout_url); ?>" class="cart-btn-checkout">
          Commander <span class="cart-btn-arrow">&rarr;</span>
        </a>

        <!-- Moyens de paiement -->
        <?php
        $pay_raw = get_theme_mod( 'ads_footer_pay', 'Orange Money,Wave,Carte' );
        $methods = array_filter( array_map( 'trim', explode(',', $pay_raw) ) );
        if ( $methods ) :
        ?>
        <div class="cart-payment-methods">
          <?php foreach ( $methods as $m ) echo '<span class="cart-payment-badge">'.esc_html($m).'</span>'; ?>
        </div>
        <?php endif; ?>

        <!-- Infos livraison -->
        <div class="cart-delivery-info">
          <div class="cart-delivery-row">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Livraison sur Dakar &amp; environs
          </div>
          <?php ads_phone( 'cart', 'cart-delivery-row' ); ?>
        </div>

      </div>
    </div>

  </div>
  <?php endif; ?>

</div>
<?php get_footer(); ?>
