<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$price = $product->get_price();

if ( empty( $price ) ) { return; }

?><div class="wrap-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
	<p class="price"><?php echo $product->get_price_html(); ?></p>
	<meta itemprop="price" content="<?php echo esc_attr( $price ); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
</div>