<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.com/
 *
 * @package  	Tillotson
 */
class Tillotson_Automattic {

	/**
	 * Constructor
	 */
	public function __construct() {} // __construct()

	/**
	 * Jetpack setup function.
	 *
	 * @see: https://jetpack.com/support/infinite-scroll/
	 * @see: https://jetpack.com/support/responsive-videos/
	 * @hooked 		after_setup_theme
	 */
	function jetpack_setup() {

		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => 'tillotson_infinite_scroll_render',
			'footer'    => 'page',
		) );

		add_theme_support( 'jetpack-responsive-videos' );

	} // jetpack_setup()

	/**
	 * Adds support for wp.com-specific theme functions.
	 *
	 * @hooked 		after_setup_theme
	 * @global array $themecolors
	 */
	function wpcom_setup() {

		global $themecolors;

		if ( isset( $themecolors ) ) { return; }

		$themecolors = array(
			'bg'     => '',
			'border' => '',
			'text'   => '',
			'link'   => '',
			'url'    => '',
		);

	} // wpcom_setup()

} // class

/**
 * Custom render function for Infinite Scroll.
 */
function tillotson_infinite_scroll_render() {

	while ( have_posts() ) {

		the_post();

		if ( is_search() ) {

			get_template_part( 'template-parts/content', 'search' );

		} else {

			get_template_part( 'template-parts/content', get_post_format() );

		}

	}

} // function_names_infinite_scroll_render()
