<?php

/**
 * Register all actions and filters for the theme
 *
 * @since 		1.0.0
 *
 * @package 	Tillotson
 */
class Tillotson_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the theme loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the theme loads.
	 */
	protected $filters;

	/**
	 * The array of meta registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $meta    The meta to register with WordPress.
	 */
	protected $meta;

	/**
	 * The array of shortcodes registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $shortcodes    The shortcodes registered with WordPress to fire when the theme loads.
	 */
	protected $shortcodes;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions 		= array();
		$this->filters 		= array();
		$this->meta 		= array();
		$this->shortcodes 	= array();

	} // __construct()

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $class			A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $class.
	 * @param    int                  $priority         Optional. he priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function action( $hook, $class, $callback, $priority = 10, $accepted_args = 1 ) {

		$this->actions = $this->add( $this->actions, $hook, $class, $callback, $priority, $accepted_args );

	} // action()

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $class			A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $class.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $class, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'class' 		=> $class,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	} // add()

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $class			A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $class.
	 * @param    int                  $priority         Optional. he priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function filter( $hook, $class, $callback, $priority = 10, $accepted_args = 1 ) {

		$this->filters = $this->add( $this->filters, $hook, $class, $callback, $priority, $accepted_args );

	} // filter()

	/**
	 * Add a new meta to the collection to be registered with WordPress
	 *
	 * @since 	1.0.0
	 * @param 	string 		$hook 			The name of the WordPress shortcode being registered.
	 * @param 	object 		$class 			A reference to the instance of the object on which the action is defined.
	 * @param 	string 		$callback 		The name of the function definition on the $class.
	 */
	public function meta( $type, $key, $class, $callback ) {

		$this->meta = $this->add( $this->meta, array( $type, $key ), $class, $callback, '', '' );

	} // meta()

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['class'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['class'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->meta as $meta ) {
			register_meta( $meta['hook'][0], $meta['hook'][1], array( $meta['class'], $meta['callback'] ) );
		}

		foreach ( $this->shortcodes as $hook ) {
			add_shortcode( $hook['hook'], array( $hook['class'], $hook['callback'] ) );
		}

	} // run()

	/**
	 * Add a new shortcode to the collection to be registered with WordPress
	 *
	 * @since 	1.0.0
	 * @param 	string 		$hook 			The name of the WordPress shortcode being registered.
	 * @param 	object 		$class 			A reference to the instance of the object on which the action is defined.
	 * @param 	string 		$callback 		The name of the function definition on the $class.
	 */
	public function shortcode( $shortcode, $class, $callback ) {

		$this->shortcodes = $this->add( $this->shortcodes, $shortcode, $class, $callback, '', '' );

	} // shortcode()

} // class
