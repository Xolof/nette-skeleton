CREATE TABLE `posts` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`title` varchar(255) NOT NULL,
	`content` text NOT NULL,
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARSET=utf8;

INSERT INTO `posts` (`id`, `title`, `content`, `created_at`) VALUES
(1,	'Article One',	'Lorem ipusm dolor one',	CURRENT_TIMESTAMP),
(2,	'Article Two',	'Lorem ipsum dolor two',	CURRENT_TIMESTAMP),
(3,	'Article Three',	'Lorem ipsum dolor three',	CURRENT_TIMESTAMP);

