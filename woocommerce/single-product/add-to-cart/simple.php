<?php
/**
 * Simple product add to cart
 *
 * NOTE: Removed is_sold_individually check. 7/16/2015.
 * NOTE: Added shopping cart icon to Add to Cart button.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! $product->is_purchasable() ) { return; }

echo wc_get_stock_html( $product );

if ( $product->is_in_stock() ) :

	do_action( 'woocommerce_before_add_to_cart_form' );

	?><form class="cart" method="post" enctype="multipart/form-data" action="<?php echo esc_url( get_permalink() ); ?>"><?php

		/**
		 * @since 2.1.0
		 */
		do_action( 'woocommerce_before_add_to_cart_button' );

		woocommerce_quantity_input( array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : $product->get_min_purchase_quantity(),
		) );

		/**
		 * @since 3.0.0.
		 */
		do_action( 'woocommerce_before_add_to_cart_quantity' );


		?><button type="submit" class="single_add_to_cart_button button alt" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>"><?php

			echo esc_html( $product->single_add_to_cart_text() );

		?><span class="dashicons dashicons-cart"></span></button><?php

		/**
		 * @since 2.1.0
		 */
		do_action( 'woocommerce_after_add_to_cart_button' );

	?></form><?php

	do_action( 'woocommerce_after_add_to_cart_form' );

endif;
