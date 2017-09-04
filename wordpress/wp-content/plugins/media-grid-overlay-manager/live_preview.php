<?php
//////////////////////////////////////////////////////////////
// if not exist - load WP functions
if(!function_exists('get_option')) {
	
	if(!isset($_REQUEST['abspath'])) {
		$curr_path = dirname(__FILE__);
		$curr_path_arr = explode(DIRECTORY_SEPARATOR, $curr_path);
		
		$true_path_arr = array();
		foreach($curr_path_arr as $part) {
			if($part == 'wp-content') {break;}
			$true_path_arr[] = $part;
		}	
		$true_path = implode('/', $true_path_arr);
	}
	else {$true_path = urldecode($_REQUEST['abspath']);}

	// main functions
	if(!file_exists($true_path . '/wp-load.php')) {die('<p>wordpress - wp-load.php file not found</p>');}
	else {require_once($true_path . '/wp-load.php');}
}
if(!function_exists('get_filesystem_method')) {
	// wp-admin/includes/file.php - for wp_filesys
	if(!file_exists(ABSPATH . 'wp-admin/includes/file.php')) {die('<p>wordpress - file.php file not found</p>');}
	else {require_once(ABSPATH . 'wp-admin/includes/file.php');}	
}
/////////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////
// CREATE THE OVERLAY FOR THE PREVIEW /////
///////////////////////////////////////////

include_once(MG_DIR . '/functions.php');
include_once(MG_DIR . '/classes/overlay_manager.php');
include_once(MGOM_DIR . '/functions.php');


// check overlay ID
if(!isset($_GET['ol_id'])) {die('overlay ID missing');}
$ol_id = (int)$_GET['ol_id'];
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Media Grid Overlay Manager - live preview</title>

<style type="text/css">
/* CSS resetter */
html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{border:0;font-size:100%;font:inherit;vertical-align:baseline;margin:0;padding:0}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:none}table{border-collapse:collapse;border-spacing:0}

/* grid simulation */
@font-face {
	font-family: 'lcweb-media';
	src:url('<?php echo MG_URL ?>/css/lcweb-media/fonts/lcweb-media.eot');
	src:url('<?php echo MG_URL ?>/css/lcweb-media/fonts/lcweb-media.eot?#iefix') format('embedded-opentype'),
		url('<?php echo MG_URL ?>/css/lcweb-media/fonts/lcweb-media.ttf') format('truetype'),
		url('<?php echo MG_URL ?>/css/lcweb-media/fonts/lcweb-media.woff') format('woff'),
		url('<?php echo MG_URL ?>/css/lcweb-media/fonts/lcweb-media.svg#lcweb-media') format('svg');
}

.mg_grid_wrap { 
	min-width: 200px;  
	width: auto;
	margin: 18px auto;
}
.mg_grid_wrap, .mg_grid_wrap * {
	-moz-box-sizing: border-box;
	box-sizing: border-box;		
}
#mg_full_overlay, #mg_full_overlay * {
	-moz-box-sizing: content-box;
	box-sizing: content-box;	
}

.mg_grid_wrap .mg_container {
	margin: auto;  
	width: 100% !important;
	overflow: visible !important;
}

.mg_box {
  float: left;
  background: none !important;
}
.mg_shadow_div {
	width: 100%;
	height: 100%;	
	overflow: hidden;
}
.mg_box img {
  display: block;
  width: 100%;
  border: none;
  margin: 0px;
  padding: 0px;
}

.img_wrap,
.img_wrap > div {
	overflow: hidden;  
	width: 100%;
	height: 100%;
	max-height: 194px;
}
.img_wrap > div {
	position: relative;	
}
.mg_transitions {
	cursor: pointer;	
}
.mg_box img {
  display: block;
  border: none;
  padding: 0px;
}
.mg_box .thumb {
	margin: 0 !important;
	padding: 0 !important;
	border: none !important;
	position: absolute;
	
	max-width: none !important;
	max-height: none !important;
	min-width: 0 !important;
	min-height: 0 !important;
	
	top: 50%;
	left: 50%;
	
	-webkit-transform: 	translate(-50%, -50%); 
	-ms-transform: 		translate(-50%, -50%);
	transform: 			translate(-50%, -50%);
}
.mg_box.mg_landscape .thumb {
	width: 100% !important;
	height: auto !important;	
}
.mg_box.mg_portrait .thumb {
	width: auto !important;
	height: 100% !important;	
}
.img_wrap .overlays {
	position: absolute;
	height: 100%;
	width: 100%;
	overflow: hidden;
	top: 0 !important;	
	z-index: 20;
}

/******/

html {
    font-size: 100%;
	font-family: "Source Sans Pro",Helvetica,sans-serif;	
}
body {
    color: #141412;
}
.mgom_txt_wrap * {
	-webkit-hyphens: auto;
	-moz-hyphens: auto;
	hyphens: auto;
	
	font-family: "Source Sans Pro",Helvetica,sans-serif;
}
.mg_title_under {
	margin-top: 10px;
}

</style>

<?php 
// frontend css
if(!get_option('mg_inline_css')) {
	echo '<link rel="stylesheet" href="'.MGOM_URL.'/css/overlays.css?ar='.uniqid().'" type="text/css" />';	
} else {
	echo '<style type="text/css">';
	require_once(MGOM_DIR.'/frontend_css.php');
	echo '</style>';
}	

// image overlay code 
$ol_man = new mg_overlay_manager($ol_id, $_REQUEST['txt_under'], true);

if($_REQUEST['txt_under'] == 1) {
	$img_ol = '<div class="overlays">' . $ol_man->get_img_ol('fake_id') . '</div>';
	$txt_under = $ol_man->get_txt_under('fake_id');
} 
else {
	$img_ol = '<div class="overlays">' . $ol_man->get_img_ol('fake_id') . '</div>';
	$txt_under = '';
}

$elem_h = ($_REQUEST['txt_under']) ? 500 : 194;
?>

<style type="text/css">
.mg_box, .mg_box img {
	opacity: 1 !important;
	filter: alpha(opacity=100);	
}
</style>

<script type='text/javascript' src='<?php echo MGOM_URL ?>/js/jquery-1.10.2.min.js'></script>
</head>

<body>
	<div class="mg_grid_wrap mg_deeplink mgom_<?php echo $ol_id ?>" style="height: <?php echo $elem_h ?>px; margin: 0;">
		<div id="mg_grid_999" class="mg_container <?php echo $ol_man->txt_vis_class ?>" rel="auto" <?php echo $ol_man->img_fx_attr ?> style="height: <?php echo $elem_h ?>px;">
			
            <div  class="mg_box mg_video" style="position: absolute; top: 0; left: 0; width: 255px; height: <?php echo $elem_h ?>px;">				
				<div class="mg_shadow_div">
					<div class="img_wrap">
						<div>
                        	<div class="mg_img_wrap_inner">
                            	<img class="thumb" src="<?php echo MG_URL ?>/img/demo_picture.jpg">
                        	</div>
							<?php echo $img_ol; ?>
                    	</div>
					</div>
                    <?php echo $txt_under; ?>
				</div>	
			</div>
   
		</div>      
	</div>       

	<script type="text/javascript">
    jQuery(document).ready(function($) { 
        if( eval("typeof mgom_hub == 'function'") ) {
            mgom_hub(999);
        }
    });
	
	// simulate MG javascript
	mg_debouncer = function($,cf,of, interval){
		var debounce = function (func, threshold, execAsap) {
			var timeout;
			
			return function debounced () {
				var obj = this, args = arguments;
				function delayed () {
					if (!execAsap) {func.apply(obj, args);}
					timeout = null;
				}
			
				if (timeout) {clearTimeout(timeout);}
				else if (execAsap) {func.apply(obj, args);}
				
				timeout = setTimeout(delayed, threshold || interval);
			};
		};
		jQuery.fn[cf] = function(fn){ return fn ? this.bind(of, debounce(fn)) : this.trigger(cf); };
	};
	
	mg_debouncer(jQuery,'mg_smartresize', 'resize', 49);
	mg_mobile = 760; 
    </script>
	<script type='text/javascript' src='<?php echo MGOM_URL ?>/js/overlays.js'></script>
</body>
</html>