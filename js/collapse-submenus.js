/**
 * Collapses and expands submenus
 */

( function( $ ) {

	 $.fn.inlineStyle = function (prop) {

		return this.prop( "style" )[$.camelCase( prop )];

    };

	var dealers = $( '.dealers' );
	var deallink = dealers.children( 'a' );
	var dealsub = dealers.children( ".sub-menu" );

	if ( ! dealers.hasClass( "open" ) ) {

		deallink.click( function( event ) {

			event.preventDefault();

			dealsub.slideToggle(250);
			dealers.toggleClass( "open" );

		});

	} // if

	var products = $( '.products' );
	var prodlink = products.children( 'a' );
	var prodsub = products.children( ".sub-menu" );

	if ( ! products.hasClass( "open" ) ) {

		prodlink.click( function( event ) {

			event.preventDefault();

			prodsub.slideToggle(250);
			products.toggleClass( "open" );

		});

	} // if

	/**
	 * Remove the style attribute on the laptop.
	 *
	 * Bug from using slideToggle above. When the Dealers menu has been
	 * toggled and one increases the browser width to view the laptop
	 * view, the "display:none" style is still applied and the dealers
	 * submenu wouldn't appear. This removes the display style so it will
	 * appear on hover as expected.
	 */
	enquire.register("screen and (min-width: 1024px)", {
		match : function() {
			dealsub.attr( "style", "" );
			prodsub.attr( "style", "" );
		}
	});

} )( jQuery );