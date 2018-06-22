<?php if(!$this->isSupported) { ?>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_get_response">
	<th scope="row">
		<?php _e('Not supported by Server', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have cUrl library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', CFS_LANG_CODE)?>
	</td>
</tr>	
<?php } else {?>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_get_response">
	<th scope="row">
		<?php _e('API Key', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(sprintf(__('You can find it under your GetResponse Account -> GetResponse API, here is <a href="%s" class="cfsGrHelpApiKeyLink" target="_blank">help screenshot</a>', CFS_LANG_CODE), $this->helpImgLink))?>"></i>
	</th>
	<td>
		<?php echo htmlCfs::text('params[tpl][sub_gr_api_key]', array(
			'value' => (isset($this->form['params']['tpl']['sub_gr_api_key']) ? $this->form['params']['tpl']['sub_gr_api_key'] : ''),
		))?>
	</td>
</tr>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_get_response">
	<th scope="row">
		<?php _e('Campaigns for subscribe', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select Campaigns for subscribe. They are taken from your GetResponse account.', CFS_LANG_CODE)?>"></i>
	</th>
	<td>
		<div id="cfsSubGrListsShell" style="display: none;">
			<?php echo htmlCfs::selectlist('params[tpl][sub_gr_lists]', array(
				'value' => (isset($this->form['params']['tpl']['sub_gr_lists']) ? $this->form['params']['tpl']['sub_gr_lists'] : ''),
				//'options' => array('' => __('Loading...', CFS_LANG_CODE)),
				'attrs' => 'id="cfsSubGrLists" class="chosen" data-placeholder="'. __('Choose Lists', CFS_LANG_CODE). '"',
			))?>
		</div>
		<span id="cfsSubGrMsg"></span>
	</td>
</tr>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_get_response">
	<th scope="row">
		<?php _e('Cycle Day', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Insert contact on a given day at the autoresponder cycle. Value of 0 means the beginning of the cycle. Lack of this param means that a contact will not be inserted into cycle.', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php echo htmlCfs::text('params[tpl][sub_gr_cycle_day]', array(
			'value' => (isset($this->form['params']['tpl']['sub_gr_cycle_day']) ? $this->form['params']['tpl']['sub_gr_cycle_day'] : '0'),
		))?>
	</td>
</tr>
<?php }?>

