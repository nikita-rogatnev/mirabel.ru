<form action="" method="post" name="unisender_message_edit" id="unisender_message_edit" class="validate">
	<h3><?php _e('Schedule campaign', $this->textdomain); ?> - <?php echo ($message['service_type'] === 'email' ? (__('E-mail from:', $this->textdomain).' '.$message['subject']) : (__('SMS from:', $this->textdomain).' '.$message['sender'])); ?></h3>
	<input name="action" type="hidden" value="unisender_campaign_create">
	<table class="form-table">
		<tr class="form-field">
			<th scope="row">
				<label for="start_date"><?php _e('For list', $this->textdomain); ?></label>
			</th>
			<td>
				<span><?php echo $message['list']['title']; ?></span>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="start_date"><?php _e('Date and time of launch', $this->textdomain); ?></label>
			</th>
			<td>
				<input name="start_date" id="start_date" value="" size="15" readonly>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('#start_date').datetimepicker({
							minDate: '<? echo date('Y-m-d') ?>',
							format: 'Y-m-d H:i'
						});
					});
				</script>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row">
				<label for="start_now"><?php _e('Or send immediately', $this->textdomain); ?></label>
			</th>
			<td>
				<input name="start_now" id="start_now" type="checkbox">
			</td>
		</tr>
	</table>
	<p class="submit">
		<img src="<?php echo admin_url('images/spinner.gif'); ?>" style="display: none;">
	<?php
		if (
			($message['service_type'] === 'email' && !empty($message['list']['id']) && !empty($message['sender_email']))
			|| ($message['service_type'] === 'sms' && !empty($message['list']['id']))
		) { ?>
		<input type="submit" name="unisender_new_message" id="unisender_new_message"
		       class="button button-primary" value="<?php _e('Save', $this->textdomain)?>">
	<?php } else {
			echo '<p>'.__("You cannot schedule sending - some required  fields of letter are not filled", $this->textdomain).'</p>';
	} ?>
		<a class="button button-primary" href="<?php echo admin_url('tools.php?page=unisender&section=message'); ?>"><?php _e('Cancel', $this->textdomain)?></a>
	</p>
</form>
