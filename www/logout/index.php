<?php

// Include the utility file for handling user sessions
include_once __DIR__ . "/../../utils/user_session.php";

// Log out the current user
UserSession::logout();

// Get the redirect URL from the query string, or default to the home page
$redirect = $_GET['redirect'] ?? '/';

// Redirect the user to the specified URL
header("Location: $redirect");
