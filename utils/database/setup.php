<?php

require_once __DIR__ . "/index.php";
require_once __DIR__ . "/../error.php";

function setup_database(): void
{
  $database = getenv("DB_DATABASE");
  $link = get_database_link();

  if (gettype($link) === "integer") {
    exit_from_error_code_map($link, [
      1 => ["Error: missing environment variables", 500],
      2 => ["Error: unknown error, could not connect to database", 500],
      1045 => ["Error: invalid credentials, could not connect to database", 500],
      2002 => ["Error: could not reach database, could not connect to database", 500]
    ]);
  }

  $queries = [
    "DROP DATABASE IF EXISTS $database",
    "CREATE DATABASE $database",
    "CREATE TABLE `$database`.`users` (`id` BINARY(16) NOT NULL, `username` VARCHAR(20) NOT NULL, `password` VARCHAR(60) NOT NULL, `avatar` LONGBLOB NULL DEFAULT NULL, PRIMARY KEY (`id`), UNIQUE `username` (`username`)) ENGINE = InnoDB",
    "CREATE TABLE `$database`.`posts` (`id` BINARY(16) NOT NULL, `author` BINARY(16) NOT NULL, `date` DATETIME NOT NULL, `forked_from` BINARY(16) NULL DEFAULT NULL, `description` TEXT NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB"
  ];

  foreach ($queries as $query) {
    $link->query($query);
  }

  $link->select_db($database);

  echo "Database and tables created successfully";
}
