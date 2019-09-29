<form action="" method="post" name="unisender_message_edit" id="unisender_message_edit" class="validate">
	<h3><?php _e('View E-mail', $this->textdomain); ?></h3>
	<input name="action" type="hidden" value="unisender_message_new">
	<table class="form-table">
		<tr class="form-field">
			<th scope="row">
				<label for="subject"><?php _e('Theme', $this->textdomain); ?></label>
			</th>
			<td>
				<span><?php echo $message['subject']; ?></span>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="sender_name"><?php _e('Sender', $this->textdomain); ?></label>
			</th>
			<td>
				<span><?php echo $message['sender_name']; ?></span>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="sender_email"><?php _e('Sender e-mail', $this->textdomain); ?></label>
			</th>
			<td>
				<span><?php echo $message['sender_email']; ?></span>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label><?php _e('Contact list', $this->textdomain); ?></label>
			</th>
			<td><span><?php echo $message['list']['title']; ?></span></td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="body"><?php _e('HTML-text of the letter', $this->textdomain); ?></label>
			</th>
			<td>
				<iframe src="<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php?action=unisenderGetLetterBody&messageId=<?php echo $message['id']; ?>" style="width: 100%; min-height: 500px; border: #DCDCDC solid 1px;"></iframe>
			</td>
		</tr>
	</table>
	<p class="submit">
		<img src="<?php echo admin_url('images/spinner.gif'); ?>" style="display: none;">
		<a href="<?php echo admin_url('tools.php?page=unisender&action=copy&messageId=' . $message['id']); ?>" name="unisender_register_action" id="unisender_register_action" class="button button-primary"><?php _e('Create copy', $this->textdomain)?></a>
		<a class="button button-primary" href="<?php echo admin_url('tools.php?page=unisender&section=message'); ?>"><?php _e('Cancel', $this->textdomain)?></a>
	</p>
</form>
