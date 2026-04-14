<?php
/**
 * Template 404.
 */
get_header();
?>
<main id="main" class="ads-404">
    <div class="ads-container ads-404-inner">
        <p class="ads-404-code">404</p>
        <h1 class="ads-404-title"><?php esc_html_e( 'Page introuvable', 'alchimie-des-senteurs' ); ?></h1>
        <p class="ads-404-body"><?php esc_html_e( 'La page que vous cherchez n&rsquo;existe pas ou a &eacute;t&eacute; d&eacute;plac&eacute;e.', 'alchimie-des-senteurs' ); ?></p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-dark">
            <?php esc_html_e( 'Retour &agrave; l&rsquo;accueil', 'alchimie-des-senteurs' ); ?>
        </a>
    </div>
</main>
<?php get_footer(); ?>
