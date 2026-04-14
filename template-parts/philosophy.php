<?php
/**
 * Section Philosophie - fond sombre.
 * Entierement editable via Personnaliser > Section Philosophie.
 */
$tag   = ads_option( 'ads_phi_tag',   'Notre Philosophie' );
$title = ads_option( 'ads_phi_title', 'L&rsquo;encens comme rituel quotidien' );
$body  = ads_option( 'ads_phi_body',  'Chaque b&acirc;tonnet est un pont entre le pr&eacute;sent et l&rsquo;ancestral.' );

$default_stats = array(
    1 => array( 'num' => '12',    'unit' => 'Fragrances', 'desc' => 'Une collection soigneusement &eacute;dit&eacute;e.' ),
    2 => array( 'num' => '5h',    'unit' => 'Maximum',    'desc' => 'La plus longue diffusion de notre gamme.' ),
    3 => array( 'num' => '100%',  'unit' => 'Naturel',    'desc' => 'R&eacute;sines et bois sans additifs chimiques.' ),
    4 => array( 'num' => 'Dakar', 'unit' => 'Livraison',  'desc' => 'Commandez, livr&eacute; directement chez vous.' ),
);
?>

<section id="philosophy" class="ads-philosophy">
    <div class="phi-left">
        <div class="phi-tag"><?php echo esc_html( $tag ); ?></div>
        <div class="phi-title"><?php echo wp_kses_post( $title ); ?></div>
        <p class="phi-body"><?php echo wp_kses_post( $body ); ?></p>
    </div>
    <div class="phi-right">
        <?php for ( $i = 1; $i <= 4; $i++ ) :
            $num  = ads_option( "ads_phi_stat_{$i}_num",  $default_stats[$i]['num'] );
            $unit = ads_option( "ads_phi_stat_{$i}_unit", $default_stats[$i]['unit'] );
            $desc = ads_option( "ads_phi_stat_{$i}_desc", $default_stats[$i]['desc'] );
        ?>
            <div class="phi-stat">
                <div class="phi-num"><?php echo esc_html( $num ); ?></div>
                <div class="phi-unit"><?php echo esc_html( $unit ); ?></div>
                <div class="phi-desc"><?php echo wp_kses_post( $desc ); ?></div>
            </div>
        <?php endfor; ?>
    </div>
</section>
