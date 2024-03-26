<?php

require_once __DIR__ . "/index.php";
require_once __DIR__ . "/../error.php";

function setup_database(): void
{
  $link = get_database_link();

  if (gettype($link) === "integer") {
    exit_from_error_code_map($link, [
      1 => ["Error: missing environment variables", 500],
      2 => ["Error: unknown error, could not connect to database", 500],
      1045 => ["Error: invalid credentials, could not connect to database", 500],
      2002 => ["Error: could not reach database, could not connect to database", 500]
    ]);
  }

  $setup_file_path = __DIR__ . "/setup.sql";
  $setup_ressource = fopen($setup_file_path, "r");
  $setup = fread($setup_ressource, filesize($setup_file_path));

  $link->multi_query($setup);
  while ($link->next_result()) {}; // We wait for all the queries to finish
  $link->select_db("atlashardware");

  echo "Database and tables created successfully";
}
