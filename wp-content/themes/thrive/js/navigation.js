/**
 * navigation.js
 *
 * Handles navigation menu behaviour
 */

jQuery( document ).ready( function($) {

	'use strict';

	// 1 Column layout search.
	$( '#thrive-2-columns-search' ).click( function(e){
		e.preventDefault();
			$('#thrive-secondary-menu').toggleClass( 'hide' );
	});

	// Mobile Navigation Event Manager
	$('#mobile-menu a').click(function(e){

		e.preventDefault();

		$('#site-navigation-container').removeClass('inactive-menu');
		$('#site-navigation-container').addClass('active-menu');

		$('#site-navigation').removeClass('inactive');
		$('#site-navigation').addClass('active');

		return;

	});

	// Mobile Search
	$( '#thrive-mobile-search-btn' ).click( function(e){
		e.preventDefault();
			$( '#thrive-mobile-search-btn' ).toggleClass( 'active' );
			$( '#thrive-secondary-menu-search' ).toggleClass( 'active' );
	});


	$('#desktop-menu').prepend("<div id='mobile-close-btn'></div>");

	$('#mobile-close-btn').on('click', function(){
		$('#site-navigation').removeClass('active');
		$('#site-navigation').addClass('inactive');
			$('#site-navigation-container').addClass('inactive-menu');
			$('#site-navigation-container').removeClass('active-menu');
	});

		$(document).mouseup(function(e){
			var container = $("#site-navigation");
		    if (container.is(e.target) // if the target of the click isn't the container...
		        && container.has(e.target).length === 0) // ... nor a descendant of the container
		    {
		      	$('#site-navigation').removeClass('active');
				$('#site-navigation').addClass('inactive');
				$('#site-navigation-container').addClass('inactive-menu');
				$('#site-navigation-container').removeClass('active-menu');
		    }
		});

		$(document).keyup(function(e) {
		  	if (e.keyCode == 27) {
		  		// remove menu
		  		$('#site-navigation').removeClass('active');
				$('#site-navigation').addClass('inactive');
				$('#site-navigation-container').addClass('inactive-menu');
				$('#site-navigation-container').removeClass('active-menu');
		  	}   // escape key maps to keycode `27`
		});

	// Sidenav Navigation Event Manager
	$('#sidenav-menu').click(function(e){

		e.preventDefault();

		$('#page-sidenav').addClass('active').css({
			height: jQuery(document).height() + 'px'
		});


	});

	$(document).mouseup(function(e){
		var container = $("#page-sidenav");
	    if (container.is(e.target) // if the target of the click isn't the container...
	        && container.has(e.target).length === 0) // ... nor a descendant of the container
	    {
	      	$('#page-sidenav').removeClass('active');
			$('#page-sidenav').addClass('inactive');

				$('#site-navigation-container').addClass('inactive-menu');
				$('#site-navigation-container').removeClass('active-menu');
	    }
	});

	$(document).keyup(function(e) {
	  	if (e.keyCode == 27) {
	  		// remove menu
	  		$('#page-sidenav').removeClass('active');
			$('#page-sidenav').addClass('inactive');
	  	}   // escape key maps to keycode `27`
	});

	nano_scroll();

	$( window ).resize( nano_scroll );

	function nano_scroll() {

		var gutter = 170;

		if ( $('#page-sidebar-user-logged-out').length >= 1 ) {
			gutter = 132.5;
		}

		$('#user-content-widget-sidenav').css({
			height: $(window).height() - gutter
		});

		$(".nano").nanoScroller();
	}

});
