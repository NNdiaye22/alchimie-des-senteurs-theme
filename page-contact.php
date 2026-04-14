<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * Page de contact — assigner via WP Admin > Pages > Attributs de page > Modele : Contact
 * Le formulaire peut etre remplace par un shortcode (CF7, WPForms, Fluent Forms...)
 */
get_header();
?>

<div class="contact-wrap">

  <!-- ═══ EN-TETE ═══ -->
  <div class="contact-hero">
    <div class="contact-hero-inner">
      <div class="contact-tag">Nous Contacter</div>
      <h1 class="contact-title">Une question ?<br><em>Parlons-en.</em></h1>
      <p class="contact-sub">Notre équipe est disponible du lundi au samedi, de 9h à 18h.</p>
    </div>
  </div>

  <!-- ═══ BLOC PRINCIPAL ═══ -->
  <div class="contact-main">

    <!-- Colonne infos -->
    <div class="contact-infos">

      <div class="ci-block">
        <div class="ci-label">Adresse</div>
        <div class="ci-value">Dakar, Sénégal</div>
      </div>

      <div class="ci-block">
        <div class="ci-label">WhatsApp</div>
        <a class="ci-value ci-link" href="https://wa.me/221776440125" target="_blank" rel="noopener">
          +221 77 644 01 25
        </a>
      </div>

      <div class="ci-block">
        <div class="ci-label">Email</div>
        <a class="ci-value ci-link" href="mailto:contact@alchimie-des-senteurs.sn">
          contact@alchimie-des-senteurs.sn
        </a>
      </div>

      <div class="ci-block">
        <div class="ci-label">Horaires</div>
        <div class="ci-value">Lun — Sam : 9h à 18h</div>
      </div>

      <div class="ci-block">
        <div class="ci-label">Réseaux</div>
        <div class="ci-socials">
          <?php $wa = get_theme_mod('ads_footer_wa','https://wa.me/221776440125'); ?>
          <?php if ($wa) : ?>
            <a href="<?php echo esc_url($wa); ?>" target="_blank" rel="noopener">WhatsApp</a>
          <?php endif; ?>
          <?php $insta = get_theme_mod('ads_footer_insta',''); if ($insta && $insta !== '#') : ?>
            <a href="<?php echo esc_url($insta); ?>" target="_blank" rel="noopener">Instagram</a>
          <?php endif; ?>
          <?php $fb = get_theme_mod('ads_footer_fb',''); if ($fb && $fb !== '#') : ?>
            <a href="<?php echo esc_url($fb); ?>" target="_blank" rel="noopener">Facebook</a>
          <?php endif; ?>
        </div>
      </div>

    </div><!-- .contact-infos -->

    <!-- Colonne formulaire -->
    <div class="contact-form-col">

      <?php
      /*
       * ZONE FORMULAIRE
       * -------------------------------------------------------
       * Si une extension de formulaire est installee (CF7, WPForms,
       * Fluent Forms, Gravity Forms...), collez son shortcode
       * dans le contenu de la page depuis WP Admin > Pages > Contact.
       *
       * Sinon, un formulaire HTML natif s'affiche par defaut ci-dessous.
       * -------------------------------------------------------
       */
      while ( have_posts() ) : the_post();
        $content = get_the_content();
      endwhile;

      if ( ! empty(trim(strip_tags($content))) ) :
        // L'editeur contient du contenu (shortcode CF7 etc.) -> on l'affiche
        echo '<div class="contact-form-shortcode">';
        the_content();
        echo '</div>';
      else :
        // Pas de contenu -> formulaire HTML natif de secours
      ?>
      <form class="contact-form" method="post" action="#" novalidate>
        <div class="cf-row cf-row-2">
          <div class="cf-field">
            <label class="cf-label" for="cf-nom">Nom</label>
            <input class="cf-input" type="text" id="cf-nom" name="nom" placeholder="Votre nom" required />
          </div>
          <div class="cf-field">
            <label class="cf-label" for="cf-prenom">Prénom</label>
            <input class="cf-input" type="text" id="cf-prenom" name="prenom" placeholder="Votre prénom" />
          </div>
        </div>
        <div class="cf-field">
          <label class="cf-label" for="cf-email">Email</label>
          <input class="cf-input" type="email" id="cf-email" name="email" placeholder="votre@email.com" required />
        </div>
        <div class="cf-field">
          <label class="cf-label" for="cf-tel">Téléphone (optionnel)</label>
          <input class="cf-input" type="tel" id="cf-tel" name="telephone" placeholder="+221 77 000 00 00" />
        </div>
        <div class="cf-field">
          <label class="cf-label" for="cf-sujet">Sujet</label>
          <select class="cf-input cf-select" id="cf-sujet" name="sujet">
            <option value="">Choisissez un sujet</option>
            <option value="commande">Suivi de commande</option>
            <option value="produit">Question sur un produit</option>
            <option value="livraison">Livraison</option>
            <option value="autre">Autre</option>
          </select>
        </div>
        <div class="cf-field">
          <label class="cf-label" for="cf-message">Message</label>
          <textarea class="cf-input cf-textarea" id="cf-message" name="message" rows="6" placeholder="Votre message..." required></textarea>
        </div>
        <button type="submit" class="cf-submit">Envoyer le message</button>
      </form>
      <?php endif; ?>

    </div><!-- .contact-form-col -->
  </div><!-- .contact-main -->

</div><!-- .contact-wrap -->

<?php get_footer(); ?>
