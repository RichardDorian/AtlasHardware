<?php
include_once __DIR__ . "/../../utils/user_session.php";

UserSession::logout();
header("Location: /");
