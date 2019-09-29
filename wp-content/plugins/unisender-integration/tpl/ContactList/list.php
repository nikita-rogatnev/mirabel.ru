<table class="wp-list-table widecolumn fixed striped pages unisenderListTable">
	<colgroup>
		<col style="width: 80px;">
	</colgroup>
	<thead>
		<tr>
			<th class="manage-column column-title">Id</th>
			<th class="manage-column column-title">
				<?php _e('Title', $this->textdomain); ?>
			</th>
		</tr>
	</thead>

	<tbody id="the-list">
	<?php foreach ($lists as $l) : ?>
		<tr>
			<th class="manage-column" style="vertical-align: top;">
				<span><?php echo $l['id']; ?></span>
			</th>
			<td class="manage-column">
				<?php if ((bool)$l['is_default'] === true) : ?>
					<img src="<?php echo admin_url('images/yes.png'); ?>" style="margin-left: 10px;" title="<?php _e('Default list. All subscribers will be included to this list', $this->textdomain); ?>">
				<?php endif; ?>
				<strong><a class="row-title" href="<?php echo admin_url('tools.php?page=unisender&action=edit&field=' . $f['id']); ?>"><?php echo $l['title']; ?></a></strong>

				<div class="row-actions">
						<span><a href="<?php echo admin_url('tools.php?page=unisender&action=edit&list=' . $l['id']); ?>">
								<?php _e('Edit', $this->textdomain); ?></a> | </span>
						<span><a href="<?php echo admin_url('tools.php?page=unisender&action=import&list=' . $l['id']); ?>">
								<?php _e('Import', $this->textdomain); ?></a> | </span>
						<span><a href="<?php echo admin_url('tools.php?page=unisender&action=export&list=' . $l['id']); ?>">
								<?php _e('Export', $this->textdomain); ?></a> | </span>
					<?php if ((bool)$l['is_default'] === false) : ?>
						<span><a href="#" onClick="return actionDefault(<?php echo $l['id']; ?>, '<?php echo admin_url('tools.php?page=unisender&action=default&list=' . $l['id']); ?>')">
								<?php _e('Set as default', $this->textdomain); ?></a> | </span>
					<?php endif; ?>
					<span class="trash"><a class="submitdelete" title="<?php _e('Delete', $this->textdomain); ?>" href="#" onClick="return actionDelete(<?php echo $l['id']; ?>, '<?php echo admin_url('tools.php?page=unisender&action=delete&list=' . $l['id']); ?>')"><?php _e('Delete', $this->textdomain); ?></a></span>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
	<tr><td colspan="2">
		<a href="<?php echo admin_url('tools.php?page=unisender&action=edit&list=0'); ?>" class="add-new-h2" style="float: right;"><?php _e('New contact list', $this->textdomain); ?></a>
	</td></tr>
	</tbody>
</table>