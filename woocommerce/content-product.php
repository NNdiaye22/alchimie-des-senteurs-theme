<?php
/**
 * Rendu d'un produit dans la boucle (grille).
 * Utilise par archive-product.php et partout ou WooCommerce affiche une liste.
 */
defined( 'ABSPATH' ) || exit;

global $product;
$product = wc_get_product( get_the_ID() );
if ( empty( $product ) ) return;

$img_id  = $product->get_image_id();
$img_url = $img_id
    ? wp_get_attachment_image_url( $img_id, 'ads-product-card' )
    : wc_placeholder_img_src( 'ads-product-card' );

$is_onsale      = $product->is_on_sale();
$is_outofstock  = ! $product->is_in_stock();
$duration       = get_post_meta( get_the_ID(), '_ads_duration', true );
?>

<div class="product-card" onclick="window.location='<?php echo esc_url( get_the_permalink() ); ?>'">

    <div class="card-img-wrap">
        <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
        <?php if ( $is_outofstock ) : ?>
            <div class="card-badge badge-out"><?php esc_html_e( 'Epuise', 'alchimie-des-senteurs' ); ?></div>
        <?php elseif ( $is_onsale ) : ?>
            <div class="card-badge badge-promo"><?php esc_html_e( 'Promo', 'alchimie-des-senteurs' ); ?></div>
        <?php endif; ?>
        <?php if ( $duration ) : ?>
            <div class="card-duration"><?php echo esc_html( $duration ); ?></div>
        <?php endif; ?>
    </div>

    <div class="card-body">
        <?php
        $terms = get_the_terms( get_the_ID(), 'product_cat' );
        if ( $terms && ! is_wp_error( $terms ) ) :
            $names = wp_list_pluck( $terms, 'name' );
            echo '<div class="card-fam">' . esc_html( implode( ' &middot; ', $names ) ) . '</div>';
        endif;
        ?>
        <div class="card-name"><?php the_title(); ?></div>
        <div class="card-desc"><?php echo wp_trim_words( $product->get_short_description(), 12, '...' ); ?></div>
        <div class="card-foot">
            <div class="card-price"><?php echo $product->get_price_html(); ?></div>
            <?php if ( $product->is_in_stock() ) : ?>
                <button class="card-add"
                    onclick="event.stopPropagation(); addToCartAjax( <?php echo $product->get_id(); ?>, this )">
                    <?php esc_html_e( 'Ajouter', 'alchimie-des-senteurs' ); ?>
                </button>
            <?php else : ?>
                <button class="card-add" disabled><?php esc_html_e( 'Indisponible', 'alchimie-des-senteurs' ); ?></button>
            <?php endif; ?>
        </div>
    </div>

</div>
