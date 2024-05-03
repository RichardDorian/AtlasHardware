<?php

// If the request method is not POST, return a 405 Method Not Allowed status code and exit the script
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit();
}

// Include the utility file for handling user sessions
include_once __DIR__ . "/../../../utils/user_session.php";

// If the user is not connected, return a 401 Unauthorized status code and exit the script
if (!UserSession::is_connected()) {
  http_response_code(401);
  exit();
}

// If the post ID is not set or is not a valid hexadecimal string, return a 400 Bad Request status code and exit the script
if (!isset($_POST["post"]) || preg_match("/^[0-9a-fA-F]{32}$/", $_POST["post"]) !== 1) {
  http_response_code(400);
  exit();
}

// Include the utility files for handling the database and errors
include_once __DIR__ . "/../../../utils/database/index.php";
include_once __DIR__ . "/../../../utils/error.php";

// Get a link to the database
$link = get_database_link();

// If the link is not valid, exit the script with an error message and status code based on the error code map
if (gettype($link) === "integer") {
  exit_from_error_code_map($link, [
    1 => ["Error: missing environment variables", 500],
    2 => ["Error: unknown error, could not connect to database", 500],
  ]);
  exit();
}

// Get the post ID from the POST data
$post_id = $_POST["post"];

// Prepare and execute a query to check if the post exists in the database
$stmt = $link->prepare("SELECT id FROM posts WHERE id = unhex(?)");
$stmt->bind_param("s", $post_id);
$stmt->execute();
$result = $stmt->get_result();

// If the post does not exist, return a 404 Not Found status code and exit the script
if ($result->num_rows !== 1) {
  http_response_code(404);
  exit();
}

// Prepare and execute a query to check if the post is already saved by the user
$stmt = $link->prepare("SELECT hex(post) as post FROM users_saved_posts WHERE post = unhex(?) AND user = unhex(?)");
$stmt->bind_param("ss", $post_id, $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();

// If the post is not already saved by the user, return a 409 Conflict status code and exit the script
if ($result->num_rows !== 1) {
  http_response_code(409);
  exit();
}

// Prepare and execute a query to delete the saved post from the database
$stmt = $link->prepare("DELETE FROM users_saved_posts WHERE user = unhex(?) AND post = unhex(?)");
$stmt->bind_param("ss", $_SESSION["user_id"], $post_id);
$stmt->execute();
$result = $stmt->get_result();


