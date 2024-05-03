<?php
// Include the utility file for handling user sessions
include_once __DIR__ . "/../../utils/user_session.php";

// Initialize the status message and color variables
$status = "";
$color = "warning";

// If the form has been submitted with the POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Check if all required fields are set in the POST data
  if (
    !isset($_POST["username"]) ||
    !isset($_POST["password"])
  ) {
    $status = "Invalid form body";
    $color = "error";
  } else {

    // Try to log in the user with the provided credentials
    $result = UserSession::login($_POST["username"], $_POST["password"]);

    // Set the status message based on the result of the login attempt
    $status = match ($result) {
      1, 2, 3 => "Something went wrong while loggin in to your account, please try again later.",
      4 => "No account with this username was found. Please check your credentials and try again.",
      5 => "Wrong password, please check your credentials and try again.",
      default => "",
    };

    // If the login attempt failed, set the color to "error"
    if (in_array($result, [1, 2, 3])) $color = "error";

    // If the login attempt was successful, redirect to the home page
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
$scripts = ["header.js"];

// Define the title of the document
$title = "Login";

// Include the head component with the defined variables
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <?php
  // Include the header component
  include_once __DIR__ . "/../../components/header/header.php";
  ?>

  <main>
    <!-- Display the login form -->
    <div id="auth-parent">
      <div id="auth-select">
        <div class="tabs">
          <a disabled class="active">Login</a>
          <a href="/register">Register</a>
        </div>
      </div>
      <div id="status">
        <?php
        // If there's a status message, display it
        if (strlen($status) > 0)
          echo "<span class=\"$color\"><span class=\"material-symbols-rounded\">$color</span><span>$status</span></span>"
        ?>
      </div>
      <form action="/login" method="post" class="auth">
        <input class="styled" type="text" name="username" placeholder="Username" autocomplete="username" required minlength="4" maxlength="20">
        <input class="styled" type="password" name="password" placeholder="Password" autocomplete="current-password" required minlength="8" maxlength="100">
        <button class="styled" type="submit">Login</button>
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
