<?php

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  include_once "./setup_form.html";
  exit();
}

require_once __DIR__ . "/../../../../utils/error.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $key = getenv("ADMIN_KEY");

  if ($key === false)
    exit_with_error("Error: ADMIN_KEY not set", 500);

  if (!isset($_POST["key"]))
    exit_with_error("Error: key not provided", 400);

  if ($_POST['key'] !== $key)
    exit_with_error("Error: invalid key", 403);

  require_once __DIR__ . "/../../../../utils/database/setup.php";
  $status_code = setup_database();

  exit();
}
