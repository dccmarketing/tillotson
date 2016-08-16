<?php

/**
 * Functions and hooks specifically for WooCommerce
 */
class Tillotson_Woocommerce {

	public function __contruct() {}

	/**
	 * Adds the cart Dashicon to the Add to Cart button
	 *
	 * @param 		string 			$text 			The current button text
	 * @return 		mixed 							The button text plus the cart Dashicon
	 */
	public function add_cart_to_button( $text ) {

		$text .= get_svg( 'cart' );

		return $text;

	} // add_cart_to_button()

	/**
	 * Adds Aelia Currency Switcher to single product page
	 *
	 * @return [type] [description]
	 */
	public function add_currency_switcher() {

		global $product;

		$price = $product->get_price();

		if ( ! empty( $price ) ) {

			echo do_shortcode( '[aelia_currency_selector_widget title="" widget_type="dropdown"]' );

		}

	} // add_currency_switcher()

	/**
	 * Adds the category logo to the category archive page
	 *
	 * @param 	object 		$post 		The category post object
	 * @return 	mixed 					The category image HTML
	 */
	public function add_product_category_logo_to_single( $post ) {

		global $post;

		$terms 			= get_the_terms( $post->ID, 'product_cat' );
		$thumbnail_id 	= get_woocommerce_term_meta( $terms[0]->term_id, 'thumbnail_id', true );

		if ( empty( $thumbnail_id ) ) { return; }

		$image 			= wp_prepare_attachment_for_js( $thumbnail_id );

		echo '<div class="wrap-logo"><img src="' . $image['url'] . '" class="logo-category" /></div>';

	} // add_product_category_logo_to_single()

	/**
	 * Echos the product search form below the shop and any product category.
	 *
	 * @return 		mixed
	 */
	public function add_search_to_shop() {

		if ( is_shop() || is_product_category() ) {

			if ( function_exists( 'woocommerce_product_search' ) ) {

				echo woocommerce_product_search( array( 'limit' => 20, 'submit_button' => 'yes', 'submit_button_label' => 'Search' ) );

			}

		}

	} // add_search_to_shop()

	/**
	 * Replace text that doesn't currently have a filter
	 *
	 * @param  [type] $translated_text [description]
	 * @param  [type] $text            [description]
	 * @param  [type] $domain          [description]
	 * @return [type]                  [description]
	 */
	public function change_related_products_heading() {

		$cats = (array) wp_get_post_terms( get_the_ID(), 'product_cat' );

		if ( 'generators' === $cats[0]->slug ) {

			return __( 'Shop Related', 'tillotson' ) . ' ' . $cats[0]->name;

		}

		return __( 'Shop Related Products', 'tillotson' );

	} // change_related_products_heading()

	/**
	 * Changes the quantity of related products
	 *
	 * @param 	array 		$args 			The current related products args
	 * @return 	array 						The modified related products args
	 */
	public function change_related_products_quantity( $args ) {

		$temp = $args;

		$temp['posts_per_page'] = 5;

		return $temp;

	} // change_related_products_quantity

	/**
	 * Sets the shop loop quantity.
	 *
	 * @hooked 		loop_shop_per_page
	 * @param 		int 		$cols 		The current quantity.
	 * @return 		int 					The modified quantity.
	 */
	public function change_shop_loop_quantity( $cols ) {

		return 12;

	} // change_shop_loop_quantity()

	/**
	 * Change the add to cart text on single product pages
	 */
	public function custom_cart_button_text() {

		global $woocommerce;

		foreach( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {

			$_product = $values['data'];

			if( get_the_ID() == $_product->id ) {

				return __( 'Add More?', 'tillotson' );

			}

		} // foreach

		return __( 'Add to cart', 'woocommerce' );

	} // custom_cart_button_text()

	/**
	 * Returns an array of image data
	 *
	 * @param  [type] $term [description]
	 * @return [type]       [description]
	 */
	public function default_category_logo( $term ) {

		if ( empty( $term ) ) { return 'No term provided.'; }

		$return 	= '';
		$image_id 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );

		if ( ! $image_id ) {

			$image_url 	= get_theme_mod( 'default_product_category_logo' );
			$image_id 	= attachment_url_to_postid( $image_url );

		}

		$return = wp_prepare_attachment_for_js( $image_id );

		return $return;

	} // default_category_logo()

	/**
	 * Sets a default thumbnail image
	 *
	 * @hooked 		woocommerce_placeholder_img_src
	 * @param 		string 		$src 		The current image source URL.
	 * @return 		string 					The modified image source URL.
	 */
	public function default_thumbnail( $src ) {

		$thumb = get_theme_mod( 'default_product_thumbnail' );

		if ( empty( $thumb ) ) { return $src; }

		return $thumb;

	} // default_thumbnail()

	public function dealers_orderby( $query ) {

		if ( ! isset( $query->query ) ) { return; }
		if ( $query->is_admin ) { return; }
		if ( 'sm-category' !== $query->queried_object->taxonomy ) { return; }

		$orderby = array( 'locationorder' => 'meta_value', 'title' => 'DESC' );

		$query->set( 'orderby', 'meta_value_num title' );
		$query->set( 'order', 'ASC' );

		$query->set( 'meta_query',
			array(
				array(
					'compare' => '>',
					'key' => 'locationorder',
					'value' => 0
				)
			)
		);

	} // dealers_orderby()

	/**
	 * Displays a list of the SimpleMap locations without the locationorder set.
	 *
	 * @exits 		If not the sm-category taxonomy.
	 * @exits 		If no an archive.
	 * @hooked 		tillotson_while_after
	 * @return 		mixed 		Posts without the locationorder set.
	 */
	public function dealers_without_locationorder( $current, $queried ) {

		if ( ! is_taxonomy( 'sm-category' ) ) { return; }
		if ( ! is_archive() ) { return; }
		if ( empty( $queried ) ) { return; }

		$unordered['meta_query'][0]['compare'] 	= 'NOT EXISTS';
		$unordered['meta_query'][0]['key'] 		= 'locationorder';
		$unordered['meta_query'][0]['value'] 	= '';
		$unordered['order'] 					= 'ASC';
		$unordered['orderby'] 					= 'title';
		$unordered['tax_query'][0]['field'] 	= 'slug';
		$unordered['tax_query'][0]['taxonomy'] 	= $queried->taxonomy;
		$unordered['tax_query'][0]['terms'] 	= $queried->slug;

		$unordered_query = tillotson_get_posts( 'sm-location', $unordered, $queried->slug );

		return $unordered_query;

	} // dealers_posts()

	/**
	 * Adds extra tabs to the product pages
	 *
	 * @param 	array 		$tabs 		The current tabs array
	 * @return 	array 					The modified tabs array
	 */
	public function extra_product_tabs( $tabs ) {

		$applications = get_field( 'applications' );

		if ( ! empty( $applications ) ) {

			$tabs['apps_tab'] = array(
				'title'    => __( 'Applications', 'woocommerce' ),
				'priority' => 15,
				'callback' => 'tillotson_applications_tab_content'
			);

		}

		return $tabs;

	} // extra_product_tabs()

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
	public function get_products_by_market( $query, $object ) {

		$end = $this->get_referrer_end( $query );

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

	} // get_products_by_market

	/**
	 * Returns the end of the referrer URL
	 *
	 * @param 		array 		$query 			The current WP_Query args
	 * @return 		string 						The end of the referrer URL
	 */
	public function get_referrer_end( $query ) {

		$ref = wp_get_referer();

		if ( empty( $ref ) ) { return $query; }

		$bits = parse_url( $ref, PHP_URL_PATH );
		$trimmed = trim( $bits, '/' );
		$parts = explode( '/', $trimmed );
		$end = end( $parts );

		return $end;

	} // get_referrer_end()

	/**
	 * Inserts category information at the top of the product category page
	 */
	public function insert_category_page() {

		if ( ! is_tax( 'pa_product-line' ) && ! is_tax( 'pa_racing-class' ) && ! is_tax( 'product_cat' ) && ! is_tax( 'product_market' ) && ! is_tax( 'pa_venturi' ) && ! is_tax( 'pa_throttle-bore-diameter' ) ) { return; }

		$taxterm = get_queried_object();

		if ( 'carburetors' === $taxterm->slug ) { return; }

		$image = $this->default_category_logo( $taxterm );

		set_query_var( 'image', $image );
		set_query_var( 'taxterm', $taxterm );
		get_template_part( 'template-parts/content', 'category' );

	} // insert_category_page()

	/**
	 * Change the amount of columns in the WooCommerce loop
	 */
	public function loop_columns() {

		return 3; // 3 products per row

	}

	/**
	 * Removes the stock quantity
	 *
	 * @param  [type] $html [description]
	 * @return [type]       [description]
	 */
	public function remove_stock( $html ) {

		if ( is_single() ) {

			return '';

		}

		return $html;

	} // remove_stock()

	/**
	 * Remove title on the category archive pages
	 *
	 * @return 		bool 				FALSE if on a WooCommerce category page, otherwise TRUE
	 */
	public function remove_title(){

		if( is_tax() && is_woocommerce() ) {

			return FALSE;

		}

		if ( is_woocommerce() ) {

			return FALSE;

		}

		return TRUE;

	} // remove_title()

	/**
	 * Renames the default tabs
	 *
	 * @param  [type] $tabs [description]
	 * @return [type]       [description]
	 */
	public function rename_tabs( $tabs ) {

		if ( empty( $tabs['additional_information'] ) ) { return $tabs; }

		$tabs['additional_information']['title'] = __( 'Specs', 'tillotson' );

		return $tabs;

	} // rename_tabs()

	/**
	 * Returns an empty string.
	 */
	public function return_empty_string(){

		return '';

	}

	/**
	 * Returns FALSE.
	 *
	 * @return 		bool 		Returns FALSE.
	 */
	public function return_false() {

		return FALSE;

	} // return_false()

	/**
	 * Returns TRUE.
	 *
	 * @return 		bool 		Returns TRUE.
	 */
	public function return_true() {

		return TRUE;

	} // return_true()

	/**
	 * Multiple items that need to be attached to init
	 *
	 * @return mixed
	 */
	public function woocommerce_tweaks() {

		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

		add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 4 );

	} // woocommerce_init()

} // class

/**
 * Adds tabs to the product page
 *
 * @return [type] [description]
 */
function tillotson_applications_tab_content() {

	$applications = get_field( 'applications' );

	if ( empty( $applications ) ) { return; }

	echo '<ul class="list-applications">';

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
 * Get the product thumbnail, or the placeholder if not set.
 *
 * Replaces default function.
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

	$return .= '</div>';

	return $return;

} // woocommerce_get_product_thumbnail()
