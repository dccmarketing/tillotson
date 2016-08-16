<?php

/**
 * Class for creating a shortcode.
 */

class Tillotson_Shortcode_Productsearchform {

	/**
	 * Constructor.
	 */
	public function __construct(){}

	/**
	 * Returns the WooCommerce product search form.
	 *
	 * @param 		array 		$atts 		The shortcode attributes
	 * @return 		mixed 					The output
	 */
	public function shortcode_productsearchform( $atts, $content = null ) {

		global $woocommerce;

		echo '';

		get_product_search_form();

		echo '';

	} // shortcode_productsearchform()

} // class
