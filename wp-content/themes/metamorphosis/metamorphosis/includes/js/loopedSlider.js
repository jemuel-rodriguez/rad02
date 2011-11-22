/*
 * 	loopedSlider - jQuery plugin
 *	written by Nathan Searles	
 *	http://code.google.com/p/loopedslider/
 *
 *	Copyright (c) 2009 Nathan Searles (http://nathansearles.com/loopedslider/)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */
(function(jQuery){
 	jQuery.fn.extend({ 
 		loopedSlider: function(options) {
    		return this.each(function() {

				// set defaults
				var defaults = {
					container : 'container',
					slideClass : 'slide',
					pagination : 'pagination',
					navButtons : 'nav-buttons', 
					fadeSpeed : 400,
					slideSpeed : 250,
					animateSpeed : 200,
					autoHeight : true,
					padding : 20,
					easing : 'easeOutQuad'
				};

				// set variables	
				var obj = jQuery(this);
				var o = jQuery.extend(defaults, options);
				var u = false;
				var w = obj.width(); 
				var h = obj.height();
				var f = jQuery('.'+o.container, obj).find('div.slide:first').attr('id');
                var l = jQuery('.'+o.container, obj).find('div.slide:last').attr('id');           
				
				// funcitons
				function setToActive(c) {
					var current = jQuery(c).attr('id');
					jQuery('a[href$="'+current+'"]', obj).addClass('active');
				}
				
				// applies style to divs
                jQuery('.'+o.container, obj).find('div').css({ 'z-index': 0, opacity: 0 });
				jQuery('.'+o.container, obj).find('div div').attr('style','');
				
				// load first slide
				jQuery('.'+o.container, obj).find('div:eq(0)').animate({ opacity: 1.0 }, o.fadeSpeed, function() {						
					jQuery(this).css({ 'z-index': 100 });				
					jQuery(this).addClass('current');
					if (o.autoHeight===true) {
						// gets height of new slide
						var newHeight = jQuery(this, obj).height() + o.padding;
						jQuery('.'+o.container, obj).animate({'height': newHeight}, o.animateSpeed, o.easing);
					}
					setToActive(this);
				});		

				// fade code
				jQuery('.'+o.pagination, obj).find('a').click(function(){
					if(u===false  && (jQuery(this).hasClass('active')===false)) {
						u = true;
						// removes active
						jQuery('a', obj).removeClass('active');

						// fades out current slide
						jQuery('.'+o.container, obj).find('div').animate({ opacity: 0 }, o.fadeSpeed, function() {					
							jQuery(this).removeClass('current');
							jQuery(this).css({ 'z-index': 0 });				
						});

						// setsup value for new slide
						var x = 0;
						var parentId = jQuery(this).attr('href');
						var parentSplit = parentId.split('-');
						x = ((parentSplit[1]*1));
						
						if (o.autoHeight===true) {
							// gets height of new slide
							var newHeight = jQuery('#'+o.slideClass+'-'+(x), obj).height() + o.padding;
							jQuery('.'+o.container, obj).animate({'height': newHeight}, o.animateSpeed, o.easing);
						}
						
						// fades in new slide
						jQuery('#'+o.slideClass+'-'+(x), obj).animate({ opacity: 1.0 }, o.fadeSpeed, function() {
							jQuery(this).css({ 'z-index': 100 });
							jQuery(this).addClass('current');
							u = false;
							setToActive(this);		
						});
					}
					return false;
				});

				// slide code
				jQuery('.'+o.navButtons, obj).find('a').click(function(){
					if(u===false) {
						u = true;
						var loop = false;
						var fLoop = f;
						var lLoop = l;

						// removes active state
						jQuery('a', obj).removeClass('active');

						// flips directions
						if (jQuery(this).hasClass('next')) {
							var nextD = -w;
							var previousD = w;
							var direction = +1;
						}
						if (jQuery(this).hasClass('previous')) {
							nextD = w;
							previousD = -w;
							direction = -1;
						}

						// setup the loop
						if (jQuery('#'+fLoop, obj).hasClass('current')) {
							loop = 'first';
						}
						if ((jQuery('#'+lLoop, obj).hasClass('current'))) {
							loop = 'last';
						}

						// get the name of the new slide
						if ((loop==='first') && (jQuery(this).hasClass('previous'))) {
							lLoop = lLoop.split('-');
							x = ((lLoop[1]*1));
						} else if ((loop==='last') && (jQuery(this).hasClass('next'))) {
							fLoop = fLoop.split('-');
							x = ((fLoop[1]*1));
						} else {
							// setsup value for new slide
							var getCurrent = jQuery('.'+o.container, obj).find('.current').attr('id');
							getCurrent = getCurrent.split('-');
							x = ((getCurrent[1]*1+direction));
						}

						// gets height of new slide
						if (o.autoHeight===true) {
							var newHeight = jQuery('#'+o.slideClass+'-'+(x), obj).height() + o.padding;
							jQuery('.'+o.container, obj).animate({'height': newHeight}, o.animateSpeed, o.easing);
						}
						
						// sets next slide to slide in position		
						jQuery('#'+o.slideClass+'-'+(x), obj).css({ opacity: 1, left: previousD, 'z-index': 100 });
						
						// slides in new slide
						jQuery('#'+o.slideClass+'-'+(x), obj).animate({ left: 0 }, o.slideSpeed, o.easing, function() {
							jQuery(this).addClass('current');
							jQuery(this).css({ opacity: 1 });
							u = false;
							// Sets active state for pagination a
							setToActive(this);						
						});
						
						// slides out current slide
						jQuery('.'+o.container, obj).find('.current').animate({ 'left': nextD }, o.slideSpeed, o.easing, function() {					
							jQuery(this).removeClass('current');
							jQuery(this).css({ opacity: 0, left: 0, 'z-index': 0 });
						});
						
					}
				return false;
				});
			});
    	}
	});
})(jQuery);

jQuery(function(){
		jQuery('#loopedSlider').loopedSlider();
});     
