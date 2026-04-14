<?php
/**
 * Section Hero - Animation scroll-driven canvas.
 * Les textes sont editables via Personnaliser > Alchimie des Senteurs > Hero.
 */
$hero_tag  = ads_option( 'ads_hero_tag',      'Maison d&rsquo;Encens &middot; Dakar' );
$title_l1  = ads_option( 'ads_hero_title_l1', 'L&rsquo;Encens' );
$title_l2  = ads_option( 'ads_hero_title_l2', 'Vivant' );
$hero_sub  = ads_option( 'ads_hero_sub',      'Oud &middot; Arabesque &middot; Musc &middot; Andalous' );
?>

<div id="scroll-zone">
    <div id="sticky">
        <canvas id="c"></canvas>

        <!-- Texte overlay hero -->
        <div id="ov">
            <div class="ov-tag" id="ot"><?php echo wp_kses_post( $hero_tag ); ?></div>
            <div class="ov-title" id="oT">
                <?php echo esc_html( $title_l1 ); ?><br>
                <em><?php echo esc_html( $title_l2 ); ?></em>
            </div>
            <div class="ov-line" id="ol"></div>
            <div class="ov-sub" id="os"><?php echo wp_kses_post( $hero_sub ); ?></div>
        </div>

        <!-- Labels informatifs gauche/droite -->
        <div class="info-block" id="info-left">
            <div class="info-label"><?php esc_html_e( 'Combustion', 'alchimie-des-senteurs' ); ?></div>
            <div class="info-value">2h &agrave; 5h</div>
            <div class="info-sub">Diffusion lente<br>et continue</div>
        </div>
        <div class="info-block" id="info-right">
            <div class="info-label"><?php esc_html_e( 'Mati&egrave;re premi&egrave;re', 'alchimie-des-senteurs' ); ?></div>
            <div class="info-value">R&eacute;sine naturelle</div>
            <div class="info-sub">Bois pr&eacute;cieux<br>s&eacute;lectionn&eacute;</div>
        </div>
        <div class="info-block" id="info-bottom">
            <div class="info-label"><?php esc_html_e( 'Notes olfactives', 'alchimie-des-senteurs' ); ?></div>
            <div class="info-value">Oud &middot; Bois de Santal &middot; Ambre</div>
        </div>

        <!-- Phases narratives -->
        <div class="phase-copy" id="pc1">
            <div class="ph-tag">I &mdash; L&rsquo;Allumage</div>
            <div class="ph-title">L&rsquo;instant<br>du premier souffle</div>
            <div class="ph-body">La braise s&rsquo;&eacute;veille. Un fil de fum&eacute;e s&rsquo;&eacute;l&egrave;ve, portant avec lui des si&egrave;cles de tradition olfactive orientale.</div>
        </div>
        <div class="phase-copy right" id="pc2">
            <div class="ph-tag">II &mdash; La Consumation</div>
            <div class="ph-title">Le temps<br>qui parfume</div>
            <div class="ph-body" style="margin-left:auto">Au fil des heures, le b&acirc;tonnet r&eacute;v&egrave;le ses couches olfactives. Du coeur &eacute;pic&eacute; aux notes bois&eacute;es de fond.</div>
        </div>
        <div class="phase-copy" id="pc3">
            <div class="ph-tag">III &mdash; L&rsquo;Empreinte</div>
            <div class="ph-title">Ce qui reste<br>apr&egrave;s le silence</div>
            <div class="ph-body">La fum&eacute;e s&rsquo;est dissip&eacute;e, mais le souvenir olfactif persiste. C&rsquo;est la magie du bon encens.</div>
        </div>

        <!-- Indicateur de scroll -->
        <div id="cue">
            <p><?php esc_html_e( 'D&eacute;couvrir', 'alchimie-des-senteurs' ); ?></p>
            <div class="cue-tick"></div>
        </div>

    </div><!-- #sticky -->
</div><!-- #scroll-zone -->
