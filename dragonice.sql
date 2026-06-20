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
-- Table `dragonice`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dragonice`.`productos` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `descripcion` VARCHAR(45) NULL,
  `precio` INT NULL,
  `costo` INT NULL,
  `stock` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dragonice`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dragonice`.`usuario` (
  `ci` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `celular` INT NULL,
  `rol` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NULL,
  PRIMARY KEY (`ci`))
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
-- Table `dragonice`.`carrito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dragonice`.`carrito` (
  `productos_id` INT NOT NULL,
  `pedidos_id` INT NOT NULL,
  `cantidad` VARCHAR(45) NULL,
  `costototal` VARCHAR(45) NULL,
  PRIMARY KEY (`productos_id`, `pedidos_id`),
  INDEX `fk_productos_has_pedidos_pedidos1_idx` (`pedidos_id` ASC),
  INDEX `fk_productos_has_pedidos_productos_idx` (`productos_id` ASC),
  CONSTRAINT `fk_productos_has_pedidos_productos`
    FOREIGN KEY (`productos_id`)
    REFERENCES `dragonice`.`productos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_has_pedidos_pedidos1`
    FOREIGN KEY (`pedidos_id`)
    REFERENCES `dragonice`.`pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

