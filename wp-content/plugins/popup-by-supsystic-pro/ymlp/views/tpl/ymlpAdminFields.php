<?php if(!$this->isSupported) { ?>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_ymlp">
	<th scope="row">
		<?php _e('Not supported by Server', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have JSON and Stream library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', PPS_LANG_CODE)?>
	</td>
</tr>	
<?php } else {?>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_ymlp">
	<th scope="row">
		<?php _e('API Key', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('You can find it under your YMLP Account.', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php echo htmlPps::text('params[tpl][sub_ymlp_api_key]', array(
			'value' => (isset($this->popup['params']['tpl']['sub_ymlp_api_key']) ? $this->popup['params']['tpl']['sub_ymlp_api_key'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_ymlp">
	<th scope="row">
		<?php _e('Username', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Your username in YMLP account.', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php echo htmlPps::text('params[tpl][sub_ymlp_name]', array(
			'value' => (isset($this->popup['params']['tpl']['sub_ymlp_name']) ? $this->popup['params']['tpl']['sub_ymlp_name'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_ymlp">
	<th scope="row">
		<?php _e('Groups for subscribe', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select Groups for subscribe. They are taken from your YMLP account.', PPS_LANG_CODE)?>"></i>
	</th>
	<td>
		<div id="ppsSubYmlpListsShell" style="display: none;">
			<?php echo htmlPps::selectlist('params[tpl][sub_ymlp_lists]', array(
				'value' => (isset($this->popup['params']['tpl']['sub_ymlp_lists']) ? $this->popup['params']['tpl']['sub_ymlp_lists'] : ''),
				'attrs' => 'id="ppsSubYmlpLists" class="chosen" data-placeholder="'. __('Choose Groups', PPS_LANG_CODE). '"',
			))?>
		</div>
		<span id="ppsSubYmlpMsg"></span>
	</td>
</tr>
<?php }?>

