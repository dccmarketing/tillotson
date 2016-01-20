<?php

/**
 * Functions and hooks specifically for WooCommerce
 */
add_action( 'init', 'tillotson_woocommerce_init' );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

add_action( 'woocommerce_before_main_content', 'tillotson_insert_category_page', 30 );
//add_action( 'woocommerce_before_shop_loop', 'tillotson_insert_category_page', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 4 );
add_action( 'woocommerce_single_product_summary', 'tillotson_add_product_category_logo_to_single', 3, 1 );
add_action( 'woocommerce_single_product_summary', 'tillotson_add_currency_switcher', 11 );
//add_action( 'woocommerce_after_shop_loop', 'tillotson_add_search_to_shop' );
//add_action( 'pre_get_product_search_form', 'tillotson_pre_search_text' );
add_action( 'woocommerce_product_query', 'tillotson_get_products_by_market', 10, 2 );
add_action( 'woocommerce_before_none_found', 'tillotson_insert_category_page', 10 );

add_filter( 'woocommerce_show_page_title', 'tillotson_remove_title' );
add_filter( 'loop_shop_columns', 'tillotson_loop_columns' );
add_filter( 'woocommerce_product_tabs', 'tillotson_rename_tabs', 98 );
add_filter( 'woocommerce_product_description_heading', 'tillotson_return_empty_string' );
add_filter( 'woocommerce_stock_html', 'tillotson_remove_stock' );
add_filter( 'woocommerce_output_related_products_args', 'tillotson_change_related_products_quantity', 10 );
add_filter( 'woocommerce_related_products_heading', 'tillotson_change_related_products_heading', 10, 1 );
add_filter( 'woocommerce_product_additional_information_heading', 'tillotson_return_empty_string' );
add_filter( 'woocommerce_product_tabs', 'tillotson_extra_product_tabs' );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'tillotson_custom_cart_button_text' );
add_filter( 'add_to_cart_text', 'tillotson_custom_cart_button_text' );
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );
add_filter( 'woocommerce_attribute_show_in_nav_menus', 'tillotson_show_attributes_in_menus', 10, 2 );



/**
 * Multiple items that need to be attached to init
 *
 * @return mixed
 */
function tillotson_woocommerce_init() {

	add_filter( 'woocommerce_placeholder_img_src', 'tillotson_default_thumbnail', 10, 1 );

	/**
	 * Sets a default thumbnail image
	 *
	 * @param  [type] $src [description]
	 * @return [type]      [description]
	 */
	function tillotson_default_thumbnail( $src ) {

		$thumb = get_theme_mod( 'default_product_thumbnail' );

		if ( empty( $thumb ) ) {

			return $src;

		}

		return $thumb;

	} // tillotson_default_thumbnail

} // tillotson_woocommerce_init()

/**
 * Adds the cart Dashicon to the Add to Cart button
 *
 * @param 		string 			$text 			The current button text
 * @return 		mixed 							The button text plus the cart Dashicon
 */
function tillotson_add_cart_to_button( $text ) {

	global $tillotson_themekit;

	$text .= $tillotson_themekit->get_svg( 'cart' );

	return $text;

} // tillotson_add_cart_to_button()

/**
 * Adds Aelia Currency Switcher to single product page
 *
 * @return [type] [description]
 */
function tillotson_add_currency_switcher() {

	global $product;

	$price = $product->get_price();

	if ( ! empty( $price ) ) {

		echo do_shortcode( '[aelia_currency_selector_widget title="" widget_type="dropdown"]' );

	}

} // tillotson_add_currency_switcher()

/**
 * Adds the category logo to the category archive page
 *
 * @param 	object 		$post 		The category post object
 * @return 	mixed 					The category image HTML
 */
function tillotson_add_product_category_logo_to_single( $post ) {

	global $tillotson_themekit, $post;

	$terms = get_the_terms( $post->ID, 'product_cat' );

	//$tillotson_themekit->pretty( $terms );

	$thumbnail_id 	= get_woocommerce_term_meta( $terms[0]->term_id, 'thumbnail_id', true );

	if ( empty( $thumbnail_id ) ) { return; }

	$image 			= wp_prepare_attachment_for_js( $thumbnail_id );

	//$tillotson_themekit->pretty( $image );

	echo '<div class="wrap-logo"><img src="' . $image['url'] . '" class="logo-category" /></div>';

} // tillotson_add_product_category_logo_to_single()

/**
 * Echos the product search form below the shop and any product category.
 *
 * @return 		mixed
 */
function tillotson_add_search_to_shop() {

	if ( is_shop() || is_product_category() ) {

		if ( function_exists( 'woocommerce_product_search' ) ) {

			echo woocommerce_product_search( array( 'limit' => 20, 'submit_button' => 'yes', 'submit_button_label' => 'Search' ) );

		}

		//return get_product_search_form(); // stsandard Woocommerce search form

	}

} // tillotson_add_search_to_shop()

/**
 * Adds tabs to the product page
 *
 * @return [type] [description]
 */
function tillotson_applications_tab_content() {

	global $tillotson_themekit;

	$applications = get_field( 'applications' );

	if ( empty( $applications ) ) { return; }

	echo '<ul class="list-applications">';

	//$tillotson_themekit->pretty( $applications );

	foreach ( $applications as $app ) {

		echo '<li>';

		if ( empty( $app['link'] ) ) {

			echo $app['title'];

		} else {

			echo '<a href="' . $app['link'] . '">';
			echo $app['title'];
			echo '</a>';

		}

		echo '</li>';

	} // foreach

	echo '</ul>';

} // tillotson_applications_tab_content()

/**
 * Replace text that doesn't currently have a filter
 *
 * @param  [type] $translated_text [description]
 * @param  [type] $text            [description]
 * @param  [type] $domain          [description]
 * @return [type]                  [description]
 */
function tillotson_change_related_products_heading() {

	global $tillotson_themekit;

	$cats = (array) wp_get_post_terms( get_the_ID(), 'product_cat' );

	if ( 'generators' === $cats[0]->slug ) {

		return __( 'Shop Related', 'tillotson' ) . ' ' . $cats[0]->name;

	}

	return __( 'Shop Related Products', 'tillotson' );

	//$tillotson_themekit->pretty( $cats );

}

/**
 * Changes the quantity of related products
 *
 * @param 	array 		$args 			The current related products args
 * @return 	array 						The modified related products args
 */
function tillotson_change_related_products_quantity( $args ) {

	$temp = $args;

	$temp['posts_per_page'] = 5;

	return $temp;

}

/**
 * Change the add to cart text on single product pages
 */
function tillotson_custom_cart_button_text() {

	global $woocommerce;

	foreach( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {

		$_product = $values['data'];

		if( get_the_ID() == $_product->id ) {

			return __( 'Add More?', 'tillotson' );

		}

	} // foreach

	return __( 'Add to cart', 'woocommerce' );

} // tillotson_custom_cart_button_text()

/**
 * Returns an array of image data
 *
 * @param  [type] $term [description]
 * @return [type]       [description]
 */
function tillotson_default_category_logo( $term ) {

	if ( empty( $term ) ) { return 'No term provided.'; }

	$return 	= '';
	$image_id 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );

	if ( ! $image_id ) {

		$image_url 	= get_theme_mod( 'default_product_category_logo' );
		$image_id 	= attachment_url_to_postid( $image_url );

	}

	$return = wp_prepare_attachment_for_js( $image_id );

	return $return;

} // tillotson_default_category_logo()

/**
 * Adds extra tabs to the product pages
 *
 * @param 	array 		$tabs 		The current tabs array
 * @return 	array 					The modified tabs array
 */
function tillotson_extra_product_tabs( $tabs ) {

	$applications = get_field( 'applications' );

	if ( ! empty( $applications ) ) {

		$tabs['apps_tab'] = array(
			'title'    => __( 'Applications', 'woocommerce' ),
			'priority' => 15,
			'callback' => 'tillotson_applications_tab_content'
		);

	}

	return $tabs;

} // tillotson_extra_product_tabs()

/**
 * Filters products by market based on the referring page.
 *
 * Checks for the referring page. Filters the products based
 * on the ending part of the referrer's URL.
 *
 * @param 	array 		$query 			The current WP_Query args
 * @param 	object 		$object 		The current WP_Query object
 * @return 	array 						The modified WP_Query args
 */
function tillotson_get_products_by_market( $query, $object ) {

	$end = tillotson_get_referrer_end( $query );

	if ( empty( $end ) ) { return $query; }
	if ( 'lawn-garden' !== $end
		&& 'racing' !== $end
		&& 'uav' !== $end
		&& 'vintage' !== $end
		&& 'by-model' !== $end
		&& 'by-class' !== $end
		&& 'by-venturi' !== $end
	) { return $query; }

	if ( 'by-model' === $end || 'by-class' === $end || 'by-venturi' === $end ) {

		$end = 'racing';

	}

	$args[0]['taxonomy'] 	= 'product_market';
	$args[0]['field'] 		= 'slug';
	$args[0]['terms'] 		= $end;

	$query->set( 'tax_query', $args );

	return $query;

} // tillotson_get_products_by_market

/**
 * Returns the end of the referrer URL
 *
 * @param 		array 		$query 			The current WP_Query args
 * @return 		string 						The end of the referrer URL
 */
function tillotson_get_referrer_end( $query ) {

	$ref = wp_get_referer();

	if ( empty( $ref ) ) { return $query; }

	$bits = parse_url( $ref, PHP_URL_PATH );
	$trimmed = trim( $bits, '/' );
	$parts = explode( '/', $trimmed );
	$end = end( $parts );

	return $end;

} // tillotson_get_referrer_end()

/**
 * Inserts category information at the top of the product category page
 */
function tillotson_insert_category_page() {

	return '<p>text</p>';

	if( ! is_tax( 'product_cat' ) ) { return; }

	global $tillotson_themekit;

	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

	if ( 'carburetors' === $term->slug ) { return; }

	$image = tillotson_default_category_logo( $term );

	set_query_var( 'image', $image );
	set_query_var( 'term', $term );
	get_template_part( 'template-parts/content', 'category' );

} // tillotson_insert_category_page()

/**
 * Change the amount of columns in the WooCommerce loop
 */
if ( ! function_exists( 'tillotson_loop_columns' ) ) {

	function tillotson_loop_columns() {

		return 3; // 3 products per row

	}

}

/**
 * Adds text above the product search field
 *
 * @return 		mixed 			HTML and text
 */
function tillotson_pre_search_text() {

	echo '<h3 class="presearch">';
	esc_html_e( get_theme_mod( 'presearch_text' ), 'tillotson' );
	echo '</h3>';

}

/**
 * Removes the stock quantity
 *
 * @param  [type] $html [description]
 * @return [type]       [description]
 */
function tillotson_remove_stock( $html ) {

	if ( is_single() ) {

		return '';

	}

	return $html;

}

/**
 * Remove title on the category archive pages
 *
 * @return 		bool 				FALSE if on a WooCommerce category page, otherwise TRUE
 */
function tillotson_remove_title(){

	if( is_tax() && is_woocommerce() ) {

		return FALSE;

	}

	if ( is_woocommerce() ) {

		return FALSE;

	}

	return TRUE;

} // tillotson_remove_title()

/**
 * Renames the default tabs
 *
 * @param  [type] $tabs [description]
 * @return [type]       [description]
 */
function tillotson_rename_tabs( $tabs ) {

	if ( empty( $tabs['additional_information'] ) ) { return $tabs; }

	$tabs['additional_information']['title'] = __( 'Specs', 'tillotson' );

	return $tabs;

}

/**
 * Returns an empty string.
 */
function tillotson_return_empty_string(){

	return '';

}

function tillotson_show_attributes_in_menus( $register, $name ) {

	return TRUE;

} // tillotson_show_attributes_in_menus()

/**
 * Get the product thumbnail, or the placeholder if not set.
 *
 * @subpackage	Loop
 * @param 		string 		$size 			(default: 'shop_catalog')
 * @param 		int 		$d1 			Deprecated since WooCommerce 2.0 (default: 0)
 * @param 		int 		$d2 			Deprecated since WooCommerce 2.0 (default: 0)
 * @return 		string
 */
function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $d1 = 0, $d2 = 0 ) {

	global $post, $product;

	$return = '';
	$return .= '<div class="wrap-thumbnail">';

	if ( has_post_thumbnail() ) {

		$return .= get_the_post_thumbnail( $post->ID, $size );

	} elseif ( wc_placeholder_img_src() ) {

		$return .= wc_placeholder_img( $size );

	} else {

		$return .= get_theme_mod( 'default_product_thumbnail' );

	}

	/*$price = $product->get_price();

	if ( ! empty( $price ) ) {

		$return .= '<div class="wrap-ribbon"><span class="available">' . esc_html__( 'Available Online!', 'tillotson' ) . '</span></div>';

	}*/

	$return .= '</div>';

	return $return;

} // woocommerce_get_product_thumbnail()


