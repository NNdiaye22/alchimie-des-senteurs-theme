<?php
/**
 * Alchimie des Senteurs - functions.php
 * Point d'entree principal du theme.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ADS_VERSION', '1.0.1' );
define( 'ADS_DIR', get_template_directory() );
define( 'ADS_URI', get_template_directory_uri() );

// -------------------------------------------------------
// Chargement des modules
// -------------------------------------------------------
require_once ADS_DIR . '/inc/enqueue.php';
require_once ADS_DIR . '/inc/customizer.php';
require_once ADS_DIR . '/inc/woocommerce.php';

// -------------------------------------------------------
// Prix "À partir de" pour les produits variables
// -------------------------------------------------------
add_filter( 'woocommerce_variable_price_html', function( $price, $product ) {
    $min = wc_price( $product->get_variation_price( 'min', true ) );
    return sprintf( 'À partir de %s', $min );
}, 10, 2 );

// -------------------------------------------------------
// Helper badge produit (simple + variable)
// Retourne array('id'=>string,'label'=>string) ou null
// -------------------------------------------------------
function ads_card_badge( $product ) {
    if ( ! $product ) return null;

    if ( $product->is_type( 'variable' ) ) {
        $any_sale      = false;
        $any_low       = false;
        $any_backorder = false;
        $all_out       = true;

        foreach ( $product->get_available_variations() as $v ) {
            $vobj    = wc_get_product( $v['variation_id'] );
            $v_stock = $vobj ? $vobj->get_stock_quantity() : null;
            $v_back  = $vobj ? $vobj->backorders_allowed() : false;
            $v_low   = ( $v['is_in_stock'] && $v_stock !== null && $v_stock > 0 && $v_stock <= 5 );
            $on_sale = $v['display_regular_price'] > $v['display_price'];

            if ( $v['is_in_stock'] || $v_back ) $all_out = false;
            if ( $on_sale ) $any_sale      = true;
            if ( $v_low )   $any_low       = true;
            if ( $v_back && ! $v['is_in_stock'] ) $any_backorder = true;
        }

        if ( $all_out )        return array( 'id' => 'out',       'label' => '&Eacute;puis&eacute;' );
        if ( $any_backorder )  return array( 'id' => 'backorder', 'label' => 'Bient&ocirc;t dispo' );
        if ( $any_low )        return array( 'id' => 'low',       'label' => 'Stock limit&eacute;' );
        if ( $any_sale )       return array( 'id' => 'promo',     'label' => 'Promo' );
        return null;
    }

    // Produit simple
    $in_stock   = $product->is_in_stock();
    $backorders = $product->backorders_allowed();
    $stock_qty  = $product->get_stock_quantity();
    $low_stock  = ( $in_stock && $stock_qty !== null && $stock_qty > 0 && $stock_qty <= 5 );
    $sale_price = $product->get_sale_price();

    if ( ! $in_stock && $backorders ) return array( 'id' => 'backorder', 'label' => 'Bient&ocirc;t dispo' );
    if ( ! $in_stock )                return array( 'id' => 'out',       'label' => '&Eacute;puis&eacute;' );
    if ( $low_stock )                 return array( 'id' => 'low',       'label' => 'Plus que ' . (int) $stock_qty . ' en stock' );
    if ( $sale_price )                return array( 'id' => 'promo',     'label' => 'Promo' );
    return null;
}

// -------------------------------------------------------
// Support du theme
// -------------------------------------------------------
function ads_theme_setup() {

    load_theme_textdomain( 'alchimie-des-senteurs', ADS_DIR . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ) );
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 600,
        'single_image_width'    => 900,
        'product_grid'          => array(
            'default_columns' => 3,
            'default_rows'    => 4,
            'min_columns'     => 1,
            'max_columns'     => 4,
        ),
    ) );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    register_nav_menus( array(
        'primary'   => __( 'Menu Principal', 'alchimie-des-senteurs' ),
        'footer_1'  => __( 'Footer - Collection', 'alchimie-des-senteurs' ),
        'footer_2'  => __( 'Footer - Boutique', 'alchimie-des-senteurs' ),
        'footer_3'  => __( 'Footer - Aide', 'alchimie-des-senteurs' ),
    ) );
    add_theme_support( 'automatic-feed-links' );
    add_image_size( 'ads-product-card',     600,  800,  true );
    add_image_size( 'ads-product-featured', 900,  1200, true );
    add_image_size( 'ads-hero',             1920, 1080, true );
}
add_action( 'after_setup_theme', 'ads_theme_setup' );

// -------------------------------------------------------
// Zones de widgets
// -------------------------------------------------------
function ads_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Footer - Colonne 1 (Presentation)', 'alchimie-des-senteurs' ),
        'id'            => 'footer-1',
        'before_widget' => '<div class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer - Colonne 2 (Collection)', 'alchimie-des-senteurs' ),
        'id'            => 'footer-2',
        'before_widget' => '<div class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer - Colonne 3 (Boutique)', 'alchimie-des-senteurs' ),
        'id'            => 'footer-3',
        'before_widget' => '<div class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer - Colonne 4 (Aide)', 'alchimie-des-senteurs' ),
        'id'            => 'footer-4',
        'before_widget' => '<div class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'ads_widgets_init' );

// -------------------------------------------------------
// Longueur des extraits
// -------------------------------------------------------
function ads_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'ads_excerpt_length' );

// -------------------------------------------------------
// Helpers globaux
// -------------------------------------------------------
function ads_the_logo( $return = false ) {
    $logo_id = get_theme_mod( 'custom_logo' );
    if ( $logo_id ) {
        $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
        $output   = '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="site-logo-img">';
    } else {
        $output = '<span class="site-logo-text">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
    }
    if ( $return ) return $output;
    echo $output;
}

function ads_option( $key, $default = '' ) {
    return get_theme_mod( $key, $default );
}
