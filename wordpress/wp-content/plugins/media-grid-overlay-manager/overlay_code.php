<?php 
////////////////////////////////////////////////
//// OVERLAY FRONTEND CODE /////////////////////

// title plceholder 	-> %MG-TITLE-OL%
// descr placeholder 	-> %MG-DESCR-OL%
// socials placeholder	-> %MG-SOCIALS-OL%

function mgom_ol_frontend_code($ol_id, $title_under = false) {
	include_once(MGOM_DIR . '/functions.php');
	
	$data = get_term($ol_id, 'mgom_overlays');	
	$code = array('graphic' => '', 'txt' => '', 'img_fx_elem' => '', 'txt_vis_class' => '');	
	$lc = 0;
	
	if(!$data || empty($data->description)) {return $code;}
	else {$layers = unserialize(mgom_fix_serialization($data->description));}

	/////////////////////////////////////////////////////////////////////////////////
	// graphic layers
	if(is_array($layers['graphic'])) {
		foreach($layers['graphic'] as $type => $opts) {
			$contents  = '';
			$classes = array();
			
			// split layers
			if($type == 'vert_split_layer' || $type == 'horiz_split_layer') {
				$contents  = '<div></div>';	
			}
			
			// crossing layer
			if($type == 'crossing_layer') {
				$classes[] = 'mgom_'.$opts['cross_pos'];
			}
			
			// corner slice
			if($type == 'corner_slice') {
				$classes[] = 'mgom_'.$opts['slice_pos'];	
			}
			
			// single border
			if($type == 'single_border') {
				$classes[] = 'mgom_sb_'.$opts['singl_border_side'].'_side';	
				$classes[] = 'mgom_sb_from_'.$opts['singl_border_show'];	
			}
			
			// corners
			elseif($type == 'corner_shape') {
				$contents  = '<span></span>';
				$classes[] = 'mgom_'.$opts['corn_ol_shape'];
				$classes[] = 'mgom_'.$opts['corner_pos']; 	
				$classes[] = 'mgom_'.$opts['inner_icon'];
			}
			
			// shapes
			else if($type == 'central_shape') {
				$contents  = '<div><span></span></div>';
				$classes[] = 'mgom_'.$opts['cent_ol_shape'];
				$classes[] = 'mgom_'.$opts['inner_icon'];
			}
			
			// icons
			else if($type == 'icon') {
				$contents  = '<span></span>';
				$classes[] = 'mgom_icon_layer';
				$classes[] = 'mgom_'.$opts['icon_type'];
			}
			
			// mouse direction class
			if(isset($opts['position']) && $opts['position'] == 'mouse_dir') {
				$classes[] = 'mgom_mouse_dir';	
			}
			
			if($type != 'img_fx') {
				$code['graphic'] .= '<div class="mgom_layer mgom_'.$type.' mgom_'.$data->term_id.'_'.$lc.' '.implode(' ', $classes).'">'.$contents.'</div>';	
			}
			
			$lc++;
		}
		
		// if image and overlays will scroll on top of text
		if(count($code['graphic']) > 0 && count($layers['txt']) > 1 && !$title_under) {
			if($layers['txt']['txt_block']['position'] == 'bottom' && $layers['txt']['txt_block']['txt_behaviors'] == 'curtain') {
				$code['graphic'] = '<div class="mgom_graphic_wrap">'. $code['graphic'] . '</div>';	
			}
		}
	}
	


	/////////////////////////////////////////////////////////////////////////////////////////
	// textual layers
	if(count($layers['txt']) > 1) {
		foreach($layers['txt'] as $type => $opts) {
			
			// contents switch
			if($type == 'title') {
				$content = '%MG-TITLE-OL%';
			}
			elseif($type == 'descr') {
				$content = '%MG-DESCR-OL%';
			}
			elseif($type == 'custom_txt') 	{
				$content = str_replace(array('&apos;', '&quot;', '&lt;', '&gt;'), array('\'', '"', '<', '>'), $opts['cust_txt']);
			}
			elseif($type == 'button') {
				$content = str_replace(array('&apos;', '&quot;', '&lt;', '&gt;'), array('\'', '"', '<', '>'), $opts['btn_txt']);
			}		
			elseif($type == 'socials') {
				$content = '<div class="mgom_'.$opts['socials_style'].'_socials mgom_soc_align_'.$opts['socials_align'].'">%MG-SOCIALS-OL%</div>';
			}
			else {$content = '';}
			
			// highlight wrap
			if((isset($opts['highlight']) && !empty($opts['highlight'])) || (isset($opts['highlight_h']) && !empty($opts['highlight_h']))) {
				if(in_array($type, array('title', 'descr', 'custom_txt'))) {
					$content = '<mark class="mgom_mark">'. $content . '</mark>';	
				} else {
					$content = str_replace('%MG-SOCIALS-OL%', '<mark class="mgom_mark">%MG-SOCIALS-OL%</mark>', $content);		
				}
			}
			
			// add description wrapper to allow max-height shortening
			else {
				if($type == 'descr') {
					$content = '<div style="display: inline;">'. $content . '</div>';		
				}
			}
			
			$code['txt'] .= '<div class="mgom_layer mgom_'.$type.' mgom_'.$data->term_id.'_'.$lc.'">'.$content.'</div>';	
			$lc++;
		}
		
		if(!$title_under) {
			$classes = array();
			$pos = $layers['txt']['txt_block']['position'];
			$behav = (isset($layers['txt']['txt_block']['txt_behaviors'])) ? $layers['txt']['txt_block']['txt_behaviors'] : 'none';
			
			// custom behavior classes
			if($pos == 'bottom' && $behav != 'none')  {
				$code['txt_vis_class'] .= ' mgom_txt_vis mgom_'.$behav;
			}
			
			// center vertically	
			if(isset($layers['txt']['txt_block']['txt_vert_center'])) {
				if($pos == 'bottom' && !in_array($behav, array('none', 'show_title_fh'))) {
					// do nothing	
				} else {
					$code['txt_vis_class'] .= ' '.$code['txt_vis_class'] . ' mgom_vc_txt';	
				}
			}
			
			// mouse direction class
			if($pos == 'mouse_dir') {
				$classes[] = 'mgom_mouse_dir';	
			}
			
			$code['txt'] = '<div class="mgom_txt_wrap mgom_'.$data->term_id.'_'.$lc.' '.implode(' ', $classes).'">
				'. $code['txt'] .'
			</div>';
		}
	}
	
	
	
	////////////////////////////////////
	// image effects 
	if(isset($layers['graphic']['img_fx'])) {
		$opts = $layers['graphic']['img_fx'];
		$fx = array();
		$val_param = ' ';
				
		if(isset($opts['grayscale']) && !empty($opts['grayscale'])) {
			$fx[] = 'grayscale';
		}
		if(isset($opts['img_blur']) && !empty($opts['img_blur'])) {
			$fx[] = 'blur';
		}	
		if(isset($opts['img_h_fx']) && !empty($opts['img_h_fx'])) {
			$fx[] = $opts['img_h_fx'];	
		}
		
		$timing = (isset($opts['animation_time']) && !empty($opts['animation_time'])) ? (int)$opts['animation_time'] : 400;
		$val_param .= 'mgom_timing="'.$timing.'"';
		
		$final_str = 'mgom_fx="'.implode(' ', $fx).'" '.$val_param;
		
		if(count($fx) > 0) {
			$code['img_fx_elem'] = $final_str;
		}
	}

	return $code;
}



////////////////////////////////////////////////
//// FILTER REPLACING PLACEHOLDERS /////////////

function mgom_txt_management($txt, $item_id, $preview_mode) {
	
	if($preview_mode) {
		$descr = 'dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.';
		
		$txt = str_replace('%MG-TITLE-OL%', 'Lorem ipsum', $txt);
		$txt = str_replace('%MG-DESCR-OL%', $descr, $txt);	
		
		$code = '';
		if(get_option('mg_facebook')) {$code .= "<span class='mgom_fb'></span>";}
		if(get_option('mg_twitter')) {$code .= "<span class='mgom_tw'></span>";}
		if(get_option('mg_pinterest')) {$code .= "<span class='mgom_pt'></span>";}
		if(get_option('mg_googleplus') && !get_option('mg_disable_dl')) {$code .= "<span class='mgom_gp'></span>";}
		
		$txt = str_replace('%MG-SOCIALS-OL%', $code, $txt);	
		
		// woocommerce price placeholder
		if(strpos($txt, '%WC-PRODUCT-PRICE%') !== false) {
			$txt = str_replace('%WC-PRODUCT-PRICE%', '100.00 $', $txt);		
		}
	}
	
	else {
		include_once(MG_DIR . '/functions.php');
		$GLOBALS['mg_item_id'] = $item_id; // global for attribute shortcode
		
		// do_shortcode to allow MGOM attr execution
		$txt = do_shortcode($txt);
		
		/*** title ***/
		if(strpos($txt, '%MG-TITLE-OL%') !== false) {
			$title = get_the_title($item_id);
			$txt = str_replace('%MG-TITLE-OL%', $title, $txt);
		}

		
		/*** description ***/
		if(strpos($txt, '%MG-DESCR-OL%') !== false) {
			$descr = do_shortcode( nl2br(get_post_field('post_excerpt', $item_id)));
			if(empty($descr)) {$descr = nl2br(strip_shortcodes( strip_tags( get_post_field('post_content', $item_id), '<p><a><br><i><span>')));}
			
			$txt = str_replace('%MG-DESCR-OL%', $descr, $txt);
		}
		else {$descr = '';}


		/*** woocommerce price placeholder ***/
		if(strpos($txt, '%WC-PRODUCT-PRICE%') !== false) { 
			if(function_exists('wc_get_product') && get_post_type($item_id) == 'product') {
				$product = wc_get_product($item_id);
				$txt = str_replace('%WC-PRODUCT-PRICE%', wc_price($product->get_price()), $txt);
			}
			else {
				$txt = str_replace('%WC-PRODUCT-PRICE%', '', $txt);	
			}
		}


		/*** socials ***/
		if(strpos($txt, '%MG-SOCIALS-OL%') !== false) {
			$fi_img_id = get_post_thumbnail_id($item_id);
			$fi_src = wp_get_attachment_image_src($fi_img_id, 'medium');
			
			$link = lcwp_curr_url();
			if(!get_option('mg_disable_dl')) {$link .= '#!mg_ld_'.$item_id;}
			
			$code = '';
			if(get_option('mg_facebook')) {
				$code .= "
				<span class='mgom_fb' onClick=\"window.open('https://www.facebook.com/dialog/feed?app_id=425190344259188&display=popup&name=".urlencode($title)."&description=".urlencode(substr($descr, 0, 1000))."&nbsp;&picture=".urlencode($fi_src[0])."&link=".urlencode($link)."&redirect_uri=http://www.lcweb.it/lcis_redirect.php','sharer','toolbar=0,status=0,width=548,height=325');\"></span>";
			}
			if(get_option('mg_twitter')) {
				$code .= "
				<span class='mgom_tw' onClick=\"window.open('https://twitter.com/share?text=". urlencode('Check out "'.$title.'" on '.get_bloginfo("name"))."&url=".urlencode($link)."','sharer','toolbar=0,status=0,width=575,height=330');\"></span>";
			}
			if(get_option('mg_pinterest')) {
				$code .= "
				<span class='mgom_pt' onClick=\"window.open('http://pinterest.com/pin/create/button/?url=".urlencode($link)."&media=".urlencode($fi_src[0])."&description=".urlencode($descr)."','sharer','toolbar=0,status=0,width=575,height=330');\"></span>";
			}
			if(get_option('mg_googleplus') && !get_option('mg_disable_dl')) {
				$code .= "
				<span class='mgom_gp' onClick=\"window.open('https://plus.google.com/share?url=".urlencode($link)."','sharer','toolbar=0,status=0,width=490,height=360');\"></span>";
			}
	
			$txt = str_replace('%MG-SOCIALS-OL%', $code, $txt);
		}
	}

	return $txt;
}
add_filter('mgom_txt_management', 'mgom_txt_management', 100, 3);

