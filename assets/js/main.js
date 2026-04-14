// Smooth scroll sur ancres
document.querySelectorAll('a[href^="#"]').forEach(a=>{
  a.addEventListener('click',e=>{
    const t=document.querySelector(a.getAttribute('href'));
    if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth'});}
  });
});

// ─── UI WordPress / WooCommerce ───────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

  // ── Menu mobile : burger ──────────────────────────────────────────────────
  // header.php utilise #navBurger (bouton) et #navMobile (panneau)
  const burger    = document.getElementById('navBurger');
  const navMobile = document.getElementById('navMobile');
  const closeBtn  = document.getElementById('navMobileClose');

  function openMenu() {
    if (!navMobile) return;
    navMobile.classList.add('open');
    navMobile.setAttribute('aria-hidden', 'false');
    if (burger) burger.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden'; // empêche le scroll derrière
  }

  function closeMenu() {
    if (!navMobile) return;
    navMobile.classList.remove('open');
    navMobile.setAttribute('aria-hidden', 'true');
    if (burger) burger.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  if (burger)   burger.addEventListener('click', openMenu);
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);

  // Fermer en cliquant en dehors du panneau
  document.addEventListener('click', function (e) {
    if (
      navMobile &&
      navMobile.classList.contains('open') &&
      !navMobile.contains(e.target) &&
      burger && !burger.contains(e.target)
    ) {
      closeMenu();
    }
  });

  // Fermer avec la touche Echap
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeMenu();
  });

  // ── Compteur panier AJAX WooCommerce ─────────────────────────────────────
  document.body.addEventListener('added_to_cart', function () {
    if (typeof adsData === 'undefined') return;
    fetch(adsData.ajaxUrl + '?action=woocommerce_get_refreshed_fragments', {
      credentials: 'same-origin',
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data && typeof data.cart_count !== 'undefined') {
          document.querySelectorAll('.nav-cart-count').forEach(function (el) {
            el.textContent = data.cart_count;
          });
        }
      });
  });

});
