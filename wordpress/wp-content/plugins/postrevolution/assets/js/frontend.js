/* 
File: assets/js/frontend.js
Description: JS Script for Frontend
Plugin: Post Revolution
Author: unCommons
*/

jQuery(function($){
	$(document).ready(function(){	
	
		
		/* ENABLE VERTICAL SCROLL */
		if( $('.preview-wrap-content').data('drag') == 1 ) {
			$('.preview-wrap-content').pep({
				axis: "y",
				easeDuration: 300,
				useCSSTranslation: false,
				stop: function(ev, obj){ outOfBounds(ev, obj); },
				rest: function(ev, obj){ outOfBounds(ev, obj) }
			}); 
		}
		
		// Check if the text went outside its parent
		function outOfBounds(ev,obj){       
		  
		  if ( -obj.$el.position().top > (obj.$el.outerHeight() - obj.$el.parent().outerHeight()) ){
		   obj.$el.css({ top: -obj.$el.outerHeight() + obj.$el.parent().outerHeight()  })
		  }
								  
		   if ( obj.$el.position().top > 0 ){ 
			 setTimeout(function(){ 
			   obj.$el.css({ top: 0 });
			 }, 500); 
		   }
		}


		/* Z-INDEX FIX */
		
		$('.grid li').hover(
			function(){
				$(this).css('z-index',9997);
			},
			function(){
				$(this).css('z-index','inherit');
			});
			
		/* OVERFLOW CAPTION FIX */
				
		var caption = $('.caption-post');
		var wrapCaption = caption.parent();
						
		if((caption.hasClass('entry-caption-3') || caption.hasClass('entry-caption-7') || caption.hasClass('entry-caption-9') || caption.hasClass('entry-caption-10')) && (!wrapCaption.hasClass('shape-5')) && (!wrapCaption.hasClass('shape-7')) && (!wrapCaption.hasClass('shape-8')) && (!wrapCaption.hasClass('shape-9')) )
		{
			$('.wrap-image').css('overflow','hidden');
		}
			
		/* ENTRY EFFECTS */
		
		$('.grid li .wrap-image').hover(
			function(){
												
				/* CAPTION IN */
								
  				$('.entry-caption-1', this).css('visibility','inherit').removeClass('un-fadeOut').addClass('un-bounceIn');
  				$('.entry-caption-2', this).css('visibility','inherit').removeClass('un-fadeOut').addClass('un-swing');
				$('.entry-caption-3', this).css('visibility','inherit').removeClass('un-fadeOut').addClass('un-fadeInUpBig');
				$('.entry-caption-4', this).css('visibility','inherit').removeClass('un-fadeOut').addClass('un-flipInX');
				$('.entry-caption-5', this).css('visibility','inherit').removeClass('un-fadeOut').addClass('un-fadeIn');
				$('.entry-caption-6', this).css('visibility','inherit').removeClass('un-fadeOut').addClass('un-bounce');
				$('.entry-caption-7', this).css('visibility','inherit').removeClass('un-fadeOut').addClass('un-slideInDown');
				$('.entry-caption-8', this).css('visibility','inherit').removeClass('un-fadeOut').addClass('un-pulse');
				$('.entry-caption-9', this).css('visibility','inherit').removeClass('un-fadeOut').addClass('un-slideInLeft');
				$('.entry-caption-10', this).css('visibility','inherit').removeClass('un-fadeOut').addClass('un-slideInRight');
	
			},
			function(){
												
				/* CAPTION OUT */
				
    			$('.entry-caption-1', this).css('visibility','visible').removeClass('un-bounceIn').addClass('un-fadeOut');				 	
				$('.entry-caption-2', this).css('visibility','visible').removeClass('un-swing').addClass('un-fadeOut');
				$('.entry-caption-3', this).css('visibility','visible').removeClass('un-fadeInUpBig').addClass('un-fadeOut');
				$('.entry-caption-4', this).css('visibility','visible').removeClass('un-flipInX').addClass('un-fadeOut');
				$('.entry-caption-5', this).css('visibility','visible').removeClass('un-fadeIn').addClass('un-fadeOut');
				$('.entry-caption-6', this).css('visibility','visible').removeClass('un-bounce').addClass('un-fadeOut');
				$('.entry-caption-7', this).css('visibility','visible').removeClass('un-slideInDown').addClass('un-fadeOut');
				$('.entry-caption-8', this).css('visibility','visible').removeClass('un-pulse').addClass('un-fadeOut');
				$('.entry-caption-9', this).css('visibility','visible').removeClass('un-slideInLeft').addClass('un-fadeOut');
				$('.entry-caption-10', this).css('visibility','visible').removeClass('un-slideInRight').addClass('un-fadeOut');
	
			});
			
		/*  PERMALINK ICON */
		
		$('.btn-permalink').click(
			function(){
				
				var permalink = $(this).data('url');
				window.location.href = permalink;
			
			}
		);
		
		/*  PERMALINK ON CAPTION */
		
		$('.caption-url').click(
			function(){
				
				var permalink = $(this).data('url');
				window.location.href = permalink;
			
			}
		);
					
		/*  PREVIEW ICON */
		
		$('.btn-preview').click(
			function(){
	
				
				$('html').css('overflow','hidden'); 
				$('body').css('overflow','hidden'); 
				
				var preview = $(this).data('preview');
				$('#' + preview).css('visibility','visible');
				
				/* DRAG 'N' DROP ICONS */
				
				setTimeout(function(){$('.btn-drag').addClass('un-bounceIn');}, 800);
				setTimeout(function(){$('.btn-drag').addClass('un-bounceOut');}, 3800);
					
				/* OVERLAY IN */
				
				$('.entry-preview-1').removeClass('un-fadeOut').addClass('un-bounceIn');
  				$('.entry-preview-2').removeClass('un-fadeOut').addClass('un-swing');
				$('.entry-preview-3').removeClass('un-fadeOut').addClass('un-fadeInUpBig');
				$('.entry-preview-4').removeClass('un-fadeOut').addClass('un-flipInX');
				$('.entry-preview-5').removeClass('un-fadeOut').addClass('un-fadeIn');
				$('.entry-preview-6').removeClass('un-fadeOut').addClass('un-bounce');
				$('.entry-preview-7').removeClass('un-fadeOut').addClass('un-slideInDown');
				$('.entry-preview-8').removeClass('un-fadeOut').addClass('un-pulse');
				$('.entry-preview-9').removeClass('un-fadeOut').addClass('un-bounceInDown');
				$('.entry-preview-10').removeClass('un-fadeOut').addClass('un-flipInY');
				$('.entry-preview-11').removeClass('un-fadeOut').addClass('un-slideInLeft');
				$('.entry-preview-12').removeClass('un-fadeOut').addClass('un-slideInRight');
				
			});
			
		$('.btn-close').click(
			function(){
				
				setTimeout(function(){$('html').css('overflow','auto');}, 500);
				setTimeout(function(){$('body').css('overflow','auto');}, 500);
											
				/* OVERLAY OUT */
				
				$('.entry-preview-1').removeClass('un-bounceIn').addClass('un-fadeOut');;
				$('.entry-preview-2').removeClass('un-swing').addClass('un-fadeOut');
				$('.entry-preview-3').removeClass('un-fadeInUpBig').addClass('un-fadeOut');
				$('.entry-preview-4').removeClass('un-flipInX').addClass('un-fadeOut');
				$('.entry-preview-5').removeClass('un-fadeIn').addClass('un-fadeOut');
				$('.entry-preview-6').removeClass('un-bounce').addClass('un-fadeOut');
				$('.entry-preview-7').removeClass('un-slideInDown').addClass('un-fadeOut');
				$('.entry-preview-8').removeClass('un-pulse').addClass('un-fadeOut');
				$('.entry-preview-9').removeClass('un-bounceInDown').addClass('un-fadeOut');
				$('.entry-preview-10').removeClass('un-flipInY').addClass('un-fadeOut');
				$('.entry-preview-11').removeClass('un-slideInLeft').addClass('un-fadeOut');
				$('.entry-preview-12').removeClass('un-slideInRight').addClass('un-fadeOut');
				
				setTimeout(function(){ 
					$('[class^="preview-overlay"]').css('visibility','hidden');
				},500);
								
		});
		
		
		/* PRETTY PHOTO INIT */
		$("a[rel^='prettyPhoto']").prettyPhoto();
		
		
		/* LOADING */		
		$(window).load(function(){
		  
			setTimeout(function () {
					
				$('#wrap-pr #mask').fadeOut(500);
				
				$('#wrap-pr #filters').fadeIn(500);
				
				$('#wrap-pr #grid').animate({opacity:1}, 500);
				
			}, 500);
			
			/* Magnage Columns and Thumb Shapes */
			$(window).resize(function() {
				
				
				$( "#grid .wrap-post" ).each(function() {	
							
					var gridW = $('#grid').width();
					
					// CASE COL 6
					if($(this).hasClass('column-6')) {
						
						if (gridW > 840) {
							$(this).css('width', '');
						}
						
						if(gridW < 840 && gridW > 700 ) {
							$(this).css('width','20%');
						}
						
						if(gridW < 700 && gridW > 560 ) {
							$(this).css('width','25%');
						}
						
						if(gridW < 560 && gridW > 420 ) {
							$(this).css('width','33.3333%');
						}
						
						if(gridW < 420 && gridW > 280 ) {
							$(this).css('width','50%');
						}
						
						if(gridW < 280) {
							$(this).css('width','100%');
						}
						
					}
					
					// CASE COL 5
					if($(this).hasClass('column-5')) {
						
						if (gridW > 700) {
							$(this).css('width', '');
						}					
						
						if(gridW < 700 && gridW > 560 ) {
							$(this).css('width','25%');
						}
						
						if(gridW < 560 && gridW > 420 ) {
							$(this).css('width','33.3333%');
						}
						
						if(gridW < 420 && gridW > 280 ) {
							$(this).css('width','50%');
						}
						
						if(gridW < 280) {
							$(this).css('width','100%');
						}
						
					}
					
					// CASE COL 4
					if($(this).hasClass('column-4')) {
						
						if (gridW > 560) {
							$(this).css('width', '');
						}					
						
						if(gridW < 560 && gridW > 420 ) {
							$(this).css('width','33.3333%');
						}
						
						if(gridW < 420 && gridW > 280 ) {
							$(this).css('width','50%');
						}
						
						if(gridW < 280) {
							$(this).css('width','100%');
						}
						
					}
					
					// CASE COL 3
					if($(this).hasClass('column-3')) {
						
						if (gridW > 420) {
							$(this).css('width', '');
						}					
						
						if(gridW < 420 && gridW > 280 ) {
							$(this).css('width','50%');
						}
						
						if(gridW < 280) {
							$(this).css('width','100%');
						}
						
					}
					
					// CASE COL 2
					if($(this).hasClass('column-2')) {
						
						if (gridW > 280) {
							$(this).css('width', '');
						}					
						
						if(gridW < 280) {
							$(this).css('width','100%');
						}
						
					}
					
					// Manage Thumb Sizes
					
					var itemW = $(this).width();
					
					if($(this).hasClass('pr-thumb-square')) {
				
						$('.post-image', this).css('width', itemW+'px');
						$('.post-image', this).css('height', itemW+'px');
						$('.post-image', this).attr('data-height', itemW);
						$('.post-image', this).data('height', itemW);
						
					}
					
					if($(this).hasClass('pr-thumb-land')) {
						
						var itemH = itemW / 3 * 2;
						
						$('.post-image', this).css('width', itemW+'px');					
						$('.post-image', this).css('height', itemH+'px');
						$('.post-image', this).attr('data-height', itemH);
						$('.post-image', this).data('height', itemH);
						
					}
					
					if($(this).hasClass('pr-thumb-port')) {
						
						var itemH = itemW / 3 * 4;
			
						$('.post-image', this).css('width', itemW+'px');					
						$('.post-image', this).css('height', itemH+'px');												
						$('.post-image', this).attr('data-height', itemH);
						$('.post-image', this).data('height', itemH);
						
					}
					
					
					
								
					// Magnage Elements 
					
					var relWidth = $('.post-image', $(this)).width();
					var relHeight = $('.post-image', $(this)).data('height');
					
					if(relWidth < 280 || relHeight < 320){
						$('.meta-caption', $(this)).css('display','none');
						$('.caption-title', $(this)).css({'white-space':'nowrap','overflow':'hidden','text-overflow':'ellipsis', 'width':'100%'});
					}else{
						$('.caption-title', $(this)).css({'white-space':'','overflow':'','text-overflow':'', 'width':''});
						$('.meta-caption', $(this)).css('display','');
					}
					
					if(relWidth < 240 || relHeight < 240){
						$('.caption-subtitle', $(this)).css('display','none');
					}else{
						$('.caption-subtitle', $(this)).css('display','');
	
					}
					
					if(relWidth < 180 || relHeight < 180){
						$('.caption-title', $(this)).css('display','none');
						$('.meta-value', $(this)).css('display','none');
					}else{
						$('.caption-title', $(this)).css('display','');
						$('.meta-value', $(this)).css('display','');
					}
					
					if(relWidth < 180){
						$('.wrap-excerpt', $(this)).css('display','none');
					}else{
						$('.wrap-excerpt', $(this)).css('display','');
					}
					
					if(relWidth < 160 || relHeight < 160){
						$('.btn-caption').css({'text-align':'center','top':'50%','margin-top':'-30px'});
						$('.btn-caption span').css('margin','5px');
					}else{
						$('.btn-caption').css({'text-align':'','top':'','left':'','margin':''});
						$('.btn-caption span').css('margin','');
					}
					
					/*** Set Item Height (Safari Fix) ***/
					var padding = 0;
					if ($(this).hasClass('mosaic-1')){ padding = 10; }
					if ($(this).hasClass('mosaic-2')){ padding = 20; }
					
					if($('.wrap-excerpt', this).css('display') == 'none') {
						$(this).css('height', $('.post-image', this).data('height') + padding );
					}else{
						$(this).css('height', $('.post-image', this).data('height') + $('.wrap-excerpt', this).outerHeight() + padding );
					}
													
				});
			});
			
			
			// Resize all
			$(window).trigger('resize');
	
		
			/* ISOTOPE INITIALIZATION */
			var $container = $('#grid');
			
			$container.isotope({
				 
					// options
					itemSelector: '.wrap-post',
					layoutMode: 'masonry',
					transitionDuration: '0.6s',
					
					masonry: {
					  columnWidth: '.wrap-post',
					}
		
			});
			
			/* ISOTOPE FILTERING */
			$('#filters').on( 'click', 'li', function() {
		
				  var filterValue = $(this).data('filter');
				  
				  $container.isotope({ 
					
					  filter: filterValue
					  
				  });
			
			});	
		  
		}); // WIN.LOAD
		
									
	}); // WIN.READY
}); // JQUERY