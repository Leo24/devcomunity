( function( $ ) {

	"use strict";

	// Height
	wp.customize( 'thrive_branding_height', function( value ) {
		value.bind( function( height ) {
			$('#site-branding').css('height', height+'px');
			$('#thrive_nav').css('height', height+'px');
		} );
	} );

	// Logo Background
	wp.customize( 'thrive_logo_background', function( value ) {
		value.bind( function( color ) {
			$('#site-branding').css('background-color', color);
		} );
	} );

	// Menu Background
	wp.customize( 'thrive_header_menu_background', function( value ) {
		value.bind( function( color ) {
			$('#thrive_nav').css('background-color', color );
		} );
	} );

})(jQuery);
