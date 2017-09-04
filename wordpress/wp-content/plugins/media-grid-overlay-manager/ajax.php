<?php
////////////////////////////////////////////////
////// ADD OVERLAY TERM ////////////////////////
////////////////////////////////////////////////

function mgom_add_ol_term() {
	if(!isset($_POST['lcwp_nonce']) || !wp_verify_nonce($_POST['lcwp_nonce'], 'lcwp_nonce')) {die('Cheating?');};
	if(!isset($_POST['ol_name'])) {die('data is missing');}
	$name = $_POST['ol_name'];
	
	$resp = wp_insert_term( $name, 'mgom_overlays', array( 'slug'=>sanitize_title($name)) );
	
	if(is_array($resp)) {die('success');}
	else {
		$err_mes = $resp->errors['term_exists'][0];
		die($err_mes);
	}
}
add_action('wp_ajax_mgom_add_ol_term', 'mgom_add_ol_term');



////////////////////////////////////////////////
////// LOAD OVERLAYS LIST //////////////////////
////////////////////////////////////////////////

function mgom_ol_list() {
	if(!isset($_POST['lcwp_nonce']) || !wp_verify_nonce($_POST['lcwp_nonce'], 'lcwp_nonce')) {die('Cheating?');};
	//if(!isset($_POST['ol_page']) || !filter_var($_POST['ol_page'], FILTER_VALIDATE_INT)) {$pag = 1;}
	
	$pag = 1;
	$per_page = 100;
	
	// search
	$search = (isset($_POST['grid_src'])) ? $_POST['grid_src']: '';
	if($search && !empty($search)) {
		$src_string = '&search='.$search;
	} else {
		$src_string = '';	
	}
	
	// get all terms 
	$grids = get_terms('mgom_overlays', 'hide_empty=0'.$src_string);
	$total = count($grids);
	
	$tot_pag = ceil( $total / $per_page );
	
	
	if($pag > $tot_pag) {$pag = $tot_pag;}
	$offset = ($pag - 1) * $per_page;
	
	// get page terms
	$args =  array(
		'number' => $per_page,
		'offset' => $offset,
		'hide_empty' => 0
	);
	if($src_string != '') {
		$args['search'] = $search;	
	}
	$items = get_terms('mgom_overlays', $args);

	// clean term array
	$clean_ols = array();
	
	foreach ( $items as $item ) {
		$clean_ols[] = array('id' => $item->term_id, 'name' => $item->name);
	}
	
	$to_return = array(
		'overlays' => $clean_ols,
		'pag' => $pag, 
		'tot_pag' => $tot_pag
	);
    
	echo json_encode($to_return);
	die();
}
add_action('wp_ajax_mgom_ol_list', 'mgom_ol_list');



////////////////////////////////////////////////
////// CLONE OVERLAY TERM //////////////////////
////////////////////////////////////////////////

function mgom_clone_ol() {
	if(!isset($_POST['ol_id']) || !isset($_POST['new_name']) || empty($_POST['new_name'])) {die('data is missing');}
	
	$ol_id = (int)$_POST['ol_id'];
	$name = $_POST['new_name'];
	
	$to_clone = get_term($ol_id, 'mgom_overlays');
	if(empty($to_clone) || is_wp_error($to_clone)) {
		die( __('Source overlay not found', 'mgom_ml') );	
	}
	
	
	$resp = wp_insert_term($name, 'mgom_overlays', array(
		'slug' 			=> sanitize_title($name),
		'description' 	=> $to_clone->description
	));
	
	if(is_wp_error($resp)) {
		echo $resp->get_error_message();
		die();
	} else {
		die('success');
	}
}
add_action('wp_ajax_mgom_clone_ol', 'mgom_clone_ol');



////////////////////////////////////////////////
////// DELETE OVERLAY TERM /////////////////////
////////////////////////////////////////////////

function mgom_del_ol_term() {
	if(!isset($_POST['ol_id'])) {die('data is missing');}
	$id = addslashes($_POST['ol_id']);
	
	$resp = wp_delete_term( $id, 'mgom_overlays');

	if($resp == '1') {die('success');}
	else {die('error during the overlay deletion');}
}
add_action('wp_ajax_mgom_del_ol_term', 'mgom_del_ol_term');



////////////////////////////////////////////////
////// DISPLAY OVERLAY BUILDER /////////////////
////////////////////////////////////////////////

function mgom_ol_builder() {
	require_once(MGOM_DIR . '/functions.php');
	
	if(!isset($_POST['ol_id'])) {die('data is missing');}
	$ol_id = addslashes($_POST['ol_id']);

	// get term and unserialize contents
	$ol = get_term($ol_id, 'mgom_overlays');
	$data = (empty($ol->description)) ? '' : unserialize(mgom_fix_serialization($ol->description));
	
	// graphic and textual arrays
	$graphic = (empty($data)) ? array() : $data['graphic'];
	$txt = (empty($data)) ? array() : $data['txt'];
	
	echo '<h2 id="mgom_builder_ol_tit"></h2>';
	
	////////////////////////////////
	// graphical elements //////////
	?>
    <form class="form-wrap" id="mgom_graphic_layers">  
        <div class="postbox">
          <h3 class="hndle"><?php _e('Graphical elements', 'mgom_ml') ?></h3>
          <div class="inside">
        
            <div class="lcwp_mainbox_meta">
              	<div class="mgom_add_layer">
                	<?php _e('Add new layer', 'mgom_ml') ?> 
                    <select class="lcweb-chosen" data-placeholder="Select a layer" tabindex="2">
                    	<?php 
						foreach(mgom_graphic_types() as $k => $v) {
							echo '<option value="'.$k.'">'.$v.'</option>';	
						}
						?>
                    </select>
                    <input type="button" class="button-secondary" value="<?php _e('Add', 'mgom_ml') ?>" /><span></span>
                </div>
                <div class="mgom_elements">
                	<?php echo mgom_saved_to_blocks($graphic); ?>
                </div>
            </div> 
             
          </div>
        </div>
    </form>
    <?php
    
    ////////////////////////////////
	// textual elements ////////////
	?>
    <form class="form-wrap" id="mgom_txt_layers">  
        <div class="postbox">
          <h3 class="hndle"><?php _e('Textual elements', 'mgom_ml') ?></h3>
          <div class="inside">
        
            <div class="lcwp_mainbox_meta">
				<div class="mgom_add_layer">
                	<?php _e('Add new element', 'mgom_ml') ?> 
                    <select class="lcweb-chosen" data-placeholder="Select a layer" autocomplete="off">
                    	<?php 
						$txt_types = mgom_txt_types();
						unset( $txt_types['txt_block'] );
						
						foreach($txt_types as $k => $v) {
							echo '<option value="'.$k.'">'.$v.'</option>';	
						}
						?>
                    </select>
                    <input type="button" class="button-secondary" value="<?php _e('Add', 'mgom_ml') ?>" /><span></span>
                </div>
                <div class="mgom_elements">
                	<?php 
					echo mgom_saved_to_blocks($txt);
					
					// text block - mandatory
					$values = (isset($txt['txt_block'])) ? $txt['txt_block'] : array();             
					echo mgom_type_block('txt_block', $values); 
					?>
                </div>
            <div>  
          </div>
        </div>
    </form>
    
	<?php
	die();
}
add_action('wp_ajax_mgom_ol_builder', 'mgom_ol_builder');



////////////////////////////////////////////////
////// ADD LAYER TO OVERLAY ////////////////////
////////////////////////////////////////////////

function mgom_add_layer() {
	require_once(MGOM_DIR . '/functions.php');
	
	if(!isset($_POST['mgom_type'])) {die('data is missing');}
	$type = addslashes($_POST['mgom_type']);
	
	die( mgom_type_block($type, array()) );
}
add_action('wp_ajax_mgom_add_layer', 'mgom_add_layer');



////////////////////////////////////////////////
////// SAVE OVERLAY ////////////////////////////
////////////////////////////////////////////////

function mgom_save_ol() {
	require_once(MGOM_DIR . '/functions.php');

	if(!isset($_POST['ol_id']) || !isset($_POST['ol_data'])) {die('data is missing');}
	$ol_id = $_POST['ol_id'];
	$ol_data = json_decode(rawurldecode(stripslashes($_POST['ol_data'])));

	// JS objects to array
	$true_data = mgom_js_ajax_sanitize($ol_data);	
	
	// save
	$result = wp_update_term($ol_id, 'mgom_overlays', array(
	  'description' => serialize($true_data)
	));
	
	if ( is_wp_error($result) ) {
  		echo $result->get_error_message();
	}
	else {

		// create dynamic CSS file for the overlay
		if(!get_option('mg_inline_css')) {
			if(!mgom_create_ol_css()) {
				if(!get_option('mg_inline_css')) { add_option('mg_inline_css', '255', '', 'yes'); }
				update_option('mg_inline_css', 1);	
			}
			else {delete_option('mg_inline_css');}
		}
		
		
		//echo serialize($true_data); // get data for preset styles
		echo 'success';	
	}
	
	die();
}
add_action('wp_ajax_mgom_save_ol', 'mgom_save_ol');



////////////////////////////////////////////////
////// PREVIEW OVERLAY /////////////////////////
////////////////////////////////////////////////

function mgom_live_preview() {
	if(!isset($_POST['ol_id'])) {die('data is missing');}
	$id = addslashes($_POST['ol_id']);
	
	$txt_under = (isset($_POST['txt_under']) && $_POST['txt_under']) ? 1 : 0;
	$iframe_h = ($txt_under) ? 500 : 194;

	echo '<iframe src="'.MGOM_URL.'/live_preview.php?ol_id='.$id.'&txt_under='.$txt_under.'&abspath='.urlencode(ABSPATH).'" width="255" height="'.$iframe_h.'" frameborder="0" style="overflow: hidden;"></iframe>';
	die();
}
add_action('wp_ajax_mgom_live_preview', 'mgom_live_preview');

