<?php

/** Get a link to the database
 * @return int|mysqli
 */
function get_database_link(): int | \mysqli
{
  $host = getenv("DB_HOST");
  $user = getenv("DB_USER");
  $password = getenv("DB_PASSWORD");
  $database = "atlashardware";

  if ($password === false) $password = NULL;

  if ($host === false || $user === false) {
    return 1;
  }

  // We add p: before the host to force the use of a persistent connection
  $link = NULL;
  try {
    $link = mysqli_connect("p:$host", $user, $password);
  } catch (\mysqli_sql_exception $exception) {
    return $exception->getCode();
  }

  if ($link === false)
    return 2;

  // If the database already exists, we select it. Otherwise, it'll be created when the admin sets up the database
  if (does_database_exist($link, $database)) {
    $link->select_db($database);
  }

  return $link;
}

/** Check if a database exists
 * @param mysqli $link
 * @param string $database
 * @return bool
 */
function does_database_exist(\mysqli $link, string $database): bool
{
  $stmt = $link->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
  $stmt->bind_param("s", $database);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->num_rows > 0;
}
