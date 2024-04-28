<!DOCTYPE html>
<html lang="en">
<?php include_once __DIR__ . "/../../components/cards/index.php" ?>
<?php include_once __DIR__ . "/../../utils/user_session.php" ?>
  <?php
    $styles = ["header.css", "footer.css", "cards.css", "browse.css"];
    $scripts = ["header.js", "save-unsave.js"];
    $title = "Browse";
    include_once __DIR__ . "/../../components/head/head.php";
  ?>
  
  <body>
    <?php include_once __DIR__ . "/../../components/header/header.php" ?>
    <main>
      <?php
      include_once __DIR__ . "/../../utils/posts.php";
      $_GET["page"] = $_GET["page"] ?? 1;
      if (!is_numeric($_GET["page"])) $_GET["page"] = 1;
      if ($_GET["page"] < 1) $_GET["page"] = 1;

      $_GET["items_per_page"] = $_GET["items_per_page"] ?? 30;
      if (!is_numeric($_GET["items_per_page"])) $_GET["items_per_page"] = 30;
      if ($_GET["items_per_page"] < 1) $_GET["items_per_page"] = 30;
      if ($_GET["items_per_page"] > 100) $_GET["items_per_page"] = 100;
      
      $count = Posts::get_number_of_posts();
      $number_of_pages = ceil($count / $_GET["items_per_page"]);
      if ($number_of_pages < 1) $number_of_pages = 1;
      if ($_GET["page"] > $number_of_pages) $_GET["page"] = $number_of_pages;
      
      $offset = ($_GET["page"] - 1) * $_GET["items_per_page"];
      $latest_posts = Posts::get_latest_posts($_GET["items_per_page"], $offset);
      

      $saved_posts_in_others = [];

      if (UserSession::is_connected()) {
        $post_ids = [];
        foreach ($latest_posts as $post) {
          if (!in_array($post->id, $post_ids)) $post_ids[] = $post->id;
        }
        $saved_posts_in_others = UserSession::are_saved_posts($post_ids);      
      }
      
      
      ?>

      <div class="content">
        <?php
        foreach ($latest_posts as $post) {
          small_card($post, in_array($post->id, $saved_posts_in_others));
        }
        ?>
        
      </div>
    </main>
    <?php include_once __DIR__ . "/../../components/footer/footer.php" ?>
  </body>
</html>