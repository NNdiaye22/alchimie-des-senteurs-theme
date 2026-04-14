<?php
/**
 * Template page produit unique — style Alchimie des Senteurs
 * Remplace le template WooCommerce par defaut
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) :
    the_post();
    global $product;
    $product = wc_get_product( get_the_ID() );
    if ( ! $product ) continue;

    // --- Donnees produit ---
    $img_id      = $product->get_image_id();
    $img_url     = $img_id ? wp_get_attachment_image_url( $img_id, 'large' ) : wc_placeholder_img_src('large');
    $gallery_ids = $product->get_gallery_image_ids();

    $reg_price   = $product->get_regular_price();
    $sale_price  = $product->get_sale_price();
    $in_stock    = $product->is_in_stock();

    $terms       = get_the_terms( get_the_ID(), 'product_cat' );
    $fam         = ( $terms && ! is_wp_error($terms) ) ? esc_html($terms[0]->name) : '';

    $short_desc  = $product->get_short_description();
    $long_desc   = $product->get_description();

    // Attributs (pour specs)
    $attributes  = $product->get_attributes();

    // Produits de la meme categorie (upsells visuels)
    $cat_id      = ( $terms && ! is_wp_error($terms) ) ? $terms[0]->term_id : 0;
?>

<div class="sp-wrap">

  <!-- ═══ BREADCRUMB ═══ -->
  <nav class="sp-breadcrumb">
    <a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
    <span>&rsaquo;</span>
    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Boutique</a>
    <?php if ( $fam && $terms ) : ?>
      <span>&rsaquo;</span>
      <a href="<?php echo esc_url(get_term_link($terms[0])); ?>"><?php echo $fam; ?></a>
    <?php endif; ?>
    <span>&rsaquo;</span>
    <span class="sp-bc-current"><?php the_title(); ?></span>
  </nav>

  <!-- ═══ BLOC PRINCIPAL ═══ -->
  <div class="sp-main">

    <!-- Colonne image -->
    <div class="sp-gallery">
      <div class="sp-img-main">
        <img id="sp-main-img" src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
        <?php if ( $sale_price ) : ?>
          <div class="sp-badge badge-promo">Promo</div>
        <?php elseif ( ! $in_stock ) : ?>
          <div class="sp-badge badge-out">Épuisé</div>
        <?php endif; ?>
      </div>

      <?php if ( ! empty($gallery_ids) ) : ?>
      <div class="sp-thumbs">
        <button class="sp-thumb active" data-img="<?php echo esc_url($img_url); ?>">
          <img src="<?php echo esc_url(wp_get_attachment_image_url($img_id,'thumbnail')); ?>" alt="" />
        </button>
        <?php foreach ( $gallery_ids as $gid ) :
          $g_full  = wp_get_attachment_image_url($gid,'large');
          $g_thumb = wp_get_attachment_image_url($gid,'thumbnail');
        ?>
        <button class="sp-thumb" data-img="<?php echo esc_url($g_full); ?>">
          <img src="<?php echo esc_url($g_thumb); ?>" alt="" />
        </button>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>

    <!-- Colonne infos -->
    <div class="sp-info">

      <?php if ( $fam ) : ?>
        <div class="sp-fam"><?php echo $fam; ?></div>
      <?php endif; ?>

      <h1 class="sp-title"><?php the_title(); ?></h1>

      <!-- Prix -->
      <div class="sp-price-block">
        <?php if ( $sale_price && $reg_price ) : ?>
          <span class="sp-price-old"><?php echo wc_price($reg_price); ?></span>
        <?php endif; ?>
        <span class="sp-price"><?php echo strip_tags($product->get_price_html()); ?></span>
      </div>

      <!-- Description courte -->
      <?php if ( $short_desc ) : ?>
        <div class="sp-short-desc"><?php echo wp_kses_post($short_desc); ?></div>
      <?php endif; ?>

      <!-- Attributs / Specs -->
      <?php if ( ! empty($attributes) ) : ?>
      <div class="sp-specs">
        <?php foreach ( $attributes as $attr ) :
          $label = wc_attribute_label( $attr->get_name() );
          $values = array_map('esc_html', $attr->get_terms() ? wp_list_pluck($attr->get_terms(), 'name') : explode(',', $attr->get_options()[0] ?? ''));
          $val_str = implode(' · ', array_filter($values));
          if ( ! $val_str ) continue;
        ?>
        <div class="sp-spec-row">
          <div class="sp-spec-label"><?php echo esc_html($label); ?></div>
          <div class="sp-spec-value"><?php echo $val_str; ?></div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- Bouton panier -->
      <div class="sp-cart-wrap">
        <?php if ( $in_stock ) : ?>
          <?php
          // Formulaire add-to-cart WooCommerce natif (gere variable, simple, etc.)
          woocommerce_template_single_add_to_cart();
          ?>
        <?php else : ?>
          <div class="sp-out-msg">Épuisé — revenez bientôt</div>
        <?php endif; ?>
      </div>

      <!-- Meta -->
      <div class="sp-meta">
        <?php if ( $fam && $terms ) : ?>
          <div class="sp-meta-row">
            <span class="sp-meta-label">Catégorie</span>
            <a href="<?php echo esc_url(get_term_link($terms[0])); ?>" class="sp-meta-val"><?php echo $fam; ?></a>
          </div>
        <?php endif; ?>
        <?php $sku = $product->get_sku(); if ($sku) : ?>
          <div class="sp-meta-row">
            <span class="sp-meta-label">Référence</span>
            <span class="sp-meta-val"><?php echo esc_html($sku); ?></span>
          </div>
        <?php endif; ?>
      </div>

    </div><!-- .sp-info -->
  </div><!-- .sp-main -->

  <!-- ═══ DESCRIPTION LONGUE ═══ -->
  <?php if ( $long_desc ) : ?>
  <div class="sp-desc-section">
    <div class="sp-desc-title">Description</div>
    <div class="sp-desc-body"><?php echo wp_kses_post($long_desc); ?></div>
  </div>
  <?php endif; ?>

  <!-- ═══ PRODUITS SIMILAIRES ═══ -->
  <?php
  $related_args = array(
    'post_type'      => 'product',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'post__not_in'   => array(get_the_ID()),
    'orderby'        => 'rand',
  );
  if ( $cat_id ) {
    $related_args['tax_query'] = array(array(
      'taxonomy' => 'product_cat',
      'field'    => 'term_id',
      'terms'    => $cat_id,
    ));
  }
  $related = new WP_Query($related_args);
  ?>
  <?php if ( $related->have_posts() ) : ?>
  <div class="sp-related">
    <div class="sp-related-title">Vous aimerez aussi</div>
    <div class="products-grid">
      <?php while ( $related->have_posts() ) : $related->the_post();
        global $product;
        $product = wc_get_product(get_the_ID());
        if (!$product) continue;
        $ri_url = $product->get_image_id() ? wp_get_attachment_image_url($product->get_image_id(),'ads-product-card') : wc_placeholder_img_src();
        $r_link = get_permalink();
        $r_terms = get_the_terms(get_the_ID(),'product_cat');
        $r_fam = ($r_terms && !is_wp_error($r_terms)) ? esc_html($r_terms[0]->name) : '';
      ?>
      <div class="product-card" onclick="window.location='<?php echo esc_url($r_link); ?>'">
        <div class="card-img-wrap">
          <img src="<?php echo esc_url($ri_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy"/>
        </div>
        <div class="card-body">
          <?php if ($r_fam) echo '<div class="card-fam">'.$r_fam.'</div>'; ?>
          <div class="card-name"><?php the_title(); ?></div>
          <div class="card-foot">
            <span class="card-price"><?php echo strip_tags($product->get_price_html()); ?></span>
            <button class="card-add" onclick="event.stopPropagation();window.location='<?php echo esc_url($r_link); ?>'">Voir</button>
          </div>
        </div>
      </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
  <?php endif; ?>

</div><!-- .sp-wrap -->

<?php endwhile; ?>

<script>
(function(){
  var mainImg = document.getElementById('sp-main-img');
  if (!mainImg) return;
  document.querySelectorAll('.sp-thumb').forEach(function(btn){
    btn.addEventListener('click', function(){
      mainImg.src = this.dataset.img;
      document.querySelectorAll('.sp-thumb').forEach(function(b){ b.classList.remove('active'); });
      this.classList.add('active');
    });
  });
})();
</script>

<?php get_footer(); ?>
