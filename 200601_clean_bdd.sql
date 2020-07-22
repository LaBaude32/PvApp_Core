-- MySQL Script generated by MySQL Workbench
-- lun. 01 juin 2020 11:37:20 CEST
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema pv_app_core_database
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema pv_app_core_database
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `pv_app_core_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;
USE `pv_app_core_database` ;

-- -----------------------------------------------------
-- Table `pv_app_core_database`.`affair`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pv_app_core_database`.`affair` (
  `id_affair` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `progress` INT NULL,
  `meeting_type` ENUM("Chantier", "Etude") NOT NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id_affair`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pv_app_core_database`.`lot`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pv_app_core_database`.`lot` (
  `id_lot` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `affair_id` INT NOT NULL,
  PRIMARY KEY (`id_lot`),
  INDEX `fk_lot_affair1_idx` (`affair_id` ASC) VISIBLE,
  CONSTRAINT `fk_lot_affair1`
    FOREIGN KEY (`affair_id`)
    REFERENCES `pv_app_core_database`.`affair` (`id_affair`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pv_app_core_database`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pv_app_core_database`.`user` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(10) NOT NULL,
  `user_group` VARCHAR(255) NULL,
  `user_function` VARCHAR(255) NULL,
  `organism` VARCHAR(255) NULL,
  PRIMARY KEY (`id_user`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pv_app_core_database`.`pv`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pv_app_core_database`.`pv` (
  `id_pv` INT NOT NULL AUTO_INCREMENT,
  `state` VARCHAR(255) NOT NULL,
  `meeting_date` TIMESTAMP NOT NULL,
  `meeting_place` VARCHAR(255) NOT NULL,
  `meeting_next_date` TIMESTAMP NULL,
  `meeting_next_place` VARCHAR(255) NULL,
  `affair_id` INT NOT NULL,
  `release_date` TIMESTAMP NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pv`),
  INDEX `fk_pv_affair1_idx` (`affair_id` ASC) VISIBLE,
  CONSTRAINT `fk_pv_affair1`
    FOREIGN KEY (`affair_id`)
    REFERENCES `pv_app_core_database`.`affair` (`id_affair`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `pv_app_core_database`.`item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pv_app_core_database`.`item` (
  `id_item` INT NOT NULL AUTO_INCREMENT,
  `position` INT NOT NULL,
  `note` TEXT NULL,
  `follow_up` TEXT NULL,
  `ressources` VARCHAR(255) NULL,
  `completion` VARCHAR(255) NULL,
  `completion_date` TIMESTAMP NULL,
  `visible` TINYINT NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id_item`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `pv_app_core_database`.`pv_has_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pv_app_core_database`.`pv_has_item` (
  `pv_id` INT NOT NULL,
  `item_id` INT NOT NULL,
  PRIMARY KEY (`pv_id`, `item_id`),
  INDEX `fk_pv_has_item_item1_idx` (`item_id` ASC) VISIBLE,
  INDEX `fk_pv_has_item_pv1_idx` (`pv_id` ASC) VISIBLE,
  CONSTRAINT `fk_pv_has_item_pv1`
    FOREIGN KEY (`pv_id`)
    REFERENCES `pv_app_core_database`.`pv` (`id_pv`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pv_has_item_item1`
    FOREIGN KEY (`item_id`)
    REFERENCES `pv_app_core_database`.`item` (`id_item`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `pv_app_core_database`.`pv_has_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pv_app_core_database`.`pv_has_user` (
  `pv_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `status_PAE` ENUM("Présent", "Absent, Excusé") NULL,
  `invited_current_meeting` TINYINT(1) NULL,
  `invited_next_meeting` TINYINT(1) NULL,
  `distribution` TINYINT(1) NULL,
  `owner` VARCHAR(45) NOT NULL DEFAULT 0,
  PRIMARY KEY (`pv_id`, `user_id`),
  INDEX `fk_pv_has_user_user1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_pv_has_user_pv1_idx` (`pv_id` ASC) VISIBLE,
  CONSTRAINT `fk_pv_has_user_pv1`
    FOREIGN KEY (`pv_id`)
    REFERENCES `pv_app_core_database`.`pv` (`id_pv`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pv_has_user_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `pv_app_core_database`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `pv_app_core_database`.`item_has_lot`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pv_app_core_database`.`item_has_lot` (
  `item_id` INT NOT NULL,
  `lot_id` INT NOT NULL,
  PRIMARY KEY (`item_id`, `lot_id`),
  INDEX `fk_item_has_lot_lot1_idx` (`lot_id` ASC) VISIBLE,
  INDEX `fk_item_has_lot_item1_idx` (`item_id` ASC) VISIBLE,
  CONSTRAINT `fk_item_has_lot_item1`
    FOREIGN KEY (`item_id`)
    REFERENCES `pv_app_core_database`.`item` (`id_item`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_has_lot_lot1`
    FOREIGN KEY (`lot_id`)
    REFERENCES `pv_app_core_database`.`lot` (`id_lot`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `pv_app_core_database`.`token`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pv_app_core_database`.`token` (
  `token` VARCHAR(45) NOT NULL,
  `device` VARCHAR(45) NOT NULL,
  `expiration_date` VARCHAR(45) NULL,
  `user_id_user` INT NOT NULL,
  PRIMARY KEY (`token`),
  INDEX `fk_token_user1_idx` (`user_id_user` ASC) VISIBLE,
  CONSTRAINT `fk_token_user1`
    FOREIGN KEY (`user_id_user`)
    REFERENCES `pv_app_core_database`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
