<section class="supsystic-bar">
	<h4>
		<?php if($this->isActive) {
			printf(__('Congratulations! PRO version of %s plugin has been activated and is working fine!', CFS_LANG_CODE), CFS_WP_PLUGIN_NAME);
		} elseif($this->isExpired) {
			printf(__('Your license for PRO version of %s plugin has expired. You can <a href="%s" target="_blank">click here</a> to extend your license, then - click on "Re-activate" button to re-activate your PRO version.', CFS_LANG_CODE), CFS_WP_PLUGIN_NAME, $this->extendUrl);
		} else {
			printf(__('Congratulations! You have successfully installed PRO version of %s plugin. Final step to finish Your PRO version setup - is to enter your Email and License Key on this page. This will activate Your copy of software on this site.', CFS_LANG_CODE), CFS_WP_PLUGIN_NAME);
		}?>
	</h4>
	<div style="clear: both;"></div>
	<hr />
</section>
<section>
	<form id="cfsLicenseForm" class="">
		<div class="supsystic-item supsystic-panel">
			<table class="form-table" style="">
				<tr>
					<th scope="row" style="">
						<?php _e('Email', CFS_LANG_CODE)?>
					</th>
					<td style="width: 1px;">
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(sprintf(__('Your email address, used on checkout procedure on <a href="%s" target="_blank">%s</a>', CFS_LANG_CODE), 'http://supsystic.com/', 'http://supsystic.com/'))?>"></i>
					</td>
					<td>
						<?php echo htmlCfs::text('email', array('value' => $this->credentials['email'], 'attrs' => 'style="width: 300px;"'))?>
					</td>
				</tr>
				<tr>
					<th scope="row" style="">
						<?php _e('License Key', CFS_LANG_CODE)?>
					</th>
					<td>
						<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(sprintf(__('Your License Key from your account on <a href="%s" target="_blank">%s</a>', CFS_LANG_CODE), 'http://supsystic.com/', 'http://supsystic.com/'))?>"></i>
					</td>
					<td>
						<?php echo htmlCfs::text('key', array('value' => $this->credentials['key'], 'attrs' => 'style="width: 300px;"'))?>
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="3" style="">
						<?php echo htmlCfs::hidden('mod', array('value' => 'license'))?>
						<?php echo htmlCfs::hidden('action', array('value' => 'activate'))?>
						<button class="button button-primary">
							<i class="fa fa-fw fa-save"></i>
							<?php if($this->isExpired) {
								_e('Re-activate', CFS_LANG_CODE);
							} else {
								_e('Activate', CFS_LANG_CODE);
							}?>
						</button>
					</th>
				</tr>
			</table>
			<div style="clear: both;"></div>
			
		</div>
	</form>
</section>