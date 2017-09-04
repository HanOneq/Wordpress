/* 
File: assets/js/backend.js
Description: JS Script for Backend
Plugin: Post Revolution
Author: unCommons
*/

jQuery(function($){
	$(window).load(function(){
		
		// APPEND MENU
		
		$( 'body' ).append( '<div id="pr_custom_preset_menu" class="menu-hide"></div>' );
		
		$( '#pr_custom_preset_menu' ).append( '<div class="pr_menu_title">Custom Preset Navigator <a class="pricon-menu pr-nav-toggle" title="Open/Close Navigator"></a> <a class="pricon-circle-arrow-up pr-gotop" title="Back to the Top" data-id="#post-body-content"></a></div>' );
		
		$( '#pr_custom_preset_menu' ).append( '<ul class="pr_menu_main"></ul>' );
		
		$( '#pr_custom_preset_menu ul.pr_menu_main' ).append( '<li><a data-id=".pr_title_fonts"><i class="pricon-settings"></i> Fonts</a></li>' );
		$( '#pr_custom_preset_menu ul.pr_menu_main' ).append( '<li><a data-id=".pr_title_thumbs"><i class="pricon-settings"></i> Thumbnails</a></li>' );
		$( '#pr_custom_preset_menu ul.pr_menu_main' ).append( '<li><a data-id=".pr_title_caption"><i class="pricon-settings"></i> Caption</a><ul class="pr_menu_caption pr_submenu"></ul></li>' );
		$( '#pr_custom_preset_menu ul.pr_menu_main' ).append( '<li><a data-id=".pr_title_excerpt"><i class="pricon-settings"></i> Excerpt</a><ul class="pr_menu_excerpt pr_submenu"></ul></li>' );
		$( '#pr_custom_preset_menu ul.pr_menu_main' ).append( '<li><a data-id=".pr_title_preview"><i class="pricon-settings"></i> Preview</a><ul class="pr_menu_preview pr_submenu"></ul></li>' );
		
		$( '#pr_custom_preset_menu ul.pr_menu_caption' ).append( '<li><a data-id=".pr-caption-shape"><i class="pricon-star"></i> Shape</a></li>' );
		$( '#pr_custom_preset_menu ul.pr_menu_caption' ).append( '<li><a data-id=".pr-caption-title"><i class="pricon-font"></i> Title</a></li>' );
		$( '#pr_custom_preset_menu ul.pr_menu_caption' ).append( '<li><a data-id=".pr-caption-subtitle"><i class="pricon-bold"></i> Subtitle</a></li>' );
		$( '#pr_custom_preset_menu ul.pr_menu_caption' ).append( '<li><a data-id=".pr-caption-metas"><i class="pricon-tags"></i> Metas</a></li>' );
		
		$( '#pr_custom_preset_menu ul.pr_menu_excerpt' ).append( '<li><a data-id=".pr-excerpt-header"><i class="pricon-type"></i> Header</a></li>' );
		$( '#pr_custom_preset_menu ul.pr_menu_excerpt' ).append( '<li><a data-id=".pr-excerpt-content"><i class="pricon-menu-2"></i> Content</a></li>' );
		$( '#pr_custom_preset_menu ul.pr_menu_excerpt' ).append( '<li><a data-id=".pr-excerpt-button"><i class="pricon-hand-right"></i> Read More Button</a></li>' );
		
		$( '#pr_custom_preset_menu ul.pr_menu_preview' ).append( '<li><a data-id=".pr-preview-title"><i class="pricon-font"></i> Title</a></li>' );
		$( '#pr_custom_preset_menu ul.pr_menu_preview' ).append( '<li><a data-id=".pr-preview-subtitle"><i class="pricon-bold"></i> Subtitle</a></li>' );
		$( '#pr_custom_preset_menu ul.pr_menu_preview' ).append( '<li><a data-id=".pr-preview-content"><i class="pricon-menu-2"></i> Content</a></li>' );
		
		
		// CHECK IF CUSTOM GROUP IS OPENED AFTER PAGE IS LOADED
		
		if( !$('.wpa_loop-pr_custom_preset .vp-controls').hasClass('vp-hide') && !$('.wpa_loop-pr_custom_preset').hasClass('vp-hide') ) {
				
				$('#pr_custom_preset_menu').removeClass('menu-hide');
			
		}
	
		
		// ENABLE DISABLE MENU BY GROUP TOGGLE
		
		$('.wpa_loop-pr_custom_preset .vp-wpa-group-title').click(function() {
						
			if( $('i', this).hasClass('pricon-settings') ) {
				
				if( $('.wpa_loop-pr_custom_preset .vp-controls').hasClass('vp-hide') ) {
					
					$('#pr_custom_preset_menu').removeClass('menu-hide');
				
				}else{
					
					$('#pr_custom_preset_menu').addClass('menu-hide');
					
				}
			
			}
			
		});
		
		
		// ENABLE DISABLE MENU BY GROUP DEPENDENCY
		
		$('*[name="pr_layouts_meta[pr_presets]"]').change(function(){
			
			var val = $(this).val();
			
			if (val == 'custom') {
				$('#pr_custom_preset_menu').removeClass('menu-hide');
			}else{
				$('#pr_custom_preset_menu').addClass('menu-hide');
			}
			
		});
		
		// MENU TOGGLE
		$('.pr-nav-toggle').click(function() {
			$('.pr_menu_main').slideToggle(500);
		});
		
		// GO TO SELECTED SECTION
		
		$("#pr_custom_preset_menu a").click(function() {
			
			var id = $(this).data('id');
			
			if(id == '#post-body-content') { $('.pr_menu_main').slideToggle(500); }
			
			$('html, body').animate({
				scrollTop: $(id).offset().top - 50
			}, 500);
			
		});
		
		
	});
}); 