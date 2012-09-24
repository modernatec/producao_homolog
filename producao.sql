SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `producao` DEFAULT CHARACTER SET utf8 ;
USE `producao` ;

-- -----------------------------------------------------
-- Table `producao`.`moderna_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_roles` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_roles` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(32) NULL DEFAULT NULL ,
  `description` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `producao`.`moderna_user_tokens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_user_tokens` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_user_tokens` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `user_agent` VARCHAR(40) NULL DEFAULT NULL ,
  `token` VARCHAR(40) NULL DEFAULT NULL ,
  `type` VARCHAR(100) NULL DEFAULT NULL ,
  `created` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `expires` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `user_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `token_UNIQUE` (`token` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `producao`.`moderna_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_users` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_users` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(127) NULL DEFAULT NULL ,
  `username` VARCHAR(32) NOT NULL ,
  `password` VARCHAR(64) NOT NULL ,
  `logins` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `last_login` INT(10) UNSIGNED NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `producao`.`moderna_tasks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_tasks` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_tasks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `created_at` TIMESTAMP NULL ,
  `started_at` DATETIME NULL ,
  `finished_at` DATETIME NULL ,
  `priority_id` INT NOT NULL ,
  `project_id` INT NOT NULL ,
  `description` TEXT NULL ,
  `crono_date` DATETIME NULL ,
  `user_id` INT(11) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`, `priority_id`, `project_id`, `user_id`) ,
  INDEX `fk_moderna_tasks_moderna_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_moderna_tasks_moderna_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `producao`.`moderna_users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producao`.`moderna_tasks_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_tasks_users` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_tasks_users` (
  `task_id` INT NOT NULL ,
  `user_id` INT(11) NOT NULL ,
  PRIMARY KEY (`task_id`, `user_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producao`.`moderna_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_status` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_status` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `status` VARCHAR(45) NULL ,
  `roles_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`, `roles_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producao`.`moderna_status_tasks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_status_tasks` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_status_tasks` (
  `status_id` INT NOT NULL ,
  `tasks_id` INT NOT NULL ,
  `date` DATETIME NOT NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`status_id`, `tasks_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producao`.`moderna_files`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_files` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_files` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NULL ,
  `created_at` TIMESTAMP NULL ,
  `task_id` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producao`.`moderna_priority`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_priority` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_priority` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `priority` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producao`.`moderna_project`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_project` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_project` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `target` VARCHAR(45) NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producao`.`moderna_menus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_menus` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_menus` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `display` VARCHAR(45) NULL ,
  `link` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producao`.`moderna_menu_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_menu_roles` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_menu_roles` (
  `menu_id` INT NOT NULL ,
  `roles_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`menu_id`, `roles_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producao`.`moderna_roles_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_roles_users` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_roles_users` (
  `roles_id` INT(10) UNSIGNED NOT NULL ,
  `users_id` INT(11) UNSIGNED NOT NULL ,
  PRIMARY KEY (`roles_id`, `users_id`) ,
  INDEX `fk_moderna_roles_has_moderna_users_moderna_users1` (`users_id` ASC) ,
  INDEX `fk_moderna_roles_has_moderna_users_moderna_roles1` (`roles_id` ASC) ,
  CONSTRAINT `fk_moderna_roles_has_moderna_users_moderna_roles1`
    FOREIGN KEY (`roles_id` )
    REFERENCES `producao`.`moderna_roles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_moderna_roles_has_moderna_users_moderna_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `producao`.`moderna_users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `producao`.`moderna_menus_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_menus_roles` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_menus_roles` (
  `menu_id` INT(11) NOT NULL ,
  `role_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`menu_id`, `role_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `producao`.`moderna_priorities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producao`.`moderna_priorities` ;

CREATE  TABLE IF NOT EXISTS `producao`.`moderna_priorities` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `priority` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
