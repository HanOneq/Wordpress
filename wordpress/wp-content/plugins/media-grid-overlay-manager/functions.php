<?php 
// include function sets
include_once(MGOM_DIR .'/ol_fn_includes/fields_code.php');
include_once(MGOM_DIR .'/ol_fn_includes/ol_fields.php');
include_once(MGOM_DIR .'/ol_fn_includes/ol_select_opts.php');
include_once(MGOM_DIR .'/ol_fn_includes/opts_to_css.php');

/////////////////////////////////////////////////////////////////////



// graphical overlay types
function mgom_graphic_types($type = false) {
	$opts = array(
		'full_img_layer' 	=> __('Full image layer', 'mgom_ml'),
		'vert_split_layer' 	=> __('Vertical split layers', 'mgom_ml'),
		'horiz_split_layer' => __('Horizontal split layers', 'mgom_ml'),
		'crossing_layer' 	=> __('Crossing layer', 'mgom_ml'),
		'corner_slice' 		=> __('Corner slice', 'mgom_ml'),
		
		'single_border' 	=> __('Single-side border', 'mgom_ml'),
		'outlined_box' 		=> __('Outlined box', 'mgom_ml'),
		
		'central_shape' 	=> __('Central shape', 'mgom_ml'),
		'corner_shape' 		=> __('Corner shape', 'mgom_ml'),
		'icon' 				=> __('Standalone icon', 'mgom_ml'),
		
		'img_ol' 			=> __('Image layer', 'mgom_ml'),
		'img_fx' 			=> __('Image effects', 'mgom_ml'),
	);	
	
	if($type) {
		return (isset($opts[$type])) ? $opts[$type] : false;	
	} else {
		return $opts;	
	}
}

// textual overlay types
function mgom_txt_types($type = false) {
	$opts = array(
		'txt_block' 	=> __("Text block <small>(not for text under images)</small>", 'mgom_ml'),
		'title' 		=> __("Item's title", 'mgom_ml'),
		'descr' 		=> __("Item's excerpt", 'mgom_ml'),
		'separator' 	=> __("Separator", 'mgom_ml'),
		'button' 		=> __("Button", 'mgom_ml'),
		'socials' 		=> __("Social buttons", 'mgom_ml'),
		'custom_txt' 	=> __("Custom content", 'mgom_ml')
	);	
	
	if($type) {
		return (isset($opts[$type])) ? $opts[$type] : false;	
	} else {
		return $opts;	
	}
}

// overlay types
function mgom_types($type = false) {
	$opts = array_merge(mgom_txt_types(), mgom_graphic_types());  
	
	return ($type !== false) ? $opts[$type] : $opts;
}



//////////////////////////////////////////////////////////////////////



// fields for each type
function mgom_type_fields($type) {
	$opts = array(
		'full_img_layer' 	=> array('position', 'bg_color', 'bg_color_h', 'opacity', 'opacity_h', 'full_img_padding', 'full_img_padding_h', 'transitions', 'animation_time', 'easing', 'animation_delay'),
		'vert_split_layer' 	=> array('bg_color', 'bg_color_h', 'opacity', 'opacity_h', 'animation_time', 'easing', 'animation_delay'),
		'horiz_split_layer' => array('bg_color', 'bg_color_h', 'opacity', 'opacity_h', 'animation_time', 'easing', 'animation_delay'),
		'crossing_layer'	=> array('cross_pos', 'bg_color', 'bg_color_h', 'opacity', 'opacity_h', 'over_txt_block', 'animation_time', 'easing', 'animation_delay'),
		'corner_slice'		=> array('slice_pos', 'bg_color', 'bg_color_h', 'opacity', 'opacity_h', 'over_txt_block', 'animation_time', 'easing', 'animation_delay'),
		
		'single_border' 	=> array('singl_border_side', 'singl_border_show', 'border_width', 'border_color', 'border_color_h', 'opacity', 'opacity_h', 'over_txt_block', 'animation_time', 'easing', 'animation_delay'),
		'outlined_box' 		=> array('position', 'border_width', 'border_width_h', 'border_color', 'border_color_h', 'full_img_padding', 'full_img_padding_h', 'opacity', 'opacity_h', 'over_txt_block', 'transitions', 'animation_time', 'easing', 'animation_delay'),

		'central_shape' => array('cent_ol_shape', 'position','bg_color', 'bg_color_h', 'opacity', 'opacity_h', 'inner_icon', 'color', 'over_txt_block', 'transitions', 'animation_time', 'easing', 'animation_delay'),
		'corner_shape' 	=> array('corn_ol_shape', 'corner_pos', 'bg_color', 'opacity', 'opacity_h', 'inner_icon', 'color', 'over_txt_block', 'animation_time', 'easing', 'animation_delay'),
		'icon' 			=> array('icon_type', 'icon_position', 'font_size', 'font_size_h', 'color', 'color_h', 'opacity', 'opacity_h', 'over_txt_block', 'transitions', 'animation_time', 'easing', 'animation_delay'),

		'img_ol' 		=> array('img_ol_src', 'img_ol_bg_size', 'img_ol_pos', 'full_img_padding', 'position', 'opacity', 'opacity_h', 'over_txt_block', 'transitions', 'animation_time', 'easing', 'animation_delay'),
		'img_fx' 		=> array('img_zoom', 'grayscale', 'img_blur', 'img_no_borders', 'img_h_fx', 'animation_time', 'easing', 'animation_delay'),
		
		'title' 		=> array('txt_align', 'font_size', 'color', 'color_h', 'highlight', 'highlight_h', 'line_height', 'txt_styles', 'txt_vert_margin', 'font_family', 'animation_delay'),
		'descr' 		=> array('txt_align', 'font_size', 'color', 'color_h', 'highlight', 'highlight_h', 'line_height', 'txt_styles', 'txt_max_h', 'txt_vert_margin', 'font_family', 'animation_delay'),
		'separator' 	=> array('color', 'thickness', 'sep_style', 'txt_vert_margin', 'animation_delay'),
		'button' 		=> array('btn_txt', 'font_size', 'line_height', 'btn_full_width', 'btn_align', 'txt_styles', 'font_family', 'txt_padding', 'border_width', 'border_style', 'border_color', 'border_color_h', 'border_radius', 'bg_color', 'bg_color_h', 'color', 'color_h', 'txt_vert_margin', 'animation_delay'),
		'socials' 		=> array('socials_style', 'socials_align', 'color', 'color_h', 'highlight', 'highlight_h', 'font_size', 'line_height', 'txt_vert_margin', 'animation_delay'),
		'custom_txt' 	=> array('cust_txt', 'txt_align', 'font_size', 'color', 'color_h', 'highlight', 'highlight_h', 'opacity', 'opacity_h', 'line_height', 'txt_styles', 'txt_vert_margin', 'font_family', 'animation_delay'),
		'txt_block'		=> array('position', 'txt_behaviors', 'txt_visibility', 'txt_vert_center', 'bg_color', 'bg_color_h', 'opacity', 'opacity_h', 'txt_padding', 'transitions', 'animation_time', 'easing'),
	);	
	
	return $opts[$type];	
}



//////////////////////////////////////////////////////////////////////



// type block builder
function mgom_type_block($type, $values = false) {
	$name = mgom_types($type);
	if(!$name) {return '';}
	
	$fields = mgom_type_fields($type);
	$commands = ($type == 'txt_block') ? '' : '<span class="lcwp_move_row"></span><span class="lcwp_del_row"></span>';
	
	$code = '
	<div class="mgom_type_block tb_'.$type.'" rel="'.$type.'">
	<h4>
		'. $name .' 
		<div class="mgom_css_selector">  |  '. __('CSS selector', 'mgom_ml') .' <span></span></div>
		<div class="mgom_cmd">
			<small class="mgom_ec">(<em class="collapse">'. __('collapse', 'mgom_ml') .'</em><em class="expand" style="display: none;">'. __('expand', 'mgom_ml') .'</em>)</small>
			'.$commands.'
		</div>
	</h4>';

	foreach($fields as $field) {
		$val = (isset($values[$field])) ? $values[$field] : ''; 
		$code .= mgom_fields_builder($field, $val);
	}
	
	return $code . '<div class="mgom_btm_border_fix"></div></div>';
}


// overlay saved data to blocks
function mgom_saved_to_blocks($layers) {
	if(!is_array($layers)) {return '';}
	if(isset($layers['txt_block'])) {unset($layers['txt_block']);}
	
	$code = '';
	foreach($layers as $type => $values) {
		if($type != 'txt_block') {
			$code .= mgom_type_block($type, $values);
		}
	}
	
	return $code;
}


// JS ajax array to PHP proper array
function mgom_js_ajax_sanitize($data) {
	require_once(MG_DIR . '/functions.php');
	
	// base
	$init_arr = array(
		"graphic" => $data->graphic,
		"txt" => $data->txt,
	);
	
	$final_arr = array(
		"graphic" => array(),
		"txt" => array(),
	);
	
	foreach($init_arr as $subj => $values) {
		foreach($values as $type => $vals) {
			foreach($vals as $val) {

				if(strpos($val->name, '[]') === false) {
					$index = $val->name;
					$val = mg_sanitize_input($val->value);
				}
				else {
					$index = str_replace('[]', '', $val->name);
					$val = array( mg_sanitize_input($val->value) );
				}
				
				if(isset($final_arr[$subj][$type][$index])) {
					$final_arr[$subj][$type][$index][] = $val[0];
				} else {
					$final_arr[$subj][$type][$index] = $val;	
				}
			}
		}
	}
	
	
	return $final_arr;	
}


// recalculate serialized elements length - fix for DB get issues 
function mgom_fix_serialization($string) {
	//return preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $string); // global chars recalculation
	return str_replace('&amp;', '&', $string);	
}



////////////////////////////////////////////////////////////////////////////



// create dynamic css file for all the overlays
function mgom_create_ol_css() {	
	ob_start();
	require_once(MGOM_DIR.'/frontend_css.php');
	
	$css = ob_get_clean();
	if(trim($css) != '') {
		if(!@file_put_contents(MGOM_DIR.'/css/overlays.css', $css, LOCK_EX)) {$error = true;}
	}
	else {
		if(file_exists(MGOM_DIR.'/css/'.$ol_id.'.css'))	{ unlink(MGOM_DIR.'/css/overlays.css'); }
	}
	
	if(isset($error)) {return false;}
	else {return true;}
}
