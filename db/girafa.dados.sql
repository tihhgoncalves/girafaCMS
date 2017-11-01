-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 01-Nov-2017 às 16:09
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `girafa`
--

--
-- Extraindo dados da tabela `sis_grupos`
--

INSERT INTO `sis_grupos` (`ID`, `Lang`, `Name`, `LastUpdate`, `LastUserName`) VALUES
(1, 'pt-br', 'Administradores', '2011-10-06 15:28:51', 'Instalador CMS'),
(2, 'pt-br', 'Redatores', '2011-10-06 21:29:37', 'Instalador CMS'),
(3, 'pt-br', 'Gerentes', '2011-10-06 21:29:37', 'Instalador CMS');

--
-- Extraindo dados da tabela `sis_idiomas`
--

INSERT INTO `sis_idiomas` (`ID`, `Lang`, `LastUpdate`, `LastUserName`, `Nome`, `Identificador`) VALUES
(1, NULL, NULL, NULL, 'Português (Brasil)', 'pt-br'),
(2, NULL, NULL, NULL, 'Africâner', 'af'),
(3, NULL, NULL, NULL, 'Amárico', 'am'),
(4, NULL, NULL, NULL, 'Árabe', 'ar'),
(5, NULL, NULL, NULL, 'Búlgaro', 'bg'),
(6, NULL, NULL, NULL, 'Bengali', 'bn'),
(7, NULL, NULL, NULL, 'Catalão', 'ca'),
(8, NULL, NULL, NULL, 'Tcheco', 'cs'),
(9, NULL, NULL, NULL, 'Dinamarquês', 'da'),
(10, NULL, NULL, NULL, 'Alemão', 'de'),
(11, NULL, NULL, NULL, 'Grego', 'el'),
(12, NULL, NULL, NULL, 'Inglês (Reino Unido)', 'en-gb'),
(13, NULL, NULL, NULL, 'Espanhol', 'es'),
(14, NULL, NULL, NULL, 'Estoniano', 'et'),
(15, NULL, NULL, NULL, 'Basco', 'eu'),
(16, NULL, NULL, NULL, 'Persa', 'fa'),
(17, NULL, NULL, NULL, 'Finlandês', 'fi'),
(18, NULL, NULL, NULL, 'Filipino', 'fil'),
(19, NULL, NULL, NULL, 'Francês (França)', 'fr'),
(20, NULL, NULL, NULL, 'Francês (Canadá)', 'fr-ca'),
(21, NULL, NULL, NULL, 'Galego', 'gl'),
(22, NULL, NULL, NULL, 'Guzerate', 'gu'),
(23, NULL, NULL, NULL, 'Híndi', 'hi'),
(24, NULL, NULL, NULL, 'Croata', 'hr'),
(25, NULL, NULL, NULL, 'Húngaro', 'hu'),
(26, NULL, NULL, NULL, 'Indonésio', 'id'),
(27, NULL, NULL, NULL, 'Islandês', 'is'),
(28, NULL, NULL, NULL, 'Italiano', 'it'),
(29, NULL, NULL, NULL, 'Hebraico', 'iw'),
(30, NULL, NULL, NULL, 'Japonês', 'ja'),
(31, NULL, NULL, NULL, 'Canarês', 'kn'),
(32, NULL, NULL, NULL, 'Coreano', 'ko'),
(33, NULL, NULL, NULL, 'Lituano', 'lt'),
(34, NULL, NULL, NULL, 'Letão', 'lv'),
(35, NULL, NULL, NULL, 'Malaiala', 'ml'),
(36, NULL, NULL, NULL, 'Marata', 'mr'),
(37, NULL, NULL, NULL, 'Malaio', 'ms'),
(38, NULL, NULL, NULL, 'Holandês', 'nl'),
(39, NULL, NULL, NULL, 'Norueguês', 'no'),
(40, NULL, NULL, NULL, 'polonês', 'pl'),
(41, NULL, NULL, NULL, 'Português', 'pt-pt'),
(42, NULL, NULL, NULL, 'Romeno', 'ro'),
(43, NULL, NULL, NULL, 'Russo', 'ru'),
(44, NULL, NULL, NULL, 'Eslovaco', 'sk'),
(45, NULL, NULL, NULL, 'Esloveno', 'sl'),
(46, NULL, NULL, NULL, 'Sérvio', 'sr'),
(47, NULL, NULL, NULL, 'Sueco', 'sv'),
(48, NULL, NULL, NULL, 'Suaili', 'sw'),
(49, NULL, NULL, NULL, 'Tâmil', 'ta'),
(50, NULL, NULL, NULL, 'Telugu', 'te'),
(51, NULL, NULL, NULL, 'Tailandês', 'th'),
(52, NULL, NULL, NULL, 'Turco', 'tr'),
(53, NULL, NULL, NULL, 'Ucraniano', 'uk'),
(54, NULL, NULL, NULL, 'Urdu', 'ur'),
(56, NULL, NULL, NULL, 'Vietnamita', 'vi'),
(57, NULL, NULL, NULL, 'Chinês (Han simplificado)', 'zh-cn'),
(58, NULL, NULL, NULL, 'Chinês (Hong Kong)', 'zh-hk'),
(59, NULL, NULL, NULL, 'Chinês (Han tradicional)', 'zh'),
(60, NULL, NULL, NULL, 'Zulu', 'zu'),
(61, NULL, NULL, NULL, 'Inglês (Estados Unidos)', 'en');

--
-- Extraindo dados da tabela `sis_modulos`
--

INSERT INTO `sis_modulos` (`ID`, `Lang`, `Name`, `Path`, `Actived`, `LastUpdate`, `LastUserName`, `Description`, `Developer`, `Icon`) VALUES
(1, 'pt-br', 'Aplicação', 'aplicacoes', 'Y', '2013-06-11 10:15:15', 'Instalador CMS', 'Módulo responsável pela configuração do Sistema', 'Y', 'fa-microchip'),
(2, 'pt-br', 'Usuários', 'usuarios', 'Y', '2013-06-11 10:15:15', 'Instalador CMS', 'Módulo responsável pela administração de Usuários', 'Y', 'fa-users'),
(3, 'pt-br', 'Parâmetros', 'parametros', 'Y', '2013-09-24 13:36:18', 'Instalador CMS', 'Cadastro de Parâmetros', NULL, 'fa-sliders'),
(4, 'pt-br', 'Cache', 'cache', 'Y', '2015-08-13 11:00:00', 'Instalador CMS', 'Controle de Cache', NULL, 'fa-archive');

--
-- Extraindo dados da tabela `sis_modulos_grupos`
--

INSERT INTO `sis_modulos_grupos` (`ID`, `Lang`, `LastUpdate`, `LastUserName`, `Module`, `Group`) VALUES
(1, 'pt-br', '2013-06-11 10:15:14', 'Instalador CMS', 1, 1),
(2, 'pt-br', '2013-06-11 10:15:14', 'Instalador CMS', 2, 1),
(3, 'pt-br', '2013-06-11 10:15:14', 'Instalador CMS', 2, 3),
(4, 'pt-br', '2013-06-11 10:15:14', 'Instalador CMS', 3, 1),
(5, 'pt-br', '2013-06-11 10:15:14', 'Instalador CMS', 3, 3),
(6, 'pt-br', '2013-06-11 10:15:14', 'Instalador CMS', 4, 3);

--
-- Extraindo dados da tabela `sis_modulos_idiomas`
--

INSERT INTO `sis_modulos_idiomas` (`ID`, `Lang`, `LastUpdate`, `LastUserName`, `Modulo`, `Idioma`) VALUES
(1, NULL, '2013-10-18 17:49:02', 'Instalador CMS', 1, 1),
(2, NULL, '2013-10-18 17:49:02', 'Instalador CMS', 2, 1),
(3, NULL, '2013-10-18 17:49:02', 'Instalador CMS', 3, 1),
(4, NULL, '2013-10-18 17:49:02', 'Instalador CMS', 4, 1);

--
-- Extraindo dados da tabela `sis_pastas`
--

INSERT INTO `sis_pastas` (`ID`, `Lang`, `Module`, `Name`, `Order`, `File`, `Grouper`, `Actived`, `MultiLanguages`, `CounterSQL`, `LastUpdate`, `LastUserName`) VALUES
(2, 'pt-br', 1, 'Módulos', 20, 'admin.modules.grid.php', 'Organização', 'Y', 'N', NULL, '2010-11-05 14:33:43', 'Instalador CMS'),
(3, 'pt-br', 1, 'Usuários', 30, 'admin.security.users.grid.php', 'Segurança', 'Y', 'N', NULL, '2010-11-05 14:33:43', 'Instalador CMS'),
(4, 'pt-br', 1, 'Grupos', 40, 'admin.security.groups.grid.php', 'Segurança', 'Y', 'N', NULL, '2010-11-05 14:33:43', 'Instalador CMS'),
(5, 'pt-br', 1, 'Ações de Usuários', 50, 'admin.security.logs.grid.php', 'Segurança', 'Y', 'N', NULL, '2010-11-05 14:33:43', 'Instalador CMS'),
(6, 'pt-br', 1, 'Plugins', 30, 'admin.plugins.grid.php', 'Organização', 'Y', 'N', NULL, '2013-06-17 17:53:18', 'Instalador CMS'),
(7, 'pt-br', 2, 'Usuários', 10, 'admin.usuarios.grid.php', 'Geral', 'Y', 'N', NULL, '2013-06-17 17:53:18', 'Instalador CMS'),
(8, 'pt-br', 2, 'Grupos', 20, 'admin.grupos.grid.php', 'Geral', 'Y', 'N', NULL, '2013-06-17 17:53:18', 'Instalador CMS'),
(9, 'pt-br', 1, 'Parâmetros', 20, 'admin.params.grid.php', 'Banco de Dados', 'Y', 'N', NULL, '2013-09-24 13:26:08', 'Instalador CMS'),
(10, 'pt-br', 3, 'Do CMS', 20, 'admin.params.cms.php', 'Geral', 'Y', 'N', NULL, '2013-09-24 14:26:31', 'Instalador CMS'),
(12, 'pt-br', 4, 'Cache', 10, 'index.php', 'Geral', 'Y', 'N', NULL, '2013-09-24 14:26:31', 'Instalador CMS');

--
-- Extraindo dados da tabela `sis_usuarios`
--

INSERT INTO `sis_usuarios` (`ID`, `Lang`, `Name`, `Mail`, `Password`, `Group`, `LastAccess`, `LastUpdate`, `LastUserName`, `Developer`, `Actived`) VALUES
(1, 'pt-br', 'Admin', 'teste@teste.com.br', '698dc19d489c4e4db73e28a713eab07b', 1, '2013-06-13 10:19:05', '2012-12-13 08:17:03', 'Instalador CMS', 'Y', 'Y');

--
-- Extraindo dados da tabela `sis_usuarios_grupos`
--

INSERT INTO `sis_usuarios_grupos` (`ID`, `Lang`, `LastUpdate`, `LastUserName`, `User`, `Group`) VALUES
(1, 'pt-br', '2012-12-13 08:17:03', 'Instalador CMS', 1, 1),
(2, 'pt-br', '2012-12-13 08:17:03', 'Instalador CMS', 1, 2),
(3, 'pt-br', '2012-12-13 08:17:03', 'Instalador CMS', 1, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
