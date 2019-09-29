<div class="wrap">
	<h2>UniSender Integration</h2>

	<h2 class="nav-tab-wrapper">
		<a href="<?php echo admin_url('tools.php?page=unisender'); ?>" class="nav-tab">
			<?php _e('Contact lists', $this->textdomain); ?></a>
		<a href="<?php echo admin_url('tools.php?page=unisender&section=field'); ?>" class="nav-tab">
			<?php _e('Additional fields', $this->textdomain); ?></a>
		<a href="<?php echo admin_url('tools.php?page=unisender&section=form'); ?>" class="nav-tab">
			<?php _e('Subscription form', $this->textdomain); ?></a>
		<a href="<?php echo admin_url('tools.php?page=unisender&section=message'); ?>" class="nav-tab">
			<?php _e('Campaigns', $this->textdomain); ?></a>
	</h2>

	<form action="" method="post" name="unisender_message_edit" id="unisender_message_edit" class="validate">
		<h3><?php _e('Error', $this->textdomain); ?></h3>
		<input name="action" type="hidden" value="unisender_message_new">
		<table class="form-table">
			<tr class="form-field">
				<th scope="row">
					<p><?php echo $error; ?></p>
				</th>
			</tr>
		</table>
	</form>

	<br class="clear">
</div>