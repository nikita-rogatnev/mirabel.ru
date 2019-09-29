<table class="wp-list-table widecolumn fixed striped pages unisenderListTable">
	<thead>
	<tr>
		<th class="manage-column" style="width: 80px;"></th>
		<th class="manage-column" colspan="4" style="font-style: italic; min-width: 650px;"><form method="GET" action="<?php echo admin_url('tools.php'); ?>"><?php _e('Show letters, created from', $this->textdomain); ?>&nbsp;&nbsp;<input name="date_from" type="date" id="date_from" value="<? echo $dateFrom; ?>">&nbsp;&nbsp;<?php _e('till', $this->textdomain); ?>&nbsp;&nbsp;<input name="date_to" type="date" id="date_to" value="<? echo $dateTo; ?>"><input type="hidden" name="page" value="unisender"><input type="hidden" name="section" value="message"><input type="submit" value="<?php _e('Select', $this->textdomain); ?>"></form></th>
	</tr>
	<tr>
		<th class="manage-column" style="width: 80px;">Id</th>
		<th class="manage-column" style="min-width: 250px;"><strong><?php _e('Theme', $this->textdomain); ?></strong></th>
		<th class="manage-column" style="width: 80px;"><?php _e('Type', $this->textdomain); ?></th>
		<th class="manage-column" style="width: 150px;"><?php _e('Contact list', $this->textdomain); ?></th>
		<th class="manage-column" style="width: 380px;"><?php _e('Sender', $this->textdomain); ?><a href="<?php echo admin_url('tools.php?page=unisender&section=message&action=newSms'); ?>" class="add-new-h2" style="float: right;"><?php _e('New SMS', $this->textdomain); ?><a href="<?php echo admin_url('tools.php?page=unisender&section=message&action=new'); ?>" class="add-new-h2" style="float: right;"><?php _e('New E-mail', $this->textdomain); ?></a></th>
	</tr>
	</thead>

	<tbody id="the-list">
    <?php foreach ($messages as $mess) : ?>
		<tr>
			<th class="manage-column"><span><?php echo $mess['id']; ?></span></th>
			<td class="manage-column">
                <?php if ($mess['service_type'] === 'sms') {
                    $title = '<strong>' . __('From', $this->textdomain) . ' ' . $mess['sms_from']
                        . '</strong><span class="description">(' . mb_substr($mess['body'], 0, 64)
                        . (mb_strlen($mess['body']) > 61 ? '...' : '') . ')</span>';
                } else {
                    $title = '<strong>' . $mess['subject'] . '</strong>';
                } ?>
				<?php echo $title; ?>

				<div class="row-actions">
					<span><a href="<?php echo admin_url('tools.php?page=unisender&action=view&messageId=' . $mess['id']); ?>"><?php _e('View', $this->textdomain); ?></a> |</span>
					<span><a href="<?php echo admin_url('tools.php?page=unisender&action=copy&messageId=' . $mess['id']); ?>"><?php _e('Create copy', $this->textdomain); ?></a> |</span>
					<?php if (!empty($mess['list']['id']) && !empty($mess['body'])) { ?><span><a href="<?php echo admin_url('tools.php?page=unisender&action=campaign&messageId=' . $mess['id']); ?>"><?php _e('Send/schedule', $this->textdomain); ?></a> |</span> <?php } ?>
					<span class="trash"><a class="submitdelete" href="#" onClick="return actionDelete(<?php echo $mess['id']; ?>, '<?php echo admin_url('tools.php?page=unisender&action=delete&messageId=' . $mess['id']); ?>')"><?php _e('Delete', $this->textdomain); ?></a></span>
				</div>
			</td>
			<td class="manage-column"><span><?php echo $mess['service_type']; ?></span></td>
			<td class="manage-column"><span><?php echo $mess['list']['title']; ?></span></td>
			<td class="manage-column"><span><?php echo ($mess['service_type'] === 'email' ? ($mess['sender_name'].' (' . $mess['sender_email'] .')') : $mess['sms_from']);  ?></span></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
