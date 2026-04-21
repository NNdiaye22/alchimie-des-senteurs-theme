<?php
/**
 * Confirmation de commande — Alchimie des Senteurs
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<div class="thankyou-wrap">

  <div class="thankyou-hero">
    <p class="ty-tag"><?php esc_html_e( 'Commande', 'woocommerce' ); ?></p>
    <h1 class="ty-title">Validation de<br><em>votre commande</em></h1>
  </div>

  <?php if ( $order = wc_get_order( $order_id ) ) : ?>

  <div class="ty-layout">

    <!-- COLONNE GAUCHE : résumé -->
    <div class="ty-main">

      <div class="ty-notice">
        <span class="ty-notice-icon">&#10003;</span>
        <p><?php echo wp_kses_post( apply_filters( 'woocommerce_thankyou_order_received_text',
          __( 'Merci. Votre commande a été bien reçue. Notre équipe vous contactera par téléphone pour confirmer la livraison.', 'woocommerce' ),
          $order
        ) ); ?></p>
      </div>

      <!-- Infos commande -->
      <div class="ty-meta-grid">
        <div class="ty-meta-item">
          <span class="ty-meta-label"><?php esc_html_e( 'Numéro', 'woocommerce' ); ?></span>
          <span class="ty-meta-value">#<?php echo esc_html( $order->get_order_number() ); ?></span>
        </div>
        <div class="ty-meta-item">
          <span class="ty-meta-label"><?php esc_html_e( 'Date', 'woocommerce' ); ?></span>
          <span class="ty-meta-value"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></span>
        </div>
        <div class="ty-meta-item">
          <span class="ty-meta-label"><?php esc_html_e( 'Statut', 'woocommerce' ); ?></span>
          <span class="ty-meta-value ty-status ty-status--<?php echo esc_attr( $order->get_status() ); ?>">
            <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
          </span>
        </div>
        <div class="ty-meta-item">
          <span class="ty-meta-label"><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
          <span class="ty-meta-value ty-total"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></span>
        </div>
      </div>

      <!-- Tableau produits -->
      <div class="ty-section">
        <h2 class="ty-section-title"><?php esc_html_e( 'Détail de la commande', 'woocommerce' ); ?></h2>
        <table class="ty-table">
          <thead>
            <tr>
              <th><?php esc_html_e( 'Produit', 'woocommerce' ); ?></th>
              <th class="ty-table-right"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ( $order->get_items() as $item ) :
              $product = $item->get_product();
            ?>
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

      <!-- Moyen de paiement -->
      <div class="ty-section">
        <h2 class="ty-section-title"><?php esc_html_e( 'Paiement', 'woocommerce' ); ?></h2>
        <p class="ty-payment-method"><?php echo esc_html( $order->get_payment_method_title() ); ?></p>
        <p class="ty-payment-note">Le règlement s&rsquo;effectue en espèces au moment de la livraison.</p>
      </div>

    </div>

    <!-- COLONNE DROITE : adresse -->
    <div class="ty-aside">

      <div class="ty-section">
        <h2 class="ty-section-title"><?php esc_html_e( 'Adresse de livraison', 'woocommerce' ); ?></h2>
        <address class="ty-address">
          <?php echo wp_kses_post( $order->get_formatted_billing_address() ?: esc_html__( 'Non renseignée', 'woocommerce' ) ); ?>
          <?php if ( $phone = $order->get_billing_phone() ) : ?>
          <span class="ty-address-phone"><?php echo esc_html( $phone ); ?></span>
          <?php endif; ?>
        </address>
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
