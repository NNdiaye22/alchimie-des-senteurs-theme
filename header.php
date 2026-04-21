<?php
/**
 * Header du theme.
 * Affiché sur toutes les pages.
 * Menu editable via Apparence > Menus > Menu Principal.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="pbar"></div>

<nav id="nav" class="site-nav" role="navigation" aria-label="<?php esc_attr_e( 'Navigation principale', 'alchimie-des-senteurs' ); ?>">

    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo">
        <?php ads_the_logo(); ?>
    </a>

    <?php if ( has_nav_menu( 'primary' ) ) : ?>
        <?php
        wp_nav_menu( array(
            'theme_location'  => 'primary',
            'menu_class'      => 'nav-links',
            'container'       => false,
            'depth'           => 2,
            'fallback_cb'     => false,
            'items_wrap'      => '<ul class="nav-links">%3$s</ul>',
        ) );
        ?>
    <?php endif; ?>

    <div class="nav-right">
        <?php if ( function_exists( 'WC' ) ) : ?>
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="nav-cart" aria-label="Panier">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 01-8 0"/>
                </svg>
                <span class="nav-cart-count"><?php echo function_exists( 'WC' ) ? WC()->cart->get_cart_contents_count() : '0'; ?></span>
            </a>
        <?php endif; ?>
        <button class="nav-burger" id="navBurger" aria-label="Menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>

</nav>

<div id="navMobile" class="nav-mobile" aria-hidden="true">
    <button class="nav-mobile-close" id="navMobileClose" aria-label="Fermer">&times;</button>
    <?php
    wp_nav_menu( array(
        'theme_location' => 'primary',
        'menu_class'     => 'nav-mobile-links',
        'container'      => false,
        'fallback_cb'    => false,
    ) );
    ?>
</div>
