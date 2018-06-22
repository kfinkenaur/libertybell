<?php if(!$this->isSupported) { ?>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_mailchimp">
	<th scope="row">
		<?php _e('Not supported by Server', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have cUrl library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', CFS_LANG_CODE)?>
	</td>
</tr>
<?php } else {?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_mailchimp">
		<th scope="row">
			<?php _e('MailChimp API key', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(sprintf(__('To find your MailChimp API Key login to your mailchimp account at <a href="%s" target="_blank">%s</a> then from the left main menu, click on your Username, then select "Account" in the flyout menu. From the account page select "Extras", "API Keys". Your API Key will be listed in the table labeled "Your API Keys". Copy / Paste your API key into "MailChimp API key" field here. For more detailed instruction - check article <a href="%s" target="_blank">here</a>.', CFS_LANG_CODE), 'http://mailchimp.com', 'http://mailchimp.com', 'https://supsystic.com/mailchimp-integration/'))?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::text('params[tpl][sub_mailchimp_api_key]', array(
				'value' => (isset($this->form['params']['tpl']['sub_mailchimp_api_key']) ? $this->form['params']['tpl']['sub_mailchimp_api_key'] : ''),
				'attrs' => 'style="min-width: 300px;"'))?>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_mailchimp">
		<th scope="row">
			<?php _e('Lists for subscribe', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select lists for subscribe. They are taken from your MailChimp account - so make sure that you entered correct API key before.', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<div id="cfsMailchimpListsShell" style="display: none;">
				<?php echo htmlCfs::selectlist('params[tpl][sub_mailchimp_lists]', array(
					'value' => (isset($this->form['params']['tpl']['sub_mailchimp_lists']) ? $this->form['params']['tpl']['sub_mailchimp_lists'] : ''),
					'attrs' => 'id="cfsMailchimpLists" class="chosen" data-placeholder="'. __('Choose Lists', CFS_LANG_CODE). '"',
				))?>
			</div>
			<span id="cfsMailchimpNoApiKey"><?php _e('Enter API key - and your list will appear here', CFS_LANG_CODE)?></span>
			<span id="cfsMailchimpMsg"></span>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_mailchimp">
		<th scope="row">
			<?php _e('Disable double opt-in', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip" title="<?php echo _e('Disable double opt-in confirmation message sending - will create subscriber directly after he will sign-up to your form.', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::checkbox('params[tpl][sub_dsbl_dbl_opt_id]', array(
				'checked' => htmlCfs::checkedOpt($this->form['params']['tpl'], 'sub_dsbl_dbl_opt_id')))?><br />

			<label id="cfsSubMcSendWelcome">
				<?php echo htmlCfs::checkbox('params[tpl][sub_mc_enb_welcome]', array(
					'checked' => htmlCfs::checkedOpt($this->form['params']['tpl'], 'sub_mc_enb_welcome')))?>
				<?php _e('Send MailChimp Welcome Email', CFS_LANG_CODE)?>&nbsp;
				<i style="float: none;" class="fa fa-question supsystic-tooltip" title="<?php echo _e('If double opt-in is disable - there will be no Welcome email from MailChimp by default. But if you still need it - just enable this opton, and Welcome email from MailChimp will be sent to your user even in this case.', CFS_LANG_CODE)?>"></i>
			</label>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_mailchimp">
		<th scope="row">
			<?php _e('Group for subscribe', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('In MailChimp there are possibility to select groups for your subscribers. This is not mandatory, but some times is really helpful. So, we added this possibility for you in our plugin too - hope you will like it!', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<div id="cfsMailchimpGroupsShell" style="display: none;">
				<?php echo htmlCfs::selectlist('params[tpl][sub_mailchimp_groups]', array(
					'value' => (isset($this->form['params']['tpl']['sub_mailchimp_groups']) ? $this->form['params']['tpl']['sub_mailchimp_groups'] : ''),
					'attrs' => 'id="cfsMailchimpGroups" class="chosen" data-placeholder="'. __('Choose Groups', CFS_LANG_CODE). '"',
				))?>
			</div>
			<span id="cfsMailchimpGroupsNoApiKey"><?php _e('Enter API key, select List - and your groups will appear here', CFS_LANG_CODE)?></span>
			<span id="cfsMailchimpGroupsMsg"></span>
			<?php echo htmlCfs::hidden('params[tpl][sub_mailchimp_groups_full]', array(
				'value' => (isset($this->form['params']['tpl']['sub_mailchimp_groups_full']) ? $this->form['params']['tpl']['sub_mailchimp_groups_full'] : ''),
			))?>
		</td>
	</tr>
<?php }

