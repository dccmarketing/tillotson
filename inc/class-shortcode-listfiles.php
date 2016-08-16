<?php

/**
 * Class for creating a shortcode.
 */

class Tillotson_Shortcode_Listfiles {

	/**
	 * Constructor.
	 */
	public function __construct(){}

	/**
	 * Returns a list of files for the category.
	 *
	 * @param 		array 		$atts 		The shortcode attribute
	 * @return 		mixed 					The output
	 */
	public function shortcode_listfiles( $atts, $content = null ) {

		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['type'] 			= 'kits';
		$args						= shortcode_atts( $defaults, $atts, 'listfiles' );

		$cats = tillotson_get_cats( array( 'pa_product-line', 'product_cat' ), array( 'hide_empty' => FALSE ), 'listfiles' );

		if ( empty( $cats ) ) { return; }

		$files = array();

		foreach ( $cats as $cat ) {

			$checks = tillotson_get_files( $args['type'], $cat );

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

	} // shortcode_listfiles()

} // class
