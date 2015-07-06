<?php if ( has_nav_menu( 'social' ) ) {

	$menu['theme_location']		= 'social';
	$menu['container'] 			= 'div';
	$menu['container_id']    	= 'menu-social-media';
	$menu['container_class'] 	= 'menu nav-social';
	$menu['menu_id']         	= 'menu-social-media-items';
	$menu['menu_class']      	= 'menu-items';
	$menu['depth']           	= 1;
	$menu['fallback_cb']     	= '';

	wp_nav_menu( $menu );

}