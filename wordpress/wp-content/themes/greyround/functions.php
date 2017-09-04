<?php
function greyround_setup() {
	load_theme_textdomain( 'greyround', get_template_directory() . '/languages' );
	register_nav_menus( array(
		'main_menu' => __('Main Menu', 'greyround'),
	) );
	set_post_thumbnail_size( 150, 150); //0.0.4 addition for featured images
	add_theme_support( 'post-thumbnails' ); //0.0.4 addition for featured images
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'greyround_setup' );

function title_links($title, $id){
    if( $date = get_the_date('d, F (Y)', $id) ){
        $title = sprintf('%s - %s', $title, $date);
    }
    return $title;
}

if ( ! isset( $content_width ) ) {
	$content_width = 60;
}

function greyround_wp_title( $title, $sep ) {
	global $paged, $page;
		if ( is_feed() ) {
			return $title;
		} // end if
	// Add the site name.
	$title .= get_bloginfo( 'name' );
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
		} // end if
	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = sprintf( __( 'Page %s', 'greyround' ), max( $paged, $page ) ) . " $sep $title";
	} // end if
	return $title;
}
add_filter( 'wp_title', 'greyround_wp_title', 10, 2 ); 

function greyround_scripts() {
	wp_enqueue_style( 'greyround-style', get_stylesheet_uri(), array('dashicons') );
	wp_enqueue_style( 'open-sans');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'greyround_scripts' );
?>