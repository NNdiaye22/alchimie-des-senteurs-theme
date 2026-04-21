<?php
/**
 * Historique des commandes — Alchimie des Senteurs
 */
defined( 'ABSPATH' ) || exit;

$customer_orders = wc_get_orders( apply_filters( 'woocommerce_my_account_my_orders_query', array(
    'customer' => get_current_user_id(),
    'page'     => isset( $current_page ) ? $current_page : 1,
    'paginate'  => true,
) ) );
$has_orders = 0 < $customer_orders->total;
?>

<?php if ( $has_orders ) : ?>

<table class="ty-table orders-table">
  <thead>
    <tr>
      <th><?php esc_html_e( 'Commande', 'woocommerce' ); ?></th>
      <th><?php esc_html_e( 'Date', 'woocommerce' ); ?></th>
      <th><?php esc_html_e( 'Statut', 'woocommerce' ); ?></th>
      <th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ( $customer_orders->orders as $customer_order ) :
      $order      = wc_get_order( $customer_order );
      $item_count = $order->get_item_count();
    ?>
    <tr>
      <td>
        <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="order-num">
          #<?php echo esc_html( $order->get_order_number() ); ?>
        </a>
      </td>
      <td class="order-date"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></td>
      <td>
        <span class="ty-status ty-status--<?php echo esc_attr( $order->get_status() ); ?>">
          <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
        </span>
      </td>
      <td class="order-total">
        <?php echo wp_kses_post( sprintf(
          _n( '%1$s pour %2$s article', '%1$s pour %2$s articles', $item_count, 'woocommerce' ),
          $order->get_formatted_order_total(),
          $item_count
        ) ); ?>
      </td>
      <td class="order-actions">
        <?php foreach ( wc_get_account_orders_actions( $order ) as $key => $action ) : ?>
        <a href="<?php echo esc_url( $action['url'] ); ?>" class="ty-btn-ghost btn-sm">
          <?php echo esc_html( $action['name'] ); ?>
        </a>
        <?php endforeach; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
<div class="ty-pagination">
  <?php if ( 1 < $current_page ) : ?>
  <a href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>" class="ty-btn-ghost btn-sm">&larr; Précédent</a>
  <?php endif; ?>
  <?php if ( $current_page < $customer_orders->max_num_pages ) : ?>
  <a href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>" class="ty-btn-ghost btn-sm">Suivant &rarr;</a>
  <?php endif; ?>
</div>
<?php endif; ?>

<?php else : ?>
<div class="ty-empty-state">
  <div class="ty-empty-icon">
    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
      <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
      <line x1="3" y1="6" x2="21" y2="6"/>
      <path d="M16 10a4 4 0 01-8 0"/>
    </svg>
  </div>
  <p class="ty-empty-title">Aucune commande pour le moment</p>
  <p class="ty-empty-sub">Explorez notre collection et passez votre première commande.</p>
  <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="ty-btn-primary">Découvrir la boutique</a>
</div>
<?php endif; ?>
