<?php
/**
 * Template pour les articles de blog.
 */
get_header();
?>
<main id="main" class="ads-single">
    <div class="ads-container">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'ads-article' ); ?>>
                <header class="ads-article-header">
                    <div class="ads-article-meta">
                        <span><?php the_category( ', ' ); ?></span>
                        <span><?php echo get_the_date(); ?></span>
                    </div>
                    <h1 class="ads-article-title"><?php the_title(); ?></h1>
                </header>
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="ads-article-img">
                        <?php the_post_thumbnail( 'ads-hero' ); ?>
                    </div>
                <?php endif; ?>
                <div class="ads-article-body">
                    <?php the_content(); ?>
                </div>
                <footer class="ads-article-footer">
                    <?php the_tags( '<div class="ads-tags">', ', ', '</div>' ); ?>
                    <?php
                    the_post_navigation( array(
                        'prev_text' => '&larr; %title',
                        'next_text' => '%title &rarr;',
                    ) );
                    ?>
                </footer>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php get_footer(); ?>
