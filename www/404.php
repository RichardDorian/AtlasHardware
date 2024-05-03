<!DOCTYPE html>
<html lang="en">
<?php

// Define the CSS and JS files to be included in the head of the document
$styles = ["header.css", "404.css", "footer.css"];
$scripts = ["header.js"];

$title = "Not Found";

// Include the head component with the defined variables
include_once __DIR__ . "/../components/head/head.php";
?>

<body>

  <?php
  // Include the header component
  include_once __DIR__ . "/../components/header/header.php"
  ?>

  <!-- Main content of the page -->
  <main>
    <h1>(;-;)</h1>
    <h2>The page you are looking for doesn't exist</h2>
  </main>

  <?php
  // Include the footer component
  include_once __DIR__ . "/../components/footer/footer.php"
  ?>

</body>

</html>