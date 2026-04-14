<?php
/**
 * Page Panier — Alchimie des Senteurs
 * Override de woocommerce/cart/cart.php
 */
defined( 'ABSPATH' ) || exit;
get_header();

$shop_url     = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url();
$checkout_url = function_exists('wc_get_checkout_url')  ? wc_get_checkout_url()         : home_url();
?>

<div class="cart-wrap">

  <!-- ======================================================
       HERO
  ====================================================== -->
  <div class="cart-hero">
    <div class="cart-hero-inner">
      <div class="cart-hero-tag">Mon Panier</div>
      <h1 class="cart-hero-title">
        Votre<br><em>Sélection</em>
      </h1>
    </div>
    <div class="cart-hero-count">
      <div class="cart-hero-count-num"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
      <div class="cart-hero-count-label">Article<?php echo WC()->cart->get_cart_contents_count() > 1 ? 's' : ''; ?></div>
    </div>
  </div>

  <?php if ( WC()->cart->is_empty() ) : ?>

  <!-- ======================================================
       PANIER VIDE
  ====================================================== -->
  <div class="cart-empty">
    <div class="cart-empty-icon">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 01-8 0"/>
      </svg>
    </div>
    <p class="cart-empty-text">Votre panier est vide.</p>
    <a href="<?php echo esc_url($shop_url); ?>" class="cart-btn-primary">Voir la boutique</a>
  </div>

  <?php else : ?>

  <!-- ======================================================
       CONTENU DU PANIER
  ====================================================== -->
  <div class="cart-layout">

    <!-- ---- COLONNE GAUCHE : liste des articles ---- -->
    <div class="cart-items-col">

      <div class="cart-items-head">
        <span class="cart-items-head-product">Produit</span>
        <span class="cart-items-head-qty">Qté</span>
        <span class="cart-items-head-price">Prix</span>
      </div>

      <form class="cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

        <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
          $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
          $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
          if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] === 0 ) continue;

          $product_permalink = $_product->is_visible() ? get_permalink( $product_id ) : '';
          $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('ads-product-card'), $cart_item, $cart_item_key );
          $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
          $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
          $product_subtotal  = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
          $terms             = get_the_terms( $product_id, 'product_cat' );
          $cat_name          = ( $terms && ! is_wp_error($terms) ) ? $terms[0]->name : '';
          $short             = $_product->get_short_description();
          if ( ! $short ) $short = wp_trim_words( $_product->get_description(), 10 );
        ?>

        <div class="cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart-item', $cart_item, $cart_item_key ) ); ?>">

          <!-- Image -->
          <div class="cart-item-img">
            <?php if ( $product_permalink ) : ?>
              <a href="<?php echo esc_url($product_permalink); ?>"><?php echo $thumbnail; ?></a>
            <?php else : ?>
              <?php echo $thumbnail; ?>
            <?php endif; ?>
          </div>

          <!-- Infos produit -->
          <div class="cart-item-info">
            <?php if ( $cat_name ) echo '<div class="cart-item-cat">' . esc_html($cat_name) . '</div>'; ?>
            <div class="cart-item-name">
              <?php if ( $product_permalink ) : ?>
                <a href="<?php echo esc_url($product_permalink); ?>"><?php echo $product_name; ?></a>
              <?php else : ?>
                <?php echo $product_name; ?>
              <?php endif; ?>
            </div>
            <?php if ( $short ) echo '<div class="cart-item-desc">' . wp_strip_all_tags($short) . '</div>'; ?>
            <?php do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key ); ?>
            <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
            <!-- Supprimer -->
            <?php echo apply_filters( 'woocommerce_cart_item_remove_link',
              sprintf(
                '<a href="%s" class="cart-item-remove" aria-label="%s" data-product_id="%s" data-cart_item_key="%s">&#10005; Retirer</a>',
                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                esc_attr__( 'Remove this item', 'woocommerce' ),
                esc_attr( $product_id ),
                esc_attr( $cart_item_key )
              ),
              $cart_item_key
            ); ?>
          </div>

          <!-- Quantité -->
          <div class="cart-item-qty">
            <?php
            if ( $_product->is_sold_individually() ) :
              echo '<span class="cart-item-qty-solo">1</span>';
              echo '<input type="hidden" name="cart[' . esc_attr($cart_item_key) . '][qty]" value="1">';
            else :
              woocommerce_quantity_input( array(
                'input_name'   => 'cart[' . esc_attr($cart_item_key) . '][qty]',
                'input_value'  => $cart_item['quantity'],
                'max_value'    => $_product->get_max_purchase_quantity(),
                'min_value'    => '0',
                'product_name' => $product_name,
              ), $_product );
            endif;
            ?>
          </div>

          <!-- Sous-total -->
          <div class="cart-item-subtotal">
            <?php echo $product_subtotal; ?>
          </div>

        </div>

        <?php endforeach; ?>

        <!-- Actions panier -->
        <div class="cart-actions">
          <?php do_action( 'woocommerce_cart_actions' ); ?>
          <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
          <button type="submit" class="cart-btn-update" name="update_cart" value="1">
            Mettre à jour
          </button>
          <a href="<?php echo esc_url($shop_url); ?>" class="cart-btn-continue">
            &larr; Continuer les achats
          </a>
        </div>

      </form>
    </div><!-- /.cart-items-col -->

    <!-- ---- COLONNE DROITE : récapitulatif ---- -->
    <div class="cart-summary-col">

      <div class="cart-summary">

        <div class="cart-summary-title">Récapitulatif</div>

        <!-- Totaux WooCommerce -->
        <div class="cart-summary-totals">

          <div class="cart-summary-row">
            <span>Sous-total</span>
            <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
          </div>

          <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
          <div class="cart-summary-row cart-summary-coupon">
            <span>
              Code promo<br>
              <small><?php echo esc_html($code); ?></small>
            </span>
            <span class="cart-summary-discount">
              &minus; <?php echo wc_price( WC()->cart->get_coupon_discount_amount( $code, WC()->cart->display_cart_ex_tax ) ); ?>
            </span>
          </div>
          <?php endforeach; ?>

          <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
          <div class="cart-summary-row">
            <span>Livraison</span>
            <span><?php woocommerce_shipping_calculator(); ?></span>
          </div>
          <?php endif; ?>

          <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
          <div class="cart-summary-row">
            <span><?php echo esc_html( $fee->name ); ?></span>
            <span><?php echo wc_price( $fee->total ); ?></span>
          </div>
          <?php endforeach; ?>

          <?php wc_get_template( 'cart/cart-tax-totals.php' ); ?>

          <div class="cart-summary-row cart-summary-total">
            <span>Total</span>
            <span><?php echo WC()->cart->get_total(); ?></span>
          </div>

        </div>

        <!-- Code promo -->
        <?php if ( wc_coupons_enabled() ) : ?>
        <div class="cart-coupon">
          <div class="cart-coupon-label">Code promo</div>
          <div class="cart-coupon-row">
            <input type="text"
                   id="coupon_code"
                   class="cart-coupon-input"
                   name="coupon_code"
                   value=""
                   placeholder="Votre code&hellip;" />
            <button type="button"
                    class="cart-coupon-btn"
                    onclick="
                      var code = document.getElementById('coupon_code').value;
                      if(code){
                        var f = document.createElement('form');
                        f.method='post'; f.action='';
                        var i1=document.createElement('input'); i1.type='hidden'; i1.name='coupon_code'; i1.value=code; f.appendChild(i1);
                        var i2=document.createElement('input'); i2.type='hidden'; i2.name='apply_coupon'; i2.value='1'; f.appendChild(i2);
                        var i3=document.createElement('input'); i3.type='hidden'; i3.name='woocommerce-cart-nonce'; i3.value='<?php echo wp_create_nonce('woocommerce-cart'); ?>'; f.appendChild(i3);
                        document.body.appendChild(f); f.submit();
                      }">
              Appliquer
            </button>
          </div>
        </div>
        <?php endif; ?>

        <!-- Bouton commander -->
        <a href="<?php echo esc_url($checkout_url); ?>" class="cart-btn-checkout">
          Commander
          <span class="cart-btn-arrow">&rarr;</span>
        </a>

        <!-- Moyens de paiement -->
        <?php
        $pay_raw = get_theme_mod( 'ads_footer_pay', 'Orange Money,Wave,Carte' );
        $methods = array_filter( array_map( 'trim', explode(',', $pay_raw) ) );
        if ( $methods ) :
        ?>
        <div class="cart-payment-methods">
          <?php foreach ( $methods as $m ) : ?>
            <span class="cart-payment-badge"><?php echo esc_html($m); ?></span>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Livraison info -->
        <div class="cart-delivery-info">
          <div class="cart-delivery-row">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Livraison sur Dakar & environs
          </div>
          <div class="cart-delivery-row">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013 7.18 2 2 0 014.99 5h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L9.91 12a16 16 0 006.09 6.09l.31-.31a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 20z"/></svg>
            <?php echo esc_html( get_theme_mod( 'ads_contact_wa_label', '+221 77 644 01 25' ) ); ?>
          </div>
        </div>

      </div>
    </div><!-- /.cart-summary-col -->

  </div><!-- /.cart-layout -->

  <?php endif; // panier non vide ?>

</div><!-- /.cart-wrap -->

<?php get_footer(); ?>
