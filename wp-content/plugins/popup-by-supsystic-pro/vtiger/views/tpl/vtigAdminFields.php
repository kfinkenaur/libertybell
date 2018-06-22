<?php if(!$this->isSupported) { ?>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_vtiger">
	<th scope="row">
		<?php _e('Not supported by Server', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have cUrl library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', PPS_LANG_CODE)?>
	</td>
</tr>	
<?php } else {?>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_vtiger">
	<th scope="row">
		<?php _e('Your Vtiger URL', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('You can find it under your Vtiger - it\'s just first part of yur URL in browser.', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php echo htmlPps::text('params[tpl][sub_vtig_url]', array(
			'value' => (isset($this->popup['params']['tpl']['sub_vtig_url']) ? $this->popup['params']['tpl']['sub_vtig_url'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_vtiger">
	<th scope="row">
		<?php _e('Username', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Your Vtiger username.', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php echo htmlPps::text('params[tpl][sub_vtig_name]', array(
			'value' => (isset($this->popup['params']['tpl']['sub_vtig_name']) ? $this->popup['params']['tpl']['sub_vtig_name'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_vtiger">
	<th scope="row">
		<?php _e('API Key', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('You can find it under your Vtiger Account -> My Prefences.', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php echo htmlPps::text('params[tpl][sub_vtig_key]', array(
			'value' => (isset($this->popup['params']['tpl']['sub_vtig_key']) ? $this->popup['params']['tpl']['sub_vtig_key'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<?php }?>

