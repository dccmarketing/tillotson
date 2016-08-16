<?php
/**
 * Tillotson 2015 Customizer
 *
 * Contains methods for customizing the theme customization screen.
 *
 * @link 		https://codex.wordpress.org/Theme_Customization_API
 * @since 		1.0.0
 * @package  	Tillotson
 */
class Tillotson_Customizer {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Registers custom panels for the Customizer
	 *
	 * @hooked 		customize_register
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_panels( $wp_customize ) {

		// Register panels here

	} // register_panels()

	/**
	 * Registers custom sections for the Customizer
	 *
	 * Existing sections:
	 *
	 * Slug 				Priority 		Title
	 *
	 * title_tagline 		20 				Site Identity
	 * colors 				40				Colors
	 * header_image 		60				Header Image
	 * background_image 	80				Background Image
	 * nav_menus			100 			Navigation
	 * widgets 				110 			Widgets
	 * static_front_page 	120 			Static Front Page
	 * default 				160 			all others
	 *
	 * @hooked 		customize_register
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_sections( $wp_customize ) {

		// Images Section
		$wp_customize->add_section( 'tillotson_images',
			array(
				'capability' 		=> 'edit_theme_options',
				'description' 		=> esc_html__( 'Images', 'tillotson' ),
				'priority' 			=> 10,
				'title' 			=> esc_html__( 'Images', 'tillotson' )
			)
		);

		// Text Section
		$wp_customize->add_section( 'tillotson_text',
			array(
				'capability' 		=> 'edit_theme_options',
				'description' 		=> esc_html__( 'Various text used throughout the site.', 'tillotson' ),
				'priority' 			=> 10,
				'title' 			=> esc_html__( 'Text', 'tillotson' )
			)
		);

		// Contact Info Section
		$wp_customize->add_section( 'contact_info',
			array(
				'capability' 	=> 'edit_theme_options',
				'description' 	=> esc_html__( '', 'tillotson' ),
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Contact Info', 'tillotson' )
			)
		);

		// Promo Box 1 Section
		$wp_customize->add_section( 'promo_box_1',
			array(
				'capability' 	=> 'edit_theme_options',
				'description' 	=> esc_html__( '', 'tillotson' ),
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Promo Box 1', 'tillotson' )
			)
		);

		// Promo Box 2 Section
		$wp_customize->add_section( 'promo_box_2',
			array(
				'capability' 	=> 'edit_theme_options',
				'description' 	=> esc_html__( '', 'tillotson' ),
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Promo Box 2', 'tillotson' )
			)
		);

		// Promo Box 3 Section
		$wp_customize->add_section( 'promo_box_3',
			array(
				'capability' 	=> 'edit_theme_options',
				'description' 	=> esc_html__( '', 'tillotson' ),
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Promo Box 3', 'tillotson' )
			)
		);

	} // register_sections()

	/**
	 * Registers controls/fields for the Customizer
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom
	 * javascript. See live_preview() for more.
	 *
	 * Note: To use active_callbacks, don't add these to the selecting control, it apepars these conflict:
	 * 		'transport' => 'postMessage'
	 * 		$wp_customize->get_setting( 'field_name' )->transport = 'postMessage';
	 *
	 * @hooked 		customize_register
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_fields( $wp_customize ) {

		// Enable live preview JS for default fields
		$wp_customize->get_setting( 'blogname' )->transport 		= 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport 	= 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';



		// Site Identity Section Fields

		// Google Tag Manager Field
		$wp_customize->add_setting(
			'tag_manager',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'tag_manager',
			array(
				'description' 	=> esc_html__( 'Paste in the Google Tag Manager code here. Do not include the comment tags!', 'tillotson' ),
				'label' => esc_html__( 'Google Tag Manager', 'tillotson' ),
				'priority' => 90,
				'section' => 'title_tagline',
				'settings' => 'tag_manager',
				'type' => 'textarea'
			)
		);
		$wp_customize->get_setting( 'tag_manager' )->transport = 'postMessage';



		// Default Header Image
		$wp_customize->add_setting(
			'default_header_image',
			array(
				'default' 			=> '',
				'transport' 		=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'default_header_image',
				array(
					'description' 	=> esc_html__( 'The header image to use if there is not one chosen', 'tillotson' ) ,
					'label' 		=> esc_html__( 'Default Header Image', 'tillotson' ),
					'section' 		=> 'tillotson_images',
					'settings' 		=> 'default_header_image'
				)
			)
		);
		$wp_customize->get_setting( 'default_header_image' )->transport = 'postMessage';

		// Default Product Thumbnail
		$wp_customize->add_setting(
			'default_product_thumbnail',
			array(
				'default' 			=> '',
				'transport' 		=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'default_product_thumbnail',
				array(
					'description' 	=> esc_html__( 'The product thumbnail to use if there is not one chosen.', 'tillotson' ) ,
					'label' 		=> esc_html__( 'Default Product Thumbnail', 'tillotson' ),
					'section' 		=> 'tillotson_images',
					'settings' 		=> 'default_product_thumbnail'
				)
			)
		);
		$wp_customize->get_setting( 'default_product_thumbnail' )->transport = 'postMessage';




		// Category Description Header
		$wp_customize->add_setting(
			'category_description_header',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'category_description_header',
			array(
				'description' 	=> esc_html__( 'The text to use on Product Category pages above the category description.', 'tillotson' ),
				'label'  		=> esc_html__( 'Category Description Header', 'tillotson' ),
				'section'  		=> 'tillotson_text',
				'settings' 		=> 'category_description_header',
				'type' 			=> 'text'
			)
		);
		$wp_customize->get_setting( 'category_description_header' )->transport = 'postMessage';

		// Category Service Docs Header
		$wp_customize->add_setting(
			'category_docs_header',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'category_docs_header',
			array(
				'description' 	=> esc_html__( 'The text to use on Product Category pages above the service documents list.', 'tillotson' ),
				'label'  		=> esc_html__( 'Category Service Docs Header', 'tillotson' ),
				'section'  		=> 'tillotson_text',
				'settings' 		=> 'category_docs_header',
				'type' 			=> 'text'
			)
		);
		$wp_customize->get_setting( 'category_docs_header' )->transport = 'postMessage';






		// Home Technical Header
		$wp_customize->add_setting(
			'home_tech_header',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'home_tech_header',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label'  		=> esc_html__( 'Home Page Technical Info Header', 'tillotson' ),
				'section'  		=> 'tillotson_text',
				'settings' 		=> 'home_tech_header',
				'type' 			=> 'text'
			)
		);
		$wp_customize->get_setting( 'home_tech_header' )->transport = 'postMessage';

		// Home News Header
		$wp_customize->add_setting(
			'home_news_header',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'home_news_header',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label'  		=> esc_html__( 'Home Page News Header', 'tillotson' ),
				'section'  		=> 'tillotson_text',
				'settings' 		=> 'home_news_header',
				'type' 			=> 'text'
			)
		);
		$wp_customize->get_setting( 'home_news_header' )->transport = 'postMessage';







		// Contact Info Section Fields

		// Address 1 Field
		$wp_customize->add_setting(
			'address_1',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'address_1',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label'  		=> esc_html__( 'Address Line 1', 'tillotson' ),
				'priority' 		=> 200,
				'section'  		=> 'contact_info',
				'settings' 		=> 'address_1',
				'type' 			=> 'text'
			)
		);
		$wp_customize->get_setting( 'address_1' )->transport = 'postMessage';

		// City Field
		$wp_customize->add_setting(
			'city',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'city',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label'  		=> esc_html__( 'City', 'tillotson' ),
				'priority' 		=> 220,
				'section'  		=> 'contact_info',
				'settings' 		=> 'city',
				'type' 			=> 'text'
			)
		);
		$wp_customize->get_setting( 'city' )->transport = 'postMessage';




		// Default State Field
		$wp_customize->add_setting(
			'default_state',
			array(
				'default'  	=> '',
				//'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'default_state',
			array(
				'active_callback' 	=> 'tillotson_states_of_country_callback',
				'description' 		=> esc_html__( 'Select a country for better options here.', 'tillotson' ),
				'label'  			=> esc_html__( 'State', 'tillotson' ),
				'priority' 			=> 220,
				'section'  			=> 'contact_info',
				'settings' 			=> 'default_state',
				'type' 				=> 'text'
			)
		);
		$wp_customize->get_setting( 'default_state' )->transport = 'postMessage';

		// Canadian States Select Field
		$wp_customize->add_setting(
			'canada_state',
			array(
				'default'  	=> '',
				//'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'canada_state',
			array(
				'active_callback' 	=> 'tillotson_states_of_country_callback',
				'choices' => array(
					'AB' => esc_html__( 'Alberta', 'tillotson' ),
					'BC' => esc_html__( 'British Columbia', 'tillotson' ),
					'MB' => esc_html__( 'Manitoba', 'tillotson' ),
					'NB' => esc_html__( 'New Brunswick', 'tillotson' ),
					'NL' => esc_html__( 'Newfoundland and Labrador', 'tillotson' ),
					'NT' => esc_html__( 'Northwest Territories', 'tillotson' ),
					'NS' => esc_html__( 'Nova Scotia', 'tillotson' ),
					'NU' => esc_html__( 'Nunavut', 'tillotson' ),
					'ON' => esc_html__( 'Ontario', 'tillotson' ),
					'PE' => esc_html__( 'Prince Edward Island', 'tillotson' ),
					'QC' => esc_html__( 'Quebec', 'tillotson' ),
					'SK' => esc_html__( 'Saskatchewan', 'tillotson' ),
					'YT' => esc_html__( 'Yukon', 'tillotson' )
				),
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label' 		=> esc_html__( 'State', 'tillotson' ),
				'priority' 		=> 230,
				'section' 		=> 'contact_info',
				'settings' 		=> 'canada_state',
				'type' 			=> 'select'
			)
		);
		$wp_customize->get_setting( 'canada_state' )->transport = 'postMessage';


		// Australian States Select Field
		$wp_customize->add_setting(
			'australia_state',
			array(
				'default'  	=> '',
				//'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'australia_state',
			array(
				'active_callback' 	=> 'tillotson_states_of_country_callback',
				'choices' => array(
					'ACT' 	=> esc_html__( 'Australian Capital Territory', 'tillotson' ),
					'NSW' 	=> esc_html__( 'New South Wales', 'tillotson' ),
					'NT' 	=> esc_html__( 'Northern Territory', 'tillotson' ),
					'QLD' 	=> esc_html__( 'Queensland', 'tillotson' ),
					'SA' 	=> esc_html__( 'South Australia', 'tillotson' ),
					'TAS' 	=> esc_html__( 'Tasmania', 'tillotson' ),
					'VIC' 	=> esc_html__( 'Victoria', 'tillotson' ),
					'WA' 	=> esc_html__( 'Western Australia', 'tillotson' )
				),
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label' 		=> esc_html__( 'State', 'tillotson' ),
				'priority' 		=> 230,
				'section' 		=> 'contact_info',
				'settings' 		=> 'australia_state',
				'type' 			=> 'select'
			)
		);
		$wp_customize->get_setting( 'australia_state' )->transport = 'postMessage';

		// US States Select Field
		$wp_customize->add_setting(
			'us_state',
			array(
				'default'  	=> '',
				//'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'us_state',
			array(
				'active_callback' 	=> 'tillotson_states_of_country_callback',
				'choices' => array(
					'AL' => esc_html__( 'Alabama', 'tillotson' ),
					'AK' => esc_html__( 'Alaska', 'tillotson' ),
					'AZ' => esc_html__( 'Arizona', 'tillotson' ),
					'AR' => esc_html__( 'Arkansas', 'tillotson' ),
					'CA' => esc_html__( 'California', 'tillotson' ),
					'CO' => esc_html__( 'Colorado', 'tillotson' ),
					'CT' => esc_html__( 'Connecticut', 'tillotson' ),
					'DE' => esc_html__( 'Delaware', 'tillotson' ),
					'DC' => esc_html__( 'District of Columbia', 'tillotson' ),
					'FL' => esc_html__( 'Florida', 'tillotson' ),
					'GA' => esc_html__( 'Georgia', 'tillotson' ),
					'HI' => esc_html__( 'Hawaii', 'tillotson' ),
					'ID' => esc_html__( 'Idaho', 'tillotson' ),
					'IL' => esc_html__( 'Illinois', 'tillotson' ),
					'IN' => esc_html__( 'Indiana', 'tillotson' ),
					'IA' => esc_html__( 'Iowa', 'tillotson' ),
					'KS' => esc_html__( 'Kansas', 'tillotson' ),
					'KY' => esc_html__( 'Kentucky', 'tillotson' ),
					'LA' => esc_html__( 'Louisiana', 'tillotson' ),
					'ME' => esc_html__( 'Maine', 'tillotson' ),
					'MD' => esc_html__( 'Maryland', 'tillotson' ),
					'MA' => esc_html__( 'Massachusetts', 'tillotson' ),
					'MI' => esc_html__( 'Michigan', 'tillotson' ),
					'MN' => esc_html__( 'Minnesota', 'tillotson' ),
					'MS' => esc_html__( 'Mississippi', 'tillotson' ),
					'MO' => esc_html__( 'Missouri', 'tillotson' ),
					'MT' => esc_html__( 'Montana', 'tillotson' ),
					'NE' => esc_html__( 'Nebraska', 'tillotson' ),
					'NV' => esc_html__( 'Nevada', 'tillotson' ),
					'NH' => esc_html__( 'New Hampshire', 'tillotson' ),
					'NJ' => esc_html__( 'New Jersey', 'tillotson' ),
					'NM' => esc_html__( 'New Mexico', 'tillotson' ),
					'NY' => esc_html__( 'New York', 'tillotson' ),
					'NC' => esc_html__( 'North Carolina', 'tillotson' ),
					'ND' => esc_html__( 'North Dakota', 'tillotson' ),
					'OH' => esc_html__( 'Ohio', 'tillotson' ),
					'OK' => esc_html__( 'Oklahoma', 'tillotson' ),
					'OR' => esc_html__( 'Oregon', 'tillotson' ),
					'PA' => esc_html__( 'Pennsylvania', 'tillotson' ),
					'RI' => esc_html__( 'Rhode Island', 'tillotson' ),
					'SC' => esc_html__( 'South Carolina', 'tillotson' ),
					'SD' => esc_html__( 'South Dakota', 'tillotson' ),
					'TN' => esc_html__( 'Tennessee', 'tillotson' ),
					'TX' => esc_html__( 'Texas', 'tillotson' ),
					'UT' => esc_html__( 'Utah', 'tillotson' ),
					'VT' => esc_html__( 'Vermont', 'tillotson' ),
					'VA' => esc_html__( 'Virginia', 'tillotson' ),
					'WA' => esc_html__( 'Washington', 'tillotson' ),
					'WV' => esc_html__( 'West Virginia', 'tillotson' ),
					'WI' => esc_html__( 'Wisconsin', 'tillotson' ),
					'WY' => esc_html__( 'Wyoming', 'tillotson' ),
					'AS' => esc_html__( 'American Samoa', 'tillotson' ),
					'AA' => esc_html__( 'Armed Forces America (except Canada)', 'tillotson' ),
					'AE' => esc_html__( 'Armed Forces Africa/Canada/Europe/Middle East', 'tillotson' ),
					'AP' => esc_html__( 'Armed Forces Pacific', 'tillotson' ),
					'FM' => esc_html__( 'Federated States of Micronesia', 'tillotson' ),
					'GU' => esc_html__( 'Guam', 'tillotson' ),
					'MH' => esc_html__( 'Marshall Islands', 'tillotson' ),
					'MP' => esc_html__( 'Northern Mariana Islands', 'tillotson' ),
					'PR' => esc_html__( 'Puerto Rico', 'tillotson' ),
					'PW' => esc_html__( 'Palau', 'tillotson' ),
					'VI' => esc_html__( 'Virgin Islands', 'tillotson' )
				),
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label' 		=> esc_html__( 'State', 'tillotson' ),
				'priority' 		=> 230,
				'section' 		=> 'contact_info',
				'settings' 		=> 'us_state',
				'type' 			=> 'select'
			)
		);
		$wp_customize->get_setting( 'us_state' )->transport = 'postMessage';

		// Zip Code Field
		$wp_customize->add_setting(
			'zip_code',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'zip_code',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label'  		=> esc_html__( 'Zip Code', 'tillotson' ),
				'priority' 		=> 240,
				'section'  		=> 'contact_info',
				'settings' 		=> 'zip_code',
				'type' 			=> 'text'
			)
		);
		$wp_customize->get_setting( 'zip_code' )->transport = 'postMessage';

		// Country Select Field
		$wp_customize->add_setting(
			'country',
			array(
				'default'  	=> '',
				//'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'country',
			array(
				'choices' 		=> tillotson_country_list(),
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label' 		=> esc_html__( 'Country', 'tillotson' ),
				'priority' 		=> 250,
				'section' 		=> 'contact_info',
				'settings' 		=> 'country',
				'type' 			=> 'select'
			)
		);
		$wp_customize->get_setting( 'country' )->transport = 'postMessage';

		// Phone Number Field
		$wp_customize->add_setting(
			'phone_number',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'phone_number',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label'  		=> esc_html__( 'Phone Number', 'tillotson' ),
				'priority' 		=> 260,
				'section'  		=> 'contact_info',
				'settings' 		=> 'phone_number',
				'type' 			=> 'text'
			)
		);
		$wp_customize->get_setting( 'phone_number' )->transport = 'postMessage';

		// Email Field
		$wp_customize->add_setting(
			'email_address',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'email_address',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label'  		=> esc_html__( 'Email Address', 'tillotson' ),
				'priority'  	=> 270,
				'section'  		=> 'contact_info',
				'settings' 		=> 'email_address',
				'type' 			=> 'email'
			)
		);
		$wp_customize->get_setting( 'email_address' )->transport = 'postMessage';




		// Promo Box 1 Fields

		// Prom Box Text Field
		$wp_customize->add_setting(
			'promo_box_1_text',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'promo_box_1_text',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label'  		=> esc_html__( 'Text', 'tillotson' ),
				'priority' 		=> 10,
				'section'  		=> 'promo_box_1',
				'settings' 		=> 'promo_box_1_text',
				'type' 			=> 'text'
			)
		);
		$wp_customize->get_setting( 'promo_box_1_text' )->transport = 'postMessage';

		// Promo Box 1 URL Field
		$wp_customize->add_setting(
			'promo_box_1_url',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'promo_box_1_url',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label' 		=> esc_html__( 'URL', 'tillotson' ),
				'priority' 		=> 10,
				'section' 		=> 'promo_box_1',
				'settings' 		=> 'promo_box_1_url',
				'type' 			=> 'url'
			)
		);
		$wp_customize->get_setting( 'promo_box_1_url' )->transport = 'postMessage';

		// Promo Box 1 Logo Field
		$wp_customize->add_setting(
			'promo_box_1_logo',
			array(
				'default' => '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'promo_box_1_logo',
				array(
					'description' 	=> esc_html__( '', 'tillotson' ),
					'label' => esc_html__( 'Logo', 'tillotson' ),
					'priority' => 10,
					'section' => 'promo_box_1',
					'settings' => 'promo_box_1_logo'
				)
			)
		);
		$wp_customize->get_setting( 'promo_box_1_logo' )->transport = 'postMessage';

		// Promo Box 1 Background Image Field
		$wp_customize->add_setting(
			'promo_box_1_bg',
			array(
				'default' => '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'promo_box_1_bg',
				array(
					'description' 	=> esc_html__( '', 'tillotson' ),
					'label' => esc_html__( 'Background Image', 'tillotson' ),
					'priority' => 10,
					'section' => 'promo_box_1',
					'settings' => 'promo_box_1_bg'
				)
			)
		);
		$wp_customize->get_setting( 'promo_box_1_bg' )->transport = 'postMessage';



		// Promo Box 2 Fields

		// Promo Box Text Field
		$wp_customize->add_setting(
			'promo_box_2_text',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'promo_box_2_text',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label'  		=> esc_html__( 'Text', 'tillotson' ),
				'priority' 		=> 10,
				'section'  		=> 'promo_box_2',
				'settings' 		=> 'promo_box_2_text',
				'type' 			=> 'text'
			)
		);
		$wp_customize->get_setting( 'promo_box_2_text' )->transport = 'postMessage';

		// Promo Box 2 URL Field
		$wp_customize->add_setting(
			'promo_box_2_url',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'promo_box_2_url',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label' 		=> esc_html__( 'URL', 'tillotson' ),
				'priority' 		=> 10,
				'section' 		=> 'promo_box_2',
				'settings' 		=> 'promo_box_2_url',
				'type' 			=> 'url'
			)
		);
		$wp_customize->get_setting( 'promo_box_2_url' )->transport = 'postMessage';

		// Promo Box 2 Logo Field
		$wp_customize->add_setting(
			'promo_box_2_logo',
			array(
				'default' => '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'promo_box_2_logo',
				array(
					'description' 	=> esc_html__( '', 'tillotson' ),
					'label' => esc_html__( 'Logo', 'tillotson' ),
					'priority' => 10,
					'section' => 'promo_box_2',
					'settings' => 'promo_box_2_logo'
				)
			)
		);
		$wp_customize->get_setting( 'promo_box_2_logo' )->transport = 'postMessage';

		// Promo Box 2 Background Image Field
		$wp_customize->add_setting(
			'promo_box_2_bg',
			array(
				'default' => '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'promo_box_2_bg',
				array(
					'description' 	=> esc_html__( '', 'tillotson' ),
					'label' => esc_html__( 'Background Image', 'tillotson' ),
					'priority' => 10,
					'section' => 'promo_box_2',
					'settings' => 'promo_box_2_bg'
				)
			)
		);
		$wp_customize->get_setting( 'promo_box_2_bg' )->transport = 'postMessage';



		// Promo Box 3 Fields

		// Prom0 Box Text Field
		$wp_customize->add_setting(
			'promo_box_3_text',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'promo_box_3_text',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label'  		=> esc_html__( 'Text', 'tillotson' ),
				'priority' 		=> 10,
				'section'  		=> 'promo_box_3',
				'settings' 		=> 'promo_box_3_text',
				'type' 			=> 'text'
			)
		);
		$wp_customize->get_setting( 'promo_box_3_text' )->transport = 'postMessage';

		// Promo Box 3 URL Field
		$wp_customize->add_setting(
			'promo_box_3_url',
			array(
				'default'  	=> '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			'promo_box_3_url',
			array(
				'description' 	=> esc_html__( '', 'tillotson' ),
				'label' 		=> esc_html__( 'URL', 'tillotson' ),
				'priority' 		=> 10,
				'section' 		=> 'promo_box_3',
				'settings' 		=> 'promo_box_3_url',
				'type' 			=> 'url'
			)
		);
		$wp_customize->get_setting( 'promo_box_3_url' )->transport = 'postMessage';

		// Promo Box 3 Logo Field
		$wp_customize->add_setting(
			'promo_box_3_logo',
			array(
				'default' => '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'promo_box_3_logo',
				array(
					'description' 	=> esc_html__( '', 'tillotson' ),
					'label' => esc_html__( 'Logo', 'tillotson' ),
					'priority' => 10,
					'section' => 'promo_box_3',
					'settings' => 'promo_box_3_logo'
				)
			)
		);
		$wp_customize->get_setting( 'promo_box_3_logo' )->transport = 'postMessage';

		// Promo Box 3 Background Image Field
		$wp_customize->add_setting(
			'promo_box_3_bg',
			array(
				'default' => '',
				'transport' => 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'promo_box_3_bg',
				array(
					'description' 	=> esc_html__( '', 'tillotson' ),
					'label' => esc_html__( 'Background Image', 'tillotson' ),
					'priority' => 10,
					'section' => 'promo_box_3',
					'settings' => 'promo_box_3_bg'
				)
			)
		);
		$wp_customize->get_setting( 'promo_box_3_bg' )->transport = 'postMessage';

	} // register_fields()

	/**
	 * This will generate a line of CSS for use in header output. If the setting
	 * ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @access 		public
	 * @since 		1.0.0
	 * @see 		header_output()
	 * @param 		string 		$selector 		CSS selector
	 * @param 		string 		$style 			The name of the CSS *property* to modify
	 * @param 		string 		$mod_name 		The name of the 'theme_mod' option to fetch
	 * @param 		string 		$prefix 		Optional. Anything that needs to be output before the CSS property
	 * @param 		string 		$postfix 		Optional. Anything that needs to be output after the CSS property
	 * @param 		bool 		$echo 			Optional. Whether to print directly to the page (default: true).
	 * @return 		string 						Returns a single line of CSS with selectors and a property.
	 */
	public function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {

		$return = '';
		$mod 	= get_theme_mod( $mod_name );

		if ( ! empty( $mod ) ) {

			$return = sprintf('%s { %s:%s; }',
				$selector,
				$style,
				$prefix . $mod . $postfix
			);

			if ( $echo ) {

				echo $return;

			}

		}

		return $return;

	} // generate_css()

	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 *
	 * @hooked 		wp_head
	 * @access 		public
	 * @see 		add_action( 'wp_head', $func )
	 * @since 		1.0.0
	 */
	public function header_output() {

		?><!-- Customizer CSS -->
		<style type="text/css"><?php

			$this->generate_css( '#promo-box-1:before', 'background-image', 'promo_box_1_bg', 'url(', ')' );
			$this->generate_css( '#promo-box-2:before', 'background-image', 'promo_box_2_bg', 'url(', ')' );
			$this->generate_css( '#promo-box-3:before', 'background-image', 'promo_box_3_bg', 'url(', ')' );

			// pattern:
			// $this->generate_css( 'selector', 'style', 'mod_name', 'prefix', 'postfix', true );
			//
			// background-image example:
			// $this->generate_css( '.class', 'background-image', 'background_image_example', 'url(', ')' );


		?></style><!-- Customizer CSS --><?php

		/**
		 * Hides all but the first Soliloquy slide while using Customizer previewer.
		 */
		if ( is_customize_preview() ) {

			?><style type="text/css">

				li.soliloquy-item:not(:first-child) {
					display: none !important;
				}

			</style><!-- Customizer CSS --><?php

		}

	} // header_output()

	/**
	 * Returns true if a country has a custom select menu
	 *
	 * @param 		string 		$country 			The country code to check
	 * @return 		bool 							TRUE if the code is in the array, FALSE otherwise
	 */
	public function custom_countries( $country ) {

		$countries = array( 'US', 'CA', 'AU' );

		return in_array( $country, $countries );

	} // custom_countries()

	/**
	 * Loads files for Custom Controls.
	 *
	 * @hooked
	 */
	public function load_customize_controls() {

		// $files[] = 'control-editor.php';
		// $files[] = 'control-layout-picker.php';
		// $files[] = 'control-multiple-checkboxes.php';
		// $files[] = 'control-select-category.php';
		// $files[] = 'control-select-menu.php';
		// $files[] = 'control-select-post.php';
		// $files[] = 'control-select-post-type.php';
		// //$files[] = 'control-select-recent-post.php';
		// $files[] = 'control-select-tag.php';
		// $files[] = 'control-select-taxonomy.php';
		// $files[] = 'control-select-user.php';
		//
		// foreach ( $files as $file ) {
		//
		// 	require_once( trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/' . $file );
		//
		// }

	} // load_customize_controls()

	/**
	 * Returns an array of the Australian states and Territories.
	 * The optional parameters allows for returning just one state.
	 *
	 * @param 		string 		$state 		The state to return.
	 * @return 		array 					An array containing states.
	 */
	private function states_list_australia( $state = '' ) {

		$states = array();

		$states['ACT'] = esc_html__( 'Australian Capital Territory', 'tillotson' );
		$states['NSW'] = esc_html__( 'New South Wales', 'tillotson' );
		$states['NT' ] = esc_html__( 'Northern Territory', 'tillotson' );
		$states['QLD'] = esc_html__( 'Queensland', 'tillotson' );
		$states['SA' ] = esc_html__( 'South Australia', 'tillotson' );
		$states['TAS'] = esc_html__( 'Tasmania', 'tillotson' );
		$states['VIC'] = esc_html__( 'Victoria', 'tillotson' );
		$states['WA' ] = esc_html__( 'Western Australia', 'tillotson' );

		if ( ! empty( $state ) ) {

			return $states[$state];

		}

		return $states;

	} // states_list_australia()



	/**
	 * Returns an array of the Canadian states and Territories.
	 * The optional parameters allows for returning just one state.
	 *
	 * @param 		string 		$state 		The state to return.
	 * @return 		array 					An array containing states.
	 */
	private function states_list_canada( $state = '' ) {

		$states = array();

		$states['AB'] = esc_html__( 'Alberta', 'tillotson' );
		$states['BC'] = esc_html__( 'British Columbia', 'tillotson' );
		$states['MB'] = esc_html__( 'Manitoba', 'tillotson' );
		$states['NB'] = esc_html__( 'New Brunswick', 'tillotson' );
		$states['NL'] = esc_html__( 'Newfoundland and Labrador', 'tillotson' );
		$states['NT'] = esc_html__( 'Northwest Territories', 'tillotson' );
		$states['NS'] = esc_html__( 'Nova Scotia', 'tillotson' );
		$states['NU'] = esc_html__( 'Nunavut', 'tillotson' );
		$states['ON'] = esc_html__( 'Ontario', 'tillotson' );
		$states['PE'] = esc_html__( 'Prince Edward Island', 'tillotson' );
		$states['QC'] = esc_html__( 'Quebec', 'tillotson' );
		$states['SK'] = esc_html__( 'Saskatchewan', 'tillotson' );
		$states['YT'] = esc_html__( 'Yukon', 'tillotson' );

		if ( ! empty( $state ) ) {

			return $states[$state];

		}

		return $states;

	} // states_list_canada()

	/**
	 * Returns an array of the US states and Territories.
	 * The optional parameters allows for returning just one state.
	 *
	 * @param 		string 		$state 		The state to return.
	 * @return 		array 					An array containing states.
	 */
	private function states_list_unitedstates( $state = '' ) {

		$states = array();

		$states['AL'] = esc_html__( 'Alabama', 'tillotson' );
		$states['AK'] = esc_html__( 'Alaska', 'tillotson' );
		$states['AZ'] = esc_html__( 'Arizona', 'tillotson' );
		$states['AR'] = esc_html__( 'Arkansas', 'tillotson' );
		$states['CA'] = esc_html__( 'California', 'tillotson' );
		$states['CO'] = esc_html__( 'Colorado', 'tillotson' );
		$states['CT'] = esc_html__( 'Connecticut', 'tillotson' );
		$states['DE'] = esc_html__( 'Delaware', 'tillotson' );
		$states['DC'] = esc_html__( 'District of Columbia', 'tillotson' );
		$states['FL'] = esc_html__( 'Florida', 'tillotson' );
		$states['GA'] = esc_html__( 'Georgia', 'tillotson' );
		$states['HI'] = esc_html__( 'Hawaii', 'tillotson' );
		$states['ID'] = esc_html__( 'Idaho', 'tillotson' );
		$states['IL'] = esc_html__( 'Illinois', 'tillotson' );
		$states['IN'] = esc_html__( 'Indiana', 'tillotson' );
		$states['IA'] = esc_html__( 'Iowa', 'tillotson' );
		$states['KS'] = esc_html__( 'Kansas', 'tillotson' );
		$states['KY'] = esc_html__( 'Kentucky', 'tillotson' );
		$states['LA'] = esc_html__( 'Louisiana', 'tillotson' );
		$states['ME'] = esc_html__( 'Maine', 'tillotson' );
		$states['MD'] = esc_html__( 'Maryland', 'tillotson' );
		$states['MA'] = esc_html__( 'Massachusetts', 'tillotson' );
		$states['MI'] = esc_html__( 'Michigan', 'tillotson' );
		$states['MN'] = esc_html__( 'Minnesota', 'tillotson' );
		$states['MS'] = esc_html__( 'Mississippi', 'tillotson' );
		$states['MO'] = esc_html__( 'Missouri', 'tillotson' );
		$states['MT'] = esc_html__( 'Montana', 'tillotson' );
		$states['NE'] = esc_html__( 'Nebraska', 'tillotson' );
		$states['NV'] = esc_html__( 'Nevada', 'tillotson' );
		$states['NH'] = esc_html__( 'New Hampshire', 'tillotson' );
		$states['NJ'] = esc_html__( 'New Jersey', 'tillotson' );
		$states['NM'] = esc_html__( 'New Mexico', 'tillotson' );
		$states['NY'] = esc_html__( 'New York', 'tillotson' );
		$states['NC'] = esc_html__( 'North Carolina', 'tillotson' );
		$states['ND'] = esc_html__( 'North Dakota', 'tillotson' );
		$states['OH'] = esc_html__( 'Ohio', 'tillotson' );
		$states['OK'] = esc_html__( 'Oklahoma', 'tillotson' );
		$states['OR'] = esc_html__( 'Oregon', 'tillotson' );
		$states['PA'] = esc_html__( 'Pennsylvania', 'tillotson' );
		$states['RI'] = esc_html__( 'Rhode Island', 'tillotson' );
		$states['SC'] = esc_html__( 'South Carolina', 'tillotson' );
		$states['SD'] = esc_html__( 'South Dakota', 'tillotson' );
		$states['TN'] = esc_html__( 'Tennessee', 'tillotson' );
		$states['TX'] = esc_html__( 'Texas', 'tillotson' );
		$states['UT'] = esc_html__( 'Utah', 'tillotson' );
		$states['VT'] = esc_html__( 'Vermont', 'tillotson' );
		$states['VA'] = esc_html__( 'Virginia', 'tillotson' );
		$states['WA'] = esc_html__( 'Washington', 'tillotson' );
		$states['WV'] = esc_html__( 'West Virginia', 'tillotson' );
		$states['WI'] = esc_html__( 'Wisconsin', 'tillotson' );
		$states['WY'] = esc_html__( 'Wyoming', 'tillotson' );
		$states['AS'] = esc_html__( 'American Samoa', 'tillotson' );
		$states['AA'] = esc_html__( 'Armed Forces America (except Canada)', 'tillotson' );
		$states['AE'] = esc_html__( 'Armed Forces Africa/Canada/Europe/Middle East', 'tillotson' );
		$states['AP'] = esc_html__( 'Armed Forces Pacific', 'tillotson' );
		$states['FM'] = esc_html__( 'Federated States of Micronesia', 'tillotson' );
		$states['GU'] = esc_html__( 'Guam', 'tillotson' );
		$states['MH'] = esc_html__( 'Marshall Islands', 'tillotson' );
		$states['MP'] = esc_html__( 'Northern Mariana Islands', 'tillotson' );
		$states['PR'] = esc_html__( 'Puerto Rico', 'tillotson' );
		$states['PW'] = esc_html__( 'Palau', 'tillotson' );
		$states['VI'] = esc_html__( 'Virgin Islands', 'tillotson' );

		if ( ! empty( $state ) ) {

			return $states[$state];

		}

		return $states;

	} // states_list_unitedstates()




	/**
	 * Callbacks
	 */

	/**
	 * Returns TRUE based on which link type is selected, otherwise FALSE
	 *
	 * @param 		object 		$control 		The control object
	 * @return 		bool 						TRUE if conditions are met, otherwise FALSE
	 */
	public static function states_of_country_callback( $control ) {

		$country_setting = $control->manager->get_setting('country')->value();

		if ( 'us_state' === $control->id && 'US' === $country_setting ) { return true; }
		if ( 'canada_state' === $control->id && 'CA' === $country_setting ) { return true; }
		if ( 'australia_state' === $control->id && 'AU' === $country_setting ) { return true; }
		//if ( 'default_state' === $control->id && ! $this->custom_countries( $country_setting ) ) { return true; }

		return false;

	} // states_of_country_callback()

} // class

/**
 * Returns an array of countries or a country name.
 *
 * @param 		string 		$country 		Country code to return (optional)
 * @return 		array|string 				Array of countries or a single country name
 */
function tillotson_country_list( $country = '' ) {

	$countries = array();

	$countries['AF'] = esc_html__( 'Afghanistan (‫افغانستان‬‎)', 'tillotson' );
	$countries['AX'] = esc_html__( 'Åland Islands (Åland)', 'tillotson' );
	$countries['AL'] = esc_html__( 'Albania (Shqipëri)', 'tillotson' );
	$countries['DZ'] = esc_html__( 'Algeria (‫الجزائر‬‎)', 'tillotson' );
	$countries['AS'] = esc_html__( 'American Samoa', 'tillotson' );
	$countries['AD'] = esc_html__( 'Andorra', 'tillotson' );
	$countries['AO'] = esc_html__( 'Angola', 'tillotson' );
	$countries['AI'] = esc_html__( 'Anguilla', 'tillotson' );
	$countries['AQ'] = esc_html__( 'Antarctica', 'tillotson' );
	$countries['AG'] = esc_html__( 'Antigua and Barbuda', 'tillotson' );
	$countries['AR'] = esc_html__( 'Argentina', 'tillotson' );
	$countries['AM'] = esc_html__( 'Armenia (Հայաստան)', 'tillotson' );
	$countries['AW'] = esc_html__( 'Aruba', 'tillotson' );
	$countries['AC'] = esc_html__( 'Ascension Island', 'tillotson' );
	$countries['AU'] = esc_html__( 'Australia', 'tillotson' );
	$countries['AT'] = esc_html__( 'Austria (Österreich)', 'tillotson' );
	$countries['AZ'] = esc_html__( 'Azerbaijan (Azərbaycan)', 'tillotson' );
	$countries['BS'] = esc_html__( 'Bahamas', 'tillotson' );
	$countries['BH'] = esc_html__( 'Bahrain (‫البحرين‬‎)', 'tillotson' );
	$countries['BD'] = esc_html__( 'Bangladesh (বাংলাদেশ)', 'tillotson' );
	$countries['BB'] = esc_html__( 'Barbados', 'tillotson' );
	$countries['BY'] = esc_html__( 'Belarus (Беларусь)', 'tillotson' );
	$countries['BE'] = esc_html__( 'Belgium (België)', 'tillotson' );
	$countries['BZ'] = esc_html__( 'Belize', 'tillotson' );
	$countries['BJ'] = esc_html__( 'Benin (Bénin)', 'tillotson' );
	$countries['BM'] = esc_html__( 'Bermuda', 'tillotson' );
	$countries['BT'] = esc_html__( 'Bhutan (འབྲུག)', 'tillotson' );
	$countries['BO'] = esc_html__( 'Bolivia', 'tillotson' );
	$countries['BA'] = esc_html__( 'Bosnia and Herzegovina (Босна и Херцеговина)', 'tillotson' );
	$countries['BW'] = esc_html__( 'Botswana', 'tillotson' );
	$countries['BV'] = esc_html__( 'Bouvet Island', 'tillotson' );
	$countries['BR'] = esc_html__( 'Brazil (Brasil)', 'tillotson' );
	$countries['IO'] = esc_html__( 'British Indian Ocean Territory', 'tillotson' );
	$countries['VG'] = esc_html__( 'British Virgin Islands', 'tillotson' );
	$countries['BN'] = esc_html__( 'Brunei', 'tillotson' );
	$countries['BG'] = esc_html__( 'Bulgaria (България)', 'tillotson' );
	$countries['BF'] = esc_html__( 'Burkina Faso', 'tillotson' );
	$countries['BI'] = esc_html__( 'Burundi (Uburundi)', 'tillotson' );
	$countries['KH'] = esc_html__( 'Cambodia (កម្ពុជា)', 'tillotson' );
	$countries['CM'] = esc_html__( 'Cameroon (Cameroun)', 'tillotson' );
	$countries['CA'] = esc_html__( 'Canada', 'tillotson' );
	$countries['IC'] = esc_html__( 'Canary Islands (islas Canarias)', 'tillotson' );
	$countries['CV'] = esc_html__( 'Cape Verde (Kabu Verdi)', 'tillotson' );
	$countries['BQ'] = esc_html__( 'Caribbean Netherlands', 'tillotson' );
	$countries['KY'] = esc_html__( 'Cayman Islands', 'tillotson' );
	$countries['CF'] = esc_html__( 'Central African Republic (République centrafricaine)', 'tillotson' );
	$countries['EA'] = esc_html__( 'Ceuta and Melilla (Ceuta y Melilla)', 'tillotson' );
	$countries['TD'] = esc_html__( 'Chad (Tchad)', 'tillotson' );
	$countries['CL'] = esc_html__( 'Chile', 'tillotson' );
	$countries['CN'] = esc_html__( 'China (中国)', 'tillotson' );
	$countries['CX'] = esc_html__( 'Christmas Island', 'tillotson' );
	$countries['CP'] = esc_html__( 'Clipperton Island', 'tillotson' );
	$countries['CC'] = esc_html__( 'Cocos (Keeling) Islands (Kepulauan Cocos (Keeling))', 'tillotson' );
	$countries['CO'] = esc_html__( 'Colombia', 'tillotson' );
	$countries['KM'] = esc_html__( 'Comoros (‫جزر القمر‬‎)', 'tillotson' );
	$countries['CD'] = esc_html__( 'Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)', 'tillotson' );
	$countries['CG'] = esc_html__( 'Congo (Republic) (Congo-Brazzaville)', 'tillotson' );
	$countries['CK'] = esc_html__( 'Cook Islands', 'tillotson' );
	$countries['CR'] = esc_html__( 'Costa Rica', 'tillotson' );
	$countries['CI'] = esc_html__( 'Côte d’Ivoire', 'tillotson' );
	$countries['HR'] = esc_html__( 'Croatia (Hrvatska)', 'tillotson' );
	$countries['CU'] = esc_html__( 'Cuba', 'tillotson' );
	$countries['CW'] = esc_html__( 'Curaçao', 'tillotson' );
	$countries['CY'] = esc_html__( 'Cyprus (Κύπρος)', 'tillotson' );
	$countries['CZ'] = esc_html__( 'Czech Republic (Česká republika)', 'tillotson' );
	$countries['DK'] = esc_html__( 'Denmark (Danmark)', 'tillotson' );
	$countries['DG'] = esc_html__( 'Diego Garcia', 'tillotson' );
	$countries['DJ'] = esc_html__( 'Djibouti', 'tillotson' );
	$countries['DM'] = esc_html__( 'Dominica', 'tillotson' );
	$countries['DO'] = esc_html__( 'Dominican Republic (República Dominicana)', 'tillotson' );
	$countries['EC'] = esc_html__( 'Ecuador', 'tillotson' );
	$countries['EG'] = esc_html__( 'Egypt (‫مصر‬‎)', 'tillotson' );
	$countries['SV'] = esc_html__( 'El Salvador', 'tillotson' );
	$countries['GQ'] = esc_html__( 'Equatorial Guinea (Guinea Ecuatorial)', 'tillotson' );
	$countries['ER'] = esc_html__( 'Eritrea', 'tillotson' );
	$countries['EE'] = esc_html__( 'Estonia (Eesti)', 'tillotson' );
	$countries['ET'] = esc_html__( 'Ethiopia', 'tillotson' );
	$countries['FK'] = esc_html__( 'Falkland Islands (Islas Malvinas)', 'tillotson' );
	$countries['FO'] = esc_html__( 'Faroe Islands (Føroyar)', 'tillotson' );
	$countries['FJ'] = esc_html__( 'Fiji', 'tillotson' );
	$countries['FI'] = esc_html__( 'Finland (Suomi)', 'tillotson' );
	$countries['FR'] = esc_html__( 'France', 'tillotson' );
	$countries['GF'] = esc_html__( 'French Guiana (Guyane française)', 'tillotson' );
	$countries['PF'] = esc_html__( 'French Polynesia (Polynésie française)', 'tillotson' );
	$countries['TF'] = esc_html__( 'French Southern Territories (Terres australes françaises)', 'tillotson' );
	$countries['GA'] = esc_html__( 'Gabon', 'tillotson' );
	$countries['GM'] = esc_html__( 'Gambia', 'tillotson' );
	$countries['GE'] = esc_html__( 'Georgia (საქართველო)', 'tillotson' );
	$countries['DE'] = esc_html__( 'Germany (Deutschland)', 'tillotson' );
	$countries['GH'] = esc_html__( 'Ghana (Gaana)', 'tillotson' );
	$countries['GI'] = esc_html__( 'Gibraltar', 'tillotson' );
	$countries['GR'] = esc_html__( 'Greece (Ελλάδα)', 'tillotson' );
	$countries['GL'] = esc_html__( 'Greenland (Kalaallit Nunaat)', 'tillotson' );
	$countries['GD'] = esc_html__( 'Grenada', 'tillotson' );
	$countries['GP'] = esc_html__( 'Guadeloupe', 'tillotson' );
	$countries['GU'] = esc_html__( 'Guam', 'tillotson' );
	$countries['GT'] = esc_html__( 'Guatemala', 'tillotson' );
	$countries['GG'] = esc_html__( 'Guernsey', 'tillotson' );
	$countries['GN'] = esc_html__( 'Guinea (Guinée)', 'tillotson' );
	$countries['GW'] = esc_html__( 'Guinea-Bissau (Guiné Bissau)', 'tillotson' );
	$countries['GY'] = esc_html__( 'Guyana', 'tillotson' );
	$countries['HT'] = esc_html__( 'Haiti', 'tillotson' );
	$countries['HM'] = esc_html__( 'Heard & McDonald Islands', 'tillotson' );
	$countries['HN'] = esc_html__( 'Honduras', 'tillotson' );
	$countries['HK'] = esc_html__( 'Hong Kong (香港)', 'tillotson' );
	$countries['HU'] = esc_html__( 'Hungary (Magyarország)', 'tillotson' );
	$countries['IS'] = esc_html__( 'Iceland (Ísland)', 'tillotson' );
	$countries['IN'] = esc_html__( 'India (भारत)', 'tillotson' );
	$countries['ID'] = esc_html__( 'Indonesia', 'tillotson' );
	$countries['IR'] = esc_html__( 'Iran (‫ایران‬‎)', 'tillotson' );
	$countries['IQ'] = esc_html__( 'Iraq (‫العراق‬‎)', 'tillotson' );
	$countries['IE'] = esc_html__( 'Ireland', 'tillotson' );
	$countries['IM'] = esc_html__( 'Isle of Man', 'tillotson' );
	$countries['IL'] = esc_html__( 'Israel (‫ישראל‬‎)', 'tillotson' );
	$countries['IT'] = esc_html__( 'Italy (Italia)', 'tillotson' );
	$countries['JM'] = esc_html__( 'Jamaica', 'tillotson' );
	$countries['JP'] = esc_html__( 'Japan (日本)', 'tillotson' );
	$countries['JE'] = esc_html__( 'Jersey', 'tillotson' );
	$countries['JO'] = esc_html__( 'Jordan (‫الأردن‬‎)', 'tillotson' );
	$countries['KZ'] = esc_html__( 'Kazakhstan (Казахстан)', 'tillotson' );
	$countries['KE'] = esc_html__( 'Kenya', 'tillotson' );
	$countries['KI'] = esc_html__( 'Kiribati', 'tillotson' );
	$countries['XK'] = esc_html__( 'Kosovo (Kosovë)', 'tillotson' );
	$countries['KW'] = esc_html__( 'Kuwait (‫الكويت‬‎)', 'tillotson' );
	$countries['KG'] = esc_html__( 'Kyrgyzstan (Кыргызстан)', 'tillotson' );
	$countries['LA'] = esc_html__( 'Laos (ລາວ)', 'tillotson' );
	$countries['LV'] = esc_html__( 'Latvia (Latvija)', 'tillotson' );
	$countries['LB'] = esc_html__( 'Lebanon (‫لبنان‬‎)', 'tillotson' );
	$countries['LS'] = esc_html__( 'Lesotho', 'tillotson' );
	$countries['LR'] = esc_html__( 'Liberia', 'tillotson' );
	$countries['LY'] = esc_html__( 'Libya (‫ليبيا‬‎)', 'tillotson' );
	$countries['LI'] = esc_html__( 'Liechtenstein', 'tillotson' );
	$countries['LT'] = esc_html__( 'Lithuania (Lietuva)', 'tillotson' );
	$countries['LU'] = esc_html__( 'Luxembourg', 'tillotson' );
	$countries['MO'] = esc_html__( 'Macau (澳門)', 'tillotson' );
	$countries['MK'] = esc_html__( 'Macedonia (FYROM) (Македонија)', 'tillotson' );
	$countries['MG'] = esc_html__( 'Madagascar (Madagasikara)', 'tillotson' );
	$countries['MW'] = esc_html__( 'Malawi', 'tillotson' );
	$countries['MY'] = esc_html__( 'Malaysia', 'tillotson' );
	$countries['MV'] = esc_html__( 'Maldives', 'tillotson' );
	$countries['ML'] = esc_html__( 'Mali', 'tillotson' );
	$countries['MT'] = esc_html__( 'Malta', 'tillotson' );
	$countries['MH'] = esc_html__( 'Marshall Islands', 'tillotson' );
	$countries['MQ'] = esc_html__( 'Martinique', 'tillotson' );
	$countries['MR'] = esc_html__( 'Mauritania (‫موريتانيا‬‎)', 'tillotson' );
	$countries['MU'] = esc_html__( 'Mauritius (Moris)', 'tillotson' );
	$countries['YT'] = esc_html__( 'Mayotte', 'tillotson' );
	$countries['MX'] = esc_html__( 'Mexico (México)', 'tillotson' );
	$countries['FM'] = esc_html__( 'Micronesia', 'tillotson' );
	$countries['MD'] = esc_html__( 'Moldova (Republica Moldova)', 'tillotson' );
	$countries['MC'] = esc_html__( 'Monaco', 'tillotson' );
	$countries['MN'] = esc_html__( 'Mongolia (Монгол)', 'tillotson' );
	$countries['ME'] = esc_html__( 'Montenegro (Crna Gora)', 'tillotson' );
	$countries['MS'] = esc_html__( 'Montserrat', 'tillotson' );
	$countries['MA'] = esc_html__( 'Morocco (‫المغرب‬‎)', 'tillotson' );
	$countries['MZ'] = esc_html__( 'Mozambique (Moçambique)', 'tillotson' );
	$countries['MM'] = esc_html__( 'Myanmar (Burma) (မြန်မာ)', 'tillotson' );
	$countries['NA'] = esc_html__( 'Namibia (Namibië)', 'tillotson' );
	$countries['NR'] = esc_html__( 'Nauru', 'tillotson' );
	$countries['NP'] = esc_html__( 'Nepal (नेपाल)', 'tillotson' );
	$countries['NL'] = esc_html__( 'Netherlands (Nederland)', 'tillotson' );
	$countries['NC'] = esc_html__( 'New Caledonia (Nouvelle-Calédonie)', 'tillotson' );
	$countries['NZ'] = esc_html__( 'New Zealand', 'tillotson' );
	$countries['NI'] = esc_html__( 'Nicaragua', 'tillotson' );
	$countries['NE'] = esc_html__( 'Niger (Nijar)', 'tillotson' );
	$countries['NG'] = esc_html__( 'Nigeria', 'tillotson' );
	$countries['NU'] = esc_html__( 'Niue', 'tillotson' );
	$countries['NF'] = esc_html__( 'Norfolk Island', 'tillotson' );
	$countries['MP'] = esc_html__( 'Northern Mariana Islands', 'tillotson' );
	$countries['KP'] = esc_html__( 'North Korea (조선 민주주의 인민 공화국)', 'tillotson' );
	$countries['NO'] = esc_html__( 'Norway (Norge)', 'tillotson' );
	$countries['OM'] = esc_html__( 'Oman (‫عُمان‬‎)', 'tillotson' );
	$countries['PK'] = esc_html__( 'Pakistan (‫پاکستان‬‎)', 'tillotson' );
	$countries['PW'] = esc_html__( 'Palau', 'tillotson' );
	$countries['PS'] = esc_html__( 'Palestine (‫فلسطين‬‎)', 'tillotson' );
	$countries['PA'] = esc_html__( 'Panama (Panamá)', 'tillotson' );
	$countries['PG'] = esc_html__( 'Papua New Guinea', 'tillotson' );
	$countries['PY'] = esc_html__( 'Paraguay', 'tillotson' );
	$countries['PE'] = esc_html__( 'Peru (Perú)', 'tillotson' );
	$countries['PH'] = esc_html__( 'Philippines', 'tillotson' );
	$countries['PN'] = esc_html__( 'Pitcairn Islands', 'tillotson' );
	$countries['PL'] = esc_html__( 'Poland (Polska)', 'tillotson' );
	$countries['PT'] = esc_html__( 'Portugal', 'tillotson' );
	$countries['PR'] = esc_html__( 'Puerto Rico', 'tillotson' );
	$countries['QA'] = esc_html__( 'Qatar (‫قطر‬‎)', 'tillotson' );
	$countries['RE'] = esc_html__( 'Réunion (La Réunion)', 'tillotson' );
	$countries['RO'] = esc_html__( 'Romania (România)', 'tillotson' );
	$countries['RU'] = esc_html__( 'Russia (Россия)', 'tillotson' );
	$countries['RW'] = esc_html__( 'Rwanda', 'tillotson' );
	$countries['BL'] = esc_html__( 'Saint Barthélemy (Saint-Barthélemy)', 'tillotson' );
	$countries['SH'] = esc_html__( 'Saint Helena', 'tillotson' );
	$countries['KN'] = esc_html__( 'Saint Kitts and Nevis', 'tillotson' );
	$countries['LC'] = esc_html__( 'Saint Lucia', 'tillotson' );
	$countries['MF'] = esc_html__( 'Saint Martin (Saint-Martin (partie française))', 'tillotson' );
	$countries['PM'] = esc_html__( 'Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)', 'tillotson' );
	$countries['WS'] = esc_html__( 'Samoa', 'tillotson' );
	$countries['SM'] = esc_html__( 'San Marino', 'tillotson' );
	$countries['ST'] = esc_html__( 'São Tomé and Príncipe (São Tomé e Príncipe)', 'tillotson' );
	$countries['SA'] = esc_html__( 'Saudi Arabia (‫المملكة العربية السعودية‬‎)', 'tillotson' );
	$countries['SN'] = esc_html__( 'Senegal (Sénégal)', 'tillotson' );
	$countries['RS'] = esc_html__( 'Serbia (Србија)', 'tillotson' );
	$countries['SC'] = esc_html__( 'Seychelles', 'tillotson' );
	$countries['SL'] = esc_html__( 'Sierra Leone', 'tillotson' );
	$countries['SG'] = esc_html__( 'Singapore', 'tillotson' );
	$countries['SX'] = esc_html__( 'Sint Maarten', 'tillotson' );
	$countries['SK'] = esc_html__( 'Slovakia (Slovensko)', 'tillotson' );
	$countries['SI'] = esc_html__( 'Slovenia (Slovenija)', 'tillotson' );
	$countries['SB'] = esc_html__( 'Solomon Islands', 'tillotson' );
	$countries['SO'] = esc_html__( 'Somalia (Soomaaliya)', 'tillotson' );
	$countries['ZA'] = esc_html__( 'South Africa', 'tillotson' );
	$countries['GS'] = esc_html__( 'South Georgia & South Sandwich Islands', 'tillotson' );
	$countries['KR'] = esc_html__( 'South Korea (대한민국)', 'tillotson' );
	$countries['SS'] = esc_html__( 'South Sudan (‫جنوب السودان‬‎)', 'tillotson' );
	$countries['ES'] = esc_html__( 'Spain (España)', 'tillotson' );
	$countries['LK'] = esc_html__( 'Sri Lanka (ශ්‍රී ලංකාව)', 'tillotson' );
	$countries['VC'] = esc_html__( 'St. Vincent & Grenadines', 'tillotson' );
	$countries['SD'] = esc_html__( 'Sudan (‫السودان‬‎)', 'tillotson' );
	$countries['SR'] = esc_html__( 'Suriname', 'tillotson' );
	$countries['SJ'] = esc_html__( 'Svalbard and Jan Mayen (Svalbard og Jan Mayen)', 'tillotson' );
	$countries['SZ'] = esc_html__( 'Swaziland', 'tillotson' );
	$countries['SE'] = esc_html__( 'Sweden (Sverige)', 'tillotson' );
	$countries['CH'] = esc_html__( 'Switzerland (Schweiz)', 'tillotson' );
	$countries['SY'] = esc_html__( 'Syria (‫سوريا‬‎)', 'tillotson' );
	$countries['TW'] = esc_html__( 'Taiwan (台灣)', 'tillotson' );
	$countries['TJ'] = esc_html__( 'Tajikistan', 'tillotson' );
	$countries['TZ'] = esc_html__( 'Tanzania', 'tillotson' );
	$countries['TH'] = esc_html__( 'Thailand (ไทย)', 'tillotson' );
	$countries['TL'] = esc_html__( 'Timor-Leste', 'tillotson' );
	$countries['TG'] = esc_html__( 'Togo', 'tillotson' );
	$countries['TK'] = esc_html__( 'Tokelau', 'tillotson' );
	$countries['TO'] = esc_html__( 'Tonga', 'tillotson' );
	$countries['TT'] = esc_html__( 'Trinidad and Tobago', 'tillotson' );
	$countries['TA'] = esc_html__( 'Tristan da Cunha', 'tillotson' );
	$countries['TN'] = esc_html__( 'Tunisia (‫تونس‬‎)', 'tillotson' );
	$countries['TR'] = esc_html__( 'Turkey (Türkiye)', 'tillotson' );
	$countries['TM'] = esc_html__( 'Turkmenistan', 'tillotson' );
	$countries['TC'] = esc_html__( 'Turks and Caicos Islands', 'tillotson' );
	$countries['TV'] = esc_html__( 'Tuvalu', 'tillotson' );
	$countries['UM'] = esc_html__( 'U.S. Outlying Islands', 'tillotson' );
	$countries['VI'] = esc_html__( 'U.S. Virgin Islands', 'tillotson' );
	$countries['UG'] = esc_html__( 'Uganda', 'tillotson' );
	$countries['UA'] = esc_html__( 'Ukraine (Україна)', 'tillotson' );
	$countries['AE'] = esc_html__( 'United Arab Emirates (‫الإمارات العربية المتحدة‬‎)', 'tillotson' );
	$countries['GB'] = esc_html__( 'United Kingdom', 'tillotson' );
	$countries['US'] = esc_html__( 'United States', 'tillotson' );
	$countries['UY'] = esc_html__( 'Uruguay', 'tillotson' );
	$countries['UZ'] = esc_html__( 'Uzbekistan (Oʻzbekiston)', 'tillotson' );
	$countries['VU'] = esc_html__( 'Vanuatu', 'tillotson' );
	$countries['VA'] = esc_html__( 'Vatican City (Città del Vaticano)', 'tillotson' );
	$countries['VE'] = esc_html__( 'Venezuela', 'tillotson' );
	$countries['VN'] = esc_html__( 'Vietnam (Việt Nam)', 'tillotson' );
	$countries['WF'] = esc_html__( 'Wallis and Futuna', 'tillotson' );
	$countries['EH'] = esc_html__( 'Western Sahara (‫الصحراء الغربية‬‎)', 'tillotson' );
	$countries['YE'] = esc_html__( 'Yemen (‫اليمن‬‎)', 'tillotson' );
	$countries['ZM'] = esc_html__( 'Zambia', 'tillotson' );
	$countries['ZW'] = esc_html__( 'Zimbabwe', 'tillotson' );

	if ( ! empty( $country ) ) {

		return $countries[$country];

	}

	return $countries;

} // tillotson_country_list()

/**
 * Returns TRUE based on which link type is selected, otherwise FALSE
 *
 * @param 		object 		$control 		The control object
 * @return 		bool 						TRUE if conditions are met, otherwise FALSE
 */
function tillotson_linktype_callback( $control ) {

	$radio_setting = $control->manager->get_setting('linktype')->value();

	//wp_die( print_r( $radio_setting ) );
	//wp_die( print_r( $control->id ) );

	if ( 'externallinkurl1' === $control->id && 'external' === $radio_setting ) { return true; }
	if ( 'internalpageid1' === $control->id && 'internal' === $radio_setting ) { return true; }

	return false;

} // tillotson_linktype_callback()

/**
 * Returns TRUE based on which link type is selected, otherwise FALSE
 *
 * @param 		object 		$control 		The control object
 * @return 		bool 						TRUE if conditions are met, otherwise FALSE
 */
function tillotson_states_of_country_callback( $control ) {

	$country_setting = $control->manager->get_setting('country')->value();

	if ( 'us_state' === $control->id && 'US' === $country_setting ) { return true; }
	if ( 'canada_state' === $control->id && 'CA' === $country_setting ) { return true; }
	if ( 'australia_state' === $control->id && 'AU' === $country_setting ) { return true; }
	if ( 'default_state' === $control->id && ! tillotson_custom_countries( $country_setting ) ) { return true; }

	return false;

} // tillotson_states_of_country_callback()

/**
 * Returns true if a country has a custom select menu
 *
 * @param 		string 		$country 			The country code to check
 * @return 		bool 							TRUE if the code is in the array, FALSE otherwise
 */
function tillotson_custom_countries( $country ) {

	$countries = array( 'US', 'CA', 'AU' );

	return in_array( $country, $countries );

} // tillotson_custom_countries()
