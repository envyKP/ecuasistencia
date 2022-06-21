// JavaScript Document



	/*----------------------------------------------------*/
	/*	Preloader
	/*----------------------------------------------------*/
	
	$(window).load(function() {
	
		"use strict";	
	
		$(".loader").delay(100).fadeOut();
		$(".animationload").delay(100).fadeOut("fast");

	});
	


	$(window).load(function(){
	
		"use strict";	
	
		$(window).stellar({});

	});
	
	
	
	/*----------------------------------------------------*/
	/*	Scroll Navbar
	/*----------------------------------------------------*/
	
	$(window).scroll(function(){	

		"use strict";	
	
		var b = $(window).scrollTop();
		
		if( b > 200 ){		
			//$(".navbar.navbar-fixed-top").addClass("scroll-fixed-navbar");
		} else {
			//$(".navbar.navbar-fixed-top").removeClass("scroll-fixed-navbar");
		}
		
	});	
	
	
	/*----------------------------------------------------*/
	/*	OnScroll Animation
	/*----------------------------------------------------*/
	
	$(document).ready(function(){
	
		"use strict";
	
    	$('.animated').appear(function() {

	        var elem = $(this);
	        var animation = elem.data('animation');

	        if ( !elem.hasClass('visible') ) {
	        	var animationDelay = elem.data('animation-delay');
	            if ( animationDelay ) {
	                setTimeout(function(){
	                    elem.addClass( animation + " visible" );
	                }, animationDelay);

	            } else {
	                elem.addClass( animation + " visible" );
	            }
	        }
	    });
	
	});
	
	
	
	/*----------------------------------------------------*/
	/*	Parallax
	/*----------------------------------------------------*/
	
	$(window).bind('load', function() {
	
		"use strict";	
		parallaxInit();
		
	});

	function parallaxInit() {
		if( !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			$('#intro').parallax("30%", 0.3);
			$('#skills').parallax("30%", 0.3);
			$('#features').parallax("30%", 0.3);
			$('#statistic_banner').parallax("30%", 0.3);
			$('#promo_line').parallax("30%", 0.3);		
		}	
	}

	$(document).ready(function(){

		'use strict';

		$.scrollUp = function (options) {

			// Defaults
			var defaults = {
				scrollName: 'scrollUp', // Element ID
				topDistance: 600, // Distance from top before showing element (px)
				topSpeed: 800, // Speed back to top (ms)
				animation: 'fade', // Fade, slide, none
				animationInSpeed: 200, // Animation in speed (ms)
				animationOutSpeed: 200, // Animation out speed (ms)
				scrollText: '', // Text for element
				scrollImg: false, // Set true to use image
				activeOverlay: false // Set CSS color to display scrollUp active point, e.g '#00FFFF'
			};

			var o = $.extend({}, defaults, options),
				scrollId = '#' + o.scrollName;

			// Create element
			$('<a/>', {
				id: o.scrollName,
				href: '#top',
				title: o.scrollText
			}).appendTo('body');
			
			// If not using an image display text
			if (!o.scrollImg) {
				$(scrollId).text(o.scrollText);
			}

			// Minium CSS to make the magic happen
			$(scrollId).css({'display':'none','position': 'fixed','z-index': '2147483647'});

			// Active point overlay
			if (o.activeOverlay) {
				$("body").append("<div id='"+ o.scrollName +"-active'></div>");
				$(scrollId+"-active").css({ 'position': 'absolute', 'top': o.topDistance+'px', 'width': '100%', 'border-top': '1px dotted '+o.activeOverlay, 'z-index': '2147483647' });
			}

			// Scroll function
			$(window).scroll(function(){	
				switch (o.animation) {
					case "fade":
						$( ($(window).scrollTop() > o.topDistance) ? $(scrollId).fadeIn(o.animationInSpeed) : $(scrollId).fadeOut(o.animationOutSpeed) );
						break;
					case "slide":
						$( ($(window).scrollTop() > o.topDistance) ? $(scrollId).slideDown(o.animationInSpeed) : $(scrollId).slideUp(o.animationOutSpeed) );
						break;
					default:
						$( ($(window).scrollTop() > o.topDistance) ? $(scrollId).show(0) : $(scrollId).hide(0) );
				}
			});

			// To the top
			$(scrollId).click( function(event) {
				$('html, body').animate({scrollTop:0}, o.topSpeed);
				event.preventDefault();
			});

		};
		
		$.scrollUp();

	});
	
	
	
	/*----------------------------------------------------*/
	/*	Current Menu Item
	/*----------------------------------------------------*/
	
	$(document).ready(function() {
		
		//Bootstraping variable
		headerWrapper		= parseInt($('#navigation-menu').height());
		offsetTolerance	= 300;
		
		//Detecting user's scroll
		$(window).scroll(function() {
		
			//Check scroll position
			scrollPosition	= parseInt($(this).scrollTop());
			
			//Move trough each menu and check its position with scroll position then add selected-nav class
			$('.navbar-nav > li > a').each(function() {

				thisHref				= $(this).attr('href');
				thisTruePosition	= parseInt($(thisHref).offset().top);
				thisPosition 		= thisTruePosition - headerWrapper - offsetTolerance;
				
				if(scrollPosition >= thisPosition) {
					
					$('.selected-nav').removeClass('selected-nav');
					$('.navbar-nav > li > a[href='+ thisHref +']').addClass('selected-nav');
					
				}
			});
			
			
			//If we're at the bottom of the page, move pointer to the last section
			bottomPage	= parseInt($(document).height()) - parseInt($(window).height());
			
			if(scrollPosition == bottomPage || scrollPosition >= bottomPage) {
			
				$('.selected-nav').removeClass('selected-nav');
				$('navbar-nav > li > a:last').addClass('selected-nav');
			}
		});
		
	});
	
	 
	$(document).ready(function(){


		"use strict";
		$.fn.scrollTo = function( options ) {

			var settings = {
				offset : -60,       //an integer allowing you to offset the position by a certain number of pixels. Can be negative or positive
				speed : 'slow',   //speed at which the scroll animates
				override : null,  //if you want to override the default way this plugin works, pass in the ID of the element you want to scroll through here
				easing : null //easing equation for the animation. Supports easing plugin as well (http://gsgd.co.uk/sandbox/jquery/easing/)
			};

			if (options) {
				if(options.override){
					//if they choose to override, make sure the hash is there
					options.override = (override('#') != -1)? options.override:'#' + options.override;
				}
				$.extend( settings, options );
			}

			return this.each(function(i, el){
				$(el).click(function(e){
					var idToLookAt;
					if ($(el).attr('href').match(/#/) !== null) {
						e.preventDefault();
						idToLookAt = (settings.override)? settings.override:$(el).attr('href');//see if the user is forcing an ID they want to use
						//if the browser supports it, we push the hash into the pushState for better linking later
						if(history.pushState){
							history.pushState(null, null, idToLookAt);
							$('html,body').stop().animate({scrollTop: $(idToLookAt).offset().top + settings.offset}, settings.speed, settings.easing);
						}else{
							//if the browser doesn't support pushState, we set the hash after the animation, which may cause issues if you use offset
							$('html,body').stop().animate({scrollTop: $(idToLookAt).offset().top + settings.offset}, settings.speed, settings.easing,function(e){
								//set the hash of the window for better linking
								window.location.hash = idToLookAt;
							});
						}
					}
				});
			});
		};
		  
		$('#GoToHome, #GoToAbout, #GoToFeatures, #GoToWorks, #GoToTeam, #GoToPricing, #GoToBlog, #GoToContacts' ).scrollTo({ speed: 1400 });

	});
	
	
	
	/*----------------------------------------------------*/
	/*	Circle Progress Bars
	/*----------------------------------------------------*/
	
	$(window).scroll(function() {
	
		"use strict";

		if ($().easyPieChart) {
			var count = 0 ;
			var colors = ['#ffc400'];
			$('.percentage').each(function(){

					
				var imagePos = $(this).offset().top;
				var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+600) {

					$(this).easyPieChart({
						barColor: colors[count],
						trackColor: '#202020',
						scaleColor: false,
						scaleLength: false,
						lineCap: 'butt',
						lineWidth: 8,
						size: 130,
						rotate: 0,
						animate: 2000,
						onStep: function(from, to, percent) {
								$(this.el).find('.percent').text(Math.round(percent));
							}
					});
				}

				count++;
				if (count >= colors.length) { count = 0};
			});
		}

	});

	
	
	/*----------------------------------------------------*/
	/*	Statistic Counter
	/*----------------------------------------------------*/
	
	$(document).ready(function($) {
	
		"use strict";
	
		$('.statistic-block').each(function() {
			$(this).appear(function() {
				var $endNum = parseInt($(this).find('.statistic-number').text());
				$(this).find('.statistic-number').countTo({
					from: 0,
					to: $endNum,
					speed: 3000,
					refreshInterval: 30,
				});
			},{accX: 0, accY: 0});
		});

	});
	
	

	
	/*----------------------------------------------------*/
	/*	Portfolio Lightbox
	/*----------------------------------------------------*/
	
	$(document).ready(function(){
	
		"use strict";
		
		$("a[class^='prettyPhoto']").prettyPhoto();

	});
	
	
	
	/*----------------------------------------------------*/
	/*	Filterable Portfolio
	/*----------------------------------------------------*/

	$(document).ready(function(){
		
		
		$("#id_submit").click(function() {
			var txt_campana = document.getElementById("txt_campana").value;
			var txt_first_name = document.getElementById("txt_first_name").value;
			var txt_last_name = document.getElementById("txt_last_name").value;
			var txt_telefono = document.getElementById("txt_telefono").value;

			alert('va a grabar');
			var parametros = {
			    "txt_campana" : txt_campana,
			  	"txt_first_name" : txt_first_name,
			  	"txt_last_name" : txt_last_name,
			  	"txt_telefono" : txt_telefono
			};					
			$.ajax({
					data:  parametros,
					url:   'grabar_contacto.php',
					type:  'post',
					success:  function (response_grabar) { 
						var pos_ok = response_grabar.indexOf("OK");
						if ( pos_ok >= 0 ){
							alert('grabo ok');
						}
						else{
							alert('ERROR al grabar');
						}
						
					}

			}); 	
			
			

		});


	});
	

	
	function valid_first_name(txt_first_name) {
		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
		return pattern.test(txt_first_name);		
	}

	function valid_last_name(txt_last_name) {
		var pattern = new RegExp(/^[+a-zA-Z0-9._-]/i);
		return pattern.test(txt_last_name);		
	}
	
	function valid_telefono(txt_telefono) {
		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
		return pattern.test(email);		
	}

	