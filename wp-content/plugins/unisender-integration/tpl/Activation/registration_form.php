<form action="" method="post" name="unisender_registration" id="unisender_registration" class="validate">
	<h3><?php _e('Unisender registration', $this->textdomain); ?></h3>
	<input name="action" type="hidden" value="unisender_registration">
	<table class="form-table">

		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="login"><?php _e('Login', $this->textdomain); ?></label>
			</th>
			<td>
				<input name="login" type="text" id="login" value="" aria-required="true"
				       placeholder="<?php _e('Login', $this->textdomain); ?>" required>
			</td>
		</tr>

		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="email"><?php _e('E-mail', $this->textdomain); ?></label>
			</th>
			<td>
				<input name="email" type="email" id="email" value="" aria-required="true"
				       placeholder="<?php _e('E-mail', $this->textdomain); ?>" required>
			</td>
		</tr>

		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="firstName"><?php _e('First name', $this->textdomain)?></label>
			</th>
			<td>
				<input name="firstName" type="text" id="firstName" value="" aria-required="true"
				       placeholder="<?php _e('First name', $this->textdomain); ?>" required>
			</td>
		</tr>

		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="password"><?php _e('Password', $this->textdomain)?></label>
			</th>
			<td>
				<input name="password" type="password" id="password" value="" aria-required="true"
				       placeholder="<?php _e('Password', $this->textdomain)?>" style="width:47%;" required>
				<input name="passwordRepeat" type="password" id="passwordRepeat" value="" aria-required="true"
				       placeholder="<?php _e('Repeat password', $this->textdomain)?>" style="width:47%;" required>
			</td>
		</tr>
	</table>

	<p class="submit">
        <img src="<?php echo admin_url('images/spinner.gif'); ?>" style="display: none;">
		<input type="submit" name="unisender_register_action" id="unisender_register_action"
		       class="button button-primary" value="<?php _e('Register', $this->textdomain)?>">
	</p>
</form>