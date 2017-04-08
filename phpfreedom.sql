-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 03, 2010 at 08:16 AM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `phpfreedom`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_resources`
--

DROP TABLE IF EXISTS `auth_resources`;
CREATE TABLE IF NOT EXISTS `auth_resources` (
  `auth_resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_module` varchar(100) NOT NULL,
  `resource_manager` varchar(100) NOT NULL,
  `resource_action` varchar(100) NOT NULL,
  `access_roles` varchar(100) NOT NULL,
  PRIMARY KEY (`auth_resource_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `auth_resources`
--

INSERT INTO `auth_resources` (`auth_resource_id`, `resource_module`, `resource_manager`, `resource_action`, `access_roles`) VALUES
(17, 'index', 'group', '', '1'),
(15, 'index', 'feedbacks', '', '1'),
(9, 'index', 'feedbacks', 'contact', ''),
(13, 'index', 'group', 'list', ''),
(14, 'admin', '', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
CREATE TABLE IF NOT EXISTS `content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type_key` varchar(100) NOT NULL,
  `role_id` varchar(100) NOT NULL,
  `item_title` varchar(100) NOT NULL,
  `item_subtitle` varchar(100) NOT NULL,
  `item_template` varchar(100) NOT NULL,
  `item_subtemplate` varchar(100) NOT NULL,
  `item_pane_label` varchar(30) NOT NULL,
  `item_desc` text NOT NULL,
  `item_details` text NOT NULL,
  `item_attch` text NOT NULL,
  `item_cat` varchar(100) NOT NULL,
  `item_subcat` varchar(100) NOT NULL,
  `item_order` tinyint(1) NOT NULL DEFAULT '0',
  `item_dt` datetime NOT NULL,
  `item_exp_dt` datetime NOT NULL,
  `item_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `show_last_update_yn` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=12 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `content_type_key`, `role_id`, `item_title`, `item_subtitle`, `item_template`, `item_subtemplate`, `item_pane_label`, `item_desc`, `item_details`, `item_attch`, `item_cat`, `item_subcat`, `item_order`, `item_dt`, `item_exp_dt`, `item_last_update`, `show_last_update_yn`) VALUES
(1, 'NEWS', '', 'Lorem ipsum dolor', '', 'PARENT', 'PARENT', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', '<div id="lipsum">\r\n<p>\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc imperdiet leo non justo vehicula nec tempus leo ultrices. Vivamus a cursus purus. Cras fermentum ligula in odio gravida sodales. Donec id leo ut nibh pharetra porttitor nec in ipsum. Morbi ullamcorper auctor bibendum. Maecenas ut nisi non quam imperdiet sagittis. Nam id sagittis ante. Vivamus quis magna sed ante feugiat pellentesque. Suspendisse vel lectus sem, nec auctor nisi. Proin tempor tortor at est iaculis sagittis. Morbi velit dolor, tincidunt in tincidunt sed, vestibulum nec arcu. Vestibulum volutpat lacinia nibh vitae lacinia. Praesent vel accumsan metus. Aenean vitae ipsum in erat iaculis gravida sed in dui. Fusce imperdiet lectus ac nulla varius ornare consequat in diam. Integer ornare felis eleifend lacus adipiscing bibendum. Praesent suscipit lectus at eros euismod commodo. Quisque congue euismod nulla sit amet porta. Donec eget tortor arcu, et rhoncus velit. \r\n</p>\r\n<p>\r\nSed mollis blandit consectetur. Suspendisse malesuada ornare bibendum. In leo orci, interdum et sodales ut, imperdiet nec nisi. Aenean urna diam, consectetur eu consectetur non, luctus sed augue. Nulla eu justo et mi commodo eleifend at quis quam. Fusce rutrum pellentesque metus, id accumsan justo porttitor quis. Maecenas eget diam lacinia odio mattis rutrum vitae sed dolor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent fringilla, nunc ut malesuada viverra, orci nunc varius augue, et tristique magna odio a magna. Ut cursus tristique suscipit. Morbi purus velit, interdum id lobortis vitae, suscipit vitae eros. Nulla volutpat magna diam. Nunc viverra ipsum porttitor neque dignissim sit amet vulputate augue consectetur. Fusce aliquam ornare dignissim. Suspendisse laoreet cursus rutrum. Fusce egestas urna eget odio porta consectetur. \r\n</p>\r\n<p>\r\nNam semper metus non erat vulputate aliquam. Nunc orci dui, dapibus in vehicula quis, sollicitudin eu ligula. Etiam vitae lacus eu nisi consequat euismod. Praesent laoreet enim magna, eu semper est. Curabitur sem purus, eleifend vel gravida volutpat, fermentum eget nisi. Integer vehicula, lorem a tincidunt laoreet, magna massa lacinia lectus, a cursus purus felis ac tortor. Pellentesque vitae ante ut sapien imperdiet tempor. Praesent in diam eros, dignissim ullamcorper est. Cras a pulvinar est. Aliquam non faucibus purus. Phasellus tellus lorem, lacinia faucibus condimentum sit amet, feugiat in nulla. Sed aliquam, enim at volutpat pellentesque, nibh nisi cursus lorem, at tristique lectus nunc sit amet eros. Praesent ullamcorper pretium ante accumsan vestibulum. Aliquam vulputate sagittis nisl et sagittis. Nulla est mi, consequat vel auctor ut, eleifend at neque. \r\n</p>\r\n</div>\r\n', '', 'DEFAULT', 'DEFAULT', 0, '2009-09-08 00:37:10', '0000-00-00 00:00:00', '2009-09-07 17:37:18', 1),
(2, 'GENERAL', '', 'Contact Us', '', 'PARENT', 'PARENT', '', 'Put your contact details here...', 'Put your contact details here... Go to administrator - Content Manager - [category = contact]\n', '', 'CONTACT', 'CONTACT', 0, '2009-09-02 17:00:55', '0000-00-00 00:00:00', '2009-10-08 10:23:10', 0),
(3, 'NEWS', '', 'Phasellus iaculis dolor', '', 'PARENT', 'PARENT', '', 'Phasellus iaculis dolor id risus rutrum sed condimentum sem commodo. Quisque ac orci ante, vel tempor diam. In at diam neque, sit amet sollicitudin felis. ', '&lt;div&gt;\n&lt;p&gt;\nPhasellus iaculis dolor id risus rutrum sed condimentum sem commodo. Quisque ac orci ante, vel tempor diam. In at diam neque, sit amet sollicitudin felis. Fusce id est nulla, sit amet vestibulum diam. Fusce suscipit molestie felis, id condimentum augue pretium sed. Sed at lorem neque. Sed interdum porttitor nisl, eget laoreet augue vulputate a. Sed porttitor enim et elit malesuada egestas. Donec consequat consequat diam id eleifend. Suspendisse turpis libero, venenatis quis dictum dictum, dapibus quis nisi. Curabitur pharetra mollis sollicitudin. Etiam eget ipsum neque, quis rhoncus nisl. Pellentesque a nisl justo, in laoreet odio. Maecenas pharetra leo et mi venenatis eget lobortis mauris placerat. \n&lt;/p&gt;\n&lt;p&gt;\nSed varius lorem nec lectus porta facilisis. Etiam eu quam in nisi luctus porttitor. Ut sit amet odio ante. Morbi eget eros orci, ac pulvinar ipsum. Morbi ornare dolor dapibus tortor ornare gravida laoreet sed sapien. Duis eget nunc ante. Morbi diam mi, interdum eu porttitor sed, fermentum in sem. Aenean non lobortis felis. Quisque tristique laoreet eleifend. Integer ipsum velit, sagittis eget molestie eu, commodo gravida enim. \n&lt;/p&gt;\n&lt;p&gt;\nVestibulum vestibulum metus dolor. Proin enim tellus, fermentum id venenatis nec, semper eu ante. Praesent interdum tellus quam. Pellentesque eu odio quis odio semper ullamcorper nec a libero. Suspendisse ipsum sem, egestas vel convallis a, tincidunt a tortor. Mauris congue lacus non ipsum tincidunt accumsan. Pellentesque sed nulla nunc, faucibus faucibus tellus. Quisque pulvinar aliquam volutpat. Nunc risus massa, congue in dignissim vel, volutpat rutrum ipsum. Sed eu varius eros. Pellentesque ullamcorper tortor vitae mi varius ac tempus nisl viverra. Vestibulum ut erat at nunc vehicula pharetra id id dui. Cras dapibus convallis adipiscing. Ut pellentesque massa ac lectus blandit in hendrerit leo facilisis. \n&lt;/p&gt;\n&lt;/div&gt;\n', '', 'PHASELLUS', 'PHASELLUS', 0, '2009-09-02 17:39:47', '0000-00-00 00:00:00', '2009-10-08 11:09:25', 1),
(4, 'GENERAL', '', 'Welcome', '', 'PARENT', 'PARENT', '', '', '&lt;p&gt;\r\nThank you for choosing PHP Freedom Framework. The Rapid Web Development Technology from Africa. Now that you have successfully installed your project, the job is almost done. Your website will be ready in few minutes. \r\n&lt;/p&gt;\r\n&lt;p&gt;\r\nFirst, we need to start by securing your application... All the backend functionalities of your application shall reside in the /application folder. This folder contains and will contain your application modules. In order to ensure some security, this folder should not be accessible from a url! Therefore, \r\n&lt;/p&gt;\r\n&lt;ul&gt;\r\n	&lt;li&gt;Move this folder out of your web server. &lt;br /&gt;\r\n	&lt;/li&gt;\r\n	&lt;li&gt;Open /index.php and set $path_to_application_directory = /new/path/to/application and save&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;p&gt;\r\n&lt;br /&gt;\r\nHaving done this, login as the application administrator with &lt;br /&gt;\r\n&lt;br /&gt;\r\nUsername: administrator&lt;br /&gt;\r\nPassword: administrator&lt;br /&gt;\r\n&lt;br /&gt;\r\nYou are advised to change this password after logging in for the first time. To manage user accounts go to administrator - Manage Users.&lt;br /&gt;\r\n&lt;br /&gt;\r\nWe are working towards providing a comprehensive documentation for the project, but for now, we hope that you find the skeletal documentation provided useful and please feel free to contact me for any questions. \r\n&lt;/p&gt;\r\n&lt;p&gt;\r\nThank you. \r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n&lt;br /&gt;\r\n&lt;br /&gt;\r\nADEFOKUN Tomiwa Michael&lt;br /&gt;\r\n&lt;br /&gt;\r\nEmail: tomiwa.adefokun@gmail.com&lt;br /&gt;\r\nPhone: 234 805 305 0903 \r\n&lt;/p&gt;\r\n', 'YTowOnt9', 'HOME', 'HOME', 0, '2009-09-11 16:03:05', '0000-00-00 00:00:00', '2009-10-20 16:27:34', 0),
(5, 'GENERAL', '', 'Live Chat Support', '', 'PARENT', 'PARENT', '', '', '&lt;p&gt;\nSoft-and-smart Technologies supports the project by providing free e-support systems licence for all web applications developed with the PHP Freedom Framework.&lt;br /&gt;\n&lt;br /&gt;\nGo to &lt;a href=&quot;http://www.e-supportsystems.com&quot; target=&quot;_blank&quot; title=&quot;http://www.e-supportsystems.com&quot;&gt;http://www.e-supportsystems.com&lt;/a&gt;  to create your account. When you have successfully created the accountupdate this link in the menu manager to point to the account url, and also point the E-Support Setup link to the account&amp;#39;s control panel.\n&lt;/p&gt;\n', '', 'SUPPORT', 'SUPPORT', 0, '2009-09-02 17:03:36', '0000-00-00 00:00:00', '2009-10-08 11:07:58', 1),
(6, 'GENERAL', '', 'System Administrator', '', 'PARENT', 'PARENT', '', 'The administrator''s home page.', 'This is a restricted area! \r\n', '', 'ADMIN', 'ADMIN', 0, '2009-09-15 15:56:50', '0000-00-00 00:00:00', '2009-09-15 09:02:22', 1),
(7, 'GENERAL', '', 'The Demo Home Page', '', 'PARENT', 'PARENT', '', '', '<p>\r\nWelcome to the demo home page of the PHP Freedom Framework. This module is dedicated to demonstrations, if you have anything to add please contact us at info@phpfreedom.org. \r\n</p>\r\n<p>\r\nThank you. \r\n</p>\r\n', '', 'DEMO', 'DEMO', 0, '2009-09-02 17:04:13', '0000-00-00 00:00:00', '2009-09-07 17:35:27', 1),
(8, 'GENERAL', '', 'A brief employees profile', '', 'PARENT', 'PARENT', '', '', '&lt;p&gt;\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc imperdiet leo non justo vehicula nec tempus leo ultrices. Vivamus a cursus purus. Cras fermentum ligula in odio gravida sodales. Donec id leo ut nibh pharetra porttitor nec in ipsum. Morbi ullamcorper auctor bibendum. Maecenas ut nisi non quam imperdiet sagittis. Nam id sagittis ante. Vivamus quis magna sed ante feugiat pellentesque. Suspendisse vel lectus sem, nec auctor nisi. Proin tempor tortor at est iaculis sagittis. Morbi velit dolor, tincidunt in tincidunt sed. \n&lt;/p&gt;\n&lt;p&gt;\nVestibulum nec arcu. Vestibulum volutpat lacinia nibh vitae lacinia. Praesent vel accumsan metus. Aenean vitae ipsum in erat iaculis gravida sed in dui. Fusce imperdiet lectus ac nulla varius ornare consequat in diam. Integer ornare felis eleifend lacus adipiscing bibendum. Praesent suscipit lectus at eros euismod commodo. Quisque congue euismod nulla sit amet porta. Donec eget tortor arcu, et rhoncus velit. \n&lt;/p&gt;\n', '', 'DEMO_EMP', 'DEMO_EMP', 0, '2009-09-02 17:04:02', '0000-00-00 00:00:00', '2009-10-08 11:09:46', 1),
(9, 'GENERAL', '', 'My First Page', '', 'PARENT', 'PARENT', '', '', '&lt;p&gt;\r\nSed mollis blandit consectetur. Suspendisse malesuada ornare bibendum. In leo orci, interdum et sodales ut, imperdiet nec nisi. Aenean urna diam, consectetur eu consectetur non, luctus sed augue. Nulla eu justo et mi commodo eleifend at quis quam. Fusce rutrum pellentesque metus, id accumsan justo porttitor quis. Maecenas eget diam lacinia odio mattis rutrum vitae sed dolor. \r\n&lt;/p&gt;\r\n&lt;p&gt;\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent fringilla, nunc ut malesuada viverra, orci nunc varius augue, et tristique magna odio a magna. Ut cursus tristique suscipit. Morbi purus velit, interdum id lobortis vitae, suscipit vitae eros. Nulla volutpat magna diam. Nunc viverra ipsum porttitor neque dignissim sit amet vulputate augue consectetur. Fusce aliquam ornare dignissim. Suspendisse laoreet cursus rutrum. Fusce egestas urna eget odio porta consectetur. \r\n&lt;/p&gt;\r\n', 'YToxOntpOjA7YTo2OntzOjc6InN1Y2Nlc3MiO2I6MTtzOjg6InJlYWxuYW1lIjtzOjE1OiJfMTI1NTA3NDUwNy5naWYiO3M6ODoiZmlsZW5hbWUiO3M6MjY6Il8xMjU1MDgzOTU1XzU0MTc3ODdNMVIuZ2lmIjtzOjQ6InR5cGUiO3M6MzoiZ2lmIjtzOjQ6InNpemUiO2k6MjkwNztzOjU6ImxhYmVsIjtzOjExOiJMb3JlbSBJcHN1bSI7fX0=', 'FIRSTPAGE', 'FIRSTPAGE', 0, '2009-09-03 22:33:58', '0000-00-00 00:00:00', '2009-10-09 12:25:55', 1),
(10, 'GENERAL', '', 'First Section of My First Page', '', 'PARENT', 'PARENT', 'First Section', '', '&lt;p&gt;\r\nSed mollis blandit consectetur. Suspendisse malesuada ornare bibendum. In leo orci, interdum et sodales ut, imperdiet nec nisi. Aenean urna diam, consectetur eu consectetur non, luctus sed augue. Nulla eu justo et mi commodo eleifend at quis quam. Fusce rutrum pellentesque metus, id accumsan justo porttitor quis. Maecenas eget diam lacinia odio mattis rutrum vitae sed dolor. \r\n&lt;/p&gt;\r\n&lt;p&gt;\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent fringilla, nunc ut malesuada viverra, orci nunc varius augue, et tristique magna odio a magna. Ut cursus tristique suscipit. Morbi purus velit, interdum id lobortis vitae, suscipit vitae eros. Nulla volutpat magna diam. Nunc viverra ipsum porttitor neque dignissim sit amet vulputate augue consectetur. Fusce aliquam ornare dignissim. Suspendisse laoreet cursus rutrum. Fusce egestas urna eget odio porta consectetur. \r\n&lt;/p&gt;\r\n', 'YToxOntpOjA7YTo2OntzOjc6InN1Y2Nlc3MiO2I6MTtzOjg6InJlYWxuYW1lIjtzOjI2OiJfMTI1NTA4MzA2MV83VjI1MDgxWlY1LmdpZiI7czo4OiJmaWxlbmFtZSI7czoyNjoiXzEyNTUwODQ1ODBfSExZME0zMURLSy5naWYiO3M6NDoidHlwZSI7czozOiJnaWYiO3M6NDoic2l6ZSI7aToyOTA3O3M6NToibGFiZWwiO3M6MTE6IkxvcmVtIElwc3VtIjt9fQ==', 'FIRSTPAGE', 'FIRSTSECTION', 0, '2009-09-03 22:32:05', '0000-00-00 00:00:00', '2009-10-09 12:36:20', 1),
(11, 'GENERAL', '', 'Second Section of My First Page', '', 'PARENT', 'PARENT', 'Second Section', '', '&lt;p&gt;\r\nSed mollis blandit consectetur. Suspendisse malesuada ornare bibendum. In leo orci, interdum et sodales ut, imperdiet nec nisi. Aenean urna diam, consectetur eu consectetur non, luctus sed augue. Nulla eu justo et mi commodo eleifend at quis quam. Fusce rutrum pellentesque metus, id accumsan justo porttitor quis. Maecenas eget diam lacinia odio mattis rutrum vitae sed dolor. \r\n&lt;/p&gt;\r\n&lt;p&gt;\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent fringilla, nunc ut malesuada viverra, orci nunc varius augue, et tristique magna odio a magna. Ut cursus tristique suscipit. Morbi purus velit, interdum id lobortis vitae, suscipit vitae eros. Nulla volutpat magna diam. Nunc viverra ipsum porttitor neque dignissim sit amet vulputate augue consectetur. Fusce aliquam ornare dignissim. Suspendisse laoreet cursus rutrum. Fusce egestas urna eget odio porta consectetur. \r\n&lt;/p&gt;\r\n', 'YToxOntpOjA7YTo2OntzOjc6InN1Y2Nlc3MiO2I6MTtzOjg6InJlYWxuYW1lIjtzOjE1OiJfMTI1NTA3NDU5My5qcGciO3M6ODoiZmlsZW5hbWUiO3M6MjY6Il8xMjU1MDgzODkyX1AxMzFWMTg3TlYuanBnIjtzOjQ6InR5cGUiO3M6MzoianBnIjtzOjQ6InNpemUiO2k6MzE4NztzOjU6ImxhYmVsIjtzOjE2OiJTb21lb25lIGlzIGhhcHB5Ijt9fQ==', 'FIRSTPAGE', 'SECONDSECTION', 0, '2009-09-03 22:22:54', '0000-00-00 00:00:00', '2009-10-09 12:24:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `content_types`
--

DROP TABLE IF EXISTS `content_types`;
CREATE TABLE IF NOT EXISTS `content_types` (
  `content_type_id` int(3) NOT NULL AUTO_INCREMENT,
  `content_type_key` varchar(100) NOT NULL,
  `content_type_name` varchar(100) NOT NULL,
  `content_type_template` varchar(100) NOT NULL,
  `content_type_subtemplate` varchar(100) NOT NULL,
  `content_type_list_template` varchar(100) NOT NULL,
  `content_attach_ext` varchar(100) NOT NULL,
  `content_attach_size` int(11) NOT NULL,
  PRIMARY KEY (`content_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=3 ;

--
-- Dumping data for table `content_types`
--

INSERT INTO `content_types` (`content_type_id`, `content_type_key`, `content_type_name`, `content_type_template`, `content_type_subtemplate`, `content_type_list_template`, `content_attach_ext`, `content_attach_size`) VALUES
(1, 'NEWS', 'News', 'pages_horrizontalImgPage', 'pages_sections_full', 'pages_sections_list', 'gif,jpg,jpeg,doc,docx,pdf,ppt,pptx', 100000),
(2, 'GENERAL', 'General', 'pages_verticalBoxedImgPage', 'pages_sections_panes', 'pages_sections_list', 'gif,jpg,jpeg,doc,docx,pdf,ppt,pptx', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `demo_employees`
--

DROP TABLE IF EXISTS `demo_employees`;
CREATE TABLE IF NOT EXISTS `demo_employees` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_firstname` varchar(50) NOT NULL,
  `employee_lastname` varchar(50) NOT NULL,
  `employee_address` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`employee_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `demo_employees`
--

INSERT INTO `demo_employees` (`employee_id`, `employee_firstname`, `employee_lastname`, `employee_address`) VALUES
(1, 'Tomiwa', 'Adefokun', 'No 46, Colonel Asielue St.'),
(2, 'Mfon', 'Williams', '725, John Doe Drive.'),
(5, 'Joyce', 'Odiagbe', '50/52 Alphon Street.'),
(6, 'Victor', 'Adama', '71, Cement Drive.'),
(7, 'Bosun', 'Olaniyonu', 'No 4. Shogunle Layout.');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_name` varchar(100) NOT NULL,
  `fb_phone` varchar(100) NOT NULL,
  `fb_country` varchar(100) NOT NULL,
  `fb_state` varchar(100) NOT NULL,
  `fb_contact` text NOT NULL,
  `fb_email` varchar(150) NOT NULL,
  `fb_subject` varchar(150) NOT NULL,
  `fb_message` text NOT NULL,
  `fb_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`feedback_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`feedback_id`, `fb_name`, `fb_phone`, `fb_country`, `fb_state`, `fb_contact`, `fb_email`, `fb_subject`, `fb_message`, `fb_date`) VALUES
(1, 'Tomiwa Adefokun', '+234 805 305 0903', 'Nigeria', 'Lagos', '50/52 Alphon House,\r\nToyin Street, Ikeja\r\nLagos', 'tomiwa.adefokun@gmail.vom', 'Hope you are loving freedom', 'Hello friend,\r\n\r\nHope you are enjoying the PHP Freedom Framework, thank you for choosing it... with you we hope to do more.\r\n\r\nADEFOKUN Tomiwa Michael', '2009-05-08 12:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(2) NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(2) NOT NULL,
  `text` varchar(20) NOT NULL,
  `href` varchar(100) DEFAULT 'javascript:void(0);',
  `menu_order` int(2) NOT NULL DEFAULT '0',
  `role_id` varchar(20) NOT NULL,
  `link_is_external` tinyint(1) NOT NULL DEFAULT '0',
  `link_target` varchar(20) NOT NULL DEFAULT '',
  `top_nav_yn` tinyint(1) NOT NULL DEFAULT '0',
  `use_ajax` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `parent_id`, `text`, `href`, `menu_order`, `role_id`, `link_is_external`, `link_target`, `top_nav_yn`, `use_ajax`) VALUES
(1, 0, 'Home', 'index', 0, '', 0, '', 0, 0),
(2, 0, 'Login', 'index/login', 100, '0', 0, '', 1, 0),
(3, 0, 'Logout', 'index/login/logout', 100, '1,2', 0, '', 1, 0),
(4, 0, 'Administrator', 'javascript:void(0);', 1, '1', 1, '', 0, 0),
(5, 4, 'Manage Menu', 'admin/menu', 0, '1', 0, '', 0, 0),
(6, 4, 'Manage Users', 'admin/users', 0, '1', 0, '', 0, 0),
(7, 4, 'Manage Roles', 'admin/roles', 0, '1', 0, '', 0, 0),
(8, 4, 'Security Setup', 'admin/security', 0, '1', 0, '', 0, 0),
(9, 4, 'Content Types', 'admin/ctype', 0, '1', 0, '', 0, 0),
(10, 4, 'Content Manager', 'admin/content', 0, '1', 0, '', 0, 0),
(11, 4, 'User Feedbacks', 'index/feedbacks', 0, '1', 0, '', 0, 0),
(12, 0, 'Contact Us', 'index/feedbacks/contact', 15, '', 0, '', 1, 0),
(13, 0, 'News', 'index/groups/?group=news', 10, '', 0, '', 0, 0),
(14, 0, 'Live Chat Support', 'index/pages/display/?page=support', 20, '', 0, '', 1, 0),
(15, 4, 'E-Support setup', 'http://www.e-supportsystems.com', 0, '1', 1, '_blank', 0, 0),
(17, 0, 'Project Demo', 'demo', 0, '', 0, '', 1, 0),
(18, 17, 'Employees Manager', 'demo/employees', 0, '', 0, '', 0, 0),
(19, 17, 'Using Blocks', 'demo/index/blocks', 0, '', 0, '', 0, 0),
(20, 17, 'First Page', 'index/pages/display/?page=firstpage', 0, '', 0, '', 0, 0),
(21, 17, 'First Page - Ajax', 'index/pages/?page=firstpage', 0, '', 0, '', 0, 1),
(22, 17, 'Using Blocks - Ajax', 'demo/index/blocks', 0, '', 0, '', 0, 1),
(23, 17, 'Tabbed Panes', 'demo/index/tabbedpanes', 0, '', 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_role` int(2) NOT NULL DEFAULT '0',
  `email_address` varchar(100) NOT NULL,
  `security_question` varchar(100) NOT NULL,
  `security_answer` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `username`, `password`, `user_role`, `email_address`, `security_question`, `security_answer`) VALUES
(1, 'Administrator', 'System', 'administrator', '200ceb26807d6bf99fd6f4f0d1ca54d4', 1, 'admin@sitename.com', 'Who is the project founder?', 'Tomiwa Adefokun');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `role_id` int(2) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL,
  `role_key` smallint(2) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`role_id`, `role_name`, `role_key`) VALUES
(1, 'Admin', 1),
(2, 'Ordinary User', 0),
(3, 'Members', 2);
