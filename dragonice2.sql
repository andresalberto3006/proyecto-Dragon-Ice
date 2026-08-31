-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema dragonice
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dragonice
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dragonice` DEFAULT CHARACTER SET utf8mb4 ;
USE `dragonice` ;

-- -----------------------------------------------------
-- Table `dragonice`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dragonice`.`productos` (
  `id` INT(11) NOT NULL,
  `nombre` VARCHAR(80) NOT NULL,
  `descripcion` VARCHAR(150) NOT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  `costo` DECIMAL(10,2) NOT NULL,
  `stock` INT(11) NOT NULL DEFAULT '0',
  `imagen` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dragonice`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dragonice`.`usuario` (
  `ci` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `direccion` VARCHAR(100) NOT NULL,
  `celular` VARCHAR(20) NOT NULL,
  `rol` ENUM('Administrador', 'Vendedor') NOT NULL,
  `estado` ENUM('Activo', 'Bloqueado') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`ci`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dragonice`.`pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dragonice`.`pedidos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(80) NOT NULL,
  `fecha` DATE NOT NULL,
  `estado` ENUM('Abierto', 'Pendiente', 'En proceso', 'Entregado', 'Rechazado') NOT NULL DEFAULT 'Abierto',
  `vendedor_ci` INT(11) NULL DEFAULT NULL,
  `nombrevendedor` VARCHAR(80) NULL DEFAULT NULL,
  `metodo_pago` VARCHAR(45) NOT NULL DEFAULT '',
  `telefono` VARCHAR(20) NULL DEFAULT NULL,
  `direccion` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `vendedor_ci` (`vendedor_ci` ASC) VISIBLE,
  CONSTRAINT `pedidos_ibfk_1`
    FOREIGN KEY (`vendedor_ci`)
    REFERENCES `dragonice`.`usuario` (`ci`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dragonice`.`carrito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dragonice`.`carrito` (
  `productos_id` INT(11) NOT NULL,
  `pedidos_id` INT(11) NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `costototal` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`productos_id`, `pedidos_id`),
  INDEX `pedidos_id` (`pedidos_id` ASC) VISIBLE,
  CONSTRAINT `carrito_ibfk_1`
    FOREIGN KEY (`productos_id`)
    REFERENCES `dragonice`.`productos` (`id`),
  CONSTRAINT `carrito_ibfk_2`
    FOREIGN KEY (`pedidos_id`)
    REFERENCES `dragonice`.`pedidos` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dragonice`.`ventas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dragonice`.`ventas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `pedidos_id` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  `cliente` VARCHAR(80) NOT NULL,
  `vendedor_ci` INT(11) NOT NULL,
  `nombrevendedor` VARCHAR(80) NOT NULL,
  `total` DECIMAL(10,2) NOT NULL,
  `metodo_pago` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `venta_pedido` (`pedidos_id` ASC) VISIBLE,
  INDEX `vendedor_ci` (`vendedor_ci` ASC) VISIBLE,
  CONSTRAINT `ventas_ibfk_1`
    FOREIGN KEY (`pedidos_id`)
    REFERENCES `dragonice`.`pedidos` (`id`),
  CONSTRAINT `ventas_ibfk_2`
    FOREIGN KEY (`vendedor_ci`)
    REFERENCES `dragonice`.`usuario` (`ci`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
