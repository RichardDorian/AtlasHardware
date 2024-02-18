<?php

function get_database_link(): \mysqli
{
  $host = getenv("DB_HOST");
  $user = getenv("DB_USER");
  $password = getenv("DB_PASSWORD");
  $database = getenv("DB_DATABASE");

  if ($password === false) $password = NULL;

  if ($host === false || $user === false || $database === false) {
    require_once "../error.php";
    exit_with_error("Error: missing environment variables", 500);
  }

  # We add p: before the host to force the use of a persistent connection
  $link = mysqli_connect("p:$host", $user, $password);

  if ($link === false)
    exit_with_error("Error: could not connect to database", 500);

  # If the database already exists, we select it. Otherwise, it'll be created when the admin sets up the database
  if (does_database_exist($link, $database)) {
    $link->select_db($database);
  }

  return $link;
}

function does_database_exist(\mysqli $link, string $database): bool
{
  $stmt = $link->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
  $stmt->bind_param("s", $database);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->num_rows > 0;
}
