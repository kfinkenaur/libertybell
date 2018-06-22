<?php if(!$this->isSupported) { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_feedblitz">
		<th scope="row">
			<?php _e('FeedBlitz not supported', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('This module is not supported by your server configuration.', CFS_LANG_CODE))?>"></i>
		</th>
		<td>
			<?php _e('FeedBlitz is not supported on your server', CFS_LANG_CODE)?>
		</td>
	</tr>
<?php } else { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_feedblitz">
		<th scope="row">
			<?php _e('FeedBlitz API Key', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Your FeedBlitz API Key', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<?php echo htmlCfs::text('params[tpl][sub_feedb_key]', array(
				'value' => (isset($form['params']['tpl']['sub_feedb_key']) ? $form['params']['tpl']['sub_feedb_key'] : ''),
			))?>
		</td>
	</tr>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_feedblitz">
		<th scope="row">
			<?php _e('Lists for subscribe', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select lists for subscribe. They are taken from your FeedBlitz account.', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<div id="cfsSubFeedbListsShell" style="display: none;">
				<?php echo htmlCfs::selectlist('params[tpl][sub_feedb_lists]', array(
					'value' => (isset($this->form['params']['tpl']['sub_feedb_lists']) ? $this->form['params']['tpl']['sub_feedb_lists'] : ''),
					'attrs' => 'id="cfsSubFeedbLists" class="chosen" data-placeholder="'. __('Choose Lists', CFS_LANG_CODE). '"',
				))?>
			</div>
			<span id="cfsSubFeedbMsg"></span>
		</td>
	</tr>
<?php }?>
