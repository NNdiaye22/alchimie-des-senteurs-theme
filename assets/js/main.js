// Smooth nav links
document.querySelectorAll('a[href^="#"]').forEach(a=>{
  a.addEventListener('click',e=>{
    const t=document.querySelector(a.getAttribute('href'));
    if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth'});}
  });
});

// ─── WordPress / WooCommerce UI ────────────────────────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

  // Mobile menu toggle
  const menuToggle = document.querySelector('.menu-toggle');
  const navMenu    = document.querySelector('.nav-menu');
  if (menuToggle && navMenu) {
    menuToggle.addEventListener('click', function () {
      const isOpen = navMenu.classList.toggle('open');
      menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  // Mettre à jour le compteur panier après ajout AJAX WooCommerce
  document.body.addEventListener('added_to_cart', function () {
    if (typeof adsData === 'undefined') return;
    fetch(adsData.ajaxUrl + '?action=woocommerce_get_refreshed_fragments', {
      credentials: 'same-origin',
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data && typeof data.cart_count !== 'undefined') {
          document.querySelectorAll('.cart-count').forEach(function (el) {
            el.textContent = data.cart_count;
          });
        }
      });
  });

  // Fermer le menu mobile en cliquant ailleurs
  document.addEventListener('click', function (e) {
    if (navMenu && navMenu.classList.contains('open')) {
      if (!navMenu.contains(e.target) && !menuToggle.contains(e.target)) {
        navMenu.classList.remove('open');
        if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
      }
    }
  });

});
