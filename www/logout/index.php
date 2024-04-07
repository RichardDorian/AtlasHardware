<?php
include_once __DIR__ . "/../../utils/user_session.php";

UserSession::logout();
$redirect = $_GET['redirect'] ?? '/';
header("Location: $redirect");
