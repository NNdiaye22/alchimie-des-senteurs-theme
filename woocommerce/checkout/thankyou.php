<?php
/**
 * Confirmation de commande — Alchimie des Senteurs
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<div class="thankyou-wrap">

<?php if ( $order = wc_get_order( $order_id ) ) : ?>

  <!-- EN-TÊTE CONFIRMATION -->
  <div class="ty-hero">
    <div class="ty-hero-inner">
      <div class="ty-hero-check">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <circle cx="14" cy="14" r="13.25" stroke="currentColor" stroke-width="1.5"/>
          <polyline points="8,14 12,18 20,10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
        </svg>
      </div>
      <p class="ty-hero-tag">Commande n°<?php echo esc_html( $order->get_order_number() ); ?></p>
      <h1 class="ty-hero-title">Merci pour<br><em>votre confiance</em></h1>
      <p class="ty-hero-sub">Votre commande a bien été enregistrée. Notre équipe vous contactera dans les meilleurs délais pour confirmer l'envoi et vous communiquer les frais de livraison.</p>
    </div>
  </div>

  <!-- ÉTAPES DE SUIVI -->
  <div class="ty-steps">
    <div class="ty-step ty-step--done">
      <div class="ty-step-dot"></div>
      <div class="ty-step-body">
        <span class="ty-step-title">Commande reçue</span>
        <span class="ty-step-desc"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></span>
      </div>
    </div>
    <div class="ty-step ty-step--pending">
      <div class="ty-step-dot"></div>
      <div class="ty-step-body">
        <span class="ty-step-title">Confirmation &amp; frais de livraison</span>
        <span class="ty-step-desc">Nous vous rappelons au <?php echo esc_html( $order->get_billing_phone() ?: '—' ); ?></span>
      </div>
    </div>
    <div class="ty-step ty-step--future">
      <div class="ty-step-dot"></div>
      <div class="ty-step-body">
        <span class="ty-step-title">Préparation &amp; expédition</span>
        <span class="ty-step-desc">Dès confirmation de votre accord</span>
      </div>
    </div>
    <div class="ty-step ty-step--future">
      <div class="ty-step-dot"></div>
      <div class="ty-step-body">
        <span class="ty-step-title">Livraison &amp; paiement</span>
        <span class="ty-step-desc">Règlement en espèces à la réception</span>
      </div>
    </div>
  </div>

  <!-- DÉTAIL COMMANDE -->
  <div class="ty-layout">

    <div class="ty-main">

      <div class="ty-section">
        <h2 class="ty-section-title">Détail de la commande</h2>
        <table class="ty-table">
          <thead>
            <tr>
              <th>Produit</th>
              <th class="ty-table-right">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ( $order->get_items() as $item ) : ?>
            <tr>
              <td>
                <span class="ty-product-name"><?php echo esc_html( $item->get_name() ); ?></span>
                <span class="ty-product-qty">&times; <?php echo esc_html( $item->get_quantity() ); ?></span>
              </td>
              <td class="ty-table-right"><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
            <tr class="ty-total-row<?php echo ( $key === 'order_total' ) ? ' ty-grand-total' : ''; ?>">
              <th><?php echo esc_html( $total['label'] ); ?></th>
              <td class="ty-table-right"><?php echo wp_kses_post( $total['value'] ); ?></td>
            </tr>
            <?php endforeach; ?>
          </tfoot>
        </table>
      </div>

      <div class="ty-section ty-payment-block">
        <h2 class="ty-section-title">Paiement</h2>
        <p class="ty-payment-method"><?php echo esc_html( $order->get_payment_method_title() ); ?></p>
        <p class="ty-payment-note">Le règlement s&rsquo;effectue en espèces au moment de la livraison, après confirmation téléphonique.</p>
      </div>

    </div>

    <div class="ty-aside">

      <div class="ty-section">
        <h2 class="ty-section-title">Adresse de livraison</h2>
        <address class="ty-address">
          <?php echo wp_kses_post( $order->get_formatted_billing_address() ?: '<em>Non renseignée</em>' ); ?>
          <?php if ( $phone = $order->get_billing_phone() ) : ?>
          <span class="ty-address-phone"><?php echo esc_html( $phone ); ?></span>
          <?php endif; ?>
        </address>
      </div>

      <div class="ty-aside-info">
        <p>Vous avez une question&nbsp;? Contactez-nous directement — nous sommes disponibles pour vous accompagner.</p>
      </div>

      <div class="ty-actions">
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="ty-btn-primary">Continuer les achats</a>
        <?php if ( is_user_logged_in() ) : ?>
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="ty-btn-ghost">Mes commandes</a>
        <?php endif; ?>
      </div>

    </div>

  </div>

<?php else : ?>

  <div class="ty-layout">
    <div class="ty-main">
      <div class="ty-notice ty-notice--info">
        <p><?php echo wp_kses_post( apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Merci pour votre commande.', 'woocommerce' ), null ) ); ?></p>
      </div>
    </div>
  </div>

<?php endif; ?>

</div>

<?php
do_action( 'woocommerce_thankyou', $order_id );
get_footer();
?>
