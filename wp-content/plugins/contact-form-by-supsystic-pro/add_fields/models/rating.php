<?php
class ratingModelCfs extends modelCfs {
	public function __construct() {
		$this->_setTbl('forms_rating');
	}
	protected function _afterGetFromTbl($row) {
		if(isset($row['rate'])) {
			$row['rate'] = (int) $row['rate'];
		}
		if(isset($row['max_rate'])) {
			$row['max_rate'] = (int) $row['max_rate'];
		}
		return $row;
	}
	public function getSimpleList($where = array(), $params = array()) {
		if($where)
			$this->setWhere ($where);
		return $this->setSelectFields('*')->getFromTbl( $params );
	}
	public function setSimpleGetFields() {
		$this->setSelectFields('*');
		return parent::setSimpleGetFields();
	}
	public function getStatsForFormSorted($id, $params = array()) {
		$allTypes = array(
			'total' => array('id' => 1, 'label' => __('Total', CFS_LANG_CODE)),
		);
		$allStats = array();
		$haveData = false;
		$i = 0;
		foreach($allTypes as $typeCode => $type) {
			$params['type'] = $type['id'];
			$allStats[ $i ] = $type;
			$allStats[ $i ]['code'] = $typeCode;
			$allStats[ $i ]['points'] = $this->getStatsForForm($id, $params);
			if(!empty($allStats[ $i ]['points'])) {
				$haveData = true;
			}
			$i++;
		}
		$allStats = dispatcherCfs::applyFilters('formStatsSorted', $allStats, $id, $params);
		return $haveData ? $allStats : false;
	}
	public function getStatsForForm($formId, $params = array()) {
		$where = array('fid' => $formId);
		$group = isset($params['group']) ? $params['group'] : 'day';
		$sqlDateFormat = '';
		switch($group) {
			case 'hour':
				$sqlDateFormat = 'DATE_FORMAT(date_created, "%m-%d-%Y %H:00")';
				break;
			case 'week':
				$sqlDateFormat = 'DATE_FORMAT(DATE_SUB(date_created, INTERVAL DAYOFWEEK(date_created)-1 DAY), "%m-%d-%Y")';
				break;
			case 'month':
				$sqlDateFormat = 'DATE_FORMAT(date_created, "%m-01-%Y")';
				break;
			case 'day':
			default:
				$sqlDateFormat = 'DATE_FORMAT(date_created, "%m-%d-%Y")';
				break;
		}
		return $this->setSelectFields('(SUM(rate) / COUNT(*)) AS total_requests, '. $sqlDateFormat. ' AS date')
				->groupBy('date')
				->setOrderBy('date')
				->setSortOrder('DESC')
				->setWhere($where)
				->getFromTbl();
	}
}