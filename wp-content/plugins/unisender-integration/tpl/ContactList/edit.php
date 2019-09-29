<form action="" method="post" name="unisender_list_edit" id="unisender_list_edit" class="validate">
	<h3><?php
		if (!empty($list['title'])) {
			echo __('Edit list', $this->textdomain) . ' "' . $list['title']. '"';
		} else {
				_e('New contact list', $this->textdomain);
		}?></h3>
	<input name="action" type="hidden" value="unisender_list_edit">
	<table class="form-table">
		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="title"><?php _e('Title', $this->textdomain); ?></label>
			</th>
			<td>
				<input name="title" type="text" id="title" value="<?php echo $list['title']; ?>" aria-required="true"
				       placeholder="<?php _e('Title', $this->textdomain); ?>" required>
			</td>
		</tr>
	</table>
	<p class="submit">
        <img src="<?php echo admin_url('images/spinner.gif'); ?>" style="display: none;">
		<input type="submit" name="unisender_register_action" id="unisender_register_action"
		       class="button button-primary" value="<?php _e('Save', $this->textdomain); ?>">
		<a class="button button-primary" href="<?php echo admin_url('tools.php?page=unisender'); ?>"><?php _e('Cancel', $this->textdomain); ?></a>
	</p>
</form>