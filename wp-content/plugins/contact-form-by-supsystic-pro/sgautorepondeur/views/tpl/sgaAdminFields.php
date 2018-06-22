<?php if(!$this->isSupported) { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_sgautorepondeur">
		<th scope="row">
			<?php _e('SG Autorepondeur not supported', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('This module is not supported by your server configuration.', CFS_LANG_CODE))?>"></i>
		</th>
		<td>
			<?php _e('SG Autorepondeur is not supported on your server', CFS_LANG_CODE)?>
		</td>
	</tr>
<?php } else { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_sgautorepondeur">
		<th scope="row">
			<?php _e('SG Autorepondeur User ID', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('This info available on your home page in SG Autorepondeur', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::text('params[tpl][sub_sga_id]', array(
				'value' => (isset($this->form['params']['tpl']['sub_sga_id']) ? $this->form['params']['tpl']['sub_sga_id'] : ''),
			))?>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_sgautorepondeur">
		<th scope="row">
			<?php _e('SG Autorepondeur List ID', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('This info available on your home page in SG Autorepondeur', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::text('params[tpl][sub_sga_list_id]', array(
				'value' => (isset($this->form['params']['tpl']['sub_sga_list_id']) ? $this->form['params']['tpl']['sub_sga_list_id'] : ''),
			))?>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_sgautorepondeur">
		<th scope="row">
			<?php _e('SG Client Activation Code', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('This info available on the member\'s area in the top menu "my account" (at the bottom of the page)', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::text('params[tpl][sub_sga_activate_code]', array(
				'value' => (isset($this->form['params']['tpl']['sub_sga_activate_code']) ? $this->form['params']['tpl']['sub_sga_activate_code'] : ''),
			))?>
		</td>
	</tr>
<?php }?>
