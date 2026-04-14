/**
 * Customizer Live Preview — Couleurs & textes
 * Chargé dans le panneau de prévisualisation WordPress
 */
(function ($) {
    'use strict';

    function cssVar(name, val) {
        document.documentElement.style.setProperty(name, val);
    }

    function txt(id, sel) {
        wp.customize(id, function (v) {
            v.bind(function (val) {
                document.querySelectorAll(sel).forEach(function (el) {
                    el.innerHTML = val;
                });
            });
        });
    }

    /* Couleurs */
    wp.customize('ads_color_ink',     function(v){ v.bind(function(val){ cssVar('--ink',val); }); });
    wp.customize('ads_color_amber',   function(v){ v.bind(function(val){ cssVar('--amber',val); }); });
    wp.customize('ads_color_amber_l', function(v){ v.bind(function(val){ cssVar('--amber-l',val); }); });
    wp.customize('ads_color_stone',   function(v){ v.bind(function(val){ cssVar('--stone',val); }); });
    wp.customize('ads_color_off',     function(v){ v.bind(function(val){ cssVar('--off',val); }); });
    wp.customize('ads_color_mid',     function(v){ v.bind(function(val){ cssVar('--mid',val); }); });
    wp.customize('ads_color_white',   function(v){ v.bind(function(val){ cssVar('--white',val); }); });

    wp.customize('ads_shop_hero_bg', function(v){ v.bind(function(val){
        var h = document.querySelector('.shop-hero');
        if (h) h.style.background = val;
    }); });

    /* Textes homepage */
    txt('ads_hero_tag',      '.ov-tag');
    txt('ads_hero_sub',      '.ov-sub');

    /* Textes boutique */
    txt('ads_shop_tag',              '.shop-hero-tag');
    txt('ads_shop_sub',              '.shop-hero-sub');
    txt('ads_shop_editorial_label',  '.shop-editorial-label');
    txt('ads_shop_editorial',        '.shop-editorial-text');

    /* Newsletter */
    txt('ads_nl_tag',   '.nl-tag');
    txt('ads_nl_title', '.nl-title');
    txt('ads_nl_sub',   '.nl-sub');
    txt('ads_nl_btn',   '.nl-form button');

    /* Footer */
    txt('ads_footer_brand', '.f-brand');
    txt('ads_footer_sub',   '.f-sub');
    txt('ads_footer_about', '.f-about');
    txt('ads_footer_copy',  '.f-copy');

}(jQuery));
