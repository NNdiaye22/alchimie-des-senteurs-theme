<?php
/**
 * Confirmation de commande — Alchimie des Senteurs
 */
defined( 'ABSPATH' ) || exit;

// Récupérer $order_id de façon fiable
if ( empty( $order_id ) ) {
    global $wp;
    $order_id = isset( $wp->query_vars['order-received'] ) ? absint( $wp->query_vars['order-received'] ) : 0;
}

get_header();
?>

<div class="thankyou-wrap">

<?php if ( $order_id && ( $order = wc_get_order( $order_id ) ) ) : ?>

  <!-- HERO -->
  <section class="thankyou-hero">
    <div class="thankyou-hero-inner">
      <div class="ty-tag">Commande n°<?php echo esc_html( $order->get_order_number() ); ?></div>
      <h1 class="ty-title">Merci pour<br><em>votre confiance</em></h1>
      <p class="ty-sub">Votre commande a bien été enregistrée. Notre équipe vous contactera dans les meilleurs délais pour confirmer l'envoi et vous communiquer les frais de livraison.</p>
    </div>
  </section>

  <!-- BANDE ÉTAPES RAPIDES -->
  <div class="ty-quick">
    <div class="ty-quick-item ty-quick-item--done">
      <div class="ty-quick-dot"></div>
      <div class="ty-quick-label">Commande reçue</div>
      <div class="ty-quick-value"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></div>
    </div>
    <div class="ty-quick-item ty-quick-item--active">
      <div class="ty-quick-dot"></div>
      <div class="ty-quick-label">Confirmation</div>
      <div class="ty-quick-value">Appel au <?php echo esc_html( $order->get_billing_phone() ?: '—' ); ?></div>
    </div>
    <div class="ty-quick-item">
      <div class="ty-quick-dot"></div>
      <div class="ty-quick-label">Préparation</div>
      <div class="ty-quick-value">Après accord</div>
    </div>
    <div class="ty-quick-item">
      <div class="ty-quick-dot"></div>
      <div class="ty-quick-label">Livraison</div>
      <div class="ty-quick-value">Règlement à réception</div>
    </div>
  </div>

  <!-- LAYOUT PRINCIPAL -->
  <div class="ty-layout">

    <!-- COLONNE PRINCIPALE -->
    <div class="ty-main">

      <!-- Détail commande -->
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

      <!-- Paiement -->
      <div class="ty-section">
        <h2 class="ty-section-title">Paiement</h2>
        <p class="ty-payment-method"><?php echo esc_html( $order->get_payment_method_title() ); ?></p>
        <p class="ty-payment-note">Le règlement s'effectue en espèces au moment de la livraison, après confirmation téléphonique.</p>
      </div>

    </div>

    <!-- ASIDE -->
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

      <div class="ty-aside-note">
        <p>Une question ? Contactez-nous — nous sommes disponibles pour vous accompagner.</p>
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
        <p><?php esc_html_e( 'Merci pour votre commande.', 'woocommerce' ); ?></p>
      </div>
    </div>
  </div>

<?php endif; ?>

</div>

<?php
if ( ! empty( $order_id ) ) {
    do_action( 'woocommerce_thankyou', $order_id );
}
get_footer();
?>
