<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package Lawyer_Landing_Page
 */

if ( ! function_exists( 'lawyer_landing_page_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function lawyer_landing_page_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Lawyer Landing Page, use a find and replace
	 * to change 'lawyer-landing-page' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'lawyer-landing-page', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'lawyer-landing-page' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'gallery',
		'caption',
	) );

    add_theme_support( 'post-formats', array( 'aside', 'status' ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'lawyer_landing_page_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Custom Image Size
    add_image_size( 'lawyer-landing-page-banner', 1914, 719, true );
    add_image_size( 'lawyer-landing-page-about', 456, 268, true );
    add_image_size( 'lawyer-landing-page-practice', 115, 115, true );
    add_image_size( 'lawyer-landing-page-service', 45, 45, true );
    add_image_size( 'lawyer-landing-page-testimonial', 103, 103, true );
    add_image_size( 'lawyer-landing-page-team', 261, 264, true );
    add_image_size( 'lawyer-landing-page-blog', 361, 250, true );
    add_image_size( 'lawyer-landing-page-with-sidebar', 830, 464, true );
    add_image_size( 'lawyer-landing-page-without-sidebar', 1170, 464, true );    
    add_image_size( 'lawyer-landing-page-featured', 185, 185, true );
    add_image_size( 'lawyer-landing-page-popular', 260, 145, true );
    add_image_size( 'lawyer-landing-page-recent', 78, 78, true );
    
    /** Custom Logo */
    add_theme_support( 'custom-logo', array(    	
    	'header-text' => array( 'site-title', 'site-description' ),
    ) );

}
endif;

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lawyer_landing_page_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'lawyer_landing_page_content_width', 830 );
}

/**
* Adjust content_width value according to template.
*
* @return void
*/
function lawyer_landing_page_template_redirect_content_width() {

	// Full Width in the absence of sidebar.
	if( is_page() ){
	   $sidebar_layout = lawyer_landing_page_sidebar_layout();
       if( ( $sidebar_layout == 'no-sidebar' ) || ! ( is_active_sidebar( 'right-sidebar' ) ) ) $GLOBALS['content_width'] = 1170;
        
	}elseif ( ! ( is_active_sidebar( 'right-sidebar' ) ) ) {
		$GLOBALS['content_width'] = 1170;
	}

}

/**
 * Enqueue scripts and styles.
 */
function lawyer_landing_page_scripts() {
		$args = array(
		  'family' => 'Raleway:400,400italic,600,700,500|Lato',
		);
	wp_enqueue_style( 'font-awesome', get_template_directory_uri(). '/css/font-awesome.css' );
	wp_enqueue_style( 'meanmenu', get_template_directory_uri(). '/css/meanmenu.css' );
	wp_enqueue_style( 'flexslider', get_template_directory_uri(). '/css/flexslider.css' );
    wp_enqueue_style( 'lawyer-landing-page-google-fonts', add_query_arg( $args, "//fonts.googleapis.com/css" ) );
	wp_enqueue_style( 'lawyer-landing-page-style', get_stylesheet_uri(), array(), LAWYER_LANDING_PAGE_THEME_VERSION );
    
    if( lawyer_landing_page_is_woocommerce_activated() )
    wp_enqueue_style( 'lawyer-landing-page-woocommerce-style', get_template_directory_uri(). '/css/woocommerce.css', array(), LAWYER_LANDING_PAGE_THEME_VERSION );
    
    if( is_page_template( 'template-home.php' ) )
    wp_enqueue_script( 'masonry' );
    
    wp_enqueue_script( 'jquery-flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array('jquery'), '2.6.0', true );
    wp_enqueue_script( 'jquery-meanmenu', get_template_directory_uri() . '/js/jquery.meanmenu.js', array('jquery'), '2.0.8', true );
    wp_enqueue_script( 'jquery-nicescroll', get_template_directory_uri() . '/js/jquery.nicescroll.js', array('jquery'), '1.6', true );
    wp_enqueue_script( 'lawyer-landing-page-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), LAWYER_LANDING_PAGE_THEME_VERSION, true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function lawyer_landing_page_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
    
    // Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
		$classes[] = 'custom-background-color';
	}
    
    if( !( is_active_sidebar( 'right-sidebar' ) ) ) {
        $classes[] = 'full-width'; 
    }
    
    if( lawyer_landing_page_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || 'product' === get_post_type() ) && ! is_active_sidebar( 'shop-sidebar' ) ){
        $classes[] = 'full-width';
    }
    
    if( is_page() ){
        $sidebar_layout = lawyer_landing_page_sidebar_layout();
        if( $sidebar_layout == 'no-sidebar' )
        $classes[] = 'full-width';
    }

    if( is_front_page() && is_page_template( 'template-home.php' ) ){
        $ed_banner = get_theme_mod( 'ed_banner_section' );
        $home_page = get_option( 'page_on_front' );
        if( $ed_banner && has_post_thumbnail( $home_page ) ){
            $classes[] = 'has-banner';    
        }else{
            $classes[] = 'no-banner';
        }
    }else{
        $classes[] = 'no-banner';
    }

	return $classes;
}

/**
 * Flush out the transients used in lawyer_landing_page_categorized_blog.
 */
function lawyer_landing_page_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'lawyer_landing_page_categories' );
}

/**
 * Hook to move comment text field to the bottom in WP 4.4
 * 
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-move-comment-text-field-to-bottom-in-wordpress-4-4/  
 */
function lawyer_landing_page_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}

if ( ! function_exists( 'lawyer_landing_page_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function lawyer_landing_page_excerpt_more() {
	return ' &hellip; ';
}

endif;

if ( ! function_exists( 'lawyer_landing_page_excerpt_length' ) && ! is_admin() ) :
/**
 * Changes the default 55 character in excerpt 
*/
function lawyer_landing_page_excerpt_length( $length ) {
	return is_admin() ? $length : 40;    
}
endif;


if( ! function_exists( 'lawyer_landing_page_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function lawyer_landing_page_change_comment_form_default_fields( $fields ){
    
    // get the current commenter if available
    $commenter = wp_get_current_commenter();
 
    // core functionality
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );    
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><input id="author" name="author" placeholder="' . esc_attr__( 'Name*', 'lawyer-landing-page' ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><input id="email" name="email" placeholder="' . esc_attr__( 'Email*', 'lawyer-landing-page' ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'lawyer-landing-page' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;
    
}
endif;

if( ! function_exists( 'lawyer_landing_page_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function lawyer_landing_page_change_comment_form_defaults( $defaults ){
    
    // Change the "cancel" to "I would rather not comment" and use a span instead
    $defaults['comment_field'] = '<p class="comment-form-comment"><label for="comment"></label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'lawyer-landing-page' ) . '" cols="45" rows="8" aria-required="true"></textarea></p>';
    
    return $defaults;
    
}
endif;

/**
 * Register the required plugins for this theme.
 */
function lawyer_landing_page_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => __( 'Contact Form 7', 'lawyer-landing-page' ),
            'slug'      => 'contact-form-7',
            'required'  => false,
        ),
   
    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id'           => 'lawyer-landing-page',    // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

    );

    tgmpa( $plugins, $config );
}