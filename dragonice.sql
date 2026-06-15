-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema dragonice
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dragonice
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dragonice` DEFAULT CHARACTER SET utf8 ;
USE `dragonice` ;

-- -----------------------------------------------------
-- Table `dragonice`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dragonice`.`usuario` (
  `ciu` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `celular` INT NULL,
  `rol` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NULL,
  PRIMARY KEY (`ciu`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dragonice`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dragonice`.`productos` (
  `Codigo` INT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `descripcion` VARCHAR(45) NULL,
  `precio` INT NULL,
  `costo` INT NULL,
  `stock` INT NULL,
  PRIMARY KEY (`Codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dragonice`.`pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dragonice`.`pedidos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `fecha` DATE NULL,
  `estado` VARCHAR(45) NULL,
  `nombrevendedor` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dragonice`.`productos_has_pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dragonice`.`productos_has_pedidos` (
  `id_productos` INT NOT NULL,
  `id_pedidos` INT NOT NULL,
  `cantidad` VARCHAR(45) NULL,
  `costotal` VARCHAR(45) NULL,
  PRIMARY KEY (`id_productos`, `id_pedidos`),
  INDEX `fk_productos_has_pedidos_pedidos1_idx` (`id_pedidos` ASC),
  INDEX `fk_productos_has_pedidos_productos_idx` (`id_productos` ASC),
  CONSTRAINT `fk_productos_has_pedidos_productos`
    FOREIGN KEY (`id_productos`)
    REFERENCES `dragonice`.`productos` (`Codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_has_pedidos_pedidos1`
    FOREIGN KEY (`id_pedidos`)
    REFERENCES `dragonice`.`pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
