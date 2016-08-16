/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );

	wp.customize( 'home_tech_header', function( value ) {
		value.bind( function( to ) {
			$( '#home-tech-header' ).text( to );
		} );
	} );

	wp.customize( 'home_news_header', function( value ) {
		value.bind( function( to ) {
			$( '#home-news-header' ).text( to );
		} );
	} );

	wp.customize( 'category_description_header', function( value ) {
		value.bind( function( to ) {
			$( '.header-desc' ).text( to );
		} );
	} );

	wp.customize( 'category_docs_header', function( value ) {
		value.bind( function( to ) {
			$( '.header-docs' ).text( to );
		} );
	} );



	wp.customize( 'promo_box_1_text', function( value ) {
		value.bind( function( to ) {
			$( '#promo-box-1-text' ).text( to );
		} );
	} );

	wp.customize( 'promo_box_1_logo', function( value ) {
		value.bind( function( to ) {
			$( '#promo-box-1-logo' ).src( to );
		} );
	});

	wp.customize( 'promo_box_1_bg', function( value ) {
		value.bind( function( to ) {
			$( '#promo-box-1:before' ).css( 'background-image', 'url( ' + to + ')' );
		} );
	});




	wp.customize( 'promo_box_2_text', function( value ) {
		value.bind( function( to ) {
			$( '#promo-box-2-text' ).text( to );
		} );
	} );

	wp.customize( 'promo_box_2_logo', function( value ) {
		value.bind( function( to ) {
			$( '#promo-box-2-logo' ).src( to );
		} );
	});

	wp.customize( 'promo_box_2_bg', function( value ) {
		value.bind( function( to ) {
			$( '#promo-box-2:before' ).css( 'background-image', 'url( ' + to + ')' );
		} );
	});




	wp.customize( 'promo_box_3_text', function( value ) {
		value.bind( function( to ) {
			$( '#promo-box-3-text' ).text( to );
		} );
	} );

	wp.customize( 'promo_box_3_logo', function( value ) {
		value.bind( function( to ) {
			$( '#promo-box-3-logo' ).src( to );
		} );
	});

	wp.customize( 'promo_box_3_bg', function( value ) {
		value.bind( function( to ) {
			$( '#promo-box-3:before' ).css( 'background-image', 'url( ' + to + ')' );
		} );
	});




	/*wp.customize( 'text_field', function( value ) {
		value.bind( function( to ) {
			$( '.entry-title' ).text( to );
		} );
	} );

	// Doesn't work instantly, works after you go out of the field
	wp.customize( 'url_field', function( value ) {
		value.bind( function( to ) {
			$( '.entry-title a' ).attr( 'href', to );
		} );
	} );

	// Doesn't work instantly, works after you go out of the field
	wp.customize( 'email_field', function( value ) {
		value.bind( function( to ) {
			$( '.entry-title' ).text( to );
			//$( '.entry-title a' ).attr( 'href', 'mailto:'+to );
		} );
	} );

	wp.customize( 'date_field', function( value ) {
		value.bind( function( to ) {
			$( '.entry-date' ).text( to );
		} );
	} );

	wp.customize( 'checkbox_field', function( value ) {
		value.bind( function( to ) {
			$( '.entry-date' ).style.display( 'none' );
			if ( to ) {

			}
		} );
	} );

	wp.customize( 'color_field', function( value ) {
		value.bind( function( to ) {
			$( '.color_field' ).css( {
				'color': to,
			} );
		} );
	} );

	wp.customize( 'image_field', function( value ) {
		value.bind( function( to ) {
			$( '.image_field' ).css( {
				'color': to,
			} );
		} );
	} );
*/
} )( jQuery );
