<form action="" method="post" name="unisender_message_edit" id="unisender_message_edit" class="validate">
	<h3><?php _e('New E-mail', $this->textdomain); ?></h3>
	<input name="action" type="hidden" value="unisender_message_new">
	<table class="form-table">
		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="subject"><?php _e('Theme', $this->textdomain); ?></label>
			</th>
			<td>
				<input name="subject" type="text" id="subject" value="<?php echo !empty($message['subject']) ? $message['subject'] : ''; ?>"
				       aria-required="true" placeholder="<?php _e('Theme', $this->textdomain); ?>" required>
				<p class="description"><?php _e('May include <a href="http://support.unisender.com/index.php?/Knowledgebase/Article/View/35/0/podstnovk-strok-v-pisme" target="_ blank"> placeholders</a>', $this->textdomain); ?></p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="sender_name"><?php _e('Sender', $this->textdomain);
?></label>
			</th>
			<td>
				<input name="sender_name" type="text" id="sender_name" value="<?php echo !empty($message['sender_name']) ? $message['sender_name'] : ''; ?>"
				       aria-required="true" placeholder="<?php _e('Sender', $this->textdomain); ?>" required>
				<p class="description"><?php _e('Sender\'s name. An arbitrary string that does not match the e-mail address', $this->textdomain); ?></p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="sender_email"><?php _e('Sender e-mail', $this->textdomain); ?></label>
			</th>
			<td>
				<input name="sender_email" type="text" id="sender_email" value="<?php echo !empty($message['sender_email']) ? $message['sender_email'] : ''; ?>" aria-required="true" placeholder="<?php _e('Sender e-mail', $this->textdomain); ?>" required>
				<p class="description"><?php _e('This e-mail must be checked (for this purpose it is necessary to manually create at least one letter with the return address of the web interface, then click "send confirmation" and follow the link from the letter)', $this->textdomain); ?></p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="list_id"><?php _e('Contact list', $this->textdomain); ?></label>
			</th>
			<td>
				<select name="list_id" id="list_id" required>
					<option value=""></option>
				<?php foreach ($lists as $list) : ?>
					<option value="<?php echo $list['id']; ?>"<?php echo ((!empty($message['list_id']) && $list['id'] == $message['list_id']) ? ' selected' : ''); ?>><?php echo $list['title']; ?></option>
				<?php endforeach ?>
				</select>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<span class="description">*</span> <label for="body"><?php _e('HTML-text of the letter', $this->textdomain); ?></label>
			</th>
			<td>
				<?php wp_editor(
                    (!empty($message['body']) ? $message['body'] : ''),
					'body',
					array(
						'textarea_name' => 'body',
						'required' => 'required'
					)
				); ?>
				<p class="description"><?php _e('It is assumed that the HTML-text contains only the contents of the tag body. If you pass the entire text of the HTML, then test your further such letters - headers is body can be subjected to modifications. In addition, to reduce the difference in the display of various e-mail programs, we automatically add extra markup to each letter (a table with invisible borders, which also sets the default font and text alignment along the left border). You can ask to disable it for your letters, contacting tech support', $this->textdomain); ?></p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label><?php _e('Serial message', $this->textdomain)?></label>
				<p class="description"><?php _e('For more information about serial letters you can read <a href="https://support.unisender.com/index.php?/Knowledgebase/Article/View/21/9/serii-pisem" target="_blank"> link </a>', $this->textdomain); ?></p>
			</th>
			<td>
				<p class="description"><?php _e('To enable a letter in a series of automatic dispatch, make the following entries', $this->textdomain); ?></p>
				<div style="max-width: 250px; float: left;">
					<label for="series_day"><?php _e('Start day', $this->textdomain); ?></label>
					<input name="series_day" type="number" id="series_day" value="<?php echo $message['series_day']; ?>">
				</div>
				<div style="max-width: 250px; float: left;">
					<label for="series_time"><?php _e('Start time', $this->textdomain); ?></label><br>
					<input name="series_time" id="series_time" value="<?php echo $message['series_time']; ?>" size="5">
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('#series_time').datetimepicker({
								datepicker: false,
								format: 'H:i'
							});
						});
					</script>
				</div>
			</td>
		</tr>
	</table>
	<p class="submit">
		<img src="<?php echo admin_url('images/spinner.gif'); ?>" style="display: none;">
		<input type="submit" name="unisender_new_message" id="unisender_new_message"
		       class="button button-primary" value="<?php _e('Save', $this->textdomain)?>">
		<a class="button button-primary" href="<?php echo admin_url('tools.php?page=unisender&section=message'); ?>"><?php _e('Cancel', $this->textdomain)?></a>
	</p>
</form>
