<?php
/**
 * Mon compte — Alchimie des Senteurs
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<div class="myaccount-wrap">

  <div class="myaccount-hero">
    <p class="myaccount-hero-tag">Espace client</p>
    <h1 class="myaccount-hero-title">Mon <em>compte</em></h1>
  </div>

  <div class="myaccount-layout">

    <nav class="myaccount-nav">
      <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"
           class="myaccount-nav-item<?php echo wc_get_account_menu_item_classes( $endpoint ) ? ' active' : ''; ?>">
          <?php echo esc_html( $label ); ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="myaccount-content">
      <?php do_action( 'woocommerce_account_content' ); ?>
    </div>

  </div>
</div>
<?php get_footer(); ?>
