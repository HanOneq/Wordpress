<?php
///////////////////////////////////////////
// DYNAMICALLY CREATE THE OVERLAYS CSS ////
///////////////////////////////////////////


//// BASIC FRONTEND CSS 
// remove the HTTP/HTTPS for SSL compatibility
$safe_baseurl = str_replace(array('http:', 'https:', 'HTTP:', 'HTTPS:'), '', MGOM_URL);
?>
@import url("<?php echo $safe_baseurl; ?>/css/frontend.min.css?<?php echo MGOM_VER ?>");
<?php

// get all the overlays
$ols = get_terms('mgom_overlays', 'hide_empty=0&orderby=id');
foreach($ols as $ol) :

	// layers counter
	$lc = 0;
?>

/* ***** <?php echo $ol->term_id ?> - <?php echo $ol->name ?> OVERLAY ***** */ 
  <?php  
  // get layers
  $layers = unserialize($ol->description);
  if(is_array($layers) && isset($layers['graphic'])) {
	
	##########################################
	###### GRAPHICALS ########################
	##########################################
	foreach($layers['graphic'] as $lname => $layer) {
		
		// image effects
		if($lname == 'img_fx') {
			
			// easing
			if(!isset($layer['easing'])) {$layer['easing'] = 'ease';}
			echo '
			/* img fx */
			.mgom_'.$ol->term_id.' .mg_box:not(.mg_item_no_ol) .thumb {
				-webkit-backface-visibility: hidden;
				backface-visibility: hidden;
				-webkit-transform-style: flat;
				transform-style: flat;
				'. mgom_opt_to_css('easing', $layer['easing'], $layer) .'
			}
			';
			
			// zoom (if isn't using scale hover effects)
			if(!empty($layer['img_zoom']) && (!isset($layer['img_h_fx']) || !in_array($layer['img_h_fx'], array('zoom-in-hide', 'zoom-out-hide'))) ) {
				$val = ($layer['img_zoom'] + 100) / 100;
				echo '
				.mgom_'.$ol->term_id.' .mg_box:not(.mg_item_no_ol):hover .thumb {
					-ms-transform: 		translate(-50%, -50%) scale('.$val.');
					-webkit-transform:	translate3d(-50%, -50%, 0) scale('.$val.', '.$val.');
					transform:			translate3d(-50%, -50%, 0) scale('.$val.', '.$val.');
				}
				';	
			}
			
			// no borders
			if(isset($layer['img_no_borders']) && !empty($layer['img_no_borders'])) {
				echo '
				.mgom_'.$ol->term_id.' .mg_box:not(.mg_item_no_ol):not(.mg_inl_slider):not(.mg_inl_audio) .img_wrap {
					'. mgom_opt_to_css('easing', $layer['easing'], $layer) .'
				}
				.mgom_'.$ol->term_id.' .mg_box:not(.mg_item_no_ol):not(.mg_inl_slider):not(.mg_inl_audio):hover .img_wrap {
					padding: 0 !important;
				}
				';	
			}
			
			// hover effect - zoom and hide
			if(isset($layer['img_h_fx'])) {
			
				// scale and hide
				if(in_array($layer['img_h_fx'], array('zoom-in-hide', 'zoom-out-hide'))) {
					$val = ($layer['img_h_fx'] == 'zoom-in-hide') ? 4 : 0.1;
					
					echo '
					.mgom_'.$ol->term_id.' .mg_box:not(.mg_item_no_ol):hover .thumb {
						filter: alpha(opacity=0);
						opacity: 0;
						
						-ms-transform: 		translate(-50%, -50%) scale('.$val.');
						-webkit-transform:	translate3d(-50%, -50%, 0) scale('.$val.', '.$val.');
						transform:			translate3d(-50%, -50%, 0) scale('.$val.', '.$val.');
					}
					';
				}
				
				// flip - use perspective - issues with matrix3d + translate
				elseif(in_array($layer['img_h_fx'], array('flip-vert', 'flip-horiz'))) {
					$trans_base = 'translate(-50%, -50%) perspective(750px)';
					$trans_base_ms = 'translate(-50%, -50%)'; // avoid IE bug
					
					echo '
					.mgom_'.$ol->term_id.' .mg_box:not(.mg_item_no_ol) .thumb {
						-webkit-transform:	'. $trans_base .';
						-ms-transform:		'. $trans_base_ms .' !important;
						transform:			'. $trans_base .';
					}
					.mgom_'.$ol->term_id.' .mg_box:not(.mg_item_no_ol):hover .thumb {
						-webkit-transform:	'. $trans_base .' rotateY(180deg);
						-ms-transform:		'. $trans_base_ms .' rotateY(90deg) !important;
						transform:			'. $trans_base .' rotateY(180deg);
					}
					';	
				}
				
				// door effects
				elseif(strpos($layer['img_h_fx'], 'door') !== false) {
					$axis = (in_array($layer['img_h_fx'], array('door-top' ,'door-bottom'))) ? 'X' : 'Y';
					$trans_base = 'translate(-50%, -50%) perspective(750px)';
					$trans_base_ms = 'translate(-50%, -50%)'; // avoid IE bug
					
					switch($layer['img_h_fx']) {
						case 'door-top' 	: 
							$orig = 'center top';
							$val = '-90'; 
							break;
						case 'door-right' 	: 
							$orig = 'right center'; 
							$val = '-90'; 
							break;
						case 'door-bottom' 	: 
							$orig = 'center bottom'; 
							$val = '90'; 
							break;
						case 'door-left' 	: 
							$orig = 'left center'; 
							$val = '90'; 
							break; 	
					}
						
					echo '
					.mgom_'.$ol->term_id.' .mg_box:not(.mg_item_no_ol) .thumb {
						-webkit-transform-origin: '. $orig .';
						transform-origin: '. $orig .';
						
						-webkit-transform:	'. $trans_base .';
						-ms-transform:		'. $trans_base_ms .' !important;
						transform:			'. $trans_base .';
					}
					.mgom_'.$ol->term_id.' .mg_box:not(.mg_item_no_ol):hover .thumb {
						-webkit-transform:	'. $trans_base .' rotate'. $axis .'('. $val .'deg);
						-ms-transform:		'. $trans_base_ms .' rotate'. $axis .'('. $val .'deg) !important;
						transform:			'. $trans_base .' rotate'. $axis.'('. $val .'deg);
					}
					';	
				}
			}
			
			$lc++;	
			continue;	
		}
		
		
		/*******************************************************************/
		
		
		// layer over text block 
		$over_txt = (isset($layer['over_txt_block']) && $layer['over_txt_block']) ? true : false; 
		
		// standard
		echo '
		.mgom_'.$ol->term_id.'_'.$lc.' { /* '.$lname.' */
			';
		
			foreach ($layer as $opt => $val) {
				// outlined box - ignore everything but position, opacity and animations
				if($lname == 'outlined_box' && !in_array($opt, array('position', 'full_img_padding', 'opacity', 'transitions', 'animation_time', 'easing', 'animation_delay'))) {continue;}
				
				echo mgom_opt_to_css($opt, $val, $layer);
			}

			$z_index = 900 - (10 * ($lc + 1));
			if($over_txt) {$z_index = $z_index + 200;}
			
			echo '
			z-index: '.$z_index.'; 
		}';
		
		// hover
		echo '
		.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.' {
			';
		
			foreach ($layer as $opt => $val) {
				// outlined box - ignore everything but position, opacity and animations
				if($lname == 'outlined_box' && !in_array($opt, array('position', 'full_img_padding_h', 'opacity_h', 'transitions')))  {continue;}
				
				echo mgom_opt_to_css($opt, $val, $layer, true);
			}

		echo '
		}
		';
		
		
		/*******************************************************************/
		
		
		// special rule for split overlays
		if($lname == 'vert_split_layer' || $lname == 'horiz_split_layer') {
			// standard
			echo '
			.mgom_'.$ol->term_id.'_'.$lc.' div {
					';
			
			foreach ($layer as $opt => $val) {
				if($opt != 'opacity') {
					echo mgom_opt_to_css($opt, $val, $layer);
				}
			}
				echo '
			}';
			
			// hover
			echo '
			.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.' div {
					';
			
			foreach ($layer as $opt => $val) {
				if($opt != 'opacity_h') {
					echo mgom_opt_to_css($opt, $val, $layer, true);
				}
			}
	
			echo '
			}
			';	
		}
		
		
		// special rule for shapes
		if($lname == 'central_shape') {
			$bg_color = isset($layer['bg_color']) ? $layer['bg_color'] : '#fefefe'; 
			$bg_color_h = isset($layer['bg_color_h']) ? $layer['bg_color_h'] : false; 
			
			echo '
			.mgom_'.$ol->term_id.'_'.$lc.' div, .mgom_'.$ol->term_id.'_'.$lc.' div:before, .mgom_'.$ol->term_id.'_'.$lc.' div:after {
				background-color: '.$bg_color.';	
				border-color: '.$bg_color.'; 
			}';
			
			if($bg_color_h) {
			echo '
			.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.' div, .mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.' div:before, .mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.' div:after {
				background-color: '.$bg_color_h.';	
				border-color: '.$bg_color_h.';	
			}
			';
			}
		}
		
		
		// special rule for icons - if position center
		if(($lname == 'icon') && isset($layer['icon_position']) && $layer['icon_position'] == 'center') {
			$margin = ceil((int)$layer['font_size'] / 2);
			$margin_h = (isset($layer['font_size_h'])) ? ceil((int)$layer['font_size_h'] / 2) : $margin;
			
			echo '
			.mgom_'.$ol->term_id.'_'.$lc.' {
				margin-top: -'.$margin.'px;	
				margin-left: -'.$margin.'px; 
			}';
			
			if($margin_h) {
			echo '
			.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.' {
				margin-top: -'.$margin_h.'px;	
				margin-left: -'.$margin_h.'px; 
			}
			';
			}
		}
		
		
		// special rule for single-side border (border-width on hover)
		if($lname == 'single_border') {
			echo '
			.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.' {
				border-width: '. (int)$layer['border_width'] .'px; 
			}
			';
		}
		
		
		// special rule for outlined box
		if($lname == 'outlined_box') {
			echo '
			.mgom_'.$ol->term_id.'_'.$lc.':before {
				';
				
				foreach($layer as $opt => $val){
					if(in_array($opt, array('position', 'full_img_padding', 'border_width', 'opacity', 'transitions'))) {continue;}	
					echo mgom_opt_to_css($opt, $val, $layer);
				}
		
				echo '
				top: '. (int)$layer['full_img_padding'] .'px; 
				right: '. (int)$layer['full_img_padding'] .'px;
				bottom: '. (int)$layer['full_img_padding'] .'px;
				left: '. (int)$layer['full_img_padding'] .'px;
				box-shadow: 0 0 0 '.(int)$layer['border_width'].'px '.$layer['border_color'].';
			}
			.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.':before {
				';
				
				foreach($layer as $opt => $val){
					if(in_array($opt, array('position', 'full_img_padding_h', 'border_width_h', 'opacity_h', 'transitions'))) {continue;}	
					echo mgom_opt_to_css($opt, $val, $layer, true);
				}
				
			echo '
				top: '. (int)$layer['full_img_padding_h'] .'px; 
				right: '. (int)$layer['full_img_padding_h'] .'px;
				bottom: '. (int)$layer['full_img_padding_h'] .'px;
				left: '. (int)$layer['full_img_padding_h'] .'px;
				box-shadow: 0 0 0 '.(int)$layer['border_width_h'].'px '.$layer['border_color_h'].';
			}
			';
		}
		
		
		$lc++;	
	}

	
	
	##########################################
	###### TEXTUALS ##########################
	##########################################
	foreach($layers['txt'] as $lname => $layer) {
		
		// standard
		echo '
		.mgom_'.$ol->term_id.'_'.$lc.' { /* '.$lname.' */
			';
				
			foreach ($layer as $opt => $val) {
				if(in_array($opt, array('highlight', 'easing', 'transitions'))) {continue;} // highlight animations and transitions will be applied globally later
				echo mgom_opt_to_css($opt, $val, $layer, false, $lname);
			}
		echo '
		}';
		
		// hover
		echo '
		.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.' {
			';
		
			foreach ($layer as $opt => $val) {
				if(in_array($opt, array('highlight_h', 'easing', 'transitions'))) {continue;} // highlight animations and transitions will be applied globally later
				echo mgom_opt_to_css($opt, $val, $layer, true, $lname);
			}
		echo '
		}
		';
		
		// special rules for text highlight
		if(in_array($lname, array('title', 'descr', 'custom_txt', 'socials'))) {
			if(isset($layer['highlight']) && !empty($layer['highlight'])) {
				echo '
				.mgom_'.$ol->term_id.'_'.$lc.' .mgom_mark {
					'. mgom_opt_to_css('highlight', $layer['highlight'], $layer) .'
					'. mgom_opt_to_css('color', $layer['color'], $layer) .'
				}';
			}
			if(isset($layer['highlight_h']) && !empty($layer['highlight_h'])) {
				echo '
				.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.' .mgom_mark {
					'. mgom_opt_to_css('highlight_h', $layer['highlight_h'], $layer, true) .'
					'. mgom_opt_to_css('color_h', $layer['color'], $layer, true) .'
				}';	
			}
		}
		
		
		// special rules for socials block
		if($lname == 'socials') {
			echo '
			.mgom_'.$ol->term_id.'_'.$lc.' span {
				'. mgom_opt_to_css('font_size', $layer['font_size'], $layer) .'
			}
			.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.' span {
				'. mgom_opt_to_css('color', $layer['color'], $layer) .'
			}
			.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.' span:hover,
			.mgom_'.$ol->term_id.'_'.$lc.' span:hover {
				'. mgom_opt_to_css('color_h', $layer['color_h'], $layer, true) .'
			}';
		}
		
		
		// special rules for custom text block
		if($lname == 'custom_txt') {
		
			// standard
			echo '
			.mgom_'.$ol->term_id.'_'.$lc.' * {
					';
			
			foreach ($layer as $opt => $val) {
				echo mgom_opt_to_css($opt, $val, $layer);
			}
			
			echo '
			}';
			
			// hover
			echo '
			.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.' * {
					';
			
			foreach ($layer as $opt => $val) {
				echo mgom_opt_to_css($opt, $val, $layer, true);
			}
			
			echo '
			}
			';
			
		}
		
		$lc++;	
	}

	
	//// specific rules for overlay text wrapper and global text ones
	$layer = $layers['txt']['txt_block'];

	// animations and transitions 
	echo '
	.mg_box .mgom_'.$ol->term_id.'_'.$lc.'.mgom_txt_wrap .mgom_layer {
		'. mgom_opt_to_css('easing', $layer['easing'], $layer) .'	
		'. mgom_opt_to_css('transitions', $layer['transitions'], $layer) .'
	}
	.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.'.mgom_txt_wrap .mgom_layer {
		'. mgom_opt_to_css('transitions', $layer['transitions'], $layer, true) .'
	}
	.mg_box .mgom_'.$ol->term_id.'_'.$lc.' .mgom_mark,
	.mgom_'.$ol->term_id.' .mg_title_under .mgom_layer,
	.mgom_'.$ol->term_id.' .mg_title_under .mgom_layer * {
		'. mgom_opt_to_css('easing', $layer['easing'], $layer) .'	
	}
	';
	

	// text layers visibility
	if(isset($layer['txt_visibility']) && ($layer['txt_visibility'] == 'hide' || $layer['txt_visibility'] == 'hide_h')) {
		echo'
			.mg_box .mgom_'.$ol->term_id.'_'.$lc.'.mgom_txt_wrap {
				'. mgom_opt_to_css('easing', $layer['easing'], $layer) .'	
			}
			';	
		
		if($layer['txt_visibility'] == 'hide') {
			echo'
			.mg_box .mgom_'.$ol->term_id.'_'.$lc.'.mgom_txt_wrap .mgom_layer {
				opacity: 0;
				filter: alpha(opacity=0);	
			}
			.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.'.mgom_txt_wrap .mgom_layer {
				opacity: 1;
				filter: alpha(opacity=100);	
			}
			'; 	
		}
		else if($layer['txt_visibility'] == 'hide_h') {
			echo'
			.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.'.mgom_txt_wrap .mgom_layer {
				opacity: 0;
				filter: alpha(opacity=0);	
			}
			'; 	
		}
	}

	
	// text wrapper - padding and positionin
	echo '
	.mgom_'.$ol->term_id.'_'.$lc.'.mgom_txt_wrap {
		'. mgom_opt_to_css('position', $layer['position'], $layer) .'	
		'. mgom_opt_to_css('easing', $layer['easing'], $layer) .'
		'. mgom_opt_to_css('txt_padding', $layer['txt_padding'], $layer) .'
	}
	.mg_box:hover .mgom_'.$ol->term_id.'_'.$lc.'.mgom_txt_wrap {
		'. mgom_opt_to_css('position', $layer['position'], $layer, true) .'	
	}
	';
  }
  
endforeach;  ?>