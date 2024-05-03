<?php

// If the request method is not POST, exit the script
if ($_SERVER["REQUEST_METHOD"] !== "POST") exit();

// Include the utility file for handling user sessions
include_once __DIR__ . "/../../../utils/user_session.php";

// If the user is not connected, return a 401 Unauthorized status code and exit the script
if (!UserSession::is_connected()) {
  http_response_code(401);
  exit();
}

// Include the utility file for handling comments
include_once __DIR__ . "/../../../utils/comment.php";

// Add a new comment to the database
Comments::add_comment($_POST["comment"], $_GET["id"], $_SESSION["user_id"], NULL);
