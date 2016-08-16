<?php

/**
 * A class of helpful menu-related functions
 *
 * @package Tillotson
 * @author DCC Marketing <web@dccmarketing.com>
 */
class Tillotson_Menukit {

	/**
	 * Constructor
	 */
	public function __construct() {} // __construct()

	/**
	 * Adds the 'coin' class to the menu item classes,
	 * if the text position is 'coin'.
	 *
	 * @param 		string 		$classes [description]
	 * @param [type] $textpos [description]
	 */
	public function add_coin_to_menu_item_classes( $classes, $textpos ) {

		if ( 'coin' !== $textpos ) { return $classes; }

		$classes[] = 'coin';

		return $classes;

	} // add_coin_to_menu_item_classes()

	/**
	 * Add an icon the menu item
	 *
	 * @exits 		If $args is empty.
	 * @exits 		If 'slushicons' is not in the classes array.
	 * @hooked 		walker_nav_menu_start_el 		10
	 * @link 		http://www.billerickson.net/customizing-wordpress-menus/
	 * @param 		string 		$item_output		//
	 * @param 		object 		$item				//
	 * @param 		int 		$depth 				//
	 * @param 		array 		$args 				//
	 * @return 		string 							modified menu
	 */
	public function add_icons_to_menu( $item_output, $item, $depth, $args ) {

		if ( empty( $args ) ) { return $item_output; }
		if ( ! in_array( 'slushicons', $item->classes ) ) { return $item_output; }

		$atts 		= $this->get_attributes( $item );
		$icon_name 	= apply_filters( 'tillotson-menu-item-icon-name', '', $item, $args );
		$icon 		= $this->get_icon( $icon_name );
		$textpos 	= apply_filters( 'tillotson-menu-item-text-position', '', $item, $args );

		if ( empty( $icon_name ) && empty( $textpos ) ) { return $item_output; }

		$link_classes 	= apply_filters( 'tillotson-menu-item-link-classes', array( 'icon-menu' ), $textpos );
		$classes 		= implode( ' ', $link_classes );
		$url 			= apply_filters( 'tillotson-menu-item-link-url', $item->url, $item, $args );
		$item_title 	= apply_filters( 'tillotson-menu-item-title', $item->title, $item, $args );

		$output = '';
		$output .= '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $classes ) . '" ' . $atts . '>';

		if ( 'right' === $textpos ) {

			$output .= $icon;

		}

		if ( 'hide' === $textpos ) {

			$output .= '<span class="screen-reader-text">' . esc_html( $item_title ) . '</span>';
			$output .= $icon;

		} elseif ( 'coin' === $textpos ) {

			$output .= '<div class="front menu-icon">';
			$output .= $icon;
			$output .= '</div><div class="back menu-label"><span class="text">';
			$output .= esc_html( $item_title );
			$output .= '</span></div>';

		} else {

			$output .= '<span class="menu-label">' . esc_html( $item_title ) . '</span>';

		}

		if ( 'left' === $textpos ) {

			$output .= $icon;

		}

		$output .= '</a>';

		return $output;

	} // add_icons_to_menu()

	/**
	 * Adds a search form to the menu.
	 *
	 * @exits 		If not on the correct menu.
	 * @hooked 		wp_nav_menu_items 			10
	 * @param 		array 		$items 			The current menu items.
	 * @param 		array 		$args 			The menu args.
	 * @return 		array 						The menu items plus a search form.
	 */
	public function add_search_to_menu( $items, $args ) {

		if ( '' !== $args->theme_location ) { return $items; }

		return $items . get_search_form();

	} // add_search_to_menu()

	/**
	 * Returns a string of HTML attributes for the menu item
	 *
	 * @exits 		If $item is empty.
	 * @param 		object 		$item 			The menu item object
	 * @return 		string 						A string of attributes
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
	 * Returns the code for the icon.
	 *
	 * @exits 		If $icon is empty
	 * @exits 		if $icon is not an array.
	 * @param 		array 		$icon 			The icon info array.
	 * @return 		mixed 						The icon markup.
	 */
	private function get_icon( $icon ) {

		if ( empty( $icon ) || ! is_array( $icon ) ) { return; }

		$return = '';

		if ( 'dashicons' === $icon['type'] ) {

			$return = '<span class="dashicons dashicons-' . $icon['name'] . '"></span>';

		}

		if ( 'fontawesome' === $icon['type'] ) {

			$return = '<span class="fa fa-' . $icon['name'] . '"></span>';

		}

		if ( 'svg' === $icon['type'] ) {

			$check = tillotson_get_svg( $icon['name'] );

			if ( ! is_null( $check ) ) {

				$return = $check;

			}

		}

		return $return;

	} // get_icon()

	/**
	 * Returns an array of info about the icon.
	 *
	 * @exits 		If $classes is empty.
	 * @param 		string 		$icon 			The current icon name.
	 * @param 		object 		$item			The menu item object.
	 * @param 		array 		$args 			The menu arguments.
	 * @return 		array 						The type and name of the icon.
	 */
	public function get_icon_info( $icon, $item, $args  ) {

		if ( empty( $item->classes ) ) { return; }

		$return = array();
		$checks = array( 'dic-', 'fas-', 'svg-' );

		foreach ( $item->classes as $class ) {

			if ( stripos( $class, $checks[0] ) !== FALSE ) {

				$return['type'] = 'dashicons';
				$return['name'] = str_replace( $checks[0], '', $class );
				break;

			}

			if ( stripos( $class, $checks[1] ) !== FALSE ) {

				$return['type'] = 'fontawesome';
				$return['name'] = str_replace( $checks[1], '', $class );
				break;

			}

			if ( stripos( $class, $checks[2] ) !== FALSE ) {

				$return['type'] = 'svg';
				$return['name'] = str_replace( $checks[2], '', $class );
				break;

			}

		} // foreach

		return $return;

	} // get_icon_info()

	/**
	 * Returns the text position from the menu item class.
	 *
	 * @exits 		If $classes is empty.
	 * @param 		string 		$position 			The current text position.
	 * @param 		object 		$item				The menu item object.
	 * @param 		array 		$args 				The menu arguments.
	 * @return 		string 							The text position.
	 */
	public function get_text_position( $position, $item, $args ) {

		if ( empty( $item->classes ) ) { return; }

		if ( in_array( 'no-text', $item->classes ) ) { return 'hide'; }
		if ( in_array( 'text-left', $item->classes ) ) { return 'left'; }
		if ( in_array( 'text-right', $item->classes ) ) { return 'right'; }
		if ( in_array( 'text-coin', $item->classes ) ) { return 'coin'; }

		return;

	} // get_text_position()

	/**
	 * Add Plus ("+") expander to menus with children
	 *
	 * @exits 		If $args is empty.
	 * @exits 		If $args is not an array.
	 * @exits 		If not on the correct menu.
	 * @exits 		If 'menu-item-has-children' is not in the $classes array.
	 * @hooked 		walker_nav_menu_start_el 		10
	 * @param 		string 		$item_output		//
	 * @param 		object 		$item				//
	 * @param 		int 		$depth 				//
	 * @param 		array 		$args 				//
	 * @return 		string 							modified menu
	 */
	public function menu_show_hide( $item_output, $item, $depth, $args ) {

		if ( empty( $args ) || is_array( $args ) ) { return $item_output; }
		if ( 'belowslider' !== $args->theme_location ) { return $item_output; }
		if ( ! in_array( 'menu-item-has-children', $item->classes ) ) { return $item_output; }

		$atts 	= $this->get_attributes( $item );
		$output = '';

		$output .= '<a href="' . $item->url . '">';
		$output .= $item->title;
		$output .= '<span class="children">' . tillotson_get_svg( 'caret-down' ) . '</span>';
		$output .= '</a>';
		$output .= '<span class="show-hide flex-center">+</span>';

		return $output;

	} // menu_show_hide()

} // class
