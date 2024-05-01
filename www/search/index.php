<?php include_once __DIR__ . "/../../components/cards/index.php" ?>

<!DOCTYPE html>
<html lang="en">
<?php
$styles = ["header.css", "cards.css", "saved_search.css", "footer.css"];
$scripts = ["header.js", "save-unsave.js"];
$title = "Search";
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <?php include_once __DIR__ . "/../../components/header/header.php" ?>
  <main>
    <?php
    include_once __DIR__ . "/../../utils/posts.php";
    ?>
    <?php
    if (isset($_GET['query'])) {
      $query = $_GET['query'];
      $response = Posts::get_posts_from_search($query);
      $posts = $response['posts'];
      $error_msg = $response['error_msg'];
    } else {
      $query = "";
      $posts = [];
      $error_msg = "No search query provided";}

    ?>
    <h1>
      <span class="material-symbols-rounded">search</span>
      <span>Search</span>
    </h1>
    <h2>Results for : <?php echo $query ?></h2>
    <div>
      <?php echo "<p>" . $error_msg . "</p>"; ?>
      <div class="section-content">
        <?php

        foreach ($posts as $post) {
          small_card($post, true);
        }
        ?>
      </div>
    </div>

  </main>
  <?php include_once __DIR__ . "/../../components/footer/footer.php" ?>
</body>

</html>