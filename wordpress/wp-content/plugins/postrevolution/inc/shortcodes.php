<?php
/*
File: inc/shortcodes.php
Description: Plugin shortcodes
Plugin: Post Revolution
Author: unCommons
*/


// Add main short 

function pr_postrevolution_short( $atts, $content = null ) {
	
	// Enqueue CSS & SCRIPTS
	
	wp_enqueue_style('pr-main-style');
    wp_enqueue_style('pr-icons-style');
	wp_enqueue_style('pr-pretty-style');
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-masonry');
	
	wp_enqueue_script('pr-isotope-script');
	wp_enqueue_script('pr-pep-script');
	wp_enqueue_script('pr-pretty-script');
	wp_enqueue_script('pr-frontend-script');
	
	// Attributes
	extract( shortcode_atts( array('layout' => ''), $atts )); 
	
	if ( 'publish' != get_post_status ( $layout ) ) {
    	return __('We are sorry but the Layout you selected not exixts or isn\'t publish yet', 'pr');
	}
	
	// Layout Options
	$layouts_grid = vp_metabox('pr_layouts_meta.pr_layouts_grid', '', $layout);
	
	$grid_loader = vp_metabox('pr_layouts_meta.pr_grid_loader', '', $layout);
	
	if (empty($grid_loader)) {
		$grid_loader = PR_URL.'assets/img/spin-2.gif';
	}
	
	$source = vp_metabox('pr_layouts_meta.pr_source', '', $layout);
	
	if (empty($source)) { $source = 'post'; }
	
	if($source == 'post'){
		$category_filter = vp_metabox('pr_layouts_meta.pr_category_filter', '', $layout);
	}
	
	if($source == 'product'){
		$category_filter = vp_metabox('pr_layouts_meta.pr_woo_category_filter', '', $layout);
	}
	
	if($source == 'prgalleries'){
		$gallery_id = vp_metabox('pr_layouts_meta.pr_gallery_item', '', $layout);
		$gallery_array = vp_metabox('pr_galleries_meta.pr_gallery', '', $gallery_id);
	}


	$posts_limit = vp_metabox('pr_layouts_meta.pr_posts_limit', '', $layout);
	if( $posts_limit == 0 ){ $posts_limit = '-1'; }
	
	$items_appearing = vp_metabox('pr_layouts_meta.pr_items_appearing', '', $layout);
	
	$preset = vp_metabox('pr_layouts_meta.pr_presets', '', $layout);
	
	if( !empty($category_filter) ) {
		if (in_array('all', $category_filter)) {
			$category_filter = -1;
			$category_woo_filter = -1;
		}else{
			$category_woo_filter = $category_filter;
			$category_filter = join(",", $category_filter);
			
		}
	}else{
		$category_filter = -1;
		$category_woo_filter = -1;
	}
	

	switch ($preset) {
		
		case 'manhattan':
		require_once(PR_DIR.'inc/presets/manhattan.php');
		break;
		
		case 'london':
		require_once(PR_DIR.'inc/presets/london.php');
		break;
		
		case 'paris':
		require_once(PR_DIR.'inc/presets/paris.php');
		break;
		
		case 'rome':
		require_once(PR_DIR.'inc/presets/rome.php');
		break;
		
		case 'venice':
		require_once(PR_DIR.'inc/presets/venice.php');
		break;
		
		case 'tokyo':
		require_once(PR_DIR.'inc/presets/tokyo.php');
		break;
		
		case 'seul':
		require_once(PR_DIR.'inc/presets/seul.php');
		break;
		
		case 'florence':
		require_once(PR_DIR.'inc/presets/florence.php');
		break;
		
		case 'lasvegas':
		require_once(PR_DIR.'inc/presets/lasvegas.php');
		break;
		
		case 'rio':
		require_once(PR_DIR.'inc/presets/rio.php');
		break;
		
		case 'barcelona':
		require_once(PR_DIR.'inc/presets/barcelona.php');
		break;
		
		case 'sidney':
		require_once(PR_DIR.'inc/presets/sidney.php');
		break;
		
		case 'berlin':
		require_once(PR_DIR.'inc/presets/berlin.php');
		break;
		
		case 'amsterdam':
		require_once(PR_DIR.'inc/presets/amsterdam.php');
		break;
		
		case 'madrid':
		require_once(PR_DIR.'inc/presets/madrid.php');
		break;
		
		case 'moskow':
		require_once(PR_DIR.'inc/presets/moskow.php');
		break;
		
		case 'newdelhi':
		require_once(PR_DIR.'inc/presets/newdelhi.php');
		break;
		
		case 'singapore':
		require_once(PR_DIR.'inc/presets/singapore.php');
		break;
		
		case 'beijing':
		require_once(PR_DIR.'inc/presets/beijing.php');
		break;
		
		case 'miami':
		require_once(PR_DIR.'inc/presets/miami.php');
		break;
		
		case 'casablanca':
		require_once(PR_DIR.'inc/presets/casablanca.php');
		break;
		
		case 'dublin':
		require_once(PR_DIR.'inc/presets/dublin.php');
		break;
		
		case 'lima':
		require_once(PR_DIR.'inc/presets/lima.php');
		break;
		
		case 'losangeles':
		require_once(PR_DIR.'inc/presets/losangeles.php');
		break;
		
		case 'manila':
		require_once(PR_DIR.'inc/presets/manila.php');
		break;
		
		case 'stockholm':
		require_once(PR_DIR.'inc/presets/stockholm.php');
		break;
		
		case 'capetown':
		require_once(PR_DIR.'inc/presets/capetown.php');
		break;
		
		case 'custom':
		
		$preset_opts = array (
			
			// FONT
			'pr_primary_font' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_primary_font', '', $layout),
			'pr_secondary_font' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_secondary_font', '', $layout),
			
			// THUMBS
			'pr_thumb_cols' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_thumb_cols', '', $layout),
			'pr_thumb_shape' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_thumb_shape', '', $layout),
			'pr_thumb_hover' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_thumb_hover', '', $layout),
			
			// CAPTION
			
			// Shape
			'pr_caption_shape' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_shape_group.0.pr_shape', '', $layout),
			'pr_caption_shape_animation' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_shape_group.0.pr_shape_animation', '', $layout),
			'pr_caption_shape_amination_speed' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_shape_group.0.pr_shape_amination_speed', '', $layout),
			'pr_caption_shape_bgcolor' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_shape_group.0.pr_shape_bgcolor', '', $layout),
			'pr_caption_permalink_icon' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_shape_group.0.pr_permalink_icon', '', $layout),
			
			// Title
			'pr_caption_title_color' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_title_group.0.pr_title_color', '', $layout),
			'pr_caption_title_size' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_title_group.0.pr_title_size', '', $layout),
			'pr_caption_title_weight' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_title_group.0.pr_title_weight', '', $layout),
			'pr_caption_title_style' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_title_group.0.pr_title_style', '', $layout),
			
			// Subtitle
			'pr_caption_subtitle_source' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_subtitle_group.0.pr_subtitle_source', '', $layout),
			'pr_caption_subtitle_bgcolor' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_subtitle_group.0.pr_subtitle_bgcolor', '', $layout),
			'pr_caption_subtitle_color' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_subtitle_group.0.pr_subtitle_color', '', $layout),
			'pr_caption_subtitle_size' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_subtitle_group.0.pr_subtitle_size', '', $layout),
			'pr_caption_subtitle_weight' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_subtitle_group.0.pr_subtitle_weight', '', $layout),
			'pr_caption_subtitle_style' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_subtitle_group.0.pr_subtitle_style', '', $layout),
			
			// Metas
			'pr_caption_metas' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_metas_group.0.pr_metas', '', $layout),
			'pr_caption_metas_color' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_metas_group.0.pr_metas_color', '', $layout),
			'pr_caption_metas_size' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_metas_group.0.pr_metas_size', '', $layout),
			'pr_caption_metas_weight' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_metas_group.0.pr_metas_weight', '', $layout),
			'pr_caption_metas_style' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_caption_metas_group.0.pr_metas_style', '', $layout),
			
			// EXCERPT
			
			'pr_excerpt_style' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_style', '', $layout),
			'pr_excerpt_bg' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_bg', '', $layout),  
			
			// Header
			'pr_excerpt_header_color' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_header_group.0.pr_header_color', '', $layout),
			'pr_excerpt_header_over_color' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_header_group.0.pr_header_over_color', '', $layout),
			'pr_excerpt_header_size' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_header_group.0.pr_header_size', '', $layout),
			'pr_excerpt_header_weight' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_header_group.0.pr_header_weight', '', $layout),
			'pr_excerpt_header_style' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_header_group.0.pr_header_style', '', $layout),
			
			// Content 
			'pr_excerpt_content_color' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_content_group.0.pr_content_color', '', $layout),
			'pr_excerpt_content_size' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_content_group.0.pr_content_size', '', $layout),
			'pr_excerpt_content_weight' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_content_group.0.pr_content_weight', '', $layout),
			'pr_excerpt_content_style' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_content_group.0.pr_content_style', '', $layout),
			
			// Read More Button 
			'pr_excerpt_button_text' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_button_group.0.pr_button_text', '', $layout),
			'pr_excerpt_button_color' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_button_group.0.pr_button_color', '', $layout),
			'pr_excerpt_button_size' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_button_group.0.pr_button_size', '', $layout),
			'pr_excerpt_button_weight' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_button_group.0.pr_button_weight', '', $layout),
			'pr_excerpt_button_style' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_excerpt_button_group.0.pr_button_style', '', $layout),
			
			// PREVIEW
			
			'pr_preview_enable' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_enable', '', $layout),
			'pr_preview_style' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_style', '', $layout),
			'pr_preview_animation' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_animation', '', $layout),
			'pr_preview_speed' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_speed', '', $layout),
			'pr_preview_drag' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_drag', '', $layout),
			
			// Title
			'pr_preview_title_color' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_title_group.0.pr_title_color', '', $layout),
			'pr_preview_title_size' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_title_group.0.pr_title_size', '', $layout),
			'pr_preview_title_weight' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_title_group.0.pr_title_weight', '', $layout),
			'pr_preview_title_style' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_title_group.0.pr_title_style', '', $layout), 
			
			// Subtitle
			'pr_preview_subtitle_bgcolor' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_subtitle_group.0.pr_subtitle_bgcolor', '', $layout),
			'pr_preview_subtitle_color' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_subtitle_group.0.pr_subtitle_color', '', $layout),
			'pr_preview_subtitle_size' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_subtitle_group.0.pr_subtitle_size', '', $layout),
			'pr_preview_subtitle_weight' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_subtitle_group.0.pr_subtitle_weight', '', $layout),
			'pr_preview_subtitle_style' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_subtitle_group.0.pr_subtitle_style', '', $layout),
			
			// Content 
			'pr_preview_content_color' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_content_group.0.pr_content_color', '', $layout),
			'pr_preview_content_size' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_content_group.0.pr_content_size', '', $layout),
			'pr_preview_content_weight' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_content_group.0.pr_content_weight', '', $layout),
			'pr_preview_content_style' => vp_metabox('pr_layouts_meta.pr_custom_preset.0.pr_preview_content_group.0.pr_content_style', '', $layout),			
			
		);
		break;
		
	}
		
	if (count($preset_opts) == 0){ require_once(PR_DIR.'inc/presets/amsterdam.php'); }
	
	// START HTML //	
	
	// Loop Query
	$loop_args = array ();
	
	if($source == 'post'){
		$loop_args = array ( 
			'post_status' => 'publish',
			'pagination' => false, 
			'posts_per_page' => $posts_limit,
			'cat' => $category_filter,
			'order' => 'DESC', 
			'orderby' => 'date' 
		);
	}

	if($source == 'product' && $category_filter != '-1'){
		$loop_args = array ( 
			'post_status' => 'publish',
			'post_type' => 'product',
			'pagination' => false, 
			'posts_per_page' => $posts_limit,
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'id',
					'terms' => $category_woo_filter,
				),
			),
			'order' => 'DESC', 
			'orderby' => 'date' 
		);
	}
	
	if($source == 'product' && $category_filter == '-1'){
		$loop_args = array ( 
			'post_status' => 'publish',
			'post_type' => 'product',
			'pagination' => false, 
			'posts_per_page' => $posts_limit,
			'order' => 'DESC', 
			'orderby' => 'date' 
		);
	}
	
	
	$loop_posts = new WP_Query( $loop_args );

	// IF Query Not Empty
	if( $loop_posts->have_posts() || ($source == 'prgalleries' && count($gallery_array) > 0) ){ 
		
		// <STYLE>
		$html = '<style>';
		
		// FONTS
		if ($preset_opts['pr_primary_font'] || $preset_opts['pr_secondary_font']) {
			
			$primary_font = str_replace(' ', '+', $preset_opts['pr_primary_font']);
			$secondary_font = str_replace(' ', '+', $preset_opts['pr_secondary_font']);
			
			
			$html .= '
			/* FONTS */
			
			@import url(http://fonts.googleapis.com/css?family='.$primary_font.':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic);
			@import url(http://fonts.googleapis.com/css?family='.$secondary_font.':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic);
			
			
			#grid .caption-title, #grid .excerpt-title, #grid .read-more, #grid .excerpt-sub-title, .preview-title, .preview-sub-title {
				font-family:"'.$preset_opts['pr_primary_font'].'", sans-serif;
			}
			
			#grid .caption-subtitle, #grid .meta-caption, #grid .icons-excerpt, #grid .excerpt-content, .preview-content {
				font-family:"'.$preset_opts['pr_secondary_font'].'", sans-serif;
			}';
		
		}
	
		$html .='
		/* CAPTION BG */
		
		#grid .caption-post {
			background:'.$preset_opts['pr_caption_shape_bgcolor'].';
		}
		
		/* CAPTION TITLE */
		
		#grid .caption-title {
			color:'.$preset_opts['pr_caption_title_color'].';
			font-size:'.$preset_opts['pr_caption_title_size'].'px;
			font-weight:'.$preset_opts['pr_caption_title_weight'].';
			font-style:'.$preset_opts['pr_caption_title_style'].';
		}
		
		/* CAPTION SUBTITLE */
		
		#grid .caption-subtitle {
			background:'.$preset_opts['pr_caption_subtitle_bgcolor'].';
			color:'.$preset_opts['pr_caption_subtitle_color'].';
			font-size:'.$preset_opts['pr_caption_subtitle_size'].'px;
			font-weight:'.$preset_opts['pr_caption_subtitle_weight'].';
			font-style:'.$preset_opts['pr_caption_subtitle_style'].';
		}
		
		#grid .caption-subtitle a {
			color:'.$preset_opts['pr_caption_subtitle_color'].'; 
		}
		
		#grid .caption-subtitle a:hover {
			opacity: 0.3;
			color:'.$preset_opts['pr_caption_subtitle_color'].'; 
		}
		
		/* CAPTION BUTTONS */
		
		#grid .btn-caption span {
			color:'.$preset_opts['pr_caption_title_color'].';
		}
		
		#grid .btn-caption span:hover {
			background:'.$preset_opts['pr_caption_title_color'].';
			color:'.$preset_opts['pr_caption_shape_bgcolor'].'; 
		}
		
		/* CAPTION METAS */		
		
		#grid .meta-caption span {
			color:'.$preset_opts['pr_caption_metas_color'].';
			font-size:'.$preset_opts['pr_caption_metas_size'].'px;
			font-weight:'.$preset_opts['pr_caption_metas_weight'].';
			font-style:'.$preset_opts['pr_caption_metas_style'].';
		}
		
		#grid .meta-caption span:hover {
			border-bottom: 2px solid '.$preset_opts['pr_caption_metas_color'].';
		}
		
		#grid .meta-caption span a {
			color:'.$preset_opts['pr_caption_metas_color'].';
		}
		
		#grid .meta-caption span a:hover {
			color:'.$preset_opts['pr_caption_metas_color'].';
			opacity:0.7;
		}
		
		/* EXCERPT BG */
		
		.wrap-excerpt {
			background:'.$preset_opts['pr_excerpt_bg'].';
		}
		
		/* EXCERPT HEADER */
		
		#grid .meta-excerpt .excerpt-title, #grid .meta-excerpt span, #grid .meta-excerpt span a, #grid .meta-excerpt span a i {
			color:'.$preset_opts['pr_excerpt_header_color'].';
			font-size:'.$preset_opts['pr_excerpt_header_size'].'px;
			font-weight:'.$preset_opts['pr_excerpt_header_weight'].';
			font-style:'.$preset_opts['pr_excerpt_header_style'].';
		}
		
		#grid .meta-excerpt span:hover, #grid .meta-excerpt span:hover a, #grid .meta-excerpt span:hover a i {
			color:'.$preset_opts['pr_excerpt_header_over_color'].';
		}
		
		
		/* EXCERPT CONTENT */
		
		#grid .excerpt-content {
			color:'.$preset_opts['pr_excerpt_content_color'].';
			font-size:'.$preset_opts['pr_excerpt_content_size'].'px;
			font-weight:'.$preset_opts['pr_excerpt_content_weight'].';
			font-style:'.$preset_opts['pr_excerpt_content_style'].';
		}
		
		#grid .excerpt-sub-title {
			color:'.$preset_opts['pr_excerpt_content_color'].';
			font-weight:400;
		}
		
		/* EXCERPT BUTTON */
		
		#grid .read-more {
			color:'.$preset_opts['pr_excerpt_button_color'].';
			font-size:'.$preset_opts['pr_excerpt_button_size'].'px;
			font-weight:'.$preset_opts['pr_excerpt_button_weight'].';
			font-style:'.$preset_opts['pr_excerpt_button_style'].';
		}
		
		#grid .read-more:hover{
			border-top:2px solid '.$preset_opts['pr_excerpt_header_over_color'].';
		}
		
		/* PREVIEW TITLE */
		
		.preview-header .preview-title {
			color:'.$preset_opts['pr_preview_title_color'].';
			font-size:'.$preset_opts['pr_preview_title_size'].'px;
			font-weight:'.$preset_opts['pr_preview_title_weight'].';
			font-style:'.$preset_opts['pr_preview_title_style'].';
		}
		
		/* PREVIEW SUBTITLE */
		
		.preview-header .preview-sub-title {
			background:'.$preset_opts['pr_preview_subtitle_bgcolor'].';
			color:'.$preset_opts['pr_preview_subtitle_color'].';
			font-size:'.$preset_opts['pr_preview_subtitle_size'].'px;
			font-weight:'.$preset_opts['pr_preview_subtitle_weight'].';
			font-style:'.$preset_opts['pr_preview_subtitle_style'].';
		}
		
		/* PREVIEW CONTENT */
		
		.preview-content {
			color:'.$preset_opts['pr_preview_content_color'].';
			font-size:'.$preset_opts['pr_preview_content_size'].'px;
			font-weight:'.$preset_opts['pr_preview_content_weight'].';
			font-style:'.$preset_opts['pr_preview_content_style'].';
		}
		
		';
		
		$html .= '</style>';
		// </STYLE>
		
		//<PR WRAPPER>
		$html .= '<div id="wrap-pr">';
		
		// <LOADER>
		if($grid_loader != '0'){
			$html .= '
			<div id="mask">
				<div id="loader">
					<img src="'.$grid_loader.'">
				</div>
			</div>';
		}
		// </LOADER>
		
		// <FILTERS>
		$html .= pr_display_filters($layout, $category_filter, $category_woo_filter);
		// </FILTERS>
		
		// GRID
		$html .= '<ul class="grid '.$items_appearing.'" id="grid">'; 
		
		while ( $loop_posts->have_posts() ){ // Items loop
			
			$loop_posts->the_post();
			
			// Thumb
			$thumb_shape = $preset_opts['pr_thumb_shape'];
			
			if( empty($thumb_shape) || $thumb_shape == 'random' ) {
				
				$thumb_types = array('pr-thumb-land', 'pr-thumb-square', 'pr-thumb-port');
				$thumb_shape = $thumb_types[rand(0,2)];
				
			}
							
			$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $thumb_shape );
			$thumb_url = $thumb_url[0];
			if(empty($thumb_url)){ $thumb_url = PR_URL.'assets/img/default.png'; }
			
			// Title
			$title = get_the_title();			
			if ( strlen($title) > 40 ) { $title = substr($title, 0, 40).'...'; }
			
			// Subtitle
			switch($preset_opts['pr_caption_subtitle_source']) {
				
				case '0':
				$subtitle = 'disabled';
				break;
								
				case 'excerpt':
				$subtitle = pr_excerpt( get_the_ID(), 24);				
				break;
				
				case 'categories':
				if($source == 'post'){
					$subtitle = get_the_category_list( ' / ' );
				}else{
					$subtitle = '';
				}
				break;
				
				case 'tags':
				if($source == 'post'){
					$subtitle = get_the_tag_list( '', ' / ' );
				}else{
					$subtitle = '';
				}
				break;
				
				case 'price':
				if($source == 'product'){
					$product = new WC_Product( get_the_ID() );
					$price = $product->price;
					global  $woocommerce;
  					
					if(function_exists('get_woocommerce_currency_symbol') && $price) { 
						$currency = get_woocommerce_currency_symbol(); 
						$subtitle = $price.' '.$currency;
					}else{
						$subtitle = '';
					}
					
				}else{
					$subtitle = '';
				}
				break;
				
			}
			
			// Metas
			if($source == 'post'){
				$metas = $preset_opts['pr_caption_metas'];
				
				$author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
				$author_name = get_the_author_meta( 'display_name' );
				
				$post_categories = get_the_category();
				$main_category_id = $post_categories[0]->term_id;
				$main_category_name = $post_categories[0]->name;
			}else{
				$metas = '';
				
				$author_url = '';
				$author_name = '';
				
				$post_categories = '';
				$main_category_id = '';
				$main_category_name = '';
			}
			
			$content = pr_content( get_the_ID(), 100);
			
			$num_comments = get_comments_number();

			if ( $num_comments == 0 ) {
				$comments_label = '0 comments';
			} elseif ( $num_comments > 1 ) {
				$comments_label = $num_comments . __(' comments', 'pr');
			} else {
				$comments_label = __('1 comment', 'pr');
			}
			$comments = '<a href="' . get_comments_link() .'">'. $comments_label.'</a>';
			
		
			$date = '<a href="'.get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') ).'">'.get_the_date().'</a>';
			
			 
			// <ITEM>
			$html .= '<li class="wrap-post box-'.$preset_opts['pr_excerpt_style'].' '.$layouts_grid.' '.$preset_opts['pr_thumb_cols'].' '.$thumb_shape.' '.pr_get_post_categories(get_the_ID()).'">'; 
			
				// <WRAPIMAGE>
				$html .= '<div class="wrap-image">';
				
					// <WRAPCAPTION>
					$html .= '<div class="wrap-caption '.$preset_opts['pr_caption_shape'].'">';
					
						// <CAPTION>
						$html .= '<div class="caption-post '.$preset_opts['pr_caption_shape_animation'].' '.$preset_opts['pr_caption_shape_amination_speed'].'">';
							
							// <URL>
							if($preset_opts['pr_caption_permalink_icon'] != '1') {
								$html .= '<div class="caption-url" data-url="'.get_permalink().'"></div>';
							}
							
							// <BTN>
							$html .= '<div class="btn-caption">';
							
							if($preset_opts['pr_preview_enable'] == 1) {
								$html .= '<span class="btn-preview animated-1" data-preview="preview-'.get_the_ID().'"><i class="pricon-expand-3"></i></span>';
							}
							
							if($preset_opts['pr_caption_permalink_icon'] == 1) {
    							$html .= '<span class="btn-permalink animated-1" data-url="'.get_permalink().'"><i class="pricon-link"></i></span>';
							}
							
							$html .= '</div>';
							// </BTN>
							
							// <ELEMENTS>
							$html .= '<div class="caption-elements">';
							$html .= '<a class="caption-title" href="'.get_permalink().'">'.$title.'</a>';
							
								if ($subtitle != 'disabled' && !empty($subtitle)) {
									$sub = $subtitle;
									if(!empty($price)) { $price_class = 'pr-price'; }else{ $price_class = ''; }
									$html .= '<div class="caption-subtitle '.$price_class.'">';			
									$html .= $subtitle;
									$html .= '</div>';
								}
								
								// <METAS>
								if ( !empty($metas) && $source == 'post' ) {
									
									$html .= '<div class="meta-caption">';
									$html .= '<span>'.$date.'</span>';
									$html .= '<span>'.$comments.'</span>';
									$html .= '<span><a href="'.$author_url.'">'.$author_name.'</a></span>';
									$html .= '</div>';
								
								}
								// </METAS>
							
							$html .= '</div>';
							// </ELEMENTS>
						
							
						// </CAPTION>
						$html .= '</div>';
		
					$html .= '</div>';
					// </WRAPCAPTION>
					
					// <IMAGE>
					$html .= '<div class="wrap-post-image">';		
					$html .= '<div class="post-image '.$preset_opts['pr_thumb_hover'].'" style="background-image:url('.$thumb_url.');">';
					$html .= '</div>';
					$html .= '</div>';
					// </IMAGE>
						
				$html .= '</div>';	
				// </WRAPIMAGE>
			
				// <EXCERPT>
				switch( $preset_opts['pr_excerpt_style'] ) {
					
					case "excerpt-3":					
					$html .= '<div class="wrap-excerpt wrap-excerpt-3">
	
							    <div class="meta-excerpt">
								
									<div class="icons-excerpt">
								
										<a href="'.get_category_link($main_category_id).'" title="'.$main_category_name.'"><span><i class="pricon-folder" title="'.$main_category_name.'"></i> '.$main_category_name.'</span></a>
									
									</div>
									
								</div>
											
								<p class="excerpt-content">'.$content.'</p>
								
								<a href="'.get_the_permalink().'" title="'.__('Go to the Post', 'pr').'"><span class="read-more">'.$preset_opts['pr_excerpt_button_text'].'</span></a>
							
						      </div>';
					break;
					
					case "excerpt-4":		
					$html .= '<div class="wrap-excerpt wrap-excerpt-4">
    
								<div class="meta-excerpt">
								
									<div class="excerpt-title">'.$title.'</div>
									
								</div>
								
								<p class="excerpt-content">'.$content.'</p>
								
								<a href="'.get_the_permalink().'" title="'.__('Go to the Post', 'pr').'"><span class="read-more">'.$preset_opts['pr_excerpt_button_text'].'</span></a>
							
							</div>';
					break;
					
				}
				// </EXCERPT>
					
			$html .= '</li>'; 
			// </ITEM>
			
				
		} // End Items loop
		
		////////////////
		// PR GALLERY //
		////////////////
		
		if ($source == 'prgalleries'){
			
			foreach ($gallery_array as $img) {
				
				// Thumb
				$thumb_shape = $preset_opts['pr_thumb_shape'];
				
				if( empty($thumb_shape) || $thumb_shape == 'random' ) {
					
					$thumb_types = array('pr-thumb-land', 'pr-thumb-square', 'pr-thumb-port');
					$thumb_shape = $thumb_types[rand(0,2)];
					
				}
			
				// <ITEM>
				$html .= '<li class="wrap-post box-'.$preset_opts['pr_excerpt_style'].' '.$layouts_grid.' '.$preset_opts['pr_thumb_cols'].' '.$thumb_shape.'">'; 
				
					// <WRAPIMAGE>
					$html .= '<div class="wrap-image">';
					
						// <WRAPCAPTION>
						$html .= '<div class="wrap-caption '.$preset_opts['pr_caption_shape'].'">';
						
							// <CAPTION>
							$html .= '<div class="caption-post '.$preset_opts['pr_caption_shape_animation'].' '.$preset_opts['pr_caption_shape_amination_speed'].'">';
						
								// <BTN>
								$html .= '<div class="btn-caption">';
								
								$html .= '<a rel="prettyPhoto[pr_gal]" href="'.$img['pr_image_src'].'" title="'.$img['pr_image_title'].'"><span class="btn-lb animated-1"><i class="pricon-expand-3"></i></span></a>';
								
								$html .= '</div>';
								// </BTN>
								
								// <ELEMENTS>
								$html .= '<div class="caption-elements">';
								$html .= '<div class="caption-title">'.$img['pr_image_title'].'</div>';
								$html .= '</div>';
								// </ELEMENTS>
							
								
							// </CAPTION>
							$html .= '</div>';
			
						$html .= '</div>';
						// </WRAPCAPTION>
						
						// <IMAGE>	
						$html .= '<div class="wrap-post-image">';			
						$html .= '<div class="post-image '.$preset_opts['pr_thumb_hover'].'" style="background-image:url('.$img['pr_image_src'].');">';
						$html .= '</div>';
						$html .= '</div>';
						// </IMAGE>
							
					$html .= '</div>';	
					// </WRAPIMAGE>
				
				$html .= '</li>'; 
				// </ITEM>
				
			}

		}
		
		$html .= '</ul>';
		
		if($preset_opts['pr_preview_enable'] == 1 && $source != 'prgalleries') {
			
			if ($preset_opts['pr_preview_drag'] == 1 ) { $drag_class = 'pw-drag'; }else{ $drag_class = ''; }
		
			while ( $loop_posts->have_posts() ){ // Items loop
				
				$loop_posts->the_post();
				
				// <PREVIEW>
				$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'pr-preview' );
				$image_url = $image_url[0];
				
				if (!empty($image_url)) {
					if ($preset_opts['pr_preview_style'] == 'preview-overlay-1' || $preset_opts['pr_preview_style'] == 'preview-overlay-2' || $preset_opts['pr_preview_style'] == 'preview-overlay-3' ) {
						$image_out = '<div class="preview-image" style="background-image:url('.$image_url.');"></div>';
						$image_in = '';
					}else{
						$image_out = '';
						$image_in = '<div class="preview-image" style="background-image:url('.$image_url.');"></div>';
					}
				}else{
					$image_in = '';
					$image_out = '';
				}
				
				$html .='
				<div id="preview-'.get_the_ID().'" class="'.$preset_opts['pr_preview_style'].' '.$preset_opts['pr_preview_speed'].' '.$preset_opts['pr_preview_animation'].' '.$drag_class.'">
		
					<div class="preview-wrap-content" data-drag="'.$preset_opts['pr_preview_drag'].'">
						
						'.$image_out.'
					
						<div class="preview-centre">
	
							'.$image_in.'
							
							<div class="preview-header">
						
								<div class="preview-title">'.get_the_title().'</div>
								<div class="preview-sub-title">'.pr_excerpt( get_the_ID(), 50).'</div>
						
							</div>
							
							<div class="preview-content">'.pr_strip_shorts( get_the_content() ).'</div>
						
						</div>
							
					</div>';
					
					if ($preset_opts['pr_preview_drag'] == 1) {
						$html .='<span class="btn-drag animated-1"><img src="'.PR_URL.'assets/img/drag.png"></span>';
					}
				
					$html .='<span class="btn-close"><i class="pricon-close"></i></span>
					
					<a href="'.get_the_permalink().'" class="btn-more"><i class="pricon-link"></i></a>
				
				</div>';
				// </PREVIEW>
				
			} // End LOOP Preview
			
		} // End IF Preview
		
		//</PR WRAPPER>
		$html .= '</div>';
	
	}else{
		
		// HTML
		$html = __('No items published found', 'pr');		
		
	} // End IF Query not empty
	
	// Reset Post Data
	wp_reset_postdata();
	
	/* ARRAY 
	foreach($preset_opts as $label=>$value) {
		echo "'".$label."' => '".$value."',<br>";
	}*/
	
	// Return HTML
    return $html;
	 
}

add_shortcode( 'postrevolution', 'pr_postrevolution_short' );
