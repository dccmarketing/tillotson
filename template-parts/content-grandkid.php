<?php
/**
 * The template part for displaying a grandchild category
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tillotson
 */

$length = strlen( $grandkid->name );

if ( 15 < $length ) {

	$class = 'huge';

} elseif ( 10 < $length && 15 >= $length ) {

	$class = 'long';

} elseif ( 5 < $length && 10 >= $length ) {

	$class = 'med';

} else {

	$class = '';

}

?><a class="link-category-grandchild<?php if ( ! empty( $class ) ) { echo ' ' . $class; } ?>" href="<?php



	/*if ( ! empty( $referer ) ) {

		$link = add_query_arg( 'product_market', $referer, get_term_link( $grandkid, $grandkid->taxonomy ) );

	} elseif ( ! empty( $category ) ) {

		$link = add_query_arg( 'product_cat', $category, get_term_link( $grandkid, $grandkid->taxonomy ) );

	} else {

		$link = get_term_link( $grandkid, $grandkid->taxonomy );

	}*/

	$link = site_url();

	if ( ! empty( $category ) || ! empty( $line ) ) {

		$link .= '/filters';

	}

	if ( ! empty( $category ) ) {

		$link .= '/product-category/' . $category;

	}

	if ( ! empty( $line ) ) {

		$link .= '/product-line/' . $line;

	}

	echo esc_url( $link );

?>"><?php

	echo esc_html( $grandkid->name );

?></a>