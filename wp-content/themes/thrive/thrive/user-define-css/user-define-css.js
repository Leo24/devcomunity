(function( $ ) {

	"use strict";

	setTimeout( function(){

		$('head').append("<style id='thrivePreviewStyle'></style>");

	}, 1000 );
	
	wp.customize( 'thrive_user_define_css', function( value ) {

		value.bind( function( to ) {

			var css = to;
			
			$('#thrivePreviewStyle').html( css );
		});

	} );

})(jQuery);