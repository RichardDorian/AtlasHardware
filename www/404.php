<!DOCTYPE html>
<html lang="en">
<?php
$styles = ["header.css", "404.css", "footer.css"];
$scripts = ["header.js"];
$title = "Not Found";
include_once __DIR__ . "/../components/head/head.php";
?>

<body>
  <?php include_once __DIR__ . "/../components/header/header.php" ?>

  <main>
    <h1>(;-;)</h1>
    <h2>The page you are looking for doesn't exist</h2>
  </main>

  <?php
  include_once __DIR__ . "/../components/footer/footer.php"
  ?>
</body>

</html>