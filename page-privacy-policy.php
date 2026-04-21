<?php
/**
 * Template Name: Politique de confidentialité
 * Alchimie des Senteurs
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<div class="legal-wrap">

  <div class="legal-hero">
    <p class="ty-tag">Transparence</p>
    <h1 class="ty-title">Politique de<br><em>confidentialité</em></h1>
  </div>

  <div class="legal-body">

    <aside class="legal-toc">
      <p class="legal-toc-label">Sommaire</p>
      <nav>
        <a href="#collecte">1. Données collectées</a>
        <a href="#utilisation">2. Utilisation</a>
        <a href="#conservation">3. Conservation</a>
        <a href="#droits">4. Vos droits</a>
        <a href="#cookies">5. Cookies</a>
        <a href="#tiers">6. Tiers</a>
        <a href="#contact">7. Contact</a>
      </nav>
    </aside>

    <article class="legal-content">

      <p class="legal-intro">
        La présente politique de confidentialité décrit la manière dont
        <strong>Alchimie des Senteurs</strong> collecte, utilise et protège vos données
        personnelles conformément au Règlement Général sur la Protection des Données
        (RGPD — Règlement UE 2016/679) et à la législation algérienne en vigueur.
        En naviguant sur ce site et en passant commande, vous acceptez les conditions
        décrites ci-dessous.
      </p>

      <section id="collecte">
        <h2>1. Données collectées</h2>
        <p>Lors de votre passage en commande ou de votre inscription, nous collectons :</p>
        <ul>
          <li>Prénom et nom</li>
          <li>Adresse e-mail</li>
          <li>Numéro de téléphone</li>
          <li>Adresse postale de livraison</li>
          <li>Historique des commandes</li>
        </ul>
        <p>
          Les données de navigation (adresse IP, pages visitées, durée de session)
          peuvent être collectées automatiquement via les journaux du serveur.
        </p>
      </section>

      <section id="utilisation">
        <h2>2. Utilisation des données</h2>
        <p>Vos données sont utilisées exclusivement pour :</p>
        <ul>
          <li>Traiter et livrer vos commandes</li>
          <li>Vous contacter afin de confirmer la livraison</li>
          <li>Vous envoyer des informations sur votre commande</li>
          <li>Améliorer notre service client</li>
          <li>Envoyer notre lettre d'information (avec votre consentement)</li>
        </ul>
        <p>
          Nous ne vendons, n'échangeons ni ne louons vos informations personnelles
          à des tiers à des fins commerciales.
        </p>
      </section>

      <section id="conservation">
        <h2>3. Durée de conservation</h2>
        <p>
          Vos données sont conservées pendant la durée nécessaire à l'exécution
          de votre commande et, au-delà, pour une période maximum de
          <strong>3 ans</strong> à compter du dernier achat afin de respecter
          nos obligations légales et comptables.
        </p>
        <p>
          Les données liées à la newsletter sont supprimées dès votre désinscription.
        </p>
      </section>

      <section id="droits">
        <h2>4. Vos droits</h2>
        <p>Conformément au RGPD, vous disposez des droits suivants :</p>
        <ul>
          <li><strong>Accès</strong> — obtenir une copie de vos données personnelles</li>
          <li><strong>Rectification</strong> — corriger des informations inexactes</li>
          <li><strong>Effacement</strong> — demander la suppression de vos données</li>
          <li><strong>Opposition</strong> — vous opposer au traitement de vos données</li>
          <li><strong>Portabilité</strong> — recevoir vos données dans un format structuré</li>
          <li><strong>Limitation</strong> — restreindre temporairement le traitement</li>
        </ul>
        <p>
          Pour exercer ces droits, contactez-nous à l'adresse indiquée
          <a href="#contact">en section 7</a>.
        </p>
      </section>

      <section id="cookies">
        <h2>5. Cookies</h2>
        <p>
          Ce site utilise des cookies strictement nécessaires au fonctionnement
          de la boutique (session panier, authentification). Aucun cookie publicitaire
          tiers n'est déposé sans votre consentement explicite.
        </p>
        <p>
          Vous pouvez configurer votre navigateur pour refuser les cookies, mais
          certaines fonctionnalités du site pourraient ne plus être disponibles.
        </p>
      </section>

      <section id="tiers">
        <h2>6. Partage avec des tiers</h2>
        <p>
          Vos données ne sont transmises qu'aux prestataires indispensables
          à la réalisation de votre commande (transporteur, hébergeur). Ces
          prestataires sont soumis à des obligations contractuelles de confidentialité.
        </p>
      </section>

      <section id="contact">
        <h2>7. Nous contacter</h2>
        <p>Pour toute question relative à vos données personnelles :</p>
        <div class="legal-contact-block">
          <strong>Alchimie des Senteurs</strong><br>
          <?php echo wp_kses_post( get_option( 'woocommerce_store_address', 'Algérie' ) ); ?><br>
          <a href="mailto:<?php echo esc_attr( get_option( 'admin_email' ) ); ?>">
            <?php echo esc_html( get_option( 'admin_email' ) ); ?>
          </a>
        </div>
        <p class="legal-update">
          Dernière mise à jour&nbsp;: <?php echo esc_html( wp_date( 'd F Y', strtotime( get_post_modified_time( 'U', false, get_the_ID() ) ) ) ); ?>
        </p>
      </section>

    </article>
  </div>
</div>

<?php get_footer(); ?>
