<?php
/**
 * Template de fallback.
 * WordPress l'utilise si aucun template specifique ne correspond.
 */
get_header();
?>
<main id="main" class="ads-archive">
    <div class="ads-container">
        <?php if ( have_posts() ) : ?>
            <div class="ads-posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content', get_post_type() ); ?>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
            ) ); ?>
        <?php else : ?>
            <p class="ads-no-results"><?php esc_html_e( 'Aucun contenu trouv&eacute;.', 'alchimie-des-senteurs' ); ?></p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
