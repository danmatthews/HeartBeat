/*
Center - jQuery Plugin

Use:
================================================================================
	* Both vertical and horizontal centering are on by default.
	* Recenter on window resize is on by default.

	// centers vertically and horizontally and reacts to window resize event.
	$('#someElement').center(); 
	
	
	// vertically centers and reacts to window resize.
	$('#someElement').center({
		vertical:true,
		horizontal:false,
		resize:true
	});
	
Source:
================================================================================
http://github.com/chriscummings/jquery-center-plugin

*/

'use strict';

(function ($) {	
	$.fn.extend({ 
		center: function (options) {
			var defaults,
				getYCenter,
				getXCenter,
				getElementYCenter,
				getElementXCenter,
				position;
			
			
			defaults = {
				horizontal: true,
				vertical: true,
				resize : true
			};
							
			options =  $.extend(defaults, options);

			getYCenter = function () {
				return $(window).height() / 2;
			};
			
			getXCenter = function () {
				return $(window).width() / 2;
			};
			
			getElementYCenter = function (element) {
				return (element.outerHeight() / 2);
			}; 
			
			getElementXCenter = function (element) {				
				return (element.outerWidth() / 2);
			};
			
			position = function (element, options) {				
				if (options.horizontal) {
					$(element).css({
						'left': (getXCenter() - getElementXCenter(element))
					});
				}
				if (options.vertical) {
					$(element).css({
						'top': (getYCenter() - getElementYCenter(element))
					});	
				}
			};

			return this.each(function () {
				var element = $(this);
				
				$(element).css({'position': 'absolute'});				
				
				position(element, options);
	
				if (options.resize) {
					$(window).resize(function () {
							
						setTimeout(function () {
							position(element, options);
						}, 100);
						
					});					
				}
			});
		}
	});
})(jQuery);