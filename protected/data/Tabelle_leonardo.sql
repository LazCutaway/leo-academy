-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `employeeType`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `employeeType` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `source`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `source` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `employee`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `employee` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `identification` VARCHAR(45) NOT NULL,
  `surname` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `is_deleted` TINYINT(1) NOT NULL DEFAULT 0,
  `last_edit_time` DATETIME NOT NULL DEFAULT now(),
  `supervisor_email` VARCHAR(45) NULL,
  `employeeType_id` INT NOT NULL,
  `source_id` INT NOT NULL,
  PRIMARY KEY (`id`, `employeeType_id`, `source_id`),
  UNIQUE INDEX `identification_UNIQUE` (`identification` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_employee_employeeType_idx` (`employeeType_id` ASC),
  INDEX `fk_employee_source1_idx` (`source_id` ASC),
  CONSTRAINT `fk_employee_employeeType`
    FOREIGN KEY (`employeeType_id`)
    REFERENCES `employeeType` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_employee_source1`
    FOREIGN KEY (`source_id`)
    REFERENCES `source` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `courseType`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `courseType` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teacher`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teacher` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `surname` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `is_deleted` TINYINT(1) NOT NULL DEFAULT 0,
  `employee_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_teacher_employee1_idx` (`employee_id` ASC),
  CONSTRAINT `fk_teacher_employee1`
    FOREIGN KEY (`employee_id`)
    REFERENCES `employee` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `course`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `course` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `protocol` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `date` DATE NOT NULL,
  `slot` INT NULL,
  `last_edit_time` DATETIME NOT NULL DEFAULT now(),
  `source_id` INT NOT NULL,
  `courseType_id` INT NOT NULL,
  `teacher_id` INT NOT NULL,
  PRIMARY KEY (`id`, `source_id`, `courseType_id`, `teacher_id`),
  INDEX `fk_course_source1_idx` (`source_id` ASC),
  INDEX `fk_course_courseType1_idx` (`courseType_id` ASC),
  INDEX `fk_course_teacher1_idx` (`teacher_id` ASC),
  CONSTRAINT `fk_course_source1`
    FOREIGN KEY (`source_id`)
    REFERENCES `source` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_courseType1`
    FOREIGN KEY (`courseType_id`)
    REFERENCES `courseType` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_teacher1`
    FOREIGN KEY (`teacher_id`)
    REFERENCES `teacher` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `attendance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `course_id` INT NOT NULL,
  `employee_id` INT NOT NULL,
  PRIMARY KEY (`id`, `course_id`, `employee_id`),
  INDEX `fk_attendance_course1_idx` (`course_id` ASC),
  INDEX `fk_attendance_employee1_idx` (`employee_id` ASC),
  CONSTRAINT `fk_attendance_course1`
    FOREIGN KEY (`course_id`)
    REFERENCES `course` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_attendance_employee1`
    FOREIGN KEY (`employee_id`)
    REFERENCES `employee` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
