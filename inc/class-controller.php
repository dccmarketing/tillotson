<?php

/**
 * The file that defines the core actions and filters for the theme
 *
 * @since 		1.0.0
 *
 * @package 	Tillotson
 */
class Tillotson_Controller {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the theme.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Tillotson_Loader    $loader    Maintains and registers all hooks for the theme.
	 */
	protected $loader;

	/**
	 * The unique identifier of this theme.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $theme_name    The string used to uniquely identify this theme.
	 */
	protected $theme_name;

	/**
	 * The current version of the theme.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the theme.
	 */
	protected $version;

	/**
	 * Define the core functionality of the theme.
	 *
	 * Set the theme name and the theme version that can be used throughout the theme.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->theme_name 	= 'tillotson';
		$this->version 		= '1.0.0';

		$this->load_dependencies();
		$this->define_utility_hooks();
		$this->define_menu_hooks();
		$this->define_theme_hooks();
		$this->define_metabox_hooks();
		$this->define_automattic_hooks();
		$this->define_customizer_hooks();
		$this->define_shortcode_hooks();
		$this->define_woocommerce_hooks();

	} // __construct()

	/**
	 * Load the required dependencies for this theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$this->loader = new Tillotson_Loader();

	} // load_dependencies()

	/**
	 * Register all of the hooks related to Automattic plugin compatiblity.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_automattic_hooks() {

		$theme_automattic = new Tillotson_Automattic( $this->get_theme_name(), $this->get_version() );

		$this->loader->action( 'after_setup_theme', $theme_automattic, 'jetpack_setup' );
		$this->loader->action( 'after_setup_theme', $theme_automattic, 'wpcom_setup' );

	} // define_automattic_hooks()

	/**
	 * Register all of the hooks related to the Customizer.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_customizer_hooks() {

		$theme_customizer = new Tillotson_Customizer( $this->get_theme_name(), $this->get_version() );

		$this->loader->action( 'customize_register', 					$theme_customizer, 'register_panels' );
		$this->loader->action( 'customize_register', 					$theme_customizer, 'register_sections' );
		$this->loader->action( 'customize_register', 					$theme_customizer, 'register_fields' );
		$this->loader->action( 'wp_head', 								$theme_customizer, 'header_output' );
		$this->loader->action( 'customize_register', 					$theme_customizer, 'load_customize_controls', 0 );

	} // define_customizer_hooks()

	/**
	 * Register all of the hooks related to customizing the appearance of the menus.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_menu_hooks() {

		$theme_menu = new Tillotson_Menukit( $this->get_theme_name(), $this->get_version() );

		//$this->loader->filter( 'walker_nav_menu_start_el', 			$theme_menu, 'menu_show_hide', 10, 4 );
		$this->loader->filter( 'walker_nav_menu_start_el', 			$theme_menu, 'add_icons_to_menu', 10, 4 );
		$this->loader->filter( 'tillotson-menu-item-text-position', $theme_menu, 'get_text_position', 10, 3 );
		$this->loader->filter( 'tillotson-menu-item-icon-name', 	$theme_menu, 'get_icon_info', 10, 3 );

	} // define_menu_hooks()

	/**
	 * Register all of the hooks related to metaboxes
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_metabox_hooks() {

		$metaboxes = array( 'Locationorder' );

		foreach ( $metaboxes as $box ) {

			$class 	= 'Tillotson_Metabox_' . $box;
			$box_obj 	= new $class( $this->get_theme_name(), $this->get_version() );

			$this->loader->action( 'add_meta_boxes', 		$box_obj, 'add_metaboxes', 10, 2 );
			$this->loader->action( 'add_meta_boxes', 		$box_obj, 'set_meta', 10, 2 );
			$this->loader->action( 'save_post', 			$box_obj, 'validate_meta', 10, 2 );
			$this->loader->action( 'edit_form_after_title', $box_obj, 'promote_metaboxes', 10, 1 );

		}

	} // define_metabox_hooks()

	/**
	 * Register all of the hooks related to shortcodes.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_shortcode_hooks() {

		$shortcodes = array( 'Listmenu', 'Listfiles', 'Productsearchform' );

		foreach ( $shortcodes as $shortcode ) {

			$class 			= 'Tillotson_Shortcode_' . $shortcode;
			$shortcode_obj 	= new $class();
			$function 		= strtolower( $shortcode );

			$this->loader->shortcode( $function, $shortcode_obj, 'shortcode_' . $function );

		}

	} // define_shortcode_hooks()

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_theme_hooks() {

		$theme_hooks = new Tillotson_Themehooks( $this->get_theme_name(), $this->get_version() );


		$this->loader->action( 'tillotson_header_content', 	$theme_hooks, 'menu_social', 10 );
		$this->loader->action( 'tillotson_header_content', 	$theme_hooks, 'site_branding', 15 );
		$this->loader->action( 'tillotson_header_content', 	$theme_hooks, 'menu_primary', 20 );

		$this->loader->action( 'tha_header_after', 			$theme_hooks, 'homepage_slider', 10 );
		$this->loader->action( 'tha_header_after', 			$theme_hooks, 'homepage_promo_boxes', 15 );
		$this->loader->action( 'tha_header_after', 			$theme_hooks, 'page_header', 15 );
		$this->loader->action( 'tha_header_after', 			$theme_hooks, 'breadcrumbs', 20 );

		$this->loader->action( 'tha_body_top', 				$theme_hooks, 'analytics_code' );

		$this->loader->action( 'tillotson_footer_content', 	$theme_hooks, 'footer_logo', 10 );
		$this->loader->action( 'tillotson_footer_content', 	$theme_hooks, 'site_description', 15 );
		$this->loader->action( 'tillotson_footer_content', 	$theme_hooks, 'site_info', 20 );

		$this->loader->filter( 'tillotson_precontent_title', $theme_hooks, 'precontent_title' );

	} // define_theme_hooks()

	/**
	 * Register all of the hooks related to the utility functions.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_utility_hooks() {

		$theme_utils = new Tillotson_Utilities( $this->get_theme_name(), $this->get_version() );

		$this->loader->action( 'after_setup_theme', 				$theme_utils, 'setup' );
		$this->loader->action( 'after_setup_theme', 				$theme_utils, 'register_menus' );
		$this->loader->action( 'after_setup_theme', 				$theme_utils, 'content_width', 0 );
		$this->loader->action( 'widgets_init', 						$theme_utils, 'widgets_init' );

		$this->loader->filter( 'script_loader_tag', 				$theme_utils, 'async_scripts', 10, 2 );
		$this->loader->action( 'admin_enqueue_scripts', 			$theme_utils, 'enqueue_admin' );
		$this->loader->action( 'customize_preview_init', 			$theme_utils, 'enqueue_customizer_scripts' );
		$this->loader->action( 'customize_controls_enqueue_scripts', $theme_utils, 'enqueue_customizer_controls' );
		$this->loader->action( 'customize_controls_print_styles', 	$theme_utils, 'enqueue_customizer_styles' );
		$this->loader->action( 'login_enqueue_scripts', 			$theme_utils, 'enqueue_login' );
		$this->loader->action( 'wp_enqueue_scripts', 				$theme_utils, 'enqueue_public' );
		$this->loader->filter( 'style_loader_src', 					$theme_utils, 'remove_cssjs_ver', 10, 2 );
		$this->loader->filter( 'script_loader_src', 				$theme_utils, 'remove_cssjs_ver', 10, 2 );

		$this->loader->filter( 'body_class', 						$theme_utils, 'page_body_classes' );
		$this->loader->action( 'wp_head', 							$theme_utils, 'background_images' );
		$this->loader->filter( 'get_search_form', 					$theme_utils, 'make_search_button_a_button' );
		$this->loader->filter( 'embed_oembed_html', 				$theme_utils, 'youtube_add_id_attribute', 99, 4 );
		$this->loader->action( 'init', 								$theme_utils, 'disable_emojis' );
		$this->loader->filter( 'excerpt_length', 					$theme_utils, 'excerpt_length' );
		$this->loader->filter( 'excerpt_more', 						$theme_utils, 'excerpt_read_more' );

		$this->loader->filter( 'post_mime_types', 					$theme_utils, 'add_mime_types' );
		$this->loader->filter( 'upload_mimes', 						$theme_utils, 'custom_upload_mimes' );
		$this->loader->filter( 'mce_buttons_2', 					$theme_utils, 'add_editor_buttons' );
		$this->loader->filter( 'manage_page_posts_columns', 		$theme_utils, 'page_template_column_head', 10 );
		$this->loader->action( 'manage_page_posts_custom_column', 	$theme_utils, 'page_template_column_content', 10, 2 );
		$this->loader->action( 'edit_category', 					$theme_utils, 'category_transient_flusher' );
		$this->loader->action( 'save_post', 						$theme_utils, 'category_transient_flusher' );
		$this->loader->filter( 'wp_setup_nav_menu_item', 			$theme_utils, 'add_menu_title_as_class', 10, 1 );
		//$this->loader->filter( 'wp_nav_menu_container_allowedtags', $theme_utils, 'allow_section_tags_as_containers', 10, 1 );

		$this->loader->action( 'soliloquy_tab_slider', 				$theme_utils, 'soliloquy_add_notes', 9 );
		$this->loader->filter( 'embed_defaults', 					$theme_utils, 'oembed_defaults' );

	} // define_utility_hooks()

	/**
	 * Register all of the hooks related to WooCommerce.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_woocommerce_hooks() {

		$woocommerce = new Tillotson_Woocommerce( $this->get_theme_name(), $this->get_version() );

		$this->loader->action( 'init', 										$woocommerce, 'woocommerce_tweaks' );
		$this->loader->action( 'woocommerce_before_shop_loop', 				$woocommerce, 'insert_category_page', 10 );
		$this->loader->action( 'woocommerce_single_product_summary', 		$woocommerce, 'add_currency_switcher', 11 );
		$this->loader->action( 'woocommerce_product_query', 				$woocommerce, 'get_products_by_market', 10, 2 );
		$this->loader->action( 'woocommerce_before_none_found', 			$woocommerce, 'insert_category_page', 10 );

		$this->loader->filter( 'woocommerce_show_page_title', 				$woocommerce, 'remove_title' );
		$this->loader->filter( 'loop_shop_columns', 						$woocommerce, 'loop_columns' );
		$this->loader->filter( 'woocommerce_product_tabs', 					$woocommerce, 'rename_tabs', 98 );
		$this->loader->filter( 'woocommerce_product_description_heading', 	$woocommerce, 'return_empty_string' );
		$this->loader->filter( 'woocommerce_stock_html', 					$woocommerce, 'remove_stock' );
		$this->loader->filter( 'woocommerce_output_related_products_args', 	$woocommerce, 'change_related_products_quantity', 10 );
		$this->loader->filter( 'woocommerce_related_products_heading', 		$woocommerce, 'change_related_products_heading', 10, 1 );
		$this->loader->filter( 'woocommerce_product_additional_information_heading', $woocommerce, 'return_empty_string' );
		$this->loader->filter( 'woocommerce_product_tabs', 					$woocommerce, 'extra_product_tabs' );
		$this->loader->filter( 'woocommerce_product_single_add_to_cart_text', $woocommerce, 'custom_cart_button_text' );
		$this->loader->filter( 'add_to_cart_text', 							$woocommerce, 'custom_cart_button_text' );
		$this->loader->filter( 'woocommerce_attribute_show_in_nav_menus', 	$woocommerce, 'return_true' );

		$this->loader->filter( 'woocommerce_placeholder_img_src', 			$woocommerce, 'default_thumbnail', 9, 1 );

		$this->loader->filter( 'loop_shop_per_page', 						$woocommerce, 'change_shop_loop_quantity', 20 );

		$this->loader->action( 'pre_get_posts', 							$woocommerce, 'dealers_orderby', 10, 1 );
		$this->loader->action( 'tillotson_while_after', 						$woocommerce, 'dealers_without_locationorder' );

		$this->loader->filter( 'tillotson-unordered-dealers', $woocommerce, 'dealers_without_locationorder', 10, 2 );

	} // define_woocommerce_hooks()

	/**
	 * The name of the theme used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 *
	 * @return    string    The name of the theme.
	 */
	public function get_theme_name() {

		return $this->theme_name;

	} // get_theme_name()

	/**
	 * The reference to the class that orchestrates the hooks with the theme.
	 *
	 * @since     1.0.0
	 *
	 * @return    Tillotson_Loader    Orchestrates the hooks of the theme.
	 */
	public function get_loader() {

		return $this->loader;

	} // get_loader()

	/**
	 * Retrieve the version number of the theme.
	 *
	 * @since     1.0.0
	 *
	 * @return    string    The version number of the theme.
	 */
	public function get_version() {

		return $this->version;

	} // get_version()



	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		$this->loader->run();

	} // run()

} // class
