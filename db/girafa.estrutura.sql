-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Table `sis_grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sis_grupos` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Lang` VARCHAR(10) NULL DEFAULT NULL,
  `Name` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COMMENT = 'Grupo de Segurança do Administrator';


-- -----------------------------------------------------
-- Table `sis_usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sis_usuarios` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Lang` VARCHAR(10) NULL DEFAULT NULL,
  `Name` VARCHAR(100) NULL DEFAULT NULL,
  `Mail` VARCHAR(50) NULL DEFAULT NULL,
  `Password` CHAR(32) NULL DEFAULT NULL,
  `Group` INT(11) NULL DEFAULT NULL,
  `LastAccess` DATETIME NULL DEFAULT NULL,
  `Developer` CHAR(1) NULL DEFAULT NULL,
  `Actived` CHAR(1) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_sis_usuarios_grupo` (`Group` ASC),
  CONSTRAINT `fk_sis_usuarios_grupo`
    FOREIGN KEY (`Group`)
    REFERENCES `sis_grupos` (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Usuários do Administrator';


-- -----------------------------------------------------
-- Table `sis_usuarios_grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sis_usuarios_grupos` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Lang` VARCHAR(10) NULL DEFAULT NULL,
  `User` INT(11) NULL DEFAULT NULL,
  `Group` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_sis_usuarios_grupos_usuario` (`User` ASC),
  INDEX `fk_sis_usuarios_grupos_grupo` (`Group` ASC),
  CONSTRAINT `fk_sis_usuarios_grupos_grupo`
    FOREIGN KEY (`Group`)
    REFERENCES `sis_grupos` (`ID`),
  CONSTRAINT `fk_sis_usuarios_grupos_usuario`
    FOREIGN KEY (`User`)
    REFERENCES `sis_usuarios` (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabela de Ligação de sysAdminUsers e sysAdminGroups';


-- -----------------------------------------------------
-- Table `sis_logs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sis_logs` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Lang` VARCHAR(10) NULL DEFAULT NULL,
  `UserName` VARCHAR(100) NULL DEFAULT NULL,
  `UserMail` VARCHAR(50) NULL DEFAULT NULL,
  `Action` CHAR(3) NULL DEFAULT NULL,
  `DateTime` DATETIME NULL DEFAULT NULL,
  `Description` TEXT NULL DEFAULT NULL,
  `IP` VARCHAR(15) NULL DEFAULT NULL,
  `Browser` CHAR(3) NULL DEFAULT NULL,
  `OS` CHAR(3) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Histórico de Ações no CMS';


-- -----------------------------------------------------
-- Table `sis_idiomas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sis_idiomas` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Lang` VARCHAR(10) NULL DEFAULT NULL,
  `Nome` VARCHAR(30) NULL DEFAULT NULL,
  `Identificador` VARCHAR(10) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 140
DEFAULT CHARACTER SET = utf8
COMMENT = 'Cadastro de Idiomas';


-- -----------------------------------------------------
-- Table `sis_modulos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sis_modulos` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Lang` VARCHAR(10) NULL DEFAULT NULL,
  `Name` VARCHAR(30) NULL DEFAULT NULL,
  `Path` VARCHAR(30) NULL DEFAULT NULL,
  `Actived` CHAR(1) NULL DEFAULT NULL,
  `Description` VARCHAR(50) NULL DEFAULT NULL,
  `Developer` CHAR(1) NULL DEFAULT NULL,
  `Icon` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8
COMMENT = 'Gerencia Módulos do Sistema';


-- -----------------------------------------------------
-- Table `sis_pastas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sis_pastas` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Lang` VARCHAR(10) NULL DEFAULT NULL,
  `Module` INT(11) NULL DEFAULT NULL,
  `Name` VARCHAR(100) NULL DEFAULT NULL,
  `Order` INT(11) NULL DEFAULT NULL,
  `File` VARCHAR(50) NULL DEFAULT NULL,
  `Grouper` VARCHAR(50) NULL DEFAULT NULL,
  `Actived` CHAR(1) NULL DEFAULT NULL,
  `MultiLanguages` CHAR(1) NULL DEFAULT NULL,
  `CounterSQL` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_sis_pastas_modulo` (`Module` ASC),
  CONSTRAINT `fk_sis_pastas_modulo`
    FOREIGN KEY (`Module`)
    REFERENCES `sis_modulos` (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = utf8
COMMENT = 'Gerencia Pastas de determinado Módulo do Sistema';


-- -----------------------------------------------------
-- Table `sis_relatorios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sis_relatorios` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Lang` VARCHAR(10) NULL DEFAULT NULL,
  `File` VARCHAR(50) NULL DEFAULT NULL,
  `Module` INT(11) NULL DEFAULT NULL,
  `Published` CHAR(1) NULL DEFAULT NULL,
  `Title` VARCHAR(50) NULL DEFAULT NULL,
  `Type` CHAR(3) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_sis_relatorios_modulo` (`Module` ASC),
  CONSTRAINT `fk_sis_relatorios_modulo`
    FOREIGN KEY (`Module`)
    REFERENCES `sis_modulos` (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Relatórios dos Módulos';


-- -----------------------------------------------------
-- Table `sis_modulos_idiomas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sis_modulos_idiomas` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Lang` VARCHAR(10) NULL DEFAULT NULL,
  `Modulo` INT(11) NULL DEFAULT NULL,
  `Idioma` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_sis_modulos_idiomas_modulo` (`Modulo` ASC),
  INDEX `fk_sis_modulos_idiomas_idioma` (`Idioma` ASC),
  CONSTRAINT `fk_sis_modulos_idiomas_idioma`
    FOREIGN KEY (`Idioma`)
    REFERENCES `sis_idiomas` (`ID`),
  CONSTRAINT `fk_sis_modulos_idiomas_modulo`
    FOREIGN KEY (`Modulo`)
    REFERENCES `sis_modulos` (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8
COMMENT = 'Cadastro de Idiomas nos Módulos';


-- -----------------------------------------------------
-- Table `sis_modulos_grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sis_modulos_grupos` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Lang` VARCHAR(10) NULL DEFAULT NULL,
  `Module` INT(11) NULL DEFAULT NULL,
  `Group` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_sis_modulos_grupos_modulo` (`Module` ASC),
  INDEX `fk_sis_modulos_grupos_grupo` (`Group` ASC),
  CONSTRAINT `fk_sis_modulos_grupos_grupo`
    FOREIGN KEY (`Group`)
    REFERENCES `sis_grupos` (`ID`),
  CONSTRAINT `fk_sis_modulos_grupos_modulo`
    FOREIGN KEY (`Module`)
    REFERENCES `sis_modulos` (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8
COMMENT = 'Grupos de Segurança do Módulo';


-- -----------------------------------------------------
-- Table `sis_parametros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sis_parametros` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `Lang` VARCHAR(10) NULL DEFAULT NULL,
  `Nome` VARCHAR(100) NULL DEFAULT NULL,
  `Tipo` CHAR(3) NULL DEFAULT NULL,
  `Valor` TEXT NULL DEFAULT NULL,
  `Identificador` VARCHAR(15) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Cadastro de Parâmetros';


-- -----------------------------------------------------
-- Table `sis_plugins`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sis_plugins` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Lang` VARCHAR(10) NULL,
  `Name` VARCHAR(50) NULL,
  `Actived` CHAR(1) NULL,
  `Path` VARCHAR(30) NULL,
  `Description` TEXT NULL,
  `URL` VARCHAR(100) NULL,
  `Version` VARCHAR(10) NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
