jQuery(document).ready(function($) {
	$(document).delegate('#unisender_subscribe_form', 'submit', function() {
		var $form = $(this);
		$form.find('input[type=submit]').attr('disabled', 'disabled');
		$form.find('img').show();
		$.post(WPURLS.siteurl + '/wp-admin/admin-ajax.php', $(this).serialize(), function(response) {
			if (response.message != 'undefined') {
				alert(response.message);
			}
			if (response.status == 'success') {
				$form[0].reset();
			}
			$form.find('input[type=submit]').removeAttr('disabled');
			$form.find('img').hide();
			return false;
		}, 'json');

		return false;
	});
});