<?php
/**
 * Displayed when no products are found matching the current query.
 *
 * NOTE: Added woocommerce_before_none_found action.
 * NOTE: Customized "none available" message.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

do_action( 'woocommerce_before_none_found' );

?><p class="woocommerce-info"><?php _e( 'Please contact us or a local dealer for availability.', 'woocommerce' ); ?></p>
