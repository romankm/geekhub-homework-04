<?php

return <<<'schema'
CREATE TABLE `university`.`universities` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `city` VARCHAR(255) NOT NULL,
  `site` VARCHAR(255) NULL,
  PRIMARY KEY (`id`)
) ENGINE = INNODB CHARSET = utf8;

CREATE TABLE `university`.`departments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `university_id` INT NULL,
  FOREIGN KEY (`university_id`) REFERENCES `universities`(`id`) ON DELETE SET NULL,
  PRIMARY KEY (`id`)
) ENGINE = INNODB CHARSET = utf8;

CREATE TABLE `university`.`students` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `telephone` VARCHAR(255) NOT NULL,
  `department_id` INT NULL,
  FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL,
  PRIMARY KEY (`id`)
) ENGINE = INNODB CHARSET = utf8;

CREATE TABLE `university`.`teachers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `telephone` VARCHAR(255) NOT NULL,
  `department_id` INT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL
) ENGINE = INNODB CHARSET = utf8;

CREATE TABLE `university`.`subjects` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `department_id` INT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL
) ENGINE = INNODB CHARSET = utf8;

CREATE TABLE `university`.`home_tasks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `done` TINYINT(1) NOT NULL DEFAULT 0,
  `student_id` INT NULL,
  `department_id` INT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL
) ENGINE = INNODB CHARSET = utf8;
schema;
