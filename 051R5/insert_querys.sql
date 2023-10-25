CREATE TABLE IF NOT EXISTS `competitieschema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `speeldatum` datetime NOT NULL,
  `thuis_id` int(11) NOT NULL,
  `uit_id` int(11) NOT NULL,
  `score_thuis` int(11) NOT NULL DEFAULT '0',
  `score_uit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uit_id` (`uit_id`),
  KEY `thuis_id` (`thuis_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `schermnaam` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `login` (`id`, `user`, `pass`, `email`, `schermnaam`) VALUES
(1, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@demoland.nl', 'Demo-Gebruiker');

CREATE TABLE IF NOT EXISTS `voetbalteams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(255) NOT NULL,
  `plaats` varchar(255) NOT NULL,
  `speelsterkte` char(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `competitieschema`
  ADD CONSTRAINT `competitieschema_ibfk_3` FOREIGN KEY (`thuis_id`) REFERENCES `voetbalteams` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `competitieschema_ibfk_4` FOREIGN KEY (`uit_id`) REFERENCES `voetbalteams` (`id`) ON UPDATE CASCADE;
