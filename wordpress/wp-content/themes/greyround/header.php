<!DOCTYPE html>
<html>
<head <?php language_attributes();?> >
 <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>">
 <meta charset="<?php bloginfo('charset'); ?>">
 <title><?php wp_title('::', true, 'right');?></title>
 <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
 <meta name="viewport" content="width=device-width; initial-scale=1.0" /> <!-- Responsive width for mobile devices etc. -->
 <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="wrapper">
 <div id="header">
  <div id="titlebox">
  <p class="blogtitle"><a href=" <?php echo get_home_url(); ?> "><?php echo get_bloginfo ( 'name' );  ?></a></p>
  <p class="tagline"><?php echo get_bloginfo ( 'description' );  ?></p>
  </div>
  <div id="searchbox"><?php get_search_form(); ?></div>
 </div>