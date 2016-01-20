<?php

add_action( 'init', 'tillotson_register_shortcodes' );

/**
 * Register shortcodes
 */
function tillotson_register_shortcodes() {

	add_shortcode( 'listfiles', 'tillotson_list_files' );
	add_shortcode( 'productsearchform', 'tillotson_product_search_form' );

} // tillotson_register_shortcodes()

/**
 * Processes the listfiles shortcode
 *
 * @param  array  $atts The shortcode attribute
 * @return mixed 			The output
 */
function tillotson_list_files( $atts = array() ) {

	global $tillotson_themekit;

	$defaults['description'] 	= '';
	$defaults['label'] 			= '';
	$defaults['type'] 			= 'kits';
	$args						= shortcode_atts( $defaults, $atts, 'listfiles' );

	$cats = $tillotson_themekit->get_cats( array( 'pa_product-line', 'product_cat' ), array( 'hide_empty' => FALSE ), 'listfiles' );

	if ( empty( $cats ) ) { return; }

	$files = array();

	foreach ( $cats as $cat ) {

		$checks = $tillotson_themekit->get_files( $args['type'], $cat );

		if ( empty( $checks ) ) { continue; }

		foreach ( $checks as $check ) {

			$files[] = $check;

		}

	}

	if ( empty( $files ) ) { return; }

	ob_start();

	set_query_var( 'args', $args );
	set_query_var( 'files', $files );
	get_template_part( 'template-parts/content', 'servicedocs' );

	$output = ob_get_contents();

	ob_end_clean();

	return $output;

} // tillotson_list_files()

/**
 * Displays the default WooCommerce product search form via shortcode.
 *
 * @return [type] [description]
 */
function tillotson_product_search_form() {

	global $woocommerce;

	echo '';

	get_product_search_form();

	echo '';

} // tillotson_product_search_form()
