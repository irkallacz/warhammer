-- Adminer 3.3.2 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` varchar(30) collate utf8_czech_ci NOT NULL,
  `number` tinyint(3) unsigned NOT NULL auto_increment,
  `warband_id` varchar(30) collate utf8_czech_ci NOT NULL,
  `max` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `number` (`number`),
  KEY `warband_id` (`warband_id`),
  CONSTRAINT `units_ibfk_1` FOREIGN KEY (`warband_id`) REFERENCES `warband` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `units` (`id`, `number`, `warband_id`, `max`) VALUES
('Battle pilgrim',	2,	'Bretonnia',	3),
('Big boss',	16,	'Orcs',	1),
('Boyzz',	18,	'Orcs',	6),
('Clanrat',	21,	'Skavens',	6),
('Corsair',	6,	'Dark elves',	6),
('Glade guard',	30,	'Wood elves',	6),
('Grave guard',	23,	'Vampire counts',	3),
('Henchmen',	11,	'Empire',	3),
('Chaos champion',	25,	'Warriors of chaos',	1),
('Chieftain',	19,	'Skavens',	1),
('Chosen',	26,	'Warriors of chaos',	3),
('Ironbreaker',	9,	'Dwarfs',	6),
('Khainite',	5,	'Dark elves',	3),
('Knight',	1,	'Bretonnia',	1),
('Marauder',	27,	'Warriors of chaos',	6),
('Master',	4,	'Dark elves',	1),
('Noble',	28,	'Wood elves',	1),
('Peasant',	3,	'Bretonnia',	6),
('Prince',	13,	'High elves',	1),
('Sea guard',	15,	'High elves',	6),
('Sigmar priest',	10,	'Empire',	1),
('Slayer',	8,	'Dwarfs',	3),
('State troop',	12,	'Empire',	6),
('Stormvermin',	20,	'Skavens',	3),
('Swordmaster',	14,	'High elves',	3),
('Thane',	7,	'Dwarfs',	1),
('Troll',	17,	'Orcs',	3),
('Vampire',	22,	'Vampire counts',	1),
('Wardancer',	29,	'Wood elves',	3),
('Zombie',	24,	'Vampire counts',	6);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nick` varchar(30) collate utf8_czech_ci NOT NULL,
  `mail` varchar(30) collate utf8_czech_ci default '',
  `password` varchar(32) collate utf8_czech_ci default NULL,
  `plaintext` varchar(32) collate utf8_czech_ci default NULL,
  `users_role_id` tinyint(1) unsigned NOT NULL default '0',
  `units_id` varchar(30) collate utf8_czech_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `users_role_id` (`users_role_id`),
  KEY `units_id_2` (`units_id`),
  CONSTRAINT `users_ibfk_3` FOREIGN KEY (`users_role_id`) REFERENCES `users_role` (`id`) ON DELETE CASCADE,
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`units_id`) REFERENCES `units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `users` (`id`, `nick`, `mail`, `password`, `plaintext`, `users_role_id`, `units_id`) VALUES
(1,	'Addie',	'addie@warhammer.cz',	'7345ba318ddb265c546c9240bba28df8',	'Addie',	1,	'Peasant'),
(2,	'Albertina',	'albertina@warhammer.cz',	'eec6650f23cc0b1c895586bd37240e99',	'Albertina',	1,	'Peasant'),
(3,	'Serena',	'serena@warhammer.cz',	'28fe9b600d2ab0df7c1f9bbe8b0d0955',	'Serena',	1,	'Peasant'),
(4,	'Su',	'su@warhammer.cz',	'f72c915d8f575a5c0999b5f37b6d99b7',	'Su',	1,	'Peasant'),
(5,	'Eduardo',	'eduardo@warhammer.cz',	'364a440226e1b575411a0e324e712d17',	'Eduardo',	1,	'Peasant'),
(6,	'Kyla',	'kyla@warhammer.cz',	'00aa3c48b6395fd1217016ef17851c56',	'Kyla',	1,	'Peasant'),
(7,	'Miguelina',	'miguelina@warhammer.cz',	'db28975d75fa148e44a8dcc71107bfae',	'Miguelina',	1,	'Battle pilgrim'),
(8,	'Sharee',	'sharee@warhammer.cz',	'86a7f8afdbbc2c8234451e6a9a4885be',	'Sharee',	1,	'Battle pilgrim'),
(9,	'Paulita',	'paulita@warhammer.cz',	'e3564dea1b59bb20d298d79865ed932e',	'Paulita',	1,	'Battle pilgrim'),
(10,	'Matthew',	'matthew@warhammer.cz',	'64730ca35ed9274ff6aa8a719407fe53',	'Matthew',	1,	'Corsair'),
(11,	'Lanora',	'lanora@warhammer.cz',	'58c429e40f31793e3b966721acc7e3d6',	'Lanora',	1,	'Corsair'),
(12,	'Darnell',	'darnell@warhammer.cz',	'8b17906dcb1e668552314d9e330a2e50',	'Darnell',	1,	'Corsair'),
(13,	'Madelaine',	'madelaine@warhammer.cz',	'53982537f27087c0c1df511a2e3c85e1',	'Madelaine',	1,	'Corsair'),
(14,	'Latoya',	'latoya@warhammer.cz',	'4f645261de9c8cb463675b6764952181',	'Latoya',	1,	'Corsair'),
(15,	'Junie',	'junie@warhammer.cz',	'3eee825e45841ff54723515310413803',	'Junie',	1,	'Corsair'),
(16,	'Alphonso',	'alphonso@warhammer.cz',	'c0e149b4c036d0da648b54c8f39deab8',	'Alphonso',	1,	'Khainite'),
(17,	'Meridith',	'meridith@warhammer.cz',	'035cf261db6461a89c35f94d142af11d',	'Meridith',	1,	'Khainite'),
(18,	'Rusty',	'rusty@warhammer.cz',	'fe0a7e0883b8de58adb5ed00009376a6',	'Rusty',	1,	'Khainite'),
(19,	'Corazon',	'corazon@warhammer.cz',	'6b96fbea552c8a6054bc668a47b34997',	'Corazon',	1,	'Ironbreaker'),
(20,	'Ninfa',	'ninfa@warhammer.cz',	'f7dd443fc545ed77db6793cfefd133fe',	'Ninfa',	1,	'Ironbreaker'),
(21,	'Jacquelyn',	'jacquelyn@warhammer.cz',	'1ff9aeb87500a704f2f206304618095e',	'Jacquelyn',	1,	'Ironbreaker'),
(22,	'Carley',	'carley@warhammer.cz',	'b4febb5902d692c8ea0f44b1830a7673',	'Carley',	1,	'Ironbreaker'),
(23,	'Rueben',	'rueben@warhammer.cz',	'5f96faf64ed4ca35e9f0e4ec71db0c58',	'Rueben',	1,	'Ironbreaker'),
(24,	'Deneen',	'deneen@warhammer.cz',	'75b8b986245d8cfb5416f9cb3ad2152c',	'Deneen',	1,	'Ironbreaker'),
(25,	'Maureen',	'maureen@warhammer.cz',	'f83cec7cff0604fac65017cf55c09f7e',	'Maureen',	1,	'Slayer'),
(26,	'Chantal',	'chantal@warhammer.cz',	'c2447a59b384c152b790c1fd32a6236f',	'Chantal',	1,	'Slayer'),
(27,	'Brunilda',	'brunilda@warhammer.cz',	'f740a5a25217775842b21ce11242d2e7',	'Brunilda',	1,	'Slayer'),
(28,	'Renda',	'renda@warhammer.cz',	'2e3528a7d44290c617a7acf0707a1e90',	'Renda',	1,	'State troop'),
(29,	'Alethea',	'alethea@warhammer.cz',	'863dc7c1bf9aaa703abedcee6073010e',	'Alethea',	1,	'State troop'),
(30,	'Pat',	'pat@warhammer.cz',	'532762fa5a5b7169aa4dd24717ba9df9',	'Pat',	1,	'State troop'),
(31,	'Ok',	'ok@warhammer.cz',	'a60852f204ed8028c1c58808b746d115',	'Ok',	1,	'State troop'),
(32,	'Alycia',	'alycia@warhammer.cz',	'3ca5c78266fd7e4c0bc063103a138008',	'Alycia',	1,	'State troop'),
(33,	'Elene',	'elene@warhammer.cz',	'73ebb6645f948c67726db9709706282c',	'Elene',	1,	'State troop'),
(34,	'Avis',	'avis@warhammer.cz',	'2f3d2d373d556e9b0b98e530b6d28d44',	'Avis',	1,	'Henchmen'),
(35,	'Mardell',	'mardell@warhammer.cz',	'7877180be32f475652b503a74f88e752',	'Mardell',	1,	'Henchmen'),
(36,	'Sibyl',	'sibyl@warhammer.cz',	'cba196fb53f7cac0bcb537359a232fc0',	'Sibyl',	1,	'Henchmen'),
(37,	'Rikki',	'rikki@warhammer.cz',	'e86e4104e3b9d29da206f223f62b60c4',	'Rikki',	1,	'Sea guard'),
(38,	'Refugio',	'refugio@warhammer.cz',	'9f3e1734f53a85ea5d20b16af72e5b2a',	'Refugio',	1,	'Sea guard'),
(39,	'Agustina',	'agustina@warhammer.cz',	'f773b4f894c9d8bb528980e365025d81',	'Agustina',	1,	'Sea guard'),
(40,	'Danyel',	'danyel@warhammer.cz',	'c6d6685fd5fb138b11d442614cc7e9b2',	'Danyel',	1,	'Sea guard'),
(41,	'Inez',	'inez@warhammer.cz',	'edd8f284fa72062509f199b7ee92379b',	'Inez',	1,	'Sea guard'),
(42,	'Michiko',	'michiko@warhammer.cz',	'7af8b6bcc3c02563e624c1e1f113fc8e',	'Michiko',	1,	'Sea guard'),
(43,	'Milford',	'milford@warhammer.cz',	'b29d5b5a62f3de0f2153482580e4c39e',	'Milford',	1,	'Swordmaster'),
(44,	'Dallas',	'dallas@warhammer.cz',	'09ea9b5e69df9e1385463fde29bc41cf',	'Dallas',	1,	'Swordmaster'),
(45,	'Goldie',	'goldie@warhammer.cz',	'1a7a2fa1308d664bde82056ded291104',	'Goldie',	1,	'Swordmaster'),
(46,	'Lorretta',	'lorretta@warhammer.cz',	'5a0cc3c7ccbb3b6072fd7a61864288ed',	'Lorretta',	1,	'Boyzz'),
(47,	'Shela',	'shela@warhammer.cz',	'c9bc6982ec4b2ca6805bfae52f8f2e11',	'Shela',	1,	'Boyzz'),
(48,	'Lan',	'lan@warhammer.cz',	'6add51ad5ca3f997df3a179e287c4114',	'Lan',	1,	'Boyzz'),
(49,	'Angla',	'angla@warhammer.cz',	'af63f5b382baf62345cc05cdce7cf214',	'Angla',	1,	'Boyzz'),
(50,	'Asuncion',	'asuncion@warhammer.cz',	'8410f16f69626640a58f6c75509b068b',	'Asuncion',	1,	'Boyzz'),
(51,	'Bambi',	'bambi@warhammer.cz',	'fdd6ae70af7bd2a46ea68d3d123a2e3e',	'Bambi',	1,	'Boyzz'),
(52,	'Harris',	'harris@warhammer.cz',	'd53a0abaa0cbeb339cb02898fa4fbe96',	'Harris',	1,	'Troll'),
(53,	'Marla',	'marla@warhammer.cz',	'f378065df603d4fd55227b27d3b17bc4',	'Marla',	1,	'Troll'),
(54,	'Ismael',	'ismael@warhammer.cz',	'c93734f252a1f5b0294e69d3a9a7ab8f',	'Ismael',	1,	'Troll'),
(55,	'Clair',	'clair@warhammer.cz',	'c7e206a03eb924b8cf6f15e8c70f1f07',	'Clair',	1,	'Clanrat'),
(56,	'Alice',	'alice@warhammer.cz',	'64489c85dc2fe0787b85cd87214b3810',	'Alice',	1,	'Clanrat'),
(57,	'Prudence',	'prudence@warhammer.cz',	'd1266baad53163a1d0f09054849144f3',	'Prudence',	1,	'Clanrat'),
(58,	'Queen',	'queen@warhammer.cz',	'2c2d2c0291163b077a372c2a9c5a6eda',	'Queen',	1,	'Clanrat'),
(59,	'Christie',	'christie@warhammer.cz',	'f3860a47ba2aa602debe65f10e01cf1a',	'Christie',	1,	'Clanrat'),
(60,	'Catrice',	'catrice@warhammer.cz',	'db607f413a5843a0eba858855f95bc3b',	'Catrice',	1,	'Clanrat'),
(61,	'Le',	'le@warhammer.cz',	'bccd5ec3ec8fd3a4471e71e9b407c60c',	'Le',	1,	'Stormvermin'),
(62,	'Dortha',	'dortha@warhammer.cz',	'2258ed2838d3f50c5c47c23e65265889',	'Dortha',	1,	'Stormvermin'),
(63,	'Kattie',	'kattie@warhammer.cz',	'f886895df4989bda8f6f2397bd2d4847',	'Kattie',	1,	'Stormvermin'),
(64,	'Elli',	'elli@warhammer.cz',	'0754534133f28d3e14d9cc3ede7d8953',	'Elli',	1,	'Zombie'),
(65,	'Alison',	'alison@warhammer.cz',	'9c0f0b59a4cb6d6c59f6002bf3892a28',	'Alison',	1,	'Zombie'),
(66,	'John',	'john@warhammer.cz',	'61409aa1fd47d4a5332de23cbf59a36f',	'John',	1,	'Zombie'),
(67,	'Jorge',	'jorge@warhammer.cz',	'f4a1c8901a3d406f17af67144a3ec71a',	'Jorge',	1,	'Zombie'),
(68,	'Chauncey',	'chauncey@warhammer.cz',	'873d237ff3888e9bbef7880bd1c2a5a8',	'Chauncey',	1,	'Zombie'),
(69,	'Cherie',	'cherie@warhammer.cz',	'6a8ace7dcf47dae3ec5b04e41deb2460',	'Cherie',	1,	'Zombie'),
(70,	'Taunya',	'taunya@warhammer.cz',	'03778b1c9108285bf9ea59baacaa8530',	'Taunya',	1,	'Grave guard'),
(71,	'Kristie',	'kristie@warhammer.cz',	'a5214bb59dd56c15c19a74c72ed4fd13',	'Kristie',	1,	'Grave guard'),
(72,	'Kathryn',	'kathryn@warhammer.cz',	'0530b9b6a12155e2a3c969bf89777aef',	'Kathryn',	1,	'Grave guard'),
(73,	'Glendora',	'glendora@warhammer.cz',	'1f304d41df9d8f72ab21b43664d4128b',	'Glendora',	1,	'Marauder'),
(74,	'Kristyn',	'kristyn@warhammer.cz',	'fa4d1a9d981a142c12c542efa1993cbf',	'Kristyn',	1,	'Marauder'),
(75,	'Dodie',	'dodie@warhammer.cz',	'5223123c3bf120e8a9c6d1ec463a655d',	'Dodie',	1,	'Marauder'),
(76,	'Sally',	'sally@warhammer.cz',	'3fa8b9cc38915ca488e412b59a8aaa79',	'Sally',	1,	'Marauder'),
(77,	'Edna',	'edna@warhammer.cz',	'1e3aad34d6af5142448d07e2617020d7',	'Edna',	1,	'Marauder'),
(78,	'Bryan',	'bryan@warhammer.cz',	'd7ed9d7159a4ee762f8b8fbd646efe9e',	'Bryan',	1,	'Marauder'),
(79,	'Missy',	'missy@warhammer.cz',	'de5af76958079097acd98cab32669077',	'Missy',	1,	'Chosen'),
(80,	'Solange',	'solange@warhammer.cz',	'09edc1c4a93fc5e82a6ba73253e2e82a',	'Solange',	1,	'Chosen'),
(81,	'Dustin',	'dustin@warhammer.cz',	'7e3fceb10594a451e0741d4c536646fb',	'Dustin',	1,	'Chosen'),
(82,	'Margert',	'margert@warhammer.cz',	'ce677d59dec751dc1bf672a0c7040275',	'Margert',	1,	'Glade guard'),
(83,	'Kary',	'kary@warhammer.cz',	'55bd6e115d53b2eb47652627f3ddc0d5',	'Kary',	1,	'Glade guard'),
(84,	'Heike',	'heike@warhammer.cz',	'47f910927f40315c30bdf77c78ea74cb',	'Heike',	1,	'Glade guard'),
(85,	'Donnetta',	'donnetta@warhammer.cz',	'50160f344b4de0534c5730c244941b5a',	'Donnetta',	1,	'Glade guard'),
(86,	'Marcell',	'marcell@warhammer.cz',	'3b807bd0b0b0afaa0d9c2b6d64f17eec',	'Marcell',	1,	'Glade guard'),
(87,	'Hyo',	'hyo@warhammer.cz',	'c67553d82d4bc0cfe5e0ce3385e2aa3e',	'Hyo',	1,	'Glade guard'),
(88,	'Shila',	'shila@warhammer.cz',	'cf87a3cd632f75949311893ea87ddb2c',	'Shila',	1,	'Wardancer'),
(89,	'Contessa',	'contessa@warhammer.cz',	'bac1f9a92750ae66face4c69a4dfdf46',	'Contessa',	1,	'Wardancer'),
(90,	'Kimberley',	'kimberley@warhammer.cz',	'a81ab170e4dba2c0cc7b7279b1d767e9',	'Kimberley',	1,	'Wardancer'),
(91,	'Admin',	'admin@warhammer.cz',	'e3afed0047b08059d0fada10f400c1e5',	'Admin',	3,	NULL),
(92,	'Michael',	'michael@warhammer.cz',	'3e06fa3927cbdf4e9d93ba4541acce86',	'Michael',	2,	'Chaos champion'),
(93,	'Resli',	'resli@warhammer.cz',	'cfeaf6e28bfcd0c44357e1e65af3f127',	'Resli',	2,	'Prince'),
(94,	'David',	'david@warhammer.cz',	'464e07afc9e46359fb480839150595c5',	'David',	2,	'Noble'),
(95,	'Aridion',	'aridion@warhammer.cz',	'6126493b2daee926befa69136a43c5dd',	'Aridion',	2,	'Thane'),
(96,	'Loner',	'loner@warhammer.cz',	'03b1eceee5360b754a5c919991ce2952',	'Loner',	2,	'Chieftain'),
(97,	'Blizzy',	'blizzy@warhammer.cz',	'd41de5a3ede81d7bed6929a051c23a08',	'Blizzy',	2,	'Sigmar priest'),
(98,	'Arnold',	'arnold@warhammer.cz',	'd24d17e38303040df00c574b151b424a',	'Arnold',	2,	'Knight'),
(99,	'Tomen',	'tomen@warhammer.cz',	'f1068186c82ac70beb9d6d38c6a74508',	'Tomen',	2,	'Master'),
(100,	'Palda',	'palda@warhammer.cz',	'8cf6ddb065ccdfd03ba1346a598df468',	'Palda',	2,	'Big boss'),
(101,	'Karen',	'karen@warhammer.cz',	'7e014d9f08b5ea887eae96e5871d4b6b',	'Karen',	2,	'Vampire');

DROP TABLE IF EXISTS `users_role`;
CREATE TABLE `users_role` (
  `id` tinyint(1) unsigned NOT NULL,
  `role` varchar(30) collate utf8_czech_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `users_role` (`id`, `role`) VALUES
(0,	'visitor'),
(1,	'user'),
(2,	'superuser'),
(3,	'admin');

DROP TABLE IF EXISTS `warband`;
CREATE TABLE `warband` (
  `id` varchar(30) collate utf8_czech_ci NOT NULL,
  `side` varchar(12) collate utf8_czech_ci NOT NULL,
  `points` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `warband` (`id`, `side`, `points`) VALUES
('Bretonnia',	'Order',	1000),
('Dark elves',	'Destruction',	1000),
('Dwarfs',	'Order',	1000),
('Empire',	'Order',	1000),
('High elves',	'Order',	1000),
('Orcs',	'Destruction',	1000),
('Skavens',	'Destruction',	1000),
('Vampire counts',	'Destruction',	1000),
('Warriors of chaos',	'Destruction',	1000),
('Wood elves',	'Order',	1000);

DROP TABLE IF EXISTS `wargear`;
CREATE TABLE `wargear` (
  `users_id` int(10) unsigned NOT NULL,
  `warband_id` varchar(30) collate utf8_czech_ci NOT NULL,
  `name` varchar(30) collate utf8_czech_ci NOT NULL,
  `points` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`users_id`,`name`),
  KEY `users_id` (`users_id`),
  KEY `warband_id` (`warband_id`),
  CONSTRAINT `wargear_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  CONSTRAINT `wargear_ibfk_2` FOREIGN KEY (`warband_id`) REFERENCES `warband` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


-- 2013-04-05 00:38:25
