<?php include_once __DIR__ . "/../components/cards/index.php" ?>

<!DOCTYPE html>
<html lang="en">
<?php
$styles = ["header.css", "home.css", "cards.css", "footer.css"];
$scripts = ["header.js"];
$title = "Home";
include_once __DIR__ . "/../components/head/head.php";
?>

<body>
  <?php include_once __DIR__ . "/../components/header/header.php" ?>
  <main>
    <?php
    include_once __DIR__ . "/../utils/posts.php";
    $latest_posts = Posts::get_latest_posts();
    $best_perf = Posts::get_best_perf();

    $saved_builds = [];
    $saved_posts_in_others = [];

    if (UserSession::is_connected()) {
      $post_ids = [];
      foreach ([...$latest_posts, ...$best_perf] as $post) {
        if (!in_array($post->id, $post_ids)) $post_ids[] = $post->id;
      }
      $saved_posts_in_others = UserSession::are_saved_posts($post_ids);

      $saved_builds = UserSession::get_saved_posts();
    }
    ?>
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
    <section>
      <h1>Latest Builds</h1>
      <div>
        <div class="section-header">
          <h2>Latest Builds</h2>
          <p>Explore the latest builds submitted by the other members</p>
        </div>
        <div class="section-content">
          <?php
          foreach ($latest_posts as $post) {
            small_card($post, in_array($post->id, $saved_posts_in_others));
          }
          ?>
        </div>
      </div>
    </section>
    <section>
      <h1>Saved Builds</h1>
      <div>
        <div class="section-header">
          <h2>Saved Builds</h2>
          <p>We remembered them for you! Here are a selection of builds you saved</p>
        </div>
        <div class="section-content">
          <?php
          foreach ($saved_builds as $post) {
            small_card($post, true);
          }
          ?>
        </div>
      </div>
    </section>
    <section>
      <h1>Best Perf.</h1>
      <div>
        <div class="section-header">
          <h2>Best Performance</h2>
          <p>Are you looking for performance? Find builds that are pure beast, just raw power</p>
        </div>
        <div class="section-content">
          <?php
          foreach ($best_perf as $post) {
            small_card($post, in_array($post->id, $saved_posts_in_others));
          }
          ?>
        </div>
      </div>
    </section>
  </main>
  <?php include_once __DIR__ . "/../components/footer/footer.php" ?>
</body>

</html>