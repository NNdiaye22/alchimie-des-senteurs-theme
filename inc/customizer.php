<?php
/**
 * Customizer — Alchimie des Senteurs
 * Apparence → Personnaliser → Alchimie des Senteurs
 *
 * Toutes les sections :
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
 *  10. Page Contact
 *  11. Footer
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ================================================================
   HELPERS
================================================================ */

/** Ajoute un champ texte + setting d'un coup. */
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

/** Ajoute un champ couleur + setting. */
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

/** Ajoute un checkbox. */
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

    // Panel principal
    $wp_customize->add_panel( 'ads_theme_panel', array(
        'title'    => 'Alchimie des Senteurs',
        'priority' => 30,
    ) );

    /* ==============================================================
       0. COULEURS GLOBALES
    ============================================================== */
    $wp_customize->add_section( 'ads_colors', array(
        'title'       => '🎨 Couleurs Globales',
        'description' => 'Ces couleurs s’appliquent sur tout le site. Modifiez-les pour changer l’identité visuelle complète.',
        'panel'       => 'ads_theme_panel',
        'priority'    => 1,
    ) );
    _ads_color( $wp_customize, 'ads_color_ink',     'Couleur principale (texte / fond sombre)', '#1a1714', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_amber',   'Couleur accent (ambré / doré)',           '#c4873a', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_amber_l', 'Couleur accent claire',                    '#e0a85a', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_stone',   'Couleur texte secondaire (gris)',           '#9a9088', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_off',     'Fond décalé (sections alternées)',         '#f8f6f3', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_mid',     'Couleur des bordures / séparateurs',       '#e0d8cc', 'ads_colors' );
    _ads_color( $wp_customize, 'ads_color_white',   'Fond blanc',                               '#ffffff', 'ads_colors' );

    /* ==============================================================
       1. HERO
    ============================================================== */
    $wp_customize->add_section( 'ads_hero', array(
        'title' => 'Hero — Section principale',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_text( $wp_customize, 'ads_hero_tag',      "Tag au-dessus du titre",   "Maison d'Encens · Dakar", 'ads_hero' );
    _ads_text( $wp_customize, 'ads_hero_title_l1', 'Titre ligne 1',            "L'Encens",                'ads_hero' );
    _ads_text( $wp_customize, 'ads_hero_title_l2', 'Titre ligne 2 (italique)', 'Vivant',                  'ads_hero' );
    _ads_text( $wp_customize, 'ads_hero_sub',      'Sous-titre',               'Oud · Arabesque · Musc · Andalous', 'ads_hero' );
    _ads_text( $wp_customize, 'ads_hero_cta_text', 'Bouton CTA — Texte',       'Découvrir',               'ads_hero' );
    _ads_text( $wp_customize, 'ads_hero_cta_url',  'Bouton CTA — Lien',        '#collection',             'ads_hero' );
    _ads_check( $wp_customize, 'ads_hero_cta_show', 'Afficher le bouton CTA',  '1',                        'ads_hero' );

    /* ==============================================================
       2. ANIMATION SCROLL — Infos flottantes
    ============================================================== */
    $wp_customize->add_section( 'ads_scroll_infos', array(
        'title'       => 'Animation Scroll — Infos flottantes',
        'description' => 'Les 3 blocs d’info visibles pendant l’animation.',
        'panel'       => 'ads_theme_panel',
    ) );
    $scroll_infos = array(
        'ads_scroll_left_label'   => "Gauche — Label",
        'ads_scroll_left_value'   => "Gauche — Valeur",
        'ads_scroll_left_sub1'    => "Gauche — Ligne 1",
        'ads_scroll_left_sub2'    => "Gauche — Ligne 2",
        'ads_scroll_right_label'  => "Droite — Label",
        'ads_scroll_right_value'  => "Droite — Valeur",
        'ads_scroll_right_sub1'   => "Droite — Ligne 1",
        'ads_scroll_right_sub2'   => "Droite — Ligne 2",
        'ads_scroll_bottom_label' => "Bas — Label",
        'ads_scroll_bottom_value' => "Bas — Valeur",
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
        'ads_scroll_bottom_value' => 'Oud · Bois de Santal · Ambre',
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
            'tag'   => array( 'Phase 1 — Tag',   "I — L’Allumage" ),
            'title' => array( 'Phase 1 — Titre', "L’instant du premier souffle" ),
            'body'  => array( 'Phase 1 — Texte', 'La braise s’éveille. Un fil de fumée s’élève, portant avec lui des siècles de tradition olfactive orientale.' ),
        ),
        2 => array(
            'tag'   => array( 'Phase 2 — Tag',   'II — La Consumation' ),
            'title' => array( 'Phase 2 — Titre', 'Le temps qui parfume' ),
            'body'  => array( 'Phase 2 — Texte', 'Au fil des heures, le bâtonnet révèle ses couches olfactives.' ),
        ),
        3 => array(
            'tag'   => array( 'Phase 3 — Tag',   "III — L’Empreinte" ),
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
        'title'       => 'Section Mise en Avant Produit',
        'description' => 'La section « L’Encens Arabesque » sous l’animation scroll.',
        'panel'       => 'ads_theme_panel',
    ) );
    _ads_text( $wp_customize, 'ads_reveal_title_l1',  'Titre ligne 1',                  "L'Encens",        'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_title_l2',  'Titre ligne 2 (italique ambre)', 'Arabesque',       'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_desc',      'Texte descriptif',               'Notre encens le plus emblématique. Façonné à partir de résines précieuses et de bois de santal sélectionnés à la source.', 'ads_reveal', 'textarea' );
    _ads_text( $wp_customize, 'ads_reveal_btn1_text', 'Bouton 1 — Texte',              'Acheter',         'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn1_prix', 'Bouton 1 — Prix affiché',       '2 300 XOF',       'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn1_url',  'Bouton 1 — Lien',              '#',               'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn2_text', 'Bouton 2 — Texte',              'En savoir plus',  'ads_reveal' );
    _ads_text( $wp_customize, 'ads_reveal_btn2_url',  'Bouton 2 — Lien',              '#',               'ads_reveal' );
    for ( $i = 1; $i <= 5; $i++ ) {
        $defaults = array(
            1 => array( 'Durée de combustion', '2h30 continues' ),
            2 => array( 'Contenu', '10 bâtonnets' ),
            3 => array( 'Famille olfactive', 'Oriental · Boisé · Épicé' ),
            4 => array( 'Origine', "Résines d'Orient" ),
            5 => array( 'Livraison', 'Dakar & environs' ),
        );
        _ads_text( $wp_customize, "ads_reveal_spec_{$i}_label", "Spec {$i} — Label", $defaults[$i][0], 'ads_reveal' );
        _ads_text( $wp_customize, "ads_reveal_spec_{$i}_value", "Spec {$i} — Valeur", $defaults[$i][1], 'ads_reveal' );
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
    _ads_text(  $wp_customize, 'ads_collection_cta_text', 'Bouton « Tout voir » — Texte',   'Tout voir',    'ads_collection' );
    _ads_text(  $wp_customize, 'ads_collection_cta_url',  'Bouton « Tout voir » — Lien',    '#',            'ads_collection' );
    $wp_customize->add_setting( 'ads_collection_nb', array(
        'default' => 6, 'sanitize_callback' => 'absint', 'transport' => 'postMessage',
    ) );
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
    _ads_check( $wp_customize, 'ads_phi_show',  'Afficher cette section',  '1',                                     'ads_philosophy' );
    _ads_text(  $wp_customize, 'ads_phi_tag',   'Tag',                     'Notre Philosophie',                     'ads_philosophy' );
    _ads_text(  $wp_customize, 'ads_phi_title', 'Titre',                   "L'encens comme rituel quotidien",       'ads_philosophy' );
    _ads_text(  $wp_customize, 'ads_phi_body',  'Texte',                   "Chaque bâtonnet est un pont entre le présent et l'ancestral.", 'ads_philosophy', 'textarea' );
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
    _ads_check( $wp_customize, 'ads_nl_show',  'Afficher cette section', '1',                                              'ads_newsletter' );
    _ads_text(  $wp_customize, 'ads_nl_tag',   'Tag',                    'Restez Informé',                                 'ads_newsletter' );
    _ads_text(  $wp_customize, 'ads_nl_title', 'Titre',                  'La Lettre des Senteurs',                         'ads_newsletter' );
    _ads_text(  $wp_customize, 'ads_nl_sub',   'Sous-titre',             'Nouvelles collections, éditions limitées et conseils olfactifs.', 'ads_newsletter', 'textarea' );
    _ads_text(  $wp_customize, 'ads_nl_btn',   'Texte bouton',           "S'abonner",                                      'ads_newsletter' );

    /* ==============================================================
       9. PAGE BOUTIQUE
    ============================================================== */
    $wp_customize->add_section( 'ads_shop', array(
        'title'       => 'Page Boutique (/shop)',
        'description' => 'Textes du hero et des éléments de la page boutique.',
        'panel'       => 'ads_theme_panel',
    ) );
    // Hero
    _ads_text( $wp_customize, 'ads_shop_tag',      'Hero — Tag',                    'Notre Sélection',   'ads_shop' );
    _ads_text( $wp_customize, 'ads_shop_title_l1', 'Hero — Titre ligne 1',          'La Boutique',       'ads_shop' );
    _ads_text( $wp_customize, 'ads_shop_title_l2', 'Hero — Titre ligne 2 (ambre)',  'Alchimie',          'ads_shop' );
    _ads_text( $wp_customize, 'ads_shop_sub',      'Hero — Sous-titre',             'Encens, résines et accessoires sélectionnés pour leur authenticité et leur intensité olfactive.', 'ads_shop', 'textarea' );
    // Case éditoriale
    _ads_text( $wp_customize, 'ads_shop_editorial_label', 'Case éditoriale — Label',    'La philosophie',              'ads_shop' );
    _ads_text( $wp_customize, 'ads_shop_editorial',       'Case éditoriale — Citation', '« L’encens comme rituel. »',  'ads_shop', 'textarea' );
    // Bouton carte
    _ads_text( $wp_customize, 'ads_shop_card_btn', 'Bouton sur chaque carte',      'Voir',              'ads_shop' );
    // Message vide
    _ads_text( $wp_customize, 'ads_shop_empty',    'Message si aucun produit',     'Aucun produit trouvé.', 'ads_shop' );
    // Couleur accent boutique
    _ads_color( $wp_customize, 'ads_shop_hero_bg', 'Hero — Couleur de fond',       '#1a1714', 'ads_shop' );

    /* ==============================================================
       10. PAGE CONTACT
    ============================================================== */
    $wp_customize->add_section( 'ads_contact', array(
        'title'       => 'Page Contact',
        'description' => 'Informations affichées dans la page Contact.',
        'panel'       => 'ads_theme_panel',
    ) );
    $contact_fields = array(
        'ads_contact_hero_tag'   => array( 'Hero — Tag',                          'Nous Contacter'                    ),
        'ads_contact_hero_title' => array( 'Hero — Titre ligne 1',                'Une question ?'                   ),
        'ads_contact_hero_em'    => array( 'Hero — Titre ligne 2 (italique)',     'Parlons-en.'                       ),
        'ads_contact_hero_sub'   => array( 'Hero — Sous-titre',                   'Notre équipe est disponible du lundi au samedi, de 9h à 18h.' ),
        'ads_contact_adresse'    => array( 'Adresse',                              'Dakar, Sénégal'                    ),
        'ads_contact_whatsapp'   => array( 'Lien WhatsApp (https://wa.me/...)',    'https://wa.me/221776440125'        ),
        'ads_contact_wa_label'   => array( 'WhatsApp — Texte affiché',            '+221 77 644 01 25'                 ),
        'ads_contact_email'      => array( 'Email de contact',                    'contact@alchimie-des-senteurs.sn'  ),
        'ads_contact_horaires'   => array( 'Horaires',                             'Lun — Sam : 9h à 18h'              ),
        'ads_contact_form_tag'   => array( 'Formulaire — Tag',                    'Formulaire'                        ),
        'ads_contact_form_title' => array( 'Formulaire — Titre ligne 1',          'Envoyez-nous'                      ),
        'ads_contact_form_em'    => array( 'Formulaire — Titre ligne 2 (italique)','un message'                       ),
        'ads_contact_form_sub'   => array( 'Formulaire — Sous-titre',             'Nous vous répondons sous 24h.'     ),
    );
    foreach ( $contact_fields as $key => $data ) {
        $type = in_array( $key, array('ads_contact_hero_sub','ads_contact_form_sub'), true ) ? 'textarea' : 'text';
        _ads_text( $wp_customize, $key, $data[0], $data[1], 'ads_contact', $type );
    }

    /* ==============================================================
       11. FOOTER
    ============================================================== */
    $wp_customize->add_section( 'ads_footer', array(
        'title' => 'Footer',
        'panel' => 'ads_theme_panel',
    ) );
    _ads_text( $wp_customize, 'ads_footer_brand', 'Nom de marque',                'Alchimie des Senteurs',      'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_sub',   'Sous-titre marque',             "Maison d'Encens · Dakar",    'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_about', 'Texte de présentation',         "Depuis Dakar, nous apportons les fragrances les plus authentiques d'Orient dans vos foyers.", 'ads_footer', 'textarea' );
    _ads_text( $wp_customize, 'ads_footer_wa',    'Lien WhatsApp',                 'https://wa.me/221776440125', 'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_insta', 'Lien Instagram',                '#',                         'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_fb',    'Lien Facebook',                 '#',                         'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_copy',  'Texte copyright',               '© 2026 Alchimie des Senteurs · Dakar, Sénégal', 'ads_footer' );
    _ads_text( $wp_customize, 'ads_footer_pay',   'Moyens de paiement (virgule)',  'Orange Money,Wave,Carte',    'ads_footer' );
}
add_action( 'customize_register', 'ads_customizer_register' );

/* ================================================================
   PREVIEW LIVE (postMessage)
   Injecte les variables CSS couleurs en temps réel
   sans recharger la page
================================================================ */
function ads_customizer_preview() { ?>
<script id="ads-customizer-preview">
(function($){
    'use strict';

    /* --- Injecteur CSS variables :root --- */
    function setVar(varName, value) {
        var root = document.documentElement;
        root.style.setProperty(varName, value);
    }

    /* --- COULEURS GLOBALES --- */
    wp.customize('ads_color_ink',     function(v){ v.bind(function(val){ setVar('--ink',     val); }); });
    wp.customize('ads_color_amber',   function(v){ v.bind(function(val){ setVar('--amber',   val); }); });
    wp.customize('ads_color_amber_l', function(v){ v.bind(function(val){ setVar('--amber-l', val); }); });
    wp.customize('ads_color_stone',   function(v){ v.bind(function(val){ setVar('--stone',   val); }); });
    wp.customize('ads_color_off',     function(v){ v.bind(function(val){ setVar('--off',     val); }); });
    wp.customize('ads_color_mid',     function(v){ v.bind(function(val){ setVar('--mid',     val); }); });
    wp.customize('ads_color_white',   function(v){ v.bind(function(val){ setVar('--white',   val); }); });

    /* --- Couleur fond hero boutique --- */
    wp.customize('ads_shop_hero_bg', function(v){ v.bind(function(val){
        var el = document.querySelector('.shop-hero');
        if (el) el.style.background = val;
    }); });

    /* --- TEXTES : helper générique --- */
    function bindText(settingId, selector, attr) {
        wp.customize(settingId, function(v){
            v.bind(function(val){
                var els = document.querySelectorAll(selector);
                els.forEach(function(el){
                    if (attr === 'html') { el.innerHTML = val; }
                    else if (attr)       { el.setAttribute(attr, val); }
                    else                 { el.textContent = val; }
                });
            });
        });
    }

    /* Hero homepage */
    bindText('ads_hero_tag',      '.ov-tag',            'html');
    bindText('ads_hero_title_l1', '.ov-title',          'html');
    bindText('ads_hero_sub',      '.ov-sub',            'html');

    /* Hero boutique */
    bindText('ads_shop_tag',      '.shop-hero-tag',     'html');
    bindText('ads_shop_title_l1', '.shop-hero-title',   'html');
    bindText('ads_shop_sub',      '.shop-hero-sub',     'html');
    bindText('ads_shop_editorial_label', '.shop-editorial-label', 'html');
    bindText('ads_shop_editorial',       '.shop-editorial-text',  'html');

    /* Section Reveal */
    bindText('ads_reveal_desc',      '.reveal-left p',   'html');

    /* Newsletter */
    bindText('ads_nl_tag',   '.nl-tag',   'html');
    bindText('ads_nl_title', '.nl-title', 'html');
    bindText('ads_nl_sub',   '.nl-sub',   'html');
    bindText('ads_nl_btn',   '.nl-form button', 'html');

    /* Footer */
    bindText('ads_footer_brand', '.f-brand', 'html');
    bindText('ads_footer_sub',   '.f-sub',   'html');
    bindText('ads_footer_about', '.f-about', 'html');
    bindText('ads_footer_copy',  '.f-copy',  'html');

})(jQuery);
</script>
<?php }
add_action( 'customize_preview_init', function(){
    add_action( 'wp_footer', 'ads_customizer_preview' );
} );

/* ================================================================
   OUTPUT CSS : applique les couleurs choisies sur le front
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

    // Seulement si différent des valeurs par défaut (optimisation)
    $defaults = array(
        $ink     => '#1a1714',
        $amber   => '#c4873a',
        $amber_l => '#e0a85a',
        $stone   => '#9a9088',
        $off     => '#f8f6f3',
        $mid     => '#e0d8cc',
        $white   => '#ffffff',
    );
    $has_custom = false;
    foreach ( $defaults as $val => $def ) {
        if ( $val !== $def ) { $has_custom = true; break; }
    }
    if ( ! $has_custom && $shop_bg === '#1a1714' ) return;
    ?>
    <style id="ads-custom-colors">
    :root {
        --ink:     <?php echo sanitize_hex_color($ink);     ?>;
        --amber:   <?php echo sanitize_hex_color($amber);   ?>;
        --amber-l: <?php echo sanitize_hex_color($amber_l); ?>;
        --stone:   <?php echo sanitize_hex_color($stone);   ?>;
        --off:     <?php echo sanitize_hex_color($off);     ?>;
        --mid:     <?php echo sanitize_hex_color($mid);     ?>;
        --white:   <?php echo sanitize_hex_color($white);   ?>;
    }
    <?php if ( $shop_bg !== '#1a1714' ) : ?>
    .shop-hero { background: <?php echo sanitize_hex_color($shop_bg); ?> !important; }
    <?php endif; ?>
    </style>
    <?php
}
add_action( 'wp_head', 'ads_customizer_css' );
