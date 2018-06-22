<?php if(!$this->isSupported) { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_arpreach">
		<th scope="row">
			<?php _e('arpReach not supported', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('This module is not supported by your server configuration.', CFS_LANG_CODE))?>"></i>
		</th>
		<td>
			<?php _e('arpReach is not supported on your server.', CFS_LANG_CODE)?>
		</td>
	</tr>
<?php } else { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_arpreach">
		<th scope="row">
			<?php _e('arpReach intake form Action URL', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_attr(__('Open your script for intake form, find there form tag with form method=\'post\' action=\'http://yourdomain.coma/a/a.php/sub/a/xxxxxx\', then copy "action" attribute - and paste it in text field below.', CFS_LANG_CODE))?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::text('params[tpl][sub_ar_form_action]', array(
				'value' => (isset($this->form['params']['tpl']['sub_ar_form_action']) ? $this->form['params']['tpl']['sub_ar_form_action'] : ''),
				'attrs' => 'placeholder="http://yourdomain.coma/a/a.php/sub/a/xxxxxx" style="width: 100%;"',
			))?>
		</td>
	</tr>
<?php }?>
