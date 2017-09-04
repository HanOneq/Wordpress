<?php 
	global $theme_option, $header_style;

	echo '<div class="gdlr-navigation-wrapper">';

	// navigation
	if( has_nav_menu('main_menu') ){
		if( class_exists('gdlr_menu_walker') ){
			echo '<nav class="gdlr-navigation" id="gdlr-main-navigation" >';
			wp_nav_menu( array(
				'theme_location'=>'main_menu', 
				'container'=> '', 
				'menu_class'=> 'sf-menu gdlr-main-menu',
				'walker'=> new gdlr_menu_walker() 
			) );
		}else{
			echo '<nav class="gdlr-navigation" role="navigation">';
			wp_nav_menu( array('theme_location'=>'main_menu') );
		}
		
		if( $header_style == 'solid' ){
			$icon_style = empty($theme_option['navigation-icon-type'])? 'dark': $theme_option['navigation-icon-type'];
		}else{
			$icon_style = empty($theme_option['transparent-navigation-icon-type'])? 'light': $theme_option['transparent-navigation-icon-type'];
		}
?>
<span class="gdlr-nav-separator" ></span>
<img id="gdlr-menu-search-button" src="<?php echo GDLR_PATH . '/images/magnifier-' . $icon_style . '.png'; ?>" alt="" width="58" height="59" />
<div class="gdlr-menu-search" id="gdlr-menu-search">
	<form method="get" id="searchform" action="<?php  echo home_url(); ?>/">
		<?php
			$search_val = get_search_query();
			if( empty($search_val) ){
				$search_val = __("Type Keywords" , "gdlr_translate");
			}
		?>
		<div class="search-text">
			<input type="text" value="<?php echo esc_attr($search_val); ?>" name="s" autocomplete="off" data-default="<?php echo esc_attr($search_val); ?>" />
		</div>
		<input type="submit" value="" />
		<div class="clear"></div>
	</form>	
</div>		
<?php		
		gdlr_get_woocommerce_nav($icon_style);
		echo '</nav>'; // gdlr-navigation
	}
	
	echo '<div class="gdlr-navigation-gimmick" id="gdlr-navigation-gimmick"></div>';
	echo '<div class="clear"></div>';
	echo '</div>'; // gdlr-navigation-wrapper
?>