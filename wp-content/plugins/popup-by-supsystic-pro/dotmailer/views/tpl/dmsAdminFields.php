<?php if(!$this->isSupported) { ?>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_dotmailer">
	<th scope="row">
		<?php _e('Not supported by Server', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have cUrl library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', PPS_LANG_CODE)?>
	</td>
</tr>	
<?php } else {?>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_dotmailer">
	<th scope="row">
		<?php _e('API Username (API Email)', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(sprintf(__('You can find it under your Dotmailer Account -> Access -> API users, here is <a href="%s" target="_blank">link</a> to this page in your account.', PPS_LANG_CODE), 'https://developer.dotmailer.com/docs/getting-started-with-the-api#section-setting-up-your-api-user'))?>"></i>
	</th>
	<td>
		<?php echo htmlPps::text('params[tpl][sub_dms_api_user]', array(
			'value' => (isset($this->popup['params']['tpl']['sub_dms_api_user']) ? $this->popup['params']['tpl']['sub_dms_api_user'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_dotmailer">
	<th scope="row">
		<?php _e('API Password', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(sprintf(__('You can find it under your Dotmailer Account -> Access -> API users, here is <a href="%s" target="_blank">link</a> to this page in your account.', PPS_LANG_CODE), 'https://developer.dotmailer.com/docs/getting-started-with-the-api#section-setting-up-your-api-user'))?>"></i>
	</th>
	<td>
		<?php echo htmlPps::password('params[tpl][sub_dms_api_password]', array(
			'value' => (isset($this->popup['params']['tpl']['sub_dms_api_password']) ? $this->popup['params']['tpl']['sub_dms_api_password'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_dotmailer">
	<th scope="row">
		<?php _e('Subscriber status', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Status of just subscribed users to your account.', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php echo htmlPps::selectbox('params[tpl][sub_dms_optin]', array(
			'value' => (isset($this->popup['params']['tpl']['sub_dms_optin']) ? $this->popup['params']['tpl']['sub_dms_optin'] : ''),
			'options' => array(
				'Unknown' => __('Unknown', PPS_LANG_CODE),
				'Single' => __('Single', PPS_LANG_CODE),
				'Double' => __('Double', PPS_LANG_CODE),
				'VerifiedDouble' => __('Verified Double', PPS_LANG_CODE),
			),
		))?>
	</td>
</tr>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_dotmailer">
	<th scope="row">
		<?php _e('Address Book for subscribe', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select Address Book for subscribe. They are taken from your Dotmailer account.', PPS_LANG_CODE)?>"></i>
	</th>
	<td>
		<div id="ppsSubDmsListsShell" style="display: none;">
			<?php echo htmlPps::selectlist('params[tpl][sub_dms_lists]', array(
				'value' => (isset($this->popup['params']['tpl']['sub_dms_lists']) ? $this->popup['params']['tpl']['sub_dms_lists'] : ''),
				'attrs' => 'id="ppsSubDmsLists" class="chosen" data-placeholder="'. __('Choose Address Book', PPS_LANG_CODE). '"',
			))?>
		</div>
		<span id="ppsSubDmsMsg"></span>
	</td>
</tr>
<?php }?>

