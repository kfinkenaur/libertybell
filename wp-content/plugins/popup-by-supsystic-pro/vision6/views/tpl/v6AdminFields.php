<?php if(!$this->isSupported) { ?>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_vision6">
	<th scope="row">
		<?php _e('Not supported by Server', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have JSON and Stream library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', PPS_LANG_CODE)?>
	</td>
</tr>	
<?php } else {?>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_vision6">
	<th scope="row">
		<?php _e('API Key', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(sprintf(__('You can find it under your Vision6 Account -> Integrations -> API Keys, here is <a href="%s" target="_blank">link</a> to this page in your account.', PPS_LANG_CODE), 'https://app.vision6.com/integration/api_keys/'))?>"></i>
	</th>
	<td>
		<?php echo htmlPps::text('params[tpl][sub_v6_api_key]', array(
			'value' => (isset($this->popup['params']['tpl']['sub_v6_api_key']) ? $this->popup['params']['tpl']['sub_v6_api_key'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_vision6">
	<th scope="row">
		<?php _e('Lists for subscribe', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select Lists for subscribe. They are taken from your Vision6 account.', PPS_LANG_CODE)?>"></i>
	</th>
	<td>
		<div id="ppsSubV6ListsShell" style="display: none;">
			<?php echo htmlPps::selectlist('params[tpl][sub_v6_lists]', array(
				'value' => (isset($this->popup['params']['tpl']['sub_v6_lists']) ? $this->popup['params']['tpl']['sub_v6_lists'] : ''),
				'attrs' => 'id="ppsSubV6Lists" class="chosen" data-placeholder="'. __('Choose Lists', PPS_LANG_CODE). '"',
			))?>
		</div>
		<span id="ppsSubV6Msg"></span>
	</td>
</tr>
<?php }?>

