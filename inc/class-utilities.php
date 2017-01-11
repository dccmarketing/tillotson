<?php

/**
 * A class of helpful theme functions
 *
 * @package Tillotson
 * @author DCC Marketing <web@dccmarketing.com>
 */
class Tillotson_Utilities {

	/**
	 * The ID of this theme.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$theme_name 		The ID of this theme.
	 */
	private $theme_name;

	/**
	 * The version of this theme.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$version 			The current version of this theme.
	 */
	private $version;

	/**
	 * Constructor
	 *
	 * @since 		1.0.0
	 * @param 		string 			$plugin_name 		The name of this theme.
	 * @param 		string 			$version 			The version of this theme.
	 */
	public function __construct( $theme_name, $version ) {

		$this->theme_name 	= $theme_name;
		$this->version 		= $version;

	} // __construct()

	/**
	 * Setup theme support options.
	 *
	 * @hooked 		after_setup_theme
	 */
	public function setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'tillotson', get_stylesheet_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/**
		 * Set up the WordPress core custom logo feature.
		 *
		 * Add an array to the decalaration below to add these features.
		 *
		 * @param  	int 	height 			Defined height
		 * @param 	int 	width 			Defined width
		 * @param  	bool 	flex-height 	True if the theme has additional space for the logo vertically.
		 * @param 	bool 	flex-width 		True if the theme has additional space for the logo horizontally.
		 */
		add_theme_support( 'custom-logo' );

		/**
		 * Enable Yoast Breadcrumb support
		 */
		add_theme_support( 'yoast-seo-breadcrumbs' );

		/**
		 * Enable WooCommerce support.
		 */
		add_theme_support( 'woocommerce' );

	} // setup()

	/**
	 * Add core editor buttons that are disabled by default
	 *
	 * @hooked 		mce_buttons_2
	 * @param 		array 		$buttons 		The current buttons
	 * @return 		array 						The modified buttons
	 */
	public function add_editor_buttons( $buttons ) {

		$buttons[] = 'superscript';
		$buttons[] = 'subscript';

		return $buttons;

	} // add_editor_buttons()

	/**
	 * Adds the Menu Item Title as a class on the menu item
	 *
	 * @hooked 		wp_setup_nav_menu_item
	 * @param 		object 		$menu_item 			A menu item object
	 */
	public function add_menu_title_as_class( $menu_item ) {

		$title = sanitize_title( $menu_item->title );

		if ( empty( $menu_item->classes ) || ! is_array( $menu_item->classes ) ) {

			$menu_item->classes[0] = $title;

		} elseif ( ! in_array( $title, $menu_item->classes ) ) {
			
			$menu_item->classes[] = $title;
			
		}

		return $menu_item;

	} // add_menu_title_as_class()

	/**
	 * Adds PDF as a filter for the Media Library
	 *
	 * @hooked 		post_mime_types
	 * @param 		array 		$post_mime_types 		The current MIME types
	 * @return 		array 								The modified MIME types
	 */
	public function add_mime_types( $post_mime_types ) {

		$post_mime_types['application/pdf'] = array( esc_html__( 'PDFs', 'tillotson' ), esc_html__( 'Manage PDFs', 'tillotson' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
		$post_mime_types['text/x-vcard'] 	= array( esc_html__( 'vCards', 'tillotson' ), esc_html__( 'Manage vCards', 'tillotson' ), _n_noop( 'vCard <span class="count">(%s)</span>', 'vCards <span class="count">(%s)</span>' ) );

		return $post_mime_types;

	} // add_mime_types()

	/**
	 * Adds more allowed tags for WP menu containers.
	 *
	 * @hooked 		wp_nav_menu_container_allowedtags
	 * @param 		array 			$tags 			The current allowed tags
	 * @return 		array 							The modified allowed tags
	 */
	public function allow_section_tags_as_containers( $tags ) {

		$tags[] = 'section';

		return $tags;

	} // allow_section_tags_as_containers()

	/**
	 * Sets the async attribute on all script tags.
	 *
	 * @hooked 		script_loader_tag
	 */
	public function async_scripts( $tag, $handle ) {

		if ( is_admin() ) { return $tag; }

		$check = strpos( $handle, 'tillotson-' );

		if ( ! $check || 0 < $check ) { return $tag; }

		return str_replace( ' src', ' async="async" src', $tag );

	} // async_scripts()

	/**
	 * Creates a style tag in the header with the background image
	 *
	 * @hooked 		wp_head
	 * @return 		mixed 			Style tag
	 */
	public function background_images() {

		$output = '';
		$image = FALSE;

		if ( is_tax( 'product_cat' ) || is_tax( 'pa_product-line' ) || is_tax( 'pa_racing-class' ) || is_tax( 'pa_venturi' ) || is_tax( 'pa_throttle-bore-diameter' ) ) {

			$term 	= get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$image 	= get_field( 'category_header', $term );

			if ( ! $image ) {

				$image = get_theme_mod( 'default_header_image' );

			}

		}

		if ( is_tax( 'product_market' ) ) {

			$term 	= get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$image 	= get_field( 'header', $term );

			if ( ! $image ) {

				$image = get_theme_mod( 'default_header_image' );

			}

		}

		if ( is_product() && ! $image ) {

			$cats 	= (array) wp_get_post_terms( get_the_ID(), 'product_cat' );
			$image 	= get_field( 'category_header', $cats[0] );

			if ( ! $image ) {

				$image = get_theme_mod( 'default_header_image' );

			}

		}

		if ( is_shop() && ! $image ) {

			$image = get_theme_mod( 'default_header_image' );

		}

		if ( ! $image ) {

			$image 	= tillotson_get_thumbnail_url( get_the_ID(), 'full' );

		}

		if ( ! $image ) {

			$image = get_theme_mod( 'default_header_image' );

		}

		if ( ! empty( $image ) ) {

			$output .= '<style>';
			$output .= '@media screen and (min-width:768px){.header-page{background-image:url(' . $image . ');}';
			$output .= '</style>';

		}

		echo $output;

	} // background_images()

	/**
	 * Flush out the transients used in tillotson_categorized_blog.
	 *
	 * @exits 		Doing Autosave.
	 * @hooked 		edit_category
	 * @hooked 		save_post
	 */
	public function category_transient_flusher() {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

		// Like, beat it. Dig?
		delete_transient( 'tillotson_categories' );

	} // category_transient_flusher()

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @hooked 		after_setup_theme
	 * @global 		int 		$content_width
	 */
	public function content_width() {

		$GLOBALS['content_width'] = apply_filters( 'tillotson_content_width', 640 );

	} // content_width()

	/**
	 * Adds support for additional MIME types to WordPress
	 *
	 * @hooked 		upload_mimes
	 * @param 		array 		$existing_mimes 			The existing MIME types
	 * @return 		array 									The modified MIME types
	 */
	public function custom_upload_mimes( $existing_mimes = array() ) {

		// add your extension to the array
		$existing_mimes['vcf'] = 'text/x-vcard';

		return $existing_mimes;

	} // custom_upload_mimes()

	/**
	 * Removes WordPress emoji support everywhere
	 *
	 * @hooked 		init
	 */
	public function disable_emojis() {

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	} // disable_emojis()

	/**
	 * Enqueues scripts and styles for the admin
	 *
	 * @hooked 		admin_enqueue_scripts
	 */
	public function enqueue_admin( $hook ) {

		wp_enqueue_style( 'tillotson-admin', get_stylesheet_directory_uri() . '/admin.css' );
		wp_enqueue_script( 'tillotson-admin', get_stylesheet_directory_uri() . '/js/admin.min.js', array( 'jquery', 'media-upload' ), $this->version, true );

		// if ( 'nav-menus.php' != $hook ) { return; } // Page-specific scripts & styles after this

	} // enqueue_admin()

	/**
	 * Used by customizer controls, mostly for active callbacks.
	 *
	 * @hooked		customize_controls_enqueue_scripts
	 * @access 		public
	 * @see 		add_action( 'customize_preview_init', $func )
	 * @since 		1.0.0
	 */
	public function enqueue_customizer_controls() {

		wp_enqueue_script( 'tillotson-customizer-controls', get_stylesheet_directory_uri() . '/js/customizer-controls.min.js', array( 'jquery', 'customize-controls' ), $this->version, true );

	} // enqueue_customizer_controls()

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @hooked 		customize_preview_init
	 */
	public function enqueue_customizer_scripts() {

		wp_enqueue_script( 'tillotson-customizer', get_stylesheet_directory_uri() . '/js/customizer.min.js', array( 'jquery', 'customize-preview' ), $this->version, true );

	} // enqueue_customizer_scripts()

	/**
	 * Loads custopmizer.css file for Customizer Previewer styling.
	 *
	 * @hooked 		customize_controls_print_styles
	 */
	public function enqueue_customizer_styles() {

		wp_enqueue_style( 'tillotson-customizer-style', get_stylesheet_directory_uri() . '/customizer.css', 10, 2 );

	} // enqueue_customizer_styles()

	/**
	 * Enqueues scripts and styles for the login page
	 *
	 * @hooked 		login_enqueue_scripts
	 */
	public function enqueue_login() {

		wp_enqueue_style( 'tillotson-login', get_stylesheet_directory_uri() . '/login.css', 10, 2 );
		wp_enqueue_script( 'tillotson-login', get_stylesheet_directory_uri() . '/js/login.min.js', array(), $this->version, true );

	} // enqueue_login()

	/**
	 * Enqueue scripts and styles for the front end.
	 *
	 * @hooked 		wp_enqueue_scripts
	 */
	public function enqueue_public() {

		wp_enqueue_style( 'tillotson-style', get_stylesheet_uri() );

		wp_enqueue_style( 'tillotson-fonts', $this->fonts_url(), array(), null );

		wp_enqueue_script( 'enquire', '//cdnjs.cloudflare.com/ajax/libs/enquire.js/2.1.2/enquire.min.js', array(), $this->version, true );

		wp_enqueue_script( 'tillotson-public', get_stylesheet_directory_uri() . '/js/public.min.js', array( 'jquery', 'enquire' ), $this->version, true );

		wp_enqueue_style( 'dashicons' );

		$faver 	= wp_remote_get( 'http://api.jsdelivr.com/v1/bootstrap/libraries/font-awesome' );
		$json 	= json_decode( $faver['body'], TRUE );

		wp_enqueue_style( 'fontawesome', '//opensource.keycdn.com/fontawesome/' . $json[0]['lastversion'] . '/font-awesome.min.css' );

	} // enqueue_public()

	/**
	 * Limits excerpt length
	 *
	 * @hooked 		excerpt_length
	 * @param 		int 		$length 			The current word length of the excerpt
	 * @return 		int 							The word length of the excerpt
	 */
	public function excerpt_length( $length ) {

		if ( is_home() || is_front_page() ) {

			return 30;

		}

		return $length;

	} // excerpt_length()

	/**
	 * Customizes the "Read More" text for excerpts
	 *
	 * @hooked 		excerpt_more
	 * @global   				$post 		The post object
	 * @param 		mixed 		$more 		The current "read more"
	 * @return 		mixed 					The modifed "read more"
	 */
	public function excerpt_read_more( $more ) {

		global $post;

		$return = sprintf( '... <a class="moretag read-more" href="%s">', esc_url( get_permalink( $post->ID ) ) );
		$return .= esc_html__( 'Read more', 'tillotson' );
		$return .= '<span class="screen-reader-text">';
		$return .= sprintf( esc_html__( ' about %s', 'tillotson' ), $post->post_title );
		$return .= '</span></a>';

		return $return;

	} // excerpt_read_more()

	/**
	 * Properly encode a font URLs to enqueue a Google font
	 *
	 * @see 		enqueue_public()
	 * @return 		mixed 		A properly formatted, translated URL for a Google font
	 */
	public static function fonts_url() {

		$return 	= '';
		$families 	= '';
		$fonts[] 	= array( 'font' => 'Titillium Web', 'weights' => '400,300,700italic,700,600', 'translate' => esc_html_x( 'on', 'Titillium Web font: on or off', 'tillotson' ) );

		foreach ( $fonts as $font ) {

			if ( 'off' == $font['translate'] ) { continue; }

			$families[] = $font['font'] . ':' . $font['weights'];

		}

		if ( ! empty( $families ) ) {

			$query_args['family'] 	= urlencode( implode( '|', $families ) );
			$query_args['subset'] 	= urlencode( 'latin' );
			$return 				= add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		}

		return $return;

	} // fonts_url()

	/**
	 * Converts the search input button to an HTML5 button element
	 *
	 * @hooked 		get_search_form
	 * @param 		mixed  		$form 			The current form HTML
	 * @return 		mixed 						The modified form HTML
	 */
	public function make_search_button_a_button( $form ) {

		$form = '<form action="' . esc_url( home_url( '/' ) ) . '" class="search-form" method="get" role="search" >
				<label class="screen-reader-text" for="site-search">' . _x( 'Search for:', 'label' ) . '</label>
				<input class="search-field" id="site-search" name="s" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder' ) . '" title="' . esc_attr_x( 'Search for:', 'label' ) . '" type="search" value="' . get_search_query() . '"  />
				<button type="submit" class="search-submit">
					<span class="screen-reader-text">'. esc_attr_x( 'Search', 'submit button' ) .'</span>
					<span class="dashicons dashicons-search"></span>
				</button>
			</form>';

		return $form;

	} // make_search_button_a_button()

	/**
	 * Sets the site-wide default for oEmbed videos
	 *
	 * @param  [type] $defaults [description]
	 * @return [type]           [description]
	 */
	public function oembed_defaults( $defaults ) {

		 $defaults['width'] 	= 325;
		 $defaults['height'] = 325;

		 return $defaults;

	} // oembed_defaults()

	/**
	 * Adds classes to the body tag.
	 *
	 * @hooked		body_class
	 * @global 		$post						The $post object
	 * @param 		array 		$classes 		Classes for the body element.
	 * @return 		array 						The modified body class array
	 */
	public function page_body_classes( $classes ) {

		global $post;

		if ( empty( $post->post_content ) ) {

			$classes[] = 'content-none';

		} else {

			$classes[] = $post->post_name;

		}

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {

			$classes[] = 'group-blog';

		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {

			$classes[] = 'hfeed';

		}

		return $classes;

	} // page_body_classes()

	/**
	 * The content for each column cell
	 *
	 * @hooked		manage_page_posts_custom_column
	 * @param 		string 		$column_name 		The name of the column
	 * @param 		int 		$post_ID 			The post ID
	 * @return 		mixed 							The cell content
	 */
	public function page_template_column_content( $column_name, $post_ID ) {

		if ( 'page_template' !== $column_name ) { return; }

		$slug 		= get_page_template_slug( $post_ID );
		$templates 	= get_page_templates();
		$name 		= array_search( $slug, $templates );

		if ( ! empty( $name ) ) {

			echo '<span class="name-template">' . $name . '</span>';

		} else {

			echo '<span class="name-template">' . esc_html( 'Default', 'tillotson' ) . '</span>';

		}

	} // page_template_column_content()

	/**
	 * Adds the page template column to the columns on the page listings
	 *
	 * @hooked 		manage_page_posts_columns
	 * @param 		array 		$defaults 			The current column names
	 * @return 		array           				The modified column names
	 */
	public function page_template_column_head( $defaults ) {

		$defaults['page_template'] = esc_html( 'Page Template', 'tillotson' );

		return $defaults;

	} // page_template_column_head()

	/**
	 * Registers Menus
	 *
	 * @hooked 		after_setup_theme
	 */
	public function register_menus() {

		register_nav_menus( array(
			'primary' 		=> esc_html__( 'Primary', 'tillotson' ),
			'social' 		=> esc_html__( 'Social Links', 'tillotson' )
		) );

	} // register_menus()

	/**
	 * Removes query strings from static resources
	 * to increase Pingdom and GTMatrix scores.
	 *
	 * Does not remove query strings from Google Font calls.
	 *
	 * @hooked		style_loader_src
	 * @hooked 		script_loader_src
	 * @param 		string 		$src 			The resource URL
	 * @return 		string 						The modifed resource URL
	 */
	public function remove_cssjs_ver( $src ) {

		if ( empty( $src ) ) { return; }
		if ( strpos( $src, 'https://fonts.googleapis.com' ) ) { return; }

		if ( strpos( $src, '?ver=' ) ) {

			$src = remove_query_arg( 'ver', $src );

		}

		return $src;

	} // remove_cssjs_ver()

	/**
	 * Removes the "Private" text from the private pages in the breadcrumbs
	 *
	 * @hooked
	 * @param 		string 		$text 			The breadcrumb text
	 * @return 		string 						The modified breadcrumb text
	 */
	public function remove_private( $text ) {

		$check = stripos( $text, 'Private: ' );

		if ( is_int( $check ) ) {

			$text = str_replace( 'Private: ', '', $text );

		}

		return $text;

	} // remove_private()

	/**
	 * Adds content to the slide management screen in Soliloquy.
	 */
	public function soliloquy_add_notes() {

		echo '<p class="admin-notes update-nag">' . esc_html__( 'NOTE: Slides for the homepage need to be 1500px wide and 500px tall.', 'tillotson' ) . '</p>';

	} // soliloquy_add_notes()

	/**
	 * Unlinks breadcrumbs that are private pages
	 *
	 * @hooked
	 * @param 		mixed 		$output 		The HTML output for the breadcrumb
	 * @param 		array 		$link 			Array of link info
	 * @return 		mixed 						The modified link output
	 */
	public function unlink_private_pages( $output, $link ) {

		if ( ! isset( $link['url'] ) || empty( $link['url'] ) ) { return $output; }

		$id 		= url_to_postid( $link['url'] );
		$options 	= WPSEO_Options::get_all();

		if ( $options['breadcrumbs-home'] !== $link['text'] && 0 === $id ) {

			$output = '<span rel="v:child" typeof="v:Breadcrumb">' . $link['text'] . '</span>';

		}

		return $output;

	} // unlink_private_pages()

	/**
	 * Register widget areas.
	 *
	 * @hooked 		widgets_init
	 * @link 		https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	public function widgets_init() {

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'tillotson' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'tillotson' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

	} // widgets_init()

	/**
	 * Adds the video ID as the ID attribute on the iframe
	 *
	 * @hooked 		embed_oembed_html
	 * @param 		string 		$html 			The current oembed HTML
	 * @param 		string 		$url 			The oembed URL
	 * @param 		array 		$attr 			The oembed attributes
	 * @param 		int 		$post_id 		The post ID
	 * @return 		string 						The modified oembed HTML
	 */
	public function youtube_add_id_attribute( $html, $url, $attr, $post_id ) {

		$check = strpos( $url, 'youtu' );

		if ( ! $check ) { return $html; }

		if ( strpos( $url, 'watch?v=' ) > 0 ) {

			$id = explode( 'watch?v=', $url );

		} else {

			$id = explode( '.be/', $url );

		}

		$html = str_replace( 'allowfullscreen>', 'allowfullscreen id="video-' . $id[1] . '">', $html );

		return $html;

	} // youtube_add_id_attribute

} // class
