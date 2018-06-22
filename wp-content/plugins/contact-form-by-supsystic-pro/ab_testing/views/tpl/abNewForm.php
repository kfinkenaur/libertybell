<!--Add one more test-->
<div id="cfsAbAddNewWnd" title="<?php _e('Add New Test', CFS_LANG_CODE)?>" style="display: none;">
	<form id="cfsAbAddNewForm">
		<label>
			<h3 style="float: left; margin: 10px;"><?php _e('Test Form Name', CFS_LANG_CODE)?>:</h3>
			<?php echo htmlCfs::text('label', array('attrs' => 'style="float: left; width: 50%;"'))?>
		</label>
		<?php echo htmlCfs::hidden('base_id', array('value' => $this->form['id']))?>
		<?php echo htmlCfs::hidden('mod', array('value' => 'ab_testing'))?>
		<?php echo htmlCfs::hidden('action', array('value' => 'create'))?>
	</form>
	<div style="clear: both;"></div>
	<div id="cfsAbAddNewMsg"></div>
</div>
<!---->