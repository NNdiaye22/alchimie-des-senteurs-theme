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
// CHAMPS CHECKOUT : code postal facultatif, téléphone obligatoire
// -------------------------------------------------------
add_filter( 'woocommerce_checkout_fields', function( $fields ) {

    // Code postal facultatif
    if ( isset( $fields['billing']['billing_postcode'] ) ) {
        $fields['billing']['billing_postcode']['required'] = false;
    }
    if ( isset( $fields['shipping']['shipping_postcode'] ) ) {
        $fields['shipping']['shipping_postcode']['required'] = false;
    }

    // Téléphone sénégalais : obligatoire, en tête de formulaire
    if ( isset( $fields['billing']['billing_phone'] ) ) {
        $fields['billing']['billing_phone']['required']    = true;
        $fields['billing']['billing_phone']['priority']    = 5;
        $fields['billing']['billing_phone']['label']       = __( 'Téléphone', 'alchimie-des-senteurs' );
        $fields['billing']['billing_phone']['placeholder'] = 'Ex : 77 000 00 00 ou +221 77 000 00 00';
    }

    return $fields;
} );

// -------------------------------------------------------
// Validation téléphone assouplie (accepte formats sénégalais)
// WooCommerce valide nativement le téléphone avec une regex stricte
// On la remplace pour accepter 7+ chiffres, espaces, +, tirets
// -------------------------------------------------------
add_filter( 'woocommerce_validate_phone', function( $valid, $phone ) {
    $cleaned = preg_replace( '/[\s\-\.\(\)]/', '', $phone );
    // Accepte : +221XXXXXXXX, 77XXXXXXX, 33XXXXXXX, etc. (min 7 chiffres)
    $valid = (bool) preg_match( '/^\+?[0-9]{7,15}$/', $cleaned );
    return $valid;
}, 10, 2 );

// -------------------------------------------------------
// FORCER nos templates via template_include
// -------------------------------------------------------
add_filter( 'template_include', function( $template ) {

    if ( is_singular( 'product' ) ) {
        $custom = get_template_directory() . '/woocommerce/single-product.php';
        if ( file_exists( $custom ) ) return $custom;
    }

    if ( is_tax( 'product_cat' ) ) {
        $custom = get_template_directory() . '/woocommerce/taxonomy-product_cat.php';
        if ( file_exists( $custom ) ) return $custom;
    }

    if ( is_cart() ) {
        $custom = get_template_directory() . '/page-cart.php';
        if ( file_exists( $custom ) ) return $custom;
    }

    return $template;

}, 99 );

// -------------------------------------------------------
// Nombre de produits par page
// -------------------------------------------------------
add_filter( 'loop_shop_per_page', function() {
    return absint( get_theme_mod( 'ads_collection_nb', 6 ) );
}, 20 );

// -------------------------------------------------------
// Desactiver les styles WooCommerce natifs
// -------------------------------------------------------
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// -------------------------------------------------------
// AJAX : Ajouter au panier (produit simple)
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
// AJAX : Ajouter au panier (produit variable)
// -------------------------------------------------------
add_action( 'wp_ajax_ads_add_variation_to_cart',        'ads_ajax_add_variation_to_cart' );
add_action( 'wp_ajax_nopriv_ads_add_variation_to_cart', 'ads_ajax_add_variation_to_cart' );

function ads_ajax_add_variation_to_cart() {
    check_ajax_referer( 'ads-nonce', 'nonce' );

    $product_id   = absint( $_POST['product_id']   ?? 0 );
    $variation_id = absint( $_POST['variation_id'] ?? 0 );
    $qty          = absint( $_POST['quantity']      ?? 1 );

    if ( ! $product_id || ! $variation_id ) {
        wp_send_json_error( 'invalid_product' );
    }

    $variation  = wc_get_product( $variation_id );
    $var_attrs  = $variation ? $variation->get_variation_attributes() : [];

    $added = WC()->cart->add_to_cart( $product_id, $qty, $variation_id, $var_attrs );

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
// Taille des images
// -------------------------------------------------------
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return array( 'width' => 150, 'height' => 150, 'crop' => 1 );
} );

// -------------------------------------------------------
// CSS variations — boutons pill
// -------------------------------------------------------
add_action( 'wp_head', function() {
    if ( ! is_product() ) return;
    ?>
    <style id="ads-variation-css">
    .ads-var-group { margin-bottom: 1.25rem; }
    .ads-var-label {
        font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em;
        color: var(--stone, #9a9088); margin-bottom: 0.6rem;
        display: flex; align-items: baseline; gap: 0.5rem;
    }
    .ads-var-chosen {
        font-size: 0.72rem; font-weight: 600; color: var(--amber, #c4873a);
        letter-spacing: 0.02em; text-transform: none;
    }
    .ads-var-pills { display: flex; flex-wrap: wrap; gap: 0.5rem; }
    .ads-pill {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 0.4rem 1rem; border: 1px solid var(--mid, #e0d8cc);
        border-radius: 999px; background: transparent; color: var(--ink, #1a1714);
        font-size: 0.8rem; font-family: inherit; cursor: pointer;
        transition: border-color 0.2s, background 0.2s, color 0.2s, box-shadow 0.2s;
        line-height: 1;
    }
    .ads-pill:hover { border-color: var(--amber, #c4873a); color: var(--amber, #c4873a); }
    .ads-pill.active {
        border-color: var(--amber, #c4873a); background: var(--amber, #c4873a);
        color: #fff; box-shadow: 0 2px 8px oklch(from var(--amber, #c4873a) l c h / 0.25);
    }
    .ads-pill:disabled, .ads-pill.is-disabled {
        opacity: 0.4; cursor: not-allowed;
        border-color: var(--mid, #e0d8cc); color: var(--stone, #9a9088);
    }
    .ads-var-unavailable {
        font-size: 0.78rem; color: #b94a48; margin-top: 0.5rem;
        padding: 0.4rem 0.75rem; border-left: 2px solid #b94a48;
        background: rgba(185,74,72,0.06); border-radius: 0 4px 4px 0;
    }
    .sp-add-btn {
        display: inline-flex; align-items: center; gap: 0.5rem;
        margin-top: 1rem; padding: 0.75rem 1.75rem;
        background: var(--ink, #1a1714); color: #fff; border: none;
        border-radius: 4px; font-size: 0.85rem; font-family: inherit;
        font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase;
        cursor: pointer; transition: background 0.2s, opacity 0.2s, transform 0.15s;
    }
    .sp-add-btn:hover:not(:disabled) { background: var(--amber, #c4873a); transform: translateY(-1px); }
    .sp-add-btn:disabled { opacity: 0.45; cursor: not-allowed; transform: none; }
    .sp-add-btn.loading { opacity: 0.7; pointer-events: none; }
    .sp-add-btn.added { background: #437a22; }
    .sp-add-btn.loading::after {
        content: ''; display: inline-block; width: 12px; height: 12px;
        border: 2px solid rgba(255,255,255,0.4); border-top-color: #fff;
        border-radius: 50%; animation: ads-spin 0.7s linear infinite;
    }
    @keyframes ads-spin { to { transform: rotate(360deg); } }
    </style>
    <?php
} );
