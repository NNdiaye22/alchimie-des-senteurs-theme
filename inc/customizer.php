<?php
/**
 * Customizer - Alchimie des Senteurs
 *
 * Sections :
 *   0. Couleurs Globales
 *   1. Hero
 *   2. Animation Scroll - Infos
 *   3. Animation Scroll - Phases
 *   4. Section Mise en Avant (Reveal)
 *   5. Bandeau Citation
 *   6. Section Collection
 *   7. Section Philosophie
 *   8. Section Newsletter
 *   9. Page Boutique
 *  10. Pages Categories
 *  11. Page Contact
 *  12. Footer
 *  13. Numero de Telephone
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ================================================================
   HELPERS
================================================================ */
function _ads_text( $c, $key, $label, $default, $section, $type = 'text' ) {
    $c->add_setting( $key, array(
        'default'           => $default,
        'sanitize_callback' => ( $type === 'textarea' ) ? 'wp_kses_post' : 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $c->add_control( $key, array(
        'label'   => $label,
        'section' => $section,
        'type'    => $type,
    ) );
}
function _ads_color( $c, $key, $label, $default, $section ) {
    $c->add_setting( $key, array(
        'default'           => $default,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $c->add_control( new WP_Customize_Color_Control( $c, $key, array(
        'label'   => $label,
        'section' => $section,
    ) ) );
}
function _ads_check( $c, $key, $label, $default, $section ) {
    $c->add_setting( $key, array(
        'default'           => $default,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $c->add_control( $key, array(
        'label'   => $label,
        'section' => $section,
        'type'    => 'checkbox',
    ) );
}

/* ================================================================
   ENREGISTREMENT
================================================================ */
function ads_customizer_register( $wp_customize ) {

    $wp_customize->add_panel( 'ads_theme_panel', array(
        'title'    => 'Alchimie des Senteurs',
        'priority' => 30,
    ) );

    /* ==============================================================
       0. COULEURS GLOBALES
    ============================================================== */
    $wp_customize->add_section( 'ads_colors', array(
        'title'       => '\ud83c\udfa8 Couleurs Globales',
        'description' => 'Ces couleurs s\'appliquent sur tout le site.',
        'panel'       => 'ads_theme_panel',
        'priority'    => 1,
    ) );
    _ads_color( $wp_customize, 'ads_color_ink',     'Couleur principale (fond sombre / texte)', '#1a1714', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_amber',   'Couleur accent (ambre / dor\u00e9)',           '#c4873a', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_amber_l', 'Couleur accent claire',                    '#e0a85a', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_stone',   'Texte secondaire (gris)',                  '#9a9088', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_off',     'Fond d\u00e9cal\u00e9 (sections altern\u00e9es)',     '#f8f6f3', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_mid',     'Bordures / s\u00e9parateurs',                '#e0d8cc', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_white',   'Fond blanc',                               '#ffffff', 'ads_colors' );

    /* ==============================================================
       1. HERO
    ============================================================== */
    $wp_customize->add_section( 'ads_hero', array(
        'title' => 'Hero - Section principale',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_text(  $wp_customize, 'ads_hero_tag',      'Tag au-dessus du titre',   'Maison d\'Encens \u00b7 Dakar', 'ads_hero' );
    _ads_text(  $wp_customize, 'ads_hero_title_l1', 'Titre ligne 1',            'L\'Encens',                   'ads_hero' );
    _ads_text(  $wp_customize, 'ads_hero_title_l2', 'Titre ligne 2 (italique)', 'Vivant',                      'ads_hero' );
    _ads_text(  $wp_customize, 'ads_hero_sub',      'Sous-titre',               'Oud \u00b7 Arabesque \u00b7 Musc \u00b7 Andalous', 'ads_hero' );
    _ads_text(  $wp_customize, 'ads_hero_cta_text', 'Bouton CTA - Texte',       'D\u00e9couvrir',               'ads_hero' );
    _ads_text(  $wp_customize, 'ads_hero_cta_url',  'Bouton CTA - Lien',        '#collection',                 'ads_hero' );
    _ads_check( $wp_customize, 'ads_hero_cta_show', 'Afficher le bouton CTA',   '1',                           'ads_hero' );

    /* ==============================================================
       2. ANIMATION SCROLL - Infos flottantes
    ============================================================== */
    $wp_customize->add_section( 'ads_scroll_infos', array(
        'title'       => 'Animation Scroll - Infos flottantes',
        'description' => 'Les 3 blocs d\'info visibles pendant l\'animation.',
        'panel'       => 'ads_theme_panel',
    ) );
    $scroll_infos = array(
        'ads_scroll_left_label'   => 'Gauche - Label',
        'ads_scroll_left_value'   => 'Gauche - Valeur',
        'ads_scroll_left_sub1'    => 'Gauche - Ligne 1',
        'ads_scroll_left_sub2'    => 'Gauche - Ligne 2',
        'ads_scroll_right_label'  => 'Droite - Label',
        'ads_scroll_right_value'  => 'Droite - Valeur',
        'ads_scroll_right_sub1'   => 'Droite - Ligne 1',
        'ads_scroll_right_sub2'   => 'Droite - Ligne 2',
        'ads_scroll_bottom_label' => 'Bas - Label',
        'ads_scroll_bottom_value' => 'Bas - Valeur',
    );
    $scroll_defaults = array(
        'ads_scroll_left_label'   => 'Combustion',
        'ads_scroll_left_value'   => '2h \u00e0 5h',
        'ads_scroll_left_sub1'    => 'Diffusion lente',
        'ads_scroll_left_sub2'    => 'et continue',
        'ads_scroll_right_label'  => 'Mati\u00e8re premi\u00e8re',
        'ads_scroll_right_value'  => 'R\u00e9sine naturelle',
        'ads_scroll_right_sub1'   => 'Bois pr\u00e9cieux',
        'ads_scroll_right_sub2'   => 's\u00e9lectionn\u00e9',
        'ads_scroll_bottom_label' => 'Notes olfactives',
        'ads_scroll_bottom_value' => 'Oud \u00b7 Bois de Santal \u00b7 Ambre',
    );
    foreach ( $scroll_infos as $key => $label ) {
        _ads_text( $wp_customize, $key, $label, $scroll_defaults[$key], 'ads_scroll_infos' );
    }

    /* ==============================================================
       3. ANIMATION SCROLL - Phases
    ============================================================== */
    $wp_customize->add_section( 'ads_scroll_phases', array(
        'title'       => 'Animation Scroll - Phases',
        'description' => 'Les 3 textes successifs pendant le scroll.',
        'panel'       => 'ads_theme_panel',
    ) );
    $phases = array(
        1 => array(
            'tag'   => array( 'Phase 1 - Tag',   'I - L\'Allumage' ),
            'title' => array( 'Phase 1 - Titre', 'L\'instant du premier souffle' ),
            'body'  => array( 'Phase 1 - Texte', 'La braise s\'\u00e9veille. Un fil de fum\u00e9e s\'\u00e9l\u00e8ve, portant avec lui des si\u00e8cles de tradition olfactive orientale.' ),
        ),
        2 => array(
            'tag'   => array( 'Phase 2 - Tag',   'II - La Consumation' ),
            'title' => array( 'Phase 2 - Titre', 'Le temps qui parfume' ),
            'body'  => array( 'Phase 2 - Texte', 'Au fil des heures, le b\u00e2tonnet r\u00e9v\u00e8le ses couches olfactives.' ),
        ),
        3 => array(
            'tag'   => array( 'Phase 3 - Tag',   'III - L\'Empreinte' ),
            'title' => array( 'Phase 3 - Titre', 'Ce qui reste apr\u00e8s le silence' ),
            'body'  => array( 'Phase 3 - Texte', 'La fum\u00e9e s\'est dissip\u00e9e, mais le souvenir olfactif persiste.' ),
        ),
    );
    foreach ( $phases as $i => $parts ) {
        foreach ( $parts as $part => $data ) {
            _ads_text( $wp_customize, "ads_phase_{$i}_{$part}", $data[0], $data[1], 'ads_scroll_phases', ( $part === 'body' ? 'textarea' : 'text' ) );
        }
    }

    /* ==============================================================
       4. SECTION MISE EN AVANT PRODUIT
    ============================================================== */
    $wp_customize->add_section( 'ads_reveal', array(
        'title' => 'Section Mise en Avant Produit',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_text( $wp_customize, 'ads_reveal_title_l1',  'Titre ligne 1',                  'L\'Encens',       'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_title_l2',  'Titre ligne 2 (italique ambre)', 'Arabesque',       'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_desc',      'Texte descriptif',               'Notre encens le plus embl\u00e9matique.', 'ads_reveal', 'textarea' );
    _ads_text( $wp_customize, 'ads_reveal_btn1_text', 'Bouton 1 - Texte',               'Acheter',         'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn1_prix', 'Bouton 1 - Prix affich\u00e9',    '2 300 XOF',       'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn1_url',  'Bouton 1 - Lien',                '#',               'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn2_text', 'Bouton 2 - Texte',               'En savoir plus',  'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn2_url',  'Bouton 2 - Lien',                '#',               'ads_reveal' );
    for ( $i = 1; $i <= 5; $i++ ) {
        $def = array(
            1 => array( 'Dur\u00e9e de combustion', '2h30 continues' ),
            2 => array( 'Contenu', '10 b\u00e2tonnets' ),
            3 => array( 'Famille olfactive', 'Oriental \u00b7 Bois\u00e9 \u00b7 \u00c9pic\u00e9' ),
            4 => array( 'Origine', 'R\u00e9sines d\'Orient' ),
            5 => array( 'Livraison', 'Dakar & environs' ),
        );
        _ads_text( $wp_customize, "ads_reveal_spec_{$i}_label", "Spec {$i} - Label",  $def[$i][0], 'ads_reveal' );
        _ads_text( $wp_customize, "ads_reveal_spec_{$i}_value", "Spec {$i} - Valeur", $def[$i][1], 'ads_reveal' );
    }

    /* ==============================================================
       5. BANDEAU CITATION
    ============================================================== */
    $wp_customize->add_section( 'ads_quote', array(
        'title' => 'Bandeau Citation',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_check( $wp_customize, 'ads_quote_show', 'Afficher cette section', '1', 'ads_quote' );
    _ads_text(  $wp_customize, 'ads_quote_text', 'Texte de la citation', '\u00ab\u00a0Un parfum ne se voit pas, mais il se souvient.\u00a0\u00bb', 'ads_quote', 'textarea' );
    _ads_text(  $wp_customize, 'ads_quote_attr', 'Attribution', '\u2014 La Philosophie des Senteurs', 'ads_quote' );

    /* ==============================================================
       6. SECTION COLLECTION
    ============================================================== */
    $wp_customize->add_section( 'ads_collection', array(
        'title' => 'Section Collection',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_check( $wp_customize, 'ads_collection_show',     'Afficher cette section',   '1',             'ads_collection' );
    _ads_text(  $wp_customize, 'ads_collection_tag',      'Tag',                      'Nos Encens',    'ads_collection' );
    _ads_text(  $wp_customize, 'ads_collection_title',    'Titre',                    'La Collection', 'ads_collection' );
    _ads_text(  $wp_customize, 'ads_collection_cta_text', 'Bouton Tout voir - Texte', 'Tout voir',     'ads_collection' );
    _ads_text(  $wp_customize, 'ads_collection_cta_url',  'Bouton Tout voir - Lien',  '#',             'ads_collection' );
    $wp_customize->add_setting( 'ads_collection_nb', array( 'default' => 6, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'ads_collection_nb', array(
        'label'       => 'Nombre de produits affich\u00e9s',
        'section'     => 'ads_collection',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 3, 'max' => 12 ),
    ) );

    /* ==============================================================
       7. SECTION PHILOSOPHIE
    ============================================================== */
    $wp_customize->add_section( 'ads_philosophy', array(
        'title' => 'Section Philosophie',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_check( $wp_customize, 'ads_phi_show',  'Afficher cette section', '1', 'ads_philosophy' );
    _ads_text(  $wp_customize, 'ads_phi_tag',   'Tag',   'Notre Philosophie',                'ads_philosophy' );
    _ads_text(  $wp_customize, 'ads_phi_title', 'Titre', 'L\'encens comme rituel quotidien', 'ads_philosophy' );
    _ads_text(  $wp_customize, 'ads_phi_body',  'Texte', 'Chaque b\u00e2tonnet est un pont entre le pr\u00e9sent et l\'ancestral.', 'ads_philosophy', 'textarea' );
    for ( $i = 1; $i <= 4; $i++ ) {
        _ads_text( $wp_customize, "ads_phi_stat_{$i}_num",  "Stat {$i} - Chiffre",      '', 'ads_philosophy' );
        _ads_text( $wp_customize, "ads_phi_stat_{$i}_unit", "Stat {$i} - Unit\u00e9/Label",  '', 'ads_philosophy' );
        _ads_text( $wp_customize, "ads_phi_stat_{$i}_desc", "Stat {$i} - Description", '', 'ads_philosophy' );
    }

    /* ==============================================================
       8. SECTION NEWSLETTER
    ============================================================== */
    $wp_customize->add_section( 'ads_newsletter', array(
        'title' => 'Section Newsletter',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_check( $wp_customize, 'ads_nl_show',  'Afficher cette section', '1', 'ads_newsletter' );
    _ads_text(  $wp_customize, 'ads_nl_tag',   'Tag',          'Restez Inform\u00e9',                                                    'ads_newsletter' );
    _ads_text(  $wp_customize, 'ads_nl_title', 'Titre',        'La Lettre des Senteurs',                                                'ads_newsletter' );
    _ads_text(  $wp_customize, 'ads_nl_sub',   'Sous-titre',   'Nouvelles collections, \u00e9ditions limit\u00e9es et conseils olfactifs.', 'ads_newsletter', 'textarea' );
    _ads_text(  $wp_customize, 'ads_nl_btn',   'Texte bouton', 'S\'abonner',                                                             'ads_newsletter' );

    /* ==============================================================
       9. PAGE BOUTIQUE
    ============================================================== */
    $wp_customize->add_section( 'ads_shop', array(
        'title'       => 'Page Boutique (/shop)',
        'description' => 'Textes du hero et des elements de la page boutique principale.',
        'panel'       => 'ads_theme_panel',
    ) );
    _ads_text(  $wp_customize, 'ads_shop_tag',            'Hero - Tag',                   'Notre S\u00e9lection',  'ads_shop' );
    _ads_text(  $wp_customize, 'ads_shop_title_l1',       'Hero - Titre ligne 1',         'La Boutique',          'ads_shop' );
    _ads_text(  $wp_customize, 'ads_shop_title_l2',       'Hero - Titre ligne 2 (ambre)', 'Alchimie',             'ads_shop' );
    _ads_text(  $wp_customize, 'ads_shop_sub',            'Hero - Sous-titre',            'Encens, r\u00e9sines et accessoires s\u00e9lectionn\u00e9s pour leur authenticit\u00e9 et leur intensit\u00e9 olfactive.', 'ads_shop', 'textarea' );
    _ads_text(  $wp_customize, 'ads_shop_editorial_label','Case editoriale - Label',      'La philosophie',       'ads_shop' );
    _ads_text(  $wp_customize, 'ads_shop_editorial',      'Case editoriale - Citation',   '\u00ab L\'encens comme rituel. \u00bb', 'ads_shop', 'textarea' );
    _ads_text(  $wp_customize, 'ads_shop_card_btn',       'Bouton sur chaque carte',      'Voir',                 'ads_shop' );
    _ads_text(  $wp_customize, 'ads_shop_empty',          'Message si aucun produit',     'Aucun produit trouv\u00e9.', 'ads_shop' );
    _ads_color( $wp_customize, 'ads_shop_hero_bg',        'Hero - Couleur de fond',       '#1a1714',              'ads_shop' );

    /* ==============================================================
       10. PAGES CATEGORIES
    ============================================================== */
    $wp_customize->add_section( 'ads_cat_defaults', array(
        'title'       => 'Pages Categories - Defauts',
        'description' => 'Ces textes s\'appliquent a toutes les categories sans reglages specifiques.',
        'panel'       => 'ads_theme_panel',
    ) );
    _ads_text( $wp_customize, 'ads_cat_default_tag',      'Tag generique',            'Collection',                                       'ads_cat_defaults' );
    _ads_text( $wp_customize, 'ads_cat_default_ed_label', 'Case editoriale - Label',  'La selection',                                     'ads_cat_defaults' );
    _ads_text( $wp_customize, 'ads_cat_default_ed_text',  'Case editoriale - Citation','\u00ab Chaque forme, une exp\u00e9rience olfactive unique. \u00bb', 'ads_cat_defaults', 'textarea' );

    $known_cats = array(
        'batonnets' => array(
            'label'   => 'Cat\u00e9gorie - B\u00e2tonnets',
            'tag_def' => 'Collection B\u00e2tonnets',
            'sub_def' => 'Nos encens en b\u00e2tonnets : une combustion lente, une diffusion continuelle. Le format traditionnel par excellence.',
            'ed_lbl'  => 'Le classique',
            'ed_txt'  => '\u00ab Le b\u00e2tonnet d\'encens, g\u00e9n\u00e9ration apr\u00e8s g\u00e9n\u00e9ration. \u00bb',
        ),
        'cones' => array(
            'label'   => 'Cat\u00e9gorie - C\u00f4nes',
            'tag_def' => 'Collection C\u00f4nes',
            'sub_def' => 'Nos encens en c\u00f4nes : une combustion concentr\u00e9e, une diffusion intense et enveloppante.',
            'ed_lbl'  => 'L\'intensit\u00e9',
            'ed_txt'  => '\u00ab Le c\u00f4ne concentre toute la puissance du parfum. \u00bb',
        ),
    );
    foreach ( $known_cats as $slug => $cfg ) {
        $sec = 'ads_cat_' . $slug;
        $wp_customize->add_section( $sec, array(
            'title'       => $cfg['label'],
            'description' => 'Personnalise /product-category/' . $slug . '/',
            'panel'       => 'ads_theme_panel',
        ) );
        _ads_text( $wp_customize, 'ads_cat_'.$slug.'_tag',      'Tag dans le hero',           $cfg['tag_def'], $sec );
        _ads_text( $wp_customize, 'ads_cat_'.$slug.'_sub',      'Sous-titre du hero',         $cfg['sub_def'], $sec, 'textarea' );
        _ads_text( $wp_customize, 'ads_cat_'.$slug.'_ed_label', 'Case editoriale - Label',    $cfg['ed_lbl'],  $sec );
        _ads_text( $wp_customize, 'ads_cat_'.$slug.'_ed_text',  'Case editoriale - Citation', $cfg['ed_txt'],  $sec, 'textarea' );
    }

    /* ==============================================================
       11. PAGE CONTACT
    ============================================================== */
    $wp_customize->add_section( 'ads_contact', array(
        'title'       => 'Page Contact',
        'description' => 'Informations affichees dans la page Contact.',
        'panel'       => 'ads_theme_panel',
    ) );
    $contact_fields = array(
        'ads_contact_hero_tag'   => array( 'Hero - Tag',                        'Nous Contacter'                    ),
        'ads_contact_hero_title' => array( 'Hero - Titre ligne 1',              'Une question ?' ),
        'ads_contact_hero_em'    => array( 'Hero - Titre ligne 2 (italique)',   'Parlons-en.'                       ),
        'ads_contact_hero_sub'   => array( 'Hero - Sous-titre',                 'Notre equipe est disponible du lundi au samedi, de 9h a 18h.' ),
        'ads_contact_adresse'    => array( 'Adresse',                           'Dakar, S\u00e9n\u00e9gal'          ),
        'ads_contact_whatsapp'   => array( 'Lien WhatsApp (https://wa.me/...)', 'https://wa.me/221776440125'        ),
        'ads_contact_wa_label'   => array( 'WhatsApp - Texte affiche',          '+221 77 644 01 25'                 ),
        'ads_contact_email'      => array( 'Email de contact',                  'contact@alchimie-des-senteurs.sn'  ),
        'ads_contact_horaires'   => array( 'Horaires',                          'Lun - Sam : 9h a 18h'              ),
        'ads_contact_form_tag'   => array( 'Formulaire - Tag',                  'Formulaire'                        ),
        'ads_contact_form_title' => array( 'Formulaire - Titre ligne 1',        'Envoyez-nous'                      ),
        'ads_contact_form_em'    => array( 'Formulaire - Titre ligne 2',        'un message'                        ),
        'ads_contact_form_sub'   => array( 'Formulaire - Sous-titre',           'Nous vous repondons sous 24h.'     ),
    );
    foreach ( $contact_fields as $key => $data ) {
        $type = in_array( $key, array( 'ads_contact_hero_sub', 'ads_contact_form_sub' ), true ) ? 'textarea' : 'text';
        _ads_text( $wp_customize, $key, $data[0], $data[1], 'ads_contact', $type );
    }

    /* ==============================================================
       12. FOOTER
    ============================================================== */
    $wp_customize->add_section( 'ads_footer', array(
        'title' => 'Footer',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_text( $wp_customize, 'ads_footer_brand', 'Nom de marque',              'Alchimie des Senteurs',              'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_sub',   'Sous-titre marque',           'Maison d\'Encens \u00b7 Dakar',      'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_about', 'Texte de presentation',       'Depuis Dakar, nous apportons les fragrances les plus authentiques d\'Orient dans vos foyers.', 'ads_footer', 'textarea' );
    _ads_text( $wp_customize, 'ads_footer_wa',    'Lien WhatsApp',               'https://wa.me/221776440125',         'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_insta', 'Lien Instagram',              '#',                                  'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_fb',    'Lien Facebook',               '#',                                  'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_copy',  'Texte copyright',             '\u00a9 2026 Alchimie des Senteurs \u00b7 Dakar, S\u00e9n\u00e9gal', 'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_pay',   'Moyens de paiement (virgule)','Orange Money,Wave,Carte',            'ads_footer' );

    /* ==============================================================
       13. NUMERO DE TELEPHONE
    ============================================================== */
    $wp_customize->add_section( 'ads_phone', array(
        'title'       => '\ud83d\udcf1 Num\u00e9ro de T\u00e9l\u00e9phone',
        'description' => 'G\u00e9rez le num\u00e9ro WhatsApp affich\u00e9 sur le site et activez/d\u00e9sactivez son affichage page par page.',
        'panel'       => 'ads_theme_panel',
        'priority'    => 200,
    ) );
    _ads_text( $wp_customize, 'ads_phone_number', 'Num\u00e9ro affich\u00e9',          '+221 77 644 01 25',           'ads_phone' );
    _ads_text( $wp_customize, 'ads_phone_link',   'Lien (https://wa.me/...)',     'https://wa.me/221776440125',  'ads_phone' );

    $phone_locations = array(
        'ads_phone_show_cart'     => 'Afficher dans le Panier',
        'ads_phone_show_checkout' => 'Afficher dans le Checkout',
        'ads_phone_show_contact'  => 'Afficher dans la page Contact',
        'ads_phone_show_footer'   => 'Afficher dans le Footer',
        'ads_phone_show_header'   => 'Afficher dans le Header',
        'ads_phone_show_product'  => 'Afficher sur les pages Produit',
    );
    foreach ( $phone_locations as $key => $label ) {
        _ads_check( $wp_customize, $key, $label, '1', 'ads_phone' );
    }
}
add_action( 'customize_register', 'ads_customizer_register' );

/* ================================================================
   HELPER GLOBAL : ads_phone()
================================================================ */
function ads_phone( $location, $class = '' ) {
    $show = get_theme_mod( 'ads_phone_show_' . $location, '1' );
    if ( ! $show ) return;

    $number = get_theme_mod( 'ads_phone_number', '+221 77 644 01 25' );
    $link   = get_theme_mod( 'ads_phone_link',   'https://wa.me/221776440125' );
    if ( ! $number ) return;

    $cls = 'ads-phone-block' . ( $class ? ' ' . esc_attr( $class ) : '' );

    $wa_icon = '<svg class="ads-wa-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">'
        . '<path fill="#25D366" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>'
        . '<path fill="#25D366" d="M12 0C5.373 0 0 5.373 0 12c0 2.117.554 4.103 1.523 5.828L.057 23.57a.75.75 0 0 0 .92.919l5.8-1.453A11.95 11.95 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 0 1-5.006-1.373l-.36-.214-3.713.929.959-3.629-.235-.374A9.818 9.818 0 1 1 12 21.818z"/>'
        . '</svg>';

    echo '<a href="' . esc_url( $link ) . '" class="' . esc_attr( $cls ) . '" target="_blank" rel="noopener">';
    echo $wa_icon;
    echo '<span class="ads-wa-label">WhatsApp</span>';
    echo '<span class="ads-wa-number">' . esc_html( $number ) . '</span>';
    echo '</a>';
}

/* ================================================================
   PREVIEW LIVE (postMessage)
================================================================ */
function ads_customizer_preview() { ?>
<script id="ads-customizer-preview">
(function($){
    'use strict';
    function cssVar(n, v) { document.documentElement.style.setProperty(n, v); }
    function txt(id, sel) {
        wp.customize(id, function(v){ v.bind(function(val){
            document.querySelectorAll(sel).forEach(function(el){ el.innerHTML = val; });
        }); });
    }
    function tog(id, sel) {
        wp.customize(id, function(v){ v.bind(function(val){
            document.querySelectorAll(sel).forEach(function(el){
                el.style.display = val ? '' : 'none';
            });
        }); });
    }
    wp.customize('ads_color_ink',     function(v){ v.bind(function(val){ cssVar('--ink',val); }); });
    wp.customize('ads_color_amber',   function(v){ v.bind(function(val){ cssVar('--amber',val); }); });
    wp.customize('ads_color_amber_l', function(v){ v.bind(function(val){ cssVar('--amber-l',val); }); });
    wp.customize('ads_color_stone',   function(v){ v.bind(function(val){ cssVar('--stone',val); }); });
    wp.customize('ads_color_off',     function(v){ v.bind(function(val){ cssVar('--off',val); }); });
    wp.customize('ads_color_mid',     function(v){ v.bind(function(val){ cssVar('--mid',val); }); });
    wp.customize('ads_color_white',   function(v){ v.bind(function(val){ cssVar('--white',val); }); });
    wp.customize('ads_shop_hero_bg',  function(v){ v.bind(function(val){
        var h = document.querySelector('.shop-hero'); if(h) h.style.background = val;
    }); });
    txt('ads_hero_tag', '.ov-tag');
    txt('ads_hero_sub', '.ov-sub');
    txt('ads_shop_tag',             '.shop-hero-tag');
    txt('ads_shop_sub',             '.shop-hero-sub');
    txt('ads_shop_editorial_label', '.shop-editorial-label');
    txt('ads_shop_editorial',       '.shop-editorial-text');
    txt('ads_cat_batonnets_tag',      '.cat-batonnets .shop-hero-tag');
    txt('ads_cat_batonnets_sub',      '.cat-batonnets .shop-hero-sub');
    txt('ads_cat_batonnets_ed_label', '.cat-batonnets .shop-editorial-label');
    txt('ads_cat_batonnets_ed_text',  '.cat-batonnets .shop-editorial-text');
    txt('ads_cat_cones_tag',          '.cat-cones .shop-hero-tag');
    txt('ads_cat_cones_sub',          '.cat-cones .shop-hero-sub');
    txt('ads_cat_cones_ed_label',     '.cat-cones .shop-editorial-label');
    txt('ads_cat_cones_ed_text',      '.cat-cones .shop-editorial-text');
    txt('ads_nl_tag',   '.nl-tag');
    txt('ads_nl_title', '.nl-title');
    txt('ads_nl_sub',   '.nl-sub');
    txt('ads_nl_btn',   '.nl-form button');
    txt('ads_footer_brand', '.f-brand');
    txt('ads_footer_sub',   '.f-sub');
    txt('ads_footer_about', '.f-about');
    txt('ads_footer_copy',  '.f-copy');
    tog('ads_phone_show_cart',    '.cart-wrap .ads-phone-block');
    tog('ads_phone_show_footer',  '.site-footer .ads-phone-block');
    tog('ads_phone_show_header',  '.site-header .ads-phone-block');
    tog('ads_phone_show_contact', '.contact-wrap .ads-phone-block');
    tog('ads_phone_show_product', '.product-wrap .ads-phone-block');
})(jQuery);
</script>
<?php }
add_action( 'customize_preview_init', function(){
    add_action( 'wp_footer', 'ads_customizer_preview' );
} );

/* ================================================================
   OUTPUT CSS
================================================================ */
function ads_customizer_css() {
    $ink     = get_theme_mod( 'ads_color_ink',     '#1a1714' );
    $amber   = get_theme_mod( 'ads_color_amber',   '#c4873a' );
    $amber_l = get_theme_mod( 'ads_color_amber_l', '#e0a85a' );
    $stone   = get_theme_mod( 'ads_color_stone',   '#9a9088' );
    $off     = get_theme_mod( 'ads_color_off',     '#f8f6f3' );
    $mid     = get_theme_mod( 'ads_color_mid',     '#e0d8cc' );
    $white   = get_theme_mod( 'ads_color_white',   '#ffffff' );
    $shop_bg = get_theme_mod( 'ads_shop_hero_bg',  '#1a1714' );
    $vals    = compact( 'ink', 'amber', 'amber_l', 'stone', 'off', 'mid', 'white' );
    $defs    = array( 'ink'=>'#1a1714','amber'=>'#c4873a','amber_l'=>'#e0a85a','stone'=>'#9a9088','off'=>'#f8f6f3','mid'=>'#e0d8cc','white'=>'#ffffff' );
    $custom  = false;
    foreach ( $defs as $k => $d ) { if ( $vals[$k] !== $d ) { $custom = true; break; } }
    ?>
    <style id="ads-custom-css">
    <?php if ( $custom || $shop_bg !== '#1a1714' ) : ?>
    :root {
        --ink:     <?php echo sanitize_hex_color($ink); ?>;
        --amber:   <?php echo sanitize_hex_color($amber); ?>;
        --amber-l: <?php echo sanitize_hex_color($amber_l); ?>;
        --stone:   <?php echo sanitize_hex_color($stone); ?>;
        --off:     <?php echo sanitize_hex_color($off); ?>;
        --mid:     <?php echo sanitize_hex_color($mid); ?>;
        --white:   <?php echo sanitize_hex_color($white); ?>;
    }
    <?php endif; ?>
    <?php if ( $shop_bg !== '#1a1714' ) : ?>
    .shop-hero { background: <?php echo sanitize_hex_color($shop_bg); ?> !important; }
    <?php endif; ?>
    /* Bouton WhatsApp */
    .ads-phone-block {
        display:         inline-flex;
        align-items:     center;
        gap:             0.5rem;
        padding:         0.35rem 0.75rem 0.35rem 0.5rem;
        border:          1px solid #25D36640;
        border-radius:   999px;
        background:      #25D36610;
        text-decoration: none;
        color:           var(--stone, #9a9088);
        font-size:       0.72rem;
        line-height:     1;
        transition:      background 0.2s, border-color 0.2s;
    }
    .ads-phone-block:hover {
        background:   #25D36620;
        border-color: #25D366;
    }
    .ads-wa-icon   { flex-shrink: 0; display: block; }
    .ads-wa-label  {
        font-weight:    600;
        color:          #25D366;
        letter-spacing: 0.02em;
        font-size:      0.7rem;
    }
    .ads-wa-number {
        letter-spacing: 0.04em;
        color:          var(--stone, #9a9088);
    }
    </style>
    <?php
}
add_action( 'wp_head', 'ads_customizer_css' );
