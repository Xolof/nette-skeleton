DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS posts;

CREATE TABLE `posts` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`title` varchar(255) NOT NULL,
	`content` text NOT NULL,
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARSET=utf8;

INSERT INTO `posts` (`id`, `title`, `content`, `created_at`) VALUES
(1,	"Nette PHP Framework: Productivity and Best Practices at Its Core",	"Nette is a powerful PHP framework designed for developers who value efficiency and clean code. Rated the third most popular PHP framework in a 2015 SitePoint survey, Nette emphasizes productivity, best practices, and a delightful coding experience. Built as a collection of mature, standalone components, it supports PHP 8 and enables rapid development of scalable web applications. Its object-oriented design leverages modern PHP features, promoting extensibility and maintainability. Developers can use Nette\'s components independently, even alongside other frameworks like WordPress, making it highly versatile. With a vibrant community and comprehensive documentation (fully available in Czech and English), Nette fosters collaboration and learning. Whether you\'re crafting a small project or a complex application, Nette\'s focus on DRY (Don\'t Repeat Yourself) and KISS (Keep It Simple, Stupid) principles ensures cleaner, faster, and more enjoyable development.",	CURRENT_TIMESTAMP),
(2,	"Uncompromising Security with Nette PHP Framework",	"Security is Nette\'s hallmark, earning it a reputation as one of the safest PHP frameworks. Engineered to eliminate common vulnerabilities like XSS (Cross-Site Scripting) and CSRF (Cross-Site Request Forgery), Nette has passed multiple security audits with flying colors. Its innovative Context-Aware Escaping technology automatically secures template outputs, reducing the risk of oversight by developers. Nette\'s robust routing system and built-in protections against session hijacking further fortify applications. The framework\'s Tracy debugging tool enhances security by providing detailed error logging and diagnostics, helping developers catch issues early. With a philosophy prioritizing secure coding practices, Nette empowers developers to build applications that are not only functional but also resilient against attacks. For businesses and developers prioritizing trust and safety, Nette\'s proactive security measures make it a top choice for modern web development.",	CURRENT_TIMESTAMP),
(3,	"Latte: Nette\'s Intuitive and Secure Templating Engine",	"Latte, Nette\'s built-in templating engine, redefines simplicity and security in PHP web development. Unlike traditional templating systems, Latte compiles templates into optimized PHP code, boosting performance and caching efficiency. Its intuitive syntax, with clever macros embedded in HTML tags, makes templates highly readable compared to native PHP or engines like Smarty. Latte\'s standout feature is its automatic protection against XSS attacks through Context-Aware Escaping, ensuring variables are safely rendered by default. This reduces developer errors and enhances application security. Supporting HTML5, AJAX, and internationalization, Latte is versatile for building dynamic, multilingual interfaces. Praised for its ease of use and speed, Latte is a key reason developers love Nette, offering a seamless blend of power and simplicity for crafting secure, modern web applications.",	CURRENT_TIMESTAMP);

CREATE TABLE `comments` (
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`post_id` int NOT NULL,
	`name` varchar(250) NOT NULL,
	`email` varchar(250) NOT NULL,
	`content` text NOT NULL,
	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB CHARSET=utf8;
