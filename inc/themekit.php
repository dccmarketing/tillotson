<?php

/**
 * A class of helpful theme functions
 *
 * @package DocBlock
 * @author Slushman <chris@slushman.com>
 */
class function_names_Themekit {

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
		add_action( 'login_enqueue_scripts', array( $this, 'more_scripts_and_styles' ) );
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
	 * Enqueues additional scripts and styles
	 *
	 * @return 	void
	 */
	public function more_scripts_and_styles() {

		wp_enqueue_style( 'scriptname-login', get_stylesheet_directory_uri() . '/login.css' );
		// wp_enqueue_style( 'scriptname-fonts', fonts_url(), array(), null );

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
		$fonts[] 	= array( 'font' => 'Oxygen', 'weights' => '400,700', 'translate' => esc_html_x( 'on', 'Oxygen font: on or off', 'tillotson' ) );

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

			case 'caret-down' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="caret-down" viewBox="0 0 100 100" enable-background="new 0 0 100 100"><path d="M96.8 37.7L54.3 80.2C53.1 81.4 51.6 82 50 82c-1.6 0-3.1-0.7-4.3-1.8L3.2 37.7c-1.1-1.1-1.8-2.7-1.8-4.3 0-3.3 2.8-6.1 6.1-6.1h85c3.3 0 6.1 2.8 6.1 6.1C98.6 35.1 97.9 36.6 96.8 37.7z"/>'; break;
			case 'caret-left' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="caret-left"><path d="M76.4 92.6c0 3.3-2.8 6.1-6.1 6.1-1.6 0-3.1-.7-4.3-1.8L23.5 54.4c-1.1-1.1-1.8-2.7-1.8-4.3 0-1.6.7-3.1 1.8-4.3L66 3.3c1.1-1.1 2.7-1.8 4.3-1.8 3.3 0 6.1 2.8 6.1 6.1v85z"/>'; break;
			case 'caret-right' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="caret-right" viewBox="0 0 100 100" enable-background="new 0 0 100 100"><path d="M69.8 53.4L32.3 90.9c-1 1-2.3 1.6-3.8 1.6 -2.9 0-5.4-2.4-5.4-5.4v-75c0-2.9 2.4-5.4 5.4-5.4 1.4 0 2.8 0.6 3.8 1.6l37.5 37.5c1 1 1.6 2.3 1.6 3.8S70.8 52.4 69.8 53.4z"/>'; break;
			case 'email' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 12.5 100 75" class="email "aria-labelledby="title" role="link"><title id="title">Contact Us Link</title>' . $link . '<path d="M96.5 27.5h-55c-1.7 0-3.4 1.4-3.8 3.1l-7.8 38c-.4 1.7.8 3.1 2.5 3.1h55c1.7 0 3.4-1.4 3.8-3.1l7.8-38c.4-1.7-.7-3.1-2.5-3.1zm-6.6 12.7L65.5 52c-1.1.5-2.3.5-3.1 0L42.9 40.2c-1.4-.9-1.6-2.8-.4-4.4.8-1.1 2-1.7 3.3-1.7.5 0 1 .1 1.5.4l18.2 10.9 22.5-11c.5-.3 1.1-.4 1.6-.4 1.2 0 2.2.7 2.5 1.7.6 1.6-.4 3.6-2.2 4.5zM9.3 35.8H33c1.3 0 2.3-1 2.3-2.3s-1-2.3-2.3-2.3H9.3c-1.3 0-2.3 1-2.3 2.3s1 2.3 2.3 2.3zm17.3 16.1H2.9c-1.3 0-2.3 1-2.3 2.3s1 2.3 2.3 2.3h23.7c1.3 0 2.3-1 2.3-2.3s-1-2.3-2.3-2.3zm5.5-8.2c0-1.3-1-2.3-2.3-2.3H15.6c-1.3 0-2.3 1-2.3 2.3s1 2.3 2.3 2.3h14.2c1.3 0 2.3-1 2.3-2.3zm-8.6 18.4h-7.6c-1.3 0-2.3 1-2.3 2.3s1 2.3 2.3 2.3h7.6c1.3 0 2.3-1 2.3-2.3-.1-1.3-1.1-2.3-2.3-2.3z"/>'; break;
			case 'facebook'			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="facebook" viewBox="0 0 113 113" enable-background="new 0 0 113 113" aria-labelledby="title" role="link"><title id="title">Facebook Link</title>' . $link . '<path d="M82.2 21.1H72.1c-7.9 0-9.4 3.8-9.4 9.2v12.1h18.8l-2.5 19H62.8v48.7H43.1V61.5H26.8v-19h16.4v-14c0-16.2 9.9-25.1 24.5-25.1 6.9 0 12.9 0.5 14.6 0.8V21.1z"/>'; break;
			case 'facebooksqaure' 	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="facebooksquare" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Facebook Link</title>' . $link . '<path d="M79.5 97H67.7V59.6h12.5L82 45.9H67.7v-8.8c0-4.1 1.7-6.9 7.6-6.9l8.1-0.1V17.5c-2-0.2-5.9-0.6-11-0.6 -10.9 0-18.4 6.6-18.4 18.8v10.2H40.2v13.8h13.8V97H20.5c-9.8 0-17.7-7.9-17.7-17.7V20.4c0-9.8 7.9-17.7 17.7-17.7h58.9c9.8 0 17.7 7.9 17.7 17.7v58.9C97.1 89.1 89.2 97 79.5 97z"/>'; break;
			case 'flickr' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="flickr" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Flickr Link</title>' . $link . '<path d="M97.6 20.2v59.5c0 9.8-8 17.8-17.8 17.8H20.3c-9.8 0-17.8-8-17.8-17.8V20.2c0-9.8 8-17.8 17.8-17.8h59.5C89.6 2.3 97.6 10.3 97.6 20.2zM32.5 36.8c-7.2 0-13.1 5.9-13.1 13.1S25.3 63 32.5 63s13.1-5.9 13.1-13.1S39.8 36.8 32.5 36.8zM67.5 36.8c-7.2 0-13.1 5.9-13.1 13.1S60.2 63 67.5 63s13.1-5.9 13.1-13.1S74.7 36.8 67.5 36.8z"/>'; break;
			case 'gallery' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" class="gallery"><path d="M80 20h9.8c1.4 0 2.7.5 3.7 1.5s1.5 2.2 1.5 3.7v64.6c0 1.4-.5 2.7-1.5 3.7S91.3 95 89.8 95H25.2c-1.4 0-2.7-.5-3.7-1.5S20 91.3 20 89.8V80h-9.8c-1.4 0-2.7-.5-3.7-1.5S5 76.3 5 74.8V10.2c0-1.4.5-2.7 1.5-3.7S8.7 5 10.2 5h64.6c1.4 0 2.7.5 3.7 1.5S80 8.7 80 10.2V20zM15 70h55V15H15v55zm35-20c.1-.3.2-.8.3-1.4.1-.6.4-1.8.9-3.5s1-3.4 1.5-5 1.2-3.3 2.2-5.2 1.8-3.6 2.8-5c.9-1.4 2.1-2.5 3.3-3.5s2.6-1.4 4-1.4v40H20V35c1.9 0 3.5.5 4.8 1.5s2.4 2.3 3 3.8 1.1 2.9 1.5 4.4.6 2.7.6 3.8V50c0-.1.1-.3.1-.6.1-.2.2-.7.4-1.4s.5-1.3.8-2c.3-.6.7-1.3 1.3-2.1.5-.8 1.1-1.4 1.8-2s1.5-1 2.5-1.4c1-.4 2-.6 3.2-.6 1.6 0 3 .3 4.2 1 1.2.7 2.2 1.5 2.9 2.5.7 1 1.3 2 1.7 3 .5 1 .8 1.8 1 2.5L50 50zM37.8 32.8c1.5-1.5 2.2-3.2 2.2-5.3 0-2.1-.7-3.8-2.2-5.3S34.6 20 32.5 20s-3.8.7-5.3 2.2c-1.5 1.5-2.2 3.2-2.2 5.3 0 2.1.7 3.8 2.2 5.3 1.5 1.5 3.2 2.2 5.3 2.2s3.8-.7 5.3-2.2zM85 85V30h-5v44.8c0 1.4-.5 2.7-1.5 3.7S76.3 80 74.8 80H30v5h55z"/>'; break;
			case 'github' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="github" viewBox="0 0 512 512" enable-background="new 0 0 512 512" aria-labelledby="title" role="link"><title id="title">Github Link</title>' . $link . '<path d="M323.8 462c-10.9 2-14.5-4.7-14.5-10.3 0-7 0-30.1 0-58.9 0-20.1-6.7-32.9-14.5-39.6 47.7-5.3 97.9-23.4 97.9-105.8 0-23.4-8.4-42.7-22-57.5 2.2-5.6 9.5-27.3-2.2-56.9 -17.9-5.6-58.9 22-58.9 22 -17-4.7-35.4-7.3-53.6-7.3s-36.6 2.5-53.6 7.3c0 0-41-27.6-59.2-22 -11.4 29.6-4.2 51.3-2 56.9 -13.7 14.8-22 34-22 57.5 0 82 49.9 100.4 97.7 105.8 -6.1 5.6-11.7 14.8-13.7 28.7C191 387.5 159.7 397 141 364c-11.7-20.4-32.9-22-32.9-22 -20.9-0.3-1.4 13.1-1.4 13.1 14 6.4 23.7 31.2 23.7 31.2 12.6 38.2 72.3 25.4 72.3 25.4 0 17.9 0.3 34.9 0.3 39.9 0 5.6-3.9 12.3-14.8 10.3C103.1 433.5 41.7 353.2 41.7 258.6c0-118.3 96-214.3 214.3-214.3s214.3 96 214.3 214.3C470.3 353.2 408.9 433.5 323.8 462z"/>'; break;
			case 'googleplus' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="googleplus" viewBox="0 0 512 512" enable-background="new 0 0 512 512" aria-labelledby="title" role="link"><title id="title">Google Plus Link</title>' . $link . '<path d="M310 366.3c0 15.3-4.5 30.4-12.1 43.4 -25.9 43.9-79.9 59.5-127.8 59.5 -37.7 0-84.1-9.8-105-44.9 -6-9.8-9.3-21.3-9.3-32.9 0-28.4 17.6-52 40.9-66.5 29.4-18.3 67.5-22.9 101.5-25.1 -8.8-11.6-15.8-21.8-15.8-36.9 0-8 2.3-14.3 5.3-21.3 -5.8 0.5-11.3 1-17.1 1 -49 0-88.1-35.7-88.1-85.6 0-27.6 13.1-54.7 33.9-72.8 27.1-23.4 65.5-32.6 100.4-32.6h105l-34.7 22.1h-32.9c23.4 19.8 37.7 41.9 37.7 73.6 0 65-59.5 72.3-59.5 104.2C232.4 284.5 310 295.5 310 366.3zM274.4 387.7c0-33.9-33.6-54.5-58-72.1 -4-0.5-8-0.5-12.1-0.5 -40.9 0-101.7 13.1-101.7 64.8 0 49 53 66.5 93.7 66.5C233.4 446.4 274.4 430.9 274.4 387.7zM231.9 212.1c10.3-11 13.3-25.1 13.3-39.9 0-37.2-21.8-100.2-67-100.2 -14.1 0-28.6 7-37.2 18.1 -9 11.3-11.8 26.1-11.8 40.2 0 37.7 21.3 96.9 66.5 96.9C208.3 227.2 223.1 221.2 231.9 212.1zM453.2 226.5v27.1h-53.5v55h-26.4v-55h-53.2v-27.1h53.2V172h26.4v54.5H453.2z"/>'; break;
			case 'hamburger' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="hamburger" viewBox="0 0 100 100" enable-background="new 0 0 100 100"><path d="M97.1 21.3c0 2.1-1.8 3.9-3.9 3.9H6.8c-2.1 0-3.9-1.8-3.9-3.9v-7.9c0-2.1 1.8-3.9 3.9-3.9h86.4c2.1 0 3.9 1.8 3.9 3.9V21.3zM97.1 52.8c0 2.1-1.8 3.9-3.9 3.9H6.8c-2.1 0-3.9-1.8-3.9-3.9v-7.9c0-2.1 1.8-3.9 3.9-3.9h86.4c2.1 0 3.9 1.8 3.9 3.9V52.8zM97.1 84.2c0 2.1-1.8 3.9-3.9 3.9H6.8c-2.1 0-3.9-1.8-3.9-3.9v-7.9c0-2.1 1.8-3.9 3.9-3.9h86.4c2.1 0 3.9 1.8 3.9 3.9V84.2z"/>'; break;
			case 'instagram' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="instagram" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Instagram Link</title>' . $link . '<path d="M97.1 84.9c0 6.6-5.5 12.1-12.1 12.1H15C8.3 97 2.9 91.5 2.9 84.9V14.8C2.9 8.1 8.3 2.7 15 2.7h70.1c6.6 0 12.1 5.5 12.1 12.1V84.9zM86.5 42.6h-8.3c0.8 2.5 1.2 5.3 1.2 8C79.4 66.3 66.3 79 50.1 79c-16.1 0-29.3-12.7-29.3-28.4 0-2.8 0.4-5.5 1.2-8h-8.7v39.8c0 2.1 1.7 3.7 3.7 3.7h65.6c2.1 0 3.7-1.7 3.7-3.7V42.6zM50.1 31.3c-10.4 0-18.9 8.2-18.9 18.4S39.6 68 50.1 68c10.5 0 19-8.2 19-18.4S60.6 31.3 50.1 31.3zM86.5 17.4c0-2.3-1.9-4.2-4.2-4.2H71.5c-2.3 0-4.2 1.9-4.2 4.2v10.1c0 2.3 1.9 4.2 4.2 4.2h10.7c2.3 0 4.2-1.9 4.2-4.2V17.4z"/>'; break;
			case 'linkedin' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="linkedin" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">LinkedIn Link</title>' . $link . '<path d="M14.2 25.9H14c-6.8 0-11.2-4.7-11.2-10.5 0-6 4.5-10.5 11.4-10.5 6.9 0 11.2 4.5 11.3 10.5C25.6 21.2 21.2 25.9 14.2 25.9zM24.3 95H4V34.2h20.3V95zM97.1 95H77V62.5c0-8.2-2.9-13.8-10.3-13.8 -5.6 0-8.9 3.7-10.4 7.4 -0.5 1.4-0.7 3.1-0.7 5V95H35.5c0.2-55.1 0-60.8 0-60.8h20.2V43h-0.1c2.6-4.2 7.4-10.3 18.4-10.3 13.3 0 23.3 8.7 23.3 27.4V95z"/>'; break;
			case 'linkedinsquare' 	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="linkedinsquare" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">LinkedIn Link</title>' . $link . '<path d="M97.1 79.3c0 9.8-7.9 17.7-17.7 17.7H20.5c-9.8 0-17.7-7.9-17.7-17.7V20.4c0-9.8 7.9-17.7 17.7-17.7h58.9c9.8 0 17.7 7.9 17.7 17.7V79.3zM24.6 18.5c-4.8 0-8 3.2-8 7.4 0 4.1 3.1 7.4 7.9 7.4h0.1c5 0 8-3.3 8-7.4C32.4 21.7 29.4 18.5 24.6 18.5zM31.6 81.6V39H17.4v42.6H31.6zM82.6 81.6V57.2c0-13.1-7-19.2-16.3-19.2 -7.6 0-11 4.2-12.8 7.2h0.1V39H39.4c0 0 0.2 4 0 42.6h14.2V57.8c0-1.2 0.1-2.5 0.4-3.4 1-2.5 3.4-5.2 7.3-5.2 5.1 0 7.1 3.9 7.1 9.6v22.8H82.6z"/>'; break;
			case 'pinterest' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="pinterest" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Pinterest Link</title>' . $link . '<path d="M50 97c-4.7 0-9.1-0.7-13.4-2 1.8-2.8 3.8-6.4 4.8-10.1 0 0 0.6-2.1 3.3-13 1.6 3.1 6.4 5.9 11.5 5.9 15.2 0 25.5-13.8 25.5-32.4 0-13.9-11.8-27-29.9-27 -22.3 0-33.6 16.1-33.6 29.5 0 8.1 3.1 15.3 9.6 18 1 0.4 2 0 2.3-1.2 0.2-0.8 0.7-2.9 1-3.7 0.3-1.2 0.2-1.6-0.7-2.6 -1.9-2.3-3.1-5.2-3.1-9.3 0-11.9 8.9-22.6 23.2-22.6 12.6 0 19.6 7.7 19.6 18.1 0 13.6-6 25-15 25 -4.9 0-8.6-4.1-7.4-9.1 1.4-6 4.2-12.4 4.2-16.7 0-3.9-2.1-7.1-6.4-7.1 -5 0-9.1 5.2-9.1 12.2 0 0 0 4.5 1.5 7.5 -5.2 21.9-6.1 25.7-6.1 25.7C31 85.7 31 89.7 31.1 93 14.5 85.7 2.9 69.2 2.9 49.8 2.9 23.8 24 2.7 50 2.7c26 0 47.1 21.1 47.1 47.1S76 97 50 97z"/>'; break;
			case 'pinterestsquare' 	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="pinterestsquare" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Pinterest Link</title>' . $link . '<path d="M97.1 20.4v58.9c0 9.8-7.9 17.7-17.7 17.7H35c2-2.9 5.3-7.9 6.6-12.9 0 0 0.6-2.1 3.3-12.8 1.7 3.1 6.4 5.8 11.4 5.8 15 0 25.2-13.7 25.2-32 0-13.8-11.7-26.7-29.5-26.7 -22.2 0-33.3 15.9-33.3 29.2 0 8 3.1 15.1 9.6 17.8 1 0.4 2 0 2.3-1.2 0.2-0.8 0.7-2.9 0.9-3.7 0.3-1.2 0.2-1.6-0.7-2.6 -1.8-2.3-3.1-5.1-3.1-9.2 0-11.8 8.8-22.3 23-22.3C63.1 26.4 70 34 70 44.2c0 13.4-6 24.8-14.8 24.8 -4.9 0-8.5-4.1-7.4-9 1.4-5.9 4.1-12.3 4.1-16.5 0-3.8-2-7-6.3-7 -5 0-9 5.2-9 12 0 0 0 4.4 1.5 7.4 -5.1 21.6-6 25.4-6 25.4C30.9 87 31.4 93.6 31.8 97H20.5c-9.8 0-17.7-7.9-17.7-17.7V20.4c0-9.8 7.9-17.7 17.7-17.7h58.9C89.2 2.7 97.1 10.6 97.1 20.4z"/>'; break;
			case 'reddit' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="reddit" viewBox="0 0 512 512" enable-background="new 0 0 512 512" aria-labelledby="title" role="link"><title id="title">Reddit Link</title>' . $link . '<path d="M476.5 297.6c0.8 5 1.3 10.3 1.3 15.3 0 40.7-23.9 78.3-66.8 106.5 -41.9 27.4-97.2 42.4-155.9 42.4 -58.8 0-114.3-15.1-155.9-42.4C55.9 391.3 32.3 353.6 32.3 313c0-5.5 0.5-11 1.3-16.6 -15.8-10-26.6-27.9-26.6-48 0-31.4 25.4-56.8 56.8-56.8 14.1 0 27.1 5.3 37.2 13.8 40.2-25.6 92.7-40.2 148.7-41.2l33.6-106.2c1.5-4.8 6.5-7.5 11.6-6.5l87.1 20.6c7.3-16.6 23.9-28.1 42.9-28.1 25.9 0 46.7 21.1 46.7 46.7 0 25.9-20.8 47-46.7 47 -25.6 0-46.5-20.8-46.7-46.5l-79.1-18.6 -29.1 91.9c53 2.3 102.5 16.8 140.6 41.7 10-9 23.4-14.6 37.9-14.6 31.4 0 56.8 25.4 56.8 56.8C505.1 269.5 493.6 287.9 476.5 297.6zM39 276.3c8-21.6 23.4-41.7 45.2-59 -5.8-4-13.1-6.3-20.6-6.3 -20.6 0-37.4 16.8-37.4 37.4C26.2 259.5 31.3 269.5 39 276.3zM458.4 313c0-33.6-20.6-65.8-58-90.1 -38.7-25.1-90.4-39.2-145.4-39.2 -55 0-106.7 14.1-145.4 39.2 -37.4 24.4-58 56.5-58 90.1 0 33.9 20.6 66 58 90.4 38.7 25.1 90.4 39.2 145.4 39.2 55 0 106.7-14.1 145.4-39.2C437.8 379 458.4 346.9 458.4 313zM181.2 320.2c-18.8 0-34.9-15.3-34.9-34.2 0-19.1 16.1-34.9 34.9-34.9 18.8 0 34.4 15.8 34.4 34.9C215.6 304.9 200 320.2 181.2 320.2zM336.4 370.2c3.8 3.8 3.8 10 0 13.8 -16.8 16.8-42.9 24.9-80.1 24.9h-0.5c-37.2 0-63.3-8-80.1-24.9 -3.8-3.8-3.8-10 0-13.8 3.8-3.8 9.8-3.8 13.6 0 13.1 13.1 34.7 19.3 66.5 19.3h0.5c31.6 0 53.5-6.3 66.5-19.3C326.6 366.5 332.6 366.5 336.4 370.2zM365.7 286.1c0 18.8-15.6 34.2-34.4 34.2 -18.8 0-34.9-15.3-34.9-34.2 0-19.1 16.1-34.9 34.9-34.9C350.2 251.2 365.7 267 365.7 286.1zM397.4 90.7c0 15.1 12.3 27.4 27.4 27.4s27.4-12.3 27.4-27.4 -12.3-27.4-27.4-27.4S397.4 75.7 397.4 90.7zM485.8 248.4c0-20.6-16.8-37.4-37.4-37.4 -8 0-15.6 2.5-21.6 7 21.6 17.3 36.9 37.7 44.7 59.8C480.2 270.8 485.8 260.2 485.8 248.4z"/>'; break;
			case 'search' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" class="search"><path d="M89.3 97.1c-1.9 0-3.7-.8-5-2.1L65.1 75.9c-6.5 4.5-14.3 6.9-22.3 6.9-21.7 0-39.3-17.6-39.3-39.3 0-21.7 17.6-39.3 39.3-39.3 21.7 0 39.3 17.6 39.3 39.3 0 7.9-2.4 15.7-6.9 22.3l19.1 19.1c1.3 1.3 2.1 3.1 2.1 5 0 4-3.2 7.2-7.1 7.2zM42.9 18.5c-13.8 0-25 11.2-25 25s11.2 25 25 25 25-11.2 25-25c0-13.7-11.3-25-25-25z"/>'; break;
			case 'slack' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="slack" viewBox="0 0 512 512" enable-background="new 0 0 512 512" aria-labelledby="title" role="link"><title id="title">Slack Link</title>' . $link . '<path d="M464.9 278.5c0 16.1-8.3 27.4-23.4 32.6L398.4 326l14.1 41.9c1.3 3.8 1.8 7.8 1.8 11.8 0 19.8-16.1 36.4-35.9 36.4 -15.8 0-29.9-9.8-34.9-24.9l-13.8-41.4 -77.8 26.6 13.8 41.2c1.3 3.8 2 7.8 2 11.8 0 19.6-16.1 36.4-36.2 36.4 -15.8 0-29.6-9.8-34.7-24.9l-13.8-40.9 -38.4 13.3c-4 1.3-8.3 2.3-12.6 2.3 -20.3 0-35.7-15.1-35.7-35.4 0-15.6 10-29.6 24.9-34.7l39.2-13.3L134 253.7l-39.2 13.6c-4 1.3-8 2-12.1 2 -20.1 0-35.7-15.3-35.7-35.4 0-15.6 10-29.6 24.9-34.7l39.4-13.3L98.1 146c-1.3-3.8-2-7.8-2-11.8 0-19.8 16.1-36.4 36.2-36.4 15.8 0 29.6 9.8 34.7 24.9l13.6 40.2 77.8-26.4 -13.6-40.2c-1.3-3.8-2-7.8-2-11.8 0-19.8 16.3-36.4 36.2-36.4 15.8 0 29.9 10 34.9 24.9l13.3 40.4 40.7-13.8c3.5-1 7-1.5 10.8-1.5 19.6 0 36.4 14.6 36.4 34.7 0 15.6-12.1 28.6-26.1 33.4l-39.4 13.6 26.4 79.4 41.2-14.1c3.8-1.3 7.8-2 11.6-2C449.1 242.9 464.9 258 464.9 278.5zM307 282.3l-26.4-79.1 -77.8 26.9 26.4 78.6L307 282.3z"/>'; break;
			case 'snapchat' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" class="snapchat" aria-labelledby="title" role="link"><title id="title">Snapchat Link</title>' . $link . '<path d="M71.9 43.8c0.8-0.2 1.7-0.8 2.5-0.8 1.3 0 2.7 0 3.8 0.5 1.9 0.9 2 3 0.3 4.3 -1.4 1-3.1 1.6-4.7 2.3 -3.6 1.4-4.1 2.4-2.3 5.8 3 5.6 7.2 9.8 13.7 11.4 0.7 0.2 1.7 0.9 1.7 1.3 -0.1 0.9-0.5 2.2-1.2 2.5 -2.2 1-4.5 1.9-6.8 2.4 -1.5 0.3-2 0.8-2.3 2.2 -0.7 2.9-1.2 3.3-4 2.7 -4.5-0.9-8.4-0.1-12.2 2.6 -7.7 5.5-13.4 5.5-21 0 -3.7-2.7-7.6-3.5-12-2.6 -2.9 0.6-3.5 0.2-4.2-2.8 -0.3-1.2-0.7-1.9-2.2-2.1 -2.2-0.4-4.4-1.1-6.5-2.1 -0.8-0.4-1.5-1.7-1.6-2.7 -0.1-0.4 1.3-1.3 2.2-1.5 6.9-1.9 11.2-6.6 14-12.9 0.7-1.5 0.1-2.5-1.1-3.2 -1.1-0.6-2.3-1-3.5-1.4 -0.7-0.3-1.5-0.6-2.2-1 -1.4-0.9-2.5-1.9-1.7-3.8 0.7-1.5 2.8-2.3 4.5-1.8 1 0.3 1.9 0.7 2.9 0.9 1.3 0.3 2-0.1 2-1.7 -0.1-3.6-0.3-7.1 0-10.7 0.6-7.5 5-12.4 11.7-15 9.7-3.8 21.4-0.9 26.6 8.5 1.8 3.3 2.1 6.9 2.3 10.5 -0.1 2.3-0.3 4.6-0.4 6.8C69.9 43.8 70.7 44.1 71.9 43.8z"/>'; break;
			case 'telephone' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="telephone" viewBox="0 0 100 100" enable-background="new 0 0 100 100"><path d="M95.1 86.5c-1.4 3.3-5.2 5.4-8.2 7.1 -4 2.1-8 3.4-12.5 3.4 -6.2 0-11.9-2.5-17.5-4.6 -4.1-1.5-8-3.3-11.7-5.6 -11.4-7-25.1-20.8-32.1-32.1C10.8 51 9 47 7.5 43c-2.1-5.7-4.6-11.3-4.6-17.5 0-4.5 1.3-8.5 3.4-12.5 1.7-3 3.8-6.8 7.1-8.2 2.2-1 6.9-2.1 9.3-2.1 0.5 0 0.9 0 1.4 0.2C25.5 3.4 27 6.7 27.6 8c2.1 3.8 4.2 7.7 6.4 11.5 1.1 1.7 3.1 3.9 3.1 6 0 4.1-12.1 10-12.1 13.7 0 1.8 1.7 4.2 2.6 5.8C34.4 57 42.8 65.5 55 72.2c1.6 0.9 4 2.6 5.8 2.6 3.6 0 9.6-12.1 13.7-12.1 2.1 0 4.2 2 6 3.1 3.8 2.2 7.6 4.3 11.5 6.4 1.3 0.7 4.6 2.1 5.1 3.5 0.2 0.5 0.2 0.9 0.2 1.4C97.2 79.6 96.1 84.3 95.1 86.5z"/>'; break;
			case 'tumblr' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="tumblr" viewBox="0 0 512 512" enable-background="new 0 0 512 512" aria-labelledby="title" role="link"><title id="title">Tumblr Link</title>' . $link . '<path d="M398.9 462.5c-8.4 12.6-46.3 26.8-80.4 27.3C217.2 491.5 179 417.9 179 366V214.2h-46.9v-60c70.3-25.4 87.3-89 91.2-125.3 0.3-2.2 2.2-3.3 3.3-3.3 0 0 1.1 0 68.1 0v118.3h92.9v70.3h-93.2v144.5c0 19.5 7.3 46.6 44.6 45.8 12.3-0.3 28.7-3.9 37.4-8.1L398.9 462.5z"/>'; break;
			case 'twitter' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="twitter" viewBox="0 0 113 113" enable-background="new 0 0 113 113" aria-labelledby="title" role="link"><title id="title">Twitter Link</title>' . $link . '<path d="M101.2 33.6c0.1 1 0.1 2 0.1 3 0 30.5-23.2 65.6-65.6 65.6 -13.1 0-25.2-3.8-35.4-10.4 1.9 0.2 3.6 0.3 5.6 0.3 10.8 0 20.7-3.6 28.6-9.9 -10.1-0.2-18.6-6.9-21.6-16 1.4 0.2 2.9 0.4 4.4 0.4 2.1 0 4.1-0.3 6.1-0.8C12.7 63.7 4.8 54.4 4.8 43.2c0-0.1 0-0.2 0-0.3 3.1 1.7 6.6 2.8 10.4 2.9C9 41.7 4.9 34.6 4.9 26.6c0-4.3 1.1-8.2 3.1-11.6 11.4 14 28.4 23.1 47.6 24.1 -0.4-1.7-0.6-3.5-0.6-5.3 0-12.7 10.3-23.1 23.1-23.1 6.6 0 12.6 2.8 16.9 7.3 5.2-1 10.2-2.9 14.6-5.6 -1.7 5.4-5.4 9.9-10.1 12.7 4.6-0.5 9.1-1.8 13.3-3.6C109.6 26.2 105.7 30.3 101.2 33.6z"/>'; break;
			case 'twittersquare' 	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="twittersquare" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Twitter Link</title>' . $link . '<path d="M97.1 79.3c0 9.8-7.9 17.7-17.7 17.7H20.5c-9.8 0-17.7-7.9-17.7-17.7V20.4c0-9.8 7.9-17.7 17.7-17.7h58.9c9.8 0 17.7 7.9 17.7 17.7V79.3zM74 34.4c2.7-1.6 4.7-4.2 5.7-7.2 -2.5 1.5-5.3 2.6-8.2 3.1 -2.3-2.5-5.7-4.1-9.4-4.1 -7.1 0-12.9 5.8-12.9 12.9 0 1 0.1 2 0.3 2.9 -10.7-0.6-20.3-5.6-26.6-13.5 -1.1 1.9-1.8 4.2-1.8 6.5 0 4.5 2.1 8.4 5.6 10.7 -2.1-0.1-4.2-0.7-6.1-1.6 0 0 0 0.1 0 0.1 0 6.3 4.7 11.5 10.6 12.6 -1.1 0.3-2 0.5-3.1 0.5 -0.8 0-1.6-0.1-2.4-0.2 1.7 5.1 6.4 8.8 12 9 -4.4 3.4-9.9 5.5-16 5.5 -1 0-2.1-0.1-3.1-0.2 5.7 3.6 12.5 5.8 19.8 5.8C62 77.3 75 57.7 75 40.6c0-0.6 0-1.1-0.1-1.7 2.5-1.8 4.7-4.1 6.4-6.7C79.1 33.3 76.6 34 74 34.4z"/>'; break;
			case 'vimeosquare' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="vimeosquare" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">Vimeo Link</title>' . $link . '<path d="M97.1 79.3c0 9.8-7.9 17.7-17.7 17.7H20.5c-9.8 0-17.7-7.9-17.7-17.7V20.4c0-9.8 7.9-17.7 17.7-17.7h58.9c9.8 0 17.7 7.9 17.7 17.7V79.3zM78.5 25.8c-2.5-3.2-7.8-3.3-11.5-2.8 -2.9 0.5-13 4.9-16.4 15.5 6-0.5 9.2 0.4 8.6 7.1 -0.2 2.8-1.7 5.8-3.2 8.8 -1.8 3.4-5.2 10-9.7 5.2 -4-4.3-3.7-12.5-4.6-18 -0.6-3.1-1.1-6.9-2.1-10.1 -0.9-2.7-2.9-6-5.3-6.7 -2.6-0.7-5.9 0.4-7.8 1.5 -6 3.6-10 8.6-15.9 12.8v0.4c2 1 1.4 2.6 2.9 2.8 3.6 0.5 7.1-3.4 9.5 0.7 1.5 2.5 1.9 5.2 2.8 7.8 1.3 3.6 2.2 7.4 3.3 11.5 1.7 6.9 3.8 17.2 9.8 19.8 3 1.3 7.6-0.4 9.9-1.8 6.3-3.7 11.2-9 15.3-14.5C73.8 52.9 79 38.2 79.8 33.9 80.4 31 80.3 28.1 78.5 25.8z"/>'; break;
			case 'vine' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="vine" viewBox="0 0 512 512" enable-background="new 0 0 512 512" aria-labelledby="title" role="link"><title id="title">Vine Link</title>' . $link . '<path d="M459.4 306.2c-19.5 4.5-39.1 6.4-55.2 6.4 -39.1 82-109.1 152.3-132.5 165.5 -14.8 8.4-28.7 8.9-45.2-0.8C197.7 459.9 88.9 370.6 52.6 89.9h79c19.8 168.5 68.4 255 121.7 319.8 29.6-29.6 58-68.9 80.1-113.3 -52.7-26.8-84.8-85.7-84.8-154.3 0-69.5 39.9-121.9 108.3-121.9 66.4 0 102.7 41.3 102.7 112.4 0 26.5-5.6 56.6-16.2 79.8 0 0-49.1 9.8-67.2-21.8 3.6-12 8.6-32.6 8.6-51.3 0-33.2-12-49.4-30.1-49.4 -19.3 0-32.6 18.1-32.6 53 0 71.2 45.2 111.9 103.8 111.9 10.3 0 22-1.1 33.8-3.9V306.2z"/>'; break;
			case 'wordpress' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="wordpress" viewBox="0 0 512 512" enable-background="new 0 0 512 512" aria-labelledby="title" role="link"><title id="title">WordPress Link</title>' . $link . '<path d="M506 255.6c0 137.8-112.2 250-250 250S6 393.4 6 255.6s112.2-250 250-250S506 117.7 506 255.6zM494.6 255.6C494.6 124.2 387.4 17 256 17S17.4 124.2 17.4 255.6C17.4 387 124.6 494.1 256 494.1S494.6 387 494.6 255.6zM60.1 168.2l102.4 280.4C90.8 413.8 41.4 340.4 41.4 255.6 41.4 224.6 48.1 195 60.1 168.2zM384.4 314.2l-21.2 71.4 -77.6-230.5c0 0 12.8-0.8 24.6-2.2 11.4-1.4 10-18.4-1.4-17.6 -34.9 2.5-57.2 2.8-57.2 2.8s-20.9-0.3-56.4-2.8c-11.7-0.8-13.1 16.7-1.4 17.6 10.9 1.1 22.3 2.2 22.3 2.2l33.5 91.5 -46.9 140.6 -78.1-232.1c0 0 12.8-0.8 24.6-2.2 11.4-1.4 10-18.4-1.4-17.6 -34.6 2.5-57.2 2.8-57.2 2.8 -3.9 0-8.6-0.3-13.7-0.3C115.1 79.5 181 41 256 41c55.8 0 106.6 21.5 144.8 56.4 -0.8 0-2 0-2.8 0 -20.9 0-36 18.1-36 37.9 0 17.6 10.3 32.4 21.2 50.2 8.4 14.2 17.6 32.6 17.6 59.2C400.8 263.1 393.3 284.3 384.4 314.2zM325.8 454.8c0.3 1.1 0.8 2.2 1.4 3.1 -22.3 7.8-46 12.3-71.2 12.3 -20.9 0-41.3-3.1-60.5-8.9l64.2-186.9L325.8 454.8zM470.6 255.6c0 79.2-43 148.2-106.9 185.3l65.6-189.2c10.9-31.3 16.5-55.2 16.5-77 0-7.8-0.6-15.1-1.7-22C460.8 183.3 470.6 218.2 470.6 255.6z"/>'; break;
			case 'youtube' 			: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="youtube" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">YouTube Link</title>' . $link . '<path d="M89.5 90.4c-1 4.4-4.6 7.6-8.8 8 -10.2 1.2-20.4 1.2-30.7 1.2 -10.2 0-20.5 0-30.7-1.2 -4.3-0.4-7.8-3.6-8.8-8 -1.4-6.2-1.4-13-1.4-19.3 0-6.4 0.1-13.2 1.4-19.3 1-4.4 4.6-7.6 8.9-8.1 10.1-1.1 20.4-1.1 30.6-1.1 10.2 0 20.5 0 30.7 1.1 4.3 0.5 7.8 3.7 8.8 8.1 1.4 6.2 1.4 12.9 1.4 19.3C90.9 77.4 90.9 84.2 89.5 90.4zM32.4 57.3v-5.2H15.2v5.2H21v31.4h5.5V57.3H32.4zM41.4 0.5l-6.7 22v15h-5.5v-15c-0.5-2.7-1.6-6.6-3.4-11.7C24.6 7.4 23.4 4 22.3 0.5h5.9L32 15.1l3.8-14.5H41.4zM47.4 88.7V61.4h-4.9v20.9c-1.1 1.5-2.2 2.3-3.1 2.3 -0.7 0-1-0.4-1.2-1.2 -0.1-0.2-0.1-0.8-0.1-1.9V61.4h-4.9V83c0 1.9 0.2 3.2 0.4 4 0.4 1.4 1.6 2 3.2 2 1.8 0 3.6-1.1 5.6-3.4v3H47.4zM56.2 28.6c0 2.9-0.5 5.1-1.5 6.5 -1.4 1.9-3.3 2.8-5.9 2.8 -2.5 0-4.4-0.9-5.8-2.8 -1-1.4-1.5-3.6-1.5-6.5v-9.7c0-2.9 0.5-5.1 1.5-6.5 1.4-1.9 3.3-2.8 5.8-2.8 2.5 0 4.5 0.9 5.9 2.8 1 1.4 1.5 3.5 1.5 6.5V28.6zM51.2 17.9c0-2.5-0.7-3.8-2.4-3.8 -1.6 0-2.4 1.3-2.4 3.8v11.6c0 2.5 0.8 3.9 2.4 3.9 1.7 0 2.4-1.3 2.4-3.9V17.9zM66.1 69.7c0-2.5-0.1-4.4-0.5-5.5 -0.6-2-2-3.1-3.9-3.1 -1.8 0-3.5 1-5.1 3v-12h-4.9v36.6h4.9v-2.7c1.7 2 3.4 3 5.1 3 1.9 0 3.3-1 3.9-3 0.4-1.2 0.5-3 0.5-5.5V69.7zM61.2 80.9c0 2.5-0.7 3.7-2.2 3.7 -0.8 0-1.7-0.4-2.5-1.2V66.8c0.8-0.8 1.7-1.2 2.5-1.2 1.4 0 2.2 1.3 2.2 3.7V80.9zM74.8 37.6h-5v-3c-2 2.3-3.9 3.4-5.7 3.4 -1.6 0-2.8-0.7-3.3-2 -0.3-0.8-0.4-2.2-0.4-4.1V10h5v20.3c0 1.2 0 1.8 0.1 1.9 0.1 0.8 0.5 1.2 1.2 1.2 1 0 2-0.8 3.1-2.4V10h5V37.6zM84.8 79.3h-5c0 2-0.1 3.1-0.1 3.4 -0.3 1.3-1 2-2.2 2 -1.7 0-2.5-1.3-2.5-3.8V76h9.9v-5.7c0-2.9-0.5-5-1.5-6.4 -1.4-1.9-3.4-2.8-5.9-2.8 -2.5 0-4.5 0.9-5.9 2.8 -1 1.4-1.5 3.5-1.5 6.4v9.6c0 2.9 0.6 5.1 1.6 6.4 1.4 1.9 3.4 2.8 6 2.8 2.6 0 4.6-1 6-2.9 0.6-0.9 1-1.9 1.2-3 0.1-0.5 0.1-1.6 0.1-3.2V79.3zM79.9 71.9h-5v-2.5c0-2.5 0.8-3.8 2.5-3.8 1.7 0 2.5 1.3 2.5 3.8V71.9z"/>'; break;
			case 'youtubesquare'	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="youtubesquare" viewBox="0 0 100 100" enable-background="new 0 0 100 100" aria-labelledby="title" role="link"><title id="title">YouTube Link</title>' . $link . '<path d="M97.1 79.3c0 9.8-7.9 17.7-17.7 17.7H20.5c-9.8 0-17.7-7.9-17.7-17.7V20.4c0-9.8 7.9-17.7 17.7-17.7h58.9c9.8 0 17.7 7.9 17.7 17.7V79.3zM82.6 50.7c-0.9-3.6-3.8-6.3-7.3-6.6 -8.3-0.9-16.8-0.9-25.3-0.9 -8.4 0-16.9 0-25.2 0.9 -3.6 0.4-6.5 3-7.3 6.6 -1.2 5.1-1.2 10.7-1.2 16 0 5.2 0 10.8 1.2 16 0.8 3.6 3.7 6.2 7.2 6.6 8.4 0.9 16.9 0.9 25.3 0.9 8.4 0 16.9 0 25.3-0.9 3.5-0.4 6.4-3.1 7.2-6.6 1.2-5.2 1.2-10.7 1.2-16C83.8 61.4 83.8 55.8 82.6 50.7zM35.5 55.3h-4.9v26h-4.5v-26h-4.8V51h14.2V55.3zM42.9 8.5h-4.6l-3.1 12L32 8.5h-4.8c0.9 2.8 2 5.6 2.9 8.5 1.5 4.3 2.4 7.5 2.8 9.7V39h4.5V26.7L42.9 8.5zM47.9 81.3h-4.1v-2.5c-1.6 1.8-3.1 2.8-4.7 2.8 -1.3 0-2.2-0.6-2.6-1.7 -0.2-0.7-0.4-1.7-0.4-3.3V58.7h4.1v16.6c0 0.9 0 1.5 0.1 1.6 0.1 0.6 0.4 0.9 0.9 0.9 0.9 0 1.7-0.6 2.6-1.9V58.7h4.1V81.3zM55.2 23.7c0-2.4-0.4-4.2-1.3-5.3 -1.2-1.5-2.8-2.3-4.8-2.3 -2.1 0-3.7 0.8-4.8 2.3 -0.9 1.2-1.3 2.9-1.3 5.3v8c0 2.4 0.4 4.2 1.3 5.3 1.1 1.5 2.7 2.3 4.8 2.3 2 0 3.6-0.8 4.8-2.3 0.9-1.1 1.3-2.9 1.3-5.3V23.7zM51 32.5c0 2.1-0.7 3.1-2 3.1 -1.4 0-2-1-2-3.1v-9.6c0-2.1 0.6-3.2 2-3.2 1.3 0 2 1.1 2 3.2V32.5zM63.3 74.5c0 2-0.1 3.6-0.4 4.5 -0.5 1.7-1.6 2.6-3.3 2.6 -1.4 0-2.8-0.9-4.2-2.5v2.2h-4.1V51h4.1v9.9c1.3-1.6 2.7-2.5 4.2-2.5 1.7 0 2.8 0.9 3.3 2.6 0.3 0.9 0.4 2.4 0.4 4.5V74.5zM59.3 65.2c0-2-0.6-3.1-1.8-3.1 -0.7 0-1.4 0.3-2 1v13.8c0.7 0.7 1.4 1 2 1 1.2 0 1.8-1 1.8-3V65.2zM70.4 39V16.3h-4.1v17.4c-0.9 1.3-1.8 1.9-2.6 1.9 -0.6 0-0.9-0.3-1-1 -0.1-0.1-0.1-0.6-0.1-1.6V16.3h-4.1v18c0 1.6 0.1 2.6 0.4 3.4 0.4 1.1 1.3 1.7 2.6 1.7 1.5 0 3.1-0.9 4.7-2.8V39H70.4zM78.7 74c0 1.4-0.1 2.2-0.1 2.6 -0.1 0.9-0.4 1.7-0.9 2.5 -1.1 1.7-2.8 2.5-4.9 2.5 -2.1 0-3.8-0.8-5-2.3 -0.9-1.1-1.3-2.9-1.3-5.3V66c0-2.4 0.4-4.1 1.2-5.3 1.2-1.5 2.8-2.3 4.9-2.3 2 0 3.7 0.8 4.8 2.3 0.9 1.2 1.3 2.9 1.3 5.3v4.7h-8.2v4c0 2.1 0.7 3.1 2.1 3.1 1 0 1.6-0.6 1.8-1.6 0-0.2 0.1-1.2 0.1-2.8h4.2V74zM74.6 67.3v-2.1c0-2.1-0.7-3.1-2-3.1 -1.3 0-2 1-2 3.1v2.1H74.6z"/>'; break;

			// Insert theme-specific SVGs
			case 'logo' 			: $output .= ''; break;

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

		echo get_svg( $svg, $link = '' );

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
		$image 	= get_thumbnail_url( get_the_ID(), 'full' );

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
$themekit = new function_names_Themekit();

