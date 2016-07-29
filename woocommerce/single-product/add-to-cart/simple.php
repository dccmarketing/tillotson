<?php
/**
 * Simple product add to cart
 *
 * NOTE: Removed is_sold_individually check. 7/16/2015.
 * NOTE: Added shopping cart icon to Add to Cart button.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! $product->is_purchasable() ) { return; }

// Availability
$availability      = $product->get_availability();
$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';

echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );

if ( $product->is_in_stock() ) :

	do_action( 'woocommerce_before_add_to_cart_form' );

	?><form class="cart" method="post" enctype='multipart/form-data'><?php

		do_action( 'woocommerce_before_add_to_cart_button' );

	 	?><input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
	 	<button type="submit" class="single_add_to_cart_button button alt"><?php

			echo esc_html( $product->single_add_to_cart_text() );

		?><span class="dashicons dashicons-cart"></span></button><?php

		do_action( 'woocommerce_after_add_to_cart_button' );

	?></form><?php

	do_action( 'woocommerce_after_add_to_cart_form' );

endif;
