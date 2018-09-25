<?php $createdb[] .= "
CREATE TABLE`". $tblpre ."users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `steamid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `salt` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'english',
  `admin` int(1) NOT NULL DEFAULT '0',
  `suspended` int(1) NOT NULL DEFAULT '0',
  `verified` int(1) NOT NULL DEFAULT '0',
  `verifypend` int(1) NOT NULL DEFAULT '0',
  `regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `donator` int(1) NOT NULL DEFAULT '0',
  `lastlogged` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `private` int(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passwordReset` int(1) NOT NULL DEFAULT '0',
  `passwordKey` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `ipaddress` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$createdb[] .= "
CREATE TABLE`". $tblpre ."settings` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."blog_post` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."connections` (
  `SID` varchar(100) NOT NULL,
  `ip` varchar(450) DEFAULT NULL,
  `prevsite` varchar(450) DEFAULT NULL,
  `LogoUrl` varchar(450) DEFAULT NULL,
  `SphubPre` varchar(450) DEFAULT NULL,
  `LON` varchar(450) DEFAULT '0',
  `SphubCK` varchar(450) DEFAULT NULL,
  `LogAttempts` varchar(450) DEFAULT '0',
  `AccountID` varchar(450) DEFAULT NULL,
  `SAML` varchar(1200) DEFAULT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."custom_pages` (
  `content` text NOT NULL,
  `name` varchar(100) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."lang` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `lang_short` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lang_title` varchar(255) NOT NULL,
  `lang_default` tinyint(1) unsigned NOT NULL,
  `lang_enabled` bit(1) NOT NULL DEFAULT b'1',
  UNIQUE KEY `identifier` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
INSERT INTO `". $tblpre ."lang` VALUES (1,'en_US','English',1,1);
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."lang_words` (
  `word_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UID',
  `lang_id` varchar(50) NOT NULL COMMENT 'The name for the language',
  `word_module` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'The Module key, if word belongs to an Module',
  `word_key` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The Key',
  `word_default` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'The Default Value',
  `word_custom` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'the Current Value',
  PRIMARY KEY (`word_id`),
  UNIQUE KEY `word_id` (`word_id`)
) ENGINE=InnoDB AUTO_INCREMENT=422 DEFAULT CHARSET=utf8;
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."login_handlers` (
  `login_key` varchar(50) NOT NULL,
  `login_enabled` int(1) NOT NULL,
  PRIMARY KEY (`login_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `". $tblpre ."login_handlers` VALUES ('Internal',1),('Steam',1);
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."marketplace` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `class` varchar(100) NOT NULL,
  `price` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `seller` int(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `server` int(2) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `buyer` varchar(100) DEFAULT NULL,
  `posted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bought` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."modules` (
  `module_id` int(50) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) NOT NULL,
  `module_key` varchar(50) NOT NULL,
  `module_enabled` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `". $tblpre ."modules` VALUES (1,'Core','core',1),(2,'Garage','mygarage',1),(3,'Inventory','inventory',1),(4,'Marketplace','marketplace',1),(5,'Territories','territories',1),(6,'Announcements','announcements',1),(7,'Blog','blog',1),(8,'Exile Server','exileserver',1),(9,'Pages','pages',1),(10,'admin CP','admincp',1);
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."pages` (
  `page` varchar(25) NOT NULL,
  `rlog` int(1) NOT NULL DEFAULT '0',
  `radmin` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."private_messages` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `sentto` int(4) NOT NULL,
  `sentby` int(4) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `message` varchar(5000) NOT NULL,
  `status` int(1) DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."rcon_log` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `script` varchar(1000) NOT NULL,
  `timestamp` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."serverannouncements` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."sessions` (
  `sid` varchar(100) NOT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `accountid` varchar(100) DEFAULT NULL,
  `loginattempts` int(2) DEFAULT NULL,
  `lastupdated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."site_images` (
  `name` varchar(250) NOT NULL,
  `location` varchar(250) NOT NULL,
  `func` varchar(250) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `". $tblpre ."site_images` VALUES ('Welcome','images/custom/slide-1.png','front_carousel',1,'Welcome to A3EP your A3EP Install'),('Place Holder','images/custom/slide-2.png','front_carousel',2,'hello'),('Background','images/custom/bg.png','background',3,'Background'),('Logo','images/custom/A3Exile.png','header_logo',4,'');
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."user_permissions` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `p_offline_access` int(1) NOT NULL DEFAULT '0',
  `garage_access` int(1) NOT NULL DEFAULT '1',
  `manage_garage` int(1) NOT NULL DEFAULT '0',
  `garage_lock_vehicle` int(1) NOT NULL DEFAULT '1',
  `garage_change_pin` int(1) NOT NULL DEFAULT '1',
  `inventory_access` int(1) NOT NULL DEFAULT '1',
  `manage_inventory` int(1) NOT NULL DEFAULT '0',
  `territory_access` int(1) NOT NULL DEFAULT '1',
  `manage_territory` int(1) NOT NULL DEFAULT '0',
  `blog_access` int(1) NOT NULL DEFAULT '1',
  `leaderboard_access` int(1) NOT NULL DEFAULT '1',
  `contact_access` int(1) NOT NULL DEFAULT '1',
  `pm_access` int(1) NOT NULL DEFAULT '1',
  `pm_send` int(1) NOT NULL DEFAULT '1',
  `manage_blog` int(1) NOT NULL DEFAULT '0',
  `add_blog_post` int(1) NOT NULL DEFAULT '0',
  `announcement_access` int(1) NOT NULL DEFAULT '1',
  `manage_announcement` int(1) NOT NULL DEFAULT '0',
  `add_announcement` int(1) NOT NULL DEFAULT '0',
  `view_security_center` int(1) NOT NULL DEFAULT '0',
  `view_enhancements` int(1) NOT NULL DEFAULT '0',
  `view_general_config` int(1) NOT NULL DEFAULT '0',
  `view_lkey` int(1) NOT NULL DEFAULT '0',
  `create_member` int(1) NOT NULL DEFAULT '0',
  `edit_member` int(1) NOT NULL DEFAULT '0',
  `edit_admin` int(1) NOT NULL DEFAULT '0',
  `delete_member` int(1) NOT NULL DEFAULT '0',
  `delete_admin` int(1) NOT NULL DEFAULT '0',
  `suspend_member` int(1) NOT NULL DEFAULT '0',
  `validate_member` int(1) NOT NULL DEFAULT '0',
  `registration_settings` int(1) NOT NULL DEFAULT '0',
  `spam_settings` int(1) NOT NULL DEFAULT '0',
  `addon_settings` int(1) NOT NULL DEFAULT '0',
  `addon_console` int(1) NOT NULL DEFAULT '0',
  `manage_images` int(1) NOT NULL DEFAULT '0',
  `view_login_handlers` int(1) NOT NULL DEFAULT '0',
  `marketplace_access` int(1) NOT NULL DEFAULT '1',
  `support` INT( 1 ) NOT NULL DEFAULT  '0',
  `submit_support` INT( 1 ) NOT NULL DEFAULT  '0',
  UNIQUE KEY `userid` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
$createdb[] .= "
CREATE TABLE`". $tblpre ."items` (
  `class` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `url` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
"; ?>
