// Smooth scroll sur ancres
document.querySelectorAll('a[href^="#"]').forEach(a=>{
  a.addEventListener('click',e=>{
    const t=document.querySelector(a.getAttribute('href'));
    if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth'});}
  });
});

// ─── UI WordPress / WooCommerce ───────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

  // ── Menu mobile : volet depuis la droite ──────────────────────────────────
  const burger    = document.getElementById('navBurger');
  const navMobile = document.getElementById('navMobile');
  const closeBtn  = document.getElementById('navMobileClose');

  const overlay = document.createElement('div');
  overlay.className = 'nav-overlay';
  document.body.appendChild(overlay);

  function openMenu() {
    if (!navMobile) return;
    navMobile.classList.add('open');
    overlay.classList.add('open');
    navMobile.setAttribute('aria-hidden', 'false');
    if (burger) burger.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    if (!navMobile) return;
    navMobile.classList.remove('open');
    overlay.classList.remove('open');
    navMobile.setAttribute('aria-hidden', 'true');
    if (burger) burger.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  if (burger) burger.addEventListener('click', openMenu);
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);
  overlay.addEventListener('click', closeMenu);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeMenu();
  });

  // ── Accordéon sous-menus mobile ───────────────────────────────────────────
  if (navMobile) {
    const parents = navMobile.querySelectorAll('.menu-item-has-children');

    parents.forEach(function (item) {
      const trigger = item.querySelector(':scope > a');
      if (!trigger) return;

      trigger.addEventListener('click', function (e) {
        if (window.innerWidth > 768) return;
        e.preventDefault();

        const isOpen = item.classList.contains('is-open');

        parents.forEach(function (other) {
          if (other !== item) other.classList.remove('is-open');
        });

        item.classList.toggle('is-open', !isOpen);
      });
    });
  }

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
