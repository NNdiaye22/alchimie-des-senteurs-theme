<?php
/**
 * Hooks et filtres WooCommerce.
 * Personnalisation de l'integration WooCommerce dans le theme.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// -------------------------------------------------------
// Supprimer les wrappers par defaut de WooCommerce
// pour utiliser notre propre structure HTML
// -------------------------------------------------------
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );

function ads_woo_wrapper_start() {
    echo '<main id="main" class="ads-woo-main">';
}
function ads_woo_wrapper_end() {
    echo '</main>';
}
add_action( 'woocommerce_before_main_content', 'ads_woo_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content',  'ads_woo_wrapper_end',   10 );

// -------------------------------------------------------
// Supprimer la sidebar sur les pages WooCommerce
// -------------------------------------------------------
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// -------------------------------------------------------
// Personnaliser le nombre de produits par page
// -------------------------------------------------------
function ads_woo_products_per_page() {
    return (int) get_theme_mod( 'ads_collection_nb', 6 );
}
add_filter( 'loop_shop_per_page', 'ads_woo_products_per_page', 20 );

// -------------------------------------------------------
// Nombre de colonnes dans la grille
// -------------------------------------------------------
function ads_woo_loop_columns() {
    return 3;
}
add_filter( 'loop_shop_columns', 'ads_woo_loop_columns' );

// -------------------------------------------------------
// Breadcrumb personnalise
// -------------------------------------------------------
add_filter( 'woocommerce_breadcrumb_defaults', function( $defaults ) {
    $defaults['delimiter']   = ' &rsaquo; ';
    $defaults['wrap_before'] = '<nav class="ads-breadcrumb">';
    $defaults['wrap_after']  => '</nav>';
    return $defaults;
} );

// -------------------------------------------------------
// Bouton Ajouter au panier : texte personnalise
// -------------------------------------------------------
add_filter( 'woocommerce_product_single_add_to_cart_text', function() {
    return __( 'Ajouter au panier', 'alchimie-des-senteurs' );
} );
add_filter( 'woocommerce_product_add_to_cart_text', function() {
    return __( 'Ajouter', 'alchimie-des-senteurs' );
} );

// -------------------------------------------------------
// Desactiver le CSS WooCommerce par defaut
// (deja gere dans enqueue.php mais double securite)
// -------------------------------------------------------
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// -------------------------------------------------------
// Afficher le prix dans la bonne devise
// -------------------------------------------------------
add_filter( 'woocommerce_currency', function() {
    return 'XOF';
} );

add_filter( 'woocommerce_currency_symbol', function( $symbol, $currency ) {
    if ( $currency === 'XOF' ) return 'XOF';
    return $symbol;
}, 10, 2 );

// -------------------------------------------------------
// Fragment panier AJAX (mise a jour compteur nav)
// -------------------------------------------------------
add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
    $count = WC()->cart->get_cart_contents_count();
    $fragments['.nav-cart-count'] = '<span class="nav-cart-count">' . $count . '</span>';
    return $fragments;
} );

// -------------------------------------------------------
// Retirer les onglets inutiles sur la page produit
// -------------------------------------------------------
add_filter( 'woocommerce_product_tabs', function( $tabs ) {
    // Garder uniquement description et avis
    unset( $tabs['additional_information'] );
    return $tabs;
}, 98 );

// -------------------------------------------------------
// Structure des images produit dans la boucle
// -------------------------------------------------------
function ads_woo_loop_thumbnail() {
    global $product;
    $img_id  = $product->get_image_id();
    $img_url = $img_id
        ? wp_get_attachment_image_url( $img_id, 'ads-product-card' )
        : wc_placeholder_img_src( 'ads-product-card' );
    $alt = get_the_title();
    echo '<div class="ads-product-img-wrap">';
    echo '<img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy">';
    echo '</div>';
}
