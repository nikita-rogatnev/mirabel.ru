<form action="" method="post" name="unisender_message_sms_edit" id="unisender_message_sms_edit" class="validate">
    <h3><?php _e('New SMS', $this->textdomain); ?></h3>
    <input name="action" type="hidden" value="unisender_message_new">
    <table class="form-table">
        <tr class="form-field">
            <th scope="row">
                <span class="description">*</span> <label for="sender"><?php _e('Sender', $this->textdomain)?></label>
            </th>
            <td>
                <input name="sender" type="text" id="sender" value="<?php echo !empty($message['sender']) ? $message['sender'] : ''; ?>" aria-required="true" placeholder="<?php _e('Sender', $this->textdomain)?>" required>
                <p class="description"><?php _e('Phone number of the sender or the sender\'s name up to 11 alphanumeric characters', $this->textdomain); ?></p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <span class="description">*</span> <label for="body"><?php _e('SMS text', $this->textdomain)?></label>
            </th>
            <td>
                <input name="body" type="text" id="body" value="<?php echo !empty($message['body']) ? $message['body'] : ''; ?>"
                       aria-required="true" placeholder="<?php _e('SMS text', $this->textdomain)?>" required>
                <p class="description"><?php _e('SMS text field with <a href="http://support.unisender.com/index.php?/Knowledgebase/Article/View/35/0/podstnovk-strok-v-pisme" target = "_ blank"> placeholders </a>', $this->textdomain); ?></p>
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
                <p class="description"><?php _e('Sending messages is only possible on the same ticket. To send a list of other necessary to create a new message', $this->textdomain); ?></p>
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
                    <input name="series_time" type="time" id="series_time" value="<?php echo $message['series_time']; ?>">
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
