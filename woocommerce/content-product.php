<?php
/**
 * Rendu d'un produit dans la boucle (grille).
 * Utilise par archive-product.php, taxonomy-product_cat.php et partout ou WooCommerce affiche une liste.
 */
defined( 'ABSPATH' ) || exit;

global $product;
$product = wc_get_product( get_the_ID() );
if ( empty( $product ) ) return;

$img_id  = $product->get_image_id();
$img_url = $img_id
    ? wp_get_attachment_image_url( $img_id, 'ads-product-card' )
    : wc_placeholder_img_src( 'ads-product-card' );

// --- Badge intelligent (variable + simple) ---
$badge = null;

if ( $product->is_type('variable') ) {
    $any_sale      = false;
    $any_low       = false;
    $any_backorder = false;
    $all_out       = true;

    foreach ( $product->get_available_variations() as $v ) {
        $vobj    = wc_get_product( $v['variation_id'] );
        $v_stock = $vobj ? $vobj->get_stock_quantity() : null;
        $v_back  = $vobj ? $vobj->backorders_allowed() : false;
        $v_low   = ( $v['is_in_stock'] && $v_stock !== null && $v_stock > 0 && $v_stock <= 5 );
        $on_sale = $v['display_regular_price'] > $v['display_price'];

        if ( $v['is_in_stock'] || $v_back ) $all_out = false;
        if ( $on_sale )  $any_sale      = true;
        if ( $v_low )    $any_low       = true;
        if ( $v_back && ! $v['is_in_stock'] ) $any_backorder = true;
    }

    if ( $all_out )       $badge = array( 'id' => 'out',       'label' => '&Eacute;puis&eacute;' );
    elseif ( $any_backorder ) $badge = array( 'id' => 'backorder', 'label' => 'Bient&ocirc;t dispo' );
    elseif ( $any_low )   $badge = array( 'id' => 'low',       'label' => 'Stock limit&eacute;' );
    elseif ( $any_sale )  $badge = array( 'id' => 'promo',     'label' => 'Promo' );

} else {
    $in_stock   = $product->is_in_stock();
    $backorders = $product->backorders_allowed();
    $stock_qty  = $product->get_stock_quantity();
    $low_stock  = ( $in_stock && $stock_qty !== null && $stock_qty > 0 && $stock_qty <= 5 );
    $sale_price = $product->get_sale_price();

    if ( ! $in_stock && $backorders )  $badge = array( 'id' => 'backorder', 'label' => 'Bient&ocirc;t dispo' );
    elseif ( ! $in_stock )             $badge = array( 'id' => 'out',       'label' => '&Eacute;puis&eacute;' );
    elseif ( $low_stock )              $badge = array( 'id' => 'low',       'label' => 'Plus que ' . (int)$stock_qty . ' en stock' );
    elseif ( $sale_price )             $badge = array( 'id' => 'promo',     'label' => 'Promo' );
}
?>

<div class="product-card" onclick="window.location='<?php echo esc_url( get_the_permalink() ); ?>'">

    <div class="card-img-wrap">
        <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
        <?php if ( $badge ) : ?>
            <div class="card-badge badge-<?php echo esc_attr( $badge['id'] ); ?>"><?php echo $badge['label']; ?></div>
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
            <?php if ( $product->is_in_stock() || $product->backorders_allowed() ) : ?>
                <button class="card-add"
                    onclick="event.stopPropagation(); window.location='<?php echo esc_url( get_the_permalink() ); ?>'">
                    <?php esc_html_e( 'Voir', 'alchimie-des-senteurs' ); ?>
                </button>
            <?php else : ?>
                <button class="card-add" disabled><?php esc_html_e( 'Indisponible', 'alchimie-des-senteurs' ); ?></button>
            <?php endif; ?>
        </div>
    </div>

</div>
