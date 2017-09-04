<?php
/*
File: inc/install.php
Description: Install functions
Plugin: Post Revolution
Author: unCommons
*/


//***************************************************************************
// Plugin INIT
//***************************************************************************


// LANGUAGE
add_action('init', 'pr_language');
 
function pr_language() {
	
	load_plugin_textdomain('pr', false, PR_DIR . '/languages/'); 
	
}

// IMAGE SIZES
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'pr-preview', 1920, 800, true );
	add_image_size( 'pr-thumb-land', 600, 400, true );
	add_image_size( 'pr-thumb-square', 600, 600, true );
	add_image_size( 'pr-thumb-port', 675, 900, true );
}

// ASSETS
require_once(PR_DIR.'inc/assets.php');

// POST TYPES
require_once(PR_DIR.'inc/posttypes/layouts.php');
require_once(PR_DIR.'inc/posttypes/galleries.php');

// META BOXES
require_once(PR_DIR.'inc/metaboxes.php');

// SHORTCODES
require_once(PR_DIR.'inc/shortcodes.php');

// PLUGIN FUNCTIONS
require_once(PR_DIR.'inc/functions.php'); 