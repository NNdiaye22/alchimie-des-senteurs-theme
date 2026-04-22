<?php
/**
 * Template : Page Mon Compte — Alchimie des Senteurs
 * Chargé via template_include dans inc/woocommerce.php
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

    <?php if ( is_user_logged_in() ) : ?>
    <nav class="myaccount-nav" aria-label="Navigation compte">
      <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
        $classes   = wc_get_account_menu_item_classes( $endpoint );
        $is_active = strpos( $classes, 'is-active' ) !== false;
      ?>
      <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"
         class="myaccount-nav-item<?php echo $is_active ? ' active' : ''; ?>">
        <?php echo esc_html( $label ); ?>
      </a>
      <?php endforeach; ?>
    </nav>
    <?php endif; ?>

    <div class="myaccount-content">
      <?php
        // Rendu WooCommerce complet (login form ou dashboard)
        echo do_shortcode( '[woocommerce_my_account]' );
      ?>
    </div>

  </div>
</div>

<?php get_footer(); ?>
