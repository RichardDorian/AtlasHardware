<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit();
}

include_once __DIR__ . "/../../../utils/user_session.php";

if (!UserSession::is_connected()) {
  http_response_code(401);
  exit();
}

if (!isset($_POST["post"]) || preg_match("/^[0-9a-fA-F]{32}$/", $_POST["post"]) !== 1) {
  http_response_code(400);
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

$post_id = $_POST["post"];

$stmt = $link->prepare("SELECT id FROM posts WHERE id = unhex(?)");
$stmt->bind_param("s", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  http_response_code(404);
  exit();
}

$stmt = $link->prepare("SELECT hex(post) as post FROM users_saved_posts WHERE post = unhex(?) AND user = unhex(?)");
$stmt->bind_param("ss", $post_id, $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  http_response_code(409);
  exit();
}

$stmt = $link->prepare("DELETE FROM users_saved_posts WHERE user = unhex(?) AND post = unhex(?)");
$stmt->bind_param("ss", $_SESSION["user_id"], $post_id);
$stmt->execute();
$result = $stmt->get_result();
