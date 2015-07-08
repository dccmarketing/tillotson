<?php

/**
 * A class of helpful theme functions
 *
 * @package Tillotson
 * @author Slushman <chris@slushman.com>
 */
class tillotson_Themekit {

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->loader();

	}

	/**
	 * Loads all filter and action calls
	 *
	 * @return [type] [description]
	 */
	private function loader() {

		add_action( 'after_setup_theme', array( $this, 'more_setup' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'login_scripts_and_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'more_scripts_and_styles' ) );
		add_action( 'after_body', array( $this, 'analytics_code' ) );
		add_filter( 'post_mime_types', array( $this, 'add_mime_types' ) );
		add_filter( 'upload_mimes', array( $this, 'custom_upload_mimes' ) );
		add_filter( 'body_class', array( $this, 'page_body_classes' ) );
		//add_action( 'wp_head', array( $this, 'background_images' ) );
		add_action( 'wp_head', array( $this, 'add_favicons' ) );

		remove_action( 'wp_head', array( $this, 'print_emoji_detection_script', 7 ) );
		remove_action( 'admin_print_scripts', array( $this, 'print_emoji_detection_script' ) );

	} // loader()

	/**
	 * Additional theme setup
	 * @return 	void
	 */
	public function more_setup() {

		register_nav_menus( array(
			'social' => esc_html__( 'Social Links', 'tillotson' )
		) );

	} // more_setup()

	/**
	 * Enqueues login page scripts and styles
	 *
	 * @return 	void
	 */
	public function login_scripts_and_styles() {

		wp_enqueue_style( 'tillotson-login', get_stylesheet_directory_uri() . '/login.css' );

	} // login_scripts_and_styles()

	/**
	 * Enqueues additional scripts and styles
	 *
	 * @return 	void
	 */
	public function more_scripts_and_styles() {

		wp_enqueue_style( 'tillotson-fonts', $this->fonts_url(), array(), null );

	} // more_scripts_and_styles()



	/**
	 * Inserts Google Tag manager code after body tag
	 * @return 	mixed 		The inserted Google Tag Manager code
	 */
	public function analytics_code() { ?>

		<!-- paste code here -->

	<?php } // analytics_code()

	/**
	 * Properly encode a font URLs to enqueue a Google font
	 *
	 * @return 	mixed 		A properly formatted, translated URL for a Google font
	 */
	public function fonts_url() {

		$return 	= '';
		$families 	= '';
		$fonts[] 	= array( 'font' => 'Titillium Web', 'weights' => '400,300,700italic,700,600', 'translate' => esc_html_x( 'on', 'Titillium Web font: on or off', 'tillotson' ) );

		foreach ( $fonts as $font ) {

			if ( 'off' == $font['translate'] ) { continue; }

			$families[] = $font['font'] . ':' . $font['weights'];

		}

		if ( ! empty( $families ) ) {

			$query_args['family'] 	= urlencode( implode( '|', $families ) );
			$query_args['subset'] 	= urlencode( 'latin,latin-ext' );
			$return 				= add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		}

		return $return;

	} // fonts_url()

	/**
	 * Returns a post object of the requested post type
	 *
	 * @param 	string 		$post 			The name of the post type
	 * @param   array 		$params 		Optional parameters
	 * @return 	object 		A post object
	 */
	public function get_posts( $post, $params = array(), $cache = '' ) {

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

	} // get_posts()

	/**
	 * Returns the requested SVG
	 *
	 * @param 	string 		$svg 		The name of the icon to return
	 * @param 	string 		$link 		URL to link from the SVG
	 *
	 * @return 	mixed 					The SVG code
	 */
	public function get_svg( $svg, $link = '' ) {

		$output = '';

		switch ( $svg ) {

			case 'caret-down' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="caret-down"><path d="M15 8l-4.03 6L7 8h8z"/></svg>'; break;
			case 'caret-left' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="caret-left"><path d="M13 14L7 9.97 13 6v8z"/></svg>'; break;
			case 'caret-right' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="caret-right"><path d="M8 6l6 4.03L8 14V6z"/></svg>'; break;
			case 'caret-up' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="caret-up"><path d="M7 13l4.03-6L15 13H7z"/></svg>'; break;
			case 'cart' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="cart" aria-labelledby="title" role="link"><title id="title">Shopping Cart Link</title>' . $link . '<path d="M6 13h9q.41 0 .705.295T16 14t-.295.705T15 15H5q-.41 0-.705-.295T4 14V4H2q-.41 0-.705-.295T1 3t.295-.705T2 2h3q.41 0 .705.295T6 3v2h13l-4 7H6v1zm-.5 3q.62 0 1.06.44T7 17.5t-.44 1.06T5.5 19t-1.06-.44T4 17.5t.44-1.06T5.5 16zm9 0q.62 0 1.06.44T16 17.5t-.44 1.06-1.06.44-1.06-.44T13 17.5t.44-1.06T14.5 16z"/></svg>'; break;
			case 'email' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="email" aria-labelledby="title" role="link"><title id="title">Contact Us Link</title>' . $link . '<path d="M19 14.5v-9q0-.62-.44-1.06T17.5 4H3.49q-.62 0-1.06.44T1.99 5.5v9q0 .62.44 1.06t1.06.44H17.5q.62 0 1.06-.44T19 14.5zm-1.31-9.11q.15.15.175.325t-.04.295-.165.22L13.6 9.95l3.9 4.06q.26.3.06.51-.09.11-.28.12t-.28-.07l-4.37-3.73-2.14 1.95-2.13-1.95-4.37 3.73q-.09.08-.28.07t-.28-.12q-.2-.21.06-.51l3.9-4.06-4.06-3.72q-.1-.1-.165-.22t-.04-.295.175-.325q.4-.4.95.07l6.24 5.04 6.25-5.04q.55-.47.95-.07z"/></svg>'; break;
			case 'facebook' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="facebook" aria-labelledby="title" role="link"><title id="title">Facebook Link</title>' . $link . '<path d="M8.46 18h2.93v-7.3h2.45l.37-2.84h-2.82V6.04q0-.69.295-1.035T12.8 4.66h1.51V2.11Q13.36 2 12.12 2q-1.67 0-2.665.985T8.46 5.76v2.1H6v2.84h2.46V18z"/></svg>'; break;
			case 'facebooksquare' 	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="facebook" aria-labelledby="title" role="link"><title id="title">Facebook Link</title>' . $link . '<path d="M2.89 2h14.23q.37 0 .625.255T18 2.88v14.24q0 .36-.255.62t-.625.26h-4.08v-6.2h2.08l.31-2.41h-2.39V7.85q0-.59.25-.885t.95-.295h1.28V4.51q-.66-.09-1.86-.09-1.42 0-2.265.835T10.55 7.61v1.78H8.46v2.41h2.09V18H2.89q-.37 0-.63-.26T2 17.12V2.88q0-.37.26-.625T2.89 2z"/></svg>'; break;
			case 'flickr' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="flickr" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Flickr Link</title>' . $link . '<path d="M97.6 20.2v59.5c0 9.8-8 17.8-17.8 17.8H20.3c-9.8 0-17.8-8-17.8-17.8V20.2c0-9.8 8-17.8 17.8-17.8h59.5C89.6 2.3 97.6 10.3 97.6 20.2zM32.5 36.8c-7.2 0-13.1 5.9-13.1 13.1S25.3 63 32.5 63s13.1-5.9 13.1-13.1S39.8 36.8 32.5 36.8zM67.5 36.8c-7.2 0-13.1 5.9-13.1 13.1S60.2 63 67.5 63s13.1-5.9 13.1-13.1S74.7 36.8 67.5 36.8z"/>'; break;
			case 'gallery' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="gallery"><path d="M16 4h1.96q.43 0 .735.305T19 5.04v12.92q0 .43-.305.735T17.96 19H5.04q-.43 0-.735-.305T4 17.96V16H2.04q-.43 0-.735-.305T1 14.96V2.04q0-.43.305-.735T2.04 1h12.92q.43 0 .735.305T16 2.04V4zM3 14h11V3H3v11zm5-8.5q0-.62-.44-1.06T6.5 4t-1.06.44T5 5.5t.44 1.06T6.5 7t1.06-.44T8 5.5zm2 4.5q.02-.1.06-.28t.185-.7.305-.995.43-1.05.555-.99.67-.7T13 5v8H4V7q.56 0 .97.31t.6.75.3.88.12.75L6 10q.01-.04.025-.115t.08-.28.155-.395.255-.42.36-.395.49-.28T8 8q.47 0 .845.205t.58.5.345.59.19.505zm7 7V6h-1v8.96q0 .43-.305.735T14.96 16H6v1h11z"/></svg>'; break;
			case 'github' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="github" viewBox="0 0 512 512" enable-background="new 0 0 512 512" aria-labelledby="title" role="link"><title id="title">Github Link</title>' . $link . '<path d="M323.8 462c-10.9 2-14.5-4.7-14.5-10.3 0-7 0-30.1 0-58.9 0-20.1-6.7-32.9-14.5-39.6 47.7-5.3 97.9-23.4 97.9-105.8 0-23.4-8.4-42.7-22-57.5 2.2-5.6 9.5-27.3-2.2-56.9 -17.9-5.6-58.9 22-58.9 22 -17-4.7-35.4-7.3-53.6-7.3s-36.6 2.5-53.6 7.3c0 0-41-27.6-59.2-22 -11.4 29.6-4.2 51.3-2 56.9 -13.7 14.8-22 34-22 57.5 0 82 49.9 100.4 97.7 105.8 -6.1 5.6-11.7 14.8-13.7 28.7C191 387.5 159.7 397 141 364c-11.7-20.4-32.9-22-32.9-22 -20.9-0.3-1.4 13.1-1.4 13.1 14 6.4 23.7 31.2 23.7 31.2 12.6 38.2 72.3 25.4 72.3 25.4 0 17.9 0.3 34.9 0.3 39.9 0 5.6-3.9 12.3-14.8 10.3C103.1 433.5 41.7 353.2 41.7 258.6c0-118.3 96-214.3 214.3-214.3s214.3 96 214.3 214.3C470.3 353.2 408.9 433.5 323.8 462z"/>'; break;
			case 'googleplus' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="googleplus" aria-labelledby="title" role="link"><title id="title">Google Plus Link</title>' . $link . '<path d="M9.25 11.64q.88.62 1.23 1.28t.35 1.65q0 .62-.3 1.195t-.845 1.04-1.4.74-1.895.275q-1.26 0-2.31-.315t-1.685-.93-.635-1.405q0-1.28 1.3-2.265t3.14-.985q.14 0 .4-.005t.38-.005q-.61-.61-.61-1.26 0-.43.23-.86-.08.01-.22-.005t-.2-.015q-1.51 0-2.475-.97T2.74 6.43q0-.87.555-1.665t1.47-1.28T6.67 3h4.52l-1.01 1H8.74q.83.87 1.03 1.16.43.63.43 1.44 0 1.35-1.28 2.34-.53.42-.695.67t-.165.62q0 .28.395.705t.795.705zM6.83 9.37q.88.03 1.39-.76t.36-1.94q-.15-1.14-.87-1.95t-1.6-.84q-.88-.02-1.39.75t-.36 1.91q.15 1.15.875 1.98t1.595.85zM17 10v1h-2v2h-1v-2h-2v-1h2V8h1v2h2zM6.38 17.1q1.72 0 2.5-.635t.78-1.705q0-.22-.05-.47-.04-.16-.105-.295t-.18-.275-.205-.235-.28-.24-.295-.215-.365-.25-.38-.26q-.56-.18-1.12-.18-1.31-.02-2.3.685t-.99 1.665q0 1 .855 1.705t2.135.705z"/></svg>'; break;
			case 'instagram' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="instagram" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Instagram Link</title>' . $link . '<path d="M97.1 84.9c0 6.6-5.5 12.1-12.1 12.1H15C8.3 97 2.9 91.5 2.9 84.9V14.8C2.9 8.1 8.3 2.7 15 2.7h70.1c6.6 0 12.1 5.5 12.1 12.1V84.9zM86.5 42.6h-8.3c0.8 2.5 1.2 5.3 1.2 8C79.4 66.3 66.3 79 50.1 79c-16.1 0-29.3-12.7-29.3-28.4 0-2.8 0.4-5.5 1.2-8h-8.7v39.8c0 2.1 1.7 3.7 3.7 3.7h65.6c2.1 0 3.7-1.7 3.7-3.7V42.6zM50.1 31.3c-10.4 0-18.9 8.2-18.9 18.4S39.6 68 50.1 68c10.5 0 19-8.2 19-18.4S60.6 31.3 50.1 31.3zM86.5 17.4c0-2.3-1.9-4.2-4.2-4.2H71.5c-2.3 0-4.2 1.9-4.2 4.2v10.1c0 2.3 1.9 4.2 4.2 4.2h10.7c2.3 0 4.2-1.9 4.2-4.2V17.4z"/>'; break;
			case 'linkedin' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="linkedin" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">LinkedIn Link</title>' . $link . '<path d="M14.2 25.9H14c-6.8 0-11.2-4.7-11.2-10.5 0-6 4.5-10.5 11.4-10.5 6.9 0 11.2 4.5 11.3 10.5C25.6 21.2 21.2 25.9 14.2 25.9zM24.3 95H4V34.2h20.3V95zM97.1 95H77V62.5c0-8.2-2.9-13.8-10.3-13.8 -5.6 0-8.9 3.7-10.4 7.4 -0.5 1.4-0.7 3.1-0.7 5V95H35.5c0.2-55.1 0-60.8 0-60.8h20.2V43h-0.1c2.6-4.2 7.4-10.3 18.4-10.3 13.3 0 23.3 8.7 23.3 27.4V95z"/>'; break;
			case 'linkedinsquare' 	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="linkedinsquare" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">LinkedIn Link</title>' . $link . '<path d="M97.1 79.3c0 9.8-7.9 17.7-17.7 17.7H20.5c-9.8 0-17.7-7.9-17.7-17.7V20.4c0-9.8 7.9-17.7 17.7-17.7h58.9c9.8 0 17.7 7.9 17.7 17.7V79.3zM24.6 18.5c-4.8 0-8 3.2-8 7.4 0 4.1 3.1 7.4 7.9 7.4h0.1c5 0 8-3.3 8-7.4C32.4 21.7 29.4 18.5 24.6 18.5zM31.6 81.6V39H17.4v42.6H31.6zM82.6 81.6V57.2c0-13.1-7-19.2-16.3-19.2 -7.6 0-11 4.2-12.8 7.2h0.1V39H39.4c0 0 0.2 4 0 42.6h14.2V57.8c0-1.2 0.1-2.5 0.4-3.4 1-2.5 3.4-5.2 7.3-5.2 5.1 0 7.1 3.9 7.1 9.6v22.8H82.6z"/>'; break;
			case 'menu' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="menu"><path d="M17 7V5H3v2h14zm0 4V9H3v2h14zm0 4v-2H3v2h14z"/></svg>'; break;
			case 'phone' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="phone"><path d="M12.06 6l-.21-.2q-.26-.27-.32-.47t.035-.38.365-.45l2.72-2.75q.11-.11.275-.285t.235-.245.19-.175.185-.12.17-.035.195.03.21.13.27.22l.21.2zm.53.45l4.4-4.4q.21.28.415.595t.47.78.45.95.31 1 .1 1.04-.215.975q-.33.76-.59 1.175t-.695.93-.715.895q-2.26 2.57-6 6.07-.41.29-.9.725t-.915.705-1.185.57q-.43.17-.95.18t-1.035-.125T4.53 18.2t-.97-.445-.8-.455-.62-.4l4.4-4.4 1.18 1.62q.16.23.485.165t.66-.285.655-.54l.925-.93 1.18-1.185 1.045-1.065.85-.89q.32-.32.535-.65t.29-.655-.165-.495zM1.57 16.5l-.21-.21q-.15-.16-.235-.28t-.095-.245-.01-.195.11-.21.17-.205.27-.265.31-.3l2.74-2.72q.41-.39.635-.425t.635.315l.2.21z"/></svg>'; break;
			case 'pinterest' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="pinterest" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Pinterest Link</title>' . $link . '<path d="M50 97c-4.7 0-9.1-0.7-13.4-2 1.8-2.8 3.8-6.4 4.8-10.1 0 0 0.6-2.1 3.3-13 1.6 3.1 6.4 5.9 11.5 5.9 15.2 0 25.5-13.8 25.5-32.4 0-13.9-11.8-27-29.9-27 -22.3 0-33.6 16.1-33.6 29.5 0 8.1 3.1 15.3 9.6 18 1 0.4 2 0 2.3-1.2 0.2-0.8 0.7-2.9 1-3.7 0.3-1.2 0.2-1.6-0.7-2.6 -1.9-2.3-3.1-5.2-3.1-9.3 0-11.9 8.9-22.6 23.2-22.6 12.6 0 19.6 7.7 19.6 18.1 0 13.6-6 25-15 25 -4.9 0-8.6-4.1-7.4-9.1 1.4-6 4.2-12.4 4.2-16.7 0-3.9-2.1-7.1-6.4-7.1 -5 0-9.1 5.2-9.1 12.2 0 0 0 4.5 1.5 7.5 -5.2 21.9-6.1 25.7-6.1 25.7C31 85.7 31 89.7 31.1 93 14.5 85.7 2.9 69.2 2.9 49.8 2.9 23.8 24 2.7 50 2.7c26 0 47.1 21.1 47.1 47.1S76 97 50 97z"/>'; break;
			case 'pinterestsquare' 	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="pinterestsquare" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Pinterest Link</title>' . $link . '<path d="M97.1 20.4v58.9c0 9.8-7.9 17.7-17.7 17.7H35c2-2.9 5.3-7.9 6.6-12.9 0 0 0.6-2.1 3.3-12.8 1.7 3.1 6.4 5.8 11.4 5.8 15 0 25.2-13.7 25.2-32 0-13.8-11.7-26.7-29.5-26.7 -22.2 0-33.3 15.9-33.3 29.2 0 8 3.1 15.1 9.6 17.8 1 0.4 2 0 2.3-1.2 0.2-0.8 0.7-2.9 0.9-3.7 0.3-1.2 0.2-1.6-0.7-2.6 -1.8-2.3-3.1-5.1-3.1-9.2 0-11.8 8.8-22.3 23-22.3C63.1 26.4 70 34 70 44.2c0 13.4-6 24.8-14.8 24.8 -4.9 0-8.5-4.1-7.4-9 1.4-5.9 4.1-12.3 4.1-16.5 0-3.8-2-7-6.3-7 -5 0-9 5.2-9 12 0 0 0 4.4 1.5 7.4 -5.1 21.6-6 25.4-6 25.4C30.9 87 31.4 93.6 31.8 97H20.5c-9.8 0-17.7-7.9-17.7-17.7V20.4c0-9.8 7.9-17.7 17.7-17.7h58.9C89.2 2.7 97.1 10.6 97.1 20.4z"/>'; break;
			case 'reddit' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="reddit" viewBox="0 0 512 512" enable-background="new 0 0 512 512" aria-labelledby="title" role="link"><title id="title">Reddit Link</title>' . $link . '<path d="M476.5 297.6c0.8 5 1.3 10.3 1.3 15.3 0 40.7-23.9 78.3-66.8 106.5 -41.9 27.4-97.2 42.4-155.9 42.4 -58.8 0-114.3-15.1-155.9-42.4C55.9 391.3 32.3 353.6 32.3 313c0-5.5 0.5-11 1.3-16.6 -15.8-10-26.6-27.9-26.6-48 0-31.4 25.4-56.8 56.8-56.8 14.1 0 27.1 5.3 37.2 13.8 40.2-25.6 92.7-40.2 148.7-41.2l33.6-106.2c1.5-4.8 6.5-7.5 11.6-6.5l87.1 20.6c7.3-16.6 23.9-28.1 42.9-28.1 25.9 0 46.7 21.1 46.7 46.7 0 25.9-20.8 47-46.7 47 -25.6 0-46.5-20.8-46.7-46.5l-79.1-18.6 -29.1 91.9c53 2.3 102.5 16.8 140.6 41.7 10-9 23.4-14.6 37.9-14.6 31.4 0 56.8 25.4 56.8 56.8C505.1 269.5 493.6 287.9 476.5 297.6zM39 276.3c8-21.6 23.4-41.7 45.2-59 -5.8-4-13.1-6.3-20.6-6.3 -20.6 0-37.4 16.8-37.4 37.4C26.2 259.5 31.3 269.5 39 276.3zM458.4 313c0-33.6-20.6-65.8-58-90.1 -38.7-25.1-90.4-39.2-145.4-39.2 -55 0-106.7 14.1-145.4 39.2 -37.4 24.4-58 56.5-58 90.1 0 33.9 20.6 66 58 90.4 38.7 25.1 90.4 39.2 145.4 39.2 55 0 106.7-14.1 145.4-39.2C437.8 379 458.4 346.9 458.4 313zM181.2 320.2c-18.8 0-34.9-15.3-34.9-34.2 0-19.1 16.1-34.9 34.9-34.9 18.8 0 34.4 15.8 34.4 34.9C215.6 304.9 200 320.2 181.2 320.2zM336.4 370.2c3.8 3.8 3.8 10 0 13.8 -16.8 16.8-42.9 24.9-80.1 24.9h-0.5c-37.2 0-63.3-8-80.1-24.9 -3.8-3.8-3.8-10 0-13.8 3.8-3.8 9.8-3.8 13.6 0 13.1 13.1 34.7 19.3 66.5 19.3h0.5c31.6 0 53.5-6.3 66.5-19.3C326.6 366.5 332.6 366.5 336.4 370.2zM365.7 286.1c0 18.8-15.6 34.2-34.4 34.2 -18.8 0-34.9-15.3-34.9-34.2 0-19.1 16.1-34.9 34.9-34.9C350.2 251.2 365.7 267 365.7 286.1zM397.4 90.7c0 15.1 12.3 27.4 27.4 27.4s27.4-12.3 27.4-27.4 -12.3-27.4-27.4-27.4S397.4 75.7 397.4 90.7zM485.8 248.4c0-20.6-16.8-37.4-37.4-37.4 -8 0-15.6 2.5-21.6 7 21.6 17.3 36.9 37.7 44.7 59.8C480.2 270.8 485.8 260.2 485.8 248.4z"/>'; break;
			case 'search' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="search"><path d="M12.14 4.18q1.39 1.39 1.58 3.345t-.86 3.545q.03.03.155.14t.205.17q.34.27.81.59.62.43.66.47.61.45.94.78.49.49.84 1 .36.5.59 1.04.22.55.18 1-.03.48-.36.81t-.81.36q-.49.03-.99-.19-.52-.21-1.04-.59-.51-.35-1-.84-.33-.33-.77-.93-.02-.03-.47-.66-.32-.46-.56-.78-.24-.3-.44-.5-1.54.83-3.34.57t-3.1-1.55q-1.6-1.61-1.6-3.895t1.6-3.885q1.06-1.06 2.475-1.435t2.83 0T12.14 4.18zm-1.41 6.36q1.02-1.03 1.02-2.475T10.73 5.59Q9.7 4.56 8.25 4.56T5.78 5.59Q4.75 6.62 4.75 8.065t1.03 2.475q1.02 1.03 2.47 1.03t2.48-1.03z"/></svg>'; break;
			case 'slack' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="slack" viewBox="0 0 512 512" enable-background="new 0 0 512 512" aria-labelledby="title" role="link"><title id="title">Slack Link</title>' . $link . '<path d="M464.9 278.5c0 16.1-8.3 27.4-23.4 32.6L398.4 326l14.1 41.9c1.3 3.8 1.8 7.8 1.8 11.8 0 19.8-16.1 36.4-35.9 36.4 -15.8 0-29.9-9.8-34.9-24.9l-13.8-41.4 -77.8 26.6 13.8 41.2c1.3 3.8 2 7.8 2 11.8 0 19.6-16.1 36.4-36.2 36.4 -15.8 0-29.6-9.8-34.7-24.9l-13.8-40.9 -38.4 13.3c-4 1.3-8.3 2.3-12.6 2.3 -20.3 0-35.7-15.1-35.7-35.4 0-15.6 10-29.6 24.9-34.7l39.2-13.3L134 253.7l-39.2 13.6c-4 1.3-8 2-12.1 2 -20.1 0-35.7-15.3-35.7-35.4 0-15.6 10-29.6 24.9-34.7l39.4-13.3L98.1 146c-1.3-3.8-2-7.8-2-11.8 0-19.8 16.1-36.4 36.2-36.4 15.8 0 29.6 9.8 34.7 24.9l13.6 40.2 77.8-26.4 -13.6-40.2c-1.3-3.8-2-7.8-2-11.8 0-19.8 16.3-36.4 36.2-36.4 15.8 0 29.9 10 34.9 24.9l13.3 40.4 40.7-13.8c3.5-1 7-1.5 10.8-1.5 19.6 0 36.4 14.6 36.4 34.7 0 15.6-12.1 28.6-26.1 33.4l-39.4 13.6 26.4 79.4 41.2-14.1c3.8-1.3 7.8-2 11.6-2C449.1 242.9 464.9 258 464.9 278.5zM307 282.3l-26.4-79.1 -77.8 26.9 26.4 78.6L307 282.3z"/>'; break;
			case 'snapchat' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" class="snapchat" aria-labelledby="title" role="link"><title id="title">Snapchat Link</title>' . $link . '<path d="M71.9 43.8c0.8-0.2 1.7-0.8 2.5-0.8 1.3 0 2.7 0 3.8 0.5 1.9 0.9 2 3 0.3 4.3 -1.4 1-3.1 1.6-4.7 2.3 -3.6 1.4-4.1 2.4-2.3 5.8 3 5.6 7.2 9.8 13.7 11.4 0.7 0.2 1.7 0.9 1.7 1.3 -0.1 0.9-0.5 2.2-1.2 2.5 -2.2 1-4.5 1.9-6.8 2.4 -1.5 0.3-2 0.8-2.3 2.2 -0.7 2.9-1.2 3.3-4 2.7 -4.5-0.9-8.4-0.1-12.2 2.6 -7.7 5.5-13.4 5.5-21 0 -3.7-2.7-7.6-3.5-12-2.6 -2.9 0.6-3.5 0.2-4.2-2.8 -0.3-1.2-0.7-1.9-2.2-2.1 -2.2-0.4-4.4-1.1-6.5-2.1 -0.8-0.4-1.5-1.7-1.6-2.7 -0.1-0.4 1.3-1.3 2.2-1.5 6.9-1.9 11.2-6.6 14-12.9 0.7-1.5 0.1-2.5-1.1-3.2 -1.1-0.6-2.3-1-3.5-1.4 -0.7-0.3-1.5-0.6-2.2-1 -1.4-0.9-2.5-1.9-1.7-3.8 0.7-1.5 2.8-2.3 4.5-1.8 1 0.3 1.9 0.7 2.9 0.9 1.3 0.3 2-0.1 2-1.7 -0.1-3.6-0.3-7.1 0-10.7 0.6-7.5 5-12.4 11.7-15 9.7-3.8 21.4-0.9 26.6 8.5 1.8 3.3 2.1 6.9 2.3 10.5 -0.1 2.3-0.3 4.6-0.4 6.8C69.9 43.8 70.7 44.1 71.9 43.8z"/>'; break;
			case 'tumblr' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="tumblr" viewBox="0 0 512 512" enable-background="new 0 0 512 512" aria-labelledby="title" role="link"><title id="title">Tumblr Link</title>' . $link . '<path d="M398.9 462.5c-8.4 12.6-46.3 26.8-80.4 27.3C217.2 491.5 179 417.9 179 366V214.2h-46.9v-60c70.3-25.4 87.3-89 91.2-125.3 0.3-2.2 2.2-3.3 3.3-3.3 0 0 1.1 0 68.1 0v118.3h92.9v70.3h-93.2v144.5c0 19.5 7.3 46.6 44.6 45.8 12.3-0.3 28.7-3.9 37.4-8.1L398.9 462.5z"/>'; break;
			case 'twitter' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="twitter" aria-labelledby="title" role="link"><title id="title">Twitter Link</title>' . $link . '<path d="M18.94 4.46q-.75 1.12-1.83 1.9.01.15.01.47 0 1.47-.43 2.945T15.38 12.6t-2.1 2.39-2.93 1.66-3.66.62q-3.04 0-5.63-1.65.48.05.88.05 2.55 0 4.55-1.57-1.19-.02-2.125-.73T3.07 11.55q.39.07.69.07.47 0 .96-.13-1.27-.26-2.105-1.27T1.78 7.89v-.04q.8.43 1.66.46-.75-.51-1.19-1.315T1.81 5.25q0-1 .5-1.84Q3.69 5.1 5.655 6.115T9.87 7.24q-.1-.45-.1-.84 0-1.51 1.075-2.585T13.44 2.74q1.6 0 2.68 1.16 1.26-.26 2.33-.89-.43 1.32-1.62 2.02 1.07-.11 2.11-.57z"/></svg>'; break;
			case 'twittersquare' 	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="twittersquare" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Twitter Link</title>' . $link . '<path d="M97.1 79.3c0 9.8-7.9 17.7-17.7 17.7H20.5c-9.8 0-17.7-7.9-17.7-17.7V20.4c0-9.8 7.9-17.7 17.7-17.7h58.9c9.8 0 17.7 7.9 17.7 17.7V79.3zM74 34.4c2.7-1.6 4.7-4.2 5.7-7.2 -2.5 1.5-5.3 2.6-8.2 3.1 -2.3-2.5-5.7-4.1-9.4-4.1 -7.1 0-12.9 5.8-12.9 12.9 0 1 0.1 2 0.3 2.9 -10.7-0.6-20.3-5.6-26.6-13.5 -1.1 1.9-1.8 4.2-1.8 6.5 0 4.5 2.1 8.4 5.6 10.7 -2.1-0.1-4.2-0.7-6.1-1.6 0 0 0 0.1 0 0.1 0 6.3 4.7 11.5 10.6 12.6 -1.1 0.3-2 0.5-3.1 0.5 -0.8 0-1.6-0.1-2.4-0.2 1.7 5.1 6.4 8.8 12 9 -4.4 3.4-9.9 5.5-16 5.5 -1 0-2.1-0.1-3.1-0.2 5.7 3.6 12.5 5.8 19.8 5.8C62 77.3 75 57.7 75 40.6c0-0.6 0-1.1-0.1-1.7 2.5-1.8 4.7-4.1 6.4-6.7C79.1 33.3 76.6 34 74 34.4z"/>'; break;
			case 'vimeosquare' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="vimeosquare" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Vimeo Link</title>' . $link . '<path d="M97.1 79.3c0 9.8-7.9 17.7-17.7 17.7H20.5c-9.8 0-17.7-7.9-17.7-17.7V20.4c0-9.8 7.9-17.7 17.7-17.7h58.9c9.8 0 17.7 7.9 17.7 17.7V79.3zM78.5 25.8c-2.5-3.2-7.8-3.3-11.5-2.8 -2.9 0.5-13 4.9-16.4 15.5 6-0.5 9.2 0.4 8.6 7.1 -0.2 2.8-1.7 5.8-3.2 8.8 -1.8 3.4-5.2 10-9.7 5.2 -4-4.3-3.7-12.5-4.6-18 -0.6-3.1-1.1-6.9-2.1-10.1 -0.9-2.7-2.9-6-5.3-6.7 -2.6-0.7-5.9 0.4-7.8 1.5 -6 3.6-10 8.6-15.9 12.8v0.4c2 1 1.4 2.6 2.9 2.8 3.6 0.5 7.1-3.4 9.5 0.7 1.5 2.5 1.9 5.2 2.8 7.8 1.3 3.6 2.2 7.4 3.3 11.5 1.7 6.9 3.8 17.2 9.8 19.8 3 1.3 7.6-0.4 9.9-1.8 6.3-3.7 11.2-9 15.3-14.5C73.8 52.9 79 38.2 79.8 33.9 80.4 31 80.3 28.1 78.5 25.8z"/>'; break;
			case 'vine' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="vine" viewBox="0 0 512 512" enable-background="new 0 0 512 512" aria-labelledby="title" role="link"><title id="title">Vine Link</title>' . $link . '<path d="M459.4 306.2c-19.5 4.5-39.1 6.4-55.2 6.4 -39.1 82-109.1 152.3-132.5 165.5 -14.8 8.4-28.7 8.9-45.2-0.8C197.7 459.9 88.9 370.6 52.6 89.9h79c19.8 168.5 68.4 255 121.7 319.8 29.6-29.6 58-68.9 80.1-113.3 -52.7-26.8-84.8-85.7-84.8-154.3 0-69.5 39.9-121.9 108.3-121.9 66.4 0 102.7 41.3 102.7 112.4 0 26.5-5.6 56.6-16.2 79.8 0 0-49.1 9.8-67.2-21.8 3.6-12 8.6-32.6 8.6-51.3 0-33.2-12-49.4-30.1-49.4 -19.3 0-32.6 18.1-32.6 53 0 71.2 45.2 111.9 103.8 111.9 10.3 0 22-1.1 33.8-3.9V306.2z"/>'; break;
			case 'wordpress' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="wordpress" aria-labelledby="title" role="link"><title id="title">WordPress Link</title>' . $link . '<path d="M20 10q0-1.63-.505-3.155t-1.43-2.755-2.155-2.155-2.755-1.43T10 0 6.845.505 4.09 1.935 1.935 4.09.505 6.845 0 10t.505 3.155 1.43 2.755 2.155 2.155 2.755 1.43T10 20t3.155-.505 2.755-1.43 2.155-2.155 1.43-2.755T20 10zM10 1.01q1.83 0 3.495.71t2.87 1.915 1.915 2.87.71 3.495-.71 3.495-1.915 2.87-2.87 1.915-3.495.71-3.495-.71-2.87-1.915-1.915-2.87T1.01 10t.71-3.495 1.915-2.87 2.87-1.915T10 1.01zM8.01 14.82L4.96 6.61l1.05-.08q.2-.02.27-.275t-.025-.49-.305-.225q-1.29.1-2.13.1-.33 0-.52-.01Q4.4 3.97 6.17 3T10 2.03q1.54 0 2.935.55t2.475 1.54q-.52-.07-.985.305T13.96 5.54q0 .29.115.615t.225.525.37.61l.08.13q.5.87.5 2.21 0 .6-.315 1.72t-.635 1.94l-.32.82-2.71-7.5q.21-.01.4-.05t.27-.08l.08-.03q.2-.02.275-.295t-.025-.535-.3-.25q-1.3.11-2.14.11-.35 0-.875-.03L8.08 5.4l-.36-.03q-.2-.01-.3.255t-.025.54.275.285l.84.08 1.12 3.04zm6.02 2.15L16.64 10q.03-.07.07-.195t.15-.535.155-.82.08-1.05-.065-1.21q.94 1.7.94 3.81 0 2.19-1.065 4.05t-2.875 2.92zM2.68 6.77L6.5 17.25q-2.02-.99-3.245-2.945T2.03 10q0-1.79.65-3.23zm7.45 4.53l2.29 6.25q-1.17.42-2.42.42-1.03 0-2.06-.3z"/></svg>'; break;
			case 'youtube' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="youtube" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">YouTube Link</title>' . $link . '<path d="M89.5 90.4c-1 4.4-4.6 7.6-8.8 8 -10.2 1.2-20.4 1.2-30.7 1.2 -10.2 0-20.5 0-30.7-1.2 -4.3-0.4-7.8-3.6-8.8-8 -1.4-6.2-1.4-13-1.4-19.3 0-6.4 0.1-13.2 1.4-19.3 1-4.4 4.6-7.6 8.9-8.1 10.1-1.1 20.4-1.1 30.6-1.1 10.2 0 20.5 0 30.7 1.1 4.3 0.5 7.8 3.7 8.8 8.1 1.4 6.2 1.4 12.9 1.4 19.3C90.9 77.4 90.9 84.2 89.5 90.4zM32.4 57.3v-5.2H15.2v5.2H21v31.4h5.5V57.3H32.4zM41.4 0.5l-6.7 22v15h-5.5v-15c-0.5-2.7-1.6-6.6-3.4-11.7C24.6 7.4 23.4 4 22.3 0.5h5.9L32 15.1l3.8-14.5H41.4zM47.4 88.7V61.4h-4.9v20.9c-1.1 1.5-2.2 2.3-3.1 2.3 -0.7 0-1-0.4-1.2-1.2 -0.1-0.2-0.1-0.8-0.1-1.9V61.4h-4.9V83c0 1.9 0.2 3.2 0.4 4 0.4 1.4 1.6 2 3.2 2 1.8 0 3.6-1.1 5.6-3.4v3H47.4zM56.2 28.6c0 2.9-0.5 5.1-1.5 6.5 -1.4 1.9-3.3 2.8-5.9 2.8 -2.5 0-4.4-0.9-5.8-2.8 -1-1.4-1.5-3.6-1.5-6.5v-9.7c0-2.9 0.5-5.1 1.5-6.5 1.4-1.9 3.3-2.8 5.8-2.8 2.5 0 4.5 0.9 5.9 2.8 1 1.4 1.5 3.5 1.5 6.5V28.6zM51.2 17.9c0-2.5-0.7-3.8-2.4-3.8 -1.6 0-2.4 1.3-2.4 3.8v11.6c0 2.5 0.8 3.9 2.4 3.9 1.7 0 2.4-1.3 2.4-3.9V17.9zM66.1 69.7c0-2.5-0.1-4.4-0.5-5.5 -0.6-2-2-3.1-3.9-3.1 -1.8 0-3.5 1-5.1 3v-12h-4.9v36.6h4.9v-2.7c1.7 2 3.4 3 5.1 3 1.9 0 3.3-1 3.9-3 0.4-1.2 0.5-3 0.5-5.5V69.7zM61.2 80.9c0 2.5-0.7 3.7-2.2 3.7 -0.8 0-1.7-0.4-2.5-1.2V66.8c0.8-0.8 1.7-1.2 2.5-1.2 1.4 0 2.2 1.3 2.2 3.7V80.9zM74.8 37.6h-5v-3c-2 2.3-3.9 3.4-5.7 3.4 -1.6 0-2.8-0.7-3.3-2 -0.3-0.8-0.4-2.2-0.4-4.1V10h5v20.3c0 1.2 0 1.8 0.1 1.9 0.1 0.8 0.5 1.2 1.2 1.2 1 0 2-0.8 3.1-2.4V10h5V37.6zM84.8 79.3h-5c0 2-0.1 3.1-0.1 3.4 -0.3 1.3-1 2-2.2 2 -1.7 0-2.5-1.3-2.5-3.8V76h9.9v-5.7c0-2.9-0.5-5-1.5-6.4 -1.4-1.9-3.4-2.8-5.9-2.8 -2.5 0-4.5 0.9-5.9 2.8 -1 1.4-1.5 3.5-1.5 6.4v9.6c0 2.9 0.6 5.1 1.6 6.4 1.4 1.9 3.4 2.8 6 2.8 2.6 0 4.6-1 6-2.9 0.6-0.9 1-1.9 1.2-3 0.1-0.5 0.1-1.6 0.1-3.2V79.3zM79.9 71.9h-5v-2.5c0-2.5 0.8-3.8 2.5-3.8 1.7 0 2.5 1.3 2.5 3.8V71.9z"/>'; break;
			case 'youtubesquare'	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="youtubesquare" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">YouTube Link</title>' . $link . '<path d="M97.1 79.3c0 9.8-7.9 17.7-17.7 17.7H20.5c-9.8 0-17.7-7.9-17.7-17.7V20.4c0-9.8 7.9-17.7 17.7-17.7h58.9c9.8 0 17.7 7.9 17.7 17.7V79.3zM82.6 50.7c-0.9-3.6-3.8-6.3-7.3-6.6 -8.3-0.9-16.8-0.9-25.3-0.9 -8.4 0-16.9 0-25.2 0.9 -3.6 0.4-6.5 3-7.3 6.6 -1.2 5.1-1.2 10.7-1.2 16 0 5.2 0 10.8 1.2 16 0.8 3.6 3.7 6.2 7.2 6.6 8.4 0.9 16.9 0.9 25.3 0.9 8.4 0 16.9 0 25.3-0.9 3.5-0.4 6.4-3.1 7.2-6.6 1.2-5.2 1.2-10.7 1.2-16C83.8 61.4 83.8 55.8 82.6 50.7zM35.5 55.3h-4.9v26h-4.5v-26h-4.8V51h14.2V55.3zM42.9 8.5h-4.6l-3.1 12L32 8.5h-4.8c0.9 2.8 2 5.6 2.9 8.5 1.5 4.3 2.4 7.5 2.8 9.7V39h4.5V26.7L42.9 8.5zM47.9 81.3h-4.1v-2.5c-1.6 1.8-3.1 2.8-4.7 2.8 -1.3 0-2.2-0.6-2.6-1.7 -0.2-0.7-0.4-1.7-0.4-3.3V58.7h4.1v16.6c0 0.9 0 1.5 0.1 1.6 0.1 0.6 0.4 0.9 0.9 0.9 0.9 0 1.7-0.6 2.6-1.9V58.7h4.1V81.3zM55.2 23.7c0-2.4-0.4-4.2-1.3-5.3 -1.2-1.5-2.8-2.3-4.8-2.3 -2.1 0-3.7 0.8-4.8 2.3 -0.9 1.2-1.3 2.9-1.3 5.3v8c0 2.4 0.4 4.2 1.3 5.3 1.1 1.5 2.7 2.3 4.8 2.3 2 0 3.6-0.8 4.8-2.3 0.9-1.1 1.3-2.9 1.3-5.3V23.7zM51 32.5c0 2.1-0.7 3.1-2 3.1 -1.4 0-2-1-2-3.1v-9.6c0-2.1 0.6-3.2 2-3.2 1.3 0 2 1.1 2 3.2V32.5zM63.3 74.5c0 2-0.1 3.6-0.4 4.5 -0.5 1.7-1.6 2.6-3.3 2.6 -1.4 0-2.8-0.9-4.2-2.5v2.2h-4.1V51h4.1v9.9c1.3-1.6 2.7-2.5 4.2-2.5 1.7 0 2.8 0.9 3.3 2.6 0.3 0.9 0.4 2.4 0.4 4.5V74.5zM59.3 65.2c0-2-0.6-3.1-1.8-3.1 -0.7 0-1.4 0.3-2 1v13.8c0.7 0.7 1.4 1 2 1 1.2 0 1.8-1 1.8-3V65.2zM70.4 39V16.3h-4.1v17.4c-0.9 1.3-1.8 1.9-2.6 1.9 -0.6 0-0.9-0.3-1-1 -0.1-0.1-0.1-0.6-0.1-1.6V16.3h-4.1v18c0 1.6 0.1 2.6 0.4 3.4 0.4 1.1 1.3 1.7 2.6 1.7 1.5 0 3.1-0.9 4.7-2.8V39H70.4zM78.7 74c0 1.4-0.1 2.2-0.1 2.6 -0.1 0.9-0.4 1.7-0.9 2.5 -1.1 1.7-2.8 2.5-4.9 2.5 -2.1 0-3.8-0.8-5-2.3 -0.9-1.1-1.3-2.9-1.3-5.3V66c0-2.4 0.4-4.1 1.2-5.3 1.2-1.5 2.8-2.3 4.9-2.3 2 0 3.7 0.8 4.8 2.3 0.9 1.2 1.3 2.9 1.3 5.3v4.7h-8.2v4c0 2.1 0.7 3.1 2.1 3.1 1 0 1.6-0.6 1.8-1.6 0-0.2 0.1-1.2 0.1-2.8h4.2V74zM74.6 67.3v-2.1c0-2.1-0.7-3.1-2-3.1 -1.3 0-2 1-2 3.1v2.1H74.6z"/>'; break;

			// Insert theme-specific SVGs
			case 'brochure' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="36.87" height="51.774" viewBox="0 0 36.87 51.774" class="brochure"><path d="M28.596 6.316h-19.8s19.277-3.51 19.8-3.51v3.51zM2.512 9.04h31.846v40.223H2.512V9.04zM0 5.47v46.305h36.87V6.525h-5.864V0L0 5.47z"/><path d="M6.7 17.553V13.23h4.167L6.7 17.552zm8.284-6.072c-.197-.462-.655-.765-1.158-.765h-8.38c-.692 0-1.256.56-1.256 1.256v8.695c0 .512.31.975.785 1.166.155.063.31.092.47.092.337 0 .664-.136.905-.386l8.38-8.694c.35-.36.45-.9.254-1.36M30.167 45.073H26.08l4.087-4.088v4.088zm1.74-8.285c-.47-.192-1.012-.086-1.372.273l-8.38 8.38c-.36.36-.47.9-.273 1.37.196.468.654.775 1.162.775h8.38c.695 0 1.255-.562 1.255-1.256v-8.382c0-.506-.306-.965-.774-1.16M29.853 25.892c0-.69-.565-1.257-1.256-1.257H9.112c-.692 0-1.257.566-1.257 1.257 0 .696.565 1.26 1.257 1.26h19.484c.692 0 1.257-.564 1.257-1.26"/></svg>'; break;
			case 'diamonds' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="42.079" height="32.674" viewBox="0 0 42.079 32.674" class="diamonds"><path d="M17.947 15.876l-.522.904.406.71.524-.842-.407-.772zm7.045-2.363L22.138 8.48l-.71 1.25 2.833 5.044.732-1.26zm-2.98 11.258l2.94-4.824-.74-1.266-2.9 4.863.7 1.228zm20.053-8.053l-.002.002-.092-.16.095.157zm.014.014L32.713.064h-5.812L25.71 2.18l2.822 5.14 1.214-2.128 6.073 10.556.484.904-.003.025-6.744 11.184-1.065-1.82-2.925 4.907.958 1.663h6.066l9.297-15.594.187-.28-.002-.004h.007z"/><path d="M18.394 15.748l.485.904-.004.025L12.13 27.86 5.687 16.78 12.32 5.192l6.074 10.556zm6.246.97l-.093-.16.094.16zm.014.013L15.29.064H9.477L0 16.78l9.098 15.83h6.065l9.3-15.594.186-.28-.003-.004h.007z"/><path fill="#007AC2" d="M16.292 13.15l-2.778-4.83-4.858 8.397 4.55 7.978 2.97-4.876-1.96-3.167 2.076-3.504zm17.005 3.63l-4.802-8.296-.007.012L23.818 0h-5.495l-1.205 2.087 2.773 4.936 1.085-1.83 6.603 11.64-6.603 10.84-1.2-1.647L16.87 30.9l1.2 1.773h5.75l9.477-15.894z"/></svg>'; break;
			case 'logo' 			: $output .= ''; break;
			case 'manuals' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="37.787" height="39.852" viewBox="0 0 37.787 39.852" class="manuals"><path d="M35.85 35.25c-.508.502-1.327.51-1.836 0-.5-.51-.51-1.32-.008-1.837.517-.5 1.336-.5 1.845 0 .51.51.51 1.328 0 1.837m1.11-3.03l.026-.01L23.5 18.665l6.12-6.12 5.462-3.525 2.18-3.91-2.53-2.528-3.907 2.18-3.525 5.47-6.112 6.11-6.073-6.087-.025-8.05L6.863 0l-.876.878 4.378 4.367L6.097 9.52 1.72 5.154l-.876.868 2.203 8.23 7.834.014-.05.06 6.18 6.206-2.287 2.287-1.494-1.504-2.315 2.322.717.71c-2.077.794-7.807 6.53-8.608 8.603l-.718-.71L0 34.547l5.31 5.305 2.313-2.313-.725-.718c2.078-.785 7.816-6.53 8.61-8.602l.717.717 2.313-2.312-1.494-1.495 2.28-2.28L32.8 36.38l.025-.02c1.144 1.112 2.98 1.112 4.1-.023 1.136-1.128 1.144-2.957.034-4.117"/></svg>'; break;
			case 'news' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="37.696" height="32.4" viewBox="0 0 37.696 32.4" class="news"><path d="M31.827 26.89c0 1.392-1.133 2.526-2.526 2.526H5.513c-1.395 0-2.527-1.134-2.527-2.527V5.51c0-1.393 1.133-2.526 2.527-2.526h23.79c1.393 0 2.525 1.133 2.525 2.527v21.38zm2.966-21.807C34.573 2.243 32.195 0 29.3 0H5.513C2.472 0 0 2.472 0 5.51v21.38c0 3.038 2.473 5.51 5.512 5.51h26.674c3.038 0 5.51-2.472 5.51-5.51V9.933c0-2.095-1.176-3.92-2.903-4.85"/><path d="M5.994 11.183h.062c.43 0 .777-.348.777-.778v-2.74l2.322 3.197c.146.2.38.32.628.32h.155c.43 0 .777-.347.777-.777V5.3c0-.43-.347-.778-.776-.778h-.06c-.43 0-.777.348-.777.778v2.74L6.78 4.843c-.146-.202-.38-.32-.628-.32H5.995c-.43 0-.778.347-.778.777v5.105c0 .43.348.778.777.778M15.478 9.628h-2.424V8.583h1.98c.43 0 .776-.348.776-.777v-.063c0-.43-.348-.777-.777-.777h-1.98V6.14h2.32c.43 0 .777-.348.777-.778V5.3c0-.43-.347-.778-.776-.778h-3.16c-.43 0-.777.348-.777.777v5.105c0 .43.348.778.777.778h3.264c.43 0 .777-.35.777-.778 0-.428-.35-.777-.777-.777M18.96 11.183h.095c.334 0 .63-.213.737-.53l.972-2.884.967 2.883c.105.317.402.53.736.53h.094c.333 0 .63-.212.736-.528l1.732-5.106c.08-.238.04-.5-.105-.703-.146-.204-.38-.325-.632-.325h-.078c-.335 0-.632.215-.738.533l-.96 2.895-.962-2.896c-.105-.317-.403-.532-.738-.532h-.107c-.336 0-.633.215-.738.533l-.96 2.895-.963-2.896c-.106-.317-.403-.532-.738-.532h-.08c-.25 0-.485.12-.632.325-.146.203-.185.465-.104.702l1.73 5.105c.106.316.403.528.736.528M27.588 11.183c1.723 0 2.494-1.003 2.494-1.99.012-1.542-1.33-1.948-2.132-2.19-.89-.27-.974-.377-.974-.595 0-.13.31-.27.774-.27.31 0 .677.09.892.22.364.22.836.108 1.06-.252l.03-.047c.11-.176.146-.39.098-.59-.05-.203-.176-.378-.353-.486-.476-.29-1.12-.463-1.727-.463-1.65 0-2.39.948-2.39 1.887 0 1.5 1.27 1.885 2.11 2.14.915.277.996.387.994.638 0 .26-.456.38-.878.38-.41 0-.86-.175-1.12-.436-.147-.147-.345-.23-.55-.23h-.002c-.206 0-.404.082-.55.228l-.043.042c-.145.147-.228.347-.227.555.002.208.086.407.235.552.576.56 1.442.906 2.26.906M14.04 13.448H6.648c-.823 0-1.49.668-1.49 1.492s.667 1.492 1.49 1.492h7.394c.825 0 1.493-.668 1.493-1.492s-.668-1.492-1.492-1.492M14.04 18.42H6.648c-.823 0-1.49.67-1.49 1.493 0 .824.667 1.492 1.49 1.492h7.394c.825 0 1.493-.668 1.493-1.492s-.668-1.492-1.492-1.492M14.04 23.395H6.648c-.823 0-1.49.668-1.49 1.492s.667 1.492 1.49 1.492h7.394c.825 0 1.493-.67 1.493-1.493 0-.825-.668-1.492-1.492-1.492M29.22 13.237H17.816c-.477 0-.864.387-.864.864v11.625c0 .477.388.863.864.863h11.4c.478 0 .864-.386.864-.863V14.1c.002-.476-.385-.863-.86-.863"/></svg>'; break;

		} // switch

		if ( ! empty( $link ) ) {

			$output .= '</a>';

		}

		$output .= '</svg>';

		return $output;

		return $output;

	} // get_svg()

	/**
	 * Echos the requested SVG
	 *
	 * @param 	string 		$svg 		The name of the icon to return
	 * @param 	string 		$link 		URL to link from the SVG
	 *
	 * @return 	mixed 					The SVG code
	 */
	public function the_svg( $svg, $link = '' ) {

		echo $this->get_svg( $svg, $link = '' );

	} // the_svg()

	/**
	 * Returns the URL of the featured image
	 *
	 * @param 	int 		$postID 		The post ID
	 * @param 	string 		$size 			The image size to return
	 *
	 * @return 	string | bool 				The URL of the featured image, otherwise FALSE
	 */
	public function get_thumbnail_url( $postID, $size = 'thumbnail' ) {

		if ( empty( $postID ) ) { return FALSE; }

		$thumb_id = get_post_thumbnail_id( $postID );

		if ( empty( $thumb_id ) ) { return FALSE; }

		$thumb_array = wp_get_attachment_image_src( $thumb_id, $size, true );

		if ( empty( $thumb_array ) ) { return FALSE; }

		return $thumb_array[0];

	} // get_thumbnail_url()

	/**
	 * Returns an array of the featured image details
	 *
	 * @param 	int 	$postID 		The post ID
	 *
	 * @return 	array 					Array of info about the featured image
	 */
	public function get_featured_images( $postID ) {

		if ( empty( $postID ) ) { return FALSE; }

		$imageID = get_post_thumbnail_id( $postID );

		if ( empty( $imageID ) ) { return FALSE; }

		return wp_prepare_attachment_for_js( $imageID );

	} // get_bg_image()

	/**
	 * Prints whatever in a nice, readable format
	 */
	public function pretty( $input ) {

		echo '<pre>'; print_r( $input ); echo '</pre>';

	} // pretty()

	/**
	 * Reduce the length of a string by character count
	 *
	 * @param 	string 		$text 		The string to reduce
	 * @param 	int 		$limit 		Max amount of characters to allow
	 * @param 	string 		$after 		Text for after the limit
	 * @return 	string 					The possibly reduced string
	 */
	public function shorten_text( $text, $limit = 100, $after = '...' ) {

		$length = strlen( $text );
		$text 	= substr( $text, 0, $limit );

		if ( $length > $limit ) {

			$text = $text . $after;

		} // Ellipsis

		return $text;

	} // shorten_text()

	/**
	 * Adds PDF as a filter for the Media Library
	 *
	 * @param 	array 		$post_mime_types 		The current MIME types
	 * @return 	array 								The modified MIME types
	 */
	public function add_mime_types( $post_mime_types ) {

	    $post_mime_types['application/pdf'] = array( esc_html__( 'PDFs', 'tillotson' ), esc_html__( 'Manage PDFs', 'tillotson' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
	    $post_mime_types['text/x-vcard'] = array( esc_html__( 'vCards', 'tillotson' ), esc_html__( 'Manage vCards', 'tillotson' ), _n_noop( 'vCard <span class="count">(%s)</span>', 'vCards <span class="count">(%s)</span>' ) );

	    return $post_mime_types;

	} // add_mime_types

	/**
	 * [custom_upload_mimes description]
	 * @param  array  $existing_mimes [description]
	 * @return [type]                 [description]
	 */
	public function custom_upload_mimes( $existing_mimes = array() ) {

		// add your extension to the array
		$existing_mimes['vcf'] = 'text/x-vcard';

		return $existing_mimes;

	} // custom_upload_mimes()

	/**
	 * Adds the name of the page or post to the body classes.
	 *
	 * @global 	$post						The $post object
	 * @param 	array 		$classes 		Classes for the body element.
	 * @return 	array 						The modified body class array
	 */
	public function page_body_classes( $classes ) {

		global $post;

		if ( empty( $post->post_content ) ) {

			$classes[] = 'content-none';

		} else {

			$classes[] = $post->post_name;

		}

		return $classes;

	} // page_body_classes()

	/**
	 * Creates a style tag in the header with the background image
	 *
	 * @return 		void
	 */
	public function background_images() {

		$output = '';
		$image 	= $this->get_thumbnail_url( get_the_ID(), 'full' );

		if ( ! $image ) {

			$image = get_theme_mod( 'default_bg_image' );

		}

		if ( ! empty( $image ) ) {

			$output .= '<style>';
			$output .= '@media screen and (min-width:768px){.site-header{background-image:url(' . $image . ');}';
			$output .= '</style>';

		}

		echo $output;

	}

	/**
	 * Creates links to all favicons
	 *
	 * PUT THEM IN A "FAVICONS" FOLDER AT THE ROOT!
	 *
	 * @link 	http://iconogen.com/
	 * @return 	mixed 			HTML for favicon links
	 */
	public function add_favicons() {

		?><link rel="shortcut icon" href="/favicons/favicon.ico" type="image/x-icon" />

		<link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-touch-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-touch-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon-180x180.png">

		<link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="/favicons/favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="/favicons/android-chrome-192x192.png" sizes="192x192">

		<meta name="msapplication-square70x70logo" content="/favicons/smalltile.png" />
		<meta name="msapplication-square150x150logo" content="/favicons/mediumtile.png" />
		<meta name="msapplication-wide310x150logo" content="/favicons/widetile.png" />
		<meta name="msapplication-square310x310logo" content="/favicons/largetile.png" /><?php

	}

	/**
	 * Converts formatted phone numbers to just numbers for tel links
	 *
	 * @param 	string 		$number 			A formatted phone number
	 * @return 	string 							The number minus characters besides numbers
	 */
	public function make_number( $number ) {

		if ( empty( $number ) ) { return FALSE; }

		$return = '';

		$return = preg_replace( '/[^0-9]/', '', $number );

		return $return;

	} // make_number()

	/**
	 * Limits excerpt length
	 *
	 * @param 	int 		$length 			The current word length of the excerpt
	 * @return 	int 							The word length of the excerpt
	 */
	public function excerpt_length( $length ) {

		if ( is_home() || is_front_page() ) {

			return 30;

		} else {

			return $length;

		}

	} // excerpt_length()
} // class

/**
 * Make an instance so its ready to be used
 */
$tillotson_themekit = new tillotson_Themekit();

