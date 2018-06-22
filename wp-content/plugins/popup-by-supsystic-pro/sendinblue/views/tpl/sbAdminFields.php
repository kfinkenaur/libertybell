<?php if(!$this->isSupported) { ?>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_sendinblue">
	<th scope="row">
		<?php _e('Not supported by Server', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', PPS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have cUrl library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', PPS_LANG_CODE)?>
	</td>
</tr>	
<?php } else {?>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_sendinblue">
	<th scope="row">
		<?php _e('API Key', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(sprintf(__('You can find it under your SendinBlue Account -> SMTP & API -> API Keys, here is <a href="%s" target="_blank">link</a> to this page in your account.', PPS_LANG_CODE), 'https://account.sendinblue.com/advanced/api'))?>"></i>
	</th>
	<td>
		<?php echo htmlPps::text('params[tpl][sub_sb_api_key]', array(
			'value' => (isset($this->popup['params']['tpl']['sub_sb_api_key']) ? $this->popup['params']['tpl']['sub_sb_api_key'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="ppsPopupSubDestOpts ppsPopupSubDestOpts_sendinblue">
	<th scope="row">
		<?php _e('Lists for subscribe', PPS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select Lists for subscribe. They are taken from your SendinBlue account.', PPS_LANG_CODE)?>"></i>
	</th>
	<td>
		<div id="ppsSubSbListsShell" style="display: none;">
			<?php echo htmlPps::selectlist('params[tpl][sub_sb_lists]', array(
				'value' => (isset($this->popup['params']['tpl']['sub_sb_lists']) ? $this->popup['params']['tpl']['sub_sb_lists'] : ''),
				'attrs' => 'id="ppsSubSbLists" class="chosen" data-placeholder="'. __('Choose Lists', PPS_LANG_CODE). '"',
			))?>
		</div>
		<span id="ppsSubSbMsg"></span>
	</td>
</tr>
<?php }?>

