jQuery(document).bind('cfsAfterAdminStatsInit', function(){
	// Main charts
	if(typeof(cfsRatingStats) !== 'undefined' && cfsRatingStats.length) {
		cfsDrawChart( cfsRatingStats, 'cfsRatingStats' );
	} else {
		_cfsSwitchToNoStats('cfsRatingStats');
	}
});