-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Patients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Patients` (
  `Patientid` INT NOT NULL,
  `Fname` VARCHAR(255) NOT NULL,
  `Lname` VARCHAR(255) NOT NULL,
  `Contact` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Patientid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Department`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Department` (
  `Departmentid` INT NOT NULL,
  `Name` VARCHAR(255) NOT NULL,
  `PatientPrivacy` INT NOT NULL,
  PRIMARY KEY (`Departmentid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Doctors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Doctors` (
  `Doctorid` INT NOT NULL,
  `Fname` VARCHAR(255) NOT NULL,
  `Lname` VARCHAR(255) NOT NULL,
  `Departmentid` INT NOT NULL,
  `Contact` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Doctorid`),
  INDEX `doc_dept_idx` (`Departmentid` ASC) VISIBLE,
  CONSTRAINT `doc_dept`
    FOREIGN KEY (`Departmentid`)
    REFERENCES `mydb`.`Department` (`Departmentid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Nurse`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Nurse` (
  `Nurseid` INT NOT NULL,
  `Fname` VARCHAR(255) NOT NULL,
  `Lname` VARCHAR(255) NOT NULL,
  `Contact` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Nurseid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Inventory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Inventory` (
  `Inventoryid` INT NOT NULL,
  `Name` VARCHAR(255) NOT NULL,
  `Cost` DOUBLE NOT NULL,
  `Quantity` DOUBLE NOT NULL,
  PRIMARY KEY (`Inventoryid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Appointment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Appointment` (
  `Appointmentid` INT NOT NULL,
  `Patientid` INT NOT NULL,
  `Doctorid` INT NOT NULL,
  `ArrivalTime` DATETIME NOT NULL,
  `AppointmentTime` DATETIME NOT NULL,
  `Checkintime` DATETIME NOT NULL,
  `Appointmentcol` DATETIME NOT NULL,
  `DoctorsNotes` MEDIUMTEXT NULL,
  PRIMARY KEY (`Appointmentid`),
  INDEX `app_pat_idx` (`Patientid` ASC) VISIBLE,
  INDEX `app_doc_idx` (`Doctorid` ASC) VISIBLE,
  CONSTRAINT `app_pat`
    FOREIGN KEY (`Patientid`)
    REFERENCES `mydb`.`Patients` (`Patientid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `app_doc`
    FOREIGN KEY (`Doctorid`)
    REFERENCES `mydb`.`Doctors` (`Doctorid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Services`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Services` (
  `Serviceid` INT NOT NULL,
  `Name` VARCHAR(255) NOT NULL,
  `Price` DOUBLE NOT NULL,
  PRIMARY KEY (`Serviceid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Billing`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Billing` (
  `Appointmentid` INT NOT NULL,
  `Serviceid` INT NOT NULL,
  INDEX `bill_app_idx` (`Appointmentid` ASC) VISIBLE,
  INDEX `bill_serv_idx` (`Serviceid` ASC) VISIBLE,
  CONSTRAINT `bill_app`
    FOREIGN KEY (`Appointmentid`)
    REFERENCES `mydb`.`Appointment` (`Appointmentid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bill_serv`
    FOREIGN KEY (`Serviceid`)
    REFERENCES `mydb`.`Services` (`Serviceid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Procedure`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Procedure` (
  `ProcedureId` INT NOT NULL,
  `Name` VARCHAR(45) NOT NULL,
  `Serviceid` INT NOT NULL,
  PRIMARY KEY (`ProcedureId`),
  INDEX `prod_serv_idx` (`Serviceid` ASC) VISIBLE,
  CONSTRAINT `prod_serv`
    FOREIGN KEY (`Serviceid`)
    REFERENCES `mydb`.`Services` (`Serviceid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Checklist`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Checklist` (
  `Procedureid` INT NOT NULL,
  `Order` INT NOT NULL,
  `Checklistcol` VARCHAR(45) NULL,
  PRIMARY KEY (`Procedureid`),
  CONSTRAINT `check_proc`
    FOREIGN KEY (`Procedureid`)
    REFERENCES `mydb`.`Procedure` (`ProcedureId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
