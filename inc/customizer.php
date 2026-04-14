<?php
/**
 * Customizer - Alchimie des Senteurs
 * Apparence > Personnaliser > Alchimie des Senteurs
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function ads_customizer_register( $wp_customize ) {

    $wp_customize->add_panel( 'ads_theme_panel', array(
        'title'    => 'Alchimie des Senteurs',
        'priority' => 30,
    ) );

    // ================================================================
    // SECTION : HERO
    // ================================================================
    $wp_customize->add_section( 'ads_hero', array(
        'title' => 'Hero — Section principale',
        'panel' => 'ads_theme_panel',
    ) );
    $hero_fields = array(
        'ads_hero_tag'      => array( 'label' => 'Tag au-dessus du titre',     'default' => "Maison d'Encens · Dakar" ),
        'ads_hero_title_l1' => array( 'label' => 'Titre ligne 1',              'default' => "L'Encens" ),
        'ads_hero_title_l2' => array( 'label' => 'Titre ligne 2 (italique)',   'default' => 'Vivant' ),
        'ads_hero_sub'      => array( 'label' => 'Sous-titre',                 'default' => 'Oud · Arabesque · Musc · Andalous' ),
        'ads_hero_cta_text' => array( 'label' => 'Bouton CTA — Texte',         'default' => 'Découvrir' ),
        'ads_hero_cta_url'  => array( 'label' => 'Bouton CTA — Lien',          'default' => '#collection' ),
    );
    foreach ( $hero_fields as $key => $field ) {
        $wp_customize->add_setting( $key, array( 'default' => $field['default'], 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( $key, array( 'label' => $field['label'], 'section' => 'ads_hero', 'type' => 'text' ) );
    }
    // Afficher/masquer le bouton CTA
    $wp_customize->add_setting( 'ads_hero_cta_show', array( 'default' => '1', 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'ads_hero_cta_show', array(
        'label'   => 'Afficher le bouton CTA',
        'section' => 'ads_hero',
        'type'    => 'checkbox',
    ) );

    // ================================================================
    // SECTION : CITATION
    // ================================================================
    $wp_customize->add_section( 'ads_quote', array(
        'title' => 'Bandeau Citation',
        'panel' => 'ads_theme_panel',
    ) );
    $wp_customize->add_setting( 'ads_quote_show', array( 'default' => '1', 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'ads_quote_show', array( 'label' => 'Afficher cette section', 'section' => 'ads_quote', 'type' => 'checkbox' ) );
    $wp_customize->add_setting( 'ads_quote_text', array( 'default' => '« Un parfum ne se voit pas, mais il se souvient. »', 'sanitize_callback' => 'wp_kses_post' ) );
    $wp_customize->add_control( 'ads_quote_text', array( 'label' => 'Texte de la citation', 'section' => 'ads_quote', 'type' => 'textarea' ) );
    $wp_customize->add_setting( 'ads_quote_attr', array( 'default' => '— La Philosophie des Senteurs', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'ads_quote_attr', array( 'label' => 'Attribution', 'section' => 'ads_quote', 'type' => 'text' ) );

    // ================================================================
    // SECTION : COLLECTION
    // ================================================================
    $wp_customize->add_section( 'ads_collection', array(
        'title' => 'Section Collection',
        'panel' => 'ads_theme_panel',
    ) );
    $wp_customize->add_setting( 'ads_collection_show', array( 'default' => '1', 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'ads_collection_show', array( 'label' => 'Afficher cette section', 'section' => 'ads_collection', 'type' => 'checkbox' ) );
    $wp_customize->add_setting( 'ads_collection_tag',   array( 'default' => 'Nos Encens',    'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_setting( 'ads_collection_title', array( 'default' => 'La Collection', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_setting( 'ads_collection_cta_text', array( 'default' => 'Tout voir', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_setting( 'ads_collection_cta_url',  array( 'default' => '#',          'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_setting( 'ads_collection_nb',    array( 'default' => 6,             'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'ads_collection_tag',      array( 'label' => 'Tag',                   'section' => 'ads_collection', 'type' => 'text' ) );
    $wp_customize->add_control( 'ads_collection_title',    array( 'label' => 'Titre',                 'section' => 'ads_collection', 'type' => 'text' ) );
    $wp_customize->add_control( 'ads_collection_cta_text', array( 'label' => 'Bouton "Tout voir" — Texte', 'section' => 'ads_collection', 'type' => 'text' ) );
    $wp_customize->add_control( 'ads_collection_cta_url',  array( 'label' => 'Bouton "Tout voir" — Lien',  'section' => 'ads_collection', 'type' => 'text' ) );
    $wp_customize->add_control( 'ads_collection_nb',       array( 'label' => 'Nombre de produits affichés', 'section' => 'ads_collection', 'type' => 'number', 'input_attrs' => array( 'min' => 3, 'max' => 12 ) ) );

    // ================================================================
    // SECTION : PHILOSOPHIE
    // ================================================================
    $wp_customize->add_section( 'ads_philosophy', array(
        'title' => 'Section Philosophie',
        'panel' => 'ads_theme_panel',
    ) );
    $wp_customize->add_setting( 'ads_phi_show', array( 'default' => '1', 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'ads_phi_show', array( 'label' => 'Afficher cette section', 'section' => 'ads_philosophy', 'type' => 'checkbox' ) );
    $phi_fields = array(
        'ads_phi_tag'   => array( 'label' => 'Tag',   'default' => 'Notre Philosophie',                    'type' => 'text' ),
        'ads_phi_title' => array( 'label' => 'Titre', 'default' => "L'encens comme rituel quotidien",       'type' => 'text' ),
        'ads_phi_body'  => array( 'label' => 'Texte', 'default' => "Chaque bâtonnet est un pont entre le présent et l'ancestral.", 'type' => 'textarea' ),
    );
    foreach ( $phi_fields as $key => $field ) {
        $wp_customize->add_setting( $key, array( 'default' => $field['default'], 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( $key, array( 'label' => $field['label'], 'section' => 'ads_philosophy', 'type' => $field['type'] ) );
    }
    for ( $i = 1; $i <= 4; $i++ ) {
        $wp_customize->add_setting( "ads_phi_stat_{$i}_num",  array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_setting( "ads_phi_stat_{$i}_unit", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_setting( "ads_phi_stat_{$i}_desc", array( 'default' => '', 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( "ads_phi_stat_{$i}_num",  array( 'label' => "Stat {$i} — Chiffre",      'section' => 'ads_philosophy', 'type' => 'text' ) );
        $wp_customize->add_control( "ads_phi_stat_{$i}_unit", array( 'label' => "Stat {$i} — Unité/Label",  'section' => 'ads_philosophy', 'type' => 'text' ) );
        $wp_customize->add_control( "ads_phi_stat_{$i}_desc", array( 'label' => "Stat {$i} — Description", 'section' => 'ads_philosophy', 'type' => 'text' ) );
    }

    // ================================================================
    // SECTION : NEWSLETTER
    // ================================================================
    $wp_customize->add_section( 'ads_newsletter', array(
        'title' => 'Section Newsletter',
        'panel' => 'ads_theme_panel',
    ) );
    $wp_customize->add_setting( 'ads_nl_show', array( 'default' => '1', 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'ads_nl_show', array( 'label' => 'Afficher cette section', 'section' => 'ads_newsletter', 'type' => 'checkbox' ) );
    $nl_fields = array(
        'ads_nl_tag'   => array( 'label' => 'Tag',           'default' => 'Restez Informé',       'type' => 'text' ),
        'ads_nl_title' => array( 'label' => 'Titre',          'default' => 'La Lettre des Senteurs','type' => 'text' ),
        'ads_nl_sub'   => array( 'label' => 'Sous-titre',     'default' => 'Nouvelles collections, éditions limitées et conseils olfactifs.', 'type' => 'textarea' ),
        'ads_nl_btn'   => array( 'label' => 'Texte bouton',   'default' => "S'abonner",            'type' => 'text' ),
    );
    foreach ( $nl_fields as $key => $field ) {
        $wp_customize->add_setting( $key, array( 'default' => $field['default'], 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( $key, array( 'label' => $field['label'], 'section' => 'ads_newsletter', 'type' => $field['type'] ) );
    }

    // ================================================================
    // SECTION : FOOTER
    // ================================================================
    $wp_customize->add_section( 'ads_footer', array(
        'title' => 'Footer',
        'panel' => 'ads_theme_panel',
    ) );
    $footer_fields = array(
        'ads_footer_brand' => array( 'label' => 'Nom de marque',           'default' => 'Alchimie des Senteurs',   'type' => 'text' ),
        'ads_footer_sub'   => array( 'label' => 'Sous-titre marque',        'default' => "Maison d'Encens · Dakar", 'type' => 'text' ),
        'ads_footer_about' => array( 'label' => 'Texte de présentation',    'default' => "Depuis Dakar, nous apportons les fragrances les plus authentiques d'Orient dans vos foyers.", 'type' => 'textarea' ),
        'ads_footer_wa'    => array( 'label' => 'Lien WhatsApp',            'default' => 'https://wa.me/221776440125', 'type' => 'text' ),
        'ads_footer_insta' => array( 'label' => 'Lien Instagram',           'default' => '#',                      'type' => 'text' ),
        'ads_footer_fb'    => array( 'label' => 'Lien Facebook',            'default' => '#',                      'type' => 'text' ),
        'ads_footer_copy'  => array( 'label' => 'Texte copyright',          'default' => '© 2026 Alchimie des Senteurs · Dakar, Sénégal', 'type' => 'text' ),
        'ads_footer_pay'   => array( 'label' => 'Moyens de paiement (séparés par virgule)', 'default' => 'Orange Money,Wave,Carte', 'type' => 'text' ),
    );
    foreach ( $footer_fields as $key => $field ) {
        $wp_customize->add_setting( $key, array( 'default' => $field['default'], 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( $key, array( 'label' => $field['label'], 'section' => 'ads_footer', 'type' => $field['type'] ) );
    }
}
add_action( 'customize_register', 'ads_customizer_register' );
