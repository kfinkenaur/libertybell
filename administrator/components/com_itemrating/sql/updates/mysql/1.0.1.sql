
CREATE TABLE IF NOT EXISTS `#__itemrating_context` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `context` varchar(255) NOT NULL,
  `context_id` int(11) NOT NULL,
  `group_id` int(10) NOT NULL,
  `textscore` varchar(255) NOT NULL,
    `summary` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;