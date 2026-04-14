<?php
/**
 * Template Name: Front Page
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="pbar"></div>

<!-- NAV -->
<nav id="nav">
  <a href="<?php echo home_url('/'); ?>" class="logo">Alchimie des Senteurs</a>
  <ul class="nav-links">
    <li><a href="#collection">Collection</a></li>
    <li><a href="#philosophy">Philosophie</a></li>
    <li><a href="#nl">Contact</a></li>
  </ul>
  <button class="nav-cta">Découvrir</button>
</nav>

<!-- HERO SCROLL ZONE -->
<div id="scroll-zone">
<div id="sticky">
  <canvas id="c"></canvas>
  <div id="ov">
    <div class="ov-tag" id="ot">Maison d'Encens · Dakar</div>
    <div class="ov-title" id="oT">L'Encens<br><em>Vivant</em></div>
    <div class="ov-line" id="ol"></div>
    <div class="ov-sub" id="os">Oud · Arabesque · Musc · Andalous</div>
  </div>
  <div class="info-block" id="info-left">
    <div class="info-label">Combustion</div>
    <div class="info-value">2h à 5h</div>
    <div class="info-sub">Diffusion lente<br>et continue</div>
  </div>
  <div class="info-block" id="info-right">
    <div class="info-label">Matière première</div>
    <div class="info-value">Résine naturelle</div>
    <div class="info-sub">Bois précieux<br>sélectionné</div>
  </div>
  <div class="info-block" id="info-bottom">
    <div class="info-label">Notes olfactives</div>
    <div class="info-value">Oud · Bois de Santal · Ambre</div>
  </div>
  <div class="phase-copy" id="pc1">
    <div class="ph-tag">I — L'Allumage</div>
    <div class="ph-title">L'instant<br>du premier souffle</div>
    <div class="ph-body">La braise s'éveille. Un fil de fumée s'élève, portant avec lui des siècles de tradition olfactive orientale.</div>
  </div>
  <div class="phase-copy right" id="pc2">
    <div class="ph-tag">II — La Consumation</div>
    <div class="ph-title">Le temps<br>qui parfume</div>
    <div class="ph-body" style="margin-left:auto;">Au fil des heures, le bâtonnet révèle ses couches olfactives. Du cœur épicé aux notes boisées de fond.</div>
  </div>
  <div class="phase-copy" id="pc3">
    <div class="ph-tag">III — L'Empreinte</div>
    <div class="ph-title">Ce qui reste<br>après le silence</div>
    <div class="ph-body">La fumée s'est dissipée, mais le souvenir olfactif persiste. C'est la magie du bon encens.</div>
  </div>
  <div id="cue">
    <p>Découvrir</p>
    <div class="cue-tick"></div>
  </div>
</div>
</div>

<!-- SECTION REVEAL -->
<section id="reveal">
  <div class="reveal-left">
    <h2>L'Encens<br><em>Arabesque</em></h2>
    <p>Notre encens le plus emblématique. Façonné à partir de résines précieuses et de bois de santal sélectionnés à la source, il offre une expérience sensorielle d'une rare profondeur.</p>
    <div class="cta-row">
      <button class="btn-dark">Acheter — 2 300 XOF</button>
      <button class="btn-text">En savoir plus</button>
    </div>
  </div>
  <div class="reveal-right">
    <div class="spec-row"><div class="spec-label">Durée de combustion</div><div class="spec-value">2h30 continues</div></div>
    <div class="spec-row"><div class="spec-label">Contenu</div><div class="spec-value">10 bâtonnets</div></div>
    <div class="spec-row"><div class="spec-label">Famille olfactive</div><div class="spec-value">Oriental · Boisé · Épicé</div></div>
    <div class="spec-row"><div class="spec-label">Origine</div><div class="spec-value">Résines d'Orient</div></div>
    <div class="spec-row"><div class="spec-label">Livraison</div><div class="spec-value">Dakar & environs</div></div>
  </div>
</section>

<!-- COLLECTION -->
<section id="collection">
  <div class="coll-header">
    <div>
      <div class="coll-tag">Nos Encens</div>
      <div class="coll-title">La Collection</div>
    </div>
    <a href="#" class="all-link">Tout voir</a>
  </div>
  <div class="products-grid">
    <div class="product-card" onclick="window.open('https://alchimiedessenteurs.com/products/encens-arabesque-gm-2h-30','_blank')">
      <div class="card-img-wrap">
        <img src="https://cdn.shopify.com/s/files/1/0943/9366/3777/files/IMG-0682.jpg?v=1.750265925e+09" alt="Arabesque 2h30" loading="lazy"/>
        <div class="card-badge badge-promo">Promo</div>
        <div class="card-duration">2h30</div>
      </div>
      <div class="card-body">
        <div class="card-fam">Oriental · Boisé</div>
        <div class="card-name">Arabesque 2h30</div>
        <div class="card-desc">10 bâtonnets raffinés. Puissance aromatique intense. Notes chaudes et épicées.</div>
        <div class="card-foot">
          <div><span class="card-old">2 700 XOF</span><span class="card-price">2 300 XOF</span></div>
          <button class="card-add" onclick="event.stopPropagation()">Ajouter</button>
        </div>
      </div>
    </div>
    <div class="product-card" onclick="window.open('https://alchimiedessenteurs.com/products/boite-de-5-batonnets-d-encens-de-3h-avec-le-parfum-oud-original-pour-une-ambiance-chaleureuse-et-accueillante','_blank')">
      <div class="card-img-wrap">
        <img src="https://cdn.shopify.com/s/files/1/0943/9366/3777/files/IMG-0745.jpg?v=1.751997084e+09" alt="Oud Original 3h" loading="lazy"/>
        <div class="card-badge badge-promo">Promo</div>
        <div class="card-duration">3h</div>
      </div>
      <div class="card-body">
        <div class="card-fam">Oriental · Profond</div>
        <div class="card-name">Oud Original 3h</div>
        <div class="card-desc">5 bâtonnets. Le roi des fragrances orientales, profond et envoûtant.</div>
        <div class="card-foot">
          <div><span class="card-old">2 700 XOF</span><span class="card-price">2 500 XOF</span></div>
          <button class="card-add" onclick="event.stopPropagation()">Ajouter</button>
        </div>
      </div>
    </div>
    <div class="product-card" onclick="window.open('https://alchimiedessenteurs.com/products/boite-de-5-batonnets-d-encens-de-5h-arabesque','_blank')">
      <div class="card-img-wrap">
        <img src="https://cdn.shopify.com/s/files/1/0943/9366/3777/files/C6150834-B278-4E8F-AE4B-55869A96EA69.jpg?v=1.75433569e+09" alt="Arabesque 5h" loading="lazy"/>
        <div class="card-badge badge-promo">Promo</div>
        <div class="card-duration">5h</div>
      </div>
      <div class="card-body">
        <div class="card-fam">Floral · Boisé</div>
        <div class="card-name">Arabesque 5h</div>
        <div class="card-desc">5 bâtonnets longue durée. Senteur douce et agréable pour tous vos espaces.</div>
        <div class="card-foot">
          <div><span class="card-old">3 300 XOF</span><span class="card-price">3 000 XOF</span></div>
          <button class="card-add" onclick="event.stopPropagation()">Ajouter</button>
        </div>
      </div>
    </div>
    <div class="product-card" onclick="window.open('https://alchimiedessenteurs.com/products/boite-de-5-batonnets-d-encens-de-5h-chacun-parfum-oud-original','_blank')">
      <div class="card-img-wrap">
        <img src="https://cdn.shopify.com/s/files/1/0943/9366/3777/files/IMG-0794.jpg?v=1.753610672e+09" alt="Musc Original 5h" loading="lazy"/>
        <div class="card-badge badge-out">Épuisé</div>
        <div class="card-duration">5h</div>
      </div>
      <div class="card-body">
        <div class="card-fam">Musqué · Doux</div>
        <div class="card-name">Musc Original 5h</div>
        <div class="card-desc">5 bâtonnets. Notes orientales enveloppantes, musc doux et délicat.</div>
        <div class="card-foot">
          <div><span class="card-old">3 300 XOF</span><span class="card-price">3 000 XOF</span></div>
          <button class="card-add" onclick="event.stopPropagation()">Ajouter</button>
        </div>
      </div>
    </div>
    <div class="product-card" onclick="window.open('https://alchimiedessenteurs.com/products/boite-d-encens-de-10-batonnets-de-2h30-parfum-andalous','_blank')">
      <div class="card-img-wrap">
        <img src="https://cdn.shopify.com/s/files/1/0943/9366/3777/files/IMG-0828.jpg?v=1.753810389e+09" alt="Andalous 2h30" loading="lazy"/>
        <div class="card-badge badge-promo">Promo</div>
        <div class="card-duration">2h30</div>
      </div>
      <div class="card-body">
        <div class="card-fam">Oriental · Frais</div>
        <div class="card-name">Andalous 2h30</div>
        <div class="card-desc">10 bâtonnets Parfum Andalous. Subtil, doux, très agréable au quotidien.</div>
        <div class="card-foot">
          <div><span class="card-old">2 700 XOF</span><span class="card-price">2 300 XOF</span></div>
          <button class="card-add" onclick="event.stopPropagation()">Ajouter</button>
        </div>
      </div>
    </div>
    <div class="product-card" onclick="window.open('https://alchimiedessenteurs.com/products/boite-d-encens-arabesque-en-cone-10-pieces','_blank')">
      <div class="card-img-wrap">
        <img src="https://cdn.shopify.com/s/files/1/0943/9366/3777/files/IMG-0848.jpg?v=1.757525956e+09" alt="Arabesque Cône" loading="lazy"/>
        <div class="card-duration">Cône</div>
      </div>
      <div class="card-body">
        <div class="card-fam">Oriental · Vanillé</div>
        <div class="card-name">Arabesque Cône</div>
        <div class="card-desc">10 cônes. Mélange musc, vanille, rose turque et pêche. Diffusion concentrée.</div>
        <div class="card-foot">
          <div><span class="card-price">5 500 XOF</span></div>
          <button class="card-add" onclick="event.stopPropagation()">Ajouter</button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PHILOSOPHY -->
<section id="philosophy">
  <div>
    <div class="phi-tag">Notre Philosophie</div>
    <div class="phi-title">L'encens comme<br><em>rituel quotidien</em></div>
    <p class="phi-body">Chaque bâtonnet est un pont entre le présent et l'ancestral. Nous sélectionnons des matières premières d'une authenticité rare, pour que chaque moment d'allumage devienne un acte de présence.</p>
  </div>
  <div class="phi-right">
    <div class="phi-stat"><div class="phi-num">12</div><div class="phi-unit">Fragrances</div><div class="phi-desc">Une collection soigneusement éditée, chaque senteur ayant sa propre histoire.</div></div>
    <div class="phi-stat"><div class="phi-num">5h</div><div class="phi-unit">Maximum</div><div class="phi-desc">La plus longue diffusion de notre gamme, pour habiller durablement votre espace.</div></div>
    <div class="phi-stat"><div class="phi-num">100%</div><div class="phi-unit">Naturel</div><div class="phi-desc">Résines et bois sélectionnés sans additifs chimiques ni arômes artificiels.</div></div>
    <div class="phi-stat"><div class="phi-num">Dakar</div><div class="phi-unit">Livraison</div><div class="phi-desc">Commandez via WhatsApp ou notre boutique, livré directement chez vous.</div></div>
  </div>
</section>

<!-- NEWSLETTER -->
<section id="nl">
  <div class="nl-tag">Restez Informé</div>
  <div class="nl-title">La Lettre des Senteurs</div>
  <p class="nl-sub">Nouvelles collections, éditions limitées et conseils olfactifs directement dans votre boîte mail.</p>
  <form class="nl-form" onsubmit="return false;">
    <input type="email" placeholder="votre@email.com"/>
    <button>S'abonner</button>
  </form>
</section>

<!-- FOOTER -->
<footer>
  <div>
    <div class="f-brand">Alchimie des Senteurs</div>
    <div class="f-sub">Maison d'Encens · Dakar</div>
    <p class="f-about">Depuis Dakar, nous apportons les fragrances les plus authentiques d'Orient dans vos foyers. Sélection, qualité, livraison.</p>
    <div class="f-soc">
      <a href="https://wa.me/221776440125">WhatsApp</a>
      <a href="#">Instagram</a>
      <a href="#">Facebook</a>
    </div>
  </div>
  <div class="f-col">
    <h5>Collection</h5>
    <ul>
      <li><a href="#">Arabesque</a></li>
      <li><a href="#">Oud Original</a></li>
      <li><a href="#">Musc</a></li>
      <li><a href="#">Andalous</a></li>
      <li><a href="#">Cônes</a></li>
    </ul>
  </div>
  <div class="f-col">
    <h5>Boutique</h5>
    <ul>
      <li><a href="#">Nouveautés</a></li>
      <li><a href="#">Promotions</a></li>
      <li><a href="#">Packs cadeaux</a></li>
    </ul>
  </div>
  <div class="f-col">
    <h5>Aide</h5>
    <ul>
      <li><a href="https://wa.me/221776440125">WhatsApp</a></li>
      <li><a href="#">Livraison</a></li>
      <li><a href="#">Retours</a></li>
      <li><a href="#">CGV</a></li>
    </ul>
  </div>
</footer>
<div class="f-bottom">
  <p>© 2026 Alchimie des Senteurs · Dakar, Sénégal</p>
  <div class="pay-row">
    <span class="pay">Orange Money</span>
    <span class="pay">Wave</span>
    <span class="pay">Carte</span>
  </div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/canvas.js"></script>
<?php wp_footer(); ?>
</body>
</html>