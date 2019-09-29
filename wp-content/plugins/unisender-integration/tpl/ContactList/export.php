<form action="" method="post" name="unisender_list_export" id="unisender_list_export" class="validate">
	<h3><?php echo __('Exports from WP in UniSender', $this->textdomain) . ' "' . $list['title']. '"'; ?></h3>
	<input name="action" type="hidden" value="unisender_list_export">
	<table class="form-table">
		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="user_role"><?php _e('Users role', $this->textdomain); ?></label>
			</th>
			<td>
				<select name="user_role" id="user_role">
					<option value="all"><?php _e('All', $this->textdomain); ?></option>
					<?php wp_dropdown_roles('subscriber'); ?>
				</select>
				<p class="description"><?php _e('Select the role of users who want to transfer to the list', $this->textdomain); ?></p>
			</td>
		</tr>
	</table>
	<p class="submit">
        <img src="<?php echo admin_url('images/spinner.gif'); ?>" style="display: none;">
		<input type="submit" name="unisender_register_action" id="unisender_register_action"
		       class="button button-primary" value="<?php _e('Export', $this->textdomain)?>">
		<a class="button button-primary" href="<?php echo admin_url('tools.php?page=unisender'); ?>"><?php _e('Cancel', $this->textdomain)?></a>
	</p>
</form>