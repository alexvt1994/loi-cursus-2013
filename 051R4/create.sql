CREATE TABLE IF NOT EXISTS `gastenboek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(50) NOT NULL,
  `boodschap` text NOT NULL,
  `datum` datetime NOT NULL,
  `sport` varchar(30) NOT NULL,
  `beoefenaar` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;