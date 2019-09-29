<table class="wp-list-table widecolumn fixed striped pages unisenderListTable">
	<colgroup>
		<col style="width: 80px;">
		<col style="">
		<col style="">
		<col style="text-align: center;">
		<col style="text-align: center;">
	</colgroup>
	<thead>
	<tr>
		<th class="manage-column column-title" style="width: 80px;">Id</th>
		<th class="manage-column column-title">
			<?php _e('Title', $this->textdomain) ?>
		</th>
		<th class="manage-column column-title">
			<?php _e('Related WP field', $this->textdomain) ?>

		</th>
        <th class="manage-column column-title">
            <?php _e('Enabled', $this->textdomain) ?>
        </th>
        <th class="manage-column column-title">
            <?php _e('Displays in form', $this->textdomain) ?>
        </th>
	</tr>
	</thead>

	<tbody id="the-list">
	<?php foreach ($fields as $f) : ?>
		<tr>
			<th class="manage-column" style="vertical-align: top;">
				<span><?php echo $f['id']; ?></span>
			</th>
			<td class="manage-column">
				<strong><a class="row-title" href="<?php echo admin_url('tools.php?page=unisender&action=edit&field=' . $f['id']); ?>"><?php echo $f['public_name']; ?> (<?php echo $f['name']; ?>)</a></strong>

				<div class="row-actions">
                <?php if ($f['name'] === 'email') { ?>
                    <span class="description"><?php _e('The field email is mandatory and can not be edited', $this->textdomain); ?></span>
                <?php } else { ?>
					<span><a href="<?php echo admin_url('tools.php?page=unisender&action=edit&field=' . $f['id']); ?>"><?php _e('Edit', $this->textdomain); ?></a> | </span>
					<span class="trash"><a class="submitdelete" href="#" onClick="return actionDelete(<?php echo $f['id']; ?>, '<?php echo admin_url('tools.php?page=unisender&action=delete&field=' . $f['id']); ?>')"><?php _e('Delete', $this->textdomain); ?></a></span>
                <?php } ?>
				</div>
			</td>
			<td class="manage-column" align="center">
				<span><?php echo $f['connect']; ?></span>
			</td>
            <td class="manage-column" align="center">
                <span><?php echo $f['is_enabled'] ? '<img src="'.admin_url('images/yes.png').'">' : ''; ?></span>
            </td>
            <td class="manage-column" align="center">
                <span><?php echo $f['is_in_form'] ? '<img src="'.admin_url('images/yes.png').'">': ''; ?></span>
            </td>
		</tr>
	<?php endforeach; ?>
		<tr><td colspan="5">
			<a href="<?php echo admin_url('tools.php?page=unisender&action=edit&field=0'); ?>" class="add-new-h2" style="float: right;"><?php _e('New additional field', $this->textdomain); ?></a>
		</td></tr>
	</tbody>
</table>
