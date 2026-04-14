<?php
/**
 * Footer du theme.
 * Colonnes editables via Apparence > Widgets.
 * Informations marque et reseaux sociaux via Personnaliser.
 */
?>

<footer class="site-footer" role="contentinfo">
    <div class="footer-inner">

        <!-- Colonne 1 : Branding -->
        <div class="footer-brand">
            <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                <?php dynamic_sidebar( 'footer-1' ); ?>
            <?php else : ?>
                <div class="f-brand"><?php echo wp_kses_post( ads_option( 'ads_footer_brand', 'Alchimie des Senteurs' ) ); ?></div>
                <div class="f-sub"><?php echo wp_kses_post( ads_option( 'ads_footer_sub', 'Maison d&rsquo;Encens &middot; Dakar' ) ); ?></div>
                <p class="f-about"><?php echo wp_kses_post( ads_option( 'ads_footer_about', 'Depuis Dakar, nous apportons les fragrances les plus authentiques d&rsquo;Orient dans vos foyers.' ) ); ?></p>
                <div class="f-soc">
                    <?php $wa = ads_option( 'ads_footer_wa', 'https://wa.me/221776440125' ); if ( $wa ) : ?>
                        <a href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener">WhatsApp</a>
                    <?php endif; ?>
                    <?php $insta = ads_option( 'ads_footer_insta', '#' ); if ( $insta && $insta !== '#' ) : ?>
                        <a href="<?php echo esc_url( $insta ); ?>" target="_blank" rel="noopener">Instagram</a>
                    <?php endif; ?>
                    <?php $fb = ads_option( 'ads_footer_fb', '#' ); if ( $fb && $fb !== '#' ) : ?>
                        <a href="<?php echo esc_url( $fb ); ?>" target="_blank" rel="noopener">Facebook</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Colonne 2 -->
        <div class="footer-col">
            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                <?php dynamic_sidebar( 'footer-2' ); ?>
            <?php elseif ( has_nav_menu( 'footer_1' ) ) : ?>
                <h5 class="f-col-title"><?php esc_html_e( 'Collection', 'alchimie-des-senteurs' ); ?></h5>
                <?php wp_nav_menu( array(
                    'theme_location' => 'footer_1',
                    'container'      => false,
                    'fallback_cb'    => false,
                ) ); ?>
            <?php endif; ?>
        </div>

        <!-- Colonne 3 -->
        <div class="footer-col">
            <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                <?php dynamic_sidebar( 'footer-3' ); ?>
            <?php elseif ( has_nav_menu( 'footer_2' ) ) : ?>
                <h5 class="f-col-title"><?php esc_html_e( 'Boutique', 'alchimie-des-senteurs' ); ?></h5>
                <?php wp_nav_menu( array(
                    'theme_location' => 'footer_2',
                    'container'      => false,
                    'fallback_cb'    => false,
                ) ); ?>
            <?php endif; ?>
        </div>

        <!-- Colonne 4 -->
        <div class="footer-col">
            <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                <?php dynamic_sidebar( 'footer-4' ); ?>
            <?php elseif ( has_nav_menu( 'footer_3' ) ) : ?>
                <h5 class="f-col-title"><?php esc_html_e( 'Aide', 'alchimie-des-senteurs' ); ?></h5>
                <?php wp_nav_menu( array(
                    'theme_location' => 'footer_3',
                    'container'      => false,
                    'fallback_cb'    => false,
                ) ); ?>
            <?php endif; ?>
        </div>

    </div><!-- .footer-inner -->

    <div class="footer-bottom">
        <p><?php echo wp_kses_post( ads_option( 'ads_footer_copy', '&copy; 2026 Alchimie des Senteurs &middot; Dakar, S&eacute;n&eacute;gal' ) ); ?></p>
        <div class="pay-row">
            <?php
            $methods = ads_option( 'ads_footer_pay', 'Orange Money,Wave,Carte' );
            $methods = array_map( 'trim', explode( ',', $methods ) );
            foreach ( $methods as $m ) :
                if ( $m ) echo '<span class="pay">' . esc_html( $m ) . '</span>';
            endforeach;
            ?>
        </div>
    </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
