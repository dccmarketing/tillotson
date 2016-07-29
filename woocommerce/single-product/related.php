<?php
/**
 * Related Products
 *
 * NOTE: Added woocommerce_related_products_heading filter for "Related Products" heading to filter it on some pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

if ( ! $related = $product->get_related( $posts_per_page ) ) {
	return;
}

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;
$woocommerce_loop['name']    = 'related';

if ( $products->have_posts() ) :

	?><div class="related products">
		<h2><?php echo apply_filters( 'woocommerce_related_products_heading', __( 'Related Products', 'woocommerce' ), $product ); ?></h2><?php

		woocommerce_product_loop_start();

		while ( $products->have_posts() ) : $products->the_post();

			wc_get_template_part( 'content', 'product' );

		endwhile; // end of the loop.

		woocommerce_product_loop_end();

	?></div><?php

endif;

wp_reset_postdata();
