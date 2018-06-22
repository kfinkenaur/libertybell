<?php if(!$this->isSupported) { ?>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_activecampaign">
	<th scope="row">
		<?php _e('Not supported by Server', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have cUrl library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', CFS_LANG_CODE)?>
	</td>
</tr>	
<?php } else {?>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_activecampaign">
	<th scope="row">
		<?php _e('API URL', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(sprintf(__('You can find it under your Active Campaign Account -> My Settings -> API, here is <a href="%s" class="cfsAcHelpApiKeyLink">help screenshot</a>', CFS_LANG_CODE), $this->helpImgLink))?>"></i>
	</th>
	<td>
		<?php echo htmlCfs::text('params[tpl][sub_ac_api_url]', array(
			'value' => (isset($this->form['params']['tpl']['sub_ac_api_url']) ? $this->form['params']['tpl']['sub_ac_api_url'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_activecampaign">
	<th scope="row">
		<?php _e('API Key', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(sprintf(__('You can find it under your Active Campaign Account -> My Settings -> API, here is <a href="%s" class="cfsAcHelpApiKeyLink">help screenshot</a>', CFS_LANG_CODE), $this->helpImgLink))?>"></i>
	</th>
	<td>
		<?php echo htmlCfs::text('params[tpl][sub_ac_api_key]', array(
			'value' => (isset($this->form['params']['tpl']['sub_ac_api_key']) ? $this->form['params']['tpl']['sub_ac_api_key'] : ''),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_activecampaign">
	<th scope="row">
		<?php _e('Campaigns for subscribe', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select Campaigns for subscribe. They are taken from your Active Campaign account.', CFS_LANG_CODE)?>"></i>
	</th>
	<td>
		<div id="cfsSubAcListsShell" style="display: none;">
			<?php echo htmlCfs::selectlist('params[tpl][sub_ac_lists]', array(
				'value' => (isset($this->form['params']['tpl']['sub_ac_lists']) ? $this->form['params']['tpl']['sub_ac_lists'] : ''),
				//'options' => array('' => __('Loading...', CFS_LANG_CODE)),
				'attrs' => 'id="cfsSubAcLists" class="chosen" data-placeholder="'. __('Choose Lists', CFS_LANG_CODE). '"',
			))?>
		</div>
		<span id="cfsSubAcMsg"></span>
	</td>
</tr>
<?php }?>

