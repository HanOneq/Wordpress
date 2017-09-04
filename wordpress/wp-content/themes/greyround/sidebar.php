<div id="sidebar">
	<h2>
		<?php _e('What\'s happening', 'greyround'); ?>
	</h2>
	<?php add_filter('the_title', 'title_links', 10, 2); ?>
	<ul>
	<?php wp_get_archives( array(
		'type' => 'postbypost',
		'format' => 'html',
		'before' => '',
		'after' => '<br/><br/>',
		'limit' => '25' ) ); 
		?>
	</ul>
	<?php remove_filter('the_title', 'title_links', 10, 2); ?>
		<select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
			<option value=""><?php echo esc_attr( __( 'Ancient Archive', 'greyround') ); ?></option> 
			<?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'option', 'show_post_count' => 1 ) ); ?>
		</select>
</div>