<form action="" method="post" name="unisender_login" id="unisender_login" class="validate">
	<h3><?php _e('UniSender login', $this->textdomain); ?></h3>
	<input name="action" type="hidden" value="unisender_login">
	<table class="form-table">
		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="api_key"><?php _e('API Key', $this->textdomain); ?></label>
			</th>
			<td>
				<input name="api_key" type="text" id="api_key" value="" aria-required="true"
				       placeholder="<?php _e('API Key', $this->textdomain); ?>" required>
			</td>
		</tr>
	</table>
	<p class="submit">
        <img src="<?php echo admin_url('images/spinner.gif'); ?>" style="display: none;">
		<input type="submit" name="unisender_register_action" id="unisender_register_action"
		       class="button button-primary" value="<?php _e('Login', $this->textdomain); ?>">
	</p>
</form>
