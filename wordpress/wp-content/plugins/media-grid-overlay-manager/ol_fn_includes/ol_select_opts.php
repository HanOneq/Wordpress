<?php 

// central overlay shapes 
function mgom_central_shapes() {
	return array(
		'circle' 			=> __('circle', 'mgom_ml'),
		'diamond' 			=> __('diamond', 'mgom_ml'),
		'exagon' 			=> __('exagon', 'mgom_ml'),
		'octagon' 			=> __('octagon', 'mgom_ml'),
		'outline_circle' 	=> __('outlined circle', 'mgom_ml'),
		'outline_diamond' 	=> __('outlined diamond', 'mgom_ml'),
	);
}


// corner overlay shapes 
function mgom_corner_shapes() {
	return array(
		'corner_triangle' => __('triangle', 'mgom_ml'),
		'corner_square' => __('square', 'mgom_ml'),
		'corner_circle' => __('circle', 'mgom_ml')
	);	
}


// positions
function mgom_positions($strip = array()) {
	$opts = array(
		'center' 		=> __("center", 'mgom_ml'),
		'top-left' 		=> __("top-left", 'mgom_ml'),
		'top' 			=> __("top", 'mgom_ml'),
		'top-right'		=> __("top-right", 'mgom_ml'),
		'right' 		=> __("right", 'mgom_ml'),
		'bottom-right' 	=> __("bottom-right", 'mgom_ml'),
		'bottom' 		=> __("bottom", 'mgom_ml'),
		'bottom-left' 	=> __("bottom-left", 'mgom_ml'),
		'left' 			=> __("left", 'mgom_ml'),
		'mouse_dir' 	=> __("on mouse direction", 'mgom_ml'),
	);	
	
	if(!empty($strip)) {
		foreach($strip as $to_strip) {
			if(isset($opts[$to_strip])) {unset($opts[$to_strip]);}	
		}
	}
	
	return $opts;
}


// positions
function mgom_icon_positions() {
	return array(
		'center' => __("center", 'mgom_ml'),
		'top-left' => __("top-left corner", 'mgom_ml'),
		'top-right' => __("top-right corner", 'mgom_ml'),
		'bottom-right' => __("bottom-right corner", 'mgom_ml'),
		'bottom-left' => __("bottom-left corner", 'mgom_ml')
	);	
}


// corners
function mgom_corners() {
	$opts = array(
		'top-left' => __("top-left", 'mgom_ml'),
		'top-right' => __("top-right", 'mgom_ml'),
		'bottom-right' => __("bottom-right", 'mgom_ml'),
		'bottom-left' => __("bottom-left", 'mgom_ml')
	);	
	
	return $opts;
}


// inner icons
function mgom_inner_icons($always_icon = false) {
	$opts = array(
		'none' => __('none', 'mgom_ml'),
		'subj_icon' => __('Item type icon', 'mgom_ml'),
		'magnfier_icon' => __('Magnifier icon', 'mgom_ml'),
		'plus_icon' => __('Plus icon', 'mgom_ml'),
		'eye_icon' => __('Eye icon', 'mgom_ml')
	);
		
	if($always_icon) {unset($opts['none']);}	
	return $opts;
}


// image hover effects
function mgom_img_h_fx() {
	return array(
		'' 				=> __("(no effect)", 'mgom_ml'),
		'zoom-in-hide' 	=> __("zoom-in and hide", 'mgom_ml'),
		'zoom-out-hide' => __("zoom-out and hide", 'mgom_ml'),
		
		'flip-vert' 	=> __("flip vertically", 'mgom_ml'),
		'flip-horiz' 	=> __("flip horizontally", 'mgom_ml'),
		
		'door-top'		=> __("door upward", 'mgom_ml'),
		'door-right'	=> __("door rightward", 'mgom_ml'),
		'door-bottom'	=> __("door downward", 'mgom_ml'),
		'door-left'		=> __("door leftward", 'mgom_ml'),
	);			
}


// easings
function mgom_easings() {
	return array(
		'ease' => __("ease", 'mgom_ml'),
		'linear' => __("linear", 'mgom_ml'),
		'ease-in' => __("ease-in", 'mgom_ml'),
		'ease-out' => __("ease-out", 'mgom_ml'),
		'ease-in-out' => __("ease-in-out", 'mgom_ml'),
		'ease-in-back' => __("ease-in-back", 'mgom_ml'),
		'ease-out-back' => __("ease-out-back", 'mgom_ml'),
		'ease-in-out-back' => __("ease-in-out-back", 'mgom_ml')
	);	
}


// transions
function mgom_transitions() {
	return array(
		'zoom-in' 		=> __("zoom-in", 'mgom_ml'),
		'zoom-out' 		=> __("zoom-out", 'mgom_ml'),
		'slide-vert' 	=> __("flip vertically", 'mgom_ml'),
		'slide-horiz' 	=> __("flip horizontally", 'mgom_ml'),
		'flip-vert' 	=> __("spin vertically", 'mgom_ml'),
		'flip-horiz' 	=> __("spin horizontally", 'mgom_ml'),
		'rotate' 		=> __("rotate", 'mgom_ml'),
		
		'door-top'		=> __("door upward", 'mgom_ml'),
		'door-right'	=> __("door rightward", 'mgom_ml'),
		'door-bottom'	=> __("door downward", 'mgom_ml'),
		'door-left'		=> __("door leftward", 'mgom_ml'),
		
		'upward'	=> __("upward", 'mgom_ml'),
		'leftward'	=> __("leftward", 'mgom_ml'),
		'downward'	=> __("downward", 'mgom_ml'),
		'rightward'	=> __("rightward", 'mgom_ml'),
	);	
}


// text layer behaviors
function mgom_txt_behaviors() {
	return array(
		'none' 			=> __("(standard behavior)", 'mgom_ml'),
		'show_all' 		=> __("always visible + use contents height", 'mgom_ml'),
		'show_title'	=> __("always show title + use contents height", 'mgom_ml'),
		'show_title_fh' => __("always show title + full height", 'mgom_ml'),
		'hide_all' 		=> __("show on hover + use contents height", 'mgom_ml'),
		'sh_vert_center'=> __("slide on hover vertically centered + use contents height", 'mgom_ml'),
		'curtain'	 	=> __("curtain effect", 'mgom_ml')
	);	
}


// text alignments
function mgom_txt_align($justify = true) {
	$opts = array(
		'left' => __("left", 'mgom_ml'),
		'center' => __("center", 'mgom_ml'),
		'right' => __("right", 'mgom_ml')
	);	
	if($justify) {
		$opts['justify'] = __("justify", 'mgom_ml');	
	}
	
	return $opts;
}


// social button styles
function mgom_social_btn_styles() {
	return array(
		'minimal' => __("minimal", 'mgom_ml'),
		'rounded' => __("rounded", 'mgom_ml'),
		'squared' => __("squared", 'mgom_ml')
	);	
}


// socials alignment
function mgom_socials_align() {
	return array(
		'left'	 => __("left", 'mgom_ml'),
		'center' => __("center", 'mgom_ml'),
		'right'	 => __("right", 'mgom_ml')
	);
}


// border styles
function mgom_border_styles() {
	return array(
		'solid' => __("solid", 'mgom_ml'),
		'dotted' => __("dotted", 'mgom_ml'),
		'dashed' => __("dashed", 'mgom_ml'),
		'double' => __("double", 'mgom_ml')
	);
}
