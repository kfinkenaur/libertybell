<?php
/**
 * Product Open Pricing for WooCommerce - Section Settings
 *
 * @version 1.1.1
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Product_Open_Pricing_Settings_Section' ) ) :

class Alg_WC_Product_Open_Pricing_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function __construct() {
		add_filter( 'woocommerce_get_sections_alg_wc_product_open_pricing',                   array( $this, 'settings_section' ) );
		add_filter( 'woocommerce_get_settings_alg_wc_product_open_pricing' . '_' . $this->id, array( $this, 'get_settings' ), PHP_INT_MAX );
	}

	/**
	 * settings_section.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function settings_section( $sections ) {
		$sections[ $this->id ] = $this->desc;
		return $sections;
	}

	/**
	 * get_settings.
	 *
	 * @version 1.1.1
	 * @since   1.0.0
	 */
	function get_settings() {
		return array_merge( $this->get_section_settings(), array(
			array(
				'title'     => __( 'Reset Section Settings', 'product-open-pricing-for-woocommerce' ),
				'type'      => 'title',
				'id'        => 'alg_wc_product_open_pricing' . '_' . $this->id . '_reset_options',
			),
			array(
				'title'     => __( 'Reset settings', 'product-open-pricing-for-woocommerce' ),
				'desc'      => '<strong>' . __( 'Reset', 'product-open-pricing-for-woocommerce' ) . '</strong>',
				'id'        => 'alg_wc_product_open_pricing' . '_' . $this->id . '_reset',
				'default'   => 'no',
				'type'      => 'checkbox',
			),
			array(
				'type'      => 'sectionend',
				'id'        => 'alg_wc_product_open_pricing' . '_' . $this->id . '_reset_options',
			),
		) );
	}

}

endif;
