CREATE TABLE IF NOT EXISTS `tt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `project` varchar(1000) NOT NULL,
  `task` varchar(1000) DEFAULT NULL,
  `startstop` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=179 ;
