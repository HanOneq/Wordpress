<?php
/**
 * Metaboxes: Layouts Meta
 *
 * @package WordPress
 * @subpackage Post Revolution
 * 
 */


/* FUNCTIONS */

VP_Security::instance()->whitelist_function('pr_post_source');
function pr_post_source($value){
	if($value == 'post'){
		return true;
	}
		 
}

VP_Security::instance()->whitelist_function('pr_woo_source');
function pr_woo_source($value){
	if($value == 'product'){
		return true;
	}
		 
}

VP_Security::instance()->whitelist_function('pr_gall_source');
function pr_gall_source($value){
	if($value == 'prgalleries'){
		return true;
	}
		 
}

VP_Security::instance()->whitelist_function('pr_no_gall_source');
function pr_no_gall_source($value){
	if($value != 'prgalleries'){
		return true;
	}
		 
}

VP_Security::instance()->whitelist_function('pr_get_woo_categories');
function pr_get_woo_categories() {
	
	$wp_cat = get_categories(array('type' => 'product', 'taxonomy' => 'product_cat', 'hide_empty' => 0 ));

	$result = array();
	
	if(count($wp_cat) > 0 && class_exists('Woocommerce')) {
		foreach ($wp_cat as $cat){
			$result[] = array('value' => $cat->cat_ID, 'label' => $cat->name);
		}
	}
	
	return $result;
	
}


VP_Security::instance()->whitelist_function('pr_galleries_list');

function pr_galleries_list(){	

	$args = array(
	  'post_type' => 'prgalleries',
	  'post_status' => 'publish',
	  'posts_per_page' => -1
	);
	
	$galleries = get_posts($args);
	
	$result = array();
	
	foreach ($galleries as $gallery){
		
		$result[] = array('value' => $gallery->ID, 'label' => $gallery->post_title);
		
	}
	
	return $result;
	
}


VP_Security::instance()->whitelist_function('pr_thumbnails_title');
function pr_thumbnails_title(){
	return __('<h3 class="pr_bk_title pr_title_thumbs">Thumbnails</h3>', 'pr');
}

VP_Security::instance()->whitelist_function('pr_caption_title');
function pr_caption_title(){
	return __('<h3 class="pr_bk_title pr_title_caption">Caption</h3>', 'pr');
}

VP_Security::instance()->whitelist_function('pr_excerpt_title');
function pr_excerpt_title(){
	return __('<h3 class="pr_bk_title pr_title_excerpt">Excerpt</h3>', 'pr');
}

VP_Security::instance()->whitelist_function('pr_preview_title');
function pr_preview_title(){
	return __('<h3 class="pr_bk_title pr_title_preview">Preview</h3>', 'pr');
}

VP_Security::instance()->whitelist_function('pr_fonts_title');
function pr_fonts_title(){
	return __('<h3 class="pr_bk_title pr_title_fonts">Fonts</h3>', 'pr');
}

VP_Security::instance()->whitelist_function('pr_custom_preset');
function pr_custom_preset($value){
	if($value == 'custom'){
		return true;
	}
		 
}

VP_Security::instance()->whitelist_function('pr_dep_enabled');
function pr_dep_enabled($value){
	
	if($value != '0'){
		return true;
	} 
	
}


// META ARRAY

return array(
	'id'          => 'pr_layouts_meta',
	'types'       => array('layouts'),
	'title'       => __('Layout Options', 'pr'),
	'priority'    => 'high',
	'template'    => array(
		
		// Grid Type
		
		array(
			'type' => 'radioimage',
			'name' => 'pr_layouts_grid',
			'label' => __('Grid Type', 'pr'),
			'description' => __('Choose between 3 mosaic layouts', 'pr'),
			'item_max_height' => '90',
			'item_max_width' => '90',
			'items' => array(
				array(
					'value' => 'mosaic-0',
					'label' => __('Full Mosaic', 'pr'),
					'img' => PR_URL.'assets/img/mosaic0.jpg',
				),
				array(
					'value' => 'mosaic-1',
					'label' => __('Mosaic Padding 5px', 'pr'),
					'img' => PR_URL.'assets/img/mosaic5.jpg',
				),
				array(
					'value' => 'mosaic-2',
					'label' => __('Mosaic Padding 10px', 'pr'),
					'img' => PR_URL.'assets/img/mosaic10.jpg',
				),
			),
			'default' => array(
				'mosaic-1',
			),
		),
		
		// Grid Loader
		
		array(
			'type' => 'radioimage',
			'name' => 'pr_grid_loader',
			'label' => __('Grid Loader', 'pr'),
			'description' => __('Choose between 8 loaders for your grid', 'pr'),
			'item_max_height' => '34',
			'item_max_width' => '32',
			'items' => array(
				array(
					'value' => '0',
					'label' => __('None', 'pr'),
					'img' => PR_URL.'assets/img/none.jpg',
				),
				array(
					'value' => PR_URL.'assets/img/spin-1.gif',
					'label' => __('Loader 1', 'pr'),
					'img' => PR_URL.'assets/img/spin-1.gif',
				),
				array(
					'value' => PR_URL.'assets/img/spin-2.gif',
					'label' => __('Loader 2', 'pr'),
					'img' => PR_URL.'assets/img/spin-2.gif',
				),
				array(
					'value' => PR_URL.'assets/img/spin-3.gif',
					'label' => __('Loader 3', 'pr'),
					'img' => PR_URL.'assets/img/spin-3.gif',
				),
				array(
					'value' => PR_URL.'assets/img/spin-4.gif',
					'label' => __('Loader 4', 'pr'),
					'img' => PR_URL.'assets/img/spin-4.gif',
				),
				array(
					'value' => PR_URL.'assets/img/spin-5.gif',
					'label' => __('Loader 5', 'pr'),
					'img' => PR_URL.'assets/img/spin-5.gif',
				),
				array(
					'value' => PR_URL.'assets/img/spin-6.gif',
					'label' => __('Loader 6', 'pr'),
					'img' => PR_URL.'assets/img/spin-6.gif',
				),
				array(
					'value' => PR_URL.'assets/img/spin-7.gif',
					'label' => __('Loader 7', 'pr'),
					'img' => PR_URL.'assets/img/spin-7.gif',
				),
				array(
					'value' => PR_URL.'assets/img/spin-8.gif',
					'label' => __('Loader 8', 'pr'),
					'img' => PR_URL.'assets/img/spin-8.gif',
				),
				array(
					'value' => PR_URL.'assets/img/spin-9.gif',
					'label' => __('Loader 9', 'pr'),
					'img' => PR_URL.'assets/img/spin-9.gif',
				),
				array(
					'value' => PR_URL.'assets/img/spin-10.gif',
					'label' => __('Loader 10', 'pr'),
					'img' => PR_URL.'assets/img/spin-10.gif',
				),
				array(
					'value' => PR_URL.'assets/img/spin-11.gif',
					'label' => __('Loader 11', 'pr'),
					'img' => PR_URL.'assets/img/spin-11.gif',
				),
			),
			'default' => array(
				PR_URL.'assets/img/spin-1.gif',
			),
			'validation' => 'required',
		),
		
		// Source
		
		array(
			'type' => 'select',
			'name' => 'pr_source',
			'label' => __('Source', 'pr'),
			'items' => array(
				array(
					'value' => 'post',
					'label' => __('Posts', 'pr'),
				),
				array(
					'value' => 'product',
					'label' => __('Woocommerce Products', 'pr'),
				),
				array(
					'value' => 'prgalleries',
					'label' => __('PR Gallery', 'pr'),
				),
			),
			'default' => array(
				'post',
			),
			'validation' => 'required',
		),

		// Filter Posts by Category
		
		array(
			'type' => 'multiselect',
			'name' => 'pr_category_filter',
			'label' => __('Categories', 'pr'),
			'description' => __('Filter your posts by Category', 'pr'),
			'dependency' => array(
				'field' => 'pr_source',
				'function' => 'pr_post_source',
			),
			'items' => array(
				array(
					'value' => 'all', 
					'label' => __('All Categories', 'pr'),
				),
				'data' => array(
					array(
					'source' => 'function',
					'value' => 'vp_get_categories',
					),
				),
			),
			'validation' => 'required',
			'default' => array(
				'{{first}}',
			),
		),
		
		// Filter Products by Category
		
		array(
			'type' => 'multiselect',
			'name' => 'pr_woo_category_filter',
			'label' => __('Woocommerce Categories', 'pr'),
			'description' => __('Filter your products by Category', 'pr'),
			'dependency' => array(
				'field' => 'pr_source',
				'function' => 'pr_woo_source',
			),
			'items' => array(
				array(
					'value' => 'all', 
					'label' => __('All Categories', 'pr'),
				),
				'data' => array(
					array(
					'source' => 'function',
					'value' => 'pr_get_woo_categories',
					),
				),
			),
			'validation' => 'required',
			'default' => array(
				'{{first}}',
			),
		),
		
		// Isotope Filtering
		
		array(
			'type' => 'toggle',
			'name' => 'pr_isotope_filter',
			'label' => __('Filtering Buttons', 'pr'),
			'description' => __('Enable/Disable buttons to filter the items', 'pr'),
			'dependency' => array(
				'field' => 'pr_source',
				'function' => 'pr_no_gall_source',
			),
		),

		// Gallery Items
		
		array(
			'type' => 'select',
			'name' => 'pr_gallery_item',
			'label' => __('Choose your Gallery', 'pr'),
			'dependency' => array(
				'field' => 'pr_source',
				'function' => 'pr_gall_source',
			),
			'items' => array(
				'data' => array(
					array(
					'source' => 'function',
					'value' => 'pr_galleries_list',
					),
				),
			),
			'validation' => 'required',
		),
		
		// Posts Limit	
		
		array(
		  'type' => 'slider',
		  'name' => 'pr_posts_limit',
		  'label' => __('Posts Limit', 'pr'),
		  'description' => __('Set post limit to display on page (0 = unlimited)', 'pr'),
		  'min' => '0',
		  'max' => '500',
		  'step' => '1',
		  'default' => '100',
		),	
		
		/* Items Appearing
		
		array(
			'type' => 'select',
			'name' => 'pr_items_appearing',
			'label' => __('Items Appearing', 'pr'),
			'description' => __('Choose between 8 appearing animations for your items', 'pr'),
			'items' => array(
				array(
					'value' => 'effect-1',
					'label' => __('Fade In', 'pr'),
				),
				array(
					'value' => 'effect-2',
					'label' => __('Move Up', 'pr'),
				),
				array(
					'value' => 'effect-3',
					'label' => __('Scale Up', 'pr'),
				),
				array(
					'value' => 'effect-4',
					'label' => __('Fall Perspective', 'pr'),
				),
				array(
					'value' => 'effect-5',
					'label' => __('Fly', 'pr'),
				),
				array(
					'value' => 'effect-6',
					'label' => __('Flip', 'pr'),
				),
				array(
					'value' => 'effect-7',
					'label' => __('Helix', 'pr'),
				),
				array(
					'value' => 'effect-8',
					'label' => __('Pop Up', 'pr'),
				),
			),
			'default' => array(
				'effect-1',
			),
			'validation' => 'required',
		),*/
		
		// Presets 
		
		array(
			'type' => 'select',
			'name' => 'pr_presets',
			'label' => __('Presets', 'pr'),
			'description' => __('Choose between 27 presets or customize your own', 'pr'),
			'items' => array(
				array(
					'value' => 'manhattan',
					'label' => __('Manhattan', 'pr'),
				),
				array(
					'value' => 'london',
					'label' => __('London', 'pr'),
				),
				array(
					'value' => 'paris',
					'label' => __('Paris', 'pr'),
				),
				array(
					'value' => 'rome',
					'label' => __('Rome', 'pr'),
				),
				array(
					'value' => 'venice',
					'label' => __('Venice', 'pr'),
				),
				array(
					'value' => 'tokyo',
					'label' => __('Tokyo', 'pr'),
				),
				array(
					'value' => 'seul',
					'label' => __('Seul', 'pr'),
				),
				array(
					'value' => 'florence',
					'label' => __('Florence', 'pr'),
				),
				array(
					'value' => 'lasvegas',
					'label' => __('Las Vegas', 'pr'),
				),
				array(
					'value' => 'rio',
					'label' => __('Rio', 'pr'),
				),
				array(
					'value' => 'barcelona',
					'label' => __('Barcelona', 'pr'),
				),
				array(
					'value' => 'sidney',
					'label' => __('Sidney', 'pr'),
				),
				array(
					'value' => 'berlin',
					'label' => __('Berlin', 'pr'),
				),
				array(
					'value' => 'amsterdam',
					'label' => __('Amsterdam', 'pr'),
				),
				array(
					'value' => 'madrid',
					'label' => __('Madrid', 'pr'),
				),
				array(
					'value' => 'moskow',
					'label' => __('Moskow', 'pr'),
				),
				array(
					'value' => 'newdelhi',
					'label' => __('New Delhi', 'pr'),
				),
				array(
					'value' => 'singapore',
					'label' => __('Singapore', 'pr'),
				),
				array(
					'value' => 'beijing',
					'label' => __('Beijing', 'pr'),
				),
				array(
					'value' => 'miami',
					'label' => __('Miami', 'pr'),
				),
				array(
					'value' => 'casablanca',
					'label' => __('Casablanca', 'pr'),
				),
				array(
					'value' => 'dublin',
					'label' => __('Dublin', 'pr'),
				),
				array(
					'value' => 'lima',
					'label' => __('Lima', 'pr'),
				),
				array(
					'value' => 'losangeles',
					'label' => __('Los Angeles', 'pr'),
				),
				array(
					'value' => 'manila',
					'label' => __('Manila', 'pr'),
				),
				array(
					'value' => 'stockholm',
					'label' => __('Stockholm', 'pr'),
				),
				array(
					'value' => 'capetown',
					'label' => __('Cape Town', 'pr'),
				),
				array(
					'value' => 'calgary',
					'label' => __('Calgary', 'pr'),
				),
				array(
					'value' => 'cairo',
					'label' => __('Cairo', 'pr'),
				),
				array(
					'value' => 'athens',
					'label' => __('Athens', 'pr'),
				),
				array(
					'value' => 'custom',
					'label' => __('Custom', 'pr'),
				),
			),
			'default' => array(
				'custom',
			),
			'validation' => 'required',
		),
		
		// Custom Preset 
		
		array(
			'type' => 'group',
			'repeating' => false,
			'length' => 1,
			'name' => 'pr_custom_preset',
			'title' => __('<i class="pricon-settings"></i> Custom Preset', 'pr'),
			'dependency' => array(
				'field' => 'pr_presets',
				'function' => 'pr_custom_preset',
			),
			'fields' => array(
				
				// Fonts
				
				array(
					'type' => 'html',
					'name' => 'pr_fonts_title',
					'binding' => array(
						'field' => '',
						'function' => 'pr_fonts_title',
					),
				 ),
				 
				// Primary Font
				
				array(
					'type' => 'select',
					'name' => 'pr_primary_font',
					'label' => __('Primary Font', 'pr'),
					'description' => __('Select a Google Font as Primary Font (for titles, subtitles and big texts)', 'pr'),
					'items' => array(
						'data' => array(
							array(
							'source' => 'function',
							'value' => 'vp_get_gwf_family',
							),
						),
					),
					'default' => 'Oswald',
				), 
				
				// Secondary Font
				
				array(
					'type' => 'select',
					'name' => 'pr_secondary_font',
					'label' => __('Secondary Font', 'pr'),
					'description' => __('Select a Google Font as Secondary Font (for content, excerpt and small texts)', 'pr'),
					'items' => array(
						'data' => array(
							array(
							'source' => 'function',
							'value' => 'vp_get_gwf_family',
							),
						),
					),
					'default' => 'Roboto Condensed',
				), 
				 
				// Thumbnails
				
				array(
					'type' => 'html',
					'name' => 'pr_thumbnails_title',
					'binding' => array(
						'field' => '',
						'function' => 'pr_thumbnails_title',
					),
				 ),

		
				// Thumb Cols
				
				array(
					'type' => 'radioimage',
					'name' => 'pr_thumb_cols',
					'label' => __('Thumb Columns', 'pr'),
					'description' => __('Setup your grid with the number of columns you want (note: the grid will reduce this number if your wrapper is too small, so for <b>6 columns</b> you need a content wrapper of <b>1800px</b>, for <b>5 columns</b> you need <b>1600px</b> an so on.)', 'pr'),
					'item_max_height' => '94',
					'item_max_width' => '94',
					'items' => array(
						array(
							'value' => 'column-6',
							'label' => __('6 Columns', 'pr'),
							'img' => PR_URL.'assets/img/col-6.jpg',
						),
						array(
							'value' => 'column-5',
							'label' => __('5 Columns', 'pr'),
							'img' => PR_URL.'assets/img/col-5.jpg',
						),
						array(
							'value' => 'column-4',
							'label' => __('4 Columns', 'pr'),
							'img' => PR_URL.'assets/img/col-4.jpg',
						),
						array(
							'value' => 'column-3',
							'label' => __('3 Columns', 'pr'),
							'img' => PR_URL.'assets/img/col-3.jpg',
						),
						array(
							'value' => 'column-2',
							'label' => __('2 Columns', 'pr'),
							'img' => PR_URL.'assets/img/col-2.jpg',
						),
					
					),
					'default' => array(
						'column-3',
					),
					'validation' => 'required',
				),
				
				// Thumb Shape
				
				array(
					'type' => 'radioimage',
					'name' => 'pr_thumb_shape',
					'label' => __('Thumb Shape', 'pr'),
					'description' => __('Choose the shape for your thumb (random feature will show your thumbs with 3 different shapes like a masonry grid)', 'pr'),
					'item_max_height' => '92',
					'item_max_width' => '92',
					'items' => array(
						array(
							'value' => 'pr-thumb-square',
							'label' => __('Square', 'pr'),
							'img' => PR_URL.'assets/img/square.jpg',
						),
						array(
							'value' => 'pr-thumb-land',
							'label' => __('Landscape', 'pr'),
							'img' => PR_URL.'assets/img/landscape.jpg',
						),
						array(
							'value' => 'pr-thumb-port',
							'label' => __('Portrait', 'pr'),
							'img' => PR_URL.'assets/img/portrait.jpg',
						),
						array(
							'value' => 'random',
							'label' => __('Random', 'pr'),
							'img' => PR_URL.'assets/img/random.jpg',
						),					
					),
					'default' => array(
						'random',
					),
					'validation' => 'required',
				),
				
				// Thumb Over Effect
				
				array(
					'type' => 'select',
					'name' => 'pr_thumb_hover',
					'label' => __('Thumb Over Effect', 'pr'),
					'description' => __('Choose between 4 over effects for your thumbs', 'pr'),
					'items' => array(
						array(
							'value' => '0',
							'label' => __('None', 'pr'),
						),
						array(
							'value' => 'hover-1',
							'label' => __('Zoom', 'pr'),
						),
						array(
							'value' => 'hover-2',
							'label' => __('Opacity', 'pr'),
						),
						
					),
					'default' => array(
						'hover-1',
					),
					'validation' => 'required',
				),
				
				// Captions
				
				array(
					'type' => 'html',
					'name' => 'pr_caption_title',
					'binding' => array(
						'field' => '',
						'function' => 'pr_caption_title',
					),
				 ),
				
				// Shape Group
				array(
					'type' => 'group',
					'repeating' => false,
					'length' => 1,
					'name' => 'pr_caption_shape_group',
					'title' => __('<i class="pricon-star pr-caption-shape"></i> Shape', 'pr'),
					'fields' => array(
					
						// Caption Shape
				
						array(
							'type' => 'select',
							'name' => 'pr_shape',
							'label' => __('Type', 'pr'),
							'description' => __('Choose between 14 caption shapes for your thumb', 'pr'),
							'items' => array(
								array(
									'value' => 'shape-1',
									'label' => __('Full Caption', 'pr'),
								),
								array(
									'value' => 'shape-2',
									'label' => __('Inner Frame', 'pr'),
								),
								array(
									'value' => 'shape-3',
									'label' => __('Border Rounded Bottom', 'pr'),
								),
								array(
									'value' => 'shape-4',
									'label' => __('Inner Frame Large', 'pr'),
								),
								array(
									'value' => 'shape-5',
									'label' => __('Outer Vertical', 'pr'),
								),
								array(
									'value' => 'shape-6',
									'label' => __('Outer Horizontal', 'pr'),
								),
								array(
									'value' => 'shape-7',
									'label' => __('Translated', 'pr'),
								),
								array(
									'value' => 'shape-8',
									'label' => __('Outer Frame', 'pr'),
								),
								array(
									'value' => 'shape-9',
									'label' => __('Outer Frame Large', 'pr'),
								),
								array(
									'value' => 'shape-10',
									'label' => __('Borders Rounded', 'pr'),
								),
								array(
									'value' => 'shape-11',
									'label' => __('Curtain Vertical', 'pr'),
								),
								array(
									'value' => 'shape-12',
									'label' => __('Curtain Horizontal', 'pr'),
								),
								array(
									'value' => 'shape-13',
									'label' => __('Inner Frame Top Border Rounded', 'pr'),
								),
								array(
									'value' => 'shape-14',
									'label' => __('Border Rounded Top', 'pr'),
								),
							),
							'default' => array(
								'shape-1',
							),
							'validation' => 'required',
						),
						
						// Caption Shape Animation
						
						array(
							'type' => 'select',
							'name' => 'pr_shape_animation',
							'label' => __('Animation', 'pr'),
							'description' => __('Choose between 10 shape animations', 'pr'),
							'items' => array(
								array(
									'value' => 'entry-caption-1',
									'label' => __('Bounce In', 'pr'),
								),
								array(
									'value' => 'entry-caption-2',
									'label' => __('Swing', 'pr'),
								),
								array(
									'value' => 'entry-caption-3',
									'label' => __('Fade In Up Big', 'pr'),
								),
								array(
									'value' => 'entry-caption-4',
									'label' => __('Flip In X', 'pr'),
								),
								array(
									'value' => 'entry-caption-5',
									'label' => __('Fade In', 'pr'),
								),
								array(
									'value' => 'entry-caption-6',
									'label' => __('Bounce', 'pr'),
								),
								array(
									'value' => 'entry-caption-7',
									'label' => __('Slide In Down', 'pr'),
								),
								array(
									'value' => 'entry-caption-8',
									'label' => __('Pulse', 'pr'),
								),
								array(
									'value' => 'entry-caption-9',
									'label' => __('Slide In Left', 'pr'),
								),
								array(
									'value' => 'entry-caption-10',
									'label' => __('Slide In Right', 'pr'),
								),
							),
							'default' => array(
								'entry-caption-1',
							),
							'validation' => 'required',
						),
								
						// Caption Shape Animation Speed
						
						array(
							'type' => 'select',
							'name' => 'pr_shape_amination_speed',
							'label' => __('Animation Speed', 'pr'),
							'description' => __('Choose between 3 shape animation speeds', 'pr'),
							'items' => array(
								array(
									'value' => 'animated-1',
									'label' => __('Slow', 'pr'),
								),
								array(
									'value' => 'animated-2',
									'label' => __('Medium', 'pr'),
								),
								array(
									'value' => 'animated-3',
									'label' => __('Fast', 'pr'),
								),
							),
							'default' => array(
								'animated-1',
							),
							'validation' => 'required',
						),
						
						// Caption Shape BG Color
						
						array(
						  'type' => 'color',
						  'name' => 'pr_shape_bgcolor',
						  'label' => __('Background Color', 'pr'),
						  'description' => __('Select a color for your shape backgorund (opacity is allowed)', 'pr'),
						  'default' => 'rgba(0,0,0,0.7)',
						  'format' => 'rgba',
						  'validation' => 'required',
						),
						
						// Permalink Icon
						
						array(
						  'type' => 'toggle',
						  'name' => 'pr_permalink_icon',
						  'label' => __('Permalink Icon', 'pr'),
						  'description' => __('Enable/Disable the icon with Permalink', 'pr'),
						),
					),
				),
				
				// Title Group
				
				array(
					'type' => 'group',
					'repeating' => false,
					'length' => 1,
					'name' => 'pr_caption_title_group',
					'title' => __('<i class="pricon-font pr-caption-title"></i> Title', 'pr'),
					'fields' => array(
					
						// Title Color
				
						array(
						  'type' => 'color',
						  'name' => 'pr_title_color',
						  'label' => __('Color', 'pr'),
						  'description' => __('Select a color for your title', 'pr'),
						  'default' => '#ffffff',
						  'validation' => 'required',				  
						),	
						
						// Title Size
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_title_size',
						  'label' => __('Size', 'pr'),
						  'description' => __('Choose a size for your title (px)', 'pr'),
						  'min' => '20',
						  'max' => '40',
						  'step' => '1',
						  'default' => '35',
						  'validation' => 'required',				  
						),	
						
						// Title Weight
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_title_weight',
						  'label' => __('Weight', 'pr'),
						  'description' => __('Choose a weight for your title', 'pr'),
						  'min' => '100',
						  'max' => '900',
						  'step' => '100',
						  'default' => '400',
						  'validation' => 'required',				  
						),	
						
						// Title Style
						
						array(
							'type' => 'select',
							'name' => 'pr_title_style',
							'label' => __('Style', 'pr'),
							'description' => __('Choose "Normal" or "Italic" style for your title', 'pr'),
							'items' => array(
								array(
									'value' => 'normal',
									'label' => __('Normal', 'pr'),
								),
								array(
									'value' => 'italic',
									'label' => __('Italic', 'pr'),
								),
							),
							'default' => array(
								'normal',
							),
							'validation' => 'required',
						),				
					),
				),
				
				// SubTitle Group
				
				array(
					'type' => 'group',
					'repeating' => false,
					'length' => 1,
					'name' => 'pr_caption_subtitle_group',
					'title' => __('<i class="pricon-bold pr-caption-subtitle"></i> Subtitle', 'pr'),
					'fields' => array(
					
						// Subtitle Source
						
						array(
							'type' => 'select',
							'name' => 'pr_subtitle_source',
							'label' => __('Source', 'pr'),
							'description' => __('Choose the subtitle source or disbale it', 'pr'),
							'items' => array(
								array(
									'value' => '0',
									'label' => __('Disabled', 'pr'),
								),
								array(
									'value' => 'excerpt',
									'label' => __('Excerpt (Post & Woocommerce)', 'pr'),
								),
								array(
									'value' => 'categories',
									'label' => __('List of Categories (only Post)', 'pr'),
								),
								array(
									'value' => 'tags',
									'label' => __('List of Tags (only Post)', 'pr'),
								),
								array(
									'value' => 'price',
									'label' => __('Price (only Woocommerce)', 'pr'),
								),
							),
							'default' => array(
								'excerpt',
							),
							'validation' => 'required',
						),
						
						// Subtitle BG Color
						
						array(
						  'type' => 'color',
						  'name' => 'pr_subtitle_bgcolor',
						  'label' => __('Background Color', 'pr'),
						  'description' => __('Select a color for your caption subtitle backgorund (opacity is allowed)', 'pr'),
						  'dependency' => array(
								'field' => 'pr_subtitle_source',
								'function' => 'pr_dep_enabled',
								),
						  'default' => 'rgba(255,255,255,1)',
						  'format' => 'rgba',
						  'validation' => 'required',
						 ),
						 
						// Subtitle Color
						
						array(
						  'type' => 'color',
						  'name' => 'pr_subtitle_color',
						  'label' => __('Color', 'pr'),
						  'description' => __('Select a color for your subtitle font', 'pr'),
						  'dependency' => array(
								'field' => 'pr_subtitle_source',
								'function' => 'pr_dep_enabled',
								),
						  'default' => '#000000',
						  'validation' => 'required',
						),
						
						// Subtitle Size
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_subtitle_size',
						  'label' => __('Size', 'pr'),
						  'description' => __('Choose a size for your subtitle (px)', 'pr'),
						  'dependency' => array(
								'field' => 'pr_subtitle_source',
								'function' => 'pr_dep_enabled',
								),
						  'min' => '15',
						  'max' => '35',
						  'step' => '1',
						  'default' => '20',
						  'validation' => 'required',				  
						),	
						
						// Subtitle Weight
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_subtitle_weight',
						  'label' => __('Weight', 'pr'),
						  'description' => __('Choose a weight for your subtitle', 'pr'),
						  'dependency' => array(
								'field' => 'pr_subtitle_source',
								'function' => 'pr_dep_enabled',
								),
						  'min' => '100',
						  'max' => '900',
						  'step' => '100',
						  'default' => '300',
						  'validation' => 'required',				  
						),	
						
						// Subtitle Style
						
						array(
							'type' => 'select',
							'name' => 'pr_subtitle_style',
							'label' => __('Style', 'pr'),
							'description' => __('Choose "Normal" or "Italic" style for your subtitle', 'pr'),
							'dependency' => array(
								'field' => 'pr_subtitle_source',
								'function' => 'pr_dep_enabled',
								),
							'items' => array(
								array(
									'value' => 'normal',
									'label' => __('Normal', 'pr'),
								),
								array(
									'value' => 'italic',
									'label' => __('Italic', 'pr'),
								),
							),
							'default' => array(
								'normal',
							),
							'validation' => 'required',
						),			
					),
				),
				
				// Metas Group
				
				array(
					'type' => 'group',
					'repeating' => false,
					'length' => 1,
					'name' => 'pr_caption_metas_group',
					'title' => __('<i class="pricon-tags pr-caption-metas"></i> Metas', 'pr'),
					'fields' => array(
					
						// Metas
				
						array(
							'type' => 'toggle',
							'name' => 'pr_metas',
							'label' => __('Enable Metas', 'pr'),
							'description' => __('Enable/Disable the metas to the bottom of the caption (only visible on <b>Post source</b> and if the image is <b>high enough</b>)', 'pr'),
							'default' => '1',
						),
						
						// Metas Color
						
						array(
						  'type' => 'color',
						  'name' => 'pr_metas_color',
						  'label' => __('Color', 'pr'),
						  'description' => __('Select a color for your metas font', 'pr'),
						  'dependency' => array(
								'field' => 'pr_metas',
								'function' => 'vp_dep_boolean',
						  ),
						  'default' => '#ffffff',
						  'validation' => 'required',
						),
						
						// Metas Size
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_metas_size',
						  'label' => __('Size', 'pr'),
						  'description' => __('Choose a size for your metas (px)', 'pr'),
						  'dependency' => array(
								'field' => 'pr_metas',
								'function' => 'vp_dep_boolean',
								),
						  'min' => '10',
						  'max' => '20',
						  'step' => '1',
						  'default' => '14',
						  'validation' => 'required',				  
						),	
						
						// Metas Weight
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_metas_weight',
						  'label' => __('Weight', 'pr'),
						  'description' => __('Choose a weight for your metas', 'pr'),
						  'dependency' => array(
								'field' => 'pr_metas',
								'function' => 'vp_dep_boolean',
						  		),
						  'min' => '100',
						  'max' => '900',
						  'step' => '100',
						  'default' => '300',
						  'validation' => 'required',				  
						),	
						
						// Metas Style
						
						array(
							'type' => 'select',
							'name' => 'pr_metas_style',
							'label' => __('Style', 'pr'),
							'description' => __('Choose "Normal" or "Italic" style for your metas', 'pr'),
							'dependency' => array(
								'field' => 'pr_metas',
								'function' => 'vp_dep_boolean',
								),
							'items' => array(
								array(
									'value' => 'normal',
									'label' => __('Normal', 'pr'),
								),
								array(
									'value' => 'italic',
									'label' => __('Italic', 'pr'),
								),
							),
							'default' => array(
								'normal',
							),
							'validation' => 'required',
						),							
					),
				),
				 
				// Excerpt
				
				array(
					'type' => 'html',
					'name' => 'pr_excerpt_title',
					'binding' => array(
						'field' => '',
						'function' => 'pr_excerpt_title',
					),
				),
				
				// Excerpt Style
				
				array(
					'type' => 'select',
					'name' => 'pr_excerpt_style',
					'label' => __('Excerpt Style', 'pr'),
					'description' => __('Choose between 4 Excerpt types', 'pr'),
					'items' => array(
						array(
							'value' => '0',
							'label' => __('None', 'pr'),
						),
						array(
							'value' => 'excerpt-3',
							'label' => __('Category (only Post)', 'pr'),
						),
						array(
							'value' => 'excerpt-4',
							'label' => __('Title (Post & Woocommerce)', 'pr'),
						),
					),
					'default' => array(
						'excerpt-1',
					),
					'validation' => 'required',
				),
				
				// Excerpt BG
				
				array(
				   'type' => 'color',
				   'name' => 'pr_excerpt_bg',
				   'label' => __('Excerpt BG Color', 'pr'),
				   'description' => __('Select a color for the background of your excerpt', 'pr'),
				   'default' => 'rgba(255,255,255,1)',
				   'format' => 'rgba',
				   'validation' => 'required',
				   'dependency' => array(
						'field' => 'pr_excerpt_style',
						'function' => 'pr_dep_enabled',
					),				  
				),	
				
				// Header Group
				
				array(
					'type' => 'group',
					'repeating' => false,
					'length' => 1,
					'name' => 'pr_excerpt_header_group',
					'title' => __('<i class="pricon-type pr-excerpt-header"></i> Header', 'pr'),
					'dependency' => array(
						'field' => 'pr_excerpt_style',
						'function' => 'pr_dep_enabled',
					),
					'fields' => array(
					
						// Header Color
				
						array(
						  'type' => 'color',
						  'name' => 'pr_header_color',
						  'label' => __('Color', 'pr'),
						  'description' => __('Select a color for your header section', 'pr'),
						  'default' => '#222222',
						  'validation' => 'required',				  
						),	
						
						// Header Over Color
				
						array(
						  'type' => 'color',
						  'name' => 'pr_header_over_color',
						  'label' => __('Mouseover Color', 'pr'),
						  'description' => __('Select a color for the over of your header section', 'pr'),
						  'default' => '#cccccc',
						  'validation' => 'required',				  
						),	
						
						// Header Size
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_header_size',
						  'label' => __('Size', 'pr'),
						  'description' => __('Choose a size for your header section (px)', 'pr'),
						  'min' => '14',
						  'max' => '28',
						  'step' => '1',
						  'default' => '22',
						  'validation' => 'required',				  
						),	
						
						// Header Weight
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_header_weight',
						  'label' => __('Weight', 'pr'),
						  'description' => __('Choose a weight for your header section', 'pr'),
						  'min' => '100',
						  'max' => '900',
						  'step' => '100',
						  'default' => '400',
						  'validation' => 'required',				  
						),	
						
						// Header Style
						
						array(
							'type' => 'select',
							'name' => 'pr_header_style',
							'label' => __('Style', 'pr'),
							'description' => __('Choose "Normal" or "Italic" style for your header section', 'pr'),
							'items' => array(
								array(
									'value' => 'normal',
									'label' => __('Normal', 'pr'),
								),
								array(
									'value' => 'italic',
									'label' => __('Italic', 'pr'),
								),
							),
							'default' => array(
								'normal',
							),
							'validation' => 'required',
						),
					),
				),
				
				// Content Group
				
				array(
					'type' => 'group',
					'repeating' => false,
					'length' => 1,
					'name' => 'pr_excerpt_content_group',
					'title' => __('<i class="pricon-menu-2 pr-excerpt-content"></i> Content', 'pr'),
					'dependency' => array(
						'field' => 'pr_excerpt_style',
						'function' => 'pr_dep_enabled',
					),
					'fields' => array(
					
						// Content Color
				
						array(
						  'type' => 'color',
						  'name' => 'pr_content_color',
						  'label' => __('Color', 'pr'),
						  'description' => __('Select a color for your content section', 'pr'),
						  'default' => '#666666',
						  'validation' => 'required',				  
						),	
						
						// Content Size
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_content_size',
						  'label' => __('Size', 'pr'),
						  'description' => __('Choose a size for your content section (px)', 'pr'),
						  'min' => '11',
						  'max' => '20',
						  'step' => '1',
						  'default' => '14',
						  'validation' => 'required',				  
						),	
						
						// Content Weight
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_content_weight',
						  'label' => __('Weight', 'pr'),
						  'description' => __('Choose a weight for your content section', 'pr'),
						  'min' => '100',
						  'max' => '900',
						  'step' => '100',
						  'default' => '300',
						  'validation' => 'required',				  
						),	
						
						// Content Style
						
						array(
							'type' => 'select',
							'name' => 'pr_content_style',
							'label' => __('Style', 'pr'),
							'description' => __('Choose "Normal" or "Italic" style for your content section', 'pr'),
							'items' => array(
								array(
									'value' => 'normal',
									'label' => __('Normal', 'pr'),
								),
								array(
									'value' => 'italic',
									'label' => __('Italic', 'pr'),
								),
							),
							'default' => array(
								'normal',
							),
							'validation' => 'required',
						),
					),
				),
				
				// Button Group
				
				array(
					'type' => 'group',
					'repeating' => false,
					'length' => 1,
					'name' => 'pr_excerpt_button_group',
					'title' => __('<i class="pricon-hand-right pr-excerpt-button"></i> Read More Button', 'pr'),
					'dependency' => array(
						'field' => 'pr_excerpt_style',
						'function' => 'pr_dep_enabled',
					),
					'fields' => array(
						
						// Button Text
				
						array(
						  'type' => 'textbox',
						  'name' => 'pr_button_text',
						  'label' => __('Text', 'pr'),
						  'description' => __('Insert yout preferred text for the button', 'pr'),
						  'default' => 'Read More',
						  'validation' => 'required',				  
						),	
						
						// Button Text Color
				
						array(
						  'type' => 'color',
						  'name' => 'pr_button_color',
						  'label' => __('Text Color', 'pr'),
						  'description' => __('Select a color for the text of the button', 'pr'),
						  'default' => '#333333',
						  'validation' => 'required',				  
						),	
						
						// Button Size
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_button_size',
						  'label' => __('Size', 'pr'),
						  'description' => __('Choose a size for the text of the button (px)', 'pr'),
						  'min' => '11',
						  'max' => '20',
						  'step' => '1',
						  'default' => '14',
						  'validation' => 'required',				  
						),	
						
						// Button Weight
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_button_weight',
						  'label' => __('Weight', 'pr'),
						  'description' => __('Choose a weight for the text of the button', 'pr'),
						  'min' => '100',
						  'max' => '900',
						  'step' => '100',
						  'default' => '300',
						  'validation' => 'required',				  
						),	
						
						// Button Style
						
						array(
							'type' => 'select',
							'name' => 'pr_button_style',
							'label' => __('Style', 'pr'),
							'description' => __('Choose "Normal" or "Italic" style for the text of the button', 'pr'),
							'items' => array(
								array(
									'value' => 'normal',
									'label' => __('Normal', 'pr'),
								),
								array(
									'value' => 'italic',
									'label' => __('Italic', 'pr'),
								),
							),
							'default' => array(
								'normal',
							),
							'validation' => 'required',
						),
					),
				),
				
				// Preview
				
				array(
					'type' => 'html',
					'name' => 'pr_preview_title',
					'binding' => array(
						'field' => '',
						'function' => 'pr_preview_title',
					),
				),
				
				// Preview
				
				array(
					'type' => 'toggle',
					'name' => 'pr_preview_enable',
					'label' => __('Enable Post Preview', 'pr'),
					'description' => __('An amazing preview lightbox for your <b>posts</b> or <b>products</b>', 'pr'),
				),
				
				// Preview Style
				
				array(
					'type' => 'select',
					'name' => 'pr_preview_style',
					'label' => __('Preview Lightbox Style', 'pr'),
					'description' => __('Choose between 6 preview styles', 'pr'),
					'dependency' => array(
								'field' => 'pr_preview_enable',
								'function' => 'vp_dep_boolean',
					),
					'items' => array(
						array(
							'value' => 'preview-overlay-1',
							'label' => __('Landscape', 'pr'),
						),
						array(
							'value' => 'preview-overlay-2',
							'label' => __('Boxed', 'pr'),
						),
						array(
							'value' => 'preview-overlay-3',
							'label' => __('Porthole', 'pr'),
						),
						array(
							'value' => 'preview-overlay-4',
							'label' => __('Bubble', 'pr'),
						),
						array(
							'value' => 'preview-overlay-5',
							'label' => __('Rounded', 'pr'),
						),
						array(
							'value' => 'preview-overlay-6',
							'label' => __('Shadow', 'pr'),
						),
					),
					'default' => array(
						'preview-overlay-1',
					),
					'validation' => 'required',
				),
				
				// Preview Animation
				
				array(
					'type' => 'select',
					'name' => 'pr_preview_animation',
					'label' => __('Preview Lightbox Animation', 'pr'),
					'description' => __('Choose between 12 preview animations', 'pr'),
					'dependency' => array(
								'field' => 'pr_preview_enable',
								'function' => 'vp_dep_boolean',
					),
					'items' => array(
						array(
							'value' => 'entry-preview-1',
							'label' => __('Bounce In', 'pr'),
						),
						array(
							'value' => 'entry-preview-2',
							'label' => __('Swing', 'pr'),
						),
						array(
							'value' => 'entry-preview-3',
							'label' => __('Fade In Up Big', 'pr'),
						),
						array(
							'value' => 'entry-preview-5',
							'label' => __('Fade In', 'pr'),
						),
						array(
							'value' => 'entry-preview-6',
							'label' => __('Bounce', 'pr'),
						),
						array(
							'value' => 'entry-preview-7',
							'label' => __('Slide In Down', 'pr'),
						),
						array(
							'value' => 'entry-preview-8',
							'label' => __('Pulse', 'pr'),
						),
						array(
							'value' => 'entry-preview-9',
							'label' => __('Bounce In Down', 'pr'),
						),
						array(
							'value' => 'entry-preview-11',
							'label' => __('Slide In Left', 'pr'),
						),
						array(
							'value' => 'entry-preview-12',
							'label' => __('Slide in RIght', 'pr'),
						),
					),
					'default' => array(
						'entry-preview-1',
					),
					'validation' => 'required',
				),
				
				// Preview Speed
				
				array(
					'type' => 'select',
					'name' => 'pr_preview_speed',
					'label' => __('Preview Animation Speed', 'pr'),
					'description' => __('Choose between 3 preview animation speed', 'pr'),
					'dependency' => array(
								'field' => 'pr_preview_enable',
								'function' => 'vp_dep_boolean',
					),
					'items' => array(
						array(
							'value' => 'animated-1',
							'label' => __('Slow', 'pr'),
						),
						array(
							'value' => 'animated-2',
							'label' => __('Medium', 'pr'),
						),
						array(
							'value' => 'animated-3',
							'label' => __('Fast', 'pr'),
						),
					),
					'default' => array(
						'animated-1',
					),
					'validation' => 'required',
				),
				
				// Preview Drag
				
				array(
					'type' => 'toggle',
					'name' => 'pr_preview_drag',
					'label' => __('Drag Scrolling', 'pr'),
					'description' => __('Scroll the preview text with the mouse drag', 'pr'),
					'dependency' => array(
								'field' => 'pr_preview_enable',
								'function' => 'vp_dep_boolean',
					),
				),
				
				// Preview Title Group
				
				array(
					'type' => 'group',
					'repeating' => false,
					'length' => 1,
					'name' => 'pr_preview_title_group',
					'title' => __('<i class="pricon-font pr-preview-title"></i> Title', 'pr'),
					'dependency' => array(
								'field' => 'pr_preview_enable',
								'function' => 'vp_dep_boolean',
					),
					'fields' => array(
					
						// Title Color
				
						array(
						  'type' => 'color',
						  'name' => 'pr_title_color',
						  'label' => __('Color', 'pr'),
						  'description' => __('Select a color for your title', 'pr'),
						  'default' => '#222222',
						  'validation' => 'required',				  
						),	
						
						// Title Size
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_title_size',
						  'label' => __('Size', 'pr'),
						  'description' => __('Choose a size for your title (px)', 'pr'),
						  'min' => '30',
						  'max' => '60',
						  'step' => '1',
						  'default' => '50',
						  'validation' => 'required',				  
						),	
						
						// Title Weight
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_title_weight',
						  'label' => __('Weight', 'pr'),
						  'description' => __('Choose a weight for your title', 'pr'),
						  'min' => '100',
						  'max' => '900',
						  'step' => '100',
						  'default' => '400',
						  'validation' => 'required',				  
						),	
						
						// Title Style
						
						array(
							'type' => 'select',
							'name' => 'pr_title_style',
							'label' => __('Style', 'pr'),
							'description' => __('Choose "Normal" or "Italic" style for your title', 'pr'),
							'items' => array(
								array(
									'value' => 'normal',
									'label' => __('Normal', 'pr'),
								),
								array(
									'value' => 'italic',
									'label' => __('Italic', 'pr'),
								),
							),
							'default' => array(
								'normal',
							),
							'validation' => 'required',
						),				
					),
				),
				
				// SubTitle Group
				
				array(
					'type' => 'group',
					'repeating' => false,
					'length' => 1,
					'name' => 'pr_preview_subtitle_group',
					'title' => __('<i class="pricon-bold pr-preview-subtitle"></i> Subtitle', 'pr'),
					'dependency' => array(
								'field' => 'pr_preview_enable',
								'function' => 'vp_dep_boolean',
					),
					'fields' => array(
										
						// Subtitle BG Color
						
						array(
						  'type' => 'color',
						  'name' => 'pr_subtitle_bgcolor',
						  'label' => __('Background Color', 'pr'),
						  'description' => __('Select a color for your subtitle backgorund (opacity is allowed)', 'pr'),
						  'default' => '#222222',
						  'validation' => 'required',
						 ),
						 
						// Subtitle Color
						
						array(
						  'type' => 'color',
						  'name' => 'pr_subtitle_color',
						  'label' => __('Color', 'pr'),
						  'description' => __('Select a color for your subtitle font', 'pr'),
						  'default' => '#000000',
						  'validation' => 'required',
						),
						
						// Subtitle Size
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_subtitle_size',
						  'label' => __('Size', 'pr'),
						  'description' => __('Choose a size for your subtitle (px)', 'pr'),
						  'min' => '15',
						  'max' => '35',
						  'step' => '1',
						  'default' => '20',
						  'validation' => 'required',				  
						),	
						
						// Subtitle Weight
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_subtitle_weight',
						  'label' => __('Weight', 'pr'),
						  'description' => __('Choose a weight for your subtitle', 'pr'),
						  'min' => '100',
						  'max' => '900',
						  'step' => '100',
						  'default' => '300',
						  'validation' => 'required',				  
						),	
						
						// Subtitle Style
						
						array(
							'type' => 'select',
							'name' => 'pr_subtitle_style',
							'label' => __('Style', 'pr'),
							'description' => __('Choose "Normal" or "Italic" style for your subtitle', 'pr'),
							'items' => array(
								array(
									'value' => 'normal',
									'label' => __('Normal', 'pr'),
								),
								array(
									'value' => 'italic',
									'label' => __('Italic', 'pr'),
								),
							),
							'default' => array(
								'normal',
							),
							'validation' => 'required',
						),			
					),
				),
				
				// Content Group
					
				array(
					'type' => 'group',
					'repeating' => false,
					'length' => 1,
					'name' => 'pr_preview_content_group',
					'title' => __('<i class="pricon-menu-2 pr-preview-content"></i> Content', 'pr'),
					'dependency' => array(
								'field' => 'pr_preview_enable',
								'function' => 'vp_dep_boolean',
					),
					'fields' => array(
					
						// Content Color
				
						array(
						  'type' => 'color',
						  'name' => 'pr_content_color',
						  'label' => __('Color', 'pr'),
						  'description' => __('Select a color for your content section', 'pr'),
						  'default' => '#666666',
						  'validation' => 'required',				  
						),	
						
						// Content Size
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_content_size',
						  'label' => __('Size', 'pr'),
						  'description' => __('Choose a size for your content section (px)', 'pr'),
						  'min' => '11',
						  'max' => '20',
						  'step' => '1',
						  'default' => '14',
						  'validation' => 'required',				  
						),	
						
						// Content Weight
				
						array(
						  'type' => 'slider',
						  'name' => 'pr_content_weight',
						  'label' => __('Weight', 'pr'),
						  'description' => __('Choose a weight for your content section', 'pr'),
						  'min' => '100',
						  'max' => '900',
						  'step' => '100',
						  'default' => '300',
						  'validation' => 'required',				  
						),	
						
						// Content Style
						
						array(
							'type' => 'select',
							'name' => 'pr_content_style',
							'label' => __('Style', 'pr'),
							'description' => __('Choose "Normal" or "Italic" style for your content section', 'pr'),
							'items' => array(
								array(
									'value' => 'normal',
									'label' => __('Normal', 'pr'),
								),
								array(
									'value' => 'italic',
									'label' => __('Italic', 'pr'),
								),
							),
							'default' => array(
								'normal',
							),
							'validation' => 'required',  
						),
					),				
				),			
			),
    	),
	),
);