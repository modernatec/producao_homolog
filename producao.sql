-- phpMyAdmin SQL Dump
-- version 3.5.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 15, 2013 at 08:51 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `producao`
--

-- --------------------------------------------------------

--
-- Table structure for table `moderna_countries`
--

CREATE TABLE IF NOT EXISTS `moderna_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `moderna_countries`
--

INSERT INTO `moderna_countries` (`id`, `nome`) VALUES
(1, 'Brasil'),
(2, 'Espanha'),
(3, 'Argentina');

-- --------------------------------------------------------

--
-- Table structure for table `moderna_curriculums`
--

CREATE TABLE IF NOT EXISTS `moderna_curriculums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `objective` varchar(45) DEFAULT NULL,
  `description` text,
  `formado` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `moderna_curriculums`
--

INSERT INTO `moderna_curriculums` (`id`, `name`, `objective`, `description`, `formado`) VALUES
(32, 'Roberto', 'Programador', 'Teste 2333', '1');

-- --------------------------------------------------------

--
-- Table structure for table `moderna_files`
--

CREATE TABLE IF NOT EXISTS `moderna_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uri` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `model_id` int(11) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `size` varchar(45) DEFAULT NULL,
  `userInfo_id` int(11) NOT NULL,
  `model` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `model` (`model`),
  KEY `userInfo_id` (`userInfo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `moderna_files`
--

INSERT INTO `moderna_files` (`id`, `uri`, `created_at`, `model_id`, `mime_type`, `size`, `userInfo_id`, `model`) VALUES
(4, 'public/upload/curriculum/Chrysanthemum.jpg', '2013-02-05 19:52:25', 32, 'application/octet-stream', '879394', 4, 'curriculum'),
(5, 'public/upload/curriculum/form_1360095520.txt', '2013-02-05 20:18:45', 32, 'text/plain', '1317', 4, 'curriculum'),
(6, 'public/upload/curriculumDesert.jpg', '2013-02-07 16:44:17', 7, 'application/octet-stream', '845941', 4, 'task'),
(7, 'public/upload/curriculumKoala.jpg', '2013-02-07 17:50:30', 8, 'application/octet-stream', '780831', 4, 'task'),
(8, 'public/upload/curriculumPenguins.jpg', '2013-02-07 18:20:07', 9, 'application/octet-stream', '777835', 4, 'task'),
(9, 'public/upload/curriculumTulips.jpg', '2013-02-07 19:19:13', 14, 'application/octet-stream', '620888', 11, 'task'),
(10, 'public/upload/curriculummapa_brasil.eps', '2013-02-07 19:54:38', 16, 'application/octet-stream', '881870', 11, 'task'),
(11, 'public/upload/curriculumDesert.jpg', '2013-02-08 11:28:34', 19, 'application/octet-stream', '845941', 4, 'task'),
(12, 'public/upload/medias/liberacao_tablet_1360936416.txt', '2013-02-15 13:54:05', 1, 'text/plain', '1842', 4, 'media');

-- --------------------------------------------------------

--
-- Table structure for table `moderna_materias`
--

CREATE TABLE IF NOT EXISTS `moderna_materias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `moderna_materias`
--

INSERT INTO `moderna_materias` (`id`, `nome`) VALUES
(1, 'Matemática'),
(2, 'Português');

-- --------------------------------------------------------

--
-- Table structure for table `moderna_media`
--

CREATE TABLE IF NOT EXISTS `moderna_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userInfo_id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userInfo_id` (`userInfo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `moderna_media`
--

INSERT INTO `moderna_media` (`id`, `userInfo_id`, `tag`, `created_at`) VALUES
(1, 4, 'PNLD 2015', '2013-02-15 13:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `moderna_menus`
--

CREATE TABLE IF NOT EXISTS `moderna_menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `display` varchar(45) DEFAULT NULL,
  `link` varchar(45) DEFAULT NULL,
  `ordem` tinyint(4) NOT NULL,
  `sub` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `moderna_menus`
--

INSERT INTO `moderna_menus` (`id`, `display`, `link`, `ordem`, `sub`) VALUES
(1, 'Projetos', 'admin/projects', 0, 0),
(2, 'Tarefas', 'admin/tasks', 1, 0),
(3, 'Relatórios', 'admin/relatorios', 6, 0),
(4, 'Usuários', 'admin/users', 5, 0),
(5, 'Fornecedores', 'admin/suppliers', 4, 0),
(6, 'Equipes', 'admin/teams', 0, 4),
(7, 'Arquivos comuns', 'admin/medias', 7, 0),
(8, 'Curriculums', 'admin/curriculums', 3, 0),
(9, 'Catálogo', 'admin/objects', 2, 0),
(10, 'Tipos de Objetos', 'admin/typeobjects', 0, 9),
(11, 'Segmentos', 'admin/segmentos', 0, 9),
(12, 'Software de Produção', 'admin/sfwprods', 0, 9),
(13, 'Países', 'admin/countries', 0, 9),
(14, 'Matérias', 'admin/materias', 0, 9);

-- --------------------------------------------------------

--
-- Table structure for table `moderna_menus_roles`
--

CREATE TABLE IF NOT EXISTS `moderna_menus_roles` (
  `menu_id` int(11) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`menu_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `moderna_menus_roles`
--

INSERT INTO `moderna_menus_roles` (`menu_id`, `role_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(2, 3),
(4, 3),
(5, 3),
(7, 3),
(8, 3),
(9, 3),
(2, 4),
(7, 4),
(9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `moderna_objects`
--

CREATE TABLE IF NOT EXISTS `moderna_objects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_obj` varchar(100) NOT NULL,
  `nome_arq` varchar(500) NOT NULL,
  `typeobject_id` int(11) NOT NULL,
  `colecao` varchar(100) NOT NULL,
  `segmento_id` int(11) NOT NULL,
  `arq_aberto` tinyint(4) NOT NULL,
  `extensao_arq` varchar(45) NOT NULL,
  `interatividade` tinyint(4) NOT NULL,
  `empresa` varchar(45) NOT NULL,
  `data_lancamento` date DEFAULT NULL,
  `sinopse` varchar(255) DEFAULT NULL,
  `obs` text,
  `objectpai_id` int(11) DEFAULT '0',
  `country_id` int(11) NOT NULL,
  `data_ins` datetime NOT NULL,
  `data_alt` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_obj_fk_idx` (`typeobject_id`),
  KEY `segmento_fk_idx` (`segmento_id`),
  KEY `cmp_pais_fk_idx` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `moderna_objects_materias`
--

CREATE TABLE IF NOT EXISTS `moderna_objects_materias` (
  `object_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  KEY `object_id` (`object_id`),
  KEY `materia_id` (`materia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moderna_objects_sfwprods`
--

CREATE TABLE IF NOT EXISTS `moderna_objects_sfwprods` (
  `object_id` int(11) NOT NULL,
  `sfwprod_id` int(11) NOT NULL,
  KEY `object_id` (`object_id`),
  KEY `sfwprod_id` (`sfwprod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moderna_objects_suppliers`
--

CREATE TABLE IF NOT EXISTS `moderna_objects_suppliers` (
  `object_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  KEY `object_id` (`object_id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moderna_priorities`
--

CREATE TABLE IF NOT EXISTS `moderna_priorities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `priority` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `moderna_priorities`
--

INSERT INTO `moderna_priorities` (`id`, `priority`) VALUES
(1, 'Alta'),
(2, 'Média'),
(3, 'Baixa');

-- --------------------------------------------------------

--
-- Table structure for table `moderna_projects`
--

CREATE TABLE IF NOT EXISTS `moderna_projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `segmento_id` int(11) DEFAULT NULL,
  `description` text,
  `pasta` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `segmento_id` (`segmento_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `moderna_projects`
--

INSERT INTO `moderna_projects` (`id`, `name`, `segmento_id`, `description`, `pasta`) VALUES
(2, 'PNLD 2015', 1, 'OED''s em HTML5', 'pnld_2015'),
(3, 'Araribá', 1, 'dfadfa', 'arariba');

-- --------------------------------------------------------

--
-- Table structure for table `moderna_roles`
--

CREATE TABLE IF NOT EXISTS `moderna_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `moderna_roles`
--

INSERT INTO `moderna_roles` (`id`, `name`, `description`) VALUES
(1, 'login', NULL),
(2, 'admin', NULL),
(3, 'coordenador', NULL),
(4, 'assistente', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `moderna_roles_users`
--

CREATE TABLE IF NOT EXISTS `moderna_roles_users` (
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `fk_moderna_roles_has_moderna_users_moderna_users1` (`user_id`),
  KEY `fk_moderna_roles_has_moderna_users_moderna_roles1` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moderna_roles_users`
--

INSERT INTO `moderna_roles_users` (`role_id`, `user_id`) VALUES
(1, 3),
(2, 3),
(3, 3),
(1, 7),
(4, 7),
(1, 8),
(4, 8),
(1, 9),
(3, 9),
(1, 10),
(3, 10),
(1, 11),
(3, 11),
(1, 12),
(4, 12),
(1, 16),
(4, 16);

-- --------------------------------------------------------

--
-- Table structure for table `moderna_segmentos`
--

CREATE TABLE IF NOT EXISTS `moderna_segmentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `moderna_segmentos`
--

INSERT INTO `moderna_segmentos` (`id`, `nome`) VALUES
(1, 'Ensino médio'),
(2, 'Fundamental 1'),
(3, 'Fundamental 2');

-- --------------------------------------------------------

--
-- Table structure for table `moderna_sfwprods`
--

CREATE TABLE IF NOT EXISTS `moderna_sfwprods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `moderna_sfwprods`
--

INSERT INTO `moderna_sfwprods` (`id`, `nome`) VALUES
(1, 'Flash CS5'),
(2, 'After Effects CS5');

-- --------------------------------------------------------

--
-- Table structure for table `moderna_status`
--

CREATE TABLE IF NOT EXISTS `moderna_status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `moderna_status`
--

INSERT INTO `moderna_status` (`id`, `status`) VALUES
(5, 'Aguardando'),
(6, 'Encaminhada'),
(7, 'Concluída');

-- --------------------------------------------------------

--
-- Table structure for table `moderna_status_tasks`
--

CREATE TABLE IF NOT EXISTS `moderna_status_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) unsigned NOT NULL,
  `task_id` int(11) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text,
  `userInfo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`status_id`,`task_id`,`userInfo_id`),
  KEY `task_id` (`task_id`),
  KEY `status_id` (`status_id`),
  KEY `userInfo_id` (`userInfo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `moderna_suppliers`
--

CREATE TABLE IF NOT EXISTS `moderna_suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(10) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `site` varchar(100) DEFAULT NULL,
  `trabalho` varchar(150) NOT NULL,
  `observacoes` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `moderna_suppliers`
--

INSERT INTO `moderna_suppliers` (`id`, `nome`, `email`, `telefone`, `empresa`, `site`, `trabalho`, `observacoes`) VALUES
(1, 'Talles', 'talles@cpc.com.br', '3058-2244', 'CPC', 'www.cpc.com.br', 'Flash / Vídeo', ''),
(2, 'Zé Ricardo', 'zericardo@vexprodutora.com.br', '2659-5905', 'Vex produtora', 'www.vexprodutora.com.br', 'Vídeo', 'Produziu os vídeos de autor - Araribá 2011');

-- --------------------------------------------------------

--
-- Table structure for table `moderna_tasks`
--

CREATE TABLE IF NOT EXISTS `moderna_tasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `priority_id` int(11) unsigned NOT NULL,
  `project_id` int(11) unsigned NOT NULL,
  `crono_date` datetime DEFAULT NULL,
  `userInfo_id` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `pasta` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`,`priority_id`,`project_id`,`userInfo_id`),
  KEY `fk_moderna_tasks_moderna_users1` (`userInfo_id`),
  KEY `priority_id` (`priority_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `moderna_tasks_users`
--

CREATE TABLE IF NOT EXISTS `moderna_tasks_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) unsigned NOT NULL,
  `userInfo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`task_id`,`userInfo_id`),
  KEY `task_id` (`task_id`),
  KEY `userInfo_id` (`userInfo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `moderna_teams`
--

CREATE TABLE IF NOT EXISTS `moderna_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `userInfo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `user_id` (`userInfo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `moderna_teams`
--

INSERT INTO `moderna_teams` (`id`, `name`, `userInfo_id`) VALUES
(1, 'Produção', 4),
(3, 'Arte', 11),
(4, 'Conteúdo', 10),
(5, 'Iconográfia', 12);

-- --------------------------------------------------------

--
-- Table structure for table `moderna_typeobjects`
--

CREATE TABLE IF NOT EXISTS `moderna_typeobjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `moderna_typeobjects`
--

INSERT INTO `moderna_typeobjects` (`id`, `nome`) VALUES
(1, 'Animação'),
(2, 'Mapa animado'),
(3, 'Mapa interativo');

-- --------------------------------------------------------

--
-- Table structure for table `moderna_userinfos`
--

CREATE TABLE IF NOT EXISTS `moderna_userinfos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'public/image/admin/default.png',
  `data_aniversario` date DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `team_id` int(11) NOT NULL,
  `ramal` varchar(45) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `mailer` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `moderna_userinfos`
--

INSERT INTO `moderna_userinfos` (`id`, `nome`, `email`, `foto`, `data_aniversario`, `user_id`, `team_id`, `ramal`, `telefone`, `mailer`) VALUES
(4, 'Roberto', 'roberto.ono@moderna.com.br', 'public/image/admin/default.png', '2000-10-19', 3, 1, '1330', '2790-1330', 1),
(8, 'Ana', 'editorial_tec22@moderna.com.br', 'public/upload/userinfos/penguins_1359665367.jpg', '2000-01-16', 7, 1, '2435', '', 1),
(9, 'Renato', 'renato.rocha@moderna.com.br', 'public/upload/userinfos/desert_1358364620.jpg', NULL, 8, 1, '2483', '', 1),
(10, 'Luciana', 'editorial_tec18@moderna.com.br', 'public/image/admin/default.png', NULL, 9, 4, '2168', '', 1),
(11, 'Fabio Ventura', 'fabio.ventura@moderna.com.br', 'public/image/admin/default.png', NULL, 10, 3, '', '', 1),
(12, 'Renate', '', 'public/image/admin/default.png', NULL, 11, 5, '', '', 1),
(13, 'Eduardo Bertolini', '', 'public/image/admin/default.png', NULL, 12, 3, '2180', '', 1),
(17, 'Renata Michelin', '', 'public/image/admin/default.png', NULL, 16, 1, '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `moderna_users`
--

CREATE TABLE IF NOT EXISTS `moderna_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) CHARACTER SET latin1 NOT NULL,
  `password` varchar(64) CHARACTER SET latin1 NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `moderna_users`
--

INSERT INTO `moderna_users` (`id`, `username`, `password`, `logins`, `last_login`) VALUES
(3, 'roberto.ono', '165bbc63336c60ac8e5246c8f11c9616863925c3', 32, 1360941068),
(7, 'ana.totaro', '165bbc63336c60ac8e5246c8f11c9616863925c3', 15, 1360266542),
(8, 'renato.rocha', '165bbc63336c60ac8e5246c8f11c9616863925c3', 4, 1358364901),
(9, 'luciana.soares', '165bbc63336c60ac8e5246c8f11c9616863925c3', 0, NULL),
(10, 'fabio.ventura', '165bbc63336c60ac8e5246c8f11c9616863925c3', 6, 1360324838),
(11, 'renate', '165bbc63336c60ac8e5246c8f11c9616863925c3', 0, NULL),
(12, 'eduardo.bertolini', '165bbc63336c60ac8e5246c8f11c9616863925c3', 4, 1360325596),
(16, 'renata.michelin', '165bbc63336c60ac8e5246c8f11c9616863925c3', 0, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `moderna_files`
--
ALTER TABLE `moderna_files`
  ADD CONSTRAINT `moderna_files_ibfk_1` FOREIGN KEY (`userInfo_id`) REFERENCES `moderna_userinfos` (`id`);

--
-- Constraints for table `moderna_media`
--
ALTER TABLE `moderna_media`
  ADD CONSTRAINT `moderna_media_ibfk_1` FOREIGN KEY (`userInfo_id`) REFERENCES `moderna_userinfos` (`id`);

--
-- Constraints for table `moderna_menus_roles`
--
ALTER TABLE `moderna_menus_roles`
  ADD CONSTRAINT `moderna_menus_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `moderna_roles` (`id`),
  ADD CONSTRAINT `moderna_menus_roles_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `moderna_menus` (`id`);

--
-- Constraints for table `moderna_objects`
--
ALTER TABLE `moderna_objects`
  ADD CONSTRAINT `cmp_pais_fk` FOREIGN KEY (`country_id`) REFERENCES `moderna_countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `segmento_fk` FOREIGN KEY (`segmento_id`) REFERENCES `moderna_segmentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tipo_obj_fk` FOREIGN KEY (`typeobject_id`) REFERENCES `moderna_typeobjects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `moderna_objects_materias`
--
ALTER TABLE `moderna_objects_materias`
  ADD CONSTRAINT `moderna_objects_materias_ibfk_1` FOREIGN KEY (`object_id`) REFERENCES `moderna_objects` (`id`),
  ADD CONSTRAINT `moderna_objects_materias_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `moderna_materias` (`id`);

--
-- Constraints for table `moderna_objects_sfwprods`
--
ALTER TABLE `moderna_objects_sfwprods`
  ADD CONSTRAINT `moderna_objects_sfwprods_ibfk_1` FOREIGN KEY (`object_id`) REFERENCES `moderna_objects` (`id`),
  ADD CONSTRAINT `moderna_objects_sfwprods_ibfk_2` FOREIGN KEY (`sfwprod_id`) REFERENCES `moderna_sfwprods` (`id`);

--
-- Constraints for table `moderna_objects_suppliers`
--
ALTER TABLE `moderna_objects_suppliers`
  ADD CONSTRAINT `moderna_objects_suppliers_ibfk_1` FOREIGN KEY (`object_id`) REFERENCES `moderna_objects` (`id`),
  ADD CONSTRAINT `moderna_objects_suppliers_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `moderna_suppliers` (`id`);

--
-- Constraints for table `moderna_projects`
--
ALTER TABLE `moderna_projects`
  ADD CONSTRAINT `moderna_projects_ibfk_1` FOREIGN KEY (`segmento_id`) REFERENCES `moderna_segmentos` (`id`);

--
-- Constraints for table `moderna_roles_users`
--
ALTER TABLE `moderna_roles_users`
  ADD CONSTRAINT `fk_moderna_roles_has_moderna_users_moderna_roles1` FOREIGN KEY (`role_id`) REFERENCES `moderna_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `moderna_roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `moderna_users` (`id`);

--
-- Constraints for table `moderna_status_tasks`
--
ALTER TABLE `moderna_status_tasks`
  ADD CONSTRAINT `moderna_status_tasks_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `moderna_tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `moderna_status_tasks_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `moderna_status` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `moderna_status_tasks_ibfk_5` FOREIGN KEY (`userInfo_id`) REFERENCES `moderna_userinfos` (`id`);

--
-- Constraints for table `moderna_tasks`
--
ALTER TABLE `moderna_tasks`
  ADD CONSTRAINT `moderna_tasks_ibfk_1` FOREIGN KEY (`priority_id`) REFERENCES `moderna_priorities` (`id`),
  ADD CONSTRAINT `moderna_tasks_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `moderna_projects` (`id`),
  ADD CONSTRAINT `moderna_tasks_ibfk_3` FOREIGN KEY (`userInfo_id`) REFERENCES `moderna_userinfos` (`id`);

--
-- Constraints for table `moderna_tasks_users`
--
ALTER TABLE `moderna_tasks_users`
  ADD CONSTRAINT `moderna_tasks_users_ibfk_3` FOREIGN KEY (`task_id`) REFERENCES `moderna_tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `moderna_tasks_users_ibfk_4` FOREIGN KEY (`userInfo_id`) REFERENCES `moderna_userinfos` (`id`);

--
-- Constraints for table `moderna_teams`
--
ALTER TABLE `moderna_teams`
  ADD CONSTRAINT `moderna_teams_ibfk_1` FOREIGN KEY (`userInfo_id`) REFERENCES `moderna_userinfos` (`id`);

--
-- Constraints for table `moderna_userinfos`
--
ALTER TABLE `moderna_userinfos`
  ADD CONSTRAINT `moderna_userinfos_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `moderna_users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
