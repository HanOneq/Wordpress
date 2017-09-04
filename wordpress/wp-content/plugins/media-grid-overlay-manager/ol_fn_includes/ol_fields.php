<?php 

// all types option - global cumulative array
function mgom_types_opt($type) {
	$opts = array(
		'cent_ol_shape' => array(
			'type' => 'select',
			'label' => __("Shape", 'mgom_ml'),
			'opts' => mgom_central_shapes()
		),
		'corn_ol_shape' => array(
			'type' => 'select',
			'label' => __("Shape", 'mgom_ml'),
			'opts' => mgom_corner_shapes()
		),
		'icon_type' => array(
			'type' => 'select',
			'label' => __("Icon type", 'mgom_ml'),
			'opts' => mgom_inner_icons(true)
		),
		
		
		'bg_color' => array(
			'type' => 'color',
			'label' => __("Background color", 'mgom_ml'),
			'def' => '#ffffff'
		),
		'bg_color_h' => array(
			'type' => 'color',
			'label' => __("Background color (on hover)", 'mgom_ml'),
			'def' => '#ffffff',
			'optional' => true
		),
		'color' => array(
			'type' => 'color',
			'label' => __("Color", 'mgom_ml'),
			'def' => '#222222'
		),
		'color_h' => array(
			'type' => 'color',
			'label' => __("Color (on hover)", 'mgom_ml'),
			'def' => '#383838',
			'optional' => true
		),
		'highlight' => array(
			'type' => 'color',
			'label' => __("Highlight <small>(leave empty to discard)</small>", 'mgom_ml'),
			'def' => '',
			'optional' => true
		),
		'highlight_h' => array(
			'type' => 'color',
			'label' => __("Highlight on hover <small>(leave empty to discard)</small>", 'mgom_ml'),
			'def' => '',
			'optional' => true
		),
		'opacity' => array(
			'type' => 'slider',
			'label' => __("Opacity", 'mgom_ml'),
			'min_val' => '0',
			'max_val' => '100',
			'step' => '10',
			'value' => '%',
			'def' => '70'
		),
		'opacity_h' => array(
			'type' => 'slider',
			'label' => __("Opacity (on hover)", 'mgom_ml'),
			'min_val' => '0',
			'max_val' => '100',
			'step' => '10',
			'value' => '%',
			'def' => '100',
			'optional' => true
		),
		
		
		'position' => array(
			'type' => 'select',
			'label' => __("Initial position", 'mgom_ml'),
			'opts' => mgom_positions()
		),
		'position_h' => array(
			'type' => 'select',
			'label' => __("Position (on hover)", 'mgom_ml'),
			'opts' => mgom_positions()
		),
		'icon_position' => array(
			'type' => 'select',
			'label' => __("Position", 'mgom_ml'),
			'opts' => mgom_icon_positions()
		),
		'corner_pos' => array(
			'type' => 'select',
			'label' => __("Corner", 'mgom_ml'),
			'opts' => mgom_corners()
		),
		'cross_pos' => array(
			'type' => 'select',
			'label' => __("Initial position", 'mgom_ml'),
			'opts' => mgom_positions(array('center', 'top', 'left', 'right', 'bottom', 'mouse_dir'))
		),
		'slice_pos' => array(
			'type' => 'select',
			'label' => __("Position", 'mgom_ml'),
			'opts' => mgom_positions(array('center', 'top', 'left', 'right', 'bottom', 'mouse_dir'))
		),
		'singl_border_side' => array(
			'type' => 'select',
			'label' => __("Border side", 'mgom_ml'),
			'opts' => mgom_positions(array('center', 'top-left', 'top-right', 'bottom-right', 'bottom-left', 'mouse_dir'))
		),
		'singl_border_show' => array(
			'type' => 'select',
			'label' => __("Show from", 'mgom_ml'),
			'opts' => mgom_positions(array('top-left', 'top-right', 'bottom-right', 'bottom-left', 'mouse_dir'))
		),
		'inner_icon' => array(
			'type' => 'select',
			'label' => __("Icon", 'mgom_ml'),
			'opts' => mgom_inner_icons()
		),
		'over_txt_block' => array(
			'type' => 'bool',
			'label' => __("Layer over text block?", 'mgom_ml'),
		),
		
		
		'img_ol_src' => array(
			'type' => 'text',
			'label' => __("Image URL", 'mgom_ml') . ' <a href="javascript:void(0)" id="mgom_img_ol_wizard">('. __('set image', 'mgom_ml') .')</a>',
		),
		'img_ol_bg_size' => array(
			'type' => 'select',
			'label' => __("Image size", 'mgom_ml'),
			'opts' => array(
				'auto' 		=> __("auto", 'mgom_ml'), 
				'cover' 	=> __("fill", 'mgom_ml'), 
				'contain' 	=> __("fit", 'mgom_ml')
			),
		),
		'img_ol_pos' => array(
			'type' => 'select',
			'label' => __("Image position <small>(not for background-size = cover)</small>", 'mgom_ml'),
			'opts' => mgom_positions(array('mouse_dir')),
		),
		
		
		'img_zoom' => array(
			'type' => 'slider',
			'label' => __("Image zoom (on hover)", 'mgom_ml'),
			'min_val' => '0',
			'max_val' => '40',
			'step' => '5',
			'value' => '%',
			'def' => '0'
		),
		'grayscale' => array(
			'type' => 'bool',
			'label' => __("Grayscale (by default)", 'mgom_ml'),
		),
		'img_blur' => array(
			'type' => 'bool',
			'label' => __("Image blur (on hover)", 'mgom_ml'),
		),
		'img_no_borders' => array(
			'type' => 'bool',
			'label' => __("Remove borders (on hover)", 'mgom_ml'),
		),
		'img_h_fx' => array(
			'type' => 'select',
			'label' => __("Hover effects", 'mgom_ml'),
			'opts' =>  mgom_img_h_fx(),
			'optional' => true
		),
		
		
		'font_size' => array(
			'type' => 'slider',
			'label' => __("Font size", 'mgom_ml'),
			'min_val' => '8',
			'max_val' => '50',
			'step' => '1',
			'value' => 'px',
			'def' => '14'
		),
		'font_size_h' => array(
			'type' => 'slider',
			'label' => __("Font size (on hover)", 'mgom_ml'),
			'min_val' => '8',
			'max_val' => '50',
			'step' => '1',
			'value' => 'px',
			'def' => '14',
			'optional' => true
		),
		
		
		'animation_time' => array(
			'type' => 'slider',
			'label' => __("Animation time", 'mgom_ml'),
			'min_val' => '0',
			'max_val' => '1500',
			'step' => '50',
			'value' => '<span title="milliseconds">ms</span>',
			'def' => '400'
		),
		'easing' => array(
			'type' => 'select',
			'label' => __("Animation easing", 'mgom_ml'),
			'opts' =>  mgom_easings()
		),
		'transitions' => array(
			'type' => 'select',
			'label' => __("Transitions", 'mgom_ml'),
			'opts' =>  mgom_transitions(),
			'multiple' => true,
			'optional' => true
		),
		'animation_delay' => array(
			'type' => 'slider',
			'label' => __("Animation delay", 'mgom_ml'),
			'min_val' => '0',
			'max_val' => '1000',
			'step' => '50',
			'value' => '<span title="milliseconds">ms</span>',
			'def' => '0'
		),
		
		
		'thickness' => array(
			'type' => 'slider',
			'label' => __("Thickness", 'mgom_ml'),
			'min_val' => '1',
			'max_val' => '4',
			'step' => '1',
			'value' => 'px',
			'def' => '1'
		),
		'sep_style' => array(
			'type' => 'select',
			'label' => __("Style", 'mgom_ml'),
			'opts' => mgom_border_styles(),
		),
		
		'socials_style' => array(
			'type' => 'select',
			'label' => __("Style", 'mgom_ml'),
			'opts' => mgom_social_btn_styles()
		),
		'socials_align' => array(
			'type' => 'select',
			'label' => __("Alignment", 'mgom_ml'),
			'opts' => mgom_socials_align()
		),
		
		
		'txt_behaviors' => array(
			'type' => 'select',
			'label' => __("Layers behavior <small>(only for bottom position)</small>", 'mgom_ml'),
			'opts' => mgom_txt_behaviors(),
		),
		'txt_visibility' => array(
			'type' => 'select',
			'label' => __("Texts visibility", 'mgom_ml'),
			'opts' =>  array(
				'always' 	=> __("always visible", 'mgom_ml'), 
				'hide' 		=> __("hidden by default", 'mgom_ml'), 
				'hide_h' 	=> __("hidden on hover", 'mgom_ml')
			),
		),
		'txt_vert_center' => array(
			'type' => 'bool',
			'label' => __("Text vertically centered?", 'mgom_ml'),
		),
		'txt_max_h' => array(
			'type' => 'slider',
			'label' => __("Text max height", 'mgom_ml'),
			'min_val' => '20',
			'max_val' => '600',
			'step' => '20',
			'value' => 'px',
			'def' => '600'
		),
		'txt_padding' => array(
			'type' => 'padding_arr',
			'label' => __("Padding <small>(top right bottom left)</small>", 'mgom_ml'),
			'value' => 'px',
			'optional' => true
		),
		'txt_vert_margin' => array(
			'type' => 'vert_margin_arr',
			'label' => __("Vertical margins <small>(top bottom)</small>", 'mgom_ml'),
			'value' => 'px',
			'optional' => true
		),
		'txt_align' => array(
			'type' => 'select',
			'label' => __("Text alignment", 'mgom_ml'),
			'opts' => mgom_txt_align(),
		), 
		'line_height' => array(
			'type' => 'slider',
			'label' => __("Line-height", 'mgom_ml'),
			'min_val' => '10',
			'max_val' => '50',
			'step' => '1',
			'value' => 'px',
			'def' => '19'
		),
		'txt_styles' => array(
			'type' => 'select',
			'label' => __("Text styles", 'mgom_ml'),
			'opts' =>  array(
				'bold' => __("bold", 'mgom_ml'), 
				'italic' => __("italic", 'mgom_ml'), 
				'uppercase' => __("uppercase", 'mgom_ml')
			),
			'multiple' => true,
			'optional' => true
		),
		'font_family' => array(
			'type' => 'text',
			'label' => __("Font family", 'mgom_ml'),
			'optional' => true
		),
		'btn_txt' => array(
			'type' => 'text',
			'label' => __("Text", 'mgom_ml')
		),
		'btn_full_width' => array(
			'type' => 'bool',
			'label' => __("Full width?", 'mgom_ml')
		),
		'btn_align' => array(
			'type' => 'select',
			'label' => __("Alignment", 'mgom_ml'),
			'opts' => mgom_txt_align(false),
		),
		'border_radius' => array(
			'type' => 'slider',
			'label' => __("Border radius", 'mgom_ml'),
			'min_val' => '0',
			'max_val' => '50',
			'step' => '1',
			'value' => 'px',
			'def' => '2'
		),
		'border_width' => array(
			'type' => 'slider',
			'label' => __("Border width", 'mgom_ml'),
			'min_val' => '0',
			'max_val' => '20',
			'step' => '1',
			'value' => 'px',
			'def' => '1'
		),
		'border_width_h' => array(
			'type' => 'slider',
			'label' => __("Border width (on hover)", 'mgom_ml'),
			'min_val' => '0',
			'max_val' => '20',
			'step' => '1',
			'value' => 'px',
			'def' => '1'
		),
		'border_style' => array(
			'type' => 'select',
			'label' => __("Border Style", 'mgom_ml'),
			'opts' => mgom_border_styles(),
		),
		'border_color' => array(
			'type' => 'color',
			'label' => __("Border color", 'mgom_ml'),
			'def' => '#444444'
		),
		'border_color_h' => array(
			'type' => 'color',
			'label' => __("Border color (on hover)", 'mgom_ml'),
			'def' => '#666666',
			'optional' => true
		),
		'cust_txt' => array(
			'type' => 'textarea',
			'label' => __("Custom text", 'mgom_ml')
		),
		
		'full_img_padding' => array(
			'type' => 'slider',
			'label' => __("Edges margin", 'mgom_ml'),
			'min_val' => '0',
			'max_val' => '50',
			'step' => '1',
			'value' => 'px',
			'def' => '0'
		),
		'full_img_padding_h' => array(
			'type' => 'slider',
			'label' => __("Edges margin (on hover)", 'mgom_ml'),
			'min_val' => '0',
			'max_val' => '50',
			'step' => '1',
			'value' => 'px',
			'def' => '0'
		),
	);
	
	return $opts[$type];	
}
