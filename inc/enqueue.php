<?php
/**
 * Chargement des assets CSS et JS du theme.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function ads_enqueue_assets() {

    // CSS principal
    wp_enqueue_style(
        'ads-main',
        ADS_URI . '/assets/css/main.css',
        array(),
        ADS_VERSION
    );

    // CSS WooCommerce (boutique, panier, checkout, compte)
    if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
        wp_enqueue_style(
            'ads-woocommerce',
            ADS_URI . '/assets/css/woocommerce.css',
            array( 'ads-main' ),
            ADS_VERSION
        );
    }

    // CSS page produit unique
    if ( function_exists( 'is_product' ) && is_product() ) {
        wp_enqueue_style(
            'ads-single-product',
            ADS_URI . '/assets/css/single-product.css',
            array( 'ads-main' ),
            ADS_VERSION
        );
    }

    // CSS page Contact
    if ( is_page_template( 'page-contact.php' ) ) {
        wp_enqueue_style(
            'ads-contact',
            ADS_URI . '/assets/css/contact.css',
            array( 'ads-main' ),
            ADS_VERSION
        );
    }

    // JS canvas animation (uniquement sur la homepage)
    if ( is_front_page() ) {
        wp_enqueue_script(
            'ads-canvas',
            ADS_URI . '/assets/js/canvas.js',
            array(),
            ADS_VERSION,
            true
        );
    }

    // JS principal (tous les templates)
    wp_enqueue_script(
        'ads-main',
        ADS_URI . '/assets/js/main.js',
        array(),
        ADS_VERSION,
        true
    );

    // Passer des variables PHP vers JS
    wp_localize_script( 'ads-main', 'adsData', array(
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'nonce'     => wp_create_nonce( 'ads-nonce' ),
        'shopUrl'   => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url(),
        'cartUrl'   => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url(),
        'cartCount' => function_exists( 'WC' ) ? WC()->cart->get_cart_contents_count() : 0,
        'currency'  => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : 'XOF',
    ) );
}
add_action( 'wp_enqueue_scripts', 'ads_enqueue_assets' );

// Desactiver les styles par defaut de WooCommerce
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
