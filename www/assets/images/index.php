<?php

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  if (!isset($_GET["id"])) {
    header('HTTP/1.1 400 Bad Request');
    exit();
  }

  include_once __DIR__ . "/../../../utils/database/index.php";
  include_once __DIR__ . "/../../../utils/error.php";

  $link = get_database_link();
  if (gettype($link) === "integer") {
    exit_from_error_code_map($link, [
      1 => ["Error: missing environment variables", 500],
      2 => ["Error: unknown error, could not connect to database", 500],
    ]);
    exit();
  }

  $stmt = $link->prepare("SELECT image FROM images WHERE id = unhex(?)");
  $stmt->bind_param("s", $_GET["id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result === false) {
    exit_with_error("Unknown error", 500);
  }

  if ($result->num_rows !== 1) {
    header('HTTP/1.1 404 Not Found');
    exit();
  }

  header('Content-Type: image/webp');
  header('Cache-Control: public, max-age=270000');
  echo $result->fetch_assoc()["image"];

  exit();
}

header('HTTP/1.1 405 Method Not Allowed');
