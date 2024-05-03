<?php
// Include the component for generating the card elements
include_once __DIR__ . "../../../../components/cards/index.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php
// Define the CSS and JS files to be included in the head of the document
$styles = ["header.css", "cards.css", "saved_search.css", "footer.css"];
$scripts = ["header.js", "save-unsave.js"];

// Define the title of the document
$title = "Saved posts";

// Include the head component with the defined variables
include_once __DIR__ . "../../../../components/head/head.php";
?>

<body>
  <?php
  // Include the header component
  include_once __DIR__ . "../../../../components/header/header.php";
  ?>

  <main>
    <?php
    // Include the utility file for handling posts
    include_once __DIR__ . "../../../../utils/posts.php";

    // If the user is not connected, redirect to the login page
    if (!UserSession::is_connected()) {
      header("Location: /login");
      exit();
    } else {
      // Get the list of saved posts for the connected user
      $saved_builds = UserSession::get_saved_posts();
    }
    ?>

    <!-- Display the saved builds -->
    <h1>
      <span class="material-symbols-rounded">bookmark</span>
      <span>Saved Builds</span>
    </h1>
    <div>
      <div class="section-content">
        <?php
        // If the user has not saved any builds, display a message
        if (count($saved_builds) === 0) {
          echo "<p>You haven't saved any build yet</p>";
        }

        // For each saved build, display a card with the build details
        foreach ($saved_builds as $post) {
          small_card($post, true);
        }
        ?>
      </div>
    </div>
  </main>

  <?php
  // Include the footer component
  include_once __DIR__ . "../../../../components/footer/footer.php";
  ?>

</body>

</html>
