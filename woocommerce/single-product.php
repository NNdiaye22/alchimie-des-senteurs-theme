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

    $img_id      = $product->get_image_id();
    $img_url     = $img_id ? wp_get_attachment_image_url( $img_id, 'large' ) : wc_placeholder_img_src('large');
    $gallery_ids = $product->get_gallery_image_ids();

    $reg_price   = $product->get_regular_price();
    $sale_price  = $product->get_sale_price();
    $in_stock    = $product->is_in_stock();
    $stock_qty   = $product->get_stock_quantity();
    $backorders  = $product->backorders_allowed();
    $low_stock   = ( $in_stock && $stock_qty !== null && $stock_qty > 0 && $stock_qty <= 5 );

    $terms       = get_the_terms( get_the_ID(), 'product_cat' );
    $fam         = ( $terms && ! is_wp_error($terms) ) ? esc_html($terms[0]->name) : '';

    $short_desc  = $product->get_short_description();
    $long_desc   = $product->get_description();
    $attributes  = $product->get_attributes();

    $cat_id      = ( $terms && ! is_wp_error($terms) ) ? $terms[0]->term_id : 0;

    // --- Donnees variations ---
    $is_variable   = $product->is_type('variable');
    $variations_js = [];

    // Flags pour badge initial produit variable
    $any_on_sale    = false;
    $any_low_stock  = false;
    $any_backorder  = false;
    $all_out        = true;

    if ( $is_variable ) {
        foreach ( $product->get_available_variations() as $v ) {
            $vobj    = wc_get_product( $v['variation_id'] );
            $v_stock = $vobj ? $vobj->get_stock_quantity() : null;
            $v_back  = $vobj ? $vobj->backorders_allowed() : false;
            $v_low   = ( $v['is_in_stock'] && $v_stock !== null && $v_stock > 0 && $v_stock <= 5 );
            $has_sale = $v['display_regular_price'] > $v['display_price'];

            if ( $v['is_in_stock'] || $v_back ) $all_out = false;
            if ( $has_sale )  $any_on_sale   = true;
            if ( $v_low )     $any_low_stock = true;
            if ( $v_back && ! $v['is_in_stock'] ) $any_backorder = true;

            $clean = function( $amount ) {
                return html_entity_decode(
                    strip_tags( wc_price( $amount ) ),
                    ENT_QUOTES | ENT_HTML5,
                    'UTF-8'
                );
            };
            $variations_js[] = [
                'variation_id'  => $v['variation_id'],
                'attributes'    => $v['attributes'],
                'price'         => $clean( $v['display_price'] ),
                'regular_price' => $has_sale ? $clean( $v['display_regular_price'] ) : '',
                'is_on_sale'    => $has_sale,
                'is_in_stock'   => $v['is_in_stock'],
                'low_stock'     => $v_low,
                'stock_qty'     => $v_stock,
                'backorders'    => $v_back,
                'image'         => ! empty($v['image']['url']) ? $v['image']['url'] : '',
            ];
        }
    }

    // --- Prix initial ---
    if ( $is_variable ) {
        $prices     = $product->get_variation_prices( true );
        $min_price  = ! empty($prices['price'])         ? min( $prices['price'] )         : 0;
        $max_price  = ! empty($prices['price'])         ? max( $prices['price'] )         : 0;
        $min_reg    = ! empty($prices['regular_price']) ? min( $prices['regular_price'] ) : 0;

        $fmt = function( $amount ) {
            return html_entity_decode( strip_tags( wc_price( $amount ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
        };
        if ( $min_price === $max_price ) {
            $initial_price_html = ( $min_price < $min_reg )
                ? '<span class="sp-price-old">' . $fmt($min_reg) . '</span><span class="sp-price-current">' . $fmt($min_price) . '</span>'
                : '<span class="sp-price-current">' . $fmt($min_price) . '</span>';
        } else {
            $initial_price_html = '<span class="sp-price-current">' . $fmt($min_price) . '</span>'
                                . '<span class="sp-price-sep"> &ndash; </span>'
                                . '<span class="sp-price-current">' . $fmt($max_price) . '</span>';
        }
    } else {
        $fmt2 = function( $a ) { return html_entity_decode( strip_tags( wc_price($a) ), ENT_QUOTES|ENT_HTML5, 'UTF-8' ); };
        if ( $sale_price && $reg_price ) {
            $initial_price_html = '<span class="sp-price-old">'     . $fmt2($reg_price)  . '</span>'
                                . '<span class="sp-price-current">' . $fmt2($sale_price) . '</span>';
        } else {
            $initial_price_html = '<span class="sp-price-current">' . $fmt2($reg_price ?: $product->get_price()) . '</span>';
        }
    }

    // --- Badge initial ---
    if ( ! $is_variable ) {
        if ( ! $in_stock && $backorders )      $initial_badge_id = 'backorder';
        elseif ( ! $in_stock )                 $initial_badge_id = 'out';
        elseif ( $low_stock )                  $initial_badge_id = 'low';
        elseif ( $sale_price )                 $initial_badge_id = 'promo';
        else                                   $initial_badge_id = '';
    } else {
        if ( $all_out )                        $initial_badge_id = 'out';
        elseif ( $any_backorder )              $initial_badge_id = 'backorder';
        elseif ( $any_low_stock )              $initial_badge_id = 'low';
        elseif ( $any_on_sale )                $initial_badge_id = 'promo';
        else                                   $initial_badge_id = '';
    }
?>

<div class="sp-wrap">

  <!-- BREADCRUMB -->
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

  <!-- BLOC PRINCIPAL -->
  <div class="sp-main">

    <!-- Colonne image -->
    <div class="sp-gallery">
      <div class="sp-img-main">
        <img id="sp-main-img" src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />

        <?php
        $badges = [
            'promo'     => 'Promo',
            'out'       => '&Eacute;puis&eacute;',
            'low'       => ( $is_variable ? '' : ( $low_stock ? 'Plus que ' . (int)$stock_qty . ' en stock' : '' ) ),
            'backorder' => 'Bient&ocirc;t disponible',
        ];
        foreach ( $badges as $bid => $blabel ) :
            $visible = ( $initial_badge_id === $bid );
            $style   = $visible ? '' : ' style="display:none"';
        ?>
        <div class="sp-badge badge-<?php echo $bid; ?>" id="badge-<?php echo $bid; ?>"<?php echo $style; ?>>
          <?php echo $blabel; ?>
        </div>
        <?php endforeach; ?>

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
      <div class="sp-price-block" id="sp-price-block">
        <?php echo $initial_price_html; ?>
      </div>

      <!-- Description courte -->
      <?php if ( $short_desc ) : ?>
        <div class="sp-short-desc"><?php echo wp_kses_post($short_desc); ?></div>
      <?php endif; ?>

      <!-- Attributs / Specs (non-variation uniquement) -->
      <?php if ( ! empty($attributes) ) : ?>
      <div class="sp-specs">
        <?php foreach ( $attributes as $attr ) :
          if ( $is_variable && $attr->get_variation() ) continue;
          $label = wc_attribute_label( $attr->get_name() );
          $raw_options = $attr->get_options();
          if ( $attr->is_taxonomy() ) {
              $terms_attr = wc_get_product_terms( get_the_ID(), $attr->get_name(), array('fields'=>'names') );
              $values = array_map('esc_html', $terms_attr);
          } else {
              $values = array_map('esc_html', $raw_options);
          }
          $val_str = implode(' &middot; ', array_filter($values));
          if ( ! $val_str ) continue;
        ?>
        <div class="sp-spec-row">
          <div class="sp-spec-label"><?php echo esc_html($label); ?></div>
          <div class="sp-spec-value"><?php echo $val_str; ?></div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- FORMULAIRE VARIATION -->
      <?php if ( $is_variable && ! empty($variations_js) ) : ?>

        <?php
        $variation_attrs = [];
        foreach ( $attributes as $attr ) {
            if ( ! $attr->get_variation() ) continue;
            $attr_name = $attr->get_name();
            $label     = wc_attribute_label( $attr_name );
            if ( $attr->is_taxonomy() ) {
                $opts = wc_get_product_terms( get_the_ID(), $attr_name, ['fields'=>'all'] );
                $options = [];
                foreach ( $opts as $t ) $options[] = ['slug' => $t->slug, 'name' => $t->name];
            } else {
                $options = [];
                foreach ( $attr->get_options() as $o ) $options[] = ['slug' => sanitize_title($o), 'name' => $o];
            }
            $variation_attrs[] = [
                'key'     => 'attribute_' . sanitize_title($attr_name),
                'label'   => $label,
                'options' => $options,
            ];
        }
        ?>

        <form class="ads-variation-form" id="ads-variation-form"
              data-product-id="<?php echo esc_attr(get_the_ID()); ?>">

          <?php foreach ( $variation_attrs as $vattr ) : ?>
          <div class="ads-var-group" data-attr-key="<?php echo esc_attr($vattr['key']); ?>">
            <div class="ads-var-label">
              <?php echo esc_html($vattr['label']); ?>
              <span class="ads-var-chosen" id="chosen-<?php echo esc_attr($vattr['key']); ?>"></span>
            </div>
            <div class="ads-var-pills">
              <?php foreach ( $vattr['options'] as $opt ) : ?>
              <button type="button" class="ads-pill"
                      data-attr-key="<?php echo esc_attr($vattr['key']); ?>"
                      data-value="<?php echo esc_attr($opt['slug']); ?>">
                <?php echo esc_html($opt['name']); ?>
              </button>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endforeach; ?>

          <input type="hidden" name="variation_id" id="ads-variation-id" value="" />
          <input type="hidden" name="product_id"   value="<?php echo esc_attr(get_the_ID()); ?>" />
          <input type="hidden" name="quantity"     value="1" />
          <?php foreach ( $variation_attrs as $vattr ) : ?>
          <input type="hidden" name="<?php echo esc_attr($vattr['key']); ?>" id="hidden-<?php echo esc_attr($vattr['key']); ?>" value="" />
          <?php endforeach; ?>

          <div class="ads-var-unavailable" id="ads-var-unavailable" style="display:none;">
            Cette combinaison n&rsquo;est pas disponible.
          </div>

          <div class="sp-cart-wrap">
            <button type="submit" class="sp-add-btn" id="ads-add-btn" disabled>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
              Ajouter au panier
            </button>
          </div>

        </form>

        <script>
        (function(){
          var variations    = <?php echo wp_json_encode($variations_js); ?>;
          var anyOnSale     = <?php echo $any_on_sale   ? 'true' : 'false'; ?>;
          var anyLowStock   = <?php echo $any_low_stock ? 'true' : 'false'; ?>;
          var anyBackorder  = <?php echo $any_backorder ? 'true' : 'false'; ?>;
          var allOut        = <?php echo $all_out       ? 'true' : 'false'; ?>;

          var selectedAttrs = {};
          var form          = document.getElementById('ads-variation-form');
          var addBtn        = document.getElementById('ads-add-btn');
          var priceBlock    = document.getElementById('sp-price-block');
          var unavailMsg    = document.getElementById('ads-var-unavailable');
          var mainImg       = document.getElementById('sp-main-img');

          var badgePromo     = document.getElementById('badge-promo');
          var badgeOut       = document.getElementById('badge-out');
          var badgeLow       = document.getElementById('badge-low');
          var badgeBackorder = document.getElementById('badge-backorder');

          function hideAllBadges() {
            [badgePromo, badgeOut, badgeLow, badgeBackorder].forEach(function(b){
              if (b) b.style.display = 'none';
            });
          }
          function showBadge(el, text) {
            if (!el) return;
            if (text !== undefined) el.textContent = text;
            el.style.display = 'block';
          }
          function resetBadge() {
            hideAllBadges();
            if      (allOut)        showBadge(badgeOut);
            else if (anyBackorder)  showBadge(badgeBackorder);
            else if (anyLowStock)   showBadge(badgeLow, 'Stock limité');
            else if (anyOnSale)     showBadge(badgePromo);
          }

          // ── GRISAGE DES PILLS INCOMPATIBLES ──────────────────────────────
          // Pour chaque pill, vérifie si au moins une variation existe
          // avec la valeur de cette pill ET les autres attrs déjà sélectionnés.
          function updatePillsAvailability() {
            document.querySelectorAll('.ads-pill').forEach(function(pill) {
              var key = pill.dataset.attrKey;
              var val = pill.dataset.value;

              // Simule une sélection hypothétique : attrs courants + cette pill
              var testAttrs = Object.assign({}, selectedAttrs);
              testAttrs[key] = val;

              // Cherche une variation compatible
              var compatible = variations.some(function(v) {
                return Object.keys(v.attributes).every(function(k) {
                  return v.attributes[k] === '' || v.attributes[k] === testAttrs[k] || !testAttrs[k];
                });
              });

              if (compatible) {
                pill.classList.remove('unavailable');
                pill.disabled = false;
              } else {
                pill.classList.add('unavailable');
                pill.disabled = true;
              }
            });
          }

          document.querySelectorAll('.ads-pill').forEach(function(pill){
            pill.addEventListener('click', function(){
              var key = this.dataset.attrKey;
              var val = this.dataset.value;
              document.querySelectorAll('.ads-pill[data-attr-key="'+key+'"]').forEach(function(p){
                p.classList.remove('active');
              });
              this.classList.add('active');
              selectedAttrs[key] = val;
              document.getElementById('hidden-'+key).value = val;
              var chosen = document.getElementById('chosen-'+key);
              if (chosen) chosen.textContent = this.textContent.trim();
              updatePillsAvailability();
              matchVariation();
            });
          });

          // Initialiser le grisage au chargement
          updatePillsAvailability();

          function allAttrsSelected() {
            var ok = true;
            document.querySelectorAll('.ads-var-group').forEach(function(g){
              if (!selectedAttrs[g.dataset.attrKey]) ok = false;
            });
            return ok;
          }

          function matchVariation() {
            var matched = null;
            for (var i = 0; i < variations.length; i++) {
              var v = variations[i], ok = true;
              for (var k in v.attributes) {
                if (v.attributes[k] !== '' && v.attributes[k] !== selectedAttrs[k]) { ok = false; break; }
              }
              if (ok) { matched = v; break; }
            }

            unavailMsg.style.display = 'none';

            if (!matched) {
              resetBadge();
              if (allAttrsSelected()) unavailMsg.style.display = 'block';
              addBtn.disabled = true;
              document.getElementById('ads-variation-id').value = '';
              return;
            }

            hideAllBadges();
            if (!matched.is_in_stock && matched.backorders) {
              showBadge(badgeBackorder);
            } else if (!matched.is_in_stock) {
              showBadge(badgeOut);
            } else if (matched.low_stock && matched.stock_qty) {
              showBadge(badgeLow, 'Plus que ' + matched.stock_qty + ' en stock');
            } else if (matched.is_on_sale) {
              showBadge(badgePromo);
            }

            if (priceBlock) {
              var html = matched.is_on_sale && matched.regular_price
                ? '<span class="sp-price-old">' + matched.regular_price + '</span><span class="sp-price-current">' + matched.price + '</span>'
                : '<span class="sp-price-current">' + matched.price + '</span>';
              priceBlock.innerHTML = html;
            }

            if (matched.image && mainImg) mainImg.src = matched.image;

            document.getElementById('ads-variation-id').value = matched.variation_id;
            addBtn.disabled = !matched.is_in_stock && !matched.backorders;
            if (!matched.is_in_stock && !matched.backorders) {
              unavailMsg.textContent = 'Cette option est épuisée.';
              unavailMsg.style.display = 'block';
            }
          }

          form.addEventListener('submit', function(e){
            e.preventDefault();
            var varId  = document.getElementById('ads-variation-id').value;
            var prodId = <?php echo get_the_ID(); ?>;
            if (!varId) return;
            addBtn.disabled = true;
            addBtn.classList.add('loading');
            var cartUrl = '<?php echo esc_url( wc_get_cart_url() ); ?>';
            fetch('<?php echo esc_url( admin_url('admin-ajax.php') ); ?>', {
              method: 'POST',
              headers: {'Content-Type':'application/x-www-form-urlencoded'},
              body: 'action=ads_add_variation_to_cart&nonce='+encodeURIComponent('<?php echo wp_create_nonce("ads-nonce"); ?>')+'&product_id='+prodId+'&variation_id='+varId+'&quantity=1'
            })
            .then(function(r){ return r.json(); })
            .then(function(res){
              addBtn.classList.remove('loading');
              if (res.success) {
                addBtn.classList.add('added');
                addBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg> Ajouté !';
                var counter = document.querySelector('.cart-count');
                if (counter) counter.textContent = res.data.count;
                setTimeout(function(){
                  addBtn.disabled = false;
                  addBtn.classList.remove('added');
                  addBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg> Ajouter au panier';
                }, 2500);
              } else {
                addBtn.disabled = false;
                window.location.href = cartUrl;
              }
            })
            .catch(function(){
              addBtn.classList.remove('loading');
              addBtn.disabled = false;
              window.location.href = cartUrl;
            });
          });
        })();
        </script>

      <?php else : ?>
        <div class="sp-cart-wrap">
          <?php if ( $in_stock || $backorders ) :
            woocommerce_template_single_add_to_cart();
          else : ?>
            <div class="sp-out-msg">&Eacute;puis&eacute; &mdash; revenez bient&ocirc;t</div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <!-- Meta -->
      <div class="sp-meta">
        <?php if ( $fam && $terms ) : ?>
          <div class="sp-meta-row">
            <span class="sp-meta-label">Cat&eacute;gorie</span>
            <a href="<?php echo esc_url(get_term_link($terms[0])); ?>" class="sp-meta-val"><?php echo $fam; ?></a>
          </div>
        <?php endif; ?>
        <?php $sku = $product->get_sku(); if ($sku) : ?>
          <div class="sp-meta-row">
            <span class="sp-meta-label">R&eacute;f&eacute;rence</span>
            <span class="sp-meta-val"><?php echo esc_html($sku); ?></span>
          </div>
        <?php endif; ?>
      </div>

    </div><!-- .sp-info -->
  </div><!-- .sp-main -->

  <!-- DESCRIPTION LONGUE -->
  <?php if ( $long_desc ) : ?>
  <div class="sp-desc-section">
    <div class="sp-desc-title">Description</div>
    <div class="sp-desc-body"><?php echo wp_kses_post($long_desc); ?></div>
  </div>
  <?php endif; ?>

  <!-- PRODUITS SIMILAIRES -->
  <?php
  $related_args = [
    'post_type'      => 'product',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'post__not_in'   => [ get_the_ID() ],
    'orderby'        => 'rand',
  ];
  if ( $cat_id ) {
    $related_args['tax_query'] = [[
      'taxonomy' => 'product_cat',
      'field'    => 'term_id',
      'terms'    => $cat_id,
    ]];
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
