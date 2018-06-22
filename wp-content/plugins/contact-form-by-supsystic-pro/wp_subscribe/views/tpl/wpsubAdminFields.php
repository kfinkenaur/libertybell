<?php if(!$this->isSupported) { ?>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_wp_subscribe">
	<th scope="row">
		<?php _e('Not supported by Server', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have cUrl library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', CFS_LANG_CODE)?>
	</td>
</tr>
<?php } else {?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_wp_subscribe">
		<th scope="row">
			<?php _e('Create user with the chosen role after subscribing', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip" title="<?php _e('Use this only if you really need it. Remember! After you change this option - your new subscriber will have more privileges than usual subscribers, so be careful with this option!', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::selectbox('params[tpl][sub_wp_create_user_role]', array(
				'options' => $this->availableUserRoles,
				'value' => (isset($this->form['params']['tpl']['sub_wp_create_user_role']) ? $this->form['params']['tpl']['sub_wp_create_user_role'] : 'subscriber')))?>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_wp_subscribe">
		<th scope="row">
			<?php _e('Create Subscriber without confirmation', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip" title="<?php _e('Usually, after user subscribes, we send an email with the confirmation link - to confirm the email address, and only after user clicks on the link from this email - we will create a new subscriber. This option allows you to create a subscriber - right after subscription, without the email confirmation process.', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::checkbox('params[tpl][sub_ignore_confirm]', array(
				'checked' => htmlCfs::checkedOpt($this->form['params']['tpl'], 'sub_ignore_confirm')))?>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_wp_subscribe">
		<th scope="row">
			<?php _e('Export Subscribers', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip" title="<?php _e('Export all subscribers, who subscribed using WordPress "Subscribe to" method, as CSV file.', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<a href="<?php echo $this->wpCsvExportUrl;?>" class="button"><?php _e('Get CSV List', CFS_LANG_CODE)?></a>
		</td>
	</tr>
<?php }?>

