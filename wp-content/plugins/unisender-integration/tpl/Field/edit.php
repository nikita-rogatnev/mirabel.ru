<form action="" method="post" name="unisender_field_edit" id="unisender_field_edit" class="validate">
	<h3><?php
		if (!empty($field['name'])) {
			echo __('Edit additional field', $this->textdomain) . ' "' . $field['name']. '"';
		} else {
			_e('New additional field', $this->textdomain);
		}?></h3>
	<input name="action" type="hidden" value="unisender_field_edit">
	<table class="form-table">
		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="public_name"><?php _e('Title', $this->textdomain); ?></label>
			</th>
			<td>
				<input name="public_name" type="text" id="public_name" value="<?php echo $field['public_name']; ?>" aria-required="true" placeholder="<?php _e('Title', $this->textdomain); ?>" required="required">
				<p class="description"><?php _e('Displayed in subscription form as label', $this->textdomain); ?></p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="name"><?php _e('Variable to substitute', $this->textdomain)?></label>
			</th>
			<td>
				<input name="name" type="text" id="name" value="<?php echo $field['name']; ?>" aria-required="true"
				       placeholder="<?php _e('Variable to substitute', $this->textdomain); ?>" required="required">
				<p class="description"><?php _e('Allowed characters: Latin letters, numbers, _ and -. First character must be always a letter', $this->textdomain); ?></p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="placeholder"><?php _e('Placeholder', $this->textdomain); ?></label>
			</th>
			<td>
				<input name="placeholder" type="text" id="placeholder" value="<?php echo $field['placeholder']; ?>" aria-required="true" placeholder="<?php _e('Placeholder', $this->textdomain)?>">
				<p class="description"><?php _e('Displayed in subscription form as placeholder', $this->textdomain); ?></p>
			</td>
		</tr>
		<?php if (empty($field['id'])):?>
		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="type"><?php _e('Type', $this->textdomain)?></label>
			</th>
			<td>
				<select name="type" id="type" required="required">
					<option value="" disabled<?php if (empty($field['type'])) echo ' selected'; ?>><?php _e('Field type', $this->textdomain); ?></option>
					<option value="string"<?php if (!empty($field['type']) && $field['type'] == 'string') echo ' selected'; ?>><?php _e('String', $this->textdomain); ?></option>
					<option value="number"<?php if (!empty($field['type']) && $field['type'] == 'number') echo ' selected'; ?>><?php _e('Numeric', $this->textdomain); ?></option>
					<option value="text"<?php if (!empty($field['type']) && $field['type'] == 'text') echo ' selected'; ?>><?php _e('Text', $this->textdomain); ?></option>
					<option value="bool"<?php if (!empty($field['type']) && $field['type'] == 'bool') echo ' selected'; ?>><?php _e('Yes/No', $this->textdomain); ?></option>
					<option value="date"<?php if (!empty($field['type']) && $field['type'] == 'date') echo ' selected'; ?>><?php _e('Date', $this->textdomain); ?></option>
				</select>
				<p class="description"><?php _e('Carefully check the correct field type. For example, when you try to import a string in the "Yes / No", the system will return an error', $this->textdomain); ?></p>
			</td>
		</tr>
		<?php endif;?>
		<tr class="form-field">
			<th scope="row">
				<label for="connect"><?php _e('Related WP field', $this->textdomain); ?></label>
			</th>
			<td>
				<input name="connect" type="text" id="connect" value="<?php echo $field['connect']; ?>"
				       placeholder="<?php _e('Related WP field', $this->textdomain); ?>">
				<p class="description"><?php _e('Related WP fields are user fields in WordPress, that you associate with fields UniSender. This link is included in the import/export. You can choose a field from the list below, or enter it manually', $this->textdomain); ?></p>
				<p class="unisender-standard-fields">
					<a>user_login</a>
					<a>user_nicename</a>
					<a>user_email</a>
					<a>user_registered</a>
					<a>display_name</a>
					<a>nickname</a>
					<a>first_name</a>
					<a>last_name</a>
				</p>
			</td>
		</tr>
        <tr>
            <th scope="row">
                <label for="is_enabled"><?php _e('Enabled', $this->textdomain); ?></label>
            </th>
            <td>
                <input name="is_enabled" type="checkbox" id="is_enabled"<?php echo $field['is_enabled'] ? ' checked' : ''?>>
                <p class="description"><?php _e('This setting affects the derivation of the field in the form, as well as import/export.', $this->textdomain); ?></p>
            </td>
        </tr>
        <tr>
			<th scope="row">
				<label for="is_enabled"><?php _e('Displays in form', $this->textdomain); ?></label>
                <p class="description"><?php _e('No affects on the import/export', $this->textdomain); ?></p>
			</th>
			<td>
				<input name="is_in_form" type="checkbox" id="is_in_form"<?php echo $field['is_in_form'] ? ' checked' : ''?>>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="is_form_required"><?php _e('Required in form', $this->textdomain)?></label>
			</th>
			<td>
				<input name="is_form_required" type="checkbox" id="is_form_required"<?php echo $field['is_form_required'] ? ' checked' : ''?>>
			</td>
		</tr>
	</table>
	<p class="submit">
        <img src="<?php echo admin_url('images/spinner.gif'); ?>" style="display: none;">
		<input type="submit" name="unisender_register_action" id="unisender_register_action"
		       class="button button-primary" value="<?php _e('Save', $this->textdomain)?>">
		<a class="button button-primary" href="<?php echo admin_url('tools.php?page=unisender&section=field'); ?>"><?php _e('Cancel', $this->textdomain)?></a>
	</p>
</form>
