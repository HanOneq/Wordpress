<?php
/*
File: inc/posttypes/layouts.php
Description: Register Layouts Post Type
Plugin: Post Revolution
Author: unCommons
*/


// Post Type Registration
add_action( 'init', 'pr_layouts_register_posttype' );

function pr_layouts_register_posttype() {

	$labels = array(
		'name'               => __('Layouts', 'pr'),
		'singular_name'      => __('Layout', 'pr'),
		'add_new'            => __('Add New', 'pr'),
		'add_new_item'       => __('Add New Layout', 'pr'),
		'edit_item'          => __('Edit Layout', 'pr'),
		'new_item'           => __('New Layout', 'pr'),
		'all_items'          => __('Layouts', 'pr'),
		'view_item'          => __('View Layout', 'pr'),
		'search_items'       => __('Search Layouts', 'pr'),
		'not_found'          => __('No layouts found', 'pr'),
		'not_found_in_trash' => __('No layouts found in Trash', 'pr'),
		'parent_item_colon'  => '',
		'menu_name'          => __('Post Revolution', 'pr')
	  );
	
	  $args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'layout' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => PR_URL.'assets/img/main_icon.png', 
		'supports'           => array( 'title' )
	  );
	
	  register_post_type( 'layouts', $args );
	
}

// Post Type custom column -> [shortcode]
add_filter('manage_edit-layouts_columns', 'pr_add_new_layouts_columns');

function pr_add_new_layouts_columns( $columns ) {
	
	$columns['shortcode'] = __( 'Schortcode', 'pr' );
	return $columns;
	
}

add_action( 'manage_layouts_posts_custom_column', 'pr_shortcode_column_display', 10, 2 );

function pr_shortcode_column_display( $column_name, $post_id ) {
	
	if ( 'shortcode' != $column_name ) {
		return;
	}
		
 	echo '<input type="text" onclick="select()" readonly="readonly" value="[postrevolution layout='.$post_id.']" style="background:none; border:none; box-shadow:none; color:#0074A2; width:300px; font-size:16px; line-height:40px;">';
	
}


// Post Type custom messages
add_filter( 'post_updated_messages', 'pr_layouts_custom_messages' );

function pr_layouts_custom_messages( $messages ) {
	
  global $post, $post_ID;

  $messages['layouts'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => __('Layout updated.', 'pr'),
    2 => __('Custom field updated.', 'pr'),
    3 => __('Custom field deleted.', 'pr'),
    4 => __('Layout updated.', 'pr'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Layout restored to revision from %s', 'pr'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => __('Layout published.', 'pr'),
    7 => __('Layout saved.', 'pr'),
    8 => __('Layout submitted.', 'pr'),
    9 => sprintf( __('Layout scheduled for: <strong>%1$s</strong>.', 'pr'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i', 'pr' ), strtotime( $post->post_date ) ) ),
    10 => __('Layout draft updated.', 'pr'),
  );

  return $messages;
  
}

add_action('admin_menu', 'pr_hide_add_new_custom_type');

function pr_hide_add_new_custom_type() {
    global $submenu;
    // replace my_type with the name of your post type
    unset($submenu['edit.php?post_type=layouts'][10]);
}

