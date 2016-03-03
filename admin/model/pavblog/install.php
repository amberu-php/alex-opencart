<?php 

/******************************************************
 * @package Pav blog module for Opencart 1.5.x
 * @version 1.1
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

/**
 * class ModelPavbloginstall 
 */
class ModelPavbloginstall extends Model { 
	public function checkInstall(){
		
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."pavblog_blog'";
		$query = $this->db->query( $sql );
		
		if( count($query->rows) <=0 ){ 
			$file = (DIR_APPLICATION).'model/sample/module.php';
			
			if( file_exists($file) ){
				require_once( $file );
		 		$sample = new ModelSampleModule( $this->registry );
		 	    $result = $sample->installSampleQuery( $this->config->get('config_template'),'pavblog', true );
				$result = $sample->installSample( $this->config->get('config_template'),'pavblogcategory', true );
				$result = $sample->installSample( $this->config->get('config_template'),'pavblogcomment', true );
				$result = $sample->installSample( $this->config->get('config_template'),'pavbloglatest', true );
			}
		}	

		$sql = " SHOW TABLES LIKE '".DB_PREFIX."pavblog_blog'";
		$query = $this->db->query( $sql );
		if( count($query->rows) <=0 ){ 
			$this->createTables();
			$this->createDataSample();
			$this->createDefaultConfig();
		}
		$sql = " SELECT * FROM ".DB_PREFIX."extension WHERE `code` IN('pavblogcategory','pavblogcomment','pavbloglatest')";
		$query = $this->db->query( $sql );
		if($query->num_rows <= 0){
			$this->installModules();
		}
	}
	public function installModules(){
		$sql1 = "DELETE FROM ".DB_PREFIX."extension WHERE `code` IN('pavblogcategory','pavblogcomment','pavbloglatest')";
		$this->db->query($sql1);
		$sql = array();
		$sql[] = "INSERT INTO `".DB_PREFIX."extension` SET `type`='module', `code`='pavblogcategory'";
		$sql[] = "INSERT INTO `".DB_PREFIX."extension` SET `type`='module', `code`='pavblogcomment'";
		$sql[] = "INSERT INTO `".DB_PREFIX."extension` SET `type`='module', `code`='pavbloglatest'";
		foreach( $sql as $q ){
			$query = $this->db->query( $q );
		}
	}
	public function createTables(){
		$sql =array();
		$sql[] = "
			
			CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavblog_blog` (
			  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
			  `category_id` int(11) NOT NULL,
			  `position` int(11) NOT NULL,
			  `created` date NOT NULL,
			  `status` tinyint(1) NOT NULL,
			  `user_id` int(11) NOT NULL,
			  `hits` int(11) NOT NULL,
			  `image` varchar(255) NOT NULL,
			  `meta_keyword` varchar(255) NOT NULL,
			  `meta_description` varchar(255) NOT NULL,
			  `meta_title` varchar(255) NOT NULL,
			  `date_modified` date NOT NULL,
			  `video_code` varchar(255) NOT NULL,
			  `params` text NOT NULL,
			  `featured` tinyint(1) NOT NULL,
			  `keyword` varchar(255) NOT NULL,
			  PRIMARY KEY (`blog_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;
		
		";
		
		$sql[] = "
		
			
			CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavblog_blog_description` (
			  `blog_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `title` varchar(255) NOT NULL,
			  `description` text NOT NULL,
			  `content` text NOT NULL,
			  `lang_tags` varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		";
		
		$sql[] = "
						
			CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavblog_category` (
			  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `image` varchar(255) NOT NULL DEFAULT '',
			  `parent_id` int(11) NOT NULL DEFAULT '0',
			  `is_group` smallint(6) NOT NULL DEFAULT '2',
			  `width` varchar(255) DEFAULT NULL,
			  `submenu_width` varchar(255) DEFAULT NULL,
			  `colum_width` varchar(255) DEFAULT NULL,
			  `submenu_colum_width` varchar(255) DEFAULT NULL,
			  `item` varchar(255) DEFAULT NULL,
			  `colums` varchar(255) DEFAULT '1',
			  `type` varchar(255) NOT NULL,
			  `is_content` smallint(6) NOT NULL DEFAULT '2',
			  `show_title` smallint(6) NOT NULL DEFAULT '1',
			  `meta_keyword` varchar(255) NOT NULL DEFAULT '1',
			  `level_depth` smallint(6) NOT NULL DEFAULT '0',
			  `published` smallint(6) NOT NULL DEFAULT '1',
			  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0',
			  `position` int(11) unsigned NOT NULL DEFAULT '0',
			  `show_sub` smallint(6) NOT NULL DEFAULT '0',
			  `url` varchar(255) DEFAULT NULL,
			  `target` varchar(25) DEFAULT NULL,
			  `privacy` smallint(5) unsigned NOT NULL DEFAULT '0',
			  `position_type` varchar(25) DEFAULT 'top',
			  `menu_class` varchar(25) DEFAULT NULL,
			  `description` text,
			  `meta_description` text,
			  `meta_title` varchar(255) DEFAULT NULL,
			  `level` int(11) NOT NULL,
			  `left` int(11) NOT NULL,
			  `right` int(11) NOT NULL,
			  `keyword` varchar(255) NOT NULL,
			  PRIMARY KEY (`category_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

		";
		$sql[] = "
		
			
				CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavblog_category_description` (
				  `category_id` int(11) NOT NULL,
				  `language_id` int(11) NOT NULL,
				  `title` varchar(255) NOT NULL,
				  `description` text NOT NULL,
				  PRIMARY KEY (`category_id`,`language_id`),
				  KEY `name` (`title`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;

		";
		
		$sql[] = "
			
					CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavblog_comment` (
					  `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `blog_id` int(11) unsigned NOT NULL,
					  `comment` text NOT NULL,
					  `status` tinyint(1) NOT NULL DEFAULT '0',
					  `created` datetime DEFAULT NULL,
					  `user` varchar(255) NOT NULL,
					  `email` varchar(255) NOT NULL,
					  PRIMARY KEY (`comment_id`),
					  KEY `FK_blog_comment` (`blog_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;
		";

		$sql[] = "
			
			CREATE TABLE `".DB_PREFIX."pavblog_related_product` (
			  `blog_id` int(11) NOT NULL,
			  `product_id` int(11) NOT NULL,
			  KEY `blog_id` (`blog_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;

		";



		foreach( $sql as $q ){
			$query = $this->db->query( $q );
		}
		return ;
	}
	
	public function createDataSample(){
		$sql = array();
		
		$sql[] = "
		
INSERT INTO `".DB_PREFIX."pavblog_blog` (`blog_id`, `category_id`, `position`, `created`, `status`, `user_id`, `hits`, `image`, `meta_keyword`, `meta_description`, `meta_title`, `date_modified`, `video_code`, `params`, `featured`, `keyword`) VALUES
(7,	21,	2,	'2013-03-09',	1,	1,	189,	'catalog/blogs/pav-c1.jpg',	'',	'',	'',	'2015-11-18',	'',	'',	1,	'realnost'),
(9,	21,	1,	'2013-03-09',	1,	1,	158,	'catalog/blogs/pav-c2.jpg',	'',	'',	'',	'2015-11-18',	'',	'',	0,	'transport'),
(10,	23,	3,	'2013-03-09',	1,	1,	296,	'catalog/blogs/pav-c3.jpg',	'test test',	'',	'Custom SEO Titlte',	'2015-11-18',	'&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/YJVmu6yttiw?rel=0&amp;amp;controls=0&amp;amp;showinfo=0&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;',	'',	0,	'motobot'),
(11,	21,	4,	'2013-03-11',	1,	1,	117,	'catalog/blogs/pav-i1.jpg',	'',	'',	'',	'2015-11-17',	'',	'',	0,	'vystavka'),
(13,	21,	5,	'2014-03-11',	1,	1,	119,	'catalog/blogs/header_gadget.jpg',	'',	'',	'',	'2015-11-18',	'',	'',	0,	'tech'),
(14,	1,	0,	'2015-11-19',	1,	1,	22,	'catalog/blogs/pav-c5.png',	'',	'',	'',	'2015-11-19',	'',	'',	0,	'apple_iphone_6'),
(15,	1,	0,	'2015-11-19',	1,	1,	2,	'catalog/blogs/pav-c6.jpg',	'',	'',	'',	'2015-11-19',	'',	'',	0,	'asus_zenfone_2');
 

		";
		$sql[] = "


INSERT INTO  `".DB_PREFIX."pavblog_blog_description` (`blog_id`, `language_id`, `title`, `description`, `content`, `lang_tags`) VALUES
(11,	1,	' Выставка, посвящённая новым 3D технологиям',	'&lt;p&gt;На прошедшей 9-10 октября в Москве выставке 3D - Expo помимо уже известных возможностей 3D принтеров были представлены совершенно новые направления в этой, быстро развивающейся сфере.&lt;/p&gt;\r\n',	'&lt;p&gt;На смену обычной сувенирной продукции, такой как создание точной копии любого предмета пришли и практичные направления: например, в Европе, создали обувь, напечатанную на 3D принтере, но она подиумная, а значит неудобная и не подходит для повседневного хождения. Компания Солюшенс 3Д представила на выставке первую креативную и практичную 3D обувь, в которой можно ходить по улицам. Имея в своей производственной базе оборудование для реализации 3D проектов, а также штат профессиональных 3D моделлеров, Солюшенс 3Д может предложить заказчику реализацию любых эксклюзивных дизайнерских идей. В данной сфере возможно применение различных материалов 3D печати: пластики, фотополимеры, металлы и их комбинации. А самое важное, все это печатается на первом российском 3D принтере с мощным названием &quot;Зверь&quot; с самой большой областью и скоростью печати, представленном союзом профессионалов в области 3D технологий &quot;Коллаборация 3Д&quot;. Действительно, разработчики смогли создать уникальную рабочую машину, которая не будет уступать импортным аналогам. 3D принтер &quot;Зверь&quot; печатает как двумя экструдерами разных цветов, так и с материалом поддержки, что позволяет создавать самые сложные и точные изделия. Нельзя не отметить появление новой функции автокалибровки — достаточно просто загрузить свой проект в компьютер, нажимать на кнопку пуска и машина без лишних движений владельца сама начнёт печатать. Но это ещё не все новшества за 2015 год. Компания &quot;Спецавиа&quot; совместно с Коллаборацией 3D разработала первый в России Строительный 3D принтер. Строительный 3Д принтер может изготавливать индивидуальные изделия из бетона и других строительных смесей формы размером от 12 куб.м (различные элементы для беседок, малые фундаменты, клумбы, скамейки и всевозможные ландшафтные постройки, печи, камины, барбекюшницы). Стоимость эксклюзивного изделия будет гораздо ниже серийного производства, так как в последнем большая часть затрат уходит на трудоемкие опалубки. Снижение цены на производство индивидуального изделия обусловлено сокращением рабочих мест, ведь, чтобы следить за 3D принтером понадобится всего один человек, когда как над изготовлением серии на производстве трудится целая бригада. Размер изготавливаемого изделия ограничивается областью печати принтера, а дизайн - лишь полетом Вашей фантазии&lt;/p&gt;\r\n',	'технологии'),
(11,	2,	'Donec tellus Nulla lorem Nullam elit id ut',	'&lt;p&gt;Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.&lt;/p&gt;\r\n',	'&lt;p&gt;Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.&lt;/p&gt;\r\n\r\n&lt;p&gt;Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend leo mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.&lt;/p&gt;\r\n',	'Tag on English'),
(7,	1,	'Интерфейс дополненной реальности от NEC',	'&lt;p&gt;Новое интересное решение по обеспечению мобильного пользователя полноценной тактильной клавиатурой предложила компания NEC.&lt;/p&gt;\r\n',	'&lt;p&gt;Новое интересное решение по обеспечению мобильного пользователя полноценной тактильной клавиатурой предложила компания NEC. В представленный ею прототип устройства входят очки дополненной реальности, а также специальный умный браслет с экраном. Система получила название ARmKeypad и даёт возможность пользователю видеть и взаимодействовать с проекционной клавиатурой: камера в очках следит за движениями пальцев человека и отслеживает прикосновения к виртуальным клавишам, а набираемый текст передаётся на дисплей &quot;умных&quot; часов. Новое интересное решение по обеспечению мобильного пользователя полноценной тактильной клавиатурой предложила компания NEC. В представленный ею прототип устройства входят очки дополненной реальности, а также специальный умный браслет с экраном. Система получила название ARmKeypad и даёт возможность пользователю видеть и взаимодействовать с проекционной клавиатурой: камера в очках следит за движениями пальцев человека и отслеживает прикосновения к виртуальным клавишам, а набираемый текст передаётся на дисплей &quot;умных&quot; часов. Новое интересное решение по обеспечению мобильного пользователя полноценной тактильной клавиатурой предложила компания NEC. В представленный ею прототип устройства входят очки дополненной реальности, а также специальный умный браслет с экраном. Система получила название ARmKeypad и даёт возможность пользователю видеть и взаимодействовать с проекционной клавиатурой: камера в очках следит за движениями пальцев человека и отслеживает прикосновения к виртуальным клавишам, а набираемый текст передаётся на дисплей &quot;умных&quot; часов. Новое интересное решение по обеспечению мобильного пользователя полноценной тактильной клавиатурой предложила компания NEC. В представленный ею прототип устройства входят очки дополненной реальности, а также специальный умный браслет с экраном. Система получила название ARmKeypad и даёт возможность пользователю видеть и взаимодействовать с проекционной клавиатурой: камера в очках следит за движениями пальцев человека и отслеживает прикосновения к виртуальным клавишам, а набираемый текст передаётся на дисплей &quot;умных&quot; часов.&lt;/p&gt;\r\n',	'технологии, реальность'),
(7,	2,	'Ac tincidunt Suspendisse malesuada',	'&lt;p&gt;Ac tincidunt Suspendisse malesuada velit in Nullam elit magnis netus Vestibulum. Praesent Nam adipiscing Aliquam elit accumsan wisi sit semper scelerisque convallis. Sed quisque cum velit&lt;/p&gt;\r\n',	'&lt;p&gt;Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.&lt;/p&gt;\r\n\r\n&lt;p&gt;Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend leo mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.&lt;/p&gt;\r\n',	'Tag on English'),
(9,	1,	'Футуристическое транспортное средство',	'&lt;p&gt;На токийском автосалоне 2015 Honda представила оригинальный концепт туристического прогулочного автомобиля - Wander Stand. Эта модель не годится для оживленных городских дорог. Транспортное средство рассчитано на поездки по парковым зонам, куда обычным авто доступ запрещен и способно перевозить двух человек в полусидячем положении: сделано это для того, чтобы пассажиры находились примерно на одном уровне с пешеходами.&lt;/p&gt;\r\n',	'&lt;p&gt;На токийском автосалоне 2015 Honda представила оригинальный концепт туристического прогулочного автомобиля - Wander Stand. Эта модель не годится для оживленных городских дорог. Транспортное средство рассчитано на поездки по парковым зонам, куда обычным авто доступ запрещен и способно перевозить двух человек в полусидячем положении: сделано это для того, чтобы пассажиры находились примерно на одном уровне с пешеходами. Honda Wander Stand представляет собой вертикальную капсулу с двумя посадочными местами, дверцами-заслонками, джойстиком и сенсорным дисплеем вместо руля и лобовым стеклом с системой дополненной реальности. Электрокар может двигаться в автоматическом и ручном режимах. Во втором случае управление осуществляется при помощи голосовых команд и джойстика в центральной части передней панели. Такое расположение контроллера позволяет вести машину любому из пассажиров без необходимости пересадки с места на место. Высота Wander Stand больше длины. В движение машина приводится электрическим мотором. Колеса позволяют двигаться в разных направлениях, не меняя положения кабины.На токийском автосалоне 2015 Honda представила оригинальный концепт туристического прогулочного автомобиля - Wander Stand. Эта модель не годится для оживленных городских дорог. Транспортное средство рассчитано на поездки по парковым зонам, куда обычным авто доступ запрещен и способно перевозить двух человек в полусидячем положении: сделано это для того, чтобы пассажиры находились примерно на одном уровне с пешеходами. Honda Wander Stand представляет собой вертикальную капсулу с двумя посадочными местами, дверцами-заслонками, джойстиком и сенсорным дисплеем вместо руля и лобовым стеклом с системой дополненной реальности. Электрокар может двигаться в автоматическом и ручном режимах. Во втором случае управление осуществляется при помощи голосовых команд и джойстика в центральной части передней панели. Такое расположение контроллера позволяет вести машину любому из пассажиров без необходимости пересадки с места на место. Высота Wander Stand больше длины. В движение машина приводится электрическим мотором. Колеса позволяют двигаться в разных направлениях, не меняя положения кабины.&lt;/p&gt;\r\n',	'транспорт'),
(9,	2,	'Commodo laoreet semper tincidunt lorem ',	'&lt;p&gt;Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue&lt;/p&gt;\r\n',	'&lt;p&gt;Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.&lt;/p&gt;\r\n\r\n&lt;p&gt;Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend leo mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.&lt;/p&gt;\r\n',	'transport'),
(13,	1,	' Выставка, посвящённая новым технологиям',	'&lt;p&gt;На прошедшей 9-10 октября в Москве выставке 3D - Expo помимо уже известных возможностей 3D принтеров были представлены совершенно новые направления в этой, быстро развивающейся сфере.&lt;/p&gt;\r\n',	'&lt;p&gt;На смену обычной сувенирной продукции, такой как создание точной копии любого предмета пришли и практичные направления: например, в Европе, создали обувь, напечатанную на 3D принтере, но она подиумная, а значит неудобная и не подходит для повседневного хождения. Компания Солюшенс 3Д представила на выставке первую креативную и практичную 3D обувь, в которой можно ходить по улицам. Имея в своей производственной базе оборудование для реализации 3D проектов, а также штат профессиональных 3D моделлеров, Солюшенс 3Д может предложить заказчику реализацию любых эксклюзивных дизайнерских идей. В данной сфере возможно применение различных материалов 3D печати: пластики, фотополимеры, металлы и их комбинации. А самое важное, все это печатается на первом российском 3D принтере с мощным названием &quot;Зверь&quot; с самой большой областью и скоростью печати, представленном союзом профессионалов в области 3D технологий &quot;Коллаборация 3Д&quot;. Действительно, разработчики смогли создать уникальную рабочую машину, которая не будет уступать импортным аналогам. 3D принтер &quot;Зверь&quot; печатает как двумя экструдерами разных цветов, так и с материалом поддержки, что позволяет создавать самые сложные и точные изделия. Нельзя не отметить появление новой функции автокалибровки — достаточно просто загрузить свой проект в компьютер, нажимать на кнопку пуска и машина без лишних движений владельца сама начнёт печатать. Но это ещё не все новшества за 2015 год. Компания &quot;Спецавиа&quot; совместно с Коллаборацией 3D разработала первый в России Строительный 3D принтер. Строительный 3Д принтер может изготавливать индивидуальные изделия из бетона и других строительных смесей формы размером от 12 куб.м (различные элементы для беседок, малые фундаменты, клумбы, скамейки и всевозможные ландшафтные постройки, печи, камины, барбекюшницы). Стоимость эксклюзивного изделия будет гораздо ниже серийного производства, так как в последнем большая часть затрат уходит на трудоемкие опалубки. Снижение цены на производство индивидуального изделия обусловлено сокращением рабочих мест, ведь, чтобы следить за 3D принтером понадобится всего один человек, когда как над изготовлением серии на производстве трудится целая бригада. Размер изготавливаемого изделия ограничивается областью печати принтера, а дизайн - лишь полетом Вашей фантазии&lt;/p&gt;\r\n',	'технологии'),
(13,	2,	'Donec tellus Nulla lorem Nullam elit id ut !!!',	'&lt;p&gt;Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.&lt;/p&gt;\r\n',	'&lt;p&gt;Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.&lt;/p&gt;\r\n\r\n&lt;p&gt;Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.&lt;/p&gt;\r\n\r\n&lt;p&gt;Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend leo mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.&lt;/p&gt;\r\n',	'Tag on English'),
(10,	1,	'Motobot - андроид-пилот гоночного байка',	'&lt;p&gt;28 октября на выставке Tokyo Motor Show 2015 компания Yamaha представила уникальную разработку - новый андроид Motobot, который способен управлять мотоциклом.&lt;/p&gt;\r\n',	'&lt;p&gt;28 октября на выставке Tokyo Motor Show 2015 компания Yamaha представила уникальную разработку - новый андроид Motobot, который способен управлять мотоциклом.Пока что Motobot развивает скорость чуть более 100 км/ч на специально модифицированном под робота мотоцикле со страховочными колесами. Однако уже сейчас робот способен манипулировать стандартными средствами управления мотоциклом: рычагом переключения передач, ручкой акселератора, рычагом тормоза и другими механизмами мотоцикла.Инженеры Yamaha заявляют, что в со временем робот сможет управлять любым гоночным байком на реальных трассах и поддерживать скорость более 200 км/ч.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img src=&quot;http://tomtest.tw1.ru/image/catalog/demo/canon_eos_5d_3.jpg&quot; /&gt;&lt;/p&gt;\r\n',	'транспорт'),
(10,	2,	'Sed ut perspiciatis unde omnis iste natus error sit ',	'&lt;p&gt;&quot;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.&lt;/p&gt;\r\n',	'&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;/image/catalog/demo/htc_touch_hd_3.jpg&quot; style=&quot;float:left; height:250px; width:250px&quot; /&gt;Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&lt;/p&gt;\r\n',	''),
(15,	1,	'Смартфон Asus Zenfone 2',	'&lt;p&gt;Год назад, когда аппетиты грандов смартфонного рынка уже разошлись не на шутку и продвинутая аудитория всерьез посмотрела на малоизвестные китайские альтернативы, Asus представила под своим авторитетным именем троицу разнокалиберных бюджетных устройств Zenfone, среди которых каждый экономный пользователь мог найти смартфон себе по душе. Еще на первой презентации производитель заявлял о работе над вторым поколением устройств. И вот спустя почти год мы возвращаемся к аппаратам Asus — к представленной в России паре Zenfone вообще и ее флагманскому представителю Zenfone 2 ZE551ML в частности.&lt;/p&gt;\r\n',	'&lt;p&gt;Основные характеристики Asus Zenfone 2 ZE551ML&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Однокристальная система: Intel Atom Z3580&lt;/li&gt;\r\n	&lt;li&gt;Центральный процессор: 4 ядра x86-64 @2,3 ГГц (4 потока)&lt;/li&gt;\r\n	&lt;li&gt;Графический процессор: PowerVR G6430 @533 МГц&lt;/li&gt;\r\n	&lt;li&gt;Операционная система: Google Android 5.0 с интерфейсом Asus ZenUI&lt;/li&gt;\r\n	&lt;li&gt;Дисплей: IPS, 5,5″, 1920×1080, 401 ppi&lt;/li&gt;\r\n	&lt;li&gt;Оперативная память: 4 ГБ LPDDR3&lt;/li&gt;\r\n	&lt;li&gt;Внутренняя память: 32 ГБ eMMC&lt;/li&gt;\r\n	&lt;li&gt;Поддержка карт памяти microSD до 64 ГБ&lt;/li&gt;\r\n	&lt;li&gt;Диапазоны мобильной связи: GSM/GPRS/EDGE 850/900/1800/1900; WCDMA 850/900/1900; TD-SCDMA 1900/2100; FDD LTE 1/2/3/4/5/7/8/9/177/18/19/20/28/29, TDD LTE 38/39/40/41&lt;/li&gt;\r\n	&lt;li&gt;Максимальная скорость: LTE Cat4 150/50 Мбит/с, UMTS HSPA+/DC-HSPA+ 42/5,76 Мбит/с&lt;/li&gt;\r\n	&lt;li&gt;Поддержка двух SIM-карт формата Micro-SIM&lt;/li&gt;\r\n	&lt;li&gt;Wi-Fi 802.11 a/b/g/n/ac (2,4 + 5 ГГц)&lt;/li&gt;\r\n	&lt;li&gt;Bluetooth 4.0, NFC, GPS/A-GPS/Глонасс/BDS/QZSS&lt;/li&gt;\r\n	&lt;li&gt;Акселерометр, датчики приближения и освещенности, гироскоп, компас, датчик Холла&lt;/li&gt;\r\n	&lt;li&gt;Тыловая камера: 13 Мп, f/2,0, двойная вспышка, автофокус&lt;/li&gt;\r\n	&lt;li&gt;Фронтальная камера: 5 Мп, f/2,0&lt;/li&gt;\r\n	&lt;li&gt;Аккумулятор: 3000 мА·ч, несъемный&lt;/li&gt;\r\n	&lt;li&gt;Размеры 153×77×11 мм&lt;/li&gt;\r\n	&lt;li&gt;Масса: 170 г&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;Четыре гигабайта RAM — это больше чем у флагманов, да и объем постоянной памяти хорош (при этом еще и сохранен слот microSD). Мощная SoC, приличная камера и дисплей вынуждают нас ставить Zenfone 2 в ряд с более дорогими аппаратами, чем те, с которыми изначально конкурировала линейка.&lt;/p&gt;\r\n',	'технологии, смартфоны'),
(15,	2,	'Asus Zenfone 2 ZE551ML',	'&lt;p&gt;A year ago, when the appetites of giants of the smartphone market had gone in earnest and advanced audience seriously looked at the little-known Chinese Alternatively, Asus introduced under his authority in the name of the trio of different-sized devices budgetary Zenfone, among which one could find an economical user smartphone to your liking. Even at the first presentation of the manufacturer said the work on the second generation of devices. And now, after nearly a year we return to the devices Asus - for submission to the Russian pair Zenfone general and its flagship representative Zenfone 2 ZE551ML in particular.&lt;/p&gt;\r\n',	'&lt;p&gt;Key Features Asus Zenfone 2 ZE551ML&lt;br /&gt;\r\nSoC: Intel Atom Z3580&lt;br /&gt;\r\nCPU: 4 cores x86-64 @ 2,3 GHz (4 threads)&lt;br /&gt;\r\nThe GPU: PowerVR G6430 @ 533 MHz&lt;br /&gt;\r\nOperating system: Google Android 5.0 interface Asus ZenUI&lt;br /&gt;\r\nDisplay: IPS, 5,5 &quot;, 1920 × 1080 resolution, 401 ppi&lt;br /&gt;\r\nMemory: 4GB LPDDR3&lt;br /&gt;\r\nInternal Memory: 32 GB eMMC&lt;br /&gt;\r\nSupporting microSD memory cards up to 64 GB&lt;br /&gt;\r\nRanges mobile: GSM / GPRS / EDGE 850/900/1800/1900; WCDMA 850/900/1900; TD-SCDMA 1900/2100; FDD LTE 1/2/3/4/5/7/8/9/177/18/19/20/28/29, TDD LTE 38/39/40/41&lt;br /&gt;\r\nMaximum speed: LTE Cat4 150/50 Mbit / s, UMTS HSPA + / DC-HSPA + 42 / 5.76 Mbit / s&lt;br /&gt;\r\nSupport for two SIM-card format Micro-SIM&lt;br /&gt;\r\nWi-Fi 802.11 a / b / g / n / ac (2,4 + 5 GHz)&lt;br /&gt;\r\nBluetooth 4.0, NFC, GPS / A-GPS / GLONASS / BDS / QZSS&lt;br /&gt;\r\nAccelerometer, proximity sensor and ambient light, gyroscope, compass, Hall sensor&lt;br /&gt;\r\nRear Camera: 13 megapixel, f / 2,0, dual flash, autofocus&lt;br /&gt;\r\nFront camera: 5 megapixel, f / 2,0&lt;br /&gt;\r\nBattery: 3000 mAh, removable&lt;br /&gt;\r\nDimensions 153 × 77 × 11 mm&lt;br /&gt;\r\nWeight: 170 g&lt;br /&gt;\r\nFour gigabytes of RAM - it\'s more than the champions, and the volume of non-volatile memory is good (thus also saved slot microSD). The powerful SoC, decent camera and display are forcing us to put Zenfone 2 in line with more expensive devices than those that initially competed lineup.&lt;/p&gt;\r\n',	'tech, smartphones'),
(14,	1,	'Обзор Apple iPhone 6',	'&lt;p&gt;В этом году мы увидели новое поколение iPhone, которое получило и улучшенную версию iOS 8, и полностью переработанный дизайн. Смартфоны Apple обновляются нечасто, тут можно вспомнить революционный iPhone 4, который вышел в 2010 году и задал курс дальнейшего развития компании.&lt;/p&gt;\r\n',	'&lt;p&gt;Причем даже более поздние модели предлагали немало общих черт с этой моделью. Так что теперь, спустя пять лет после появления на свет легендарного аппарата, в продажу поступает новое поколение смартфонов Apple. Причем теперь будут доступны сразу две модели с разными диагоналями экранов: 4,7 и 5,5 дюймов, что можно назвать весьма своевременным шагом для компании, которая долгое время придерживалась крайне консервативных взглядов. Но рынок диктует свои правила, поэтому теперь и Apple будет играть на одном поле с теми, кто уже давно освоил большие диагонали.&lt;/p&gt;\r\n\r\n&lt;p&gt;Технические характеристики&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;ОС: iOS 8&lt;/li&gt;\r\n	&lt;li&gt;Сеть: GSM/EDGE/UMTS/LTE (поддержка частот зависит от модификации), nanoSIM&lt;/li&gt;\r\n	&lt;li&gt;Процессор: Apple A8, M8, 64 бит, 1,4 ГГц&lt;/li&gt;\r\n	&lt;li&gt;Память: RAM 1 ГБ, ROM 16/64/128 ГБ&lt;/li&gt;\r\n	&lt;li&gt;Экран: 4,7 дюйма, IPS, 750 х 1334 точки, Retina HD, 326 ppi, контрастность 1400:1, олеофобное покрытие&lt;/li&gt;\r\n	&lt;li&gt;Камера: iSight, f/2.2, 8 Мп, Focus Pixels, 5-элементная линза, 1,5 микрона, запись видео 1080р 30 или 60 fps, замедленная съемка 120 или 240 fps, съемка timelaps, двойная светодиодная вспышка True Tone, FaceTime 1,2 Мп&lt;/li&gt;\r\n	&lt;li&gt;Сеть: Wi-Fi 802.11 a/b/g/n/ac, Bluetooth 4.0, NFC, GPS и GLONASS&lt;/li&gt;\r\n	&lt;li&gt;Особенности: сканер отпечатка пальца Touch ID, Apple Pay, голосовое управление Siri&lt;/li&gt;\r\n	&lt;li&gt;Цвета: серебристый, черный, золотистый&lt;/li&gt;\r\n	&lt;li&gt;Размеры: 138,1 х 67 х 6,9 мм, вес 129 г&lt;/li&gt;\r\n	&lt;li&gt;Время работы: разговор до 14 часов, ожидание до 250 часов, интернет до 10 часов в 3G, до 10 часов в LTE, до 11 часов в Wi-Fi, 11 часов видео, 50 часов проигрывания музыки&lt;/li&gt;\r\n&lt;/ul&gt;\r\n',	'Новый  iPhone, технологии, новинки, смартфоны'),
(14,	2,	'Apple iPhone 6 16GB',	'&lt;p&gt;This year we have seen a new generation of the iPhone, which has received and improved iOS version 8 , and completely redesigned . Apple smartphone updated infrequently , then you can remember the revolutionary iPhone 4, which was released in 2010 and set the course for further development of the company.&lt;/p&gt;\r\n',	'&lt;p&gt;And even later models offer a lot in common with the model. So now, five years after the birth of the legendary machine goes on sale the new generation of smart phones Apple. And now be available two models with different screen diagonals: 4.7 and 5.5 inches, which can be called a very timely step for the company, which has long adhered to a very conservative views. But the market dictates its own rules, so now Apple will play on the same field with those who have long mastered the large diagonal.&lt;/p&gt;\r\n\r\n&lt;p&gt;Specifications&lt;/p&gt;\r\n\r\n&lt;p&gt;OS: iOS 8&lt;br /&gt;\r\nNetwork: GSM / EDGE / UMTS / LTE (the frequency depends on the support of the modification), nanoSIM&lt;br /&gt;\r\nProcessor: Apple A8, M8, 64-bit, 1.4 GHz&lt;br /&gt;\r\nMemory: RAM 1 GB, ROM 16/64/128 GB&lt;br /&gt;\r\nScreen: 4.7 inches, IPS, 750 x 1334 points, Retina HD, 326 ppi, contrast 1400: 1, oleophobic coating&lt;br /&gt;\r\nCamera: iSight, f / 2.2, 8 MP, Focus Pixels, 5-element lens, 1.5 micron, video recording 1080p 30 or 60 fps, slow motion 120 or 240 fps, shooting timelaps, dual LED flash True Tone, FaceTime 1 2 megapixel&lt;br /&gt;\r\nNetwork: Wi-Fi 802.11 a / b / g / n / ac, Bluetooth 4.0, NFC, GPS and GLONASS&lt;br /&gt;\r\nFeatures: Fingerprint Touch ID, Apple Pay, voice control Siri&lt;br /&gt;\r\nColours: silver, black, gold&lt;br /&gt;\r\nDimensions: 138.1 x 67 x 6.9 mm, weight 129 g&lt;br /&gt;\r\nHours: talk up to 14 hours, waiting for up to 250 hours online and 10 hours in 3G, up to 10 hours in LTE, and 11 hours Wi-Fi, 11:00 video, 50 hours of music playback&lt;/p&gt;\r\n',	'New iphone, tech');		
		";
		$sql[] = "
	
INSERT INTO `".DB_PREFIX."pavblog_category` (`category_id`, `image`, `parent_id`, `is_group`, `width`, `submenu_width`, `colum_width`, `submenu_colum_width`, `item`, `colums`, `type`, `is_content`, `show_title`, `meta_keyword`, `level_depth`, `published`, `store_id`, `position`, `show_sub`, `url`, `target`, `privacy`, `position_type`, `menu_class`, `description`, `meta_description`, `meta_title`, `level`, `left`, `right`, `keyword`) VALUES
(1,	'',	0,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	'1',	'',	2,	1,	'1',	0,	1,	0,	0,	0,	NULL,	NULL,	0,	'top',	NULL,	NULL,	NULL,	NULL,	-5,	34,	47,	'blogs'),
(20,	'catalog/blogs/pav-i1.jpg',	22,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	'1',	'',	2,	1,	'1',	0,	1,	0,	2,	0,	NULL,	NULL,	0,	'top',	'test test',	NULL,	'',	'',	0,	0,	0,	'demo_category_12'),
(21,	'catalog/blogs/pav-c2.jpg',	22,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	'1',	'',	2,	1,	'1',	0,	1,	0,	1,	0,	NULL,	NULL,	0,	'top',	'',	NULL,	'',	'',	0,	0,	0,	'tehnology'),
(22,	'catalog/blogs/pav-c1.jpg',	1,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	'1',	'',	2,	1,	'1',	0,	1,	0,	1,	0,	NULL,	NULL,	0,	'top',	'',	NULL,	'',	'',	0,	0,	0,	'demo_category_1'),
(23,	'catalog/blogs/pav-c4.jpg',	21,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	'1',	'',	2,	1,	'1',	0,	1,	0,	1,	0,	NULL,	NULL,	0,	'top',	'',	NULL,	'',	'',	0,	0,	0,	'demo_category_1_2_2'),
(24,	'catalog/blogs/pav-c2.jpg',	1,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	'1',	'',	2,	1,	'1',	0,	1,	0,	2,	0,	NULL,	NULL,	0,	'top',	'',	NULL,	'',	'',	0,	0,	0,	'demo_category2');

	
		";
		$sql[] = "

INSERT INTO  `".DB_PREFIX."pavblog_category_description` (`category_id`, `language_id`, `title`, `description`) VALUES
(1,	2,	'Blogs',	'Menu Blogs'),
(21,	1,	'Технологии',	'&lt;p&gt;Здесь тестовое описание.Здесь тестовое описание.Здесь тестовое описание.Здесь тестовое описание.Здесь тестовое описание.Здесь тестовое описание.Здесь тестовое описание.Здесь тестовое описание.&lt;/p&gt;\r\n'),
(23,	1,	'Демо категория 1-2-2',	'&lt;p&gt;Ac tincidunt Suspendisse malesuada velit in Nullam elit magnis netus Vestibulum. Praesent Nam adipiscing Aliquam elit accumsan wisi sit semper scelerisque convallis&lt;/p&gt;\r\n'),
(23,	2,	'Demo Category 1-2-2',	'Ac tincidunt Suspendisse malesuada velit in Nullam elit magnis netus Vestibulum. Praesent Nam adipiscing Aliquam elit accumsan wisi sit semper scelerisque convallis'),
(24,	2,	'Demo Category 2',	'Description Here'),
(20,	1,	'Демо категория 1-2',	'&lt;p&gt;Здесь тестовое описание.Здесь тестовое описание.Здесь тестовое описание.Здесь тестовое описание.Здесь тестовое описание.Здесь тестовое описание.Здесь тестовое описание.Здесь тестовое описание.s&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n'),
(1,	1,	'Блоги',	'Menu Blogs'),
(22,	1,	'Демо категория 1',	'&lt;p&gt;Здесь тестовое описание на русском для первой категории&lt;/p&gt;\r\n'),
(24,	1,	'Демо категория 2',	'&lt;p&gt;Здесь тестовое описание&lt;/p&gt;\r\n'),
(22,	2,	'Demo Category 1',	'Enter your Category 1 Description Here'),
(21,	2,	'Tehnology',	'Here is test description.Here is test description.Here is test description.Here is test description.Here is test description.Here is test description.Here is test description.Here is test description.Here is test description.'),
(20,	2,	'Demo Category 1-2',	'Ac tincidunt Suspendisse malesuada velit in Nullam elit magnis netus Vestibulum. Praesent Nam adipiscing Aliquam elit accumsan wisi sit semper scelerisque convallis');		
		
		";
		
		$sql[] = "
		
INSERT INTO `".DB_PREFIX."pavblog_comment` (`comment_id`, `blog_id`, `comment`, `status`, `created`, `user`, `email`) VALUES
(6,	10,	'Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur mag Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur mag',	1,	'2013-03-12 14:23:09',	'ha cong tien',	'hatuhn@gmail.com'),
(7,	10,	'Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur mag',	1,	'2013-03-12 14:25:19',	'ha cong tien',	'hatuhn@gmail.com'),
(8,	10,	'Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur mag Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur mag',	1,	'2013-03-12 14:30:17',	'Test Test ',	'ngoisao@aa.com');
		";


				$sql[] = "
		
INSERT INTO `".DB_PREFIX."pavblog_related_product` (`blog_id`, `product_id`) VALUES
(10,	41),
(10,	28),
(10,	42),
(7,	41),
(7,	47),
(7,	30),
(10,	30),
(10,	47),
(9,	41),
(9,	30),
(14,	40);

		";
		
		foreach( $sql as $q ){
			$query = $this->db->query( $q );
		}
		
		return ;
	}
	
	public function createDefaultConfig(){
	 
		$sql  = "
			INSERT INTO  `".DB_PREFIX."layout` (
					`layout_id` ,
					`name`
					)
					VALUES 
					(24,	'Pav Blog'),
					(25,	'pavblog/category'),
					(26,	'pavblog/blog');		
		";

		$query = $this->db->query( $sql );
		
		$id = $this->db->getLastId();
		
		$sql = "
			INSERT INTO `".DB_PREFIX."layout_route` (
				`layout_id` ,
				`store_id` ,
				`route`
				)
				VALUES 
				(24,	0,	'pavblog/blogs'),
				(25,	0,	'pavblog/category'),
				(26,	0,	'pavblog/blog');
				
		
		";
		$query = $this->db->query( $sql );



		$sql = array();

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/blog=13',	'tech')";

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/blog=11',	'vystavka')";

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/category=22',	'demo_category_1')";

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/category=23',	'demo_category_1_2_2')";

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/category=24',	'demo_category2')";

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/category=20',	'demo_category_12')";

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/blog=10',	'motobot')";

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/blog=9',	'transport')";

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/category=1',	'blogs')";

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/blog=7',	'realnost')";

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/category=21',	'tehnology')";

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/blog=14',	'apple_iphone_6')";

		$sql[] = "INSERT INTO `".DB_PREFIX."url_alias` (`query`, `keyword`) VALUES
		('pavblog/blog=15',	'asus_zenfone_2')";


		foreach( $sql as $q ){
			$query = $this->db->query( $q );
		}


		$sql = "
				INSERT INTO `".DB_PREFIX."layout_module` (`layout_id`, `code`, `position`, `sort_order`) VALUES
				(1,		'pavbloglatest.36',	'content_top',	3),
				(24,	'pavblogcategory.32',	'column_left',	1),
				(24,	'pavblogcomment.33',	'column_left',	2),
				(24,	'pavbloglatest.34',	'column_left',	3),
				(25,	'pavblogcategory.32',	'column_left',	1),
				(25,	'pavblogcomment.33',	'column_left',	2),
				(25,	'pavbloglatest.34',	'column_left',	3),
				(26,	'pavblogcomment.33',	'column_right',	2),
				(26,	'pavbloglatest.34',	'column_right',	1),
				(26,	'pavblogcategory.32',	'column_right',	3)
		
		";
		$query = $this->db->query( $sql );



		$sql = "
				INSERT INTO `".DB_PREFIX."module` (`module_id`, `name`, `code`, `setting`) VALUES
				(32,	'Категории Блога',	'pavblogcategory',	'{\"name\":\"\\u041a\\u0430\\u0442\\u0435\\u0433\\u043e\\u0440\\u0438\\u0438 \\u0411\\u043b\\u043e\\u0433\\u0430\",\"category_id\":\"1\",\"status\":\"1\",\"type\":\"accordion\"}'),
				(33,	'Комментарии',	'pavblogcomment',	'{\"name\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\\u0430\\u0440\\u0438\\u0438\",\"limit\":\"1\",\"status\":\"1\"}'),
				(34,	'Новые блоги',	'pavbloglatest',	'{\"name\":\"\\u041d\\u043e\\u0432\\u044b\\u0435 \\u0431\\u043b\\u043e\\u0433\\u0438\",\"status\":\"1\",\"description\":{\"1\":\"&lt;p&gt;&lt;br&gt;&lt;\\/p&gt;\",\"2\":\"&lt;p&gt;&lt;br&gt;&lt;\\/p&gt;\"},\"prefixclass\":\"\\u041f\\u0440\\u0435\\u0444\\u0438\\u043a\\u0441 \\u043a\\u043b\\u0430\\u0441\\u0441\\u0430\",\"tabs\":\"latest\",\"width\":\"300\",\"height\":\"120\",\"cols\":\"1\",\"limit\":\"4\"}'),
				(36,	'Новые Блоги (home)',	'pavbloglatest',	'{\"name\":\"\\u041d\\u043e\\u0432\\u044b\\u0435 \\u0411\\u043b\\u043e\\u0433\\u0438 (home)\",\"status\":\"1\",\"description\":{\"1\":\"&lt;p&gt;&lt;br&gt;&lt;\\/p&gt;\",\"2\":\"&lt;p&gt;&lt;br&gt;&lt;\\/p&gt;\"},\"prefixclass\":\"\\u041f\\u0440\\u0435\\u0444\\u0438\\u043a\\u0441 \\u043a\\u043b\\u0430\\u0441\\u0441\\u0430\",\"tabs\":\"latest\",\"width\":\"390\",\"height\":\"130\",\"cols\":\"4\",\"limit\":\"4\"}');
		
		";
		$query = $this->db->query( $sql );


		
		///
		$d['pavblog'] = array(
			'children_columns' => '2',
			'general_cwidth' => '850',
			'general_cheight' => '300',
			'general_lwidth'=> '850',
			'general_lheight'=> '300',
			'general_sheight'=> '300',
			'general_swidth'=> '850',
			'general_xwidth' => '80',
			'general_xheight' => '80',
			'cat_show_hits' => '1',
			'cat_limit_leading_blog'=> '5',
			'cat_limit_secondary_blog'=> '2',
			'cat_leading_image_type'=> 'l',
			'cat_secondary_image_type'=> 's',
			'cat_show_title'=> '1',
			'cat_show_image'=> '1',
			'cat_show_author'=> '1',
			'cat_show_category'=> '1',
			'cat_show_created'=> '1',
			'cat_show_readmore' => 1,
			'cat_show_description' => '1',
			'cat_show_comment_counter'=> '1',
			
			'blog_image_type'=> 'l',
			'blog_show_title'=> '1',
			'blog_show_image'=> '1',
			'blog_show_author'=> '1',
			'blog_show_category'=> '1',
			'blog_show_created'=> '1',
			'blog_show_comment_counter'=> '1',
			'blog_show_comment_form'=>'1',
			'blog_show_hits' => 1,
			'cat_columns_leading_blogs'=> 1,
			'cat_columns_secondary_blogs' => 3,
			'comment_engine' => 'local',
			'diquis_account' => 'pavothemes',
			'facebook_appid' => '100858303516',
			'facebook_width'=> '600',
			'comment_limit'=> '10',
			'auto_publish_comment'=>0,
			'enable_recaptcha' => 1,
			'recaptcha_public_key'=>'6LcoLd4SAAAAADoaLy7OEmzwjrf4w7bf-SnE_Hvj',
			'recaptcha_private_key'=>'6LcoLd4SAAAAAE18DL_BUDi0vmL_aM0vkLPaE9Ob',
			'rss_limit_item' => 12,
			'keyword_listing_blogs_page'=>'blogs'
	
		);
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('pavblog', $d );	
		
		return ;
	}
}

?>