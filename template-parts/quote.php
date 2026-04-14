<?php
/**
 * Bandeau citation interstitielle.
 * Editable via Personnaliser > Bandeau Citation.
 */
$quote = ads_option( 'ads_quote_text', '&laquo;&nbsp;Un parfum ne se voit pas, mais il se souvient. Il reste longtemps apr&egrave;s que tout le reste s&rsquo;est tu.&nbsp;&raquo;' );
$attr  = ads_option( 'ads_quote_attr', '&mdash; La Philosophie des Senteurs' );
?>

<section class="ads-quote-band">
    <div class="ads-container">
        <blockquote class="ads-quote">
            <p><?php echo wp_kses_post( $quote ); ?></p>
            <cite><?php echo wp_kses_post( $attr ); ?></cite>
        </blockquote>
    </div>
</section>
