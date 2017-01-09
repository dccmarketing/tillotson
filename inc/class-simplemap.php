<?php

/**
 * Functions and hooks specifically for SimpleMap.
 */
class Tillotson_SimpleMap {

	public function __contruct() {}

	public function dealers_orderby( $query ) {
		
		if ( 'WP_Term' !== get_class( $query->queried_object ) ) { return; }
		if ( ! isset( $query->query ) ) { return; }
		if ( $query->is_admin ) { return; }
		if ( empty( $query->tax_query->queries ) ) { return; } 

		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'ASC' );

		$query->set( 'meta_query',
			array(
				array(
					'compare' => '>=',
					'key' => 'locationorder',
					'type' => 'NUMERIC',
					'value' => 1
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
		$unordered['meta_query'][1]['compare'] 	= '=';
		$unordered['meta_query'][1]['key'] 		= 'locationorder';
		$unordered['meta_query'][1]['type'] 	= 'NUMERIC';
		$unordered['meta_query'][1]['value'] 	= 0;
		$unordered['meta_query']['relation'] 	= 'OR';
		$unordered['order'] 					= 'ASC';
		$unordered['orderby'] 					= 'title';
		$unordered['tax_query'][0]['field'] 	= 'slug';
		$unordered['tax_query'][0]['taxonomy'] 	= $queried->taxonomy;
		$unordered['tax_query'][0]['terms'] 	= $queried->slug;

		$unordered_query = tillotson_get_posts( 'sm-location', $unordered, $queried->slug );

		return $unordered_query;

	} // dealers_without_locationorder()

} // class
