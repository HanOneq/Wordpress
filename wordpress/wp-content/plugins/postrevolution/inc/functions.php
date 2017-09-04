<?php
/*
File: inc/functions.php
Description: Plugin functions
Plugin: Post Revolution
Author: unCommons
*/

function pr_strip_all($content) {
	
	// WP Strip Tags
	$content = wp_strip_all_tags($content, true);
	
	// WP Strip Shorts
	$content = strip_shortcodes($content);
	
	// PHP Strip Tags
	$content = strip_tags($content);
	
	// PHP Strip Shorts
	$content = preg_replace("/\[(.*?)\]/i", '', $content);
	
	return $content;
	
}

function pr_strip_shorts($content) {
	
	// WP Strip Shorts
	$content = strip_shortcodes($content);
	
	// PHP Strip Shorts
	$content = preg_replace("/\[(.*?)\]/i", '', $content);
	
	return $content;
	
}


function pr_excerpt ($post_id, $crop = 0) {
	
	$the_post = get_post($post_id);
	$excerpt = $the_post->post_excerpt;
	$content = $the_post->post_content;
	
	
	if( !empty($excerpt) ) {
		$result = $excerpt;
	}else{
		$result = $content;
	}
		
	// Cleaning the result
	$result = pr_strip_all( $result );
	
	// Crop if needed
	if( $crop > 0 && strlen($result) > $crop ) {
		
		$result = substr($result, 0, $crop).'...';
		
	}
	
	return $result;	
	
}


function pr_content ($post_id, $crop = 0) {
	
	$result = get_the_content($post_id);
		
	// Cleaning the result
	$result = pr_strip_all( $result );
	
	// Crop if needed
	if( $crop > 0 && strlen($result) > $crop ) {
		
		$result = substr($result, 0, $crop).'...';
		
	}
	
	return $result;	
	
}


function pr_get_post_categories($post) {
	
	$ptype = get_post_type($post);
	
	if($ptype == 'post'){
		
		$terms = wp_get_post_terms($post, 'category');
	
	}elseif($ptype == 'product'){
		
		$terms = wp_get_post_terms($post, 'product_cat');
		
	}else{
		
		return '';
		
	}
	
	$list = '';
	
	foreach($terms as $term) {
		$list .= $term->slug.' ';
	}
	
	return $list;
	
}

function pr_display_filters($layout, $category_filter, $category_woo_filter) {
	
	$html = '';
	
	$iso_filter = vp_metabox('pr_layouts_meta.pr_isotope_filter', '', $layout);
	$source = vp_metabox('pr_layouts_meta.pr_source', '', $layout);
	
	if($iso_filter == 1){
		
		$html .= '<div id="filters"><ul><li data-filter="*">all</li>';
		
		switch($source) {
			
			case 'post':
			if($category_filter != '-1'){
				$cat_array = explode(',', $category_filter);
			}else{
				$cat_array = $category_filter;
			}
			$taxonomy_ar = array('category');
			$taxonomy = 'category';
			break;
			
			case 'product':
			$cat_array = $category_woo_filter;
			$taxonomy_ar = array('product_cat');
			$taxonomy = 'product_cat';
			break;
	
		}
		
		if( $cat_array == '-1' ) {
			
			$args = array(
				'orderby'           => 'name', 
				'order'             => 'ASC',
				'hide_empty'        => true, 
				'hierarchical'      => true, 
				'child_of'          => 0, 
			); 
			
			$terms = get_terms($taxonomy_ar, $args);
			
					
			foreach($terms as $term){
				
				$html .= '<li data-filter=".'.$term->slug.'">'.$term->name.'</li>';
				
			}
			
		}else{
						
			foreach($cat_array as $term){
				
				$term = get_term( $term, $taxonomy );

				$html .= '<li data-filter=".'.$term->slug.'">'.$term->name.'</li>';
				
			}
			
		}	
		
		$html .= '</ul></div>';
		
	}
	
	return $html;
}