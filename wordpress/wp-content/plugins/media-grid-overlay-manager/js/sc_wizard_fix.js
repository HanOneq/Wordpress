jQuery(document).ready(function($) {
	jQuery('body').delegate('#mg_editor_btn', 'click', function() {
		setTimeout(function() {
			jQuery('#TB_ajaxContent').css('overflow', 'visible');
		}, 100);
	});
});