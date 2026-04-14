<?php
/**
 * Template de la page d'accueil.
 * Assemble toutes les sections via template-parts.
 */
get_header();
?>

<main id="main">

    <?php get_template_part( 'template-parts/hero' ); ?>

    <?php get_template_part( 'template-parts/quote' ); ?>

    <?php get_template_part( 'template-parts/collection' ); ?>

    <?php get_template_part( 'template-parts/featured-product' ); ?>

    <?php get_template_part( 'template-parts/philosophy' ); ?>

    <?php get_template_part( 'template-parts/newsletter' ); ?>

</main>

<?php get_footer(); ?>
