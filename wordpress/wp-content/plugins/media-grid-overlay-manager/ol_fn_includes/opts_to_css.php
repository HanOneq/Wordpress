<?php 

// dynamic css builder - layer opts to css rules
function mgom_opt_to_css($opt, $val, $all_vals, $on_hover = false, $layer_name = false) {
	include_once(MG_DIR . '/functions.php');
	
	// if value is empty and different from zero - ignore
	if(empty($val) && $val !== '0') {return '';}
	
	// extra cases to ignore
	if(!empty($layer_name)) {
		if($layer_name == 'txt_block' && in_array($opt, array('opacity', 'opacity_h'))) {return '';} // text bock - rgba background - discard opacity
		
	}
	
	
	// default state rules
	if(!$on_hover) {
		$rule = '';
		
		switch($opt) {
			case 'bg_color' : 
				if($layer_name == 'txt_block') {
					$rule = '
						background-color: '. mg_hex2rgba($val, ($all_vals['opacity'] / 100)) .';
						';
				} else {
					$rule = '
						background-color: '.$val.';
						';
				}
				break;
				
			case 'color' : $rule = '
				color: '.$val.';'; 
				break;
				
			case 'highlight' : $rule = '
				background-color: '.$val.';
				box-shadow: 0 0 0 3px '.$val.';
				outline: 4px solid '.$val.';'; 
				break;	
					
			case 'opacity' 	: 
				$rule = 'opacity: '.($val / 100).'; filter: alpha(opacity='.$val.');
				'; break;
				
			case 'position' :
				if($val == 'top') 				{$rule = 'top: -100%; left: 0px;';}
				elseif($val == 'top-right') 	{$rule = 'top: -100%; right: -100%;';}
				elseif($val == 'right') 		{$rule = 'top: 0px; right: -100%;';}
				elseif($val == 'bottom-right') 	{$rule = 'bottom: -100%; right: -100%;';}
				elseif($val == 'bottom') 		{$rule = 'bottom: -100%; left: 0px;';}
				elseif($val == 'bottom-left') 	{$rule = 'bottom: -100%; left: -100%;';}
				elseif($val == 'left') 			{$rule = 'top: 0px; left: -100%;';}
				elseif($val == 'top-left') 		{$rule = 'top: -100%; left: -100%;';}
				elseif($val == 'center') 		{$rule = 'top: 0px; left: 0px;';}
				break;
				
			case 'icon_position' :
				if($val == 'top-right') 		{$rule = 'top: 13px; right: 13px;';}
				elseif($val == 'bottom-right') 	{$rule = 'bottom: 13px; right: 13px;';}
				elseif($val == 'bottom-left') 	{$rule = 'bottom: 13px; left: 13px;';}
				elseif($val == 'top-left') 		{$rule = 'top: 13px; left: 13px;';}
				elseif($val == 'center') 		{$rule = 'top: 50%; left: 50%;';}
				break;
				
			case 'corner_pos' : 
				if($val == 'top-right') 		{$rule = 'top: -150px; right: -150px;';}
				elseif($val == 'bottom-right') 	{$rule = 'bottom: -150px; right: -150px;';}
				elseif($val == 'bottom-left') 	{$rule = 'bottom: -150px; left: -150px;';}
				elseif($val == 'top-left') 		{$rule = 'top: -150px; left: -150px;';}
				break;	
				
			case 'font_size' : $rule = 'font-size: '.$val.'px;
				'; break;

			case 'easing' :  // all the transition block
				$duration = (isset($all_vals['animation_time'])) ? (int)$all_vals['animation_time'] : '350'; 

				$rule = '
				-webkit-transition: all '.$duration.'ms '. mgom_easing_to_css_ow($val) .' 0s;
				-ms-transition: 	all '.$duration.'ms '. mgom_easing_to_css($val) .' 0ms;
				transition: 		all '.$duration.'ms '. mgom_easing_to_css($val) .' 0ms;
				';
				break;		
			
			case 'transitions' : $rule = mgom_transitions_css($val, false);
				break;
					
			case 'txt_align' : $rule = 'text-align: '.$val.';
				'; break;	
			
			case 'line_height' : $rule = 'line-height: '.$val.'px;
				'; break;
				
			case 'txt_styles' : 
				if(in_array('bold', $val)) {$rule .= 'font-weight: bold;';}
				if(in_array('italic', $val)) {$rule .= 'font-style: italic;';}
				if(in_array('uppercase', $val)) {$rule .= 'text-transform: uppercase;';}
				break;			
				
			case 'font_family' : $rule = 'font-family: '. str_replace(array('&apos;', '?'), array('\'', ''), utf8_decode ($val)) .';
				'; break;	
				
			case 'sep_style': // separator/border full style
				$size = (isset($all_vals['thickness'])) ? $all_vals['thickness'] : 1; 
				$color = (isset($all_vals['color'])) ? $all_vals['color'] : '#333333'; 

				$rule = '
				border-bottom: '.$size.'px '.$val.' '.$color.';
				';
				break;
			
			case 'border_width' : // full border code
				$style = (isset($all_vals['border_style'])) ? $all_vals['border_style'] : 'solid'; 
				$color = (isset($all_vals['border_color'])) ? $all_vals['border_color'] : '#444'; 
					
				$rule = 'border: '. (int)$val .'px '.$style.' '.$color.';
				'; break;
			
			case 'border_radius' : $rule = 'border-radius: '. $val .'px;
				'; break;	
				
			case 'btn_full_width' : 
				if($val) {$rule = 'display: block;
				';
				}
				break;	
			
			case 'btn_align' : 
				if(!isset($all_vals['btn_full_width']) || !$all_vals['btn_full_width']) {
					if($val == 'right') {$rule = 'float: right; clear: both;
					';
					}
					else if($val == 'center') {$rule = 'display: table; margin: auto;
					';
					}
				}
				break;	
				
			case 'txt_padding': // txt wrap custom padding
				if(is_array($val)) {
					if(!empty($val[0])) {$rule .= 'padding-top: '.$val[0].'px; ';}
					if(!empty($val[1])) {$rule .= 'padding-right: '.$val[1].'px; ';}
					if(!empty($val[2])) {$rule .= 'padding-bottom: '.$val[2].'px; ';}
					if(!empty($val[3])) {$rule .= 'padding-left: '.$val[3].'px; ';}
				}
				break;
				
			case 'txt_max_h':
				if(!empty($val)) {
					$rule = 'max-height: '. (int)$val .'px;
					';	
				}
				break;	
				
			case 'txt_vert_margin': // txt elements custom margin
				if(is_array($val)) {
					if(!empty($val[0])) {$rule .= 'margin-top: '.$val[0].'px !important; ';}
					if(!empty($val[1])) {$rule .= 'margin-bottom: '.$val[1].'px !important; ';}
				}
				break;	
				
			case 'full_img_padding'	: // full image layer - simulated padding
				$rule = 'padding: '. (int)$val .'px;
				';break;	
				
			case 'img_ol_src' : // all rules related to image overlay
				switch($all_vals['img_ol_pos']) {
					case 'top' 		: $pos = 'center top'; break;
					case 'right' 	: $pos = 'right center'; break;
					case 'bottom' 	: $pos = 'center bottom'; break;
					case 'left' 	: $pos = 'left center'; break;
					case 'center' 	: $pos = 'center center'; break;	
					default			: $pos = str_replace('-', ' ', $all_vals['img_ol_pos']); break;	
				}
				
				$rule = '
				background: url("'. $val .'") no-repeat scroll '. $pos .' transparent;
				background-size: '. $all_vals['img_ol_bg_size'] .';
				background-origin: content-box content-box;
				';
				break;	
		}
	}
	
	// hover state rules
	else {
		$rule = '';
		
		switch($opt) {
			case 'bg_color_h' : 
				if($layer_name == 'txt_block') {
					$rule = '
						background-color: '. mg_hex2rgba($val, ($all_vals['opacity_h']/100)) .';
						';
				} else {
					$rule = '
						background-color: '.$val.';
						';
				}
				break;
				
			case 'color_h' 	: $rule = '
				color: '.$val.';'; 
				break;
			
			case 'highlight_h' : $rule = '
				background-color: '.$val.';
				box-shadow: 0 0 0 3px '.$val.';
				outline: 4px solid '.$val.';'; 
				break;	
			
			case 'border_color_h' 	: $rule = '
				border-color: '.$val.';'; 
				break;
				
			case 'opacity_h' 	: 
				$rule = 'opacity: '.($val / 100).'; filter: alpha(opacity='.$val.');
				'; break;
			
			case 'position' :
				if($val == 'top') 				{$rule = 'top: 0px;';}
				elseif($val == 'top-right') 	{$rule = 'top: 0px; right: 0px;';}
				elseif($val == 'right') 		{$rule = 'top: 0px; right: 0px;';}
				elseif($val == 'bottom-right') 	{$rule = 'bottom: 0px; right: 0px;';}
				elseif($val == 'bottom') 		{$rule = 'bottom: 0px; left: 0px;';}
				elseif($val == 'bottom-left') 	{$rule = 'bottom: 0px; left: 0px;';}
				elseif($val == 'left') 			{$rule = 'top: 0px; left: 0px;';}
				elseif($val == 'top-left') 		{$rule = 'top: 0px; left: 0px;';}
				elseif($val == 'center') 		{$rule = 'top: 0px; left: 0px;';}
				break;
			
			case 'corner_pos' 	: 
				if($val == 'top-right') 		{$rule = 'top: -80px; right: -80px;';}
				elseif($val == 'bottom-right') 	{$rule = 'bottom: -80px; right: -80px;';}
				elseif($val == 'bottom-left') 	{$rule = 'bottom: -80px; left: -80px;';}
				elseif($val == 'top-left') 	{$rule = 'top: -80px; left: -80px;';}
				break;
				
			case 'border_width_h' : $rule = 'border-width: '. (int)$val.'px;
				'; break;
				
			case 'font_size_h' : $rule = 'font-size: '.$val.'px;
				'; break;
			
			case 'full_img_padding_h' : $rule = 'padding: '. (int)$val .'px;
				'; break;	
			
			case 'transitions' : $rule = mgom_transitions_css($val, true);
				break;
				
			case 'animation_delay' :
				if(!empty($val)) {
					$rule = '
					 -webkit-transition-delay: '. ($val/1000) .'s !important;
					transition-delay: '. ($val/1000) .'s !important;
					';	
				}
				break;
		}	
	}

	return $rule;
}


// litteral easing to CSS code
function mgom_easing_to_css($easing) {
	switch($easing) {
		case 'ease' : $code = 'ease'; break;
		case 'linear' : $code = 'linear'; break;
		case 'ease-in' : $code = 'ease-in'; break;
		case 'ease-out' : $code = 'ease-out'; break;
		case 'ease-in-out' : $code = 'ease-in-out'; break;
		case 'ease-in-back' : $code = 'cubic-bezier(0.600, -0.280, 0.735, 0.045)'; break;
		case 'ease-out-back' : $code = 'cubic-bezier(0.175, 0.885, 0.320, 1.275)'; break;
		case 'ease-in-out-back' : $code = 'cubic-bezier(0.680, -0.850, 0.265, 1.850)'; break;
	}
	
	return $code;
}

// litteral easing to CSS code - old webkit (safari on Win)
function mgom_easing_to_css_ow($easing) {
	switch($easing) {
		case 'ease' : $code = 'ease'; break;
		case 'linear' : $code = 'linear'; break;
		case 'ease-in' : $code = 'ease-in'; break;
		case 'ease-out' : $code = 'ease-out'; break;
		case 'ease-in-out' : $code = 'ease-in-out'; break;
		case 'ease-in-back' : $code = 'cubic-bezier(0.600, 0, 0.735, 0.045)'; break;
		case 'ease-out-back' : $code = 'cubic-bezier(0.175, 0.885, 0.320, 1)'; break;
		case 'ease-in-out-back' : $code = 'cubic-bezier(0.680, 0, 0.265, 1)'; break;
	}
	
	return $code;
}


// transitions css rules
function mgom_transitions_css($val, $on_hover = false) {
	if(!is_array($val) || count($val) == 0) {return '';}
	$bc = array();
	$persp = 'perspective(750px)';

	if(!$on_hover) {
		if(in_array('zoom-in', $val)) {$bc[] = 'scale(0.6)';}
		if(in_array('zoom-out', $val)) {$bc[] = 'scale(1.4)';}
		if(in_array('slide-vert', $val)) {$bc[] = $persp.' rotateY(-180deg)';}
		if(in_array('slide-horiz', $val)) {$bc[] =$persp.' rotateX(-180deg)';}
		if(in_array('flip-vert', $val)) {$bc[] = 'rotateY(0deg)';}
		if(in_array('flip-horiz', $val)) {$bc[] = 'rotateX(0deg)';}
		if(in_array('rotate', $val)) {$bc[] = 'rotate(0deg)';}
		
		if(in_array('door-top', $val)) {$bc[] = $persp.' rotateX(-90deg)';}
		if(in_array('door-right', $val)) {$bc[] = $persp.' rotateY(-90deg)';}
		if(in_array('door-bottom', $val)) {$bc[] = $persp.' rotateX(90deg)';}
		if(in_array('door-left', $val)) {$bc[] = $persp.' rotateY(90deg)';}
		
		if(in_array('upward', $val)) {$bc[] = 'translateY(13px)';}
		if(in_array('leftward', $val)) {$bc[] = 'translateX(13px)';}
		if(in_array('downward', $val)) {$bc[] = 'translateY(-13px)';}
		if(in_array('rightward', $val)) {$bc[] = 'translateX(-13px)';}
	} 
	else {
		if(in_array('zoom-in', $val)) {$bc[] = 'scale(1.0)';}
		if(in_array('zoom-out', $val)) {$bc[] = 'scale(1.0)';}
		if(in_array('slide-vert', $val)) {$bc[] = $persp.' rotateY(0deg)';}
		if(in_array('slide-horiz', $val)) {$bc[] = $persp.' rotateX(0deg)';}
		if(in_array('flip-vert', $val)) {$bc[] = 'rotateY(360deg)';}
		if(in_array('flip-horiz', $val)) {$bc[] = 'rotateX(360deg)';}	
		if(in_array('rotate', $val)) {$bc[] = 'rotate(360deg)';}
		
		if(in_array('door-top', $val)) {$bc[] = $persp.' rotateX(0deg)';}
		if(in_array('door-right', $val)) {$bc[] = $persp.' rotateY(0deg)';}
		if(in_array('door-bottom', $val)) {$bc[] = $persp.' rotateX(0deg)';}
		if(in_array('door-left', $val)) {$bc[] = $persp.' rotateY(0deg)';}
		
		if(in_array('upward', $val)) {$bc[] = 'translateY(0)';}
		if(in_array('leftward', $val)) {$bc[] = 'translateX(0)';}
		if(in_array('downward', $val)) {$bc[] = 'translateY(0)';}
		if(in_array('rightward', $val)) {$bc[] = 'translateX(0)';}
	}

	$subj = array('-ms-transform:', '-webkit-transform:', 'transform:');
	$final_code = '';
	
	foreach($subj as $rule) {
		$final_code .= $rule.' '.implode(' ', $bc).'; ';
	}
	
	
	// special instructions
	if(!$on_hover) {
		
		// spinner - show backface
		if(in_array('flip-vert', $val) || in_array('flip-horiz', $val)) {
			$final_code .= '
				-webkit-backface-visibility: visible !important;
				backface-visibility: visible !important;
			';
		}
		
		// door fx - transform origin
		foreach($val as $fx) {
			if(strpos($fx, 'door') !== false) {
				switch($fx) {
					case 'door-top' 	: $orig = 'center top'; break;
					case 'door-right' 	: $orig = 'right center'; break;
					case 'door-bottom' 	: $orig = 'center bottom'; break;
					case 'door-left' 	: $orig = 'left center'; break; 	
				}
				
				$final_code .= '
					-webkit-transform-origin: '. $orig .';
					transform-origin: '. $orig .';
				';
			}
		}
	}
	
	return $final_code;
}

