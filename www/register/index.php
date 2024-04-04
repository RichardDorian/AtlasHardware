<?php include_once __DIR__ . "/../../utils/user_session.php" ?>

<?php
$status = "";
$color = "warning";

function stringlength($string, $name, $min, $max)
{
  global $status;
  if (strlen($string) < $min) {
    $status = "The $name must be at least $min characters long";
    return false;
  }

  if (strlen($string) > $max) {
    $status = "The $name must be at most $max characters long";
    return false;
  }

  return true;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (
    !isset($_POST["username"]) ||
    !isset($_POST["password"]) ||
    !isset($_POST["password-repeat"])
  ) {
    $status = "Invalid form body";
    $color = "danger";
  } else if (!stringlength($_POST["username"], "username", 4, 20));
  else if (!stringlength($_POST["password"], "password", 8, 100));

  else if ($_POST["password"] !== $_POST["password-repeat"]) {
    $status = "Passwords do not match";
    $color = "danger";
  } else {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = UserSession::register($username, $password);

    $status = match ($result) {
      1, 2, 3 => "Something went wrong while registering your account, please try again later.",
      4 => "This username is already taken, please choose another one.",
      default => "",
    };

    if (in_array($result, [1, 2, 3, 4])) $color = "danger";

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
$styles = ["header.css", "auth-forms.css", "tabs.css", "button.css", "input.css", "footer.css"];
$scripts = ["header.js", "register.js"];
$title = "Register";
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <?php include_once __DIR__ . "/../../components/header/header.php" ?>

  <main>
    <div id="auth-select">
      <div class="tabs">
        <a href="/login">Login</a>
        <a disabled class="active">Register</a>
      </div>
    </div>
    <div id="status">
      <?php
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
  </main>

  <?php
  $hide_register_footer = true;
  include_once __DIR__ . "/../../components/footer/footer.php"
  ?>
</body>

</html>