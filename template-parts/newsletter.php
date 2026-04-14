<?php
/**
 * Section Newsletter.
 * Editable via Personnaliser > Section Newsletter.
 * Le formulaire pointe vers une page de traitement ou un service tiers.
 */
$tag   = ads_option( 'ads_nl_tag',   'Restez Inform&eacute;' );
$title = ads_option( 'ads_nl_title', 'La Lettre des Senteurs' );
$sub   = ads_option( 'ads_nl_sub',   'Nouvelles collections, &eacute;ditions limit&eacute;es et conseils olfactifs directement dans votre bo&icirc;te mail.' );
$btn   = ads_option( 'ads_nl_btn',   'S&rsquo;abonner' );
?>

<section id="newsletter" class="ads-newsletter">
    <div class="ads-container ads-newsletter-inner">
        <div class="nl-tag"><?php echo wp_kses_post( $tag ); ?></div>
        <div class="nl-title"><?php echo wp_kses_post( $title ); ?></div>
        <p class="nl-sub"><?php echo wp_kses_post( $sub ); ?></p>
        <form class="nl-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST">
            <?php wp_nonce_field( 'ads_newsletter_submit', 'ads_nl_nonce' ); ?>
            <input type="hidden" name="action" value="ads_newsletter_subscribe">
            <input type="email" name="nl_email" placeholder="<?php esc_attr_e( 'votre@email.com', 'alchimie-des-senteurs' ); ?>" required>
            <button type="submit"><?php echo wp_kses_post( $btn ); ?></button>
        </form>
    </div>
</section>
