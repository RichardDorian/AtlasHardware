DROP DATABASE IF EXISTS atlashardware;

CREATE DATABASE `atlashardware`;

CREATE TABLE `atlashardware`.`users` (
  `id` BINARY(16) NOT NULL,
  `username` VARCHAR(20) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  `avatar` LONGBLOB NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE username (`username`)
) ENGINE = InnoDB;

CREATE TABLE `atlashardware`.`posts` (
  `id` BINARY(16) NOT NULL,
  `author` BINARY(16) NOT NULL,
  `date` DATETIME NOT NULL,
  `forked_from` BINARY(16) NULL DEFAULT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author`) REFERENCES `users`(`id`),
  FOREIGN KEY (`forked_from`) REFERENCES `posts`(`id`)
) ENGINE = InnoDB;

CREATE TABLE `atlashardware`.`comments` (
  `id` BINARY(16) NOT NULL,
  `author` BINARY(16) NOT NULL,
  `post` BINARY(16) NOT NULL,
  `replied_to` BINARY(16) NULL DEFAULT NULL,
  `date` DATETIME NOT NULL,
  `comment` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author`) REFERENCES `users`(`id`),
  FOREIGN KEY (`post`) REFERENCES `posts`(`id`),
  FOREIGN KEY (`replied_to`) REFERENCES `comments`(`id`)
) ENGINE = InnoDB;