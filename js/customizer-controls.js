/**
 * Theme Customizer control scripts.
 */

( function( $ ) {

	wp.customize.bind( 'ready', function () {
		wp.customize.control( 'us_state', function( control ) {
			var setting = wp.customize( 'country' );
			control.active.set( 'US' === setting.get() );
			setting.bind( function( value ) {
				control.active.set( 'US' === value );
			} );
		} );

		wp.customize.control( 'canada_state', function( control ) {
			var setting = wp.customize( 'country' );
			control.active.set( 'CA' === setting.get() );
			setting.bind( function( value ) {
				control.active.set( 'CA' === value );
			} );
		} );

		wp.customize.control( 'australia_state', function( control ) {
			var setting = wp.customize( 'country' );
			control.active.set( 'AU' === setting.get() );
			setting.bind( function( value ) {
				control.active.set( 'AU' === value );
			} );
		} );

		wp.customize.control( 'default_state', function( control ) {
			var setting = wp.customize( 'country' );
			control.active.set( 'US' !== setting.get() && 'CA' !== setting.get() && 'AU' !== setting.get() );
			setting.bind( function( value ) {
				console.log(value);
				control.active.set( 'US' !== value && 'CA' !== value && 'AU' !== value );
			} );
		} );
	} );

} )( jQuery );