( function( $ ) {

	"use strict";

	//Background.
	wp.customize( 'thrive_sidebar_widgets_background', function( value ) {
		value.bind( function( color ) {
			$('.sidebar-widgets').css({
				background: color
			})
		});
	});

	//Color.
	wp.customize( 'thrive_sidebar_color', function( value ) {
		value.bind( function( color ) {
			$('.sidebar-widgets').css({
				color: color
			})
		});
	});

	// Links
	wp.customize( 'thrive_sidebar_links_color', function( value ) {
		value.bind( function( color ) {
			$('.site-content .sidebar-widgets a').css({
				color: color
			})
		});
	});

	// Outline.
	wp.customize( 'thrive_widgets_outline', function( value ) {
		value.bind( function( $theme_mod_outline ) {

			var $outline = '';
			var $border  = '';

			if ( $theme_mod_outline === 'solid-border' ) {
				$outline = "none"; //$dark_text
				$border  = "1px solid rgba(0, 0, 0, 0.12)";
			}
			
			if ( $theme_mod_outline === 'no-outline' ) {
				$outline = "none;";
				$border  = "none";
			}

			if ( $theme_mod_outline.length >= 1 ) {
				$('.sidebar-widgets').css({
					'box-shadow': $outline,
					'border': $border
				});
			}
		});
	});

})(jQuery);