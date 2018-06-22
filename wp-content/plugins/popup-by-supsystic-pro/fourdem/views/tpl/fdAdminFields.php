<?php if(!$this->isSupported) { ?>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_fourdem">
	<th scope="row">
		<?php _e('Not supported by Server', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have cUrl library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', PPS_LANG_CODE)?>
	</td>
</tr>	
<?php } else {?>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_fourdem">
	<th scope="row">
		<?php _e('Username', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Your username for 4Dem.it account.', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php echo htmlPps::text('params[tpl][sub_4d_name]', array(
			'value' => (isset($this->popup['params']['tpl']['sub_4d_name']) ? $this->popup['params']['tpl']['sub_4d_name'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_fourdem">
	<th scope="row">
		<?php _e('Password', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Your password for 4Dem.it account.', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php echo htmlPps::text('params[tpl][sub_4d_pass]', array(
			'value' => (isset($this->popup['params']['tpl']['sub_4d_pass']) ? $this->popup['params']['tpl']['sub_4d_pass'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_fourdem">
	<th scope="row">
		<?php _e('Lists for subscribe', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select Lists for subscribe. They are taken from your SendinBlue account.', PPS_LANG_CODE)?>"></i>
	</th>
	<td>
		<div id="ppsSub4dListsShell" style="display: none;">
			<?php echo htmlPps::selectlist('params[tpl][sub_4d_lists]', array(
				'value' => (isset($this->popup['params']['tpl']['sub_4d_lists']) ? $this->popup['params']['tpl']['sub_4d_lists'] : ''),
				'attrs' => 'id="ppsSub4dLists" class="chosen" data-placeholder="'. __('Choose Lists', PPS_LANG_CODE). '"',
			))?>
		</div>
		<span id="ppsSub4dMsg"></span>
	</td>
</tr>
<?php }?>

