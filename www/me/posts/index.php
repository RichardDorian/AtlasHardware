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
$title = "My posts";

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

    // If the user is connected, get the list of their posts and check which ones are saved
    if (UserSession::is_connected()) {
      $user_posts = UserSession::get_user_posts();

      $user_post_ids = [];
      foreach ($user_posts as $post) {
        $user_post_ids[] = $post->id;
      }
      $saved_user_posts = UserSession::are_saved_posts($user_post_ids);
    }
    ?>

    <!-- Display the user's posts -->
    <h1>
      <span class="material-symbols-rounded">article</span>
      <span>My posts</span>
    </h1>
    <div>
      <div class="section-content">
        <?php
        // If the user is not connected, display a message
        if (!UserSession::is_connected()) {
          echo "<p>You need to be logged in to see your posts</p>";
        } else {
          // If the user has not posted anything, display a message
          if (count($user_posts) === 0) {
            echo "<p>You haven't posted anything yet</p>";
          }

          // For each post, display a card with the post details and a save/unsave button
          foreach ($user_posts as $post) {
            small_card($post, in_array($post->id, $saved_user_posts));
          }
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
