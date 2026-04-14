<?php
/**
 * Alchimie des Senteurs - functions.php
 * Point d'entree principal du theme.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ADS_VERSION', '1.0.0' );
define( 'ADS_DIR', get_template_directory() );
define( 'ADS_URI', get_template_directory_uri() );

// -------------------------------------------------------
// Chargement des modules
// -------------------------------------------------------
require_once ADS_DIR . '/inc/enqueue.php';
require_once ADS_DIR . '/inc/customizer.php';
require_once ADS_DIR . '/inc/woocommerce.php';

// -------------------------------------------------------
// Support du theme
// -------------------------------------------------------
function ads_theme_setup() {

    // Traductions
    load_theme_textdomain( 'alchimie-des-senteurs', ADS_DIR . '/languages' );

    // Titre dans l'onglet navigateur gere par WP
    add_theme_support( 'title-tag' );

    // Images a la une
    add_theme_support( 'post-thumbnails' );

    // Logo personnalise
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // HTML5
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ) );

    // WooCommerce
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

    // Menus de navigation
    register_nav_menus( array(
        'primary'   => __( 'Menu Principal', 'alchimie-des-senteurs' ),
        'footer_1'  => __( 'Footer - Collection', 'alchimie-des-senteurs' ),
        'footer_2'  => __( 'Footer - Boutique', 'alchimie-des-senteurs' ),
        'footer_3'  => __( 'Footer - Aide', 'alchimie-des-senteurs' ),
    ) );

    // Flux RSS automatiques
    add_theme_support( 'automatic-feed-links' );

    // Tailles d'images supplementaires
    add_image_size( 'ads-product-card', 600, 800, true );
    add_image_size( 'ads-product-featured', 900, 1200, true );
    add_image_size( 'ads-hero', 1920, 1080, true );
}
add_action( 'after_setup_theme', 'ads_theme_setup' );

// -------------------------------------------------------
// Zones de widgets
// -------------------------------------------------------
function ads_widgets_init() {

    register_sidebar( array(
        'name'          => __( 'Footer - Colonne 1 (Presentation)', 'alchimie-des-senteurs' ),
        'id'            => 'footer-1',
        'description'   => __( 'Zone de presentation de la boutique dans le footer.', 'alchimie-des-senteurs' ),
        'before_widget' => '<div class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer - Colonne 2 (Collection)', 'alchimie-des-senteurs' ),
        'id'            => 'footer-2',
        'description'   => __( 'Liens collection dans le footer.', 'alchimie-des-senteurs' ),
        'before_widget' => '<div class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer - Colonne 3 (Boutique)', 'alchimie-des-senteurs' ),
        'id'            => 'footer-3',
        'description'   => __( 'Liens boutique dans le footer.', 'alchimie-des-senteurs' ),
        'before_widget' => '<div class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer - Colonne 4 (Aide)', 'alchimie-des-senteurs' ),
        'id'            => 'footer-4',
        'description'   => __( 'Liens aide/contact dans le footer.', 'alchimie-des-senteurs' ),
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

/**
 * Affiche ou retourne le logo du theme.
 */
function ads_the_logo( $return = false ) {
    $logo_id = get_theme_mod( 'custom_logo' );
    if ( $logo_id ) {
        $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
        $output   = '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="site-logo-img">';
    } else {
        $output  = '<span class="site-logo-text">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
    }
    if ( $return ) return $output;
    echo $output;
}

/**
 * Retourne une option du customizer avec une valeur par defaut.
 */
function ads_option( $key, $default = '' ) {
    return get_theme_mod( $key, $default );
}
