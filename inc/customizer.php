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
    $wp_customize->add_setting( 'ads_hero_cta_show', array( 'default' => '1', 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'ads_hero_cta_show', array(
        'label'   => 'Afficher le bouton CTA',
        'section' => 'ads_hero',
        'type'    => 'checkbox',
    ) );

    // ================================================================
    // SECTION : ANIMATION SCROLL — Infos flottantes
    // ================================================================
    $wp_customize->add_section( 'ads_scroll_infos', array(
        'title'       => 'Animation Scroll — Infos flottantes',
        'description' => 'Les 3 blocs d’info visibles pendant l’animation de défilement (gauche, droite, bas).',
        'panel'       => 'ads_theme_panel',
    ) );
    $scroll_infos = array(
        // Bloc GAUCHE
        'ads_scroll_left_label' => array( 'label' => 'Gauche — Label',       'default' => 'Combustion' ),
        'ads_scroll_left_value' => array( 'label' => 'Gauche — Valeur',       'default' => '2h à 5h' ),
        'ads_scroll_left_sub1'  => array( 'label' => 'Gauche — Ligne 1 sous', 'default' => 'Diffusion lente' ),
        'ads_scroll_left_sub2'  => array( 'label' => 'Gauche — Ligne 2 sous', 'default' => 'et continue' ),
        // Bloc DROIT
        'ads_scroll_right_label' => array( 'label' => 'Droite — Label',       'default' => 'Matière première' ),
        'ads_scroll_right_value' => array( 'label' => 'Droite — Valeur',       'default' => 'Résine naturelle' ),
        'ads_scroll_right_sub1'  => array( 'label' => 'Droite — Ligne 1 sous', 'default' => 'Bois précieux' ),
        'ads_scroll_right_sub2'  => array( 'label' => 'Droite — Ligne 2 sous', 'default' => 'sélectionné' ),
        // Bloc BAS
        'ads_scroll_bottom_label' => array( 'label' => 'Bas — Label', 'default' => 'Notes olfactives' ),
        'ads_scroll_bottom_value' => array( 'label' => 'Bas — Valeur', 'default' => 'Oud · Bois de Santal · Ambre' ),
    );
    foreach ( $scroll_infos as $key => $field ) {
        $wp_customize->add_setting( $key, array( 'default' => $field['default'], 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( $key, array( 'label' => $field['label'], 'section' => 'ads_scroll_infos', 'type' => 'text' ) );
    }

    // ================================================================
    // SECTION : ANIMATION SCROLL — Phases (textes défilement)
    // ================================================================
    $wp_customize->add_section( 'ads_scroll_phases', array(
        'title'       => 'Animation Scroll — Phases',
        'description' => 'Les 3 textes qui apparaissent successivement pendant le scroll de la page d’accueil.',
        'panel'       => 'ads_theme_panel',
    ) );
    $phases = array(
        1 => array(
            'tag'   => array( 'label' => 'Phase 1 — Tag',   'default' => 'I — L’Allumage' ),
            'title' => array( 'label' => 'Phase 1 — Titre', 'default' => "L'instant du premier souffle" ),
            'body'  => array( 'label' => 'Phase 1 — Texte', 'default' => 'La braise s’éveille. Un fil de fumée s’élève, portant avec lui des siècles de tradition olfactive orientale.' ),
        ),
        2 => array(
            'tag'   => array( 'label' => 'Phase 2 — Tag',   'default' => 'II — La Consumation' ),
            'title' => array( 'label' => 'Phase 2 — Titre', 'default' => 'Le temps qui parfume' ),
            'body'  => array( 'label' => 'Phase 2 — Texte', 'default' => 'Au fil des heures, le bâtonnet révèle ses couches olfactives. Du cœur épicé aux notes boisées de fond.' ),
        ),
        3 => array(
            'tag'   => array( 'label' => 'Phase 3 — Tag',   'default' => 'III — L’Empreinte' ),
            'title' => array( 'label' => 'Phase 3 — Titre', 'default' => 'Ce qui reste après le silence' ),
            'body'  => array( 'label' => 'Phase 3 — Texte', 'default' => 'La fumée s’est dissipée, mais le souvenir olfactif persiste. C’est la magie du bon encens.' ),
        ),
    );
    foreach ( $phases as $i => $parts ) {
        foreach ( $parts as $part => $field ) {
            $key = "ads_phase_{$i}_{$part}";
            $wp_customize->add_setting( $key, array( 'default' => $field['default'], 'sanitize_callback' => 'wp_kses_post' ) );
            $wp_customize->add_control( $key, array( 'label' => $field['label'], 'section' => 'ads_scroll_phases', 'type' => ( $part === 'body' ? 'textarea' : 'text' ) ) );
        }
    }

    // ================================================================
    // SECTION : CITATION
    // ================================================================
    $wp_customize->add_section( 'ads_quote', array(
        'title' => 'Bandeau Citation',
        'panel' => 'ads_theme_panel',
    ) );
    $wp_customize->add_setting( 'ads_quote_show', array( 'default' => '1', 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'ads_quote_show', array( 'label' => 'Afficher cette section', 'section' => 'ads_quote', 'type' => 'checkbox' ) );
    $wp_customize->add_setting( 'ads_quote_text', array( 'default' => '« Un parfum ne se voit pas, mais il se souvient. »', 'sanitize_callback' => 'wp_kses_post' ) );
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
    foreach ( array(
        'ads_collection_tag'      => array( 'label' => 'Tag',                        'default' => 'Nos Encens',    'type' => 'text' ),
        'ads_collection_title'    => array( 'label' => 'Titre',                      'default' => 'La Collection', 'type' => 'text' ),
        'ads_collection_cta_text' => array( 'label' => 'Bouton « Tout voir » — Texte', 'default' => 'Tout voir',    'type' => 'text' ),
        'ads_collection_cta_url'  => array( 'label' => 'Bouton « Tout voir » — Lien',  'default' => '#',            'type' => 'text' ),
    ) as $key => $field ) {
        $wp_customize->add_setting( $key, array( 'default' => $field['default'], 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( $key, array( 'label' => $field['label'], 'section' => 'ads_collection', 'type' => $field['type'] ) );
    }
    $wp_customize->add_setting( 'ads_collection_nb', array( 'default' => 6, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'ads_collection_nb', array( 'label' => 'Nombre de produits affichés', 'section' => 'ads_collection', 'type' => 'number', 'input_attrs' => array( 'min' => 3, 'max' => 12 ) ) );

    // ================================================================
    // SECTION : PHILOSOPHIE
    // ================================================================
    $wp_customize->add_section( 'ads_philosophy', array(
        'title' => 'Section Philosophie',
        'panel' => 'ads_theme_panel',
    ) );
    $wp_customize->add_setting( 'ads_phi_show', array( 'default' => '1', 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'ads_phi_show', array( 'label' => 'Afficher cette section', 'section' => 'ads_philosophy', 'type' => 'checkbox' ) );
    foreach ( array(
        'ads_phi_tag'   => array( 'label' => 'Tag',   'default' => 'Notre Philosophie',                     'type' => 'text' ),
        'ads_phi_title' => array( 'label' => 'Titre', 'default' => "L'encens comme rituel quotidien",        'type' => 'text' ),
        'ads_phi_body'  => array( 'label' => 'Texte', 'default' => "Chaque bâtonnet est un pont entre le présent et l'ancestral.", 'type' => 'textarea' ),
    ) as $key => $field ) {
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
    foreach ( array(
        'ads_nl_tag'   => array( 'label' => 'Tag',         'default' => 'Restez Informé',        'type' => 'text' ),
        'ads_nl_title' => array( 'label' => 'Titre',        'default' => 'La Lettre des Senteurs', 'type' => 'text' ),
        'ads_nl_sub'   => array( 'label' => 'Sous-titre',   'default' => 'Nouvelles collections, éditions limitées et conseils olfactifs.', 'type' => 'textarea' ),
        'ads_nl_btn'   => array( 'label' => 'Texte bouton', 'default' => "S'abonner",             'type' => 'text' ),
    ) as $key => $field ) {
        $wp_customize->add_setting( $key, array( 'default' => $field['default'], 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( $key, array( 'label' => $field['label'], 'section' => 'ads_newsletter', 'type' => $field['type'] ) );
    }

    // ================================================================
    // SECTION : PAGE CONTACT
    // ================================================================
    $wp_customize->add_section( 'ads_contact', array(
        'title'       => 'Page Contact',
        'description' => 'Informations affichées dans la bande de la page Contact.',
        'panel'       => 'ads_theme_panel',
    ) );
    $contact_fields = array(
        'ads_contact_hero_tag'   => array( 'label' => 'Hero — Tag',              'default' => 'Nous Contacter',                'type' => 'text' ),
        'ads_contact_hero_title' => array( 'label' => 'Hero — Titre ligne 1',    'default' => 'Une question ?',              'type' => 'text' ),
        'ads_contact_hero_em'    => array( 'label' => 'Hero — Titre ligne 2 (italique ambre)', 'default' => 'Parlons-en.',    'type' => 'text' ),
        'ads_contact_hero_sub'   => array( 'label' => 'Hero — Sous-titre',       'default' => 'Notre équipe est disponible du lundi au samedi, de 9h à 18h.', 'type' => 'textarea' ),
        'ads_contact_adresse'    => array( 'label' => 'Adresse',                   'default' => 'Dakar, Sénégal',              'type' => 'text' ),
        'ads_contact_whatsapp'   => array( 'label' => 'Lien WhatsApp (https://wa.me/...)', 'default' => 'https://wa.me/221776440125', 'type' => 'text' ),
        'ads_contact_wa_label'   => array( 'label' => 'WhatsApp — Texte affiché', 'default' => '+221 77 644 01 25',           'type' => 'text' ),
        'ads_contact_email'      => array( 'label' => 'Email de contact',           'default' => 'contact@alchimie-des-senteurs.sn', 'type' => 'text' ),
        'ads_contact_horaires'   => array( 'label' => 'Horaires',                   'default' => 'Lun — Sam : 9h à 18h',         'type' => 'text' ),
        'ads_contact_form_tag'   => array( 'label' => 'Formulaire — Tag',          'default' => 'Formulaire',                    'type' => 'text' ),
        'ads_contact_form_title' => array( 'label' => 'Formulaire — Titre ligne 1','default' => 'Envoyez-nous',                 'type' => 'text' ),
        'ads_contact_form_em'    => array( 'label' => 'Formulaire — Titre ligne 2 (italique)', 'default' => 'un message',       'type' => 'text' ),
        'ads_contact_form_sub'   => array( 'label' => 'Formulaire — Sous-titre',   'default' => 'Nous vous répondons sous 24h. Pour les commandes urgentes, préférez WhatsApp.', 'type' => 'textarea' ),
    );
    foreach ( $contact_fields as $key => $field ) {
        $wp_customize->add_setting( $key, array( 'default' => $field['default'], 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( $key, array( 'label' => $field['label'], 'section' => 'ads_contact', 'type' => $field['type'] ) );
    }

    // ================================================================
    // SECTION : FOOTER
    // ================================================================
    $wp_customize->add_section( 'ads_footer', array(
        'title' => 'Footer',
        'panel' => 'ads_theme_panel',
    ) );
    foreach ( array(
        'ads_footer_brand' => array( 'label' => 'Nom de marque',           'default' => 'Alchimie des Senteurs',   'type' => 'text' ),
        'ads_footer_sub'   => array( 'label' => 'Sous-titre marque',        'default' => "Maison d'Encens · Dakar", 'type' => 'text' ),
        'ads_footer_about' => array( 'label' => 'Texte de présentation',    'default' => "Depuis Dakar, nous apportons les fragrances les plus authentiques d'Orient dans vos foyers.", 'type' => 'textarea' ),
        'ads_footer_wa'    => array( 'label' => 'Lien WhatsApp',            'default' => 'https://wa.me/221776440125', 'type' => 'text' ),
        'ads_footer_insta' => array( 'label' => 'Lien Instagram',           'default' => '#',                      'type' => 'text' ),
        'ads_footer_fb'    => array( 'label' => 'Lien Facebook',            'default' => '#',                      'type' => 'text' ),
        'ads_footer_copy'  => array( 'label' => 'Texte copyright',          'default' => '© 2026 Alchimie des Senteurs · Dakar, Sénégal', 'type' => 'text' ),
        'ads_footer_pay'   => array( 'label' => 'Moyens de paiement (séparés par virgule)', 'default' => 'Orange Money,Wave,Carte', 'type' => 'text' ),
    ) as $key => $field ) {
        $wp_customize->add_setting( $key, array( 'default' => $field['default'], 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( $key, array( 'label' => $field['label'], 'section' => 'ads_footer', 'type' => $field['type'] ) );
    }
}
add_action( 'customize_register', 'ads_customizer_register' );
