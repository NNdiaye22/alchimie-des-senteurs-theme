<?php
/**
 * Détail d'une commande — Alchimie des Senteurs
 */
defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id );
if ( ! $order ) return;
?>

<div class="ty-section" style="margin-bottom:2rem;">
  <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="ty-back-link">
    &larr; <?php esc_html_e( 'Retour aux commandes', 'woocommerce' ); ?>
  </a>
</div>

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
</div>

<div class="ty-section">
  <h2 class="ty-section-title"><?php esc_html_e( 'Articles commandés', 'woocommerce' ); ?></h2>
  <table class="ty-table">
    <thead>
      <tr>
        <th><?php esc_html_e( 'Produit', 'woocommerce' ); ?></th>
        <th class="ty-table-right"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
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

<div class="ty-section">
  <h2 class="ty-section-title"><?php esc_html_e( 'Adresse de facturation', 'woocommerce' ); ?></h2>
  <address class="ty-address">
    <?php echo wp_kses_post( $order->get_formatted_billing_address() ?: esc_html__( 'Non renseignée.', 'woocommerce' ) ); ?>
    <?php if ( $phone = $order->get_billing_phone() ) : ?>
    <span class="ty-address-phone"><?php echo esc_html( $phone ); ?></span>
    <?php endif; ?>
  </address>
</div>
