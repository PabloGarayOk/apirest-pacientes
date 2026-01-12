-- =====================================================
-- Database schema for API REST example
-- Author: Pablo Garay
-- Description: Database structure only (no real data)
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET NAMES utf8mb4;

-- -----------------------------------------------------
-- Database: apirest
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table: pacientes
-- -----------------------------------------------------
CREATE TABLE `pacientes` (
  `Paciente_Id` INT NOT NULL AUTO_INCREMENT,
  `DNI` INT NOT NULL,
  `Nombre` VARCHAR(30) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Apellido` VARCHAR(30) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Genero` VARCHAR(3) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `FechaNacimiento` DATE DEFAULT NULL,
  `Direccion` VARCHAR(60) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Tel` DECIMAL(10,0) DEFAULT NULL,
  `Email` VARCHAR(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`Paciente_Id`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_spanish_ci;

-- -----------------------------------------------------
-- Table: usuarios
-- -----------------------------------------------------
CREATE TABLE `usuarios` (
  `UsuarioId` INT NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(35) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Apellido` VARCHAR(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Email` VARCHAR(65) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Password` VARCHAR(70) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Estado` TINYINT(1) NOT NULL,
  PRIMARY KEY (`UsuarioId`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_spanish_ci;

-- -----------------------------------------------------
-- Table: usuarios_token
-- -----------------------------------------------------
CREATE TABLE `usuarios_token` (
  `TokenId` INT NOT NULL AUTO_INCREMENT,
  `UsuarioId` INT NOT NULL,
  `Token` VARCHAR(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Estado` TINYINT(1) NOT NULL,
  `Fecha` DATETIME NOT NULL,
  PRIMARY KEY (`TokenId`),
  CONSTRAINT `fk_usuarios_token_usuario`
    FOREIGN KEY (`UsuarioId`)
    REFERENCES `usuarios`(`UsuarioId`)
    ON DELETE CASCADE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_spanish_ci;

COMMIT;

