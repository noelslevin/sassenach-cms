DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `parent` varchar(30) NOT NULL default '' COMMENT 'The parent category, if this is a subcategory',
  `type` enum('post','link') NOT NULL default 'post',
  `url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `url` (`url`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `categories` (`id`, `name`, `parent`, `type`, `url`) VALUES
(1, 'General', 'Yes', 'post', 'general'),
(2, 'General Links', 'Yes', 'link', 'general-links');

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `email` varchar(40) NOT NULL default '',
  `website` varchar(50) default NULL,
  `status` enum('approved','unapproved') NOT NULL default 'unapproved',
  `post_id` mediumint(8) NOT NULL default '0',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `comment` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` mediumint(9) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `filesize` varchar(10) NOT NULL default '',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links` (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `description` varchar(64) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `category` mediumint(8) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `links` (`id`, `name`, `description`, `link`, `category`) VALUES
(1, 'Sassenach CMS', 'This website runs on Sassenach CMS!', 'http://www.sassenach-cms.org', 2);

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `id` mediumint(8) NOT NULL auto_increment,
  `variable` varchar(30) NOT NULL default '',
  `value` varchar(100) NOT NULL default '',
  `function` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `variable` (`variable`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

INSERT INTO `options` (`id`, `variable`, `value`, `function`) VALUES
(1, 'globalhome', '', 'This is the home page for the main site.'),
(2, 'mysqlconnect', 'includes/connection.php', 'This is the path to the MySQL database connection.'),
(3, 'sitename', '', 'The name of the website, to appear in the title bar.'),
(4, 'globalrss', 'rss.xml', 'The location of the site''s main RSS file.'),
(5, 'backend', 'backend/', 'The location of the backend admin pages.'),
(6, 'write', 'write/', 'The location of the ''write'' backend pages.'),
(7, 'manage', 'edit/', 'The location of the ''manage'' admin pages.'),
(8, 'links', 'links/', 'The location of the ''links'' admin pages.'),
(9, 'users', 'users/', 'The location of the ''users'' admin pages.'),
(10, 'options', 'options/', 'The layout of the ''options'' admin pages (like this one!).'),
(11, 'comments', 'comments/', 'The location of the ''comments'' admin pages.'),
(12, 'help', 'documentation/', 'The location of the admin documentation and general help.'),
(13, 'logout', 'logout.php', 'The location of the logout script for the backend.'),
(14, 'style', 'sassenach/', 'The active administration theme.'),
(15, 'files', 'files/', 'The location of the ''files'' admin pages.'),
(16, 'uploads', 'uploads/', 'The location of the uploads directory, relative to the root installation of the software.'),
(17, 'global', '/', 'This is the global home, relative to the root public directory.'),
(18, 'todo', 'todo/', 'The location of the task list for administrators.'),
(19, 'categorybase', 'category/', 'This is the base url, relative to the $globalhome variable, for the category archives. If left undefined, it will clash with page urls, unless page urls are altered.'),
(20, 'status', 'down/', 'This determines whether the site is enabled or disabled. If status is set to ''up'', it is enabled, but for any other value, it is disabled.'),
(21, 'offline', '<h1>Down For Maintenance</h1>\n\n<p>The site is currently down whilst an upgrade is installed.</p>', 'This is the message that is shown to people when the website is offline for upgrades and maintenance.'),
(22, 'comment_status', 'on', 'This determines whether comments can be left and seen on the website.');

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` mediumint(8) NOT NULL auto_increment,
  `title` text NOT NULL,
  `url` varchar(100) NOT NULL default '',
  `author` mediumint(8) NOT NULL default '0',
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NULL default '0000-00-00 00:00:00',
  `status` enum('draft','published') NOT NULL default 'draft',
  `parent` mediumint(8) NOT NULL default '0',
  `content` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` mediumint(8) unsigned NOT NULL auto_increment,
  `author` mediumint(8) NOT NULL default '0',
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime default NULL,
  `categories` varchar(255) NOT NULL default '1' COMMENT 'Each number refers to the relevant category id in the ''categories'' table.',
  `status` enum('draft','published') NOT NULL default 'draft',
  `frontpage` enum('yes','no') NOT NULL default 'yes',
  `url` varchar(100) NOT NULL default '',
  `title` text NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `todo`;
CREATE TABLE IF NOT EXISTS `todo` (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `description` longtext NOT NULL,
  `status` enum('Implemented','In Progress','Stalled') NOT NULL default 'Implemented',
  `importance` enum('5','4','3','2','1') NOT NULL default '5',
  `author` mediumint(8) NOT NULL,
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NULL,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` mediumint(8) unsigned NOT NULL auto_increment,
  `firstname` varchar(20) NOT NULL default '',
  `lastname` varchar(20) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `email` varchar(40) NOT NULL default '',
  `registered` datetime NOT NULL default '0000-00-00 00:00:00',
  `string` char(32) NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
