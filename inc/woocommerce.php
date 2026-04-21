<?php
/**
 * Integrations WooCommerce — Alchimie des Senteurs
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// Retirer les wrappers WooCommerce natifs
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_filter( 'woocommerce_show_page_title', '__return_false' );

// -------------------------------------------------------
// EXPÉDITION — Bypass pour Sénégal
// -------------------------------------------------------
add_filter( 'woocommerce_cart_needs_shipping',         '__return_false' );
add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false' );

// Supprimer erreurs de validation liées à l'expédition
add_action( 'woocommerce_after_checkout_validation', function( $data, $errors ) {
    foreach ( $errors->get_error_codes() as $code ) {
        if ( strpos( $code, 'shipping' ) !== false ) {
            $errors->remove( $code );
        }
    }
}, 20, 2 );

// -------------------------------------------------------
// PAIEMENT — Forcer "paiement à la livraison" (cod)
// -------------------------------------------------------

// Toujours rendre cod disponible, quelle que soit la méthode d'expédition
add_filter( 'woocommerce_available_payment_gateways', function( $gateways ) {
    // Si cod existe, on le force disponible
    if ( isset( $gateways['cod'] ) ) {
        return array( 'cod' => $gateways['cod'] );
    }
    return $gateways;
} );

// Si aucun moyen de paiement POSTé, injecter cod automatiquement
add_action( 'woocommerce_checkout_process', function() {
    if ( empty( $_POST['payment_method'] ) ) {
        $_POST['payment_method'] = 'cod';
    }
} );

// Supprimer l'erreur "Moyen de paiement non valide" pour cod
add_action( 'woocommerce_after_checkout_validation', function( $data, $errors ) {
    $codes = $errors->get_error_codes();
    foreach ( $codes as $code ) {
        if ( strpos( $code, 'payment' ) !== false ) {
            // Vérifier que cod est bien disponible avant de supprimer l'erreur
            $gateways = WC()->payment_gateways()->get_available_payment_gateways();
            if ( isset( $gateways['cod'] ) ) {
                $errors->remove( $code );
            }
        }
    }
}, 25, 2 );

// -------------------------------------------------------
// CHAMPS CHECKOUT
// -------------------------------------------------------
add_filter( 'woocommerce_checkout_fields', function( $fields ) {

    foreach ( array( 'billing', 'shipping' ) as $type ) {
        if ( isset( $fields[ $type ][ $type . '_postcode' ] ) ) {
            $fields[ $type ][ $type . '_postcode' ]['type']     = 'hidden';
            $fields[ $type ][ $type . '_postcode' ]['required'] = false;
            $fields[ $type ][ $type . '_postcode' ]['default']  = '00000';
            $fields[ $type ][ $type . '_postcode' ]['label']    = '';
            $fields[ $type ][ $type . '_postcode' ]['class']    = array( 'hidden' );
        }
        if ( isset( $fields[ $type ][ $type . '_state' ] ) ) {
            $fields[ $type ][ $type . '_state' ]['type']     = 'hidden';
            $fields[ $type ][ $type . '_state' ]['required'] = false;
            $fields[ $type ][ $type . '_state' ]['label']    = '';
            $fields[ $type ][ $type . '_state' ]['class']    = array( 'hidden' );
        }
        if ( isset( $fields[ $type ][ $type . '_city' ] ) ) {
            $fields[ $type ][ $type . '_city' ]['required'] = false;
            $fields[ $type ][ $type . '_city' ]['class']    = array( 'hidden' );
            $fields[ $type ][ $type . '_city' ]['type']     = 'hidden';
            $fields[ $type ][ $type . '_city' ]['label']    = '';
        }
    }

    // Adresse libre
    if ( isset( $fields['billing']['billing_address_1'] ) ) {
        $fields['billing']['billing_address_1']['required']    = false;
        $fields['billing']['billing_address_1']['label']       = 'Adresse / Quartier';
        $fields['billing']['billing_address_1']['placeholder'] = 'Ex : Almadies, Mermoz, Médina…';
        $fields['billing']['billing_address_1']['class']       = array( 'form-row-wide' );
    }

    unset( $fields['billing']['billing_email'] );
    unset( $fields['billing']['billing_company'] );
    unset( $fields['billing']['billing_address_2'] );

    if ( isset( $fields['billing']['billing_phone'] ) ) {
        $fields['billing']['billing_phone']['required']    = true;
        $fields['billing']['billing_phone']['priority']    = 5;
        $fields['billing']['billing_phone']['label']       = 'Téléphone';
        $fields['billing']['billing_phone']['placeholder'] = 'Ex : 77 000 00 00';
    }

    return $fields;
} );

// Valeurs par défaut si vides
add_action( 'woocommerce_checkout_process', function() {
    if ( empty( $_POST['billing_postcode'] ) )  $_POST['billing_postcode']  = '00000';
    if ( empty( $_POST['billing_city'] ) )      $_POST['billing_city']      = 'Dakar';
    if ( empty( $_POST['billing_address_1'] ) ) $_POST['billing_address_1'] = 'Non renseignée';
    if ( isset( $_POST['shipping_postcode'] ) && empty( $_POST['shipping_postcode'] ) ) $_POST['shipping_postcode'] = '00000';
} );

// Validation téléphone
add_action( 'woocommerce_after_checkout_validation', function( $data, $errors ) {
    $phone = isset( $_POST['billing_phone'] ) ? trim( $_POST['billing_phone'] ) : '';
    if ( empty( $phone ) ) {
        $errors->add( 'billing_phone_required', '<strong>Téléphone</strong> est un champ obligatoire.' );
        return;
    }
    $cleaned = preg_replace( '/[\s\-\.\(\)]/', '', $phone );
    if ( ! preg_match( '/^\+?[0-9]{7,15}$/', $cleaned ) ) {
        $errors->add( 'billing_phone_invalid', 'Veuillez entrer un numéro valide (ex : 77 000 00 00).' );
    }
}, 10, 2 );

add_filter( 'woocommerce_validate_phone', function( $valid, $phone ) {
    $cleaned = preg_replace( '/[\s\-\.\(\)]/', '', $phone );
    return (bool) preg_match( '/^\+?[0-9]{7,15}$/', $cleaned );
}, 10, 2 );

add_filter( 'woocommerce_checkout_required_field_notice', function( $notice, $field_label ) {
    if ( strpos( strtolower( $field_label ), 'email' ) !== false ) return '';
    return $notice;
}, 10, 2 );

// -------------------------------------------------------
// TEMPLATES
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

// Produits par page
add_filter( 'loop_shop_per_page', function() {
    return absint( get_theme_mod( 'ads_collection_nb', 6 ) );
}, 20 );

// Styles WooCommerce natifs désactivés
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// -------------------------------------------------------
// AJAX : Panier produit simple
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
        wp_send_json_success( array( 'count' => WC()->cart->get_cart_contents_count(), 'message' => 'Ajouté au panier' ) );
    } else {
        wp_send_json_error( 'could_not_add' );
    }
}

// -------------------------------------------------------
// AJAX : Panier produit variable
// -------------------------------------------------------
add_action( 'wp_ajax_ads_add_variation_to_cart',        'ads_ajax_add_variation_to_cart' );
add_action( 'wp_ajax_nopriv_ads_add_variation_to_cart', 'ads_ajax_add_variation_to_cart' );
function ads_ajax_add_variation_to_cart() {
    check_ajax_referer( 'ads-nonce', 'nonce' );
    $product_id   = absint( $_POST['product_id']   ?? 0 );
    $variation_id = absint( $_POST['variation_id'] ?? 0 );
    $qty          = absint( $_POST['quantity']      ?? 1 );
    if ( ! $product_id || ! $variation_id ) wp_send_json_error( 'invalid_product' );
    $variation = wc_get_product( $variation_id );
    $var_attrs = $variation ? $variation->get_variation_attributes() : [];
    $added = WC()->cart->add_to_cart( $product_id, $qty, $variation_id, $var_attrs );
    if ( $added ) {
        wp_send_json_success( array( 'count' => WC()->cart->get_cart_contents_count(), 'message' => 'Ajouté au panier' ) );
    } else {
        wp_send_json_error( 'could_not_add' );
    }
}

// Taille images
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return array( 'width' => 150, 'height' => 150, 'crop' => 1 );
} );

// CSS variations — boutons pill
add_action( 'wp_head', function() {
    if ( ! is_product() ) return;
    ?>
    <style id="ads-variation-css">
    .ads-var-group{margin-bottom:1.25rem;}
    .ads-var-label{font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--stone,#9a9088);margin-bottom:0.6rem;display:flex;align-items:baseline;gap:0.5rem;}
    .ads-var-chosen{font-size:0.72rem;font-weight:600;color:var(--amber,#c4873a);letter-spacing:0.02em;text-transform:none;}
    .ads-var-pills{display:flex;flex-wrap:wrap;gap:0.5rem;}
    .ads-pill{display:inline-flex;align-items:center;justify-content:center;padding:0.4rem 1rem;border:1px solid var(--mid,#e0d8cc);border-radius:999px;background:transparent;color:var(--ink,#1a1714);font-size:0.8rem;font-family:inherit;cursor:pointer;transition:border-color 0.2s,background 0.2s,color 0.2s,box-shadow 0.2s;line-height:1;}
    .ads-pill:hover{border-color:var(--amber,#c4873a);color:var(--amber,#c4873a);}
    .ads-pill.active{border-color:var(--amber,#c4873a);background:var(--amber,#c4873a);color:#fff;box-shadow:0 2px 8px rgba(196,135,58,0.25);}
    .ads-pill:disabled,.ads-pill.is-disabled{opacity:0.4;cursor:not-allowed;border-color:var(--mid,#e0d8cc);color:var(--stone,#9a9088);}
    .ads-var-unavailable{font-size:0.78rem;color:#b94a48;margin-top:0.5rem;padding:0.4rem 0.75rem;border-left:2px solid #b94a48;background:rgba(185,74,72,0.06);border-radius:0 4px 4px 0;}
    .sp-add-btn{display:inline-flex;align-items:center;gap:0.5rem;margin-top:1rem;padding:0.75rem 1.75rem;background:var(--ink,#1a1714);color:#fff;border:none;border-radius:4px;font-size:0.85rem;font-family:inherit;font-weight:500;letter-spacing:0.05em;text-transform:uppercase;cursor:pointer;transition:background 0.2s,opacity 0.2s,transform 0.15s;}
    .sp-add-btn:hover:not(:disabled){background:var(--amber,#c4873a);transform:translateY(-1px);}
    .sp-add-btn:disabled{opacity:0.45;cursor:not-allowed;transform:none;}
    .sp-add-btn.loading{opacity:0.7;pointer-events:none;}
    .sp-add-btn.added{background:#437a22;}
    .sp-add-btn.loading::after{content:'';display:inline-block;width:12px;height:12px;border:2px solid rgba(255,255,255,0.4);border-top-color:#fff;border-radius:50%;animation:ads-spin 0.7s linear infinite;}
    @keyframes ads-spin{to{transform:rotate(360deg);}}
    </style>
    <?php
} );
