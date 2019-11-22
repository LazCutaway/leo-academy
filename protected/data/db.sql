-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `audit`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `audit` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `dateof` DATE NULL DEFAULT NULL,
  `username` VARCHAR(255) NULL DEFAULT NULL,
  `code` INT(11) NULL DEFAULT NULL,
  `message` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `export`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `export` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `query` TEXT NOT NULL,
  `json_params` TEXT NOT NULL,
  `description` TEXT NOT NULL,
  `nome` VARCHAR(250) NULL DEFAULT NULL,
  `tipo` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `lov`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lov` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `lista` VARCHAR(50) NOT NULL,
  `codice` VARCHAR(50) NULL DEFAULT NULL,
  `descrizione` VARCHAR(50) NULL DEFAULT NULL,
  `ordine` INT(5) NULL DEFAULT NULL,
  `flag_attivo` TINYINT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `srbac_assignments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `srbac_assignments` (
  `itemname` VARCHAR(64) NOT NULL,
  `userid` VARCHAR(64) NOT NULL,
  `bizrule` VARCHAR(255) NULL DEFAULT NULL,
  `data` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`itemname`, `userid`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `srbac_itemchildren`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `srbac_itemchildren` (
  `parent` VARCHAR(64) NOT NULL,
  `child` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`parent`, `child`),
  INDEX `srbac_itemchildren_idx` (`child` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `srbac_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `srbac_items` (
  `name` VARCHAR(64) NOT NULL,
  `type` INT(11) NOT NULL,
  `description` VARCHAR(255) NULL DEFAULT NULL,
  `bizrule` VARCHAR(255) NULL DEFAULT NULL,
  `data` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`name`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tbl_audit_trail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tbl_audit_trail` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `old_value` TEXT NULL DEFAULT NULL,
  `new_value` TEXT NULL DEFAULT NULL,
  `action` VARCHAR(255) NOT NULL,
  `model` VARCHAR(255) NOT NULL,
  `field` VARCHAR(255) NULL DEFAULT NULL,
  `stamp` DATETIME NOT NULL,
  `user_id` VARCHAR(255) NULL DEFAULT NULL,
  `model_id` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_audit_trail_user_id` (`user_id` ASC),
  INDEX `idx_audit_trail_model_id` (`model_id` ASC),
  INDEX `idx_audit_trail_model` (`model` ASC),
  INDEX `idx_audit_trail_field` (`field` ASC),
  INDEX `idx_audit_trail_action` (`action` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `surname` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `track`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `track` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `owner_id` INT NOT NULL,
  `title` VARCHAR(45) NOT NULL,
  `description` TEXT(1000) NULL,
  `is_public` TINYINT NOT NULL DEFAULT 0,
  `publishing_date` DATETIME NULL,
  `is_featured` TINYINT NULL,
  `price` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `title_UNIQUE` (`title` ASC),
  INDEX `fk_track_user1_idx` (`owner_id` ASC),
  CONSTRAINT `fk_track_user1`
    FOREIGN KEY (`owner_id`)
    REFERENCES `user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `audit_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `audit_log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `track_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_audit_log_user_idx` (`user_id` ASC),
  INDEX `fk_audit_log_track1_idx` (`track_id` ASC),
  CONSTRAINT `fk_audit_log_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_audit_log_track1`
    FOREIGN KEY (`track_id`)
    REFERENCES `track` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `genre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `genre` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_genre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_genre` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `genre_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_genre_user1_idx` (`user_id` ASC),
  INDEX `fk_user_genre_genre1_idx` (`genre_id` ASC),
  CONSTRAINT `fk_user_genre_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_genre_genre1`
    FOREIGN KEY (`genre_id`)
    REFERENCES `genre` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_track_bookmark`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_track_bookmark` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `track_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `purchase_date` DATETIME NULL,
  `eclusive` TINYINT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_user_track_track1_idx` (`track_id` ASC),
  INDEX `fk_user_track_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_track_track1`
    FOREIGN KEY (`track_id`)
    REFERENCES `track` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_track_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `track_genre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `track_genre` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `track_id` INT NOT NULL,
  `genre_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_track_genre_track1_idx` (`track_id` ASC),
  INDEX `fk_track_genre_genre1_idx` (`genre_id` ASC),
  CONSTRAINT `fk_track_genre_track1`
    FOREIGN KEY (`track_id`)
    REFERENCES `track` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_track_genre_genre1`
    FOREIGN KEY (`genre_id`)
    REFERENCES `genre` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
