/* ==============================================
   CART DRAWER — Alchimie des Senteurs
============================================== */
(function () {
  'use strict';

  /* ---- Injection du HTML dans le DOM ---- */
  function injectDrawer() {
    if (document.getElementById('cart-drawer')) return;

    var html = [
      '<div class="cart-drawer-overlay" id="cart-drawer-overlay"></div>',
      '<div class="cart-drawer" id="cart-drawer" role="dialog" aria-modal="true" aria-label="Panier">',
        '<div class="cart-drawer__header">',
          '<span class="cart-drawer__tag">Panier</span>',
          '<button class="cart-drawer__close" id="cart-drawer-close" aria-label="Fermer">',
            '<svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
          '</button>',
        '</div>',
        '<div class="cart-drawer__body" id="cart-drawer-body">',
          '<div class="cart-drawer__added" id="cart-drawer-added">',
            '<div class="cart-drawer__thumb-placeholder" id="cart-drawer-thumb-wrap"></div>',
            '<div class="cart-drawer__info">',
              '<div class="cart-drawer__confirm">',
                '<svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>',
                'Ajouté au panier',
              '</div>',
              '<div class="cart-drawer__product-name" id="cart-drawer-name"></div>',
              '<div class="cart-drawer__product-price" id="cart-drawer-price"></div>',
            '</div>',
          '</div>',
          '<div class="cart-drawer__summary">',
            '<span class="cart-drawer__summary-label">Total panier</span>',
            '<span class="cart-drawer__summary-total" id="cart-drawer-total"></span>',
          '</div>',
          '<p class="cart-drawer__summary-note">Livraison calculée à la commande</p>',
        '</div>',
        '<div class="cart-drawer__footer">',
          '<a href="" class="cart-drawer__btn-primary" id="cart-drawer-checkout">Finaliser la commande</a>',
          '<a href="" class="cart-drawer__btn-ghost" id="cart-drawer-continue">Continuer mes achats</a>',
        '</div>',
      '</div>'
    ].join('');

    var wrap = document.createElement('div');
    wrap.innerHTML = html;
    while (wrap.firstChild) document.body.appendChild(wrap.firstChild);

    /* URLs depuis adsData (wp_localize_script) */
    var checkoutUrl = (typeof adsData !== 'undefined' && adsData.cartUrl) ? adsData.cartUrl : '/panier';
    var shopUrl     = (typeof adsData !== 'undefined' && adsData.shopUrl) ? adsData.shopUrl : '/boutique';

    document.getElementById('cart-drawer-checkout').href = checkoutUrl;
    document.getElementById('cart-drawer-continue').href = shopUrl;

    /* Fermeture */
    document.getElementById('cart-drawer-close').addEventListener('click', closeDrawer);
    document.getElementById('cart-drawer-overlay').addEventListener('click', closeDrawer);
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeDrawer();
    });
  }

  /* ---- Ouvrir ---- */
  function openDrawer(productName, productPrice, productImg, cartTotal) {
    injectDrawer();

    /* Produit ajouté */
    var nameEl  = document.getElementById('cart-drawer-name');
    var priceEl = document.getElementById('cart-drawer-price');
    var thumbWrap = document.getElementById('cart-drawer-thumb-wrap');
    var totalEl = document.getElementById('cart-drawer-total');

    if (nameEl)  nameEl.textContent  = productName  || '';
    if (priceEl) priceEl.textContent = productPrice || '';
    if (totalEl) totalEl.textContent = cartTotal    || '';

    /* Image */
    if (thumbWrap) {
      thumbWrap.innerHTML = '';
      if (productImg) {
        var img = document.createElement('img');
        img.src = productImg;
        img.alt = productName || '';
        img.className = 'cart-drawer__thumb';
        img.width  = 72;
        img.height = 90;
        thumbWrap.appendChild(img);
      } else {
        thumbWrap.className = 'cart-drawer__thumb-placeholder';
      }
    }

    document.getElementById('cart-drawer').classList.add('is-open');
    document.getElementById('cart-drawer-overlay').classList.add('is-open');
    document.body.style.overflow = 'hidden';
  }

  /* ---- Fermer ---- */
  function closeDrawer() {
    var drawer  = document.getElementById('cart-drawer');
    var overlay = document.getElementById('cart-drawer-overlay');
    if (drawer)  drawer.classList.remove('is-open');
    if (overlay) overlay.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  /* ---- Écoute l'event WooCommerce AJAX add-to-cart ---- */
  jQuery(function ($) {

    $(document.body).on('added_to_cart', function (e, fragments, cartHash, button) {
      var productName  = '';
      var productPrice = '';
      var productImg   = '';
      var cartTotal    = '';

      /* Récupère les infos du bouton cliqué */
      if (button && button.length) {
        var $btn = $(button);
        var $card = $btn.closest('.product-card, .product, li.product, .entry-summary');

        productName = $btn.data('product_name')
          || $card.find('.product-card__name, .woocommerce-loop-product__title, h1.product_title').first().text().trim()
          || '';

        /* Image */
        var $img = $card.find('img').first();
        if ($img.length) productImg = $img.attr('src') || '';

        /* Prix */
        var $price = $card.find('.woocommerce-Price-amount, .price').first();
        if ($price.length) productPrice = $price.text().trim();
      }

      /* Total panier via fragments ou AJAX */
      if (fragments && fragments['.cart-contents-count']) {
        /* Utilise le total depuis le mini-cart si dispo */
      }

      /* Récupère le total via fetch AJAX WC */
      $.ajax({
        url: (typeof adsData !== 'undefined' ? adsData.ajaxUrl : '/wp-admin/admin-ajax.php'),
        type: 'GET',
        data: { action: 'ads_get_cart_total', nonce: (typeof adsData !== 'undefined' ? adsData.nonce : '') },
        success: function (res) {
          if (res && res.success) cartTotal = res.data.total;
          openDrawer(productName, productPrice, productImg, cartTotal);
        },
        error: function () {
          openDrawer(productName, productPrice, productImg, cartTotal);
        }
      });
    });

  });

  /* Expose pour usage externe si besoin */
  window.adsCartDrawer = { open: openDrawer, close: closeDrawer };

})();
