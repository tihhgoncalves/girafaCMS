-- ------------------------------------------------------------
-- ------------------------------------------------------------
-- Estrutura de Instalação do CMS GIRAFA
-- Versão do sistema:
-- 2.0.0.b6
-- ------------------------------------------------------------
-- ------------------------------------------------------------

-- Estrutura da tabela `sysAdminGroups`
--

CREATE TABLE `sysAdminGroups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Grupo de Segurança do Administrator' AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `sysAdminGroups`
--

INSERT INTO `sysAdminGroups` (`ID`, `Name`, `LastUpdate`, `LastUserName`, `Lang`) VALUES
(1, 'Administradores', '2011-10-06 15:28:51','Instalador CMS', 'pt-br'),
(2, 'Redatores', '2011-10-06 21:29:37','Instalador CMS', 'pt-br'),
(3, 'Gerentes', '2011-10-06 21:29:37','Instalador CMS', 'pt-br');

-- ------------------------------------------------------------

--
-- Estrutura da tabela `sysAdminUsers`
--

CREATE TABLE `sysAdminUsers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Mail` varchar(30) DEFAULT NULL,
  `Password` char(32) DEFAULT NULL,
  `Group` int(11) DEFAULT NULL,
  `LastAccess` datetime DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(100) DEFAULT NULL,
  `Developer` char(1) DEFAULT NULL,
  `Actived` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_sysadminusers_group` (`Group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Usuários do Administrator' AUTO_INCREMENT=1 ;

INSERT INTO `sysAdminUsers` (`ID`, `Name`, `Mail`, `Password`, `Group`, `LastAccess`, `LastUpdate`, `LastUserName`, `Developer`, `Actived`, `Lang`) VALUES
(1, 'Admin', 'teste@teste.com.br', '698dc19d489c4e4db73e28a713eab07b', 1, '2013-06-13 10:19:05', '2012-12-13 08:17:03','Instalador CMS', 'Y', 'Y', 'pt-br');

-- ------------------------------------------------------------

--
-- Estrutura da tabela `sysAdminUsersGroups`
--

CREATE TABLE `sysAdminUsersGroups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  `User` int(11) DEFAULT NULL,
  `Group` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_sysadminusersgroups_user` (`User`),
  KEY `fk_sysadminusersgroups_group` (`Group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabela de Ligação de sysAdminUsers e sysAdminGroups' AUTO_INCREMENT=3;

INSERT INTO `sysAdminUsersGroups` (`ID`, `LastUpdate`, `LastUserName`, `User`, `Group`, `Lang`) VALUES
(1, '2012-12-13 08:17:03','Instalador CMS', 1, 1, 'pt-br'),
(2, '2012-12-13 08:17:03','Instalador CMS', 1, 2, 'pt-br'),
(3, '2012-12-13 08:17:03','Instalador CMS', 1, 3, 'pt-br');

-- ------------------------------------------------------------

--
-- Estrutura da tabela `sysLogs`
--

CREATE TABLE `sysLogs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `UserMail` varchar(50) DEFAULT NULL,
  `Action` char(3) DEFAULT NULL,
  `DateTime` datetime DEFAULT NULL,
  `Description` text,
  `IP` varchar(15) DEFAULT NULL,
  `Browser` char(3) DEFAULT NULL,
  `OS` char(3) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Histórico de Ações no CMS' AUTO_INCREMENT=1;

-- ------------------------------------------------------------

--
-- Estrutura da tabela `syslanguages`
--

CREATE TABLE `sysLanguages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  `Nome` varchar(30) DEFAULT NULL,
  `Identificador` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Cadastro de Idiomas' AUTO_INCREMENT=140 ;

--
-- Extraindo dados da tabela `sysLanguages`
--

INSERT INTO `sysLanguages` (`ID`, `Lang`, `LastUpdate`, `LastUserName`, `Nome`, `Identificador`) VALUES
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
-- Estrutura da tabela `sysModuleFolders`
--

CREATE TABLE `sysModuleFolders` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `Module` int(11) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Order` int(11) DEFAULT NULL,
  `File` varchar(50) DEFAULT NULL,
  `Grouper` varchar(50) DEFAULT NULL,
  `Actived` char(1) DEFAULT NULL,
  `MultiLanguages` char(1) DEFAULT NULL,
  `CounterSQL`  text,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_sysmodulefolders_module` (`Module`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Gerencia Pastas de determinado Módulo do Sistema' AUTO_INCREMENT=13;

INSERT INTO `sysModuleFolders` (`ID`, `Module`, `Name`, `Order`, `File`, `Grouper`, `Actived`,`MultiLanguages`, `LastUpdate`, `LastUserName`, `Lang`) VALUES
(1, 1, 'Tabelas', 10, 'admin.tables.grid.php', 'Banco de Dados', 'Y', 'N',  '2010-11-05 14:33:43', 'Instalador CMS', 'pt-br'),
(2, 1, 'Módulos', 20, 'admin.modules.grid.php', 'Organização', 'Y', 'N',  '2010-11-05 14:33:43', 'Instalador CMS', 'pt-br'),
(3, 1, 'Usuários', 30, 'admin.security.users.grid.php', 'Segurança', 'Y', 'N', '2010-11-05 14:33:43', 'Instalador CMS', 'pt-br'),
(4, 1, 'Grupos', 40, 'admin.security.groups.grid.php', 'Segurança', 'Y', 'N',  '2010-11-05 14:33:43', 'Instalador CMS', 'pt-br'),
(5, 1, 'Ações de Usuários', 50, 'admin.security.logs.grid.php', 'Segurança', 'Y', 'N', '2010-11-05 14:33:43', 'Instalador CMS', 'pt-br'),
(6, 1, 'Plugins', 30, 'admin.plugins.grid.php', 'Organização', 'Y', 'N', '2013-06-17 17:53:18','Instalador CMS', 'pt-br'),
(7, 2, 'Usuários', 10, 'admin.usuarios.grid.php', 'Geral', 'Y', 'N', '2013-06-17 17:53:18','Instalador CMS', 'pt-br'),
(8, 2, 'Grupos', 20, 'admin.grupos.grid.php', 'Geral', 'Y', 'N', '2013-06-17 17:53:18','Instalador CMS', 'pt-br'),
(9,1,'Parâmetros',20,'admin.params.grid.php','Banco de Dados','Y','N', '2013-09-24 13:26:08','Instalador CMS', 'pt-br'),
(10,3,'Do CMS',20,'admin.params.cms.php','Geral','Y','N', '2013-09-24 14:26:31','Instalador CMS', 'pt-br'),
(12,4,'Cache',10,'index.php','Geral','Y','N', '2013-09-24 14:26:31','Instalador CMS', 'pt-br');

-- ------------------------------------------------------------

--
-- Estrutura da tabela `sysModuleReports`
--

CREATE TABLE `sysModuleReports` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  `File` varchar(50) DEFAULT NULL,
  `Module` int(11) DEFAULT NULL,
  `Published` char(1) DEFAULT NULL,
  `Title` varchar(50) DEFAULT NULL,
  `Type` char(3) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_sysmodulereports_module` (`Module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relatórios dos Módulos' AUTO_INCREMENT=1 ;

-- ------------------------------------------------------------

--
-- Estrutura da tabela `sysModules`
--

CREATE TABLE `sysModules` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `Path` varchar(30) DEFAULT NULL,
  `Actived` char(1) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `Developer` char(1) DEFAULT NULL,
  `Icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Gerencia Módulos do Sistema' AUTO_INCREMENT=4;

INSERT INTO `sysModules` (`ID`, `Name`, `Path`, `Actived`, `LastUpdate`, `LastUserName`, `Description`, `Developer`, `Icon`, `Lang`) VALUES
(1, 'Aplicação', 'aplicacoes', 'Y', '2013-06-11 10:15:15','Instalador CMS', 'Módulo responsável pela configuração do Sistema', 'Y', 'fa-microchip', 'pt-br'),
(2, 'Usuários', 'usuarios', 'Y', '2013-06-11 10:15:15','Instalador CMS', 'Módulo responsável pela administração de Usuários', 'Y', 'fa-users', 'pt-br'),
(3,'Parâmetros','parametros','Y','2013-09-24 13:36:18','Instalador CMS','Cadastro de Parâmetros',NULL,'fa-sliders', 'pt-br'),
(4,'Cache','cache','Y','2015-08-13 11:00:00','Instalador CMS','Controle de Cache',NULL,'fa-archive', 'pt-br');
-- ------------------------------------------------------------

--
-- Estrutura da tabela `sysModulesLanguages`
--

CREATE TABLE `sysModulesLanguages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  `Modulo` int(11) DEFAULT NULL,
  `Idioma` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_sysmoduleslanguages_modulo` (`Modulo`),
  KEY `fk_sysmoduleslanguages_idioma` (`Idioma`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Cadastro de Idiomas nos Módulos' AUTO_INCREMENT=4;

--
-- Extraindo dados da tabela `sysModulesLanguages`
--

INSERT INTO `sysModulesLanguages` (`ID`, `Lang`, `LastUpdate`, `LastUserName`, `Modulo`, `Idioma`) VALUES
(1, NULL, '2013-10-18 17:49:02', 'Instalador CMS', 1, 1),
(2, NULL, '2013-10-18 17:49:02', 'Instalador CMS', 2, 1),
(3, NULL, '2013-10-18 17:49:02', 'Instalador CMS', 3, 1),
(4, NULL, '2013-10-18 17:49:02', 'Instalador CMS', 4, 1);

--
-- Estrutura da tabela `sysModuleSecurityGroups`
--

CREATE TABLE `sysModuleSecurityGroups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  `Module` int(11) DEFAULT NULL,
  `Group` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_sysmodulesecuritygroups_module` (`Module`),
  KEY `fk_sysmodulesecuritygroups_group` (`Group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Grupos de Segurança do Módulo' AUTO_INCREMENT=6;


INSERT INTO `sysModuleSecurityGroups` (`ID`, `LastUpdate`, `LastUserName`, `Module`, `Group`, `Lang`) VALUES
(1, '2013-06-11 10:15:14','Instalador CMS', 1, 1, 'pt-br'),
(2, '2013-06-11 10:15:14','Instalador CMS', 2, 1, 'pt-br'),
(3, '2013-06-11 10:15:14','Instalador CMS', 2, 3, 'pt-br'),
(4, '2013-06-11 10:15:14','Instalador CMS', 3, 1, 'pt-br'),
(5, '2013-06-11 10:15:14','Instalador CMS', 3, 3, 'pt-br'),
(6, '2013-06-11 10:15:14','Instalador CMS', 4, 3, 'pt-br');

-- ------------------------------------------------------------

--
-- Estrutura da tabela `sysTableConstrains`
--

CREATE TABLE `sysTableConstrains` (
	  `ID` int(11) NOT NULL AUTO_INCREMENT,
	  `Lang` varchar(10) DEFAULT NULL,
	  `Name` varchar(50) NOT NULL,
	  `FromTable` int(11) NOT NULL,
	  `FromField` int(11) NOT NULL,
	  `ToTable` int(11) NOT NULL,
	  `LastUpdate` datetime DEFAULT NULL,
	  `LastUserName` varchar(50) DEFAULT NULL,
	  PRIMARY KEY (`ID`),
	  KEY `fk_systablecontrains_fromtable` (`FromTable`),
	  KEY `fk_systablecontrains_fromfield` (`FromField`),
	  KEY `fk_systablecontrains_totable` (`ToTable`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Grupos de Segurança do Módulo' AUTO_INCREMENT=12 ;

INSERT INTO `sysTableConstrains` (`ID`, `Name`, `FromTable`, `FromField`, `ToTable`, `LastUpdate`, `LastUserName`, `Lang`) VALUES
(1, 'fk_systablefields_tablelink', 2, 16, 1, NULL, NULL, 'pt-br'),
(2, 'fk_systablecontrains_fromtable', 3, 17, 1, NULL, NULL, 'pt-br'),
(3, 'fk_systablecontrains_fromfield', 3, 18, 2, NULL, NULL, 'pt-br'),
(4, 'fk_systablecontrains_totable', 3, 19, 1, NULL, NULL, 'pt-br'),
(5, 'fk_sysmodulefolders_module', 9, 58, 8, NULL, NULL, 'pt-br'),
(6, 'fk_sysadminusersgroups_user', 34, 337, 24, NULL, NULL, 'pt-br'),
(7, 'fk_sysadminusersgroups_group', 34, 338, 6, NULL, NULL, 'pt-br'),
(8, 'fk_sysmodulesecuritygroups_module', 36, 339, 8, NULL, NULL, 'pt-br'),
(9, 'fk_sysmodulesecuritygroups_group', 36, 340, 6, NULL, NULL, 'pt-br'),
(10, 'fk_sysmodulereports_module', 41, 396, 8, NULL, NULL, 'pt-br'),
(11, 'fk_sysmoduleslanguages_modulo', 43, 692, 8, NULL, NULL, 'pt-br'),
(12, 'fk_sysmoduleslanguages_idioma', 43, 693, 42, NULL, NULL, 'pt-br');

-- ------------------------------------------------------------

--
-- Estrutura da tabela `sysTableFields`
--

CREATE TABLE `sysTableFields` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `Table` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Type` char(3) NOT NULL,
  `Length` int(11) DEFAULT NULL,
  `TableLink` int(11) DEFAULT NULL,
  `ListValues` varchar(500) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  `Order` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Table` (`Table`),
  KEY `fk_systablefields_tablelink` (`TableLink`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabela que gerencia Campos de determinada tabela' AUTO_INCREMENT=706;

INSERT INTO `sysTableFields` (`ID`, `Table`, `Name`, `Type`, `Length`, `TableLink`, `ListValues`, `LastUpdate`, `LastUserName`, `Order`, `Lang`) VALUES
(11, 1, 'Name', 'STR', 50, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(12, 1, 'IsSystem', 'BOL', 1, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(13, 2, 'Name', 'STR', 50, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(14, 2, 'Type', 'LST', 3, NULL, 'STR=String|INT=Inteiro|NUM=Numero Decimal|BOL=Lógico|TAB=Tabela|LST=Lista|DTA=Data|DTT=Data e Hora|TXT=Texto|IMG=Imagem|FIL=Arquivo', '2010-09-21 10:55:28','Instalador CMS', 9999, 'pt-br'),
(15, 2, 'Length', 'INT', 11, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(16, 2, 'TableLink', 'TAB', 11, 1, NULL, NULL, NULL, 9999, 'pt-br'),
(17, 3, 'FromTable', 'TAB', 11, 1, NULL, NULL, NULL, 9999, 'pt-br'),
(18, 3, 'FromField', 'TAB', 11, 2, NULL, NULL, NULL, 9999, 'pt-br'),
(19, 3, 'ToTable', 'TAB', 11, 1, NULL, NULL, NULL, 9999, 'pt-br'),
(37, 3, 'Name', 'STR', 50, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(48, 6, 'Name', 'STR', 100, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(55, 8, 'Name', 'STR', 30, NULL, NULL, '2010-07-26 16:13:28','Instalador CMS', 9999, 'pt-br'),
(56, 8, 'Path', 'STR', 30, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(57, 8, 'Actived', 'BOL', 1, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(58, 9, 'Module', 'TAB', 11, 8, NULL, NULL, NULL, 9999, 'pt-br'),
(59, 9, 'Name', 'STR', 100, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(60, 9, 'Order', 'INT', 0, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(61, 9, 'Actived', 'BOL', 1, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(62, 9, 'File', 'STR', 50, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(63, 9, 'Grouper', 'STR', 50, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(64, 1, 'Comment', 'STR', 60, NULL, NULL, '2010-07-26 15:17:36','Instalador CMS', 9999, 'pt-br'),
(65, 8, 'Description', 'STR', 50, NULL, NULL, '2010-07-22 11:50:42','Instalador CMS', 9999, 'pt-br'),
(137, 24, 'Name', 'STR', 100, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(138, 24, 'Mail', 'STR', 30, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(139, 24, 'Password', 'PSW', 10, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(140, 24, 'Group', 'TAB', NULL, 6, NULL, NULL, NULL, 9999, 'pt-br'),
(142, 24, 'Developer', 'BOL', NULL, NULL, NULL, NULL, NULL, 9999, 'pt-br'),
(229, 2, 'ListValues', 'STR', 500, NULL, NULL, '2010-10-06 10:07:00','Instalador CMS', 9999, 'pt-br'),
(305, 24, 'Actived', 'BOL', NULL, NULL, NULL, '2010-10-25 16:39:58','Instalador CMS', 9999, 'pt-br'),
(337, 34, 'User', 'TAB', NULL, 24, NULL, '2010-11-03 16:17:14','Instalador CMS', 9999, 'pt-br'),
(338, 34, 'Group', 'TAB', NULL, 6, NULL, '2010-11-03 16:17:28','Instalador CMS', 9999, 'pt-br'),
(339, 36, 'Module', 'TAB', NULL, 8, NULL, '2010-11-04 14:51:23','Instalador CMS', 9999, 'pt-br'),
(340, 36, 'Group', 'TAB', NULL, 6, NULL, '2010-11-04 14:51:41','Instalador CMS', 9999, 'pt-br'),
(341, 37, 'UserName', 'STR', 100, NULL, NULL, '2010-11-05 10:43:58','Instalador CMS', 9999, 'pt-br'),
(342, 37, 'UserMail', 'STR', 50, NULL, NULL, '2010-11-05 10:44:10','Instalador CMS', 9999, 'pt-br'),
(343, 37, 'Action', 'LST', NULL, NULL, 'LOG=Login|NEW=Inseriu novo Registro|EDT=Editou um Registro|DEL=Excluiu um Registro', '2010-11-05 14:32:45', 'Tiago Gonçalves (Tiago Gonçalves)', 9999, 'pt-br'),
(344, 37, 'DateTime', 'DTT', NULL, NULL, NULL, '2010-11-05 10:47:07','Instalador CMS', 9999, 'pt-br'),
(345, 37, 'Description', 'TXT', NULL, NULL, NULL, '2010-11-05 10:58:49','Instalador CMS', 9999, 'pt-br'),
(346, 37, 'IP', 'STR', 15, NULL, NULL, '2010-11-05 11:05:00','Instalador CMS', 9999, 'pt-br'),
(347, 37, 'Browser', 'LST', NULL, NULL, 'IE6=Internet Explorer 6|IE7=Internet Explorer 7|IE8=Internet Explorer 8|CHR=Chrome|FFX=Firefox|OPR=Opera|SAF=Safari|000=Não Identificado', '2010-11-05 11:50:49', 'Tiago Gonçalves (Tiago Gonçalves)', 9999, 'pt-br'),
(348, 37, 'OS', 'LST', NULL, NULL, 'ADN=Andróid|BKB=BlackBerry|IPH=iPhone|PLM=Palm|LNX=linux|MCT=Macintosh|WIN=Windows|000=Brower não identificado', '2010-11-05 11:52:24', 'Tiago Gonçalves (Tiago Gonçalves)', 9999, 'pt-br'),
(361, 2, 'Order', 'INT', NULL, NULL, NULL, '2010-11-17 14:04:23','Instalador CMS', 9999, 'pt-br'),
(395, 41, 'File', 'STR', 50, NULL, NULL, '2010-12-06 18:12:09','Instalador CMS', NULL, 'pt-br'),
(396, 41, 'Module', 'TAB', NULL, 8, NULL, '2010-12-06 18:12:22','Instalador CMS', NULL, 'pt-br'),
(397, 41, 'Published', 'BOL', NULL, NULL, NULL, '2010-12-06 18:12:33','Instalador CMS', NULL, 'pt-br'),
(398, 41, 'Title', 'STR', 50, NULL, NULL, '2010-12-06 18:12:48','Instalador CMS', NULL, 'pt-br'),
(399, 41, 'Type', 'LST', NULL, NULL, 'PDF=Documento em PDF|XLS=Planilha Excel', '2010-12-06 18:13:15','Instalador CMS', NULL, 'pt-br'),
(611, 8, 'Icon', 'STR', 50, NULL, NULL, '2013-06-07 00:16:00','Instalador CMS', 9999, 'pt-br'),
(612, 42, 'Nome', 'STR', 30, NULL, NULL, '2013-10-18 15:41:36', 'Instalador CMS', 9999, 'pt-br'),
(613, 42, 'Identificador', 'STR', 10, NULL, NULL, '2013-10-18 15:42:25', 'Instalador CMS', 9999, 'pt-br'),
(692, 43, 'Modulo', 'TAB', NULL, 8, NULL, '2013-10-18 17:04:51', 'Instalador CMS', 9999, 'pt-br'),
(693, 43, 'Idioma', 'TAB', NULL, 42, NULL, '2013-10-18 17:05:13', 'Instalador CMS', 9999, 'pt-br'),
(694, 45, 'Nome', 'STR', 100, NULL, NULL, '2013-10-21 14:14:57', 'Instalador CMS', 9999, 'pt-br'),
(695, 45, 'Tipo', 'LST', NULL, NULL, 'STR=String|TXT=Texto|BOL=Lógico|HTM=Html', '2013-10-21 14:15:25', 'Instalador CMS', 9999, 'pt-br'),
(696, 45, 'Valor', 'TXT', NULL, NULL, NULL, '2013-10-21 14:15:35', 'Instalador CMS', 9999, 'pt-br'),
(697, 45, 'Identificador', 'STR', 100, NULL, NULL, '2013-10-21 14:15:49', 'Instalador CMS', 9999, 'pt-br'),
(698, 45, 'Agrupador', 'LST', NULL, NULL, 'CMS=Do CMS|SIT=Do Site', '2013-10-21 14:16:07', 'Instalador CMS', 9999, 'pt-br'),
(699, 45, 'Nome', 'STR', 50, NULL, NULL, '2013-10-21 14:22:03', 'Instalador CMS', 9999, 'pt-br'),
(700, 45, 'Actived', 'BOL', NULL, NULL, NULL, '2013-10-21 14:22:20', 'Instalador CMS', 9999, 'pt-br'),
(701, 45, 'Path', 'STR', 30, NULL, NULL, '2013-10-21 14:22:46', 'Instalador CMS', 9999, 'pt-br'),
(702, 45, 'Description', 'TXT', NULL, NULL, NULL, '2013-10-21 14:23:01', 'Instalador CMS', 9999, 'pt-br'),
(703, 45, 'URL', 'STR', 100, NULL, NULL, '2013-10-21 14:23:07', 'Instalador CMS', 9999, 'pt-br'),
(704, 45, 'Version', 'STR', 10, NULL, NULL, '2013-10-21 14:23:22', 'Instalador CMS', 9999, 'pt-br'),
(705, 9, 'CounterSQL', 'TXT', 0, NULL, NULL, NULL, NULL, 9999, 'pt-br');



-- ------------------------------------------------------------
--
-- Estrutura da tabela `sysTables`
--

CREATE TABLE `sysTables` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `Name` varchar(50) NOT NULL,
  `IsSystem` char(1) NOT NULL,
  `Comment` varchar(60) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabela que gerencia tabelas do Sistema' AUTO_INCREMENT=45 ;

INSERT INTO `sysTables` (`ID`, `Name`, `IsSystem`, `Comment`, `LastUpdate`, `LastUserName`, `Lang`) VALUES
(1, 'sysTables', 'Y', 'Gerencia Tabelas do Framework', '2010-07-21 09:37:37','Instalador CMS', 'pt-br'),
(2, 'sysTableFields', 'Y', 'Gerencia Campos de Tabela', '2010-07-21 09:36:20','Instalador CMS', 'pt-br'),
(3, 'sysTableConstrains', 'Y', 'Gerencia links entre as tabelas (Constrains)', '2010-07-19 18:00:41','Instalador CMS', 'pt-br'),
(6, 'sysAdminGroups', 'Y', 'Grupo de Segurança do Administrator', '2010-07-21 14:24:59','Instalador CMS', 'pt-br'),
(8, 'sysModules', 'Y', 'Gerencia Módulos do Sistema', '2010-07-21 14:24:59', 'Instalador CMS', 'pt-br'),
(9, 'sysModuleFolders', 'Y', 'Gerencia Pastas de determinado Módulo do Sistema', '2010-07-21 14:24:59','Instalador CMS', 'pt-br'),
(24, 'sysAdminUsers', 'Y', 'Gerencia Usuários do Sistema', '2010-07-30 14:53:30','Instalador CMS', 'pt-br'),
(34, 'sysAdminUsersGroups', 'Y', 'Tabela de Ligação de sysAdminUsers e sysAdminGroups', '2010-11-03 16:16:53','Instalador CMS', 'pt-br'),
(36, 'sysModuleSecurityGroups', 'Y', 'Grupos de Segurança do Módulo', '2010-11-04 14:51:08','Instalador CMS', 'pt-br'),
(37, 'sysLogs', 'Y', 'Histórico de Ações no CMS', '2010-11-05 10:35:18','Instalador CMS', 'pt-br'),
(41, 'sysModuleReports', 'Y', 'Relatórios dos Módulos', '2010-12-06 18:11:51','Instalador CMS', 'pt-br'),
(42, 'sysLanguages', 'Y', 'Cadastro de Idiomas', '2010-12-06 18:11:51', 'Instalador CMS', 'pt-br'),
(43, 'sysModulesLanguages', 'Y', 'Ligação de Módulos com Idiomas', '2010-12-06 18:11:51','Instalador CMS', 'pt-br'),
(44, 'sysPlugins', 'Y', 'Cadastro de Plugins', '2010-12-06 18:11:51','Instalador CMS', 'pt-br'),
(45, 'sysParams', 'Y', 'Cadastro de Parâmetros', '2010-12-06 18:11:51','Instalador CMS', 'pt-br');

-- ------------------------------------------------------------
--
-- Estrutura da tabela `sysPlugins`
--

CREATE TABLE `sysPlugins` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Actived` char(1) DEFAULT NULL,
  `Path` varchar(30) DEFAULT NULL,
  `Description` text,
  `URL` varchar(100) DEFAULT NULL,
  `Version` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Cadastro de Plugins' AUTO_INCREMENT=1;


-- ------------------------------------------------------------
--
-- Estrutura da tabela `sysParams`
--

CREATE TABLE `sysParams` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  `Nome` varchar(100) DEFAULT NULL,
  `Tipo` char(3) DEFAULT NULL,
  `Valor` text,
  `Identificador` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Cadastro de Parâmetros' AUTO_INCREMENT=1;
-- --------------------------------------------------------

--
-- Estrutura da tabela `chtVisitantes`
--

CREATE TABLE IF NOT EXISTS `chtVisitantes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Lang` varchar(10) DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastUserName` varchar(50) DEFAULT NULL,
  `IP` varchar(15) DEFAULT NULL,
  `DataHora` datetime DEFAULT NULL,
  `SessaoID` varchar(50) DEFAULT NULL,
  `URL` varchar(500) DEFAULT NULL,
  `URLReferencia` varchar(500) DEFAULT NULL,
  `Plataforma` char(3) DEFAULT NULL,
  `Navegador` char(3) DEFAULT NULL,
  `Sistema` char(3) DEFAULT NULL,
  `Touch` char(1) DEFAULT NULL,
  `Resolucao` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Atendimento Online';


-- ------------------------------------------------------------
-- ------------------------------------------------------------
-- Adiciona CONSTRAINS
-- ------------------------------------------------------------
-- ------------------------------------------------------------

ALTER TABLE `sysAdminUsers`
  ADD CONSTRAINT `fk_sysadminusers_group` FOREIGN KEY (`Group`) REFERENCES `sysAdminGroups` (`ID`);

ALTER TABLE `sysAdminUsersGroups`
  ADD CONSTRAINT `fk_sysadminusersgroups_group` FOREIGN KEY (`Group`) REFERENCES `sysAdminGroups` (`ID`),
  ADD CONSTRAINT `fk_sysadminusersgroups_user` FOREIGN KEY (`User`) REFERENCES `sysAdminUsers` (`ID`);

ALTER TABLE `sysModuleFolders`
  ADD CONSTRAINT `fk_sysmodulefolders_module` FOREIGN KEY (`Module`) REFERENCES `sysModules` (`ID`);

ALTER TABLE `sysModuleReports`
  ADD CONSTRAINT `fk_sysmodulereports_module` FOREIGN KEY (`Module`) REFERENCES `sysModules` (`ID`);

ALTER TABLE `sysModuleSecurityGroups`
  ADD CONSTRAINT `fk_sysmodulesecuritygroups_group` FOREIGN KEY (`Group`) REFERENCES `sysAdminGroups` (`ID`),
  ADD CONSTRAINT `fk_sysmodulesecuritygroups_module` FOREIGN KEY (`Module`) REFERENCES `sysModules` (`ID`);

ALTER TABLE `sysTableConstrains`
  ADD CONSTRAINT `fk_systablecontrains_fromfield` FOREIGN KEY (`FromField`) REFERENCES `sysTableFields` (`ID`),
  ADD CONSTRAINT `fk_systablecontrains_fromtable` FOREIGN KEY (`FromTable`) REFERENCES `sysTables` (`ID`),
  ADD CONSTRAINT `fk_systablecontrains_totable` FOREIGN KEY (`ToTable`) REFERENCES `sysTables` (`ID`);

ALTER TABLE `sysTableFields`
  ADD CONSTRAINT `fk_systablefields_tablelink` FOREIGN KEY (`TableLink`) REFERENCES `sysTables` (`ID`);


ALTER TABLE `sysModulesLanguages`
  ADD CONSTRAINT `fk_sysmoduleslanguages_idioma` FOREIGN KEY (`Idioma`) REFERENCES `sysLanguages` (`ID`),
  ADD CONSTRAINT `fk_sysmoduleslanguages_modulo` FOREIGN KEY (`Modulo`) REFERENCES `sysModules` (`ID`);