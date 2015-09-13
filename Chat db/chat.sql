-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema chat
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema chat
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `chatsystemdb` DEFAULT CHARACTER SET utf8 ;
USE `chatsystemdb` ;

-- -----------------------------------------------------
-- Table `chat`.`login`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `chatsystemdb`.`login` (
  `username` VARCHAR(25) NOT NULL,
  `password` VARCHAR(30) NULL DEFAULT NULL,
  `admin` TINYINT(1) NULL DEFAULT '0',
  `Email` VARCHAR(100) NOT NULL,
  `Gender` VARCHAR(6) NULL DEFAULT NULL,
  PRIMARY KEY (`username`),
  UNIQUE INDEX `Email_UNIQUE` (`Email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `chat`.`friend`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `chatsystemdb`.`friend` (
  `username` VARCHAR(25) NOT NULL,
  `friend` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`username`, `friend`),
  INDEX `fk_login_has_login_login2_idx` (`friend` ASC),
  INDEX `fk_login_has_login_login1_idx` (`username` ASC),
  CONSTRAINT `fk_login_has_login_login1`
    FOREIGN KEY (`username`)
    REFERENCES `chat`.`login` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_login_has_login_login2`
    FOREIGN KEY (`friend`)
    REFERENCES `chat`.`login` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `chat`.`message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `chatsystemdb`.`message` (
  `sender` VARCHAR(25) NOT NULL,
  `receiver` VARCHAR(25) NOT NULL,
  `MsgID` INT(11) NOT NULL AUTO_INCREMENT,
  `Message` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`MsgID`),
  INDEX `fk_table1_users_idx` (`sender` ASC),
  INDEX `fk_table1_users1_idx` (`receiver` ASC),
  CONSTRAINT `fk_table1_users`
    FOREIGN KEY (`sender`)
    REFERENCES `chat`.`login` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_users1`
    FOREIGN KEY (`receiver`)
    REFERENCES `chat`.`login` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
