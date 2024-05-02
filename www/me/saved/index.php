<?php include_once __DIR__ . "../../../../components/cards/index.php" ?>

<!DOCTYPE html>
<html lang="en">
<?php
$styles = ["header.css", "cards.css", "saved_search.css", "footer.css"];
$scripts = ["header.js", "save-unsave.js"];
$title = "Saved posts";
include_once __DIR__ . "../../../../components/head/head.php";
?>

<body>
  <?php include_once __DIR__ . "../../../../components/header/header.php" ?>
  <main>
    <?php
    include_once __DIR__ . "../../../../utils/posts.php";
    if (UserSession::is_connected()) {
      $saved_builds = UserSession::get_saved_posts();
    }
    ?>
    <h1>
      <span class="material-symbols-rounded">bookmark</span>
      <span>Saved Builds</span>
    </h1>
    <div>
      <div class="section-content">
        <?php
        if (!UserSession::is_connected()) {
          echo "<p>You need to be logged in to see your saved builds</p>";
        } else {
          if (count($saved_builds) === 0) {
            echo "<p>You haven't saved any build yet</p>";
          }
          foreach ($saved_builds as $post) {
            small_card($post, true);
          }
        }
        ?>
      </div>
    </div>

  </main>
  <?php include_once __DIR__ . "../../../../components/footer/footer.php" ?>
</body>

</html>