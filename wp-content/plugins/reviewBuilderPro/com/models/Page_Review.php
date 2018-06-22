<?php

global $sgrb;
$sgrb->includeModel('Model');
$sgrb->includeModel('Review');

class SGRB_Page_ReviewModel extends SGRB_Model
{
	const TABLE = 'page_review';
	protected $id;
	protected $category_id;
	protected $product_id;
	protected $review_id;

	public static function finder($class = __CLASS__)
	{
		return parent::finder($class);
	}

	public static function create()
	{
		global $sgrb;
		global $wpdb;
		$tablename = $sgrb->tablename(self::TABLE);
		$reviewTable = SGRB_ReviewModel::TABLE;
		$reviewTable = $wpdb->dbname.'.'.$wpdb->prefix.$sgrb->prefix.$reviewTable;

		$query = "CREATE TABLE IF NOT EXISTS $tablename (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `category_id` int(10) unsigned NULL,
					  `product_id` INT(10) unsigned NULL,
					  `review_id` INT(10) unsigned NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
		$query2 = "ALTER TABLE $tablename ADD INDEX(`review_id`);";
		$query3 = "ALTER TABLE $tablename ADD FOREIGN KEY (`review_id`)
					REFERENCES $reviewTable (`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
		$wpdb->query($query);
		$wpdb->query($query2);
		$wpdb->query($query3);
	}

	public static function drop()
	{
		global $sgrb;
		global $wpdb;
		$tablename = $sgrb->tablename(self::TABLE);
		$query = "DROP TABLE $tablename";
		$wpdb->query($query);
	}
}
