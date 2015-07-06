<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package DocBlock
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param 	array 		$classes 		Classes for the body element.
 * @return 	array 						The modified body class array
 */
function function_names_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {

		$classes[] = 'group-blog';

	}

	return $classes;

} // function_names_body_classes()
add_filter( 'body_class', 'function_names_body_classes' );



if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param 	string 		$title 		Default title text for current view.
 * @param 	string 		$sep 		Optional separator.
 *
 * @uses 	is_feed()
 * @uses 	get_bloginfo()
 * @uses 	is_home()
 * @uses 	is_front_page()
 *
 * @return 	string 					The filtered title.
 */
function function_names_wp_title( $title, $sep ) {

	if ( is_feed() ) { return $title; }

	global $page, $paged;

	// Add the blog name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) ) {

		$title .= " $sep $site_description";

	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {

		$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'text-domain' ), max( $paged, $page ) );

	}

	return $title;

} // function_names_wp_title()
add_filter( 'wp_title', 'function_names_wp_title', 10, 2 );



/**
 * Title shim for sites older than WordPress 4.1.
 *
 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
 * @todo Remove this function when WordPress 4.3 is released.
 */
function function_names_render_title() {

	?><title><?php wp_title( '|', true, 'right' ); ?></title><?php

} // function_names_render_title()
add_action( 'wp_head', 'function_names_render_title' );
endif;
