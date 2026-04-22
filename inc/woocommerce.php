<?php
/**
 * Intégrations WooCommerce — Alchimie des Senteurs
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// -------------------------------------------------------
// AJAX : total du panier pour le cart drawer
// -------------------------------------------------------
function ads_get_cart_total_ajax() {
    if ( ! check_ajax_referer( 'ads-nonce', 'nonce', false ) ) {
        wp_send_json_error( array( 'total' => '' ) );
    }
    $total = function_exists( 'WC' ) && WC()->cart
        ? wc_price( WC()->cart->get_cart_total_ex_tax() )
        : '';
    // Fallback : get_cart_total() retourne déjà du HTML formaté
    if ( empty( $total ) && function_exists( 'WC' ) && WC()->cart ) {
        $total = WC()->cart->get_cart_total();
    }
    wp_send_json_success( array( 'total' => wp_strip_all_tags( $total ) ) );
}
add_action( 'wp_ajax_ads_get_cart_total',        'ads_get_cart_total_ajax' );
add_action( 'wp_ajax_nopriv_ads_get_cart_total', 'ads_get_cart_total_ajax' );
