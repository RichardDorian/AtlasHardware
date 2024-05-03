<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") exit();

include_once __DIR__ . "/../../../utils/user_session.php";

if (!UserSession::is_connected()) {
  http_response_code(401);
  exit();
}

include_once __DIR__ . "/../../../utils/comment.php";

Comments::add_comment($_POST["comment"], $_GET["id"], $_SESSION["user_id"], NULL);
