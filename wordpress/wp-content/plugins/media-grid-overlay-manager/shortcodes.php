<?php
////////// SHORCODES LIST

// [mgom-item-attr] 
//// print the custom form
function mgom_item_attr_shortcode($atts, $content = null) {
	include_once(MG_DIR . '/functions.php');

	extract( shortcode_atts( array(
		'name' => '', // CASE SENSITIVE!
		'label' => 0,
		'icon' => 0
	), $atts ) );
	
	// must have a name and $GLOBALS['mg_item_id'] must exist
	if(!$name || !isset($GLOBALS['mg_item_id'])) {return '';}
	
	$code = '';
	$item_id = $GLOBALS['mg_item_id'];
	$type = (get_post_type($item_id) == 'product') ? 'woocom' : get_post_meta($item_id, 'mg_main_type', true);
	if($type == 'single_img') {$type = 'image';}

	if($type != 'woocom') {
		$cust_opt = mg_item_copts_array($type, $item_id);
		
		// avoid too many queries 
		if($icon) {
			$type_opts = get_option('mg_'.$type.'_opt');
			$icons = get_option('mg_'.$type.'_opt_icon');
		}
		else {$type_opts = array($name);}
		

		if(count($cust_opt) > 0) {
			$a = 0;
			foreach($type_opts as $opt) {
				if(isset($cust_opt[$opt]) && $name == $opt) {				
					if($icon && isset($icons[$a]) && !empty($icons[$a])) {
						$code .= '<i class="mg_cust_opt_icon fa '.$icons[$a].'">&nbsp;</i> ';	
					}
					
					if($label) {
						$code .= '<span class="mgom_ol_attr_label">'.mg_wpml_string($type, $opt).'</span> ';	
					}
					
					$code .= do_shortcode(str_replace(array('&lt;', '&gt;'), array('<', '>'), $cust_opt[$opt]));
					break;
				}
				$a++;
			}
		}
	}
	
	// woocomm attributes
	else {
		$wc_prod = new WC_Product($item_id);
		$prod_attr = mg_wc_prod_attr($wc_prod);
		
		if(is_array($prod_attr) && count($prod_attr) > 0 && !get_option('mg_wc_hide_attr')) {
	
			foreach($prod_attr as $attr => $val) {					
				if($attr  == $name) {
					if($icon) {
						$icon = get_option('mg_wc_attr_'.sanitize_title($attr).'_icon');
						$code .= (!empty($icon)) ? '<i class="mg_cust_opt_icon fa '.$icon.'">&nbsp;</i> ': '';
					}
					if($label) {
						$code .= '<span class="mgom_ol_attr_label">'.$attr.'</span> ';	
					}
					
					$code .= do_shortcode(implode(', ', $val));
					break;
				}
			}
		}
	}
	
	return $code;
}
add_shortcode('mgom-item-attr', 'mgom_item_attr_shortcode');




// [mgom-type-txt] 
//// print the custom form
function mgom_type_txt_shortcode($atts, $content = null) {
	include_once(MG_DIR . '/functions.php');

	extract( shortcode_atts( array(
		'type' => ''
	), $atts ) );
	
	// must have a name and $GLOBALS['mg_item_id'] must exist
	if(!$type || !isset($GLOBALS['mg_item_id'])) {return '';}
	
	$types = mg_item_types();
	unset($types['spacer'], $types['inl_text'], $types['inl_slider']);
	
	$item_id = $GLOBALS['mg_item_id'];
	$curr_type = (get_post_type($item_id) == 'product') ? 'woocom' : get_post_meta($item_id, 'mg_main_type', true);

	foreach($types as $id => $name) {
		if($id == $curr_type && $curr_type == $type) {
			return nl2br(do_shortcode($content));
			break;	
		}
	}

	return '';
}
add_shortcode('mgom-type-txt', 'mgom_type_txt_shortcode');