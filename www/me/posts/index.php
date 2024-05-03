<?php include_once __DIR__ . "../../../../components/cards/index.php" ?>

<!DOCTYPE html>
<html lang="en">
<?php
$styles = ["header.css", "cards.css", "saved_search.css", "footer.css"];
$scripts = ["header.js", "save-unsave.js"];
$title = "My posts";
include_once __DIR__ . "../../../../components/head/head.php";
?>

<body>
  <?php include_once __DIR__ . "../../../../components/header/header.php" ?>
  <main>
    <?php
    include_once __DIR__ . "../../../../utils/posts.php";
    if (UserSession::is_connected()) {
      $user_posts = UserSession::get_user_posts();

      $user_post_ids = [];
      foreach ($user_posts as $post) {
        $user_post_ids[] = $post->id;
      }
      $saved_user_posts = UserSession::are_saved_posts($user_post_ids);
    }
    ?>
    <h1>
      <span class="material-symbols-rounded">article</span>
      <span>My posts</span>
    </h1>
    <div>
      <div class="section-content">
        <?php
        if (!UserSession::is_connected()) {
          echo "<p>You need to be logged in to see your posts</p>";
        } else {
          if (count($user_posts) === 0) {
            echo "<p>You haven't posted anything yet</p>";
          }
          foreach ($user_posts as $post) {
            small_card($post, in_array($post->id, $saved_user_posts));
          }
        }
        ?>
      </div>
    </div>

  </main>
  <?php include_once __DIR__ . "../../../../components/footer/footer.php" ?>
</body>

</html>