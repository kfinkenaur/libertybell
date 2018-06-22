<?php if(!$this->isSupported) { ?>
<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_jetpack">
	<th scope="row">
		<?php _e('Not supported by Server', CFS_LANG_CODE)?>
		<i class="fa fa-question supsystic-tooltip-bottom" title="<?php echo esc_html(__('Not supported on your server', CFS_LANG_CODE))?>"></i>
	</th>
	<td>
		<div class="description"><?php printf(__('To use this subscribe engine - you must have <a target="_blank" href="%s">Jetpack plugin</a> installed on your site', CFS_LANG_CODE), admin_url('plugin-install.php?tab=search&s=Jetpack'))?></div>
	</td>
</tr>
<?php } else {?>
<?php /*No additional options for this service for now*/ ?>
<?php }

