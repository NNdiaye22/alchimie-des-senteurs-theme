<?php
/**
 * Alchimie des Senteurs — functions.php
 */
defined( 'ABSPATH' ) || exit;

/* ── SUPPORT THÈME ──────────────────────────────── */
add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
    register_nav_menus( [ 'primary' => 'Navigation principale' ] );
} );

/* ── SCRIPTS & STYLES ───────────────────────────── */
add_action( 'wp_enqueue_scripts', function () {

    // Styles globaux
    wp_enqueue_style( 'ads-main', get_template_directory_uri() . '/assets/css/main.css', [], '1.0' );

    // Pages client (thankyou, account, orders)
    if ( is_wc_endpoint_url() || is_page( 'mon-compte' ) || is_checkout() ) {
        wp_enqueue_style( 'ads-thankyou', get_template_directory_uri() . '/assets/css/thankyou.css', [ 'ads-main' ], '1.0' );
    }

    // Page politique de confidentialité
    if ( is_page_template( 'page-privacy-policy.php' ) ) {
        wp_enqueue_style( 'ads-legal', get_template_directory_uri() . '/assets/css/legal.css', [ 'ads-main' ], '1.0' );
    }

    // Checkout & cart
    if ( is_checkout() || is_cart() ) {
        wp_enqueue_style( 'ads-checkout', get_template_directory_uri() . '/assets/css/checkout.css', [ 'ads-main' ], '1.0' );
    }

    // JS principal
    wp_enqueue_script( 'ads-main', get_template_directory_uri() . '/assets/js/main.js', [], '1.0', true );
} );

/* ── WOOCOMMERCE : FORCER PAIEMENT À LA LIVRAISON ── */
add_filter( 'woocommerce_available_payment_gateways', function ( $gateways ) {
    if ( isset( $gateways['cod'] ) ) {
        return [ 'cod' => $gateways['cod'] ];
    }
    return $gateways;
} );

// Valider le paiement à la livraison même sans adresse de livraison
add_filter( 'woocommerce_cod_process_payment_order_status', function ( $status ) {
    return 'processing';
} );

// Forcer COD valide pour toutes les zones de livraison
add_filter( 'woocommerce_payment_gateways', function ( $gateways ) {
    return $gateways;
} );

/* ── REMOVE WC STYLES NON NÉCESSAIRES ──────────────── */
add_filter( 'woocommerce_enqueue_styles', function ( $styles ) {
    // Garder uniquement les styles essentiels WC
    return $styles;
} );

/* ── MON COMPTE : PERSONNALISER LE MENU ─────────── */
add_filter( 'woocommerce_account_menu_items', function ( $items ) {
    $new_items = [
        'dashboard'       => 'Tableau de bord',
        'orders'          => 'Mes commandes',
        'edit-address'    => 'Mes adresses',
        'edit-account'    => 'Mes informations',
        'customer-logout' => 'Déconnexion',
    ];
    return $new_items;
} );

/* ── PAGE TITLE HELPERS ──────────────────────────── */
add_filter( 'woocommerce_page_title', function ( $title ) {
    return $title;
} );
