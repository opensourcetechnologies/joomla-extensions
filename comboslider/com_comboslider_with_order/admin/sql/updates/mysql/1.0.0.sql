CREATE TABLE `#__comboslider` (
  `id` int(11) NOT NULL auto_increment,
  `greeting` varchar(25) NOT NULL,
 `article` int(11) NOT NULL,
 `category` int(11) NOT NULL,
 `edcontent` text NOT NULL,
 `type` varchar(255) NOT NULL,
 `layout` varchar(255) NOT NULL,
 `ordering` int(11) NOT NULL,
  `published` enum('0','1') NOT NULL DEFAULT '0',
  `rantime` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__comboslider_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
