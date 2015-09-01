<?php
/**
 * _s Theme Customizer
 *
 * @package _s
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

/**
 * Tillotson Theme Customizer
 *
 * Contains methods for customizing the theme customization screen.
 *
 * @link 		http://codex.wordpress.org/Theme_Customization_API
 * @since 		1.0.0
 * @package  	DocBlock
 */
class tillotson_Customize {

   /**
	* This hooks into 'customize_register' (available as of WP 3.4) and allows
	* you to add new sections and controls to the Theme Customize screen.
	*
	* Note: To enable instant preview, we have to actually write a bit of custom
	* javascript. See live_preview() for more.
	*
	* @access 		public
	* @see 			add_action( 'customize_register', $func )
	* @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	* @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	* @since 		1.0.0
	*/
	public static function register( $wp_customize ) {

		// Panels

		// Theme Options Panel
		$wp_customize->add_panel( 'theme_options',
			array(
				'capability'  		=> 'edit_theme_options',
				'description'  		=> esc_html__( 'Options for Tillotson', 'tillotson' ),
				'priority'  		=> 10,
				'theme_supports'  	=> '',
				'title'  			=> esc_html__( 'Theme Options', 'tillotson' ),
			)
		);



		// Sections

		// Images Section
		$wp_customize->add_section( 'tillotson_images',
			array(
				'capability' 		=> 'edit_theme_options',
				'description' 		=> esc_html__( 'Images', 'tillotson' ),
				'panel' 			=> 'theme_options',
				'priority' 			=> 10,
				'title' 			=> esc_html__( 'Images', 'tillotson' )
			)
		);



		// Add Fields & Controls

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
					'description' 	=> esc_html__( 'The header image to use if there is not one chosen', 'tillotson' ),
					'label' 		=> esc_html__( 'Default Header Image', 'tillotson' ),
					'section' 		=> 'tillotson_images',
					'settings' 		=> 'default_header_image'
				)
			)
		);

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
					'description' 	=> esc_html__( 'The product thumbnail to use if there is not one chosen.', 'tillotson' ),
					'label' 		=> esc_html__( 'Default Product Thumbnail', 'tillotson' ),
					'section' 		=> 'tillotson_images',
					'settings' 		=> 'default_product_thumbnail'
				)
			)
		);

		// Default Product Category Logo
		$wp_customize->add_setting(
			'default_product_category_logo',
			array(
				'default' 			=> '',
				'transport' 		=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'default_product_category_logo',
				array(
					'description' 	=> esc_html__( 'The logo to use if there is not one chosen for a product category.', 'tillotson' ),
					'label' 		=> esc_html__( 'Default Product Category Logo', 'tillotson' ),
					'section' 		=> 'tillotson_images',
					'settings' 		=> 'default_product_category_logo'
				)
			)
		);



/*		// Text Field
		$wp_customize->add_setting(
			'text_field',
			array(
				'default' 		=> '',
				'transport' 	=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'text_field',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label'  		=> esc_html__( 'Text Field', 'tillotson' ),
				'section'  		=> 'new_section',
				'settings' 		=> 'text_field',
				'type' 			=> 'text'
			)
		);



		// URL Field
		$wp_customize->add_setting(
			'url_field',
			array(
				'default' 		=> '',
				'transport' 	=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'url_field',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' 		=> esc_html__( 'URL Field', 'tillotson' ),
				'section' 		=> 'new_section',
				'settings' 		=> 'url_field',
				'type' 			=> 'url'
			)
		);



		// Email Field
		$wp_customize->add_setting(
			'email_field',
			array(
				'default' 		=> '',
				'transport' 	=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'email_field',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' 		=> esc_html__( 'Email Field', 'tillotson' ),
				'section' 		=> 'new_section',
				'settings' 		=> 'email_field',
				'type' 			=> 'email'
			)
		);

		// Date Field
		$wp_customize->add_setting(
			'date_field',
			array(
				'default' 		=> '',
				'transport' 	=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'date_field',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' 		=> esc_html__( 'Date Field', 'tillotson' ),
				'section' 		=> 'new_section',
				'settings' 		=> 'date_field',
				'type' 			=> 'date'
			)
		);


		// Checkbox Field
		$wp_customize->add_setting(
			'checkbox_field',
			array(
				'default'  		=> 'true',
				'transport' 	=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'checkbox_field',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' 		=> esc_html__( 'Checkbox Field', 'tillotson' ),
				'section' 		=> 'new_section',
				'settings' 		=> 'checkbox_field',
				'type'			=> 'checkbox'
			)
		);*/


/*

		// Password Field
		$wp_customize->add_setting(
			'password_field',
			array(
				'default' 		=> '',
				'transport' 	=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'password_field',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' 		=> esc_html__( 'Password Field', 'tillotson' ),
				'section' 		=> 'new_section',
				'settings' 		=> 'password_field',
				'type' 			=> 'password'
			)
		);



		// Checkbox Field
		$wp_customize->add_setting(
			'checkbox_field',
			array(
				'default'  		=> 'true',
				'transport' 	=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'checkbox_field',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' 		=> esc_html__( 'Checkbox Field', 'tillotson' ),
				'section' 		=> 'new_section',
				'settings' 		=> 'checkbox_field',
				'type' 			=> 'checkbox'
			)
		);



		// Radio Field
		$wp_customize->add_setting(
			'radio_field',
			array(
				'default'  		=> 'choice1',
				'transport' 	=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'radio_field',
			array(
				'choices' => array(
					'choice1' => esc_html__( 'Choice 1', 'tillotson' ),
					'choice2' => esc_html__( 'Choice 2', 'tillotson' ),
					'choice3' => esc_html__( 'Choice 3', 'tillotson' )
				),
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' 		=> esc_html__( 'Radio Field', 'tillotson' ),
				'section' 		=> 'new_section',
				'settings' 		=> 'radio_field',
				'type' 			=> 'radio'
			)
		);



		// Select Field
		$wp_customize->add_setting(
			'select_field',
			array(
				'default'  		=> 'choice1',
				'transport' 	=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'select_field',
			array(
				'choices' => array(
					'choice1' 	=> esc_html__( 'Choice 1', 'tillotson' ),
					'choice2' 	=> esc_html__( 'Choice 2', 'tillotson' ),
					'choice3' 	=> esc_html__( 'Choice 3', 'tillotson' )
				),
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' 		=> esc_html__( 'Select Field', 'tillotson' ),
				'section' 		=> 'new_section',
				'settings' 		=> 'select_field',
				'type' 			=> 'select'
			)
		);



		// Textarea Field
		$wp_customize->add_setting(
			'textarea_field',
			array(
				'default' 		=> '',
				'transport' 	=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'textarea_field',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' 		=> esc_html__( 'Textarea Field', 'tillotson' ),
				'section' 		=> 'new_section',
				'settings' 		=> 'textarea_field',
				'type' 			=> 'textarea'
			)
		);



		// Range Field
		$wp_customize->add_setting(
			'range_field',
			array(
				'default' 		=> '',
				'transport' 	=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'range_field',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'input_attrs' 	=> array(
					'class' 	=> 'range-field',
					'max' 		=> 100,
					'min' 		=> 0,
					'step' 		=> 1,
					'style' 	=> 'color: #020202'
				),
				'label' 		=> esc_html__( 'Range Field', 'tillotson' ),
				'section' 		=> 'new_section',
				'settings' 		=> 'range_field',
				'type' 			=> 'range'
			)
		);



		// Page Select Field
		$wp_customize->add_setting(
			'select_page_field',
			array(
				'default' 		=> '',
				'transport' 	=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'select_page_field',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' 		=> esc_html__( 'Select Page', 'tillotson' ),
				'section' 		=> 'new_section',
				'settings' 		=> 'select_page_field',
				'type' 			=> 'dropdown-pages'
			)
		);



		// Color Chooser Field
		$wp_customize->add_setting(
			'color_field',
			array(
				'default'  			=> '#ffffff',
				'transport' 		=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'color_field',
				array(
					'description' 	=> esc_html__( '', 'text-domain' ),
					'label' 		=> esc_html__( 'Color Field', 'tillotson' ),
					'section' 		=> 'new_section',
					'settings' 		=> 'color_field'
				),
			)
		);



		// File Upload Field
		$wp_customize->add_setting( 'file_upload' );
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'file_upload',
				array(
					'description' 	=> esc_html__( '', 'text-domain' ),
					'label' 		=> esc_html__( 'File Upload', 'tillotson' ),
					'section' 		=> 'new_section',
					'settings' 		=> 'file_upload'
				),
			)
		);



		// Image Upload Field
		$wp_customize->add_setting(
			'image_upload',
			array(
				'default' 			=> '',
				'transport' 		=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'image_upload',
				array(
					'description' 	=> esc_html__( '', 'text-domain' ),
					'label' 		=> esc_html__( 'Image Field', 'tillotson' ),
					'section' 		=> 'new_section',
					'settings' 		=> 'image_upload'
				)
			)
		);
		*/


		// Enable live preview JS
		$wp_customize->get_setting( 'blogname' )->transport 		= 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport 	= 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


/*		$wp_customize->get_setting( 'text_field' )->transport 		= 'postMessage';
		$wp_customize->get_setting( 'url_field' )->transport 		= 'postMessage';
		$wp_customize->get_setting( 'email_field' )->transport 		= 'postMessage';
		$wp_customize->get_setting( 'date_field' )->transport 		= 'postMessage';
		$wp_customize->get_setting( 'checkbox_field' )->transport 	= 'postMessage';*/

	} // register()

	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 *
	 * Used by hook: 'wp_head'
	 *
	 * @access 		public
	 * @see 		add_action( 'wp_head', $func )
	 * @since 		1.0.0
	 */
	public static function header_output() {

		?><!-- Customizer CSS -->
		<style type="text/css"><?php

			// pattern:
			// tillotson_Customize::generate_css( 'selector', 'style', 'mod_name', 'prefix', 'postfix', true );
			//
			// background-image example:
			// tillotson_Customize::generate_css( '.class', 'background-image', 'background_image_example', 'url(', ')' );

		?></style><!-- Customizer CSS --><?php

	} // header_output()

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * Used by hook: 'customize_preview_init'
	 *
	 * @access 		public
	 * @see 		add_action( 'customize_preview_init', $func )
	 * @since 		1.0.0
	 */
	public static function live_preview() {

		wp_enqueue_script( 'tillotson_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'jquery', 'customize-preview' ), '', true );

	} // live_preview()

	/**
	 * This will generate a line of CSS for use in header output. If the setting
	 * ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @access 		public
	 * @since 		1.0.0
	 * @param 		string 		$selector 		CSS selector
	 * @param 		string 		$style 			The name of the CSS *property* to modify
	 * @param 		string 		$mod_name 		The name of the 'theme_mod' option to fetch
	 * @param 		string 		$prefix 		Optional. Anything that needs to be output before the CSS property
	 * @param 		string 		$postfix 		Optional. Anything that needs to be output after the CSS property
	 * @param 		bool 		$echo 			Optional. Whether to print directly to the page (default: true).
	 * @return 		string 						Returns a single line of CSS with selectors and a property.
	 */
	public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {

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

} // class

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'tillotson_Customize' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'tillotson_Customize' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'tillotson_Customize' , 'live_preview' ) );
