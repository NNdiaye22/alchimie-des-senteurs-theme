<?php
/**
 * Customizer — Alchimie des Senteurs
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
    _ads_text(  $wp_customize, 'ads_hero_tag',      'Tag au-dessus du titre',   "Maison d'Encens \u00b7 Dakar", 'ads_hero' );
    _ads_text(  $wp_customize, 'ads_hero_title_l1', 'Titre ligne 1',            "L'Encens",                'ads_hero' );
    _ads_text(  $wp_customize, 'ads_hero_title_l2', 'Titre ligne 2 (italique)', 'Vivant',                  'ads_hero' );
    _ads_text(  $wp_customize, 'ads_hero_sub',      'Sous-titre',               'Oud \u00b7 Arabesque \u00b7 Musc \u00b7 Andalous', 'ads_hero' );
    _ads_text(  $wp_customize, 'ads_hero_cta_text', 'Bouton CTA — Texte',       'Découvrir',               'ads_hero' );
    _ads_text(  $wp_customize, 'ads_hero_cta_url',  'Bouton CTA — Lien',        '#collection',             'ads_hero' );
    _ads_check( $wp_customize, 'ads_hero_cta_show', 'Afficher le bouton CTA',   '1',                       'ads_hero' );

    /* ==============================================================
       2. ANIMATION SCROLL — Infos flottantes
    ============================================================== */
    $wp_customize->add_section( 'ads_scroll_infos', array(
        'title'       => 'Animation Scroll — Infos flottantes',
        'description' => 'Les 3 blocs d’info visibles pendant l’animation.',
        'panel'       => 'ads_theme_panel',
    ) );
    $scroll_infos = array(
        'ads_scroll_left_label'   => 'Gauche — Label',
        'ads_scroll_left_value'   => 'Gauche — Valeur',
        'ads_scroll_left_sub1'    => 'Gauche — Ligne 1',
        'ads_scroll_left_sub2'    => 'Gauche — Ligne 2',
        'ads_scroll_right_label'  => 'Droite — Label',
        'ads_scroll_right_value'  => 'Droite — Valeur',
        'ads_scroll_right_sub1'   => 'Droite — Ligne 1',
        'ads_scroll_right_sub2'   => 'Droite — Ligne 2',
        'ads_scroll_bottom_label' => 'Bas — Label',
        'ads_scroll_bottom_value' => 'Bas — Valeur',
    );
    $scroll_defaults = array(
        'ads_scroll_left_label'   => 'Combustion',
        'ads_scroll_left_value'   => '2h à 5h',
        'ads_scroll_left_sub1'    => 'Diffusion lente',
        'ads_scroll_left_sub2'    => 'et continue',
        'ads_scroll_right_label'  => 'Matière première',
        'ads_scroll_right_value'  => 'Résine naturelle',
        'ads_scroll_right_sub1'   => 'Bois précieux',
        'ads_scroll_right_sub2'   => 'sélectionné',
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
        'title'       => 'Animation Scroll — Phases',
        'description' => 'Les 3 textes successifs pendant le scroll.',
        'panel'       => 'ads_theme_panel',
    ) );
    $phases = array(
        1 => array(
            'tag'   => array( 'Phase 1 — Tag',   "I — L\u2019Allumage" ),
            'title' => array( 'Phase 1 — Titre', "L\u2019instant du premier souffle" ),
            'body'  => array( 'Phase 1 — Texte', 'La braise s\u2019\u00e9veille. Un fil de fumée s’élève, portant avec lui des siècles de tradition olfactive orientale.' ),
        ),
        2 => array(
            'tag'   => array( 'Phase 2 — Tag',   'II — La Consumation' ),
            'title' => array( 'Phase 2 — Titre', 'Le temps qui parfume' ),
            'body'  => array( 'Phase 2 — Texte', 'Au fil des heures, le bâtonnet révèle ses couches olfactives.' ),
        ),
        3 => array(
            'tag'   => array( 'Phase 3 — Tag',   "III — L\u2019Empreinte" ),
            'title' => array( 'Phase 3 — Titre', 'Ce qui reste après le silence' ),
            'body'  => array( 'Phase 3 — Texte', 'La fumée s’est dissipée, mais le souvenir olfactif persiste.' ),
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
    _ads_text( $wp_customize, 'ads_reveal_title_l1',  'Titre ligne 1',                  "L'Encens",       'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_title_l2',  'Titre ligne 2 (italique ambre)', 'Arabesque',      'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_desc',      'Texte descriptif',               'Notre encens le plus emblématique.', 'ads_reveal', 'textarea' );
    _ads_text( $wp_customize, 'ads_reveal_btn1_text', 'Bouton 1 — Texte',              'Acheter',        'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn1_prix', 'Bouton 1 — Prix affiché',       '2 300 XOF',    'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn1_url',  'Bouton 1 — Lien',              '#',              'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn2_text', 'Bouton 2 — Texte',              'En savoir plus', 'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn2_url',  'Bouton 2 — Lien',              '#',              'ads_reveal' );
    for ( $i = 1; $i <= 5; $i++ ) {
        $def = array(
            1 => array( 'Durée de combustion', '2h30 continues' ),
            2 => array( 'Contenu', '10 bâtonnets' ),
            3 => array( 'Famille olfactive', 'Oriental · Boisé · Épicé' ),
            4 => array( 'Origine', "Résines d'Orient" ),
            5 => array( 'Livraison', 'Dakar & environs' ),
        );
        _ads_text( $wp_customize, "ads_reveal_spec_{$i}_label", "Spec {$i} — Label", $def[$i][0], 'ads_reveal' );
        _ads_text( $wp_customize, "ads_reveal_spec_{$i}_value", "Spec {$i} — Valeur", $def[$i][1], 'ads_reveal' );
    }

    /* ==============================================================
       5. BANDEAU CITATION
    ============================================================== */
    $wp_customize->add_section( 'ads_quote', array(
        'title' => 'Bandeau Citation',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_check( $wp_customize, 'ads_quote_show', 'Afficher cette section', '1', 'ads_quote' );
    _ads_text(  $wp_customize, 'ads_quote_text', 'Texte de la citation', '« Un parfum ne se voit pas, mais il se souvient. »', 'ads_quote', 'textarea' );
    _ads_text(  $wp_customize, 'ads_quote_attr', 'Attribution', '— La Philosophie des Senteurs', 'ads_quote' );

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
    _ads_text(  $wp_customize, 'ads_collection_cta_text', 'Bouton « Tout voir » — Texte', 'Tout voir', 'ads_collection' );
    _ads_text(  $wp_customize, 'ads_collection_cta_url',  'Bouton « Tout voir » — Lien',  '#',         'ads_collection' );
    $wp_customize->add_setting( 'ads_collection_nb', array( 'default' => 6, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'ads_collection_nb', array(
        'label'       => 'Nombre de produits affichés',
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
    _ads_text(  $wp_customize, 'ads_phi_tag',   'Tag',   'Notre Philosophie',               'ads_philosophy' );
    _ads_text(  $wp_customize, 'ads_phi_title', 'Titre', "L'encens comme rituel quotidien", 'ads_philosophy' );
    _ads_text(  $wp_customize, 'ads_phi_body',  'Texte', "Chaque bâtonnet est un pont entre le présent et l'ancestral.", 'ads_philosophy', 'textarea' );
    for ( $i = 1; $i <= 4; $i++ ) {
        _ads_text( $wp_customize, "ads_phi_stat_{$i}_num",  "Stat {$i} — Chiffre",      '', 'ads_philosophy' );
        _ads_text( $wp_customize, "ads_phi_stat_{$i}_unit", "Stat {$i} — Unité/Label",  '', 'ads_philosophy' );
        _ads_text( $wp_customize, "ads_phi_stat_{$i}_desc", "Stat {$i} — Description", '', 'ads_philosophy' );
    }

    /* ==============================================================
       8. SECTION NEWSLETTER
    ============================================================== */
    $wp_customize->add_section( 'ads_newsletter', array(
        'title' => 'Section Newsletter',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_check( $wp_customize, 'ads_nl_show',  'Afficher cette section', '1', 'ads_newsletter' );
    _ads_text(  $wp_customize, 'ads_nl_tag',   'Tag',          'Restez Informé',                                       'ads_newsletter' );
    _ads_text(  $wp_customize, 'ads_nl_title', 'Titre',        'La Lettre des Senteurs',                               'ads_newsletter' );
    _ads_text(  $wp_customize, 'ads_nl_sub',   'Sous-titre',   'Nouvelles collections, éditions limitées et conseils olfactifs.', 'ads_newsletter', 'textarea' );
    _ads_text(  $wp_customize, 'ads_nl_btn',   'Texte bouton', "S'abonner",                                            'ads_newsletter' );

    /* ==============================================================
       9. PAGE BOUTIQUE
    ============================================================== */
    $wp_customize->add_section( 'ads_shop', array(
        'title'       => 'Page Boutique (/shop)',
        'description' => 'Textes du hero et des éléments de la page boutique principale.',
        'panel'       => 'ads_theme_panel',
    ) );
    _ads_text(  $wp_customize, 'ads_shop_tag',            'Hero — Tag',                   'Notre Sélection', 'ads_shop' );
    _ads_text(  $wp_customize, 'ads_shop_title_l1',       'Hero — Titre ligne 1',         'La Boutique',     'ads_shop' );
    _ads_text(  $wp_customize, 'ads_shop_title_l2',       'Hero — Titre ligne 2 (ambre)', 'Alchimie',        'ads_shop' );
    _ads_text(  $wp_customize, 'ads_shop_sub',            'Hero — Sous-titre',            'Encens, résines et accessoires sélectionnés pour leur authenticité et leur intensité olfactive.', 'ads_shop', 'textarea' );
    _ads_text(  $wp_customize, 'ads_shop_editorial_label','Case éditoriale — Label',      'La philosophie',              'ads_shop' );
    _ads_text(  $wp_customize, 'ads_shop_editorial',      'Case éditoriale — Citation',   '« L’encens comme rituel. »', 'ads_shop', 'textarea' );
    _ads_text(  $wp_customize, 'ads_shop_card_btn',       'Bouton sur chaque carte',       'Voir',                        'ads_shop' );
    _ads_text(  $wp_customize, 'ads_shop_empty',          'Message si aucun produit',      'Aucun produit trouvé.',      'ads_shop' );
    _ads_color( $wp_customize, 'ads_shop_hero_bg',        'Hero — Couleur de fond',       '#1a1714',                     'ads_shop' );

    /* ==============================================================
       10. PAGES CATEGORIES
    ============================================================== */
    $wp_customize->add_section( 'ads_cat_defaults', array(
        'title'       => 'Pages Catégories — Défauts',
        'description' => 'Ces textes s’appliquent à TOUTES les catégories sans réglages spécifiques.',
        'panel'       => 'ads_theme_panel',
    ) );
    _ads_text( $wp_customize, 'ads_cat_default_tag',      'Tag générique',              'Collection',                                          'ads_cat_defaults' );
    _ads_text( $wp_customize, 'ads_cat_default_ed_label', 'Case éditoriale — Label',   'La sélection',                                         'ads_cat_defaults' );
    _ads_text( $wp_customize, 'ads_cat_default_ed_text',  'Case éditoriale — Citation','« Chaque forme, une expérience olfactive unique. »',   'ads_cat_defaults', 'textarea' );

    $known_cats = array(
        'batonnets' => array(
            'label'   => 'Catégorie — Bâtonnets',
            'tag_def' => 'Collection Bâtonnets',
            'sub_def' => 'Nos encens en bâtonnets : une combustion lente, une diffusion continuelle. Le format traditionnel par excellence.',
            'ed_lbl'  => 'Le classique',
            'ed_txt'  => '« Le bâtonnet d’encens, génération après génération. »',
        ),
        'cones' => array(
            'label'   => 'Catégorie — Cônes',
            'tag_def' => 'Collection Cônes',
            'sub_def' => 'Nos encés en cônes : une combustion concentrée, une diffusion intense et enveloppante. Parfait pour les grands espaces.',
            'ed_lbl'  => 'L’intensité',
            'ed_txt'  => '« Le cône concentre toute la puissance du parfum. »',
        ),
    );
    foreach ( $known_cats as $slug => $cfg ) {
        $sec = 'ads_cat_' . $slug;
        $wp_customize->add_section( $sec, array(
            'title'       => $cfg['label'],
            'description' => 'Personnalise /product-category/' . $slug . '/',
            'panel'       => 'ads_theme_panel',
        ) );
        _ads_text( $wp_customize, 'ads_cat_'.$slug.'_tag',      'Tag dans le hero',              $cfg['tag_def'], $sec );
        _ads_text( $wp_customize, 'ads_cat_'.$slug.'_sub',      'Sous-titre du hero',            $cfg['sub_def'], $sec, 'textarea' );
        _ads_text( $wp_customize, 'ads_cat_'.$slug.'_ed_label', 'Case éditoriale — Label',    $cfg['ed_lbl'],  $sec );
        _ads_text( $wp_customize, 'ads_cat_'.$slug.'_ed_text',  'Case éditoriale — Citation', $cfg['ed_txt'],  $sec, 'textarea' );
    }

    /* ==============================================================
       11. PAGE CONTACT
    ============================================================== */
    $wp_customize->add_section( 'ads_contact', array(
        'title'       => 'Page Contact',
        'description' => 'Informations affichées dans la page Contact.',
        'panel'       => 'ads_theme_panel',
    ) );
    $contact_fields = array(
        'ads_contact_hero_tag'   => array( 'Hero — Tag',                            'Nous Contacter'                    ),
        'ads_contact_hero_title' => array( 'Hero — Titre ligne 1',                  'Une question ?'                   ),
        'ads_contact_hero_em'    => array( 'Hero — Titre ligne 2 (italique)',       'Parlons-en.'                       ),
        'ads_contact_hero_sub'   => array( 'Hero — Sous-titre',                     'Notre équipe est disponible du lundi au samedi, de 9h à 18h.' ),
        'ads_contact_adresse'    => array( 'Adresse',                                'Dakar, Sénégal'                    ),
        'ads_contact_whatsapp'   => array( 'Lien WhatsApp (https://wa.me/...)',      'https://wa.me/221776440125'        ),
        'ads_contact_wa_label'   => array( 'WhatsApp — Texte affiché',              '+221 77 644 01 25'                 ),
        'ads_contact_email'      => array( 'Email de contact',                      'contact@alchimie-des-senteurs.sn'  ),
        'ads_contact_horaires'   => array( 'Horaires',                               'Lun — Sam : 9h à 18h'              ),
        'ads_contact_form_tag'   => array( 'Formulaire — Tag',                      'Formulaire'                        ),
        'ads_contact_form_title' => array( 'Formulaire — Titre ligne 1',            'Envoyez-nous'                      ),
        'ads_contact_form_em'    => array( 'Formulaire — Titre ligne 2 (italique)', 'un message'                        ),
        'ads_contact_form_sub'   => array( 'Formulaire — Sous-titre',               'Nous vous répondons sous 24h.'     ),
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
    _ads_text( $wp_customize, 'ads_footer_brand', 'Nom de marque',               'Alchimie des Senteurs',                               'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_sub',   'Sous-titre marque',            "Maison d'Encens \u00b7 Dakar",                            'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_about', 'Texte de présentation',        "Depuis Dakar, nous apportons les fragrances les plus authentiques d'Orient dans vos foyers.", 'ads_footer', 'textarea' );
    _ads_text( $wp_customize, 'ads_footer_wa',    'Lien WhatsApp',                'https://wa.me/221776440125',                          'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_insta', 'Lien Instagram',               '#',                                                   'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_fb',    'Lien Facebook',                '#',                                                   'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_copy',  'Texte copyright',              '© 2026 Alchimie des Senteurs · Dakar, Sénégal',          'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_pay',   'Moyens de paiement (virgule)', 'Orange Money,Wave,Carte',                             'ads_footer' );

    /* ==============================================================
       13. NUMERO DE TELEPHONE
       Contrôle l’affichage du numero partout sur le site.
    ============================================================== */
    $wp_customize->add_section( 'ads_phone', array(
        'title'       => '\ud83d\udcf1 Numéro de Téléphone',
        'description' => 'Gérez le numéro de téléphone/WhatsApp affiché sur le site et activez ou désactivez son affichage page par page.',
        'panel'       => 'ads_theme_panel',
        'priority'    => 200,
    ) );

    // --- Le numero et le lien ---
    _ads_text( $wp_customize, 'ads_phone_number', 'Numéro affiché',              '+221 77 644 01 25',          'ads_phone' );
    _ads_text( $wp_customize, 'ads_phone_link',   'Lien (https://wa.me/...)',   'https://wa.me/221776440125','ads_phone' );

    // --- Cases à cocher : afficher sur... ---
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
   Retourne le HTML du bloc telephone si la case est cochee.
   Usage : <?php ads_phone('cart'); ?>
================================================================ */
function ads_phone( $location, $class = '' ) {
    $show = get_theme_mod( 'ads_phone_show_' . $location, '1' );
    if ( ! $show ) return;
    $number = get_theme_mod( 'ads_phone_number', '+221 77 644 01 25' );
    $link   = get_theme_mod( 'ads_phone_link',   'https://wa.me/221776440125' );
    if ( ! $number ) return;
    $cls = 'ads-phone-block' . ( $class ? ' ' . esc_attr($class) : '' );
    echo '<div class="' . $cls . '">';
    echo '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013 7.18 2 2 0 014.99 5h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L9.91 12a16 16 0 006.09 6.09l.31-.31a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 20z"/></svg>';
    echo '<a href="' . esc_url($link) . '" class="ads-phone-link">' . esc_html($number) . '</a>';
    echo '</div>';
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
    // Couleurs
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
    // Catégories
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
    // Téléphone — toggle live
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
   OUTPUT CSS — Variables couleurs + style bloc telephone
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
    /* Bloc telephone global */
    .ads-phone-block {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.65rem;
        color: var(--stone);
    }
    .ads-phone-block svg { flex-shrink: 0; color: var(--amber); }
    .ads-phone-link {
        text-decoration: none;
        color: inherit;
        transition: color 0.2s;
        letter-spacing: 0.04em;
    }
    .ads-phone-link:hover { color: var(--amber); }
    </style>
    <?php
}
add_action( 'wp_head', 'ads_customizer_css' );
