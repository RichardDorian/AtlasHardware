<?php
// Include the component for generating the card elements
include_once __DIR__ . "/../components/cards/index.php";
?>

<!DOCTYPE html>
<html lang="en">
<?php

// Define the CSS and JS files to be included in the head of the document
$styles = ["header.css", "home.css", "cards.css", "footer.css"];
$scripts = ["header.js", "save-unsave.js"];

$title = "Home";

// Include the head component with the defined variables
include_once __DIR__ . "/../components/head/head.php";
?>

<body>
  <?php
  // Include the header component
  include_once __DIR__ . "/../components/header/header.php";
  ?>
  <main>
    <?php
    // Include the posts utility
    include_once __DIR__ . "/../utils/posts.php";

    // Fetch the latest posts and the posts with the best performance
    $latest_posts = Posts::get_latest_posts();
    $best_perf = Posts::get_best_perf();

    // Initialize arrays to store the saved builds and posts
    $saved_builds = [];
    $saved_posts_in_others = [];

    // Check if the user is connected
    if (UserSession::is_connected()) {
      // Get the IDs of the latest posts and the posts with the best performance
      $post_ids = [];
      foreach ([...$latest_posts, ...$best_perf] as $post) {
        if (!in_array($post->id, $post_ids)) $post_ids[] = $post->id;
      }

      // Check if the user has saved any of these posts
      $saved_posts_in_others = UserSession::are_saved_posts($post_ids);

      // Get the posts saved by the user
      $saved_builds = UserSession::get_saved_posts();
    }
    ?>
    <!-- Section of the top budget builds -->
    <section>
      <h1>Top Budget</h1>
      <div>
        <div class="section-header">
          <h2>Top Budget</h2>
          <p>Find the budget builds with the best value for money</p>
        </div>
        <div class="section-content">
          <?php

          ?>
        </div>
      </div>
    </section>

    <!-- Section of the latest builds -->
    <section>
      <h1>Latest Builds</h1>
      <div>
        <div class="section-header">
          <h2>Latest Builds</h2>
          <p>Explore the latest builds submitted by the other members</p>
        </div>
        <div class="section-content">
          <?php
          // Display the latest posts
          foreach ($latest_posts as $post) {
            small_card($post, in_array($post->id, $saved_posts_in_others));
          }
          ?>
        </div>
      </div>
    </section>

    <!-- Section of the saved builds -->
    <section>
      <h1>Saved Builds</h1>
      <div>
        <div class="section-header">
          <h2>Saved Builds</h2>
          <p>We remembered them for you! Here are a selection of builds you saved</p>
        </div>
        <div class="section-content">
          <?php
          // Display the saved builds only if the user has saved any
          if (count($saved_builds) === 0) {
            echo "<p>You haven't saved any build yet</p>";
          }
          foreach ($saved_builds as $post) {
            small_card($post, true);
          }
          ?>
        </div>
      </div>
    </section>

    <!-- Section of the best performance builds -->
    <section>
      <h1>Best Perf.</h1>
      <div>
        <div class="section-header">
          <h2>Best Performance</h2>
          <p>Are you looking for performance? Find builds that are pure beast, just raw power</p>
        </div>
        <div class="section-content">
          <?php
          // Display the posts with the best performance
          foreach ($best_perf as $post) {
            small_card($post, in_array($post->id, $saved_posts_in_others));
          }
          ?>
        </div>
      </div>
    </section>

  </main>

  <?php
  // Include the footer component
  include_once __DIR__ . "/../components/footer/footer.php"
  ?>

</body>

</html>