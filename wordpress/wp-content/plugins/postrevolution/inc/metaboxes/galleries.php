<?php
/**
 * Metaboxes: Galleries Meta
 *
 * @package WordPress
 * @subpackage Post Revolution
 * 
 */


// META ARRAY

return array(
	'id'          => 'pr_galleries_meta',
	'types'       => array('prgalleries'),
	'title'       => __('Options', 'pr'),
	'priority'    => 'high',
	'template'    => array(

		// Custom Preset 
		
		array(
			'type' => 'group',
			'repeating' => true,
			'name' => 'pr_gallery',
			'title' => __('<i class="pricon-image-2"></i> Image', 'pr'),
			'fields' => array(
				
				// Title
				
				array(
					'type' => 'textbox',
					'name' => 'pr_image_title',
					'label' => __('Title', 'pr'),
				 ),
				 
				// Image
				
				array(
					'type' => 'upload',
					'name' => 'pr_image_src',
					'label' => __('Upload', 'pr'),
					'default' => PR_URL.'assets/img/default.png',
				),	
			),
    	),
	),
);