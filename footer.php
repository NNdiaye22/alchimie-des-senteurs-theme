<?php
/**
 * Footer global — affiché sur toutes les pages via get_footer()
 * Configurable : Apparence > Personnaliser > Alchimie des Senteurs > Footer
 * Menus : Apparence > Menus (footer_1, footer_2, footer_3)
 */
function ads_c_f( $key, $default = '' ) {
    return wp_kses_post( get_theme_mod( $key, $default ) );
}
?>

<footer>
  <div>
    <div class="f-brand"><?php echo ads_c_f('ads_footer_brand', 'Alchimie des Senteurs'); ?></div>
    <div class="f-sub"><?php echo ads_c_f('ads_footer_sub', "Maison d'Encens · Dakar"); ?></div>
    <p class="f-about"><?php echo ads_c_f('ads_footer_about', "Depuis Dakar, nous apportons les fragrances les plus authentiques d'Orient dans vos foyers."); ?></p>
    <div class="f-soc">
      <?php $wa = get_theme_mod('ads_footer_wa', 'https://wa.me/221776440125'); if ( $wa ) : ?>
        <a href="<?php echo esc_url($wa); ?>" target="_blank" rel="noopener">WhatsApp</a>
      <?php endif; ?>
      <?php $insta = get_theme_mod('ads_footer_insta', ''); if ( $insta && $insta !== '#' ) : ?>
        <a href="<?php echo esc_url($insta); ?>" target="_blank" rel="noopener">Instagram</a>
      <?php endif; ?>
      <?php $fb = get_theme_mod('ads_footer_fb', ''); if ( $fb && $fb !== '#' ) : ?>
        <a href="<?php echo esc_url($fb); ?>" target="_blank" rel="noopener">Facebook</a>
      <?php endif; ?>
    </div>
  </div>

  <div class="f-col">
    <h5>Collection</h5>
    <?php wp_nav_menu(array('theme_location' => 'footer_1', 'container' => false, 'fallback_cb' => false)); ?>
  </div>

  <div class="f-col">
    <h5>Boutique</h5>
    <?php wp_nav_menu(array('theme_location' => 'footer_2', 'container' => false, 'fallback_cb' => false)); ?>
  </div>

  <div class="f-col">
    <h5>Aide</h5>
    <?php wp_nav_menu(array('theme_location' => 'footer_3', 'container' => false, 'fallback_cb' => false)); ?>
  </div>
</footer>

<div class="f-bottom">
  <p><?php echo ads_c_f('ads_footer_copy', '© ' . date('Y') . ' Alchimie des Senteurs · Dakar, Sénégal'); ?></p>
  <div class="pay-row">
    <?php
    $methods = array_map('trim', explode(',', get_theme_mod('ads_footer_pay', 'Orange Money,Wave,Carte')));
    foreach ( $methods as $m ) if ( $m ) echo '<span class="pay">' . esc_html($m) . '</span>';
    ?>
  </div>
</div>

<div class="footer-signature">
  <p>Thème créé par <span class="signature-name">BUUR DIGITAL</span></p>
</div>

<?php wp_footer(); ?>
</body>
</html>
