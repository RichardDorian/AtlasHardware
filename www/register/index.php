<?php include_once __DIR__ . "/../../utils/user_session.php" ?>
<?php include_once __DIR__ . "/../../utils/error.php" ?>

<?php
$status = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (
    !isset($_POST["username"]) ||
    !isset($_POST["password"]) ||
    !isset($_POST["password-repeat"])
  )
    $status = "Invalid form body";

  else if ($_POST["password"] !== $_POST["password-repeat"])
    $status = "Passwords do not match";

  else {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = UserSession::register($username, $password);

    $status = match ($result) {
      1, 2, 3 => "Something went wrong while registering your account, please try again later.",
      4 => "This username is already taken, please choose another one.",
      default => "",
    };

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
$styles = ["header.css", "auth-forms.css", "footer.css"];
$scripts = ["header.js"];
$title = "Register";
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <?php include_once __DIR__ . "/../../components/header/header.php" ?>

  <main>
    <div id="auth-select">
      <button>Login</button>
      <button disabled>Register</button>
    </div>

    <?php echo $status ?>

    <form action="/register" method="post">
      <input type="text" name="username" placeholder="Username" autocomplete="username" required>
      <input type="password" name="password" placeholder="Password" autocomplete="new-password" required>
      <input type="password" name="password-repeat" placeholder="Repeat password" autocomplete="new-password" required>
      <button type="submit">Register</button>
    </form>
  </main>

  <?php
  $hide_register_footer = true;
  include_once __DIR__ . "/../../components/footer/footer.php"
  ?>
</body>

</html>