<?php if(!$this->isSupported) { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_myemma">
		<th scope="row">
			<?php _e('Emma not supported', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('This module is not supported by your server configuration.', CFS_LANG_CODE))?>"></i>
		</th>
		<td>
			<?php _e('Emma is not supported on your server, please nstall cUrl PHP Library on your server first - it\'s free.', CFS_LANG_CODE)?>
		</td>
	</tr>
<?php } else { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_myemma">
		<th scope="row">
			<?php _e('Emma Account ID', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Your account ID', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::text('params[tpl][sub_mem_acc_id]', array(
				'value' => (isset($this->form['params']['tpl']['sub_mem_acc_id']) ? $this->form['params']['tpl']['sub_mem_acc_id'] : ''),
			))?>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_myemma">
		<th scope="row">
			<?php _e('Emma Public API key', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Your Public API key', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::text('params[tpl][sub_mem_pud_key]', array(
				'value' => (isset($this->form['params']['tpl']['sub_mem_pud_key']) ? $this->form['params']['tpl']['sub_mem_pud_key'] : ''),
			))?>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_myemma">
		<th scope="row">
			<?php _e('Emma Private API key', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Your Private API key', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::password('params[tpl][sub_mem_priv_key]', array(
				'value' => (isset($this->form['params']['tpl']['sub_mem_priv_key']) ? $this->form['params']['tpl']['sub_mem_priv_key'] : ''),
			))?>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_myemma">
		<th scope="row">
			<?php _e('Groups for subscribe', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('To create new groups in Emma, you must login into the control panel and click into the Emma > Subscribers groups. Once there you can add a new group for your Wordpress users, or edit an existing one', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<div id="cfsSubMemListsShell" style="display: none;">
				<?php echo htmlCfs::selectlist('params[tpl][sub_mem_lists]', array(
					'value' => (isset($this->form['params']['tpl']['sub_mem_lists']) ? $this->form['params']['tpl']['sub_mem_lists'] : ''),
					'attrs' => 'id="cfsSubMemLists" class="chosen" data-placeholder="'. __('Choose Lists', CFS_LANG_CODE). '"',
				))?>
			</div>
			<span id="cfsSubMemMsg"></span>
		</td>
	</tr>
<?php }?>
