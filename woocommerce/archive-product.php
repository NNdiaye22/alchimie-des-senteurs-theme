<?php
/**
 * Template archive produits WooCommerce.
 * Page boutique (/shop).
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="main" class="ads-shop">
    <div class="ads-container">

        <div class="ads-shop-header">
            <?php woocommerce_breadcrumb(); ?>
            <h1 class="ads-shop-title">
                <?php woocommerce_page_title(); ?>
            </h1>
            <div class="ads-shop-toolbar">
                <?php woocommerce_result_count(); ?>
                <?php woocommerce_catalog_ordering(); ?>
            </div>
        </div>

        <?php woocommerce_product_loop_start(); ?>

        <?php if ( woocommerce_product_loop() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php wc_get_template_part( 'content', 'product' ); ?>
            <?php endwhile; ?>
        <?php else : ?>
            <?php wc_no_products_found(); ?>
        <?php endif; ?>

        <?php woocommerce_product_loop_end(); ?>

        <?php woocommerce_pagination(); ?>

    </div>
</main>

<?php get_footer(); ?>
