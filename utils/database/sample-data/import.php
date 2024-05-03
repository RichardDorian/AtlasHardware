<?php

require_once __DIR__ . "/../index.php";
require_once __DIR__ . "/../../error.php";

function import_sample_data(): void
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

  $data_files = [
    __DIR__ . "/users.sql",
    __DIR__ . "/images.sql",
    __DIR__ . "/posts.sql",
    __DIR__ . "/post_images.sql",
    __DIR__ . "/comments.sql",
  ];

  foreach ($data_files as $file_path) {
    $file_resource = fopen($file_path, "r");
    $file = fread($file_resource, filesize($file_path));

    $link->multi_query($file);
    while ($link->next_result()) {
    }; // We wait for all the queries to finish
  }

  echo "Sample data successfuly imported";
}
