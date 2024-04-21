<?php include_once __DIR__ . "/../../utils/user_session.php" ?>

<?php
$status = "";
$color = "warning";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (
    !isset($_POST["username"]) ||
    !isset($_POST["password"])
  ) {
    $status = "Invalid form body";
    $color = "error";
  } else {
    $result = UserSession::login($_POST["username"], $_POST["password"]);

    $status = match ($result) {
      1, 2, 3 => "Something went wrong while loggin in to your account, please try again later.",
      4 => "No account with this username was found. Please check your credentials and try again.",
      5 => "Wrong password, please check your credentials and try again.",
      default => "",
    };

    if (in_array($result, [1, 2, 3])) $color = "error";

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
$scripts = ["header.js"];
$title = "Login";
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <?php include_once __DIR__ . "/../../components/header/header.php" ?>

  <main>
    <div id="auth-parent">
      <div id="auth-select">
        <div class="tabs">
          <a disabled class="active">Login</a>
          <a href="/register">Register</a>
        </div>
      </div>
      <div id="status">
        <?php
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
  $hide_register_footer = true;
  include_once __DIR__ . "/../../components/footer/footer.php"
  ?>
</body>

</html>