<?php
/*
File: inc/metaboxes.php
Description: Plugin metaboxes
Plugin: Post Revolution
Author: unCommons
*/


add_action( 'after_setup_theme', 'pr_init_metaboxes' );
 
function pr_init_metaboxes() {

// Framework 
require_once(PR_DIR.'framework/bootstrap.php');

// Layouts
$tpl_layouts_path = PR_DIR.'/inc/metaboxes/layouts.php';
$tpl_layouts = new VP_Metabox($tpl_layouts_path);

// Galleries
$tpl_galleries_path = PR_DIR.'/inc/metaboxes/galleries.php';
$tpl_galleries = new VP_Metabox($tpl_galleries_path);

}


