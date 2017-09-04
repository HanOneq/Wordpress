<?php
/* 
Plugin Name: Media Grid - Overlay Manager add-on
Plugin URI: http://codecanyon.net/item/media-grid-wordpress-responsive-portfolio/2218545?ref=LCweb
Description: Boost Media Grid with unique overlays. Customize preset overlays or create you one. With hundreds of possible combinations, the limit is only your creativity.
Author: Luca Montanari
Version: 1.3
Author URI: http://codecanyon.net/user/LCweb?ref=LCweb
*/  


/////////////////////////////////////////////
/////// MAIN DEFINES ////////////////////////
/////////////////////////////////////////////

// plugin path
$wp_plugin_dir = substr(plugin_dir_path(__FILE__), 0, -1);
define( 'MGOM_DIR', $wp_plugin_dir);

// plugin url
$wp_plugin_url = substr(plugin_dir_url(__FILE__), 0, -1);
define( 'MGOM_URL', $wp_plugin_url);

// add-on version
define('MGOM_VER', 1.3);



///////////////////////////////////////////////
/////// CHECK IF MEDIA GRID IS ACTIVE /////////
///////////////////////////////////////////////

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(!is_plugin_active('media-grid/media-grid.php') ) {
	function mgom_no_plugin_warning() {
		echo '
		<div class="error">
		   <p>'. __('Please activate Media Grid plugin to use the Overlay Manager add-on', 'mgom_ml') .'</p>
		</div>';
	}
	add_action('admin_notices', 'mgom_no_plugin_warning');
}


// and if is at least version 4.31
elseif(!defined('MG_VER') || MG_VER < 4.31) {
	function mgom_no_plugin_warning() {
		echo '
		<div class="error">
		   <p>'. __('Media Grid v4.31 is required to use the Overlay Manager add-on', 'mgom_ml') .'</p>
		</div>';
	}
	add_action('admin_notices', 'mgom_no_plugin_warning');	
}

else {
	/////////////////////////////////////////////
	/////// MULTILANGUAGE SUPPORT ///////////////
	
	function mgom_multilanguage() {
		$param_array = explode(DIRECTORY_SEPARATOR, MGOM_DIR);
		$folder_name = end($param_array);
		load_plugin_textdomain( 'mgom_ml', false, $folder_name . '/languages'); 
	}
	add_action('init', 'mgom_multilanguage', 1);
	
	
	
	/////////////////////////////////////////////
	/////// MAIN SCRIPT & CSS INCLUDES //////////
	
	// global script enqueuing
	function mgom_global_scripts() {
	
		// admin css & js
		if (is_admin()) {  
			mg_register_scripts();
			wp_enqueue_style('mgom_admin', MGOM_URL . '/css/admin.css', 999, MGOM_VER);
			
			// fix for the shortcode wizard overflow
			wp_enqueue_script('mgom-sc_wizard_fix', MGOM_URL.'/js/sc_wizard_fix.js');
		}
		
		else {
			// frontent JS on header or footer
			if(get_option('mg_js_head') != '1') {
				wp_enqueue_script('mgom-overlays-js', MGOM_URL.'/js/overlays.js', 9999, MGOM_VER, true);	
			} else { 
				wp_enqueue_script('mgom-overlays-js', MGOM_URL.'/js/overlays.js', 9999, MGOM_VER);
			}

			// frontend css
			if(!get_option('mg_inline_css')) {
				wp_enqueue_style('mgom-overlays-css', MGOM_URL. '/css/overlays.css', 999, MGOM_VER);	
			}
			else {add_action('wp_head', 'mgom_inline_css', 999);}		
		}
	}
	add_action('wp_enqueue_scripts', 'mgom_global_scripts', 999);
	add_action('admin_enqueue_scripts', 'mgom_global_scripts');


	// USE FRONTEND CSS INLINE
	function mgom_inline_css(){
		echo '<style type="text/css">';
		include_once(MGOM_DIR.'/frontend_css.php');
		echo '</style>';
	}
	
		

	//////////////////////////////////////////////
	// ADD SUBMENU
	
	function mgom_add_menu() {	
		add_submenu_page('edit.php?post_type=mg_items', __('Overlay Manager', 'mgom_ml'), __('Overlay Manager', 'mgom_ml'), 'upload_files', 'mgom_builder', 'mgom_builder');
	}
	add_action('admin_menu', 'mgom_add_menu');
	
	function mgom_builder() {
		include(MGOM_DIR . '/overlay_builder.php');	
	}
	
	
	
	//////////////////////
	// OVERLAYS TAXONOMY
	
	add_action( 'init', 'register_taxonomy_mgom' );
	function register_taxonomy_mgom() {
		$labels = array( 
			'name' => __('MG Overlays', 'mgom_ml'),
			'singular_name' => __('MG Overlay', 'mgom_ml'),
			'search_items' => __('Search MG Overlays', 'mgom_ml'),
			'popular_items' => __('Popular MG Overlays', 'mgom_ml'),
			'all_items' => __('All MG Overlays', 'mgom_ml'),
			'parent_item' => __('Parent MG Overlay', 'mgom_ml'),
			'parent_item_colon' => __('Parent MG Overlay:', 'mgom_ml'),
			'edit_item' => __('Edit MG Overlay', 'mgom_ml'),
			'update_item' => __('Update MG Overlay', 'mgom_ml'),
			'add_new_item' => __('Add New MG Overlay', 'mgom_ml'),
			'new_item_name' => __('New MG Overlay', 'mgom_ml'),
			'separate_items_with_commas' => __('Separate mg overlays with commas', 'mgom_ml'),
			'add_or_remove_items' => __('Add or remove MG Overlays', 'mgom_ml'),
			'choose_from_most_used' => __('Choose from most used MG Overlays', 'mgom_ml'),
			'menu_name' => __('MG Overlays', 'mgom_ml'),
		);
	
		$args = array( 
			'labels' => $labels,
			'public' => false,
			'show_in_nav_menus' => false,
			'show_ui' => false,
			'show_tagcloud' => false,
			'show_admin_column' => false,
			'hierarchical' => false,
			'rewrite' => false,
			'query_var' => true
		);
	
		register_taxonomy( 'mgom_overlays', null, $args);
	}
	
	
	
	/////////////////////////////////////////////
	/////// MAIN INCLUDES ///////////////////////
	/////////////////////////////////////////////
	
	// admin menu and cpt and taxonomy
	include_once(MGOM_DIR . '/ajax.php');
	
	// item attribute shortcode
	include_once(MGOM_DIR . '/shortcodes.php');
	
	// overlay code - MG integration
	include_once(MGOM_DIR . '/overlay_code.php');
	
	
	////////////
	// AUTO UPDATE DELIVER
	include_once(MGOM_DIR . '/classes/lc_plugin_auto_updater.php');
	function mgom_auto_updates() {
		$upd = new lc_wp_autoupdate(__FILE__, 'http://updates.lcweb.it', 'lc_updates', 'mgom_preset_ol_install');
	}
	add_action('admin_init', 'mgom_auto_updates', 1);
	////////////
	
	
	
	//////////////////////////////////////////////////
	///// PRESET OVERLAYS ON FIRST INSTALLATION //////
	//////////////////////////////////////////////////
	
	function mgom_preset_ol_install() {
		register_taxonomy_mgom();
		include_once(MGOM_DIR . '/functions.php');
		
		$presets = array();
		/////////////////////////////////////////////////////////////////////
		
		// full overlay + magnifier
		$presets[] = array(
			'name' => 'Full overlay + magnifier',
			'opts' => 'a:2:{s:7:"graphic";a:2:{s:4:"icon";a:12:{s:9:"icon_type";s:13:"magnfier_icon";s:13:"icon_position";s:6:"center";s:9:"font_size";s:2:"35";s:11:"font_size_h";s:2:"43";s:5:"color";s:4:"#555";s:7:"color_h";s:4:"#555";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:3:"100";s:11:"transitions";a:1:{i:0;s:6:"upward";}s:14:"animation_time";s:3:"400";s:6:"easing";s:13:"ease-out-back";s:15:"animation_delay";s:3:"200";}s:14:"full_img_layer";a:9:{s:8:"position";s:3:"top";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:2:"40";s:9:"opacity_h";s:2:"60";s:16:"full_img_padding";s:1:"0";s:18:"full_img_padding_h";s:1:"0";s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";}}s:3:"txt";a:1:{s:9:"txt_block";a:10:{s:8:"position";s:6:"center";s:13:"txt_behaviors";s:4:"none";s:14:"txt_visibility";s:6:"always";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:2:"70";s:9:"opacity_h";s:3:"100";s:11:"txt_padding";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";}s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";}}}'
		);
		
		// Rotating circle + type icon
		$presets[] = array(
			'name' => 'Rotating circle + type icon',
			'opts' => 'a:2:{s:7:"graphic";a:2:{s:13:"central_shape";a:13:{s:13:"cent_ol_shape";s:6:"circle";s:8:"position";s:9:"mouse_dir";s:8:"bg_color";s:7:"#4f4f4f";s:10:"bg_color_h";s:7:"#4f4f4f";s:7:"opacity";s:2:"70";s:9:"opacity_h";s:3:"100";s:10:"inner_icon";s:9:"subj_icon";s:5:"color";s:7:"#fdfdfd";s:14:"over_txt_block";s:1:"1";s:11:"transitions";a:1:{i:0;s:6:"rotate";}s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";s:15:"animation_delay";s:1:"0";}s:14:"full_img_layer";a:10:{s:8:"position";s:9:"mouse_dir";s:8:"bg_color";s:7:"#fdfdfd";s:10:"bg_color_h";s:7:"#fdfdfd";s:7:"opacity";s:2:"10";s:9:"opacity_h";s:2:"10";s:16:"full_img_padding";s:1:"0";s:18:"full_img_padding_h";s:1:"0";s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";s:15:"animation_delay";s:3:"150";}}s:3:"txt";a:1:{s:9:"txt_block";a:10:{s:8:"position";s:6:"center";s:13:"txt_behaviors";s:4:"none";s:14:"txt_visibility";s:6:"always";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:2:"70";s:9:"opacity_h";s:3:"100";s:11:"txt_padding";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";}s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";}}}'
		);
		
		// Mouse aware direction + title and excerpt
		$presets[] = array(
			'name' => 'Mouse aware + title and excerpt',
			'opts' => 'a:2:{s:7:"graphic";a:0:{}s:3:"txt";a:3:{s:5:"title";a:11:{s:9:"txt_align";s:6:"center";s:9:"font_size";s:2:"17";s:5:"color";s:7:"#fdfdfd";s:7:"color_h";s:7:"#fdfdfd";s:9:"highlight";s:0:"";s:11:"highlight_h";s:0:"";s:11:"line_height";s:2:"21";s:10:"txt_styles";a:1:{i:0;s:4:"bold";}s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:2:"15";}s:11:"font_family";s:0:"";s:15:"animation_delay";s:1:"0";}s:5:"descr";a:11:{s:9:"txt_align";s:6:"center";s:9:"font_size";s:2:"13";s:5:"color";s:7:"#ffffff";s:7:"color_h";s:7:"#ffffff";s:9:"highlight";s:0:"";s:11:"highlight_h";s:0:"";s:11:"line_height";s:2:"17";s:9:"txt_max_h";s:3:"600";s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:2:"15";}s:11:"font_family";s:0:"";s:15:"animation_delay";s:1:"0";}s:9:"txt_block";a:11:{s:8:"position";s:9:"mouse_dir";s:13:"txt_behaviors";s:4:"none";s:14:"txt_visibility";s:6:"always";s:15:"txt_vert_center";s:1:"1";s:8:"bg_color";s:7:"#222222";s:10:"bg_color_h";s:7:"#222222";s:7:"opacity";s:2:"30";s:9:"opacity_h";s:2:"80";s:11:"txt_padding";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";}s:14:"animation_time";s:3:"400";s:6:"easing";s:8:"ease-out";}}}'
		);
		
		// title + plus icon
		$presets[] = array(
			'name' => 'Title + plus icon',
			'opts' => 'a:2:{s:7:"graphic";a:3:{s:4:"icon";a:12:{s:9:"icon_type";s:9:"plus_icon";s:13:"icon_position";s:12:"bottom-right";s:9:"font_size";s:2:"19";s:11:"font_size_h";s:2:"19";s:5:"color";s:4:"#fff";s:7:"color_h";s:7:"#383838";s:7:"opacity";s:2:"90";s:9:"opacity_h";s:2:"90";s:14:"over_txt_block";s:1:"1";s:14:"animation_time";s:3:"200";s:6:"easing";s:6:"linear";s:15:"animation_delay";s:1:"0";}s:12:"outlined_box";a:12:{s:8:"position";s:6:"center";s:12:"border_width";s:1:"0";s:14:"border_width_h";s:1:"2";s:12:"border_color";s:4:"#888";s:14:"border_color_h";s:4:"#888";s:16:"full_img_padding";s:1:"0";s:18:"full_img_padding_h";s:2:"35";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:2:"40";s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";s:15:"animation_delay";s:3:"300";}s:14:"full_img_layer";a:11:{s:8:"position";s:6:"center";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:2:"80";s:16:"full_img_padding";s:1:"0";s:18:"full_img_padding_h";s:1:"0";s:11:"transitions";a:2:{i:0;s:7:"zoom-in";i:1;s:9:"rightward";}s:14:"animation_time";s:3:"250";s:6:"easing";s:8:"ease-out";s:15:"animation_delay";s:1:"0";}}s:3:"txt";a:2:{s:5:"title";a:11:{s:9:"txt_align";s:6:"center";s:9:"font_size";s:2:"16";s:5:"color";s:7:"#4f4f4f";s:7:"color_h";s:4:"#555";s:9:"highlight";s:0:"";s:11:"highlight_h";s:0:"";s:11:"line_height";s:2:"19";s:10:"txt_styles";a:2:{i:0;s:4:"bold";i:1;s:9:"uppercase";}s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:0:"";}s:11:"font_family";s:0:"";s:15:"animation_delay";s:3:"150";}s:9:"txt_block";a:12:{s:8:"position";s:6:"center";s:13:"txt_behaviors";s:4:"none";s:14:"txt_visibility";s:4:"hide";s:15:"txt_vert_center";s:1:"1";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:1:"0";s:11:"txt_padding";a:4:{i:0;s:2:"35";i:1;s:2:"35";i:2;s:2:"35";i:3;s:2:"35";}s:11:"transitions";a:1:{i:0;s:7:"zoom-in";}s:14:"animation_time";s:3:"350";s:6:"easing";s:13:"ease-out-back";}}}'
		);
		
		// title  always visible - descr on hover
		$presets[] = array(
			'name' => 'Flickr style',
			'opts' => 'a:2:{s:7:"graphic";a:0:{}s:3:"txt";a:3:{s:5:"title";a:11:{s:9:"txt_align";s:4:"left";s:9:"font_size";s:2:"15";s:5:"color";s:7:"#fdfdfd";s:7:"color_h";s:7:"#fdfdfd";s:9:"highlight";s:0:"";s:11:"highlight_h";s:0:"";s:11:"line_height";s:2:"20";s:10:"txt_styles";a:1:{i:0;s:4:"bold";}s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:0:"";}s:11:"font_family";s:0:"";s:15:"animation_delay";s:1:"0";}s:5:"descr";a:11:{s:9:"txt_align";s:4:"left";s:9:"font_size";s:2:"14";s:5:"color";s:7:"#fefefe";s:7:"color_h";s:7:"#fefefe";s:9:"highlight";s:0:"";s:11:"highlight_h";s:0:"";s:11:"line_height";s:2:"19";s:9:"txt_max_h";s:3:"600";s:15:"txt_vert_margin";a:2:{i:0;s:2:"15";i:1;s:0:"";}s:11:"font_family";s:0:"";s:15:"animation_delay";s:3:"100";}s:9:"txt_block";a:10:{s:8:"position";s:6:"bottom";s:13:"txt_behaviors";s:10:"show_title";s:14:"txt_visibility";s:6:"always";s:8:"bg_color";s:7:"#151515";s:10:"bg_color_h";s:7:"#151515";s:7:"opacity";s:2:"70";s:9:"opacity_h";s:2:"80";s:11:"txt_padding";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";}s:14:"animation_time";s:3:"500";s:6:"easing";s:4:"ease";}}}'
		);
		
		// grayscale + corner circle
		$presets[] = array(
			'name' => 'Grayscale + corner circle',
			'opts' => 'a:2:{s:7:"graphic";a:3:{s:12:"corner_shape";a:11:{s:13:"corn_ol_shape";s:13:"corner_circle";s:10:"corner_pos";s:12:"bottom-right";s:8:"bg_color";s:7:"#fdfdfd";s:7:"opacity";s:3:"100";s:9:"opacity_h";s:3:"100";s:10:"inner_icon";s:9:"subj_icon";s:5:"color";s:7:"#535353";s:14:"over_txt_block";s:1:"1";s:14:"animation_time";s:3:"500";s:6:"easing";s:13:"ease-out-back";s:15:"animation_delay";s:3:"250";}s:14:"crossing_layer";a:8:{s:9:"cross_pos";s:12:"bottom-right";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:2:"20";s:9:"opacity_h";s:2:"60";s:14:"animation_time";s:3:"700";s:6:"easing";s:4:"ease";s:15:"animation_delay";s:3:"100";}s:6:"img_fx";a:6:{s:8:"img_zoom";s:1:"0";s:9:"grayscale";s:1:"1";s:8:"img_h_fx";s:0:"";s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";s:15:"animation_delay";s:1:"0";}}s:3:"txt";a:1:{s:9:"txt_block";a:10:{s:8:"position";s:6:"center";s:13:"txt_behaviors";s:4:"none";s:14:"txt_visibility";s:6:"always";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:1:"0";s:11:"txt_padding";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";}s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";}}}'
		);
		
		// zoom image + magnifier icon
		$presets[] = array(
			'name' => 'Zoom image + magnifier icon',
			'opts' => 'a:2:{s:7:"graphic";a:3:{s:4:"icon";a:12:{s:9:"icon_type";s:13:"magnfier_icon";s:13:"icon_position";s:6:"center";s:9:"font_size";s:2:"39";s:11:"font_size_h";s:2:"39";s:5:"color";s:4:"#fff";s:7:"color_h";s:4:"#fff";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:2:"90";s:11:"transitions";a:1:{i:0;s:8:"zoom-out";}s:14:"animation_time";s:3:"400";s:6:"easing";s:8:"ease-out";s:15:"animation_delay";s:3:"100";}s:14:"crossing_layer";a:8:{s:9:"cross_pos";s:11:"bottom-left";s:8:"bg_color";s:4:"#333";s:10:"bg_color_h";s:4:"#333";s:7:"opacity";s:2:"10";s:9:"opacity_h";s:2:"15";s:14:"animation_time";s:3:"350";s:6:"easing";s:6:"linear";s:15:"animation_delay";s:2:"50";}s:6:"img_fx";a:5:{s:8:"img_zoom";s:2:"10";s:8:"img_h_fx";s:0:"";s:14:"animation_time";s:3:"400";s:6:"easing";s:8:"ease-out";s:15:"animation_delay";s:1:"0";}}s:3:"txt";a:1:{s:9:"txt_block";a:10:{s:8:"position";s:6:"center";s:13:"txt_behaviors";s:4:"none";s:14:"txt_visibility";s:6:"always";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:1:"0";s:11:"txt_padding";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";}s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";}}}'
		);
		
		// Split overlay + circle
		$presets[] = array(
			'name' => 'Split overlay + circle',
			'opts' => 'a:2:{s:7:"graphic";a:2:{s:13:"central_shape";a:13:{s:13:"cent_ol_shape";s:6:"circle";s:8:"position";s:6:"center";s:8:"bg_color";s:4:"#333";s:10:"bg_color_h";s:4:"#333";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:2:"90";s:10:"inner_icon";s:8:"eye_icon";s:5:"color";s:4:"#fff";s:14:"over_txt_block";s:1:"1";s:11:"transitions";a:2:{i:0;s:7:"zoom-in";i:1;s:10:"slide-vert";}s:14:"animation_time";s:3:"450";s:6:"easing";s:13:"ease-out-back";s:15:"animation_delay";s:3:"150";}s:16:"vert_split_layer";a:7:{s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:2:"10";s:9:"opacity_h";s:2:"40";s:14:"animation_time";s:3:"250";s:6:"easing";s:4:"ease";s:15:"animation_delay";s:1:"0";}}s:3:"txt";a:1:{s:9:"txt_block";a:10:{s:8:"position";s:6:"center";s:13:"txt_behaviors";s:4:"none";s:14:"txt_visibility";s:6:"always";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:1:"0";s:11:"txt_padding";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";}s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";}}}'
		);
		
		// Curtain + type icon + socials 
		$presets[] = array(
			'name' => 'Curtain + type icon + socials',
			'opts' => 'a:2:{s:7:"graphic";a:2:{s:4:"icon";a:13:{s:9:"icon_type";s:9:"subj_icon";s:13:"icon_position";s:6:"center";s:9:"font_size";s:2:"27";s:11:"font_size_h";s:2:"27";s:5:"color";s:7:"#ffffff";s:7:"color_h";s:7:"#ffffff";s:7:"opacity";s:2:"90";s:9:"opacity_h";s:2:"40";s:14:"over_txt_block";s:1:"1";s:11:"transitions";a:1:{i:0;s:8:"zoom-out";}s:14:"animation_time";s:3:"400";s:6:"easing";s:11:"ease-in-out";s:15:"animation_delay";s:1:"0";}s:14:"full_img_layer";a:9:{s:8:"position";s:6:"center";s:8:"bg_color";s:7:"#242424";s:10:"bg_color_h";s:7:"#242424";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:2:"10";s:16:"full_img_padding";s:1:"0";s:18:"full_img_padding_h";s:1:"0";s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";}}s:3:"txt";a:4:{s:5:"title";a:11:{s:9:"txt_align";s:6:"center";s:9:"font_size";s:2:"15";s:5:"color";s:7:"#383838";s:7:"color_h";s:7:"#5c5c5c";s:9:"highlight";s:0:"";s:11:"highlight_h";s:0:"";s:11:"line_height";s:2:"17";s:10:"txt_styles";a:1:{i:0;s:9:"uppercase";}s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:0:"";}s:11:"font_family";s:0:"";s:15:"animation_delay";s:2:"50";}s:9:"separator";a:5:{s:5:"color";s:7:"#cfcfcf";s:9:"thickness";s:1:"1";s:9:"sep_style";s:6:"dotted";s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:0:"";}s:15:"animation_delay";s:2:"50";}s:7:"socials";a:8:{s:13:"socials_style";s:7:"rounded";s:13:"socials_align";s:6:"center";s:5:"color";s:7:"#b2b2b2";s:7:"color_h";s:7:"#808080";s:9:"font_size";s:2:"18";s:11:"line_height";s:2:"32";s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:0:"";}s:15:"animation_delay";s:1:"0";}s:9:"txt_block";a:11:{s:8:"position";s:6:"bottom";s:13:"txt_behaviors";s:7:"curtain";s:14:"txt_visibility";s:6:"always";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:3:"100";s:9:"opacity_h";s:3:"100";s:11:"txt_padding";a:4:{i:0;s:2:"13";i:1;s:2:"15";i:2;s:1:"8";i:3;s:2:"15";}s:11:"transitions";a:1:{i:0;s:7:"zoom-in";}s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";}}}'
		);
		
		// Outlined diamond + type
		$presets[] = array(
			'name' => 'Outlined diamond + type',
			'opts' => 'a:2:{s:7:"graphic";a:3:{s:6:"img_fx";a:3:{s:8:"img_zoom";s:1:"0";s:14:"img_no_borders";s:1:"1";s:14:"animation_time";s:3:"500";}s:13:"central_shape";a:12:{s:13:"cent_ol_shape";s:15:"outline_diamond";s:8:"position";s:6:"center";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:3:"100";s:10:"inner_icon";s:9:"subj_icon";s:5:"color";s:7:"#ffffff";s:14:"over_txt_block";s:1:"1";s:11:"transitions";a:1:{i:0;s:8:"zoom-out";}s:14:"animation_time";s:3:"500";s:6:"easing";s:4:"ease";}s:14:"full_img_layer";a:8:{s:8:"position";s:6:"center";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:2:"15";s:16:"full_img_padding";s:2:"10";s:14:"animation_time";s:3:"600";s:6:"easing";s:4:"ease";}}s:3:"txt";a:1:{s:9:"txt_block";a:10:{s:8:"position";s:6:"center";s:13:"txt_behaviors";s:4:"none";s:14:"txt_visibility";s:6:"always";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:2:"70";s:9:"opacity_h";s:3:"100";s:11:"txt_padding";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";}s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";}}}'
		);
		
		// Central sliding text + button
		$presets[] = array(
			'name' => 'Central sliding text + button',
			'opts' => 'a:2:{s:7:"graphic";a:2:{s:17:"horiz_split_layer";a:6:{s:8:"bg_color";s:7:"#292929";s:10:"bg_color_h";s:7:"#292929";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:2:"10";s:14:"animation_time";s:3:"300";s:6:"easing";s:11:"ease-in-out";}s:6:"img_fx";a:6:{s:8:"img_zoom";s:1:"0";s:8:"img_blur";s:1:"1";s:8:"img_h_fx";s:0:"";s:14:"animation_time";s:3:"400";s:6:"easing";s:4:"ease";s:15:"animation_delay";s:1:"0";}}s:3:"txt";a:3:{s:5:"title";a:10:{s:9:"txt_align";s:6:"center";s:9:"font_size";s:2:"17";s:5:"color";s:7:"#ffffff";s:7:"color_h";s:7:"#ffffff";s:9:"highlight";s:0:"";s:11:"highlight_h";s:0:"";s:11:"line_height";s:2:"19";s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:2:"12";}s:11:"font_family";s:0:"";s:15:"animation_delay";s:3:"100";}s:6:"button";a:18:{s:7:"btn_txt";s:9:"read more";s:9:"font_size";s:2:"12";s:11:"line_height";s:2:"13";s:9:"btn_align";s:6:"center";s:10:"txt_styles";a:1:{i:0;s:9:"uppercase";}s:11:"font_family";s:0:"";s:11:"txt_padding";a:4:{i:0;s:1:"5";i:1;s:0:"";i:2;s:1:"4";i:3;s:0:"";}s:12:"border_width";s:1:"2";s:12:"border_style";s:5:"solid";s:12:"border_color";s:7:"#ffffff";s:14:"border_color_h";s:7:"#ffffff";s:13:"border_radius";s:1:"2";s:8:"bg_color";s:11:"transparent";s:10:"bg_color_h";s:11:"transparent";s:5:"color";s:7:"#ffffff";s:7:"color_h";s:7:"#ffffff";s:15:"txt_vert_margin";a:2:{i:0;s:2:"15";i:1;s:0:"";}s:15:"animation_delay";s:3:"150";}s:9:"txt_block";a:11:{s:8:"position";s:6:"bottom";s:13:"txt_behaviors";s:14:"sh_vert_center";s:14:"txt_visibility";s:6:"always";s:8:"bg_color";s:7:"#424242";s:10:"bg_color_h";s:7:"#292929";s:7:"opacity";s:2:"60";s:9:"opacity_h";s:2:"80";s:11:"txt_padding";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";}s:11:"transitions";a:1:{i:0;s:11:"slide-horiz";}s:14:"animation_time";s:3:"600";s:6:"easing";s:4:"ease";}}}'
		);
		
		
		// Bottom slice + plus button
		$presets[] = array(
			'name' => 'Bottom slice + plus button',
			'opts' => 'a:2:{s:7:"graphic";a:2:{s:6:"img_fx";a:3:{s:8:"img_zoom";s:1:"0";s:14:"img_no_borders";s:1:"1";s:14:"animation_time";s:3:"300";}s:12:"corner_slice";a:7:{s:9:"slice_pos";s:11:"bottom-left";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:2:"10";s:9:"opacity_h";s:2:"80";s:14:"animation_time";s:3:"400";s:6:"easing";s:11:"ease-in-out";}}s:3:"txt";a:2:{s:6:"button";a:17:{s:7:"btn_txt";s:1:"+";s:9:"font_size";s:2:"27";s:11:"line_height";s:2:"27";s:9:"btn_align";s:4:"left";s:10:"txt_styles";a:1:{i:0;s:4:"bold";}s:11:"font_family";s:15:"Times New Roman";s:11:"txt_padding";a:4:{i:0;s:1:"2";i:1;s:1:"8";i:2;s:1:"2";i:3;s:1:"8";}s:12:"border_width";s:1:"2";s:12:"border_style";s:5:"solid";s:12:"border_color";s:7:"#606060";s:14:"border_color_h";s:7:"#606060";s:13:"border_radius";s:2:"50";s:8:"bg_color";s:7:"#696969";s:10:"bg_color_h";s:7:"#696969";s:5:"color";s:7:"#ffffff";s:7:"color_h";s:7:"#ffffff";s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:0:"";}}s:9:"txt_block";a:10:{s:8:"position";s:6:"bottom";s:13:"txt_behaviors";s:8:"hide_all";s:14:"txt_visibility";s:4:"hide";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:1:"0";s:11:"txt_padding";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:1:"1";i:3;s:1:"6";}s:14:"animation_time";s:3:"400";s:6:"easing";s:6:"linear";}}}'
		);
		
		
		// Highlighted texts
		$presets[] = array(
			'name' => 'Highlighted texts',
			'opts' => 'a:2:{s:7:"graphic";a:2:{s:13:"single_border";a:10:{s:17:"singl_border_side";s:6:"bottom";s:17:"singl_border_show";s:6:"bottom";s:12:"border_width";s:1:"6";s:12:"border_color";s:7:"#ff551c";s:14:"border_color_h";s:7:"#ff551c";s:7:"opacity";s:2:"70";s:9:"opacity_h";s:3:"100";s:14:"animation_time";s:3:"450";s:6:"easing";s:13:"ease-out-back";s:15:"animation_delay";s:3:"600";}s:14:"full_img_layer";a:10:{s:8:"position";s:3:"top";s:8:"bg_color";s:4:"#000";s:10:"bg_color_h";s:4:"#000";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:2:"20";s:16:"full_img_padding";s:1:"0";s:18:"full_img_padding_h";s:1:"0";s:14:"animation_time";s:3:"500";s:6:"easing";s:8:"ease-out";s:15:"animation_delay";s:1:"0";}}s:3:"txt";a:3:{s:5:"title";a:11:{s:9:"txt_align";s:4:"left";s:9:"font_size";s:2:"17";s:5:"color";s:7:"#fefefe";s:7:"color_h";s:7:"#fefefe";s:9:"highlight";s:7:"#ff551c";s:11:"highlight_h";s:7:"#ff551c";s:11:"line_height";s:2:"22";s:10:"txt_styles";a:1:{i:0;s:4:"bold";}s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:2:"20";}s:11:"font_family";s:0:"";s:15:"animation_delay";s:1:"0";}s:5:"descr";a:11:{s:9:"txt_align";s:4:"left";s:9:"font_size";s:2:"14";s:5:"color";s:4:"#fff";s:7:"color_h";s:4:"#fff";s:9:"highlight";s:7:"#ff551c";s:11:"highlight_h";s:7:"#ff551c";s:11:"line_height";s:2:"23";s:9:"txt_max_h";s:2:"60";s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:2:"25";}s:11:"font_family";s:0:"";s:15:"animation_delay";s:3:"200";}s:9:"txt_block";a:11:{s:8:"position";s:6:"bottom";s:13:"txt_behaviors";s:8:"show_all";s:14:"txt_visibility";s:6:"always";s:8:"bg_color";s:7:"#ffffff";s:10:"bg_color_h";s:7:"#ffffff";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:1:"0";s:11:"txt_padding";a:4:{i:0;s:2:"15";i:1;s:2:"15";i:2;s:1:"4";i:3;s:2:"15";}s:11:"transitions";a:1:{i:0;s:8:"door-top";}s:14:"animation_time";s:3:"450";s:6:"easing";s:16:"ease-in-out-back";}}}'
		);
		
		
		// Flipping image + text
		$presets[] = array(
			'name' => 'Flip image + text and button',
			'opts' => 'a:2:{s:7:"graphic";a:2:{s:4:"icon";a:13:{s:9:"icon_type";s:9:"subj_icon";s:13:"icon_position";s:6:"center";s:9:"font_size";s:2:"29";s:11:"font_size_h";s:2:"29";s:5:"color";s:7:"#ffffff";s:7:"color_h";s:7:"#ffffff";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:3:"100";s:14:"over_txt_block";s:1:"1";s:11:"transitions";a:2:{i:0;s:7:"zoom-in";i:1;s:6:"upward";}s:14:"animation_time";s:3:"300";s:6:"easing";s:13:"ease-out-back";s:15:"animation_delay";s:3:"600";}s:6:"img_fx";a:5:{s:8:"img_zoom";s:1:"0";s:8:"img_h_fx";s:9:"flip-vert";s:14:"animation_time";s:3:"700";s:6:"easing";s:16:"ease-in-out-back";s:15:"animation_delay";s:1:"0";}}s:3:"txt";a:3:{s:5:"title";a:10:{s:9:"txt_align";s:6:"center";s:9:"font_size";s:2:"19";s:5:"color";s:7:"#fefefe";s:7:"color_h";s:7:"#fefefe";s:9:"highlight";s:0:"";s:11:"highlight_h";s:0:"";s:11:"line_height";s:2:"40";s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:2:"58";}s:11:"font_family";s:0:"";s:15:"animation_delay";s:3:"150";}s:6:"button";a:18:{s:7:"btn_txt";s:8:"discover";s:9:"font_size";s:2:"14";s:11:"line_height";s:2:"19";s:9:"btn_align";s:6:"center";s:10:"txt_styles";a:1:{i:0;s:9:"uppercase";}s:11:"font_family";s:0:"";s:11:"txt_padding";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";}s:12:"border_width";s:1:"0";s:12:"border_style";s:5:"solid";s:12:"border_color";s:7:"#444444";s:14:"border_color_h";s:7:"#666666";s:13:"border_radius";s:1:"2";s:8:"bg_color";s:7:"#7eb551";s:10:"bg_color_h";s:7:"#7eb551";s:5:"color";s:7:"#fefefe";s:7:"color_h";s:7:"#fefefe";s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:0:"";}s:15:"animation_delay";s:3:"150";}s:9:"txt_block";a:12:{s:8:"position";s:6:"center";s:13:"txt_behaviors";s:4:"none";s:14:"txt_visibility";s:6:"always";s:15:"txt_vert_center";s:1:"1";s:8:"bg_color";s:7:"#63a031";s:10:"bg_color_h";s:7:"#63a031";s:7:"opacity";s:2:"80";s:9:"opacity_h";s:3:"100";s:11:"txt_padding";a:4:{i:0;s:0:"";i:1;s:0:"";i:2;s:0:"";i:3;s:0:"";}s:11:"transitions";a:1:{i:0;s:10:"slide-vert";}s:14:"animation_time";s:3:"700";s:6:"easing";s:16:"ease-in-out-back";}}}'
		);
		
		
		// Tilt image + texts
		$presets[] = array(
			'name' => 'Tilt image + texts',
			'opts' => 'a:2:{s:7:"graphic";a:3:{s:4:"icon";a:13:{s:9:"icon_type";s:13:"magnfier_icon";s:13:"icon_position";s:12:"bottom-right";s:9:"font_size";s:2:"18";s:11:"font_size_h";s:2:"18";s:5:"color";s:7:"#ffffff";s:7:"color_h";s:7:"#ffffff";s:7:"opacity";s:1:"0";s:9:"opacity_h";s:3:"100";s:14:"over_txt_block";s:1:"1";s:11:"transitions";a:1:{i:0;s:7:"zoom-in";}s:14:"animation_time";s:3:"300";s:6:"easing";s:4:"ease";s:15:"animation_delay";s:3:"500";}s:12:"outlined_box";a:14:{s:8:"position";s:6:"center";s:12:"border_width";s:1:"2";s:14:"border_width_h";s:1:"2";s:12:"border_color";s:4:"#fff";s:14:"border_color_h";s:4:"#fff";s:16:"full_img_padding";s:1:"0";s:18:"full_img_padding_h";s:1:"8";s:7:"opacity";s:2:"40";s:9:"opacity_h";s:2:"40";s:14:"over_txt_block";s:1:"1";s:11:"transitions";a:1:{i:0;s:8:"zoom-out";}s:14:"animation_time";s:3:"350";s:6:"easing";s:13:"ease-out-back";s:15:"animation_delay";s:3:"500";}s:6:"img_fx";a:5:{s:8:"img_zoom";s:1:"0";s:8:"img_h_fx";s:9:"door-left";s:14:"animation_time";s:3:"600";s:6:"easing";s:4:"ease";s:15:"animation_delay";s:1:"0";}}s:3:"txt";a:3:{s:5:"title";a:11:{s:9:"txt_align";s:4:"left";s:9:"font_size";s:2:"19";s:5:"color";s:7:"#fefefe";s:7:"color_h";s:7:"#fefefe";s:9:"highlight";s:7:"#7eb551";s:11:"highlight_h";s:7:"#7eb551";s:11:"line_height";s:2:"22";s:10:"txt_styles";a:1:{i:0;s:9:"uppercase";}s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:2:"25";}s:11:"font_family";s:0:"";s:15:"animation_delay";s:1:"0";}s:5:"descr";a:11:{s:9:"txt_align";s:4:"left";s:9:"font_size";s:2:"16";s:5:"color";s:4:"#fff";s:7:"color_h";s:4:"#fff";s:9:"highlight";s:0:"";s:11:"highlight_h";s:0:"";s:11:"line_height";s:2:"21";s:9:"txt_max_h";s:2:"50";s:15:"txt_vert_margin";a:2:{i:0;s:0:"";i:1;s:0:"";}s:11:"font_family";s:0:"";s:15:"animation_delay";s:1:"0";}s:9:"txt_block";a:12:{s:8:"position";s:6:"center";s:13:"txt_behaviors";s:4:"none";s:14:"txt_visibility";s:6:"always";s:15:"txt_vert_center";s:1:"1";s:8:"bg_color";s:7:"#63a031";s:10:"bg_color_h";s:7:"#63a031";s:7:"opacity";s:2:"90";s:9:"opacity_h";s:3:"100";s:11:"txt_padding";a:4:{i:0;s:2:"25";i:1;s:2:"30";i:2;s:2:"25";i:3;s:2:"30";}s:11:"transitions";a:1:{i:0;s:10:"door-right";}s:14:"animation_time";s:3:"600";s:6:"easing";s:4:"ease";}}}'
		);
		
		/////////////////////////////////////////////////////////////////////
			
			
		// check if there are already overlays
		$args =  array('number' => 100, 'offset' => 0, 'hide_empty' => 0);
		$items = get_terms('mgom_overlays', $args);	
		
		if(count($items) == 0) {
			foreach($presets as $key => $preset) {
				wp_insert_term($preset['name'], 'mgom_overlays', $args = array('description' => $preset['opts']) );	
			}
		}
		
		
		// save again custom CSS file
		if(!get_option('mg_inline_css')) {
			if(!mgom_create_ol_css()) {
				if(!get_option('mg_inline_css')) { add_option('mg_inline_css', '255', '', 'yes'); }
				update_option('mg_inline_css', 1);	
			}
			else {delete_option('mg_inline_css');}
		}
	}
	register_activation_hook(__FILE__, 'mgom_preset_ol_install');
}



//////////////////////////////////////////////////
// REMOVE WP HELPER FROM PLUGIN PAGES

function mgom_remove_wp_helper() {
	$cs = get_current_screen();
	$hooked = array('mg_items_page_mgom_builder');
	
	if(in_array($cs->base, $hooked)) {
		echo '
		<style type="text/css">
		#screen-meta-links {display: none;}
		</style>';	
	}
	
	//var_dump(get_current_screen()); // debug
}
add_action('admin_head', 'mgom_remove_wp_helper', 999);