<?php
/**
 * Options du Personnaliser WordPress (Customizer).
 * Permet de modifier le contenu des sections depuis Apparence > Personnaliser.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function ads_customizer_register( $wp_customize ) {

    // ---- PANNEAU PRINCIPAL ----------------------------------------
    $wp_customize->add_panel( 'ads_theme_panel', array(
        'title'       => __( 'Alchimie des Senteurs', 'alchimie-des-senteurs' ),
        'description' => __( 'Options du theme Alchimie des Senteurs.', 'alchimie-des-senteurs' ),
        'priority'    => 30,
    ) );

    // ==============================================================
    // SECTION : HERO
    // ==============================================================
    $wp_customize->add_section( 'ads_hero', array(
        'title' => __( 'Hero - Section principale', 'alchimie-des-senteurs' ),
        'panel' => 'ads_theme_panel',
    ) );

    $hero_fields = array(
        'ads_hero_tag'      => array( 'label' => 'Tag au-dessus du titre',     'default' => 'Maison d&#8217;Encens &middot; Dakar' ),
        'ads_hero_title_l1' => array( 'label' => 'Titre - Ligne 1',            'default' => 'L&#8217;Encens' ),
        'ads_hero_title_l2' => array( 'label' => 'Titre - Ligne 2 (italique)', 'default' => 'Vivant' ),
        'ads_hero_sub'      => array( 'label' => 'Sous-titre',                 'default' => 'Oud &middot; Arabesque &middot; Musc &middot; Andalous' ),
    );
    foreach ( $hero_fields as $key => $field ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $field['default'],
            'sanitize_callback' => 'wp_kses_post',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $field['label'],
            'section' => 'ads_hero',
            'type'    => 'text',
        ) );
    }

    // ==============================================================
    // SECTION : CITATION
    // ==============================================================
    $wp_customize->add_section( 'ads_quote', array(
        'title' => __( 'Bandeau Citation', 'alchimie-des-senteurs' ),
        'panel' => 'ads_theme_panel',
    ) );
    $wp_customize->add_setting( 'ads_quote_text', array(
        'default'           => '&laquo;&nbsp;Un parfum ne se voit pas, mais il se souvient. Il reste longtemps apr&egrave;s que tout le reste s&#8217;est tu.&nbsp;&raquo;',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'ads_quote_text', array(
        'label'   => 'Texte de la citation',
        'section' => 'ads_quote',
        'type'    => 'textarea',
    ) );
    $wp_customize->add_setting( 'ads_quote_attr', array(
        'default'           => '&mdash; La Philosophie des Senteurs',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'ads_quote_attr', array(
        'label'   => 'Auteur / Attribution',
        'section' => 'ads_quote',
        'type'    => 'text',
    ) );

    // ==============================================================
    // SECTION : COLLECTION
    // ==============================================================
    $wp_customize->add_section( 'ads_collection', array(
        'title' => __( 'Section Collection', 'alchimie-des-senteurs' ),
        'panel' => 'ads_theme_panel',
    ) );
    $wp_customize->add_setting( 'ads_collection_tag', array(
        'default'           => 'Nos Encens',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'ads_collection_tag', array(
        'label'   => 'Tag au-dessus du titre',
        'section' => 'ads_collection',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'ads_collection_title', array(
        'default'           => 'La Collection',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'ads_collection_title', array(
        'label'   => 'Titre de la section',
        'section' => 'ads_collection',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'ads_collection_nb', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'ads_collection_nb', array(
        'label'   => 'Nombre de produits affiches',
        'section' => 'ads_collection',
        'type'    => 'number',
        'input_attrs' => array( 'min' => 3, 'max' => 12 ),
    ) );

    // ==============================================================
    // SECTION : PHILOSOPHIE
    // ==============================================================
    $wp_customize->add_section( 'ads_philosophy', array(
        'title' => __( 'Section Philosophie (sombre)', 'alchimie-des-senteurs' ),
        'panel' => 'ads_theme_panel',
    ) );
    $phi_fields = array(
        'ads_phi_tag'   => array( 'label' => 'Tag',   'default' => 'Notre Philosophie' ),
        'ads_phi_title' => array( 'label' => 'Titre', 'default' => 'L&#8217;encens comme rituel quotidien' ),
        'ads_phi_body'  => array( 'label' => 'Texte', 'default' => 'Chaque b&acirc;tonnet est un pont entre le pr&eacute;sent et l&#8217;ancestral.' ),
    );
    foreach ( $phi_fields as $key => $field ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $field['default'],
            'sanitize_callback' => 'wp_kses_post',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $field['label'],
            'section' => 'ads_philosophy',
            'type'    => ( $key === 'ads_phi_body' ) ? 'textarea' : 'text',
        ) );
    }

    // Statistiques
    for ( $i = 1; $i <= 4; $i++ ) {
        $wp_customize->add_setting( "ads_phi_stat_{$i}_num",  array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_setting( "ads_phi_stat_{$i}_unit", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_setting( "ads_phi_stat_{$i}_desc", array( 'default' => '', 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( "ads_phi_stat_{$i}_num",  array( 'label' => "Stat {$i} - Chiffre",       'section' => 'ads_philosophy', 'type' => 'text' ) );
        $wp_customize->add_control( "ads_phi_stat_{$i}_unit", array( 'label' => "Stat {$i} - Unite/Label",   'section' => 'ads_philosophy', 'type' => 'text' ) );
        $wp_customize->add_control( "ads_phi_stat_{$i}_desc", array( 'label' => "Stat {$i} - Description",  'section' => 'ads_philosophy', 'type' => 'text' ) );
    }

    // ==============================================================
    // SECTION : NEWSLETTER
    // ==============================================================
    $wp_customize->add_section( 'ads_newsletter', array(
        'title' => __( 'Section Newsletter', 'alchimie-des-senteurs' ),
        'panel' => 'ads_theme_panel',
    ) );
    $nl_fields = array(
        'ads_nl_tag'   => array( 'label' => 'Tag',          'default' => 'Restez Inform&eacute;' ),
        'ads_nl_title' => array( 'label' => 'Titre',         'default' => 'La Lettre des Senteurs' ),
        'ads_nl_sub'   => array( 'label' => 'Sous-titre',    'default' => 'Nouvelles collections, &eacute;ditions limit&eacute;es et conseils olfactifs.' ),
        'ads_nl_btn'   => array( 'label' => 'Texte bouton',  'default' => 'S&#8217;abonner' ),
    );
    foreach ( $nl_fields as $key => $field ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $field['default'],
            'sanitize_callback' => 'wp_kses_post',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $field['label'],
            'section' => 'ads_newsletter',
            'type'    => ( $key === 'ads_nl_sub' ) ? 'textarea' : 'text',
        ) );
    }

    // ==============================================================
    // SECTION : FOOTER
    // ==============================================================
    $wp_customize->add_section( 'ads_footer', array(
        'title' => __( 'Footer', 'alchimie-des-senteurs' ),
        'panel' => 'ads_theme_panel',
    ) );
    $footer_fields = array(
        'ads_footer_brand'    => array( 'label' => 'Nom de marque',       'default' => 'Alchimie des Senteurs' ),
        'ads_footer_sub'      => array( 'label' => 'Sous-titre marque',   'default' => 'Maison d&#8217;Encens &middot; Dakar' ),
        'ads_footer_about'    => array( 'label' => 'Texte de presentation', 'default' => 'Depuis Dakar, nous apportons les fragrances les plus authentiques d&#8217;Orient dans vos foyers.' ),
        'ads_footer_wa'       => array( 'label' => 'Lien WhatsApp',       'default' => 'https://wa.me/221776440125' ),
        'ads_footer_insta'    => array( 'label' => 'Lien Instagram',      'default' => '#' ),
        'ads_footer_fb'       => array( 'label' => 'Lien Facebook',       'default' => '#' ),
        'ads_footer_copy'     => array( 'label' => 'Texte copyright',     'default' => '&copy; 2026 Alchimie des Senteurs &middot; Dakar, S&eacute;n&eacute;gal' ),
        'ads_footer_pay'      => array( 'label' => 'Moyens de paiement (separes par des virgules)', 'default' => 'Orange Money,Wave,Carte' ),
    );
    foreach ( $footer_fields as $key => $field ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $field['default'],
            'sanitize_callback' => 'wp_kses_post',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $field['label'],
            'section' => 'ads_footer',
            'type'    => ( $key === 'ads_footer_about' ) ? 'textarea' : 'text',
        ) );
    }
}
add_action( 'customize_register', 'ads_customizer_register' );
