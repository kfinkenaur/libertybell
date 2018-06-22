<?php /*Rating stats*/ ?>
<div class="cfsChartShell" data-chart="cfsRatingStats">
	<span class="cfsOptLabel">
		<?php _e('Rating Statistics', CFS_LANG_CODE)?>
		<div style="float: right;">
			<a href="#" class="button cfsStatClearDateBtn" data-chart="cfsRatingStats" style="display: none;"><?php _e('Clear selection', CFS_LANG_CODE)?></a>
			<?php echo htmlCfs::text('stat_from_txt', array(
				'placeholder' => __('From', CFS_LANG_CODE), 
				'attrs' => 'style="font-weight: normal;" data-chart="cfsRatingStats"'))?>
			<?php echo htmlCfs::text('stat_to_txt', array(
				'placeholder' => __('To', CFS_LANG_CODE), 
				'attrs' => 'style="font-weight: normal;" data-chart="cfsRatingStats"'))?>
		</div>
	</span>
	<hr />
	<div style="clear: both;"></div>
	<div style="float: left;">
		<a href="#" class="button cfsStatChartTypeBtn" data-type="line" data-chart="cfsRatingStats">
			<i class="fa fa-line-chart"></i>
		</a>
		<a href="#" class="button cfsStatChartTypeBtn" data-type="bar" data-chart="cfsRatingStats">
			<i class="fa fa-bar-chart"></i>
		</a>
		<a href="#" class="button ppsFormStatGraphZoomReset" style="display: none;">
			<i class="fa fa-undo"></i>
			<?php _e('Reset Zoom', CFS_LANG_CODE)?>
		</a>
	</div>
	<div style="float: right;">
		<span style="line-height: 30px;">
			<?php _e('Group by', CFS_LANG_CODE)?>:
			<a href="#" class="button cfsStatChartGroupBtn" data-stat-group="hour" data-chart="cfsRatingStats"><?php _e('Hour', CFS_LANG_CODE)?></a>
			<a href="#" class="button cfsStatChartGroupBtn" data-stat-group="day" data-chart="cfsRatingStats"><?php _e('Day', CFS_LANG_CODE)?></a>
			<a href="#" class="button cfsStatChartGroupBtn" data-stat-group="week" data-chart="cfsRatingStats"><?php _e('Week', CFS_LANG_CODE)?></a>
			<a href="#" class="button cfsStatChartGroupBtn" data-stat-group="month" data-chart="cfsRatingStats"><?php _e('Month', CFS_LANG_CODE)?></a>
			<?php /*?>|
			<a href="<?php echo uriCfs::mod('statistics', 'getCsv')?>" target="_blank" class="button cfsStatExportCsv" data-chart="cfsRatingStats"><?php _e('Export to CSV', CFS_LANG_CODE)?></a>
			|<?php */?>
		</span>
		<?php /*?><a href="#" id="cfsStatClear" class="button">
			<i class="fa fa-trash"></i>
			<?php _e('Clear data', CFS_LANG_CODE)?>
		</a><?php */?>
	</div>
	<div style="clear: both;"></div>
	<div id="cfsRatingStats" class="cfsChartArea"></div>
</div>
<div class="cfsNoStatsMsg" data-chart="cfsRatingStats">
	<?php _e('Rating Statistics is empty for now.', CFS_LANG_CODE)?>
	<p class="description"><?php _e('Create your first Rating field in your Form, and after users start submit it - you will seee stats here.', CFS_LANG_CODE)?></p>
</div>