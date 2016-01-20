<?php

/**
 * A class of helpful menu-related functions
 *
 * @package Tillotson
 * @author Slushman <chris@slushman.com>
 */
class tillotson_Menukit {

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->loader();

	} // __construct()

	/**
	 * Loads all filter and action calls
	 *
	 * @return 		void
	 */
	private function loader() {

		add_filter( 'walker_nav_menu_start_el', array( $this, 'menu_caret' ), 10, 4 );
		//add_filter( 'walker_nav_menu_start_el', array( $this, 'icon_before_menu_item' ), 10, 4 );
		//add_filter( 'walker_nav_menu_start_el', array( $this, 'icon_after_menu_item' ), 10, 4 );
		//add_filter( 'walker_nav_menu_start_el', array( $this, 'image_before_menu_item' ), 10, 4 );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'icons_only_menu_item' ), 10, 4 );
		add_shortcode( 'listmenu', array( $this, 'list_menu' ) );
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_menu_title_as_class' ), 10, 1 );

	} // loader()

	/**
	 * Adds the Menu Item Title as a class on the menu item
	 *
	 * @param 	object 		$menu_item 			A menu item object
	 */
	public function add_menu_title_as_class( $menu_item ) {

		$title = sanitize_title( $menu_item->title );

		if ( ! in_array( $title, $menu_item->classes ) ) {

			$menu_item->classes[] = $title;

		}

		return $menu_item;

	} // add_menu_title_as_class()

	/**
	 * Add Down Caret to Menus with Children
	 *
	 * @global 		 			$tillotson_themekit 			Themekit class
	 *
	 * @param 		string 		$item_output		//
	 * @param 		object 		$item				//
	 * @param 		int 		$depth 				//
	 * @param 		array 		$args 				//
	 *
	 * @return 		string 							modified menu
	 */
	public function menu_caret( $item_output, $item, $depth, $args ) {

		if ( ! in_array( 'menu-item-has-children', $item->classes ) ) { return $item_output; }

		global $tillotson_themekit;

		$atts 	= $this->get_attributes( $item );
		$output = '';

		$output .= '<a href="' . $item->url . '">';
		$output .= $item->title;

		if ( 0 < $depth ) {

			$output .= '<span class="children">' . $tillotson_themekit->get_svg( 'caret-right' ) . '</span>';

		} else {

			$output .= '<span class="children">' . $tillotson_themekit->get_svg( 'caret-down' ) . '</span>';

		}

		$output .= '</a>';

		return $output;

	} // menu_caret()

	/**
	 * Adds an SVG icon before the menu item text
	 *
	 * @link 	http://www.billerickson.net/customizing-wordpress-menus/
	 *
	 * @param 	string 		$item_output		//
	 * @param 	object 		$item				//
	 * @param 	int 		$depth 				//
	 * @param 	array 		$args 				//
	 *
	 * @return 	string 							modified menu
	 */
	public function icon_before_menu_item( $item_output, $item, $depth, $args ) {

		if ( 'services' !== $args->theme_location && 'subheader' !== $args->theme_location ) { return $item_output; }

		$atts 	= $this->get_attributes( $item );
		$class 	= $this->get_svg_by_class( $item->classes );

		if ( empty( $class ) ) { return $item_output; }

		$output = '';

		$output .= '<a href="' . $item->url . '" class="icon-menu" ' . $atts . '>';
		$output .= $class;
		$output .= '<span class="menu-label">' . $item->title . '</span>';
		$output .= '</a>';

		return $output;

	} // icon_before_menu_item()

	/**
	 * Adds an SVG icon after the menu item text
	 *
	 * @link 	http://www.billerickson.net/customizing-wordpress-menus/
	 *
	 * @param 	string 		$item_output		//
	 * @param 	object 		$item				//
	 * @param 	int 		$depth 				//
	 * @param 	array 		$args 				//
	 *
	 * @return 	string 							modified menu
	 */
	public function icon_after_menu_item( $item_output, $item, $depth, $args ) {

		if ( '' !== $args->theme_location || 'subheader' !== $args->theme_location ) { return $item_output; }

		$atts 	= $this->get_attributes( $item );
		$class 	= $this->get_svg_by_class( $item->classes );

		if ( empty( $class ) ) { return $item_output; }

		$output = '';

		$output .= '<a href="' . $item->url . '" class="icon-menu" ' . $atts . '>';
		$output .= '<span class="menu-label">' . $item->title . '</span>';
		$output .= $class;
		$output .= '</a>';

		return $output;

	} // icon_after_menu_item()

	/**
	 * Replaces menu item text with an SVG icon
	 *
	 * @link 	http://www.billerickson.net/customizing-wordpress-menus/
	 *
	 * @param 	string 		$item_output		//
	 * @param 	object 		$item				//
	 * @param 	int 		$depth 				//
	 * @param 	array 		$args 				//
	 *
	 * @return 	string 							modified menu
	 */
	public function icons_only_menu_item( $item_output, $item, $depth, $args ) {

		if ( 'social' !== $args->theme_location ) { return $item_output; }

		$atts 	= $this->get_attributes( $item );
		$class 	= $this->get_svg_by_class( $item->classes );

		if ( empty( $class ) ) { return $item_output; }

		$output = '';

		$output .= '<a aria-label="' . $item->title . '" href="' . $item->url . '" class="icon-menu" ' . $atts . '>';

		if ( 'subscribe' == $item->post_name ) {

			$output .= $class;
			$output .= '<span class="menu-label show">' . $item->title . '</span>';

		} else {

			$output .= $class;

		}

		$output .= '</a>';

		return $output;

	} // icons_only_menu_item()

	/**
	 * Adds an image from the Customizer after the menu item text
	 *
	 * @link 	http://www.billerickson.net/customizing-wordpress-menus/
	 *
	 * @param 	string 		$item_output		//
	 * @param 	object 		$item				//
	 * @param 	int 		$depth 				//
	 * @param 	array 		$args 				//
	 *
	 * @return 	string 							modified menu
	 */
	public function image_before_menu_item( $item_output, $item, $depth, $args ) {

		if ( 'kits-parts-menu' !== $args->menu ) { return $item_output; }

		$atts 	= $this->get_attributes( $item );
		$title 	= sanitize_title( $item->title );

		switch ( $title ) {

			case 'carburetor-to-kit-cross-reference': 	$mod = 'kit_lookup_image'; break;
			case 'illustrated-parts-lists': 			$mod = 'parts_list_image'; break;
			case 'repair-kits-parts':
			case 'shop': 								$mod = 'kits_shop_image'; break;

		}

		$image_ID 	= get_theme_mod( $mod );
		$info 		= wp_prepare_attachment_for_js( $image_ID );

		//showme( $info );

		$output = '';
		$output .= '<a aria-label="' . $item->title . '" href="' . $item->url . '" class="icon-menu" ' . $atts . '>';
		$output .= '<div class="img-kits-landing" style="background-image:url(' . $info['sizes']['medium']['url'] . ')"></div>';
		$output .= '<h3 class="menu-label show">' . $item->title . '</h3>';
		$output .= '</a>';

		return $output;

	} // image_before_menu_item()

	/**
	 * Returns a string of HTML attributes for the menu item
	 *
	 * @param 	object 		$item 			The menu item object
	 * @return 	string 						A string of attributes
	 */
	public function get_attributes( $item ) {

		if ( empty( $item ) ) { return; }

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		$attributes = '';

		foreach ( $atts as $attr => $value ) {

			if ( ! empty( $value ) ) {

				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';

			}

		}

		return $attributes;

	} // get_attributes()

	/**
	 * Gets the appropriate SVG based on a menu item class
	 *
	 * @global 		 			$tillotson_themekit 			Themekit class
	 * @param 		array 		$classes 			Array of classes to check
	 * @param 		string 		$link 				Optional to add to the SVG
	 * @return 		mixed 							SVG icon
	 */
	public function get_svg_by_class( $classes, $link = '' ) {

		global $tillotson_themekit;

		$output = '';

		foreach ( $classes as $class ) {

			$check = $tillotson_themekit->get_svg( $class, $link );

			if ( ! is_null( $check ) ) { $output .= $check; break; }

		} // foreach

		return $output;

	} // get_svg_by_class()

	/**
	 * Returns a WordPress menu for a shortcode
	 *
	 * Example:
	 * [listmenu menu="product-page"]
	 *
	 * @param 	array 		$atts 			Shortcode attributes
	 * @param 	mixed 		$content 		The page content
	 * @return 	mixed 						A WordPress menu
	 */
	public function list_menu( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'menu'            => '',
			'container'       => 'div',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'depth'           => 0,
			'walker'          => '',
			'theme_location'  => ''),
			$atts )
		);

		return wp_nav_menu( array(
			'menu'            => $menu,
			'container'       => $container,
			'container_class' => $container_class,
			'container_id'    => $container_id,
			'menu_class'      => $menu_class,
			'menu_id'         => $menu_id,
			'echo'            => false,
			'fallback_cb'     => $fallback_cb,
			'before'          => $before,
			'after'           => $after,
			'link_before'     => $link_before,
			'link_after'      => $link_after,
			'depth'           => $depth,
			'walker'          => $walker,
			'theme_location'  => $theme_location )
		);

	} // list_menu()

} // class

/**
 * Make an instance so its ready to be used
 */
$tillotson_menukit = new tillotson_Menukit();

