<?php
// Include the utility file for handling user sessions
include_once __DIR__ . "/../../utils/user_session.php";

// Initialize the status message and color variables
$status = "";
$color = "warning";

/**
 * Function to check if a string has a valid length
 * 
 * @param string $string The string to check
 * @param string $name The name of the string
 * @param int $min The minimum length of the string
 * @param int $max The maximum length of the string
 * 
 * @return bool True if the string has a valid length, false otherwise
 */
function stringlength($string, $name, $min, $max)
{
  global $status;

  // Check if the string is shorter than the minimum length
  if (strlen($string) < $min) {
    $status = "The $name must be at least $min characters long";
    return false;
  }

  // Check if the string is longer than the maximum length
  if (strlen($string) > $max) {
    $status = "The $name must be at most $max characters long";
    return false;
  }

  // If the string length is valid, return true
  return true;
}

// If the form has been submitted with the POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Check if all required fields are set in the POST data
  if (
    !isset($_POST["username"]) ||
    !isset($_POST["password"]) ||
    !isset($_POST["password-repeat"])
  ) {
    $status = "Invalid form body";
    $color = "error";
  }

  // Check if the username has a valid length
  else if (!stringlength($_POST["username"], "username", 4, 20));

  // Check if the password has a valid length
  else if (!stringlength($_POST["password"], "password", 8, 100));

  // Check if the passwords match
  else if ($_POST["password"] !== $_POST["password-repeat"]) {
    $status = "Passwords do not match";
    $color = "error";
  }

  // If all checks pass, register the user
  else {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Try to register the user
    $result = UserSession::register($username, $password);

    // Set the status message based on the result of the registration
    $status = match ($result) {
      1, 2, 3 => "Something went wrong while registering your account, please try again later.",
      4 => "This username is already taken, please choose another one.",
      default => "",
    };

    // If the registration failed, set the color to "error"
    if (in_array($result, [1, 2, 3, 4])) $color = "error";

    // If the registration was successful, redirect to the homepage
    if ($result === 0) {
      header("Location: /");
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
// Define the CSS and JS files to be included in the head of the document
$styles = ["header.css", "auth-forms.css", "tabs.css", "button.css", "input.css", "footer.css"];
$scripts = ["header.js", "register.js"];

// Define the title of the document
$title = "Register";

// Include the head component with the defined variables
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <?php
  // Include the header component
  include_once __DIR__ . "/../../components/header/header.php";
  ?>

  <main>
    <!-- Display the registration form -->
    <div id="auth-parent">
      <div id="auth-select">
        <div class="tabs">
          <a href="/login">Login</a>
          <a disabled class="active">Register</a>
        </div>
      </div>
      <div id="status">
        <?php
        // If there's a status message, display it
        if (strlen($status) > 0)
          echo "<span class=\"$color\"><span class=\"material-symbols-rounded\">$color</span><span>$status</span></span>"
        ?>
      </div>
      <form action="/register" method="post" class="auth">
        <input class="styled" type="text" name="username" placeholder="Username" autocomplete="username" required minlength="4" maxlength="20">
        <input class="styled" type="password" name="password" placeholder="Password" autocomplete="new-password" required minlength="8" maxlength="100">
        <input class="styled" type="password" name="password-repeat" placeholder="Repeat password" autocomplete="new-password" required minlength="8" maxlength="100">
        <button class="styled" type="submit">Register</button>
      </form>
    </div>
  </main>

  <?php
  // Set the flag to hide the register link in the footer
  $hide_register_footer = true;

  // Include the footer component
  include_once __DIR__ . "/../../components/footer/footer.php";
  ?>

</body>

</html>
