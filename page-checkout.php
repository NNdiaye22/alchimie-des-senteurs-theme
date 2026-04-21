<?php
/**
 * Template Name: Validation de la commande
 * Template page Validation de la commande — Alchimie des Senteurs
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<div class="checkout-wrap">

  <!-- HERO -->
  <div class="checkout-hero">
    <div class="checkout-hero-inner">
      <div class="checkout-hero-tag">Commande</div>
      <h1 class="checkout-hero-title">Validation de<br><em>votre commande</em></h1>
    </div>
  </div>

  <!-- NOTICE LIVRAISON -->
  <div class="checkout-notice">
    <div class="checkout-notice-inner">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <p>Notre service client vous contactera par téléphone pour confirmer votre commande. <strong>Le coût de la livraison dépend du montant total de la commande et de votre adresse.</strong></p>
    </div>
  </div>

  <!-- FORMULAIRE WOOCOMMERCE -->
  <div class="checkout-layout">
    <?php echo do_shortcode( '[woocommerce_checkout]' ); ?>
  </div>

</div>

<?php get_footer(); ?>
