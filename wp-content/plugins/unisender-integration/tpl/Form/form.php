<form action="" method="post" name="unisender_form_edit" id="unisender_form_edit" class="validate">
		<h3><?php _e('Edit subscription form', $this->textdomain); ?></h3>
		<input name="action" type="hidden" value="unisender_form_edit">
		<table class="form-table">
			<tr class="form-field">
				<th scope="row">
					<span class="description">*</span> <label for="list_id"><?php _e('Contact list', $this->textdomain); ?></label>
				</th>
				<td>
					<select name="list_id" id="list_id" required>
						<option value=""></option>
						<?php foreach ($lists as $list) : ?>
							<option value="<?php echo $list['id']; ?>"<?php echo ($list['id'] === $defaultListId ? ' selected' : ''); ?>><?php echo $list['title']; ?></option>
						<?php endforeach ?>
					</select>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<span class="description">*</span> <label for="unisender_form_title"><?php _e('Form header', $this->textdomain)?></label>
				</th>
				<td>
					<input name="unisender_form_title" type="text" id="unisender_form_title" value="<?php echo get_option('unisender_form_title'); ?>"
					       aria-required="true" placeholder="<?php _e('Form header', $this->textdomain)?>" required>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<span class="description">*</span> <label for="unisender_form_success"><?php _e('Message about the successful subscription', $this->textdomain)?></label>
				</th>
				<td>
					<input name="unisender_form_success" type="text" id="unisender_form_success" value="<?php echo get_option('unisender_form_success'); ?>" aria-required="true" placeholder="<?php _e('Message about the successful subscription', $this->textdomain)?>" required>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="unisender_is_create_user"><?php _e('Create a user with "Subscriber"', $this->textdomain)?></label>
				</th>
				<td>
					<input name="unisender_is_create_user" type="checkbox" id="unisender_is_create_user"<?php echo get_option('unisender_is_create_user') ? ' checked' : ''; ?>>
					<p class="description"><?php _e('Before turning on this option, read the <a href="https://codex.wordpress.org/Roles_and_Capabilities" target="_blank"> WordPress documentation on the rights and roles of users </a>', $this->textdomain); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row">
					<label for="fields"><?php _e('Fields', $this->textdomain)?></label>
				</th>
				<td>
					<div id="columns" class="unisenderFormFields">
						<?php foreach ($fields as $field) : ?>
							<div class="column" draggable="true" data-field-id="<?php echo $field['id']; ?>">
								<header><?php echo $field['public_name'].' ('.$field['name'].')'; ?></header>
								<div>
									<label for="is_in_form_<?php echo $field['id']; ?>"><?php _e('Visible', $this->textdomain); ?></label>
									<input type="checkbox" id="is_in_form_<?php echo $field['id']; ?>"
									       name="fields[<?php echo $field['id']; ?>][is_in_form]" <?php echo $field['is_in_form'] ? ' checked' : ''?><?php echo $field['name'] === 'email' ? ' disabled' : '' ?>>
									<br><br>
									<label for="is_form_required_<?php echo $field['id']; ?>"><?php _e('Required', $this->textdomain); ?></label>
									<input type="checkbox" id="is_form_required_<?php echo $field['id']; ?>"
										name="fields[<?php echo $field['id']; ?>][is_form_required]" <?php echo $field['is_form_required'] ? ' checked' : ''?><?php echo $field['name'] === 'email' ? ' disabled' : '' ?>>
									<br>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				</td>
			</tr>
		</table>
		<p class="submit">
            <img src="<?php echo admin_url('images/spinner.gif'); ?>" style="display: none;">
			<input type="submit" name="unisender_register_action" id="unisender_register_action"
			       class="button button-primary" value="<?php _e('Save', $this->textdomain)?>">
			<input type="reset" class="button" value="<?php _e('Cancel', $this->textdomain)?>">
		</p>
	</form>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).delegate('.column input', 'change', function () {
			if (getValueOrFalse($(this).attr('checked')) === false) {
				$(this).removeAttr('checked');
			} else {
				$(this).attr('checked', 'checked');
			}

			return false;
		});
	});
</script>