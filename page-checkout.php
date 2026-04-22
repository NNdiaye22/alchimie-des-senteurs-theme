<?php
/**
 * Template Name: Validation de la commande
 * Template page Validation de la commande — Alchimie des Senteurs
 */
defined( 'ABSPATH' ) || exit;

// Forcer WooCommerce à considérer cette page comme le checkout
add_filter( 'woocommerce_is_checkout', '__return_true' );

get_header();
?>

<div class="checkout-wrap">

  <!-- HERO (style contact-hero) -->
  <section class="checkout-hero">
    <div class="checkout-hero-inner">
      <div class="checkout-hero-tag">Commande</div>
      <h1 class="checkout-hero-title">
        Validation de<br>
        <em>votre commande</em>
      </h1>
      <p class="checkout-hero-sub">Renseignez vos informations ci-dessous. Notre équipe vous contactera pour confirmer la livraison.</p>
    </div>
  </section>

  <!-- BANDE INFOS RAPIDES (style contact-quick) -->
  <div class="checkout-quick">
    <div class="cko-item">
      <div class="cko-label">Paiement</div>
      <div class="cko-value">À la livraison</div>
    </div>
    <div class="cko-item">
      <div class="cko-label">Livraison</div>
      <div class="cko-value">Dakar &amp; environs</div>
    </div>
    <div class="cko-item">
      <div class="cko-label">Confirmation</div>
      <div class="cko-value">Par téléphone</div>
    </div>
    <div class="cko-item">
      <div class="cko-label">Besoin d'aide ?</div>
      <a class="cko-value cko-link"
         href="<?php echo esc_url( get_theme_mod('ads_footer_wa','https://wa.me/221776440125') ); ?>"
         target="_blank" rel="noopener">WhatsApp</a>
    </div>
  </div>

  <!-- FORMULAIRE WOOCOMMERCE -->
  <div class="checkout-layout">
    <?php echo do_shortcode( '[woocommerce_checkout]' ); ?>
  </div>

</div>

<?php get_footer(); ?>
