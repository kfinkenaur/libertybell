<?php 
class add_fieldsViewCfs extends viewCfs {
	public function getRatingStatsTab( $form ) {
		frameCfs::_()->addScript('add_fields.rating.admin', $this->getModule()->getModPath(). 'js/add_fields.rating.admin.js');
		// Total stats
		$group = reqCfs::getVar('cfsChartGroup_cfsRatingStats', 'cookie');
		// Get stats only for default engine for now
		$stats = $this->getModel('rating')->getStatsForFormSorted($form['id'], array('group' => $group));
		if(!empty($stats)) {
			frameCfs::_()->addJSVar('add_fields.rating.admin', 'cfsRatingStats', $stats);
		}
		return parent::getContent('ratingStatsTab');
	}
}