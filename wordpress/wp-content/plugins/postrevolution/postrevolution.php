<?php
/*
Plugin Name: Post Revolution
Plugin URI: http://www.uncommons.pro
Description: Amazing Grid Builder for WordPress
Author: unCommons
Version: 3.0
Author URI: http://www.uncommons.pro
Compatibility: WP 3.6.x - 3.7.x - 3.8.x - 3.9.x
*/

// Basic plugin definitions 
define ('PR_PLG_NAME', 'postrevolution');
define( 'PR_PLG_VERSION', '3.0' );
define( 'PR_URL', WP_PLUGIN_URL . '/' . str_replace( basename(__FILE__), '', plugin_basename(__FILE__) ));
define( 'PR_DIR', WP_PLUGIN_DIR . '/' . str_replace( basename(__FILE__), '', plugin_basename(__FILE__) ));


// Plugin INIT
require_once(PR_DIR.'inc/install.php'); 