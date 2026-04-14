<?php
/**
 * Integrations WooCommerce — Alchimie des Senteurs
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// Retirer les wrappers WooCommerce natifs
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Retirer le fil d'Ariane WooCommerce natif
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// Retirer le titre d'archive natif
add_filter( 'woocommerce_show_page_title', '__return_false' );

// -------------------------------------------------------
// FORCER notre template pour les pages de categories
// WooCommerce peut parfois ignorer taxonomy-product_cat.php
// dans le dossier /woocommerce/ du theme — ce hook le force.
// -------------------------------------------------------
add_filter( 'template_include', function( $template ) {
    if ( is_tax( 'product_cat' ) ) {
        $custom = get_template_directory() . '/woocommerce/taxonomy-product_cat.php';
        if ( file_exists( $custom ) ) {
            return $custom;
        }
    }
    return $template;
}, 99 );

// -------------------------------------------------------
// Nombre de produits par page sur les archives
// -------------------------------------------------------
add_filter( 'loop_shop_per_page', function() {
    return absint( get_theme_mod( 'ads_collection_nb', 6 ) );
}, 20 );

// -------------------------------------------------------
// Desactiver les styles WooCommerce natifs
// -------------------------------------------------------
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// -------------------------------------------------------
// AJAX : Ajouter au panier depuis les cards
// -------------------------------------------------------
add_action( 'wp_ajax_ads_add_to_cart',        'ads_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_ads_add_to_cart', 'ads_ajax_add_to_cart' );

function ads_ajax_add_to_cart() {
    check_ajax_referer( 'ads-nonce', 'nonce' );
    $product_id = absint( $_POST['product_id'] ?? 0 );
    $qty        = absint( $_POST['quantity']   ?? 1 );
    if ( ! $product_id ) wp_send_json_error( 'invalid_product' );
    $added = WC()->cart->add_to_cart( $product_id, $qty );
    if ( $added ) {
        wp_send_json_success( array(
            'count'   => WC()->cart->get_cart_contents_count(),
            'message' => 'Ajouté au panier',
        ) );
    } else {
        wp_send_json_error( 'could_not_add' );
    }
}

// -------------------------------------------------------
// Taille des images produit
// -------------------------------------------------------
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return array( 'width' => 150, 'height' => 150, 'crop' => 1 );
} );
