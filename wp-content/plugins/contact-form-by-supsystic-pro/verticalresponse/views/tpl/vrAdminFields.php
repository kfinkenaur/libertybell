<?php if(!$this->isLoggedIn) { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_verticalresponse">
		<th scope="row">
			<?php _e('Vertical Response Setup', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('You must authorize to use Vertical Response features', CFS_LANG_CODE))?>"></i>
		</th>
		<td>
			<a class="button button-primary" href="<?php echo $this->authUrl?>"><?php _e('Authorize in Vertical Response')?></a>
		</td>
	</tr>
<?php } else { ?>
	<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_verticalresponse">
		<th scope="row">
			<?php _e('Lists for subscribe', CFS_LANG_CODE)?>
			<i class="fa fa-question supsystic-tooltip-bottom" title="<?php _e('Select lists for subscribe. They are taken from your Vertical Response account.', CFS_LANG_CODE)?>"></i>
		</th>
		<td>
			<div id="cfsSubVrListsShell" style="display: none;">
				<?php echo htmlCfs::selectlist('params[tpl][sub_vr_lists]', array(
					'value' => (isset($this->form['params']['tpl']['sub_vr_lists']) ? $this->form['params']['tpl']['sub_vr_lists'] : ''),
					//'options' => array('' => __('Loading...', CFS_LANG_CODE)),
					'attrs' => 'id="cfsSubVrLists" class="chosen" data-placeholder="'. __('Choose Lists', CFS_LANG_CODE). '"',
				))?>
			</div>
			<span id="cfsSubVrMsg"></span>
		</td>
	</tr>
<?php }?>
