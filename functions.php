<?php
/**
 * Tillotson functions and definitions
 *
 * @package Tillotson
 */

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Load Slushman Themekit
 */
require get_template_directory() . '/inc/themekit.php';

/**
 * Load Slushman Imagekit
 */
require get_template_directory() . '/inc/imagekit.php';



/**
 * Autoloader function
 *
 * @param 		string 			$class_name
 */
function tillotson_autoloader( $class_name ) {

	if ( 0 !== strpos( $class_name, 'Tillotson_' ) ) { return; }

	$class_name = str_replace( 'Tillotson_', '', $class_name );
	$lower 		= strtolower( $class_name );
	$file      	= 'class-' . str_replace( '_', '-', $lower ) . '.php';
	$base_path 	= trailingslashit( get_stylesheet_directory() );
	$paths[] 	= $base_path . $file;
	$paths[] 	= $base_path . 'classes/' . $file;
	$paths[] 	= $base_path . 'inc/' . $file;

	/**
	 * tillotson-autoloader-paths filter
	 */
	$paths = apply_filters( 'tillotson-autoloader-paths', $paths );

	foreach ( $paths as $path ) :

		if ( is_readable( $path ) && file_exists( $path ) ) {

			require_once( $path );
			return;

		}

	endforeach;

} // tillotson_autoloader()

spl_autoload_register( 'tillotson_autoloader' );

/**
 * Begins execution of the hooks.
 *
 * @since    1.0.0
 */
call_user_func( array( new Tillotson_Controller(), 'run' ) );
