<?php
/*
File: inc/posttypes/galleries.php
Description: Register Galleries Post Type
Plugin: Post Revolution
Author: unCommons
*/


// Post Type Registration
add_action( 'init', 'pr_galleries_register_posttype' );

function pr_galleries_register_posttype() {

	$labels = array(
		'name'               => __('Galleries', 'pr'),
		'singular_name'      => __('Gallery', 'pr'),
		'add_new'            => __('Add New', 'pr'),
		'add_new_item'       => __('Add New Gallery', 'pr'),
		'edit_item'          => __('Edit Gallery', 'pr'),
		'new_item'           => __('New Gallery', 'pr'),
		'all_items'          => __('Galleries', 'pr'),
		'view_item'          => __('View Gallery', 'pr'),
		'search_items'       => __('Search Galleries', 'pr'),
		'not_found'          => __('No galleries found', 'pr'),
		'not_found_in_trash' => __('No galleries found in Trash', 'pr'),
		'parent_item_colon'  => '',
	  );
	
	  $args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => 'edit.php?post_type=layouts',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'prgallery' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'supports'           => array( 'title' )
	  );
	
	  register_post_type( 'prgalleries', $args );
	
}

// Post Type custom messages
add_filter( 'post_updated_messages', 'pr_galleries_custom_messages' );

function pr_galleries_custom_messages( $messages ) {
	
  global $post, $post_ID;

  $messages['prgalleries'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => __('Gallery updated.', 'pr'),
    2 => __('Custom field updated.', 'pr'),
    3 => __('Custom field deleted.', 'pr'),
    4 => __('Gallery updated.', 'pr'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Gallery restored to revision from %s', 'pr'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => __('Gallery published.', 'pr'),
    7 => __('Gallery saved.', 'pr'),
    8 => __('Gallery submitted.', 'pr'),
    9 => sprintf( __('Gallery scheduled for: <strong>%1$s</strong>.', 'pr'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i', 'pr' ), strtotime( $post->post_date ) ) ),
    10 => __('Gallery draft updated.', 'pr'),
  );

  return $messages;
  
}


