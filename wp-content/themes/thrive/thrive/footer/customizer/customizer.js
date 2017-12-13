( function( $ ) {

	"use strict";
	//Footer Color.
	wp.customize( 'thrive_footer_color', function( value ) {
		value.bind( function( color ) {
			$('#thrive_footer').css('color', color );
		} );
	});

	//Footer Links Color.
	wp.customize( 'thrive_footer_links', function( value ) {
		value.bind( function( color ) {
			$('#thrive_footer a').css('color', color );
		} );
	});

	//Footer Background.
	wp.customize( 'thrive_footer_background', function( value ) {
		value.bind( function( color ) {
			$('#thrive_footer').css('background', color );
		});
	});

	//Footer Copyright.
	wp.customize( 'thrive_footer_copyright', function( value ) {
		value.bind( function( html ){
			$('#thrive_footer_copytext').html( html );
		});
	});

	// Footer Widget Color
	wp.customize( 'thrive_footer_widget_color', function(value) {
		value.bind(function(color) {
			$('#thrive_footer_widget, #thrive_footer_widget .widget-title').css({
				'color': color
			});
		});
	});

	// Footer Widget Background
	wp.customize( 'thrive_footer_widget_background', function(value) {
		value.bind(function(color) {
			$('#thrive_footer_widget').css({
				'background': color
			});
		});
	});

	// Footer Widget Links Color
	var new_color = {
		value: ''
	};
	wp.customize( 'thrive_footer_widget_color_link', function(value) {
		value.bind(function(color) {
			$('#thrive_footer_widget a').css({
				'color': color
			});
			new_color.value = color;
		});
	});

	// Footer Widget Links Color Hover

	wp.customize( 'thrive_footer_widget_color_hover', function(value) {
		value.bind(function(color) {
			$('#thrive_footer_widget a').on('mouseenter', function(){
				$(this).css({
					'color': color
				});

			}).on('mouseout', function(){
				var default_color = {'color': ''};
				if ( new_color.value.length !== 0 ){
					$(this).css({'color': new_color.value});

				} else {
					$(this).css(default_color);
				}

			});
		});
	});

})( jQuery );
