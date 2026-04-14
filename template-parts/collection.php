<?php
/**
 * Section Collection - Grille de produits WooCommerce.
 * Affiche les derniers produits publies.
 * Nombre de produits editable via Personnaliser > Section Collection.
 * Si WooCommerce n'est pas actif, affiche un message.
 */
$section_tag   = ads_option( 'ads_collection_tag',   'Nos Encens' );
$section_title = ads_option( 'ads_collection_title', 'La Collection' );
$nb_products   = (int) ads_option( 'ads_collection_nb', 6 );
?>

<section id="collection" class="ads-collection">
    <div class="ads-container">

        <div class="coll-header">
            <div>
                <div class="coll-tag"><?php echo esc_html( $section_tag ); ?></div>
                <div class="coll-title"><?php echo esc_html( $section_title ); ?></div>
            </div>
            <?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="all-link">
                    <?php esc_html_e( 'Tout voir', 'alchimie-des-senteurs' ); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php if ( class_exists( 'WooCommerce' ) ) : ?>

            <?php
            $args = array(
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => $nb_products,
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            $products_query = new WP_Query( $args );
            ?>

            <?php if ( $products_query->have_posts() ) : ?>
                <div class="products-grid">
                    <?php while ( $products_query->have_posts() ) : $products_query->the_post(); ?>
                        <?php
                        global $product;
                        $product = wc_get_product( get_the_ID() );
                        if ( ! $product ) continue;

                        $img_id  = $product->get_image_id();
                        $img_url = $img_id
                            ? wp_get_attachment_image_url( $img_id, 'ads-product-card' )
                            : wc_placeholder_img_src( 'ads-product-card' );

                        $price    = $product->get_price_html();
                        $is_onsale = $product->is_on_sale();
                        $is_outofstock = ! $product->is_in_stock();
                        $badge = $is_outofstock ? '<div class="card-badge badge-out">' . esc_html__( 'Epuise', 'alchimie-des-senteurs' ) . '</div>'
                               : ( $is_onsale   ? '<div class="card-badge badge-promo">' . esc_html__( 'Promo', 'alchimie-des-senteurs' ) . '</div>' : '' );

                        $duration_attr = get_post_meta( get_the_ID(), '_ads_duration', true );
                        ?>
                        <div class="product-card" onclick="window.location='<?php echo esc_url( get_the_permalink() ); ?>'">
                            <div class="card-img-wrap">
                                <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
                                <?php echo $badge; ?>
                                <?php if ( $duration_attr ) : ?>
                                    <div class="card-duration"><?php echo esc_html( $duration_attr ); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <?php
                                $terms = get_the_terms( get_the_ID(), 'product_cat' );
                                if ( $terms && ! is_wp_error( $terms ) ) :
                                    $term_names = wp_list_pluck( $terms, 'name' );
                                    echo '<div class="card-fam">' . esc_html( implode( ' &middot; ', $term_names ) ) . '</div>';
                                endif;
                                ?>
                                <div class="card-name"><?php the_title(); ?></div>
                                <div class="card-desc"><?php echo wp_trim_words( get_the_excerpt(), 12, '...' ); ?></div>
                                <div class="card-foot">
                                    <div class="card-price"><?php echo $price; ?></div>
                                    <?php if ( $product->is_in_stock() ) : ?>
                                        <button class="card-add"
                                            onclick="event.stopPropagation(); addToCartAjax(<?php echo $product->get_id(); ?>, this)">
                                            <?php esc_html_e( 'Ajouter', 'alchimie-des-senteurs' ); ?>
                                        </button>
                                    <?php else : ?>
                                        <button class="card-add" disabled>
                                            <?php esc_html_e( 'Indisponible', 'alchimie-des-senteurs' ); ?>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <p class="ads-no-products"><?php esc_html_e( 'Aucun produit disponible pour le moment.', 'alchimie-des-senteurs' ); ?></p>
            <?php endif; ?>

        <?php else : ?>
            <p class="ads-woo-notice"><?php esc_html_e( 'WooCommerce doit etre active pour afficher les produits.', 'alchimie-des-senteurs' ); ?></p>
        <?php endif; ?>

    </div>
</section>
