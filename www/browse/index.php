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
      $_GET["items_per_page"] = $_GET["items_per_page"] ?? 30;
      $page = $_GET["page"];
      $items_per_page = $_GET["items_per_page"];

      
      if (!is_numeric($page)) $page = 1;
      if ($page < 1) $page = 1;

      
      if (!is_numeric($items_per_page)) $items_per_page = 30;
      if ($items_per_page < 1) $items_per_page = 30;
      if ($items_per_page > 100) $items_per_page = 100;
      
      $count = Posts::get_number_of_posts();
      $number_of_pages = ceil($count / $items_per_page);
      if ($number_of_pages < 1) $number_of_pages = 1;
      if ($page > $number_of_pages) $page = $number_of_pages;
      
      $offset = ($page - 1) * $items_per_page;
      $latest_posts = Posts::get_latest_posts($items_per_page, $offset);
      

      $saved_posts_in_others = [];

      if (UserSession::is_connected()) {
        $post_ids = [];
        foreach ($latest_posts as $post) {
          if (!in_array($post->id, $post_ids)) $post_ids[] = $post->id;
        }
        $saved_posts_in_others = UserSession::are_saved_posts($post_ids);      
      }
      
      
      ?>
      <div class="pagination-container">
        <div class="pagination">
          <?php
          $min_spread = $page - 1;
          $max_spread = $page + 1;
          if ($min_spread < 1) {
            $max_spread += 1 - $min_spread;
            $min_spread = 1;
            if ($max_spread >= $number_of_pages) {
              $min_spread = 1;
              $max_spread = $number_of_pages;
              
            }
          }
          if ($max_spread > $number_of_pages) {
            $min_spread -= $max_spread - $number_of_pages;
            $max_spread = $number_of_pages;
            if ($min_spread <= 1) {
              $min_spread = 1;
              $max_spread = $number_of_pages;
              
            }
          }
          
          if ($min_spread > 1) {
            echo <<<HTML
            <a href="/browse?page=1&items_per_page=$items_per_page" class="page-link">1</a>
            HTML;
            if ($min_spread > 2) echo "<span>...</span>";
          }

          for ($i = $min_spread; $i <= $max_spread; $i++) {
            if ($i == $page) $class = "current-page page-link";
            else $class = "page-link";
            echo <<<HTML
            <a href="/browse?page=$i&items_per_page=$items_per_page" class="$class">$i</a>
            HTML;
          }
          if ($max_spread < $number_of_pages) {
            if ($max_spread < $number_of_pages - 1) echo "<span>...</span>";
            echo <<<HTML
            <a href="/browse?page=$number_of_pages&items_per_page=$items_per_page" class="page-link">$number_of_pages</a>
            HTML;
          }
          ?>
        </div>
      </div>
      <div class="content">
        <?php
        foreach ($latest_posts as $post) {
          small_card($post, in_array($post->id, $saved_posts_in_others));
        }
        ?>
        
      </div>
      <div class="pagination-container">
        <div class="pagination">
          <?php
          if ($min_spread > 1) {
            echo <<<HTML
            <a href="/browse?page=1&items_per_page=$items_per_page" class="page-link">1</a>
            HTML;
            if ($min_spread > 2) echo "<span>...</span>";
          }

          for ($i = $min_spread; $i <= $max_spread; $i++) {
            if ($i == $page) $class = "current-page page-link";
            else $class = "page-link";
            echo <<<HTML
            <a href="/browse?page=$i&items_per_page=$items_per_page" class="$class">$i</a>
            HTML;
          }
          if ($max_spread < $number_of_pages) {
            if ($max_spread < $number_of_pages - 1) echo "<span>...</span>";
            echo <<<HTML
            <a href="/browse?page=$number_of_pages&items_per_page=$items_per_page" class="page-link">$number_of_pages</a>
            HTML;
          }
          ?>
        </div>
      </div>
    </main>
    <?php include_once __DIR__ . "/../../components/footer/footer.php" ?>
  </body>
</html>