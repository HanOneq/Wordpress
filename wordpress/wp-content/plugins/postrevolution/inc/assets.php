<?php
/*
File: inc/assets.php
Description: Assets inclusion
Plugin: Post Revolution
Author: unCommons
*/



//********************************************************************************//
// CSS
//********************************************************************************//


// Frontend
add_action( 'wp_enqueue_scripts', 'pr_frontend_styles' );

function pr_frontend_styles() {
	
	// Main
	wp_register_style( 'pr-main-style',  PR_URL . 'assets/css/main.css' );

	// Icons
	wp_register_style( 'pr-icons-style',  PR_URL . 'assets/css/icons.css' );
	
	// PrettyPhoto
	wp_register_style( 'pr-pretty-style',  PR_URL . 'assets/css/libs/prettyPhoto.css' );
	
	// Commons FIX
	wp_register_style( 'pr-common-style',  PR_URL . 'assets/css/libs/common.css' );
	wp_enqueue_style('pr-common-style');
	
}


// Backend
add_action( 'admin_enqueue_scripts', 'pr_backend_styles' );

function pr_backend_styles() {
	
	// Main
	wp_register_style( 'pr-backend-style',  PR_URL . 'assets/css/backend.css' );
	wp_enqueue_style('pr-backend-style');
}



//********************************************************************************//
// JS
//********************************************************************************//


// Frontend
add_action('wp_enqueue_scripts', 'pr_frontend_scripts');

function pr_frontend_scripts() {
	
	
	// Load Libs
	wp_register_script('pr-isotope-script', PR_URL . 'assets/js/libs/isotope.pkgd.min.js', array('jquery'), '', true);
	
	wp_register_script('pr-pep-script', PR_URL . 'assets/js/libs/jquery.pep.js', array('jquery'), '', true);

	wp_register_script('pr-pretty-script', PR_URL . 'assets/js/libs/jquery.prettyPhoto.js', array('jquery'), '', true);
	
	wp_register_script('pr-frontend-script', PR_URL . 'assets/js/frontend.js', array('jquery'), '', true);
	
}


// Backend
add_action('admin_enqueue_scripts', 'pr_backend_scripts');

function pr_backend_scripts($hook) {
	
	// Load WP jQuery if not included
	wp_enqueue_script('jquery');
	
	global $post_type;
	
    if( ($post_type == 'layouts' && $hook == 'post-new.php') || ( $post_type == 'layouts' && $hook == 'post.php' && isset($_GET['action']) && $_GET['action'] == 'edit' ) ) {
		
		// Load backend js script
		wp_register_script('pr-backend-script', PR_URL . 'assets/js/backend.js', array('jquery'), '', true);
		wp_enqueue_script('pr-backend-script');
	
	}
	
}