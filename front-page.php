<?php
/**
 * Template : Page d'accueil
 */
function ads_c( $key, $default = '' ) {
    return wp_kses_post( get_theme_mod( $key, $default ) );
}
?>
<?php get_header(); ?>

<!-- ═══ HERO SCROLL ZONE ═══ -->
<div id="scroll-zone">
<div id="sticky">
  <canvas id="c"></canvas>

  <div id="ov">
    <div class="ov-tag" id="ot"><?php echo ads_c('ads_hero_tag', "Maison d'Encens · Dakar"); ?></div>
    <div class="ov-title" id="oT">
      <?php echo ads_c('ads_hero_title_l1', "L'Encens"); ?><br>
      <em><?php echo ads_c('ads_hero_title_l2', 'Vivant'); ?></em>
    </div>
    <div class="ov-line" id="ol"></div>
    <div class="ov-sub" id="os"><?php echo ads_c('ads_hero_sub', 'Oud · Arabesque · Musc · Andalous'); ?></div>
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
    <?php if ( get_theme_mod('ads_hero_cta_show', '1') ) : ?>
    <a href="<?php echo esc_url( get_theme_mod('ads_hero_cta_url', '#collection') ); ?>" class="cue-cta">
      <p><?php echo ads_c('ads_hero_cta_text', 'Découvrir'); ?></p>
      <div class="cue-tick"></div>
    </a>
    <?php endif; ?>
  </div>
</div>
</div>

<!-- ═══ REVEAL ═══ -->
<section id="reveal">
  <div class="reveal-left">
    <h2>L'Encens<br><em>Arabesque</em></h2>
    <p>Notre encens le plus emblématique. Façonné à partir de résines précieuses et de bois de santal sélectionnés à la source.</p>
    <div class="cta-row">
      <button class="btn-dark" onclick="window.location='<?php echo esc_url( wc_get_page_permalink('shop') ); ?>'">
        Acheter — 2 300 XOF
      </button>
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

<!-- ═══ COLLECTION WOOCOMMERCE ═══ -->
<?php if ( get_theme_mod('ads_collection_show', '1') && function_exists('WC') ) : ?>
<section id="collection">
  <div class="coll-header">
    <div>
      <div class="coll-tag"><?php echo ads_c('ads_collection_tag', 'Nos Encens'); ?></div>
      <div class="coll-title"><?php echo ads_c('ads_collection_title', 'La Collection'); ?></div>
    </div>
    <a href="<?php echo esc_url( get_theme_mod('ads_collection_cta_url', wc_get_page_permalink('shop')) ); ?>" class="all-link">
      <?php echo ads_c('ads_collection_cta_text', 'Tout voir'); ?>
    </a>
  </div>

  <?php
  $nb = (int) get_theme_mod('ads_collection_nb', 6);
  $args = array(
    'post_type'      => 'product',
    'posts_per_page' => $nb,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
  );
  $products = new WP_Query( $args );
  ?>

  <?php if ( $products->have_posts() ) : ?>
  <div class="products-grid">
    <?php while ( $products->have_posts() ) : $products->the_post();
      global $product;
      $product = wc_get_product( get_the_ID() );
      if ( ! $product ) continue;

      // Image
      $img_id  = $product->get_image_id();
      $img_url = $img_id
        ? wp_get_attachment_image_url( $img_id, 'ads-product-card' )
        : wc_placeholder_img_src();

      // Prix
      $price_html  = $product->get_price_html();
      $reg_price   = $product->get_regular_price();
      $sale_price  = $product->get_sale_price();

      // Stock
      $in_stock    = $product->is_in_stock();

      // Lien
      $link        = get_permalink();

      // Catégorie (famille olfactive)
      $terms = get_the_terms( get_the_ID(), 'product_cat' );
      $fam   = ( $terms && ! is_wp_error($terms) ) ? esc_html( $terms[0]->name ) : '';

      // Description courte
      $desc = $product->get_short_description();
      if ( ! $desc ) $desc = wp_trim_words( $product->get_description(), 15 );
    ?>
    <div class="product-card" onclick="window.location='<?php echo esc_url($link); ?>'">
      <div class="card-img-wrap">
        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy"/>
        <?php if ( $sale_price ) : ?>
          <div class="card-badge badge-promo">Promo</div>
        <?php elseif ( ! $in_stock ) : ?>
          <div class="card-badge badge-out">Épuisé</div>
        <?php endif; ?>
      </div>
      <div class="card-body">
        <?php if ( $fam ) : ?>
          <div class="card-fam"><?php echo $fam; ?></div>
        <?php endif; ?>
        <div class="card-name"><?php the_title(); ?></div>
        <?php if ( $desc ) : ?>
          <div class="card-desc"><?php echo wp_strip_all_tags($desc); ?></div>
        <?php endif; ?>
        <div class="card-foot">
          <div>
            <?php if ( $sale_price && $reg_price ) : ?>
              <span class="card-old"><?php echo wc_price($reg_price); ?></span>
            <?php endif; ?>
            <span class="card-price"><?php echo strip_tags($product->get_price_html()); ?></span>
          </div>
          <?php if ( $in_stock ) : ?>
            <button class="card-add" onclick="event.stopPropagation();window.location='<?php echo esc_url($link); ?>'">
              Ajouter
            </button>
          <?php else : ?>
            <span class="card-out-txt">Épuisé</span>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>
  <?php endif; ?>

</section>
<?php endif; ?>

<!-- ═══ PHILOSOPHY ═══ -->
<?php if ( get_theme_mod('ads_phi_show', '1') ) : ?>
<section id="philosophy">
  <div>
    <div class="phi-tag"><?php echo ads_c('ads_phi_tag', 'Notre Philosophie'); ?></div>
    <div class="phi-title"><?php echo ads_c('ads_phi_title', "L'encens comme<br><em>rituel quotidien</em>"); ?></div>
    <p class="phi-body"><?php echo ads_c('ads_phi_body', "Chaque bâtonnet est un pont entre le présent et l'ancestral."); ?></p>
  </div>
  <div class="phi-right">
    <?php
    $phi_defaults = array(
      1 => array( 'num' => '12',    'unit' => 'Fragrances', 'desc' => 'Une collection soigneusement éditée.' ),
      2 => array( 'num' => '5h',    'unit' => 'Maximum',    'desc' => 'La plus longue diffusion de notre gamme.' ),
      3 => array( 'num' => '100%',  'unit' => 'Naturel',    'desc' => 'Résines et bois sans additifs chimiques.' ),
      4 => array( 'num' => 'Dakar', 'unit' => 'Livraison',  'desc' => 'Livré directement chez vous.' ),
    );
    for ( $i = 1; $i <= 4; $i++ ) :
      $num  = ads_c("ads_phi_stat_{$i}_num",  $phi_defaults[$i]['num']);
      $unit = ads_c("ads_phi_stat_{$i}_unit", $phi_defaults[$i]['unit']);
      $desc = ads_c("ads_phi_stat_{$i}_desc", $phi_defaults[$i]['desc']);
    ?>
    <div class="phi-stat">
      <div class="phi-num"><?php echo $num; ?></div>
      <div class="phi-unit"><?php echo $unit; ?></div>
      <div class="phi-desc"><?php echo $desc; ?></div>
    </div>
    <?php endfor; ?>
  </div>
</section>
<?php endif; ?>

<!-- ═══ NEWSLETTER ═══ -->
<?php if ( get_theme_mod('ads_nl_show', '1') ) : ?>
<section id="nl">
  <div class="nl-tag"><?php echo ads_c('ads_nl_tag', 'Restez Informé'); ?></div>
  <div class="nl-title"><?php echo ads_c('ads_nl_title', 'La Lettre des Senteurs'); ?></div>
  <p class="nl-sub"><?php echo ads_c('ads_nl_sub', 'Nouvelles collections, éditions limitées et conseils olfactifs.'); ?></p>
  <form class="nl-form" onsubmit="return false;">
    <input type="email" placeholder="votre@email.com"/>
    <button><?php echo ads_c('ads_nl_btn', "S'abonner"); ?></button>
  </form>
</section>
<?php endif; ?>

<!-- ═══ FOOTER ═══ -->
<footer>
  <div>
    <div class="f-brand"><?php echo ads_c('ads_footer_brand', 'Alchimie des Senteurs'); ?></div>
    <div class="f-sub"><?php echo ads_c('ads_footer_sub', "Maison d'Encens · Dakar"); ?></div>
    <p class="f-about"><?php echo ads_c('ads_footer_about', "Depuis Dakar, nous apportons les fragrances les plus authentiques d'Orient dans vos foyers."); ?></p>
    <div class="f-soc">
      <a href="<?php echo esc_url(get_theme_mod('ads_footer_wa','https://wa.me/221776440125')); ?>">WhatsApp</a>
      <a href="<?php echo esc_url(get_theme_mod('ads_footer_insta','#')); ?>">Instagram</a>
      <a href="<?php echo esc_url(get_theme_mod('ads_footer_fb','#')); ?>">Facebook</a>
    </div>
  </div>
  <div class="f-col"><h5>Collection</h5>
    <?php wp_nav_menu(array('theme_location'=>'footer_1','container'=>false,'fallback_cb'=>false)); ?>
  </div>
  <div class="f-col"><h5>Boutique</h5>
    <?php wp_nav_menu(array('theme_location'=>'footer_2','container'=>false,'fallback_cb'=>false)); ?>
  </div>
  <div class="f-col"><h5>Aide</h5>
    <?php wp_nav_menu(array('theme_location'=>'footer_3','container'=>false,'fallback_cb'=>false)); ?>
  </div>
</footer>
<div class="f-bottom">
  <p><?php echo ads_c('ads_footer_copy', '© 2026 Alchimie des Senteurs · Dakar, Sénégal'); ?></p>
  <div class="pay-row">
    <?php foreach(explode(',', ads_c('ads_footer_pay','Orange Money,Wave,Carte')) as $pay) echo '<span class="pay">'.esc_html(trim($pay)).'</span>'; ?>
  </div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/canvas.js"></script>
<?php wp_footer(); ?>
</body>
</html>
