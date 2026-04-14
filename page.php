<?php
/**
 * Template pour toutes les pages WordPress standard (Contact, A propos, etc.)
 * Header et footer identiques a toutes les autres pages.
 */
get_header();
?>

<main id="main" class="ads-page">
  <div class="ads-container">
    <?php while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('ads-page-content'); ?>>
      <?php if ( has_post_thumbnail() ) : ?>
        <div class="ads-page-hero-img"><?php the_post_thumbnail('ads-hero'); ?></div>
      <?php endif; ?>
      <h1 class="ads-page-title"><?php the_title(); ?></h1>
      <div class="ads-page-body"><?php the_content(); ?></div>
    </article>
    <?php endwhile; ?>
  </div>
</main>

<?php get_footer(); ?>
