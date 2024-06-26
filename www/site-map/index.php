<!DOCTYPE html>
<html lang="en">
<?php
// Define the CSS and JS files to be included in the head of the document
$styles = ["header.css", "info-text.css", "footer.css", "site-map.css"];
$scripts = ["header.js"];

$title = "Site map";

// Include the head component with the defined variables
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <?php
  // Include the header component
  include_once __DIR__ . "/../../components/header/header.php"
  ?>

  <!-- Main content of the page -->
  <main>

    <!-- Title of the page -->
    <h1>
      <span class="material-symbols-rounded">
        Lan
      </span>
      <span>Site Map</span>
    </h1>

    <div>
      <h2>
        <span class="material-symbols-rounded">
          explore
        </span>
        <span>Explore</span>
      </h2>
      <a href="/">Home</a>
      <a href="/browse">Browse</a>
      <a href="/add-post">Add Post</a>
      <a href="/stats">Stats</a>
    </div>

    <div>
      <h2>
        <span class="material-symbols-rounded">
          emoji_people
        </span>
        <span>My stuff</span>
      </h2>
      <a href="/me/saved">Saved</a>
      <a href="/me/posts">Posts</a>
    </div>

    <div>
      <h2>
        <span class="material-symbols-rounded">
          account_circle
        </span>
        <span>Account Management</span>
      </h2>
      <a href="/register">Register</a>
      <a href="/login">Login</a>
      <a href="/logout">Logout</a>
    </div>

    <div>
      <h2>
        <span class="material-symbols-rounded">Book</span>
        <span>
          Rules and Privacy Respect
        </span>
      </h2>

      <a href="/conditions-of-use">Condition of use</a>
      <a href="/privacy-policy">Privacy policy</a>
    </div>
  </main>

  <?php 
  // Include the footer component
  include_once __DIR__ . "/../../components/footer/footer.php" 
  ?>
  
</body>

</html>