CREATE TABLE IF NOT EXISTS `#__itemrating_item` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`title` VARCHAR(255)  NOT NULL ,
`rating` VARCHAR(255)  NOT NULL ,
`label` VARCHAR(255)  NOT NULL ,
`group_id` VARCHAR(255)  NOT NULL ,
`type` VARCHAR(255)  NOT NULL ,
`icon` VARCHAR(255)  NOT NULL ,
`number` INT(11)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`hits` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__itemrating_group` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`title` VARCHAR(255)  NOT NULL ,
`display` VARCHAR(255)  NOT NULL ,
`textforscore` VARCHAR(255)  NOT NULL ,
`reviewsummary` TEXT NOT NULL ,
`styling` TEXT NOT NULL ,
`customcss` TEXT NOT NULL ,
`position` VARCHAR(255) NOT NULL,
`customcategory` TEXT NOT NULL,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__itemrating_itemdata` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `context` varchar(255) NOT NULL,
  `context_id` int(11) NOT NULL,
  `rating_id` int(10) NOT NULL,
  `rating_sum` int(10) NOT NULL,
  `rating_count` VARCHAR(255) NOT NULL,
  `jsondata` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__itemrating_context` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `context` varchar(255) NOT NULL,
  `context_id` int(11) NOT NULL,
  `group_id` int(10) NOT NULL,
  `textscore` varchar(255) NOT NULL,
    `summary` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;