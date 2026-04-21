<?php
/**
 * ADS COD Gateway — Paiement à la livraison sans restriction expédition
 *
 * Hérite de WC_Gateway_COD et remplace process_payment()
 * pour supprimer la vérification native needs_shipping.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Chargement différé — WooCommerce doit être initialisé avant.
 */
function ads_register_cod_gateway( $gateways ) {
    // Charger la classe parente si pas encore chargée
    if ( ! class_exists( 'WC_Gateway_COD' ) ) {
        return $gateways;
    }

    if ( ! class_exists( 'ADS_Gateway_COD' ) ) {

        class ADS_Gateway_COD extends WC_Gateway_COD {

            public function __construct() {
                parent::__construct();
                // Même ID que cod natif pour hériter de toute la config admin
                $this->id                 = 'cod';
                $this->method_title       = 'Paiement à la livraison (ADS)';
                $this->method_description = 'Paiement en espèces à la livraison — sans restriction d\'expédition.';
            }

            /**
             * Toujours disponible — on ignore la vérification expédition native.
             */
            public function is_available() {
                if ( $this->enabled !== 'yes' ) {
                    return false;
                }
                // Ignorer needs_shipping : disponible même si expédition désactivée
                return true;
            }

            /**
             * Traitement du paiement — version sans exception expédition.
             *
             * @param int $order_id
             * @return array
             */
            public function process_payment( $order_id ) {
                $order = wc_get_order( $order_id );

                if ( ! $order ) {
                    wc_add_notice( __( 'Commande introuvable.', 'woocommerce' ), 'error' );
                    return array( 'result' => 'failure' );
                }

                // Réduire le stock
                wc_reduce_stock_levels( $order_id );

                // Vider le panier
                WC()->cart->empty_cart();

                // Statut : en attente de paiement → processing
                $order->update_status(
                    apply_filters( 'woocommerce_cod_process_payment_order_status', 'processing', $order ),
                    __( 'Paiement à la livraison sélectionné.', 'woocommerce' )
                );

                // Retour succès
                return array(
                    'result'   => 'success',
                    'redirect' => $this->get_return_url( $order ),
                );
            }
        }
    }

    // Remplacer le gateway cod natif par notre version
    $gateways[] = 'ADS_Gateway_COD';
    return $gateways;
}
add_filter( 'woocommerce_payment_gateways', 'ads_register_cod_gateway' );

/**
 * Désactiver le gateway cod natif de WooCommerce
 * pour éviter le doublon dans la liste de paiement.
 */
add_filter( 'woocommerce_available_payment_gateways', function( $gateways ) {
    // Garder uniquement notre version ADS_Gateway_COD (id = 'cod')
    // WooCommerce instancie les deux mais notre version écrase la native
    // grâce au même $this->id = 'cod'
    return $gateways;
}, 20 );
