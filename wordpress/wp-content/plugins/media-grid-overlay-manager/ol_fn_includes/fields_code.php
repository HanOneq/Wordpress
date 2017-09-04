<?php 
// fields builder

function mgom_fields_builder($field, $value = '') {
	$data = mgom_types_opt($field);
	$pre_code = ($data['type'] == 'textarea') ? '<div class="mgom_full_field">' : '<div class="mgom_field">';
	$pre_code .= '<label>'.$data['label'].'</label>';
	
	$def_val = (isset($data['def'])) ? $data['def'] : '';
	if((empty($value) && $value !== '0') && isset($def_val)) {$value = $def_val;}
	
	$optional = (isset($data['optional'])) ? 'mgom_optional_f' : '';
	
	switch($data['type']) {

		case 'color':
			$code = '
			<div class="lcwp_colpick">
				<span class="lcwp_colblock" style="background-color: '.$value.';"></span>
				<input type="text" name="'.$field.'" value="'.$value.'" class="mgom_f_'.$field.' '.$optional.'" autocomplete="off" />
			</div>';
			break;
			
		case 'slider':
			$code = '
			<div class="lcwp_slider" step="'.$data['step'].'" max="'.$data['max_val'].'" min="'.$data['min_val'].'"></div>
			<input type="text" value="'.$value.'" name="'.$field.'" class="lcwp_slider_input mgom_f_'.$field.' '.$optional.'" autocomplete="off" />
			<span>'.$data['value'].'</span>';
			break;
		
		case 'select':
			if(isset($data['multiple'])) { 
				$multiple = 'multiple="multiple"';
				$mfn = '[]';
			} else {
				$multiple = '';
				$mfn = '';
			}
			
			$options = '';
			foreach($data['opts'] as $k => $v) {
				if(is_array($value)) {
					$sel = (in_array($k, $value)) ? 'selected="selected"' : ''; 
				} else {
					$sel = ($value == $k) ? 'selected="selected"' : '';	
				}
				
				$options .= '<option value="'.$k.'" '.$sel.'>'.$v.'</option>';
			}
			
			$code = '
			<select name="'.$field.$mfn.'" class="lcweb-chosen mgom_f_'.$field.' '.$optional.'" '.$multiple.' autocomplete="off">
				'.$options.'
			</select> ';
			break;
			
		case 'bool':
			$sel = ($value == 1) ? 'checked="checked"' : '';
			$code = '<input type="checkbox" value="1" name="'.$field.'" class="ip-checkbox mgom_f_'.$field.'" '.$sel.' autocomplete="off" />';
			break;	
		
		case 'textarea':
			$code = '<textarea name="'.$field.'" class="mgom_f_'.$field.' '.$optional.'">'.$value.'</textarea>';
			break;	
			
		case 'padding_arr':
			if(!is_array($value)) {$value = array('','','','');}
			
			$code = '
			<input type="text" value="'.$value[0].'" name="'.$field.'[]" class="lcwp_slider_input mgom_f_'.$field.' '.$optional.'" maxlength="2" autocomplete="off" />
			<input type="text" value="'.$value[1].'" name="'.$field.'[]" class="lcwp_slider_input mgom_f_'.$field.' '.$optional.'" maxlength="2" autocomplete="off" />
			<input type="text" value="'.$value[2].'" name="'.$field.'[]" class="lcwp_slider_input mgom_f_'.$field.' '.$optional.'" maxlength="2" autocomplete="off" />
			<input type="text" value="'.$value[3].'" name="'.$field.'[]" class="lcwp_slider_input mgom_f_'.$field.' '.$optional.'" maxlength="2" autocomplete="off" />
			<span>'.$data['value'].'</span>';
			break;
			
		case 'vert_margin_arr':
			if(!is_array($value)) {$value = array('','');}
			
			$code = '
			<input type="text" value="'.$value[0].'" name="'.$field.'[]" class="lcwp_slider_input mgom_f_'.$field.' '.$optional.'" maxlength="3" autocomplete="off" />
			<input type="text" value="'.$value[1].'" name="'.$field.'[]" class="lcwp_slider_input mgom_f_'.$field.' '.$optional.'" maxlength="3" autocomplete="off" />
			<span>'.$data['value'].'</span>';
			break;	

		default : // text
			$code = '<input type="text" name="'.$field.'" class="mgom_f_'.$field.' '.$optional.'" value="'.$value.'" autocomplete="off" />';
			break;
	}
	
	return $pre_code . $code . '</div>';
}

