<?php

/**
 * Returns an attachment by the filename
 *
 * @param 		string 			$post_name 				The post name
 *
 * @return 		object 									The attachment post object
 */
function tillotson_get_attachment_by_name( $post_name ) {

	if ( empty( $post_name ) ) { return 'Post name is empty'; }

	$args['name'] 			= trim ( $post_name );
	$args['post_per_page'] 	= 1;
	$args['post_status'] 	= 'any';

	$posts = $this->get_posts( 'attachment', $args, $post_name . '_attachments' );

	if ( $posts->posts[0] ) {

		return $posts->posts[0];

	}

	return FALSE;

} // tillotson_get_attachment_by_name()

/**
 * Returns an array of term objects
 *
 * @param 	string|array 		$tax 			The slug or array of slugs of taxonomies
 * @param 	int 				$params 		An array of optional parameters for get_terms
 * @param 	string 				$cache 			The name for a new cache store
 * @return 	array 								Array of term objects
 */
function tillotson_get_cats( $tax, $params = array(), $cache = '' ) {

	if ( empty( $tax ) ) { return 'No taxonomy provided.'; }

	$return  	= '';
	$cache_name = 'terms';

	if ( ! empty( $cache ) ) {

		$cache_name .= '_' . $cache;

	}

	$return = wp_cache_get( $cache_name, 'terms' );

	if ( false !== $return ) { return $return; }

	$args['cache_domain'] 		= 'core';
	$args['childless'] 			= false;
	$args['child_of'] 			= 0;
	$args['description__like'] 	= '';
	$args['exclude'] 			= array();
	$args['exclude_tree'] 		= array();
	$args['fields'] 			= 'all';
	$args['get'] 				= '';
	$args['hide_empty'] 		= TRUE;
	$args['hierarchical'] 		= TRUE;
	$args['include'] 			= array();
	$args['name__like'] 		= '';
	$args['number'] 			= '';
	$args['offset'] 			= '';
	$args['order'] 				= 'ASC';
	$args['orderby'] 			= 'name';
	$args['pad_counts'] 		= FALSE;
	$args['parent'] 			= '';
	$args['search'] 			= '';
	$args['slug'] 				= '';

	if ( ! empty( $params ) ) {

		$args = wp_parse_args( $params, $args );

	}

	$cats = get_terms( $tax, $args );

	if ( ! is_wp_error( $cats ) && ! empty( $cats ) ) {

		wp_cache_set( $cache_name, $cats, 'terms', 5 * MINUTE_IN_SECONDS );

		$return = $cats;

	}

	return $return;

} // tillotson_get_cats()

function tillotson_get_files( $type, $object ) {

	$files = get_field( 'service_docs', $object );

	if ( empty( $files ) ) { return; }

	$return = array();

	foreach ( $files as $file ) {

		if ( $type !== $file['document_type'] ) { continue; }

		$return[] = $file['service_document'];

	}

	return $return;

} // tillotson_get_files()

/**
 * Returns a post object of the requested post type
 *
 * @param 	string 		$post 			The name of the post type
 * @param   array 		$params 		Optional parameters
 * @return 	object 		A post object
 */
 function tillotson_get_posts( $post, $params = array(), $cache = '' ) {

	$return = '';
	$cache_name = 'posts';

	if ( ! empty( $cache ) ) {

		$cache_name = '' . $cache . '_posts';

	}

	$return = wp_cache_get( $cache_name, 'posts' );

	if ( false === $return ) {

		$args['post_type'] 				= $post;
		$args['post_status'] 			= 'publish';
		$args['order_by'] 				= 'date';
		$args['posts_per_page'] 		= 50;
		$args['no_found_rows']			= true;
		$args['update_post_meta_cache'] = false;
		$args['update_post_term_cache'] = false;

		if ( ! empty( $params ) ) {

			foreach ( $params as $key => $value ) {

				$args[$key] = $value;

			}

		}

		$query = new WP_Query( $args );

		if ( ! is_wp_error( $query ) && $query->have_posts() ) {

			wp_cache_set( $cache_name, $query, 'posts', 5 * MINUTE_IN_SECONDS );

			$return = $query;

		}

	}

	return $return;

} // tillotson_get_posts()

/**
 * Returns the URL for the posts page
 *
 * @return 		string 						The URL for the posts page
 */
function tillotson_get_posts_page() {

	if( get_option( 'show_on_front' ) == 'page' ) {

		return get_permalink( get_option( 'page_for_posts' ) );

	} else  {

		return bloginfo( 'url' );

	}

} // tillotson_get_posts_page()

/**
 * Returns a Google Map link from an address
 *
 * @param 	string 		$address 		An address
 * @return 	string 						URL for Google Maps
 */
function tillotson_make_map_link( $address ) {

	if( empty( $address ) ) { return FALSE; }

	$return = '';

	$query_args['q'] 	= urlencode( $address );
	$return 			= add_query_arg( $query_args, 'http://www.google.com/maps/' );

	return $return;

} // tillotson_make_map_link()

/**
 * Converts formatted phone numbers to just numbers for tel links
 *
 * @param 	string 		$number 			A formatted phone number
 * @return 	string 							The number minus characters besides numbers
 */
function tillotson_make_number( $number ) {

	if ( empty( $number ) ) { return FALSE; }

	$return = '';

	$return = preg_replace( '/[^0-9]/', '', $number );

	return $return;

} // tillotson_make_number()

/**
 * Converts a phone number into a tel link
 *
 * @param 	string 		$number 			A phone number
 * @return 	mixed 							Formatted HTML telephone link
 */
function tillotson_make_phone_link( $number ) {

	if ( empty( $number ) ) { return FALSE; }

	$return = '';

	$formatted 	= preg_replace( '/[^0-9]/', '', $number );

	$return .= '<span itemprop="telephone">';
	$return .= '<a href="tel:' . $formatted . '">';
	$return .= '<span class="screen-reader-text">';
	$return .= esc_html__( 'Call ', 'tillotson' ) . '</span>';
	$return .= $number . '</a>';
	$return .= '</span>';

	return $return;

} // tillotson_make_phone_link()

/**
 * Reduce the length of a string by character count
 *
 * @param 	string 		$text 		The string to reduce
 * @param 	int 		$limit 		Max amount of characters to allow
 * @param 	string 		$after 		Text for after the limit
 * @return 	string 					The possibly reduced string
 */
function tillotson_shorten_text( $text, $limit = 100, $after = '...' ) {

	$length = strlen( $text );
	$text 	= substr( $text, 0, $limit );

	if ( $length > $limit ) {

		$text = $text . $after;

	} // Ellipsis

	return $text;

} // tillotson_shorten_text()

/**
 * Prints whatever in a nice, readable format
 */
function showme( $input ) {

	echo '<pre>'; print_r( $input ); echo '</pre>';

} // showme()
