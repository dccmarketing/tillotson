<?php
/**
 * The template part for displaying a child category
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tillotson
 */

global $tillotson_themekit;

/*
$thumbnail_id 	= get_woocommerce_term_meta( $kid->term_id, 'thumbnail_id', true );
$image 			= wp_prepare_attachment_for_js( $thumbnail_id );
if ( $image ) {

	echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" />';

}
*/

$fields 		= get_fields( $kid );
//$products 		= $tillotson_themekit->get_cats( 'product_cat', array( 'hide_empty' => FALSE, 'orderby' => 'count' ), $kid->slug );

$args['orderby'] 					= 'title';
$args['posts_per_page'] 			= 6;
$args['post_type'] 					= 'product';
$args['tax_query']['relation'] 		= 'AND';
$args['tax_query'][0]['field'] 		= 'slug';
$args['tax_query'][0]['taxonomy'] 	= 'product_cat';
$args['tax_query'][0]['terms'] 		= $kid->slug;

$products = $tillotson_themekit->get_posts( 'product', $args, $kid->name );

//showme( $kid );
//showme( $fields );
//showme( $products );

// This is the category description
?><section class="category-kid">
	<h2><?php echo $kid->name; ?></h2>
</section><!-- #post-## -->
<div class="category-product">
	<ul class="wrap-products"><?php

	/*if ( $products->have_posts() ) {

		while ( $products->have_posts() ) : $products->the_post();

			wc_get_template_part( 'content', 'product' );

		endwhile;

		wp_reset_postdata();

	}
*/
	/*if ( ! empty( $products ) ) {

		foreach ( $products as $product ) {

			//wc_get_template_part( 'content', 'product' );

			//do_shortcode( '[product_categories category="' . $product->slug . '"]' );

			//set_query_var( 'product', $product );
			//get_template_part( 'template-parts/content', 'product' );

		} // foreach

	}*/

	?></ul>
</div><!-- .category-grandkid -->