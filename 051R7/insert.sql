CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `schermnaam` varchar(50) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT '1',
  `regdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `login` (`id`, `user`, `pass`, `email`, `schermnaam`, `rank`, `regdate`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '<uw emailadres>', 'Administrator', 2, '0000-00-00 00:00:00'),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', '<uw emailadres>', 'Demo-Gebruiker', 1, '0000-00-00 00:00:00');

CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `datetime` datetime NOT NULL,
  `edit_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
