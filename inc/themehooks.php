<?php

/**
 * A class of methods using hooks in the theme.
 *
 * @package Tillotson
 * @author Slushman <chris@slushman.com>
 */
class tillotson_Themehooks {

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->loader();

	}

	/**
	 * Loads all filter and action calls
	 */
	private function loader() {

		add_action( 'tillotson_header_content', 	array( $this, 'menu_social' ), 10 );
		add_action( 'tillotson_header_content', 	array( $this, 'site_branding' ), 15 );
		add_action( 'tillotson_header_content', 	array( $this, 'menu_primary' ), 20 );

		add_action( 'tha_header_after', 			array( $this, 'homepage_slider' ), 10 );
		add_action( 'tha_header_after', 			array( $this, 'homepage_promo_boxes' ), 15 );
		add_action( 'tha_header_after', 			array( $this, 'page_header' ), 15 );
		add_action( 'tha_header_after', 			array( $this, 'breadcrumbs' ), 20 );

		add_action( 'tha_body_top', 				array( $this, 'analytics_code' ) );

		add_action( 'tillotson_footer_content', 	array( $this, 'footer_logo' ), 10 );
		add_action( 'tillotson_footer_content', 	array( $this, 'site_description' ), 15 );
		add_action( 'tillotson_footer_content', 	array( $this, 'site_info' ), 20 );

	} // loader()

	/**
	 * Inserts Google Tag manager code after body tag
	 *
	 * @hooked 		tha_body_top 		10
	 *
	 * @return 		mixed 				The inserted Google Tag Manager code
	 */
	public function analytics_code() {

		$tag = get_theme_mod( 'tag_manager' );

		if ( ! empty( $tag ) ) {

			echo '<!-- Google Tag Manager -->';
			echo $tag;
			echo '<!-- Google Tag Manager -->';

		}

	} // analytics_code()

	/**
	 * Returns the appropriate breadcrumbs.
	 *
	 * @hooked		tha_header_after 			20
	 *
	 * @return 		mixed 						WooCommerce breadcrumbs, then Yoast breadcrumbs
	 */
	public function breadcrumbs() {

		if ( is_front_page() ) { return; }

		?><div class="breadcrumbs">
			<div class="wrap-crumbs"><?php

				if ( function_exists( 'woocommerce_breadcrumb' ) ) {

					$args['after'] 			= '</span>';
					$args['before'] 		= '<span rel="v:child" typeof="v:Breadcrumb">';
					$args['delimiter'] 		= '&nbsp;>&nbsp;';
					$args['home'] 			= esc_html_x( 'Home', 'breadcrumb', 'tillotson' );
					$args['wrap_after'] 	= '</span></span></nav>';
					$args['wrap_before'] 	= '<nav class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '><span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb">';

					woocommerce_breadcrumb( $args );

				} elseif ( function_exists( 'yoast_breadcrumb' ) ) {

					yoast_breadcrumb();

				}

			?></div><!-- .wrap-crumbs -->
		</div><!-- .breadcrumbs --><?php

	} // breadcrumbs()

	/**
	 * Adds the footer logo
	 *
	 * @hooked  	tillotson_footer_content 		10
	 *
	 * @return 		mixed 			HTML markup
	 */
	public function footer_logo() {

		?><div class="logo-years">
			<img src="<?php echo get_stylesheet_directory_uri() . '/images/100years.png'; ?>" alt="Tillotson 100-year Anniversary Logo" />
		</div><?php

	} // footer_logo()

	/**
	 * Adds three promo boxes to the home page.
	 *
	 * @hooked 		tha_header_after 		15
	 *
	 * @return 		mixed 					HTML markup
	 */
	public function homepage_promo_boxes() {

		if ( ! is_front_page() ) { return; }

		$mods = get_theme_mods();

		?><div class="divisions">
			<div class="wrap-divisions"><?php

			for ( $i = 1; $i <= 3; $i++ ) :

				if ( ! empty( $mods['promo_box_' . $i . '_url'] ) ) {

					$url = $mods['promo_box_' . $i . '_url'];

				} else {

					$url = '';

				}

				?><div class="division" id="promo-box-<?php echo esc_attr( $i ); ?>">
					<a class="link-<?php echo esc_attr( $i ); ?>" href="<?php echo esc_url( $url ); ?>">
						<div class="wrap-img">
							<img class="promo-box-logo" id="promo-box-' . $i . '-logo" src="<?php echo esc_url( $mods['promo_box_' . $i . '_logo'] ); ?>">
						</div>
						<div class="wrap-text">
							<span class="text-division" id="promo-box-'<?php echo esc_attr( $i ); ?>-text"><?php

								esc_html_e( $mods['promo_box_' . $i . '_text'], 'tillotson' );

							?></span>
						</div>
					</a>
				</div><?php

			endfor;

		?></div>
		</div><?php
/*
		global $tillotson_themekit;

		$categories['carbs'] 	= array( 'Lawn & Garden', 'carburetors', 'product_cat' );
		$categories['racing'] 	= array( 'Racing', 'racing', 'product_market' );
		$categories['power'] 	= array( 'Generators', 'generators', 'product_cat' );

		?><div class="divisions">
			<div class="wrap-divisions"><?php

			foreach ( $categories as $category => $info ) {

				?><div class="division <?php echo $category; ?>">
					<a class="link-<?php echo $category; ?>" href="<?php echo get_term_link( $info[1], $info[2] ); ?>">
						<div class="wrap-img"><?php

							echo $tillotson_themekit->get_home_logo( $category );

						?></div>
						<div class="wrap-text">
							<span class="text-division"><?php

								esc_html_e( $info[0], 'tillotson' );

							?></span>
						</div>
					</a>
				</div><?php

			} // foreach

			?></div>
		</div><?php
*/
	} // homepage_promo_boxes()

	/**
	 * Adds a slider to the homepage
	 *
	 * @hooked 		tha_header_after 		10
	 *
	 * @return 		mixed 					Soliloquy slider
	 */
	public function homepage_slider() {

		if ( ! is_front_page() ) { return; }

		if ( function_exists( 'soliloquy' ) ) { soliloquy( 'home', 'slug' ); }

	} // homepage_slider()

	/**
	 * Adds the main menu to the header
	 *
	 * @hooked 		tillotson_header_content 		20
	 *
	 * @return 		mixed 							Main nav menu
	 */
	public function menu_primary() {

		if ( ! has_nav_menu( 'primary' ) ) { return; }

		?><nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="dashicons dashicons-arrow-left"></span>
				<span class="dashicons dashicons-menu"></span>
				<span class="button-label"><?php esc_html_e( 'Menu', 'tillotson' ); ?></span>
			</button><?php

			$menu_args['menu_id'] 			= 'primary-menu';
			$menu_args['theme_location'] 	= 'primary';

			wp_nav_menu( $menu_args );

		?></nav><!-- #site-navigation --><?php

	} // menu_primary()

	/**
	 * Adds the Social Links Menu
	 *
	 * @hooked 		tillotson_header_content 		10
	 *
	 * @return 		mixed 							The social link menu
	 */
	public function menu_social() {

		if ( ! has_nav_menu( 'social' ) ) { return; }

		$menu_args['theme_location']	= 'social';
		$menu_args['container'] 		= 'div';
		$menu_args['container_id']    	= 'menu-social-media';
		$menu_args['container_class'] 	= 'menu nav-social';
		$menu_args['menu_id']         	= 'menu-social-media-items';
		$menu_args['menu_class']      	= 'menu-items';
		$menu_args['depth']           	= 1;
		$menu_args['fallback_cb']     	= '';

		wp_nav_menu( $menu_args );

	} // menu_social()

	/**
	 * Adds the page header
	 *
	 * @hooked 		tha_header_after 		15
	 *
	 * @return 		mixed 					HTML markup
	 */
	public function page_header() {

		if ( is_front_page() ) { return; }

		?><div class="header-page">
			<header class="page-header contentpage"><?php

				echo apply_filters( 'tillotson_precontent_title', the_title( '<h1 class="page-title">', '</h1>', FALSE ) );

			?></header>
		</div><?php

	} // page_header()

	/**
	 * Adds the site branding to the header
	 *
	 * @hooked 		tillotson_header_content	15
	 *
	 * @return 		mixed 						Site branding
	 */
	public function site_branding() {

		?><div class="site-branding">
			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="screen-reader-text"><?php esc_html_e( 'Return to the Tillotson homepage', 'tillotson' ); ?></span>
					<img src="<?php echo get_stylesheet_directory_uri() . '/images/logo.png'; ?>" class="logo-tillotson" alt="Tillotson Logo">
				</a>
			</h1>
		</div><!-- .site-branding --><?php

	} // site_branding()

	/**
	 * Adds the site branding to the header
	 *
	 * @hooked 		tillotson_footer_content	15
	 *
	 * @return 		mixed 						Site description
	 */
	public function site_description() {

		?><div class="site-description"><?php

			bloginfo( 'description' );

		?></div><?php

	} // site_description()

	/**
	 * Adds the site branding to the header
	 *
	 * @hooked 		tillotson_footer_content	20
	 *
	 * @return 		mixed 						Site description
	 */
	public function site_info() {

		global $tillotson_themekit;

		$mods 	= get_theme_mods();
		$print 	= array();
		$site 	= get_site_url();

		?><div class="site-info">
			<ul>
				<li>&copy <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( get_admin_url(), 'tillotson' ); ?>"><?php echo get_bloginfo( 'name' ); ?></a></li>
				<li><address><?php

				if ( ! empty( $mods['address_1'] ) ) {

					$print[] = $mods['address_1'];

				}

				if ( ! empty( $mods['city'] ) ) {

					$print[] = $mods['city'];

				}

				if ( 'US' === $mods['country'] ) {

					$print[] = $mods['us_state'];

				} else if( 'CA' === $mods['country'] ) {

					$print[] = $mods['canada_state'];

				} else if( 'AU' === $mods['country'] ) {

					$print[] = $mods['australia_state'];

				} else {

					$print[] = $mods['default_state'];

				}

				if ( ! empty( $mods['zip_code'] ) ) {

					$print[] = $mods['zip_code'];

				}

				if ( ! empty( $mods['country'] ) ) {

					$print[] = tillotson_country_list( $mods['country'] );

				}

				$print_this = implode( ', ', $print );

				echo $print_this;

				?></address></li>
				<li><?php echo $tillotson_themekit->make_phone_link( $mods['phone_number'] ); ?></li>
				<li><a href="mailto:<?php echo sanitize_email( $mods['email_address'] ); ?>"><?php esc_html_e( $mods['email_address'], 'tillotson' ); ?></a></li>
			</ul>
			<ul>
				<li><a href="<?php echo esc_url( get_site_url( '', 'privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'tillotson' ); ?></a></li>
				<li><a href="<?php echo esc_url( get_site_url( '', 'terms-and-conditions' ) ); ?>"><?php esc_html_e( 'Terms and Conditions', 'tillotson' ); ?></a></li>
			</ul>
		</div><!-- .site-info --><?php

	} // site_info()

} // class

$tillotson_Themehooks = new tillotson_Themehooks();
