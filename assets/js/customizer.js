/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
 
( function( $ ) {
	// Intro background color
	wp.customize( 'intro_background_color', function( value ) {
	console.log('loaded');
		value.bind( function( to ) {
			$( '.site-header .entry' ).css( {
				'background': to
			} );
		} );
	} );
} )( jQuery );