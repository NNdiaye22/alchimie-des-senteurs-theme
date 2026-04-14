<?php
/**
 * Customizer — Alchimie des Senteurs
 * Apparence → Personnaliser → Alchimie des Senteurs
 *
 * Sections :
 *   0. Couleurs Globales
 *   1. Hero
 *   2. Animation Scroll — Infos
 *   3. Animation Scroll — Phases
 *   4. Section Mise en Avant (Reveal)
 *   5. Bandeau Citation
 *   6. Section Collection
 *   7. Section Philosophie
 *   8. Section Newsletter
 *   9. Page Boutique
 *  10. Pages Catégories
 *  11. Page Contact
 *  12. Footer
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
        'description' => 'Ces couleurs s’appliquent sur tout le site.',
        'panel'       => 'ads_theme_panel',
        'priority'    => 1,
    ) );
    _ads_color( $wp_customize, 'ads_color_ink',     'Couleur principale (fond sombre / texte)', '#1a1714', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_amber',   'Couleur accent (ambre / doré)',           '#c4873a', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_amber_l', 'Couleur accent claire',                    '#e0a85a', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_stone',   'Texte secondaire (gris)',                  '#9a9088', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_off',     'Fond décalé (sections alternées)',         '#f8f6f3', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_mid',     'Bordures / séparateurs',                  '#e0d8cc', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_white',   'Fond blanc',                               '#ffffff', 'ads_colors' );

    /* ==============================================================
       1. HERO
    ============================================================== */
    $wp_customize->add_section( 'ads_hero', array(
        'title' => 'Hero — Section principale',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_text( $wp_customize, 'ads_hero_tag',      'Tag au-dessus du titre',   "Maison d'Encens \u00b7 Dakar", 'ads_hero' );
    _ads_text( $wp_customize, 'ads_hero_title_l1', 'Titre ligne 1',            "L'Encens",                'ads_hero' );
    _ads_text( $wp_customize, 'ads_hero_title_l2', 'Titre ligne 2 (italique)', 'Vivant',                  'ads_hero' );
    _ads_text( $wp_customize, 'ads_hero_sub',      'Sous-titre',               'Oud \u00b7 Arabesque \u00b7 Musc \u00b7 Andalous', 'ads_hero' );
    _ads_text( $wp_customize, 'ads_hero_cta_text', 'Bouton CTA \u2014 Texte',       'D\u00e9couvrir',               'ads_hero' );
    _ads_text( $wp_customize, 'ads_hero_cta_url',  'Bouton CTA \u2014 Lien',        '#collection',             'ads_hero' );
    _ads_check( $wp_customize, 'ads_hero_cta_show', 'Afficher le bouton CTA',  '1',                        'ads_hero' );

    /* ==============================================================
       2. ANIMATION SCROLL — Infos flottantes
    ============================================================== */
    $wp_customize->add_section( 'ads_scroll_infos', array(
        'title'       => 'Animation Scroll \u2014 Infos flottantes',
        'description' => 'Les 3 blocs d’info visibles pendant l’animation.',
        'panel'       => 'ads_theme_panel',
    ) );
    $scroll_infos = array(
        'ads_scroll_left_label'   => 'Gauche \u2014 Label',
        'ads_scroll_left_value'   => 'Gauche \u2014 Valeur',
        'ads_scroll_left_sub1'    => 'Gauche \u2014 Ligne 1',
        'ads_scroll_left_sub2'    => 'Gauche \u2014 Ligne 2',
        'ads_scroll_right_label'  => 'Droite \u2014 Label',
        'ads_scroll_right_value'  => 'Droite \u2014 Valeur',
        'ads_scroll_right_sub1'   => 'Droite \u2014 Ligne 1',
        'ads_scroll_right_sub2'   => 'Droite \u2014 Ligne 2',
        'ads_scroll_bottom_label' => 'Bas \u2014 Label',
        'ads_scroll_bottom_value' => 'Bas \u2014 Valeur',
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
       3. ANIMATION SCROLL — Phases
    ============================================================== */
    $wp_customize->add_section( 'ads_scroll_phases', array(
        'title'       => 'Animation Scroll \u2014 Phases',
        'description' => 'Les 3 textes successifs pendant le scroll.',
        'panel'       => 'ads_theme_panel',
    ) );
    $phases = array(
        1 => array(
            'tag'   => array( 'Phase 1 \u2014 Tag',   "I \u2014 L\u2019Allumage" ),
            'title' => array( 'Phase 1 \u2014 Titre', "L\u2019instant du premier souffle" ),
            'body'  => array( 'Phase 1 \u2014 Texte', 'La braise s\u2019\u00e9veille. Un fil de fum\u00e9e s\u2019\u00e9l\u00e8ve, portant avec lui des si\u00e8cles de tradition olfactive orientale.' ),
        ),
        2 => array(
            'tag'   => array( 'Phase 2 \u2014 Tag',   'II \u2014 La Consumation' ),
            'title' => array( 'Phase 2 \u2014 Titre', 'Le temps qui parfume' ),
            'body'  => array( 'Phase 2 \u2014 Texte', 'Au fil des heures, le b\u00e2tonnet r\u00e9v\u00e8le ses couches olfactives.' ),
        ),
        3 => array(
            'tag'   => array( 'Phase 3 \u2014 Tag',   "III \u2014 L\u2019Empreinte" ),
            'title' => array( 'Phase 3 \u2014 Titre', 'Ce qui reste apr\u00e8s le silence' ),
            'body'  => array( 'Phase 3 \u2014 Texte', 'La fum\u00e9e s\u2019est dissip\u00e9e, mais le souvenir olfactif persiste.' ),
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
        'title'       => 'Section Mise en Avant Produit',
        'panel'       => 'ads_theme_panel',
    ) );
    _ads_text( $wp_customize, 'ads_reveal_title_l1',  'Titre ligne 1',                  "L'Encens",       'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_title_l2',  'Titre ligne 2 (italique ambre)', 'Arabesque',      'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_desc',      'Texte descriptif',               'Notre encens le plus embl\u00e9matique.', 'ads_reveal', 'textarea' );
    _ads_text( $wp_customize, 'ads_reveal_btn1_text', 'Bouton 1 \u2014 Texte',              'Acheter',        'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn1_prix', 'Bouton 1 \u2014 Prix affich\u00e9',       '2\u00a0300 XOF',    'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn1_url',  'Bouton 1 \u2014 Lien',              '#',              'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn2_text', 'Bouton 2 \u2014 Texte',              'En savoir plus', 'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn2_url',  'Bouton 2 \u2014 Lien',              '#',              'ads_reveal' );
    for ( $i = 1; $i <= 5; $i++ ) {
        $def = array(
            1 => array( 'Dur\u00e9e de combustion', '2h30 continues' ),
            2 => array( 'Contenu', '10 b\u00e2tonnets' ),
            3 => array( 'Famille olfactive', 'Oriental \u00b7 Bois\u00e9 \u00b7 \u00c9pic\u00e9' ),
            4 => array( 'Origine', "R\u00e9sines d'Orient" ),
            5 => array( 'Livraison', 'Dakar & environs' ),
        );
        _ads_text( $wp_customize, "ads_reveal_spec_{$i}_label", "Spec {$i} \u2014 Label", $def[$i][0], 'ads_reveal' );
        _ads_text( $wp_customize, "ads_reveal_spec_{$i}_value", "Spec {$i} \u2014 Valeur", $def[$i][1], 'ads_reveal' );
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
    _ads_check( $wp_customize, 'ads_collection_show',     'Afficher cette section',         '1',            'ads_collection' );
    _ads_text(  $wp_customize, 'ads_collection_tag',      'Tag',                            'Nos Encens',   'ads_collection' );
    _ads_text(  $wp_customize, 'ads_collection_title',    'Titre',                          'La Collection','ads_collection' );
    _ads_text(  $wp_customize, 'ads_collection_cta_text', 'Bouton \u00ab\u00a0Tout voir\u00a0\u00bb \u2014 Texte', 'Tout voir', 'ads_collection' );
    _ads_text(  $wp_customize, 'ads_collection_cta_url',  'Bouton \u00ab\u00a0Tout voir\u00a0\u00bb \u2014 Lien',  '#',         'ads_collection' );
    $wp_customize->add_setting( 'ads_collection_nb', array( 'default' => 6, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'ads_collection_nb', array(
        'label' => 'Nombre de produits affich\u00e9s', 'section' => 'ads_collection', 'type' => 'number',
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
    _ads_text(  $wp_customize, 'ads_phi_tag',   'Tag',   'Notre Philosophie',              'ads_philosophy' );
    _ads_text(  $wp_customize, 'ads_phi_title', 'Titre', "L'encens comme rituel quotidien",'ads_philosophy' );
    _ads_text(  $wp_customize, 'ads_phi_body',  'Texte', "Chaque b\u00e2tonnet est un pont entre le pr\u00e9sent et l'ancestral.", 'ads_philosophy', 'textarea' );
    for ( $i = 1; $i <= 4; $i++ ) {
        _ads_text( $wp_customize, "ads_phi_stat_{$i}_num",  "Stat {$i} \u2014 Chiffre",      '', 'ads_philosophy' );
        _ads_text( $wp_customize, "ads_phi_stat_{$i}_unit", "Stat {$i} \u2014 Unit\u00e9/Label",  '', 'ads_philosophy' );
        _ads_text( $wp_customize, "ads_phi_stat_{$i}_desc", "Stat {$i} \u2014 Description", '', 'ads_philosophy' );
    }

    /* ==============================================================
       8. SECTION NEWSLETTER
    ============================================================== */
    $wp_customize->add_section( 'ads_newsletter', array(
        'title' => 'Section Newsletter',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_check( $wp_customize, 'ads_nl_show',  'Afficher cette section', '1',                                              'ads_newsletter' );
    _ads_text(  $wp_customize, 'ads_nl_tag',   'Tag',         'Restez Inform\u00e9',                                 'ads_newsletter' );
    _ads_text(  $wp_customize, 'ads_nl_title', 'Titre',       'La Lettre des Senteurs',                         'ads_newsletter' );
    _ads_text(  $wp_customize, 'ads_nl_sub',   'Sous-titre',  'Nouvelles collections, \u00e9ditions limit\u00e9es et conseils olfactifs.', 'ads_newsletter', 'textarea' );
    _ads_text(  $wp_customize, 'ads_nl_btn',   'Texte bouton',"S'abonner",                                      'ads_newsletter' );

    /* ==============================================================
       9. PAGE BOUTIQUE
    ============================================================== */
    $wp_customize->add_section( 'ads_shop', array(
        'title'       => 'Page Boutique (/shop)',
        'description' => 'Textes du hero et des \u00e9l\u00e9ments de la page boutique principale.',
        'panel'       => 'ads_theme_panel',
    ) );
    _ads_text( $wp_customize, 'ads_shop_tag',      'Hero \u2014 Tag',                   'Notre S\u00e9lection', 'ads_shop' );
    _ads_text( $wp_customize, 'ads_shop_title_l1', 'Hero \u2014 Titre ligne 1',         'La Boutique',       'ads_shop' );
    _ads_text( $wp_customize, 'ads_shop_title_l2', 'Hero \u2014 Titre ligne 2 (ambre)', 'Alchimie',          'ads_shop' );
    _ads_text( $wp_customize, 'ads_shop_sub',      'Hero \u2014 Sous-titre',            'Encens, r\u00e9sines et accessoires s\u00e9lectionn\u00e9s pour leur authenticit\u00e9 et leur intensit\u00e9 olfactive.', 'ads_shop', 'textarea' );
    _ads_text( $wp_customize, 'ads_shop_editorial_label', 'Case \u00e9ditoriale \u2014 Label',    'La philosophie',             'ads_shop' );
    _ads_text( $wp_customize, 'ads_shop_editorial',       'Case \u00e9ditoriale \u2014 Citation', '\u00ab\u00a0L\u2019encens comme rituel.\u00a0\u00bb', 'ads_shop', 'textarea' );
    _ads_text( $wp_customize, 'ads_shop_card_btn',        'Bouton sur chaque carte',       'Voir',             'ads_shop' );
    _ads_text( $wp_customize, 'ads_shop_empty',           'Message si aucun produit',      'Aucun produit trouv\u00e9.', 'ads_shop' );
    _ads_color( $wp_customize, 'ads_shop_hero_bg',        'Hero \u2014 Couleur de fond',       '#1a1714', 'ads_shop' );

    /* ==============================================================
       10. PAGES CATEGORIES
       Un sous-panneau par categorie connue + textes par defaut
    ============================================================== */
    $wp_customize->add_section( 'ads_cat_defaults', array(
        'title'       => 'Pages Cat\u00e9gories \u2014 D\u00e9fauts',
        'description' => 'Ces textes s\u2019appliquent \u00e0 TOUTES les cat\u00e9gories qui n\u2019ont pas de r\u00e9glages sp\u00e9cifiques.\nIls servent aussi de mod\u00e8le pour les nouvelles cat\u00e9gories que vous cr\u00e9erez.',
        'panel'       => 'ads_theme_panel',
    ) );
    _ads_text( $wp_customize, 'ads_cat_default_tag',      'Tag g\u00e9n\u00e9rique',                    'Collection',                                         'ads_cat_defaults' );
    _ads_text( $wp_customize, 'ads_cat_default_ed_label', 'Case \u00e9ditoriale \u2014 Label',           'La s\u00e9lection',                                        'ads_cat_defaults' );
    _ads_text( $wp_customize, 'ads_cat_default_ed_text',  'Case \u00e9ditoriale \u2014 Citation',        '\u00ab\u00a0Chaque forme, une exp\u00e9rience olfactive unique.\u00a0\u00bb', 'ads_cat_defaults', 'textarea' );

    // --- Categories connues : Batonnets + Cones ---
    // Chaque bloc : tag, sous-titre hero, case editoriale label + texte
    $known_cats = array(
        'batonnets' => array(
            'label'    => 'Cat\u00e9gorie \u2014 B\u00e2tonnets',
            'tag_def'  => 'Collection B\u00e2tonnets',
            'sub_def'  => 'Nos encens en b\u00e2tonnets : une combustion lente, une diffusion continuelle. Le format traditionnel par excellence.',
            'ed_lbl'   => 'Le classique',
            'ed_txt'   => '\u00ab\u00a0Le b\u00e2tonnet d\u2019encens, g\u00e9n\u00e9ration apr\u00e8s g\u00e9n\u00e9ration.\u00a0\u00bb',
        ),
        'cones'     => array(
            'label'    => 'Cat\u00e9gorie \u2014 C\u00f4nes',
            'tag_def'  => 'Collection C\u00f4nes',
            'sub_def'  => 'Nos enc\u00e9s en c\u00f4nes : une combustion concentr\u00e9e, une diffusion intense et enveloppante. Parfait pour les grands espaces.',
            'ed_lbl'   => 'L\u2019intensit\u00e9',
            'ed_txt'   => '\u00ab\u00a0Le c\u00f4ne concentre toute la puissance du parfum.\u00a0\u00bb',
        ),
    );

    foreach ( $known_cats as $slug => $cfg ) {
        $sec = 'ads_cat_' . $slug;
        $wp_customize->add_section( $sec, array(
            'title'       => $cfg['label'],
            'description' => 'Personnalise le hero de la page /product-category/' . $slug . '/\nSi vide, le tag et la citation g\u00e9n\u00e9rique s\u2019appliquent.',
            'panel'       => 'ads_theme_panel',
        ) );
        _ads_text( $wp_customize, 'ads_cat_'.$slug.'_tag',      'Tag dans le hero',               $cfg['tag_def'], $sec );
        _ads_text( $wp_customize, 'ads_cat_'.$slug.'_sub',      'Sous-titre du hero',             $cfg['sub_def'], $sec, 'textarea' );
        _ads_text( $wp_customize, 'ads_cat_'.$slug.'_ed_label', 'Case \u00e9ditoriale \u2014 Label',     $cfg['ed_lbl'],  $sec );
        _ads_text( $wp_customize, 'ads_cat_'.$slug.'_ed_text',  'Case \u00e9ditoriale \u2014 Citation',  $cfg['ed_txt'],  $sec, 'textarea' );
    }

    /* ==============================================================
       11. PAGE CONTACT
    ============================================================== */
    $wp_customize->add_section( 'ads_contact', array(
        'title'       => 'Page Contact',
        'description' => 'Informations affich\u00e9es dans la page Contact.',
        'panel'       => 'ads_theme_panel',
    ) );
    $contact_fields = array(
        'ads_contact_hero_tag'   => array( 'Hero \u2014 Tag',                            'Nous Contacter'                    ),
        'ads_contact_hero_title' => array( 'Hero \u2014 Titre ligne 1',                  'Une question\u00a0?'                   ),
        'ads_contact_hero_em'    => array( 'Hero \u2014 Titre ligne 2 (italique)',       'Parlons-en.'                       ),
        'ads_contact_hero_sub'   => array( 'Hero \u2014 Sous-titre',                     'Notre \u00e9quipe est disponible du lundi au samedi, de 9h \u00e0 18h.' ),
        'ads_contact_adresse'    => array( 'Adresse',                                'Dakar, S\u00e9n\u00e9gal'                    ),
        'ads_contact_whatsapp'   => array( 'Lien WhatsApp (https://wa.me/...)',      'https://wa.me/221776440125'        ),
        'ads_contact_wa_label'   => array( 'WhatsApp \u2014 Texte affich\u00e9',              '+221 77 644 01 25'                 ),
        'ads_contact_email'      => array( 'Email de contact',                      'contact@alchimie-des-senteurs.sn'  ),
        'ads_contact_horaires'   => array( 'Horaires',                               'Lun \u2014 Sam\u00a0: 9h \u00e0 18h'              ),
        'ads_contact_form_tag'   => array( 'Formulaire \u2014 Tag',                      'Formulaire'                        ),
        'ads_contact_form_title' => array( 'Formulaire \u2014 Titre ligne 1',            'Envoyez-nous'                      ),
        'ads_contact_form_em'    => array( 'Formulaire \u2014 Titre ligne 2 (italique)', 'un message'                        ),
        'ads_contact_form_sub'   => array( 'Formulaire \u2014 Sous-titre',               'Nous vous r\u00e9pondons sous 24h.'     ),
    );
    foreach ( $contact_fields as $key => $data ) {
        $type = in_array( $key, array('ads_contact_hero_sub','ads_contact_form_sub'), true ) ? 'textarea' : 'text';
        _ads_text( $wp_customize, $key, $data[0], $data[1], 'ads_contact', $type );
    }

    /* ==============================================================
       12. FOOTER
    ============================================================== */
    $wp_customize->add_section( 'ads_footer', array(
        'title' => 'Footer',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_text( $wp_customize, 'ads_footer_brand', 'Nom de marque',               'Alchimie des Senteurs',       'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_sub',   'Sous-titre marque',            "Maison d'Encens \u00b7 Dakar",    'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_about', 'Texte de pr\u00e9sentation',        "Depuis Dakar, nous apportons les fragrances les plus authentiques d'Orient dans vos foyers.", 'ads_footer', 'textarea' );
    _ads_text( $wp_customize, 'ads_footer_wa',    'Lien WhatsApp',                'https://wa.me/221776440125',  'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_insta', 'Lien Instagram',               '#',                          'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_fb',    'Lien Facebook',                '#',                          'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_copy',  'Texte copyright',              '\u00a9 2026 Alchimie des Senteurs \u00b7 Dakar, S\u00e9n\u00e9gal', 'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_pay',   'Moyens de paiement (virgule)', 'Orange Money,Wave,Carte',     'ads_footer' );
}
add_action( 'customize_register', 'ads_customizer_register' );

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
    // Textes homepage
    txt('ads_hero_tag', '.ov-tag');
    txt('ads_hero_sub', '.ov-sub');
    // Boutique
    txt('ads_shop_tag',             '.shop-hero-tag');
    txt('ads_shop_sub',             '.shop-hero-sub');
    txt('ads_shop_editorial_label', '.shop-editorial-label');
    txt('ads_shop_editorial',       '.shop-editorial-text');
    // Categories
    txt('ads_cat_batonnets_tag',      '.cat-batonnets .shop-hero-tag');
    txt('ads_cat_batonnets_sub',      '.cat-batonnets .shop-hero-sub');
    txt('ads_cat_batonnets_ed_label', '.cat-batonnets .shop-editorial-label');
    txt('ads_cat_batonnets_ed_text',  '.cat-batonnets .shop-editorial-text');
    txt('ads_cat_cones_tag',          '.cat-cones .shop-hero-tag');
    txt('ads_cat_cones_sub',          '.cat-cones .shop-hero-sub');
    txt('ads_cat_cones_ed_label',     '.cat-cones .shop-editorial-label');
    txt('ads_cat_cones_ed_text',      '.cat-cones .shop-editorial-text');
    // Newsletter
    txt('ads_nl_tag',   '.nl-tag');
    txt('ads_nl_title', '.nl-title');
    txt('ads_nl_sub',   '.nl-sub');
    txt('ads_nl_btn',   '.nl-form button');
    // Footer
    txt('ads_footer_brand', '.f-brand');
    txt('ads_footer_sub',   '.f-sub');
    txt('ads_footer_about', '.f-about');
    txt('ads_footer_copy',  '.f-copy');
})(jQuery);
</script>
<?php }
add_action( 'customize_preview_init', function(){
    add_action( 'wp_footer', 'ads_customizer_preview' );
} );

/* ================================================================
   OUTPUT CSS — Variables couleurs front-end
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
    if ( ! $custom && $shop_bg === '#1a1714' ) return;
    ?>
    <style id="ads-custom-colors">
    :root {
        --ink:     <?php echo sanitize_hex_color($ink); ?>;
        --amber:   <?php echo sanitize_hex_color($amber); ?>;
        --amber-l: <?php echo sanitize_hex_color($amber_l); ?>;
        --stone:   <?php echo sanitize_hex_color($stone); ?>;
        --off:     <?php echo sanitize_hex_color($off); ?>;
        --mid:     <?php echo sanitize_hex_color($mid); ?>;
        --white:   <?php echo sanitize_hex_color($white); ?>;
    }
    <?php if ( $shop_bg !== '#1a1714' ) : ?>
    .shop-hero { background: <?php echo sanitize_hex_color($shop_bg); ?> !important; }
    <?php endif; ?>
    </style>
    <?php
}
add_action( 'wp_head', 'ads_customizer_css' );
