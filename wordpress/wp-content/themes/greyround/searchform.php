<form class="searchform" action="<?php echo esc_url(home_url()) ?>/" method="get">
	<input type="text" name="s" class="searchfield" onblur="if (this.value == '') {this.value = '<?php esc_attr_e( __( 'Search...', 'greyround') ); ?>';}" onfocus="if (this.value == '<?php esc_attr_e( __( 'Search...', 'greyround') ); ?>') {this.value = '';}" value="<?php esc_attr_e( __( 'Search...', 'greyround') ); ?>" />
</form>