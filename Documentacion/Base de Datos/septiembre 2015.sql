-- MySQL Script generated by MySQL Workbench
-- Sun Sep 20 21:38:49 2015
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema awarehome-septiembre
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema awarehome-septiembre
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `awarehome-septiembre` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `awarehome-septiembre` ;

-- -----------------------------------------------------
-- Table `awarehome-septiembre`.`clave`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `awarehome-septiembre`.`clave` (
  `id_clave` INT NOT NULL AUTO_INCREMENT,
  `clave` VARCHAR(45) NULL,
  PRIMARY KEY (`id_clave`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `awarehome-septiembre`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `awarehome-septiembre`.`usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `nombre_usuario` VARCHAR(45) NULL,
  `apellido_usuario` VARCHAR(45) NULL,
  `alias` VARCHAR(45) NULL,
  `telefono` VARCHAR(45) NULL,
  `clave_id_clave` INT NOT NULL,
  PRIMARY KEY (`id_usuario`),
  INDEX `fk_usuario_clave_idx` (`clave_id_clave` ASC),
  CONSTRAINT `fk_usuario_clave`
    FOREIGN KEY (`clave_id_clave`)
    REFERENCES `awarehome-septiembre`.`clave` (`id_clave`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `awarehome-septiembre`.`ubicacion_hogar`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `awarehome-septiembre`.`ubicacion_hogar` (
  `id_ubicacion_hogar` INT NOT NULL AUTO_INCREMENT,
  `ubicacion` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `lat` VARCHAR(45) NULL,
  `lng` VARCHAR(45) NULL,
  PRIMARY KEY (`id_ubicacion_hogar`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `awarehome-septiembre`.`alerta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `awarehome-septiembre`.`alerta` (
  `id_alerta` INT NOT NULL AUTO_INCREMENT,
  `nombre_alerta` VARCHAR(45) NULL,
  `sensor` VARCHAR(45) NULL,
  `signo` VARCHAR(45) NULL,
  `valor` VARCHAR(45) NULL,
  `fecha` DATETIME NULL,
  `estado` INT NULL,
  PRIMARY KEY (`id_alerta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `awarehome-septiembre`.`repeticion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `awarehome-septiembre`.`repeticion` (
  `id_repeticion` INT NOT NULL AUTO_INCREMENT,
  `lunes` TINYINT(1) NULL,
  `martes` TINYINT(1) NULL,
  `miercoles` TINYINT(1) NULL,
  `jueves` TINYINT(1) NULL,
  `viernes` TINYINT(1) NULL,
  `sabado` TINYINT(1) NULL,
  `domingo` TINYINT(1) NULL,
  PRIMARY KEY (`id_repeticion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `awarehome-septiembre`.`composicion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `awarehome-septiembre`.`composicion` (
  `id_composicion` INT NOT NULL AUTO_INCREMENT,
  `sensor` VARCHAR(45) NULL,
  `signo` VARCHAR(45) NULL,
  `valor` VARCHAR(45) NULL,
  `operador` VARCHAR(45) NULL,
  `orden` VARCHAR(45) NULL,
  PRIMARY KEY (`id_composicion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `awarehome-septiembre`.`alerta_compuesta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `awarehome-septiembre`.`alerta_compuesta` (
  `id_alerta_compuesta` INT NOT NULL AUTO_INCREMENT,
  `nombre_alerta_compuesta` VARCHAR(45) NULL,
  `repeticion_id_repeticion` INT NULL,
  `composicion_id_composicion` INT NOT NULL,
  PRIMARY KEY (`id_alerta_compuesta`),
  INDEX `fk_alerta_compuesta_repeticion1_idx` (`repeticion_id_repeticion` ASC),
  INDEX `fk_alerta_compuesta_composicion1_idx` (`composicion_id_composicion` ASC),
  CONSTRAINT `fk_alerta_compuesta_repeticion1`
    FOREIGN KEY (`repeticion_id_repeticion`)
    REFERENCES `awarehome-septiembre`.`repeticion` (`id_repeticion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alerta_compuesta_composicion1`
    FOREIGN KEY (`composicion_id_composicion`)
    REFERENCES `awarehome-septiembre`.`composicion` (`id_composicion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `awarehome-septiembre`.`hogar`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `awarehome-septiembre`.`hogar` (
  `id_hogar` INT NOT NULL AUTO_INCREMENT,
  `nombre_hogar` VARCHAR(45) NULL,
  `descripcion_hogar` VARCHAR(45) NULL,
  `usuario_id_usuario` INT NOT NULL,
  `ubicacion_hogar_id_ubicacion_hogar` INT NULL,
  `alerta_id_alerta` INT NULL,
  `alerta_compuesta_id_alerta_compuesta` INT NULL,
  PRIMARY KEY (`id_hogar`),
  INDEX `fk_hogar_usuario1_idx` (`usuario_id_usuario` ASC),
  INDEX `fk_hogar_ubicacion_hogar1_idx` (`ubicacion_hogar_id_ubicacion_hogar` ASC),
  INDEX `fk_hogar_alerta1_idx` (`alerta_id_alerta` ASC),
  INDEX `fk_hogar_alerta_compuesta1_idx` (`alerta_compuesta_id_alerta_compuesta` ASC),
  CONSTRAINT `fk_hogar_usuario1`
    FOREIGN KEY (`usuario_id_usuario`)
    REFERENCES `awarehome-septiembre`.`usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_hogar_ubicacion_hogar1`
    FOREIGN KEY (`ubicacion_hogar_id_ubicacion_hogar`)
    REFERENCES `awarehome-septiembre`.`ubicacion_hogar` (`id_ubicacion_hogar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_hogar_alerta1`
    FOREIGN KEY (`alerta_id_alerta`)
    REFERENCES `awarehome-septiembre`.`alerta` (`id_alerta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_hogar_alerta_compuesta1`
    FOREIGN KEY (`alerta_compuesta_id_alerta_compuesta`)
    REFERENCES `awarehome-septiembre`.`alerta_compuesta` (`id_alerta_compuesta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `awarehome-septiembre`.`ubicacion_sensor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `awarehome-septiembre`.`ubicacion_sensor` (
  `id_ubicacion_sensor` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `descripcion` VARCHAR(45) NULL,
  PRIMARY KEY (`id_ubicacion_sensor`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `awarehome-septiembre`.`sensor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `awarehome-septiembre`.`sensor` (
  `id_sensor` INT NOT NULL AUTO_INCREMENT,
  `sensor` VARCHAR(45) NULL,
  `descripcion` VARCHAR(45) NULL,
  `ubicacion_sensor_id_ubicacion_sensor` INT NULL,
  PRIMARY KEY (`id_sensor`),
  INDEX `fk_sensor_ubicacion_sensor1_idx` (`ubicacion_sensor_id_ubicacion_sensor` ASC),
  CONSTRAINT `fk_sensor_ubicacion_sensor1`
    FOREIGN KEY (`ubicacion_sensor_id_ubicacion_sensor`)
    REFERENCES `awarehome-septiembre`.`ubicacion_sensor` (`id_ubicacion_sensor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `awarehome-septiembre`.`medicion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `awarehome-septiembre`.`medicion` (
  `id_medicion` INT NOT NULL AUTO_INCREMENT,
  `medicion` VARCHAR(45) NULL,
  `fecha` DATETIME NULL,
  `hogar_id_hogar` INT NULL,
  `sensor_id_sensor` INT NOT NULL,
  PRIMARY KEY (`id_medicion`),
  INDEX `fk_medicion_hogar1_idx` (`hogar_id_hogar` ASC),
  INDEX `fk_medicion_sensor1_idx` (`sensor_id_sensor` ASC),
  CONSTRAINT `fk_medicion_hogar1`
    FOREIGN KEY (`hogar_id_hogar`)
    REFERENCES `awarehome-septiembre`.`hogar` (`id_hogar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_medicion_sensor1`
    FOREIGN KEY (`sensor_id_sensor`)
    REFERENCES `awarehome-septiembre`.`sensor` (`id_sensor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
