<div class="wrap">
	<h2>UniSender Integration</h2>

	<h2 class="nav-tab-wrapper">
		<a href="<?php echo admin_url('tools.php?page=unisender'); ?>" class="nav-tab<?php echo $this->section === null || $this->section === 'ContactList' ? ' nav-tab-active' : ''; ?>">
			<?php _e('Contact lists', $this->textdomain); ?></a>
		<a href="<?php echo admin_url('tools.php?page=unisender&section=field'); ?>" class="nav-tab<?php echo $this->section === 'Field' ? ' nav-tab-active' : ''; ?>">
			<?php _e('Additional fields', $this->textdomain); ?></a>
		<a href="<?php echo admin_url('tools.php?page=unisender&section=form'); ?>" class="nav-tab<?php echo $this->section === 'Form' ? ' nav-tab-active' : ''; ?>">
			<?php _e('Subscription form', $this->textdomain); ?></a>
		<!--<a href="<?php /*echo admin_url('tools.php?page=unisender&section=message'); */?>" class="nav-tab<?php /*echo $this->section === 'Message' ? ' nav-tab-active' : ''; */?>">
			<?php /*_e('Campaigns', $this->textdomain); */?></a>-->
	</h2>

	<?php include(dirname(plugin_dir_path(__FILE__)) . '/tpl/'.$tpl); ?>

	<br class="clear">

	<div class="unisenderSyncBlock">
		<a href="#" onClick="return unisenderSync()"><?php _e('Sync now', $this->textdomain); ?></a>
		<div class="notice"></div>
	</div>

	<br class="clear">
</div>