<?php if(!$this->isSupported) { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_sendgrid">
		<th scope="row">
			<?php _e('SendGrid not supported', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('This module is not supported by your server configuration.', CFS_LANG_CODE))?>"></i>
		</th>
		<td>
			<?php _e('SendGrid is not supported on your server', CFS_LANG_CODE)?>
		</td>
	</tr>
<?php } else { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_sendgrid">
		<th scope="row">
			<?php _e('SendGrid API Key', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Your SendGrid API Key. You can ganarate it in your SendGrid account -> Settings -> API Keys. Don\'t forger to enable for it all required permissins.', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::password('sub_sg_api_key', array(
				'value' => $this->getModel()->getApiPassword(),
			))?>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_sendgrid">
		<th scope="row">
			<?php _e('Lists for subscribe', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select lists for subscribe. They are taken from your SendGrid account.', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<div id="cfsSubSgListsShell" style="display: none;">
				<?php echo htmlCfs::selectlist('params[tpl][sub_sg_lists]', array(
					'value' => (isset($this->form['params']['tpl']['sub_sg_lists']) ? $this->form['params']['tpl']['sub_sg_lists'] : ''),
					//'options' => array('' => __('Loading...', CFS_LANG_CODE)),
					'attrs' => 'id="cfsSubSgLists" class="chosen" data-placeholder="'. __('Choose Lists', CFS_LANG_CODE). '"',
				))?>
			</div>
			<span id="cfsSubSgMsg"></span>
		</td>
	</tr>
<?php }?>
