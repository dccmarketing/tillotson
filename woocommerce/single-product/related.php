<?php
/**
 * Related Products
 *
 * NOTE: Added woocommerce_related_products_heading filter for "Related Products" heading to filter it on some pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( $related_products ) :

	?><section class="related products">
		<h2><?php esc_html_e( 'Related Products', 'woocommerce' ); ?></h2><?php

		woocommerce_product_loop_start();

		foreach ( $related_products as $related_product ) :

			$post_object = get_post( $related_product->get_id() );
			setup_postdata( $GLOBALS['post'] =& $post_object );
			wc_get_template_part( 'content', 'product' );

		endforeach;

		woocommerce_product_loop_end();

	?></section><?php

endif;

wp_reset_postdata();
