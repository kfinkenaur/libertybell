<?php if(!$this->isSupported) { ?>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_aweber">
	<th scope="row">
		<?php _e('Not supported by Server', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have cUrl library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', CFS_LANG_CODE)?>
	</td>
</tr>
<?php } elseif(!$this->isLoggedIn) { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_aweber">
		<th scope="row">
			<?php _e('Consumer Key', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(sprintf(__('You can find it under your Application settings at <a href="%s" target="_blank">Aweber Labs account</a>', CFS_LANG_CODE), 'https://labs.aweber.com/apps'))?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::text('params[tpl][sub_aw_c_key]', array(
				'value' => ($this->keySecret && isset($this->keySecret['key']) ? $this->keySecret['key'] : ''),
				'attr' => 'style="width: 100%;"',
			))?>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_aweber">
		<th scope="row">
			<?php _e('Consumer Secret', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(sprintf(__('You can find it under your Application settings at <a href="%s" target="_blank">Aweber Labs account</a>', CFS_LANG_CODE), 'https://labs.aweber.com/apps'))?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::text('params[tpl][sub_aw_c_secret]', array(
				'value' => ($this->keySecret && isset($this->keySecret['secret']) ? $this->keySecret['secret'] : ''),
				'attr' => 'style="width: 100%;"',
			))?>
			<div id="cfsAweberAuthMsg"></div>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_aweber">
		<th scope="row" class="cfsAweberAuthBtnRow"<?php if(empty($this->authUrl)) { ?>
			style="display: none;"
		<?php }?>>
			<?php _e('Authorize in Aweber Account', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('To start integration process - you need to be authorized in Aweber account.', CFS_LANG_CODE))?>"></i>
		</th>
		<td class="cfsAweberAuthBtnRow"<?php if(empty($this->authUrl)) { ?>
			style="display: none;"
		<?php }?>>
			<a href="<?php echo !empty($this->authUrl) ? $this->authUrl : '';?>" target="_blank" class="button cfsAweberAuthBtn" onclick="cfsSaveForm();" data-clb-url="<?php echo $this->clbUrl;?>"><?php _e('Authorize', CFS_LANG_CODE)?></a>
		</td>
	</tr>
<?php } else {?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_aweber">
		<th scope="row">
			<?php _e('Lists for subscribe', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select lists for subscribe. They are taken from your Aweber account - so make sure that you entered correct API key before.', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<div id="cfsAweberListsShell" style="display: none;">
				<?php echo htmlCfs::selectlist('params[tpl][sub_aweber_lists]', array(
					'value' => (isset($this->form['params']['tpl']['sub_aweber_lists']) ? $this->form['params']['tpl']['sub_aweber_lists'] : ''),
					'attrs' => 'id="cfsAweberLists" class="chosen" data-placeholder="'. __('Choose Lists', CFS_LANG_CODE). '"',
				))?>
			</div>
			<span id="cfsAweberNoApiKey"><?php _e('Enter API key - and your list will appear here', CFS_LANG_CODE)?></span>
			<span id="cfsAweberMsg"></span>
		</td>
	</tr>
<?php }

