<?php if(!$this->isSupported) { ?>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_benchmarkemail">
	<th scope="row">
		<?php _e('Not supported by Server', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php _e('This module require to have cUrl library for PHP on server installed. Please contact your hosting provider and ask them to enable cUrl for you, this is Free library.', CFS_LANG_CODE)?>
	</td>
</tr>	
<?php } else {?>

<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_benchmarkemail">
	<th scope="row">
		<?php _e('Benchmark Login', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Login for your Benchmark account.', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php echo htmlCfs::text('sub_be_login', array(
			'value' => $this->getModel()->getApiUsername(),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_benchmarkemail">
	<th scope="row">
		<?php _e('Benchmark Password', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Password for your Benchmark account.', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<?php echo htmlCfs::text('sub_be_pass', array(
			'value' => $this->getModel()->getApiPassword(),
			'attr' => 'style="width: 100%;"',
		))?>
	</td>
</tr>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_benchmarkemail">
	<th scope="row">
		<?php _e('Campaigns for subscribe', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select Campaigns for subscribe. They are taken from your Benchmark account.', CFS_LANG_CODE)?>"></i>
	</th>
	<td>
		<div id="cfsSubBeListsShell" style="display: none;">
			<?php echo htmlCfs::selectlist('params[tpl][sub_be_lists]', array(
				'value' => (isset($this->form['params']['tpl']['sub_be_lists']) ? $this->form['params']['tpl']['sub_be_lists'] : ''),
				'attrs' => 'id="cfsSubBeLists" class="chosen" data-placeholder="'. __('Choose Lists', CFS_LANG_CODE). '"',
			))?>
		</div>
		<span id="cfsSubBeMsg"></span>
	</td>
</tr>
<?php }?>

