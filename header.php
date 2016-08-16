<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till the breadcrumbs
 *
 * @package Tillotson
 */

/**
 * The tha_html_before action hook
 */
do_action( 'tha_html_before' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head><?php

/**
 * The tha_head_top action hook
 */
do_action( 'tha_head_top' );

	?><meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"><?php

	wp_head();

/**
 * The tha_head_bottom action hook
 */
do_action( 'tha_head_bottom' );

?></head>

<body <?php body_class(); ?>><?php

/**
 * The tha_body_top action hook
 *
 * @hooked 			analytics_code
 */
do_action( 'tha_body_top' );

	?><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'tillotson' ); ?></a>
	<div id="page" class="hfeed site"><?php

		/**
		 * The tha_header_before action hook
		 *
		 * @hooked 		menu_social 		15
		 */
		do_action( 'tha_header_before' );

		?><header id="masthead" class="site-header" role="banner"><?php

			/**
			 * The tha_header_top action hook
			 */
			do_action( 'tha_header_top' );

			?><div class="wrap wrap-header"><?php

				/**
				 * The tillotson_header_content action hook
				 *
				 * @hooked 		menu_social 		10
				 * @hooked 		site_branding 		15
				 * @hooked 		menu_primary 		20
				 */
				do_action( 'tillotson_header_content' );

			?></div><!-- .header_wrap --><?php

			/**
			 * The tha_header_bottom action hook
			 */
			do_action( 'tha_header_bottom' );

		?></header><!-- #masthead --><?php

		/**
		 * The tha_header_after action hook
		 *
		 * @hooked 		homepage_slider 		10
		 * @hooked 		homepage_promo_boxes 	15
		 * @hooked 		page_header 			15
		 * @hooked 		breadcrumbs 			20
		 */
		do_action( 'tha_header_after' );

		/**
		 * The tha_content_before action hook
		 */
		do_action( 'tha_content_before' );

		?><div id="content" class="site-content"><?php

			/**
			 * The tha_content_top action hook
			 */
			do_action( 'tha_content_top' );

			?><div class="wrap wrap-content"><?php

				/**
				 * The tillotson_content_wrap_begin action hook
				 */
				do_action( 'tillotson_content_wrap_begin' );
