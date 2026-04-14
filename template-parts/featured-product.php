<?php
/**
 * Section Produit Vedette.
 * Affiche le produit mis en avant manuellement (champ personnalise _ads_featured = 1)
 * ou le produit le plus recemment publie si aucun n'est defini.
 */
if ( ! class_exists( 'WooCommerce' ) ) return;

$featured_args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'meta_query'     => array(
        array(
            'key'   => '_ads_featured',
            'value' => '1',
        ),
    ),
);
$featured_query = new WP_Query( $featured_args );

if ( ! $featured_query->have_posts() ) {
    $featured_args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    $featured_query = new WP_Query( $featured_args );
}

if ( ! $featured_query->have_posts() ) return;

$featured_query->the_post();
global $product;
$product = wc_get_product( get_the_ID() );
if ( ! $product ) { wp_reset_postdata(); return; }

$img_id  = $product->get_image_id();
$img_url = $img_id
    ? wp_get_attachment_image_url( $img_id, 'ads-product-featured' )
    : wc_placeholder_img_src( 'ads-product-featured' );

$specs = array(
    __( 'Dur&eacute;e de combustion', 'alchimie-des-senteurs' ) => get_post_meta( get_the_ID(), '_ads_duration', true ),
    __( 'Contenu',                   'alchimie-des-senteurs' ) => get_post_meta( get_the_ID(), '_ads_content', true ),
    __( 'Famille olfactive',         'alchimie-des-senteurs' ) => get_post_meta( get_the_ID(), '_ads_family', true ),
    __( 'Origine',                   'alchimie-des-senteurs' ) => get_post_meta( get_the_ID(), '_ads_origin', true ),
);
?>

<section id="reveal" class="ads-featured">
    <div class="reveal-left">
        <h2>
            <?php echo wp_kses_post( get_post_meta( get_the_ID(), '_ads_featured_title_l1', true ) ?: get_the_title() ); ?><br>
            <em><?php echo esc_html( get_post_meta( get_the_ID(), '_ads_featured_title_l2', true ) ?: '' ); ?></em>
        </h2>
        <p><?php echo wp_trim_words( get_the_excerpt(), 30, '...' ); ?></p>
        <div class="cta-row">
            <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="btn-dark">
                <?php
                $price = $product->get_price_html();
                printf(
                    /* translators: %s: prix du produit */
                    esc_html__( 'Acheter &mdash; %s', 'alchimie-des-senteurs' ),
                    $price
                );
                ?>
            </a>
            <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="btn-text">
                <?php esc_html_e( 'En savoir plus', 'alchimie-des-senteurs' ); ?>
            </a>
        </div>
    </div>
    <div class="reveal-right">
        <div class="feat-img-wrap">
            <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="feat-img" loading="lazy">
        </div>
        <div class="feat-specs">
            <?php foreach ( $specs as $label => $value ) : if ( ! $value ) continue; ?>
                <div class="spec-row">
                    <div class="spec-label"><?php echo wp_kses_post( $label ); ?></div>
                    <div class="spec-value"><?php echo esc_html( $value ); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php wp_reset_postdata(); ?>
