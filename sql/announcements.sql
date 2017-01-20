--
-- Štruktúra tabuľky pre tabuľku `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_hash` varchar(40) COLLATE utf8_slovak_ci NOT NULL,
  `a_message` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `a_date` datetime NOT NULL,
  `a_type` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`a_id`),
  UNIQUE KEY `a_hash` (`a_hash`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=1530 ;

