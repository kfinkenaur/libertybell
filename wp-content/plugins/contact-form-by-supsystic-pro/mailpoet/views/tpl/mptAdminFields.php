<?php if(!$this->isSupported) { ?>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_mailpoet">
	<th scope="row">
		<?php _e('Not supported by Server', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<div class="description"><?php printf(__('To use this subscribe engine - you must have <a target="_blank" href="%s">MailPoet plugin</a> installed on your site', CFS_LANG_CODE), admin_url('plugin-install.php?tab=search&s=MailPoet'))?></div>
	</td>
</tr>
<?php } else {?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_mailpoet">
		<th scope="row">
			<?php _e('MailPoet Subscribe Lists', CFS_LANG_CODE)?>
		</th>
		<td>
			<?php if(!empty($this->mailPoetListsSelect)) { ?>
				<?php echo htmlCfs::selectbox('params[tpl][sub_mailpoet_list]', array(
					'value' => (isset($this->form['params']['tpl']['sub_mailpoet_list']) ? $this->form['params']['tpl']['sub_mailpoet_list'] : ''),
					'options' => $this->mailPoetListsSelect))?>
			<?php } else { ?>
				<div class="description"><?php printf(__('You have no subscribe lists, <a target="_blank" href="%s">create lists</a> at first, then - select them here.', CFS_LANG_CODE), admin_url('admin.php?page=wysija_subscribers&action=addlist'))?></div>
			<?php }?>
		</td>
	</tr>
<?php }

