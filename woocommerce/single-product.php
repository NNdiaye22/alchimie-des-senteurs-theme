<?php
/**
 * Template page produit individuelle.
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="main" class="ads-single-product">
    <div class="ads-container">
        <?php woocommerce_breadcrumb(); ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php wc_get_template( 'single-product/price.php' ); ?>
            <div class="ads-product-layout">

                <!-- Galerie -->
                <div class="ads-product-gallery">
                    <?php do_action( 'woocommerce_before_single_product_summary' ); ?>
                </div>

                <!-- Infos -->
                <div class="ads-product-summary">
                    <div class="woocommerce-product-details__short-description">
                        <?php do_action( 'woocommerce_single_product_summary' ); ?>
                    </div>

                    <?php
                    // Specifications personnalisees
                    $specs = array(
                        __( 'Dur&eacute;e de combustion', 'alchimie-des-senteurs' ) => '_ads_duration',
                        __( 'Contenu',                   'alchimie-des-senteurs' ) => '_ads_content',
                        __( 'Famille olfactive',         'alchimie-des-senteurs' ) => '_ads_family',
                        __( 'Origine',                   'alchimie-des-senteurs' ) => '_ads_origin',
                    );
                    $has_specs = false;
                    foreach ( $specs as $label => $meta_key ) {
                        if ( get_post_meta( get_the_ID(), $meta_key, true ) ) { $has_specs = true; break; }
                    }
                    if ( $has_specs ) :
                    ?>
                        <div class="ads-product-specs">
                            <?php foreach ( $specs as $label => $meta_key ) :
                                $value = get_post_meta( get_the_ID(), $meta_key, true );
                                if ( ! $value ) continue;
                            ?>
                                <div class="spec-row">
                                    <div class="spec-label"><?php echo wp_kses_post( $label ); ?></div>
                                    <div class="spec-value"><?php echo esc_html( $value ); ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Onglets description / avis -->
            <div class="ads-product-tabs">
                <?php do_action( 'woocommerce_after_single_product_summary' ); ?>
            </div>

            <!-- Produits lies -->
            <div class="ads-related-products">
                <?php
                $related = wc_get_related_products( get_the_ID(), 3 );
                if ( $related ) :
                ?>
                    <h3 class="ads-related-title"><?php esc_html_e( 'Vous aimerez aussi', 'alchimie-des-senteurs' ); ?></h3>
                    <div class="products-grid">
                        <?php foreach ( $related as $related_id ) :
                            $post_object = get_post( $related_id );
                            setup_postdata( $GLOBALS['post'] = $post_object );
                            wc_get_template_part( 'content', 'product' );
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
