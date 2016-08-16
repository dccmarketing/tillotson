/**
 * Collapses and expands submenus based on the class "collapsible".
 * When the screen is less than 1023 pixels wide, these menus items
 * expand to dispay the submenu. At 1024 pixels or wider, they are clickable links.
 */

( function( $ ) {

	var parent = $( '.main-navigation .collapsible' );
	var link = parent.children( 'a' );
	var submenu = parent.children( '.sub-menu' );

	enquire.register( 'screen and (max-width: 1023px)', {
		match : function() {
			if ( ! parent.hasClass( 'open' ) ) {
				link.on( 'click', function( event ) {

					event.preventDefault();

					$(this).next( '.sub-menu' ).slideToggle(250);
					$(this).parent().toggleClass( 'open' );

				});
			}
		},
		unmatch: function() {
			submenu.attr( 'style', '' );
			link.off( 'click' );
		}
	});

} )( jQuery );
