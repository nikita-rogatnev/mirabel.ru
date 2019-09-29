<form action="" method="post" name="unisender_list_import" id="unisender_list_import" class="validate">
    <h3><?php echo __('Import users in WP from UniSender', $this->textdomain) . ' "' . $list['title']. '"'; ?></h3>
    <input name="action" type="hidden" value="unisender_list_import">
    <table class="form-table">
        <tr class="form-field">
            <th scope="row">
                <span class="description">*</span> <label for="user_role"><?php _e('Users role', $this->textdomain); ?></label>
            </th>
            <td>
                <select name="user_role" id="user_role">
                    <?php wp_dropdown_roles('subscriber'); ?>
                </select>
                <p class="description"><?php _e('Select the role you want to assign new users', $this->textdomain); ?></p>
            </td>
        </tr>
    </table>
    <p class="submit">
        <img src="<?php echo admin_url('images/spinner.gif'); ?>" style="display: none;">
        <input type="submit" name="unisender_register_action" id="unisender_register_action"
               class="button button-primary" value="<?php _e('Import', $this->textdomain)?>">
        <a class="button button-primary" href="<?php echo admin_url('tools.php?page=unisender'); ?>"><?php _e('Cancel', $this->textdomain)?></a>
    </p>
</form>