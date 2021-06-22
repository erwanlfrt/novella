DROP TABLE IF EXISTS `Vote`;
CREATE TABLE IF NOT EXISTS `Vote` (
  `competition` INT(11) NOT NULL,
  `userMail` VARCHAR(50) NOT NULL,
  `idNovella` bigint(20) UNSIGNED NOT NULL,
  `points` INT(11) NOT NULL,
  `prejury` BOOLEAN NOT NULL,
  PRIMARY KEY (`competition`,`userMail`,`idNovella`, `prejury`),
  KEY `fk_vote_jury` (`competition`,`userMail`),
  KEY `fk_vote_novella` (`idNovella`)
);