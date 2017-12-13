jQuery(document).ready(function($){
	"use strict";
	/**
	 * Places to footer at the bottom of the screen
	 * @return void
	 */
	var thrivePlaceFooter = function() {

		return;

		var pagecontent_height = parseInt($('#content').height());
		var wpadminbar_height = parseInt($('#wpadminbar').height());
		var document_height = parseInt($(window).height());
		var footer_height = parseInt($('#thrive_footer').height());
		var nav_height = parseInt($('#masthead').height());
		var footer_widget_height = parseInt($('#thrive_footer_widget').height());
		var page_height = document_height - wpadminbar_height;

		var content_height = page_height - footer_height - nav_height - footer_widget_height;

		$('#page').css({
			'min-height': content_height + 'px'
		});

		$('#content').css({
			'min-height': content_height + 'px'
		});

		return;
	}

	/**
	 * Start running the theme scripts
	 */
	thrivePlaceFooter();

	$(window).resize(function(){
		thrivePlaceFooter();
	});

	$('textarea').autogrow({
		animate: false
	}).focus( function(){
		// Fix the bug which causes the textarea to return to 
		// its original size when focus out and focus in
        $( this ).stop().slideDown();
    });

	$('#bp-menu-notifications-dropdown').click(function(e){
		e.preventDefault();
		$('.bp-thrive-dropdown-menu').toggleClass('active');
	});

	// fix all duplicate tags
	var duplicateChk = {};

	$('#dashboard-widgets').imagesLoaded( function(){
		$('#dashboard-widgets').masonry({
			itemSelector: '.widget',
		});
	});

	$('#ul.rtmedia-list').imagesLoaded( function(){
		$('ul.rtmedia-list').masonry({
			itemSelector: '.rtmedia-list-item',
		});
	});

	/**
	 * Couses Masonry
	 */
	/*var $thrive_ld_courses = $('.thrive-ld-course');

		if ( $thrive_ld_courses.length >= 1 ) {

			$thrive_ld_courses.wrapAll("<div class='thrive-ld-courses-wrapper'>");

			var $thrive_ld_courses_wrapper = $('.thrive-ld-courses-wrapper');

				$thrive_ld_courses_wrapper.imagesLoaded( function() {
					$thrive_ld_courses_wrapper.masonry({
						itemSelector: '.thrive-ld-course'
					});
				});
		}*/
	var $ld_courses_wrappers = $(".thrive-ld-courses-wrapper");

	$.each( $ld_courses_wrappers, function(){

		// Fetch all the children element inside the main wrapper added in filter
		// using add_filter('ld_course_list', 'thrive_fix_ld_container_issue') in extras.php.
		var $categorized_courses = $(this).children('.thrive-ld-course');

			// Wrap all the inner childs so that we could
			// assign a masonry object to each of them
			$categorized_courses.wrapAll("<div class='thrive-ld-courses-category-wrapper'>");

			// Assign the container to variable that we will be used to initiate masonry later.
			var $categorized_courses_wrap = $('.thrive-ld-courses-category-wrapper');

			// Finally, initiate a masonry object.
			$.each( $categorized_courses_wrap, function(){

				var that = $(this);

				that.imagesLoaded( function() {
					setInterval(function(){
						that.masonry({
							itemSelector: '.thrive-ld-course'
						});
					}, 500);
				});
			});
		return;

	});

	/**
	 * Support Gears
	 */
	 if ( $('.gears-carousel-standard').length >= 1 ) {

	 	var $thrive_carousel_standard = $('.gears-carousel-standard');

	 	$.each( $thrive_carousel_standard, function() {

	 		var __this = $(this);
	 		var max_slides  = (__this.attr('data-max-slides') !== undefined && __this.attr('data-max-slides').length >= 1) ? __this.attr('data-max-slides') : 7;
	 		var min_slides  = (__this.attr('data-min-slides') !== undefined && __this.attr('data-min-slides').length >= 1) ? __this.attr('data-min-slides') : 1;
	 		var slide_width = (__this.attr('data-item-width') !== undefined && __this.attr('data-item-width').length >= 1) ? __this.attr('data-item-width') : 85;

	 		var prop = {
	 			minSlides: parseInt(min_slides),
	 			maxSlides: parseInt(max_slides),
	 			slideWidth: parseInt(slide_width),
	 			nextText: '<i class="material-icons">keyboard_arrow_right</i>',
	 			prevText: '<i class="material-icons">keyboard_arrow_left</i>',
	 			pager: false,
	 			moveSlides: 3,
	 			slideMargin: 20
	 		};

	 		__this.bxSlider(prop);

	 		$('.gears-carousel-standard').css({
	 			'opacity': '1'
	 		});
	 	});

	 	//return;
	}

	$('#page-sidebar-toggle').click(function(e){
		e.preventDefault();
		$('#thrive-global-wrapper').toggleClass('toggled');
	});

	$('#toggle-add').click(function(e){
		e.preventDefault();
		$('#thrive-global-wrapper').toggleClass('toggled');
	});

	// Thrive Wisechat Support.
	if ( $('#thrive-wisechat-support-close-btn') ) {

		$('#thrive-wisechat-support-close-btn i.material-icons').on( 'click', function() {
			$('#thrive-wisechat-support').addClass('inactive');
		});

		$('#thrive-chat-label').on('click', function(){
			$('#thrive-wisechat-support').removeClass('inactive');
		});
	}

	// Side Navigation
	$.each( $('#page-sidebar-menu li.menu-item-has-children > a'), function(){
		$(this).append('<span class="toggle material-icons">arrow_drop_down</span>');
	});

	var $sidenav_toggle = $('#page-sidebar-menu li.menu-item-has-children > a > .toggle');

		$sidenav_toggle.click(function(e){

			e.preventDefault();

			var $toggle = $( this );

			// Change icon.
			if ( $toggle.text().trim() === 'arrow_drop_down' )
			{

				$toggle.text('arrow_drop_up');

			} else {

				$toggle.text('arrow_drop_down');

			}

			// Toggle Menu.
			var $sub_menu = $( '> .sub-menu', $(this).parent().parent() );

				if ( $sub_menu.hasClass('active') ) {
					$sub_menu.removeClass('active');
				} else {
					$( $sub_menu ).addClass('active');
				}
		});

	/**
	 * Fix Dashboard Issue
	 */
	$('#toggle-add').on('click', function(e){
        dunhakdis_thrive_fix_masonry_issue(e);
    });

    $('#page-sidebar-toggle').on('click', function(e){
        dunhakdis_thrive_fix_masonry_issue(e);
    });

    var dunhakdis_thrive_fix_masonry_issue = function(e) {
        e.preventDefault();
        setTimeout(function(){
            $('#dashboard-widgets').imagesLoaded( function(){
                $('#dashboard-widgets').masonry({
                    itemSelector: '.widget',
                });
            });
        }, 500);
    }

		/**
		 * Thrive Register
		 */
		 $('.thrive-register-fields-xprofile input').on('focus', function(){
			 $(this).parent().addClass('active');
			 $(this).parent().find('>label').addClass('primary');
		 }).on('blur',function(){
			 if ( $(this).val().length == 0 ) {
			 	$(this).parent().removeClass('active');
			 }
			 	$(this).parent().find('>label').removeClass('primary');
		 });

		 $(document).on('change', '.thrive-register-fields-xprofile input', function() {
			 $(this).parent().addClass('active');
  		   	 $(this).parent().find('>label').addClass('primary');
		 });

		 $(window).load(function(){
			 $.each( $('.thrive-register-fields-xprofile input'), function(){
				 if ( $(this).val().length !== 0 ) {
				 	$(this).parent().addClass('active');
				 }
			 });
		 });

    if ($('.entry-content').find('.wcContainer').length != 0) {
        $('#thrive-wisechat-support').addClass('has-wise-chat');
    } else {
        $('#thrive-wisechat-support').removeClass('has-wise-chat');
    }

    if ($('#thrive-global-wrapper').find('#thrive-wisechat-support.fb-mode-enabled').length != 0) {
        var device_width = $( window ).width();

        if ( device_width <= 768 ) {
            $('#thrive-wisechat-support.fb-mode-enabled .wcContainer > .wcWindowTitle:first-of-type').addClass('inactive');
        }

        $('#thrive-wisechat-support.fb-mode-enabled .wcContainer > .wcWindowTitle:first-of-type .wcWindowTitleMinMaxLink:not(.wcWindowTitleMinimized)').click(function(e){
            e.preventDefault();
            var $button = $( this );
            var device_width = $( window ).width();
            if ( device_width <= 768 ) {
                if ( $button.parent().hasClass('inactive') ) {
                    $button.parent().removeClass('inactive');
                } else {
                    $button.parent().addClass('inactive');
                }
            }
        });
    }

});
