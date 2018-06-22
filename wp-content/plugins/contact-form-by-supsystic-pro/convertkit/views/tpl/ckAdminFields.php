<?php if(!$this->isSupported) { ?>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_convertkit">
	<th scope="row">
		<?php _e('Not supported by Server', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have cUrl library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', CFS_LANG_CODE)?>
	</td>
</tr>	
<?php } else {?>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_convertkit">
	<th scope="row">
		<?php _e('API Key', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('You can find your API Key in the ConvertKit Account page.', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php echo htmlCfs::text('params[tpl][sub_ck_api_key]', array(
			'value' => (isset($this->form['params']['tpl']['sub_ck_api_key']) ? $this->form['params']['tpl']['sub_ck_api_key'] : ''),
		))?>
	</td>
</tr>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_convertkit">
	<th scope="row">
		<?php _e('Forms to Subscribe', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select Forms for subscribe. They are taken from your ConvertKit account.', CFS_LANG_CODE)?>"></i>
	</th>
	<td>
		<div id="cfsSubCkListsShell" style="display: none;">
			<?php echo htmlCfs::selectlist('params[tpl][sub_ck_lists]', array(
				'value' => (isset($this->form['params']['tpl']['sub_ck_lists']) ? $this->form['params']['tpl']['sub_ck_lists'] : ''),
				'attrs' => 'id="cfsSubCkLists" class="chosen" data-placeholder="'. __('Choose Forms', CFS_LANG_CODE). '"',
			))?>
		</div>
		<span id="cfsSubCkMsg"></span>
	</td>
</tr>
<?php }?>

