<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 */
get_header();
?>

<div class="contact-wrap">

  <!-- HERO -->
  <section class="contact-hero">
    <div class="contact-hero-inner">
      <div class="contact-tag">Nous Contacter</div>
      <h1 class="contact-title">Une question&nbsp;?<br><em>Parlons-en.</em></h1>
      <p class="contact-sub">Notre équipe est disponible du lundi au samedi,&nbsp;de&nbsp;9h&nbsp;à&nbsp;18h.</p>
    </div>
  </section>

  <!-- INFOS RAPIDES : 4 blocs en ligne -->
  <div class="contact-quick">
    <div class="cq-item">
      <div class="cq-label">Adresse</div>
      <div class="cq-value">Dakar, Sénégal</div>
    </div>
    <div class="cq-item">
      <div class="cq-label">WhatsApp</div>
      <a class="cq-value cq-link" href="https://wa.me/221776440125" target="_blank" rel="noopener">+221 77 644 01 25</a>
    </div>
    <div class="cq-item">
      <div class="cq-label">Email</div>
      <a class="cq-value cq-link" href="mailto:contact@alchimie-des-senteurs.sn">contact@alchimie-des-senteurs.sn</a>
    </div>
    <div class="cq-item">
      <div class="cq-label">Horaires</div>
      <div class="cq-value">Lun — Sam&nbsp;: 9h à 18h</div>
    </div>
  </div>

  <!-- FORMULAIRE -->
  <section class="contact-form-section">

    <div class="contact-form-intro">
      <div class="cf-intro-tag">Formulaire</div>
      <div class="cf-intro-title">Envoyez-nous<br><em>un message</em></div>
      <p class="cf-intro-sub">Nous vous répondons sous 24h. Pour les commandes urgentes, préférez WhatsApp.</p>

      <div class="ci-socials">
        <?php $wa = get_theme_mod('ads_footer_wa','https://wa.me/221776440125'); if ($wa) : ?>
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

    <div class="contact-form-col">
      <?php
      while ( have_posts() ) : the_post();
        $content = get_the_content();
      endwhile;

      if ( ! empty( trim( strip_tags( $content ) ) ) ) :
        echo '<div class="contact-form-shortcode">';
        the_content();
        echo '</div>';
      else :
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
          <label class="cf-label" for="cf-tel">Téléphone <span class="cf-opt">(optionnel)</span></label>
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
    </div>

  </section>

</div>

<?php get_footer(); ?>
