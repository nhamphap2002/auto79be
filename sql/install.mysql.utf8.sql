CREATE TABLE IF NOT EXISTS `#__auto79_link` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`link` VARCHAR(255)  NOT NULL ,
`title` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__auto79_cron` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`link` TEXT NOT NULL ,
`adcategories` TEXT NOT NULL ,
`pageto` DOUBLE,
`pagefrom` DOUBLE,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `t2_auto79_linkpost` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `link` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `province` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `approval` int(11) NOT NULL,
  `timeapproval` int(11) NOT NULL,
  `hasget` int(11) NOT NULL,
  `hasapproval` int(11) NOT NULL,
  `time_created` datetime NOT NULL,
  `cronid` int(11) NOT NULL
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `#__auto79_articles` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`link` TEXT NOT NULL ,
`category_id` TEXT NOT NULL ,
`province` TEXT NOT NULL ,
`approval` INT NOT NULL ,
`timeapproval` DATETIME NOT NULL ,
`hasget` INT NOT NULL ,
`hasapproval` INT NOT NULL ,
`time_created` DATETIME NOT NULL ,
`cronid` INT NOT NULL ,
`postid` INT NOT NULL ,
`user_approval` INT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `#__auto79_element` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`title` VARCHAR(255)  NOT NULL ,
`numpage` VARCHAR(255)  NOT NULL ,
`cateloopli` VARCHAR(255)  NOT NULL ,
`postlink` VARCHAR(255)  NOT NULL ,
`titlepost` VARCHAR(255)  NOT NULL ,
`postloopli` VARCHAR(255)  NOT NULL ,
`postimg` VARCHAR(255)  NOT NULL ,
`postcontent` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;


