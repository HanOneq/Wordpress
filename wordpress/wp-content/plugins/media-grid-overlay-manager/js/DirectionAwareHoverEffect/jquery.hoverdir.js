/**
 * jquery.hoverdir.js v1.1.0
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Codrops
 * LCweb tweaked to work with Overlay Manager add-on - March 2015
 * http://www.codrops.com - http://www.lcweb.it
 */
;( function( $, window, undefined ) {
	'use strict';

	$.lc_HoverDir = function( options, element ) {
		this.$el = $( element );
		this._init( options );
	};

	// the options
	$.lc_HoverDir.defaults = {
		speed : 400,
		easing : 'ease',
		hoverDelay : 0,
		inverse : false,
		overlaySelector: 'div',
		noTransitionClass : 'no_transition'
	};

	$.lc_HoverDir.prototype = {
		_supportsTransitions: function () { // avoid Modernizr integration - @LCweb
			var b = document.body || document.documentElement,
				s = b.style,
				p = 'transition';
		
			if (typeof s[p] == 'string') { return true; }
		
			// Tests for vendor specific prop
			var v = ['Moz', 'webkit', 'Webkit', 'Khtml', 'O', 'ms'];
			p = p.charAt(0).toUpperCase() + p.substr(1);
		
			for (var i=0; i<v.length; i++) {
				if (typeof s[v[i] + p] == 'string') { return true; }
			}
		
			return false;
		},
		_init : function( options ) {
			
			// options
			this.options = $.extend( true, {}, $.lc_HoverDir.defaults, options );
			// support for CSS transitions
			this.support = this._supportsTransitions();
			// load the events
			this._loadEvents();

		},
		_loadEvents : function() {

			var self = this;	
			self.$el.on('mouseenter.lc_hoverdir, mouseleave.lc_hoverdir', function( event ) {

				var $el = $(this),
					$hoverElem = $el.find( self.options.overlaySelector ),
					direction = self._getDir( $el, { x : event.pageX, y : event.pageY } ),
					styleCSS = self._getStyle( direction );
				
				if( event.type === 'mouseenter' ) {
					
					if(self.support) { // remove CSS3 transitions to apply initial state
						$hoverElem.addClass( self.options.noTransitionClass );	
					}
					$hoverElem.hide().css( styleCSS.from );
					clearTimeout( self.tmhover );

					self.tmhover = setTimeout( function() {
						
						if(self.support) { // restore CSS3 transitions
							$hoverElem.removeClass( self.options.noTransitionClass );	
						}
						
						$hoverElem.show( 0, function() {	
							var $el = $( this );
							self._applyAnimation( $el, styleCSS.to, self.options.speed );
						});
						
					
					}, self.options.hoverDelay );
					
				}
				else {
					clearTimeout( self.tmhover );
					self._applyAnimation( $hoverElem, styleCSS.from, self.options.speed );
					
				}
					
			} );

		},
		// credits : http://stackoverflow.com/a/3647634
		_getDir : function( $el, coordinates ) {
			
			// the width and height of the current div
			var w = $el.width(),
				h = $el.height(),

				// calculate the x and y to get an angle to the center of the div from that x and y.
				// gets the x value relative to the center of the DIV and "normalize" it
				x = ( coordinates.x - $el.offset().left - ( w/2 )) * ( w > h ? ( h/w ) : 1 ),
				y = ( coordinates.y - $el.offset().top  - ( h/2 )) * ( h > w ? ( w/h ) : 1 ),
			
				// the angle and the direction from where the mouse came in/went out clockwise (TRBL=0123);
				// first calculate the angle of the point,
				// add 180 deg to get rid of the negative values
				// divide by 90 to get the quadrant
				// add 3 and do a modulo by 4  to shift the quadrants to a proper clockwise TRBL (top/right/bottom/left) **/
				direction = Math.round( ( ( ( Math.atan2(y, x) * (180 / Math.PI) ) + 180 ) / 90 ) + 3 ) % 4;
			return direction;
			
		},
		_getStyle : function( direction ) {
			
			var fromStyle, toStyle,
				slideFromTop = { left : '0px', top : '-100%' },
				slideFromBottom = { left : '0px', top : '100%' },
				slideFromLeft = { left : '-100%', top : '0px' },
				slideFromRight = { left : '100%', top : '0px' },
				slideTop = { top : '0px' },
				slideLeft = { left : '0px' };
			
			switch( direction ) {
				case 0:
					// from top
					fromStyle = !this.options.inverse ? slideFromTop : slideFromBottom;
					toStyle = slideTop;
					break;
				case 1:
					// from right
					fromStyle = !this.options.inverse ? slideFromRight : slideFromLeft;
					toStyle = slideLeft;
					break;
				case 2:
					// from bottom
					fromStyle = !this.options.inverse ? slideFromBottom : slideFromTop;
					toStyle = slideTop;
					break;
				case 3:
					// from left
					fromStyle = !this.options.inverse ? slideFromLeft : slideFromRight;
					toStyle = slideLeft;
					break;
			};
			
			return { from : fromStyle, to : toStyle };
					
		},
		// apply a transition or fallback to jquery animate based on csstransitions support
		_applyAnimation : function( el, styleCSS, speed ) {
			
			// CSS3 supported - just apply basic CSS
			if(this.support) {
				el.stop().css(styleCSS);	
			} else {
				el.stop().animate( styleCSS, $.extend( true, [], { duration : speed + 'ms' } ) );
			}
		}

	};
	
	var logError = function( message ) {

		if ( window.console ) {
			window.console.error( message );
		}

	};
	
	$.fn.lc_hoverdir = function( options ) {
		var instance = $.data(this, 'lc_hoverdir');
		
		if (typeof options === 'string') {
			var args = Array.prototype.slice.call( arguments, 1 );

			if ( !instance ) {

				logError( "cannot call methods on hoverdir prior to initialization; " +
				"attempted to call method '" + options + "'" );
				return;
			
			}

			if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {

				logError( "no such method '" + options + "' for hoverdir instance" );
				return;
			
			}
			
			instance[ options ].apply( instance, args );
		} 
		else {
			if ( instance ) {
				instance._init();
			}
			else {
				instance = $.data( this, 'lc_hoverdir', new $.lc_HoverDir( options, this ) );
			}
		}
		
		return instance;
		
	};
	
} )( jQuery, window);
