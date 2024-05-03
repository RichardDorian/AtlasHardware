<!DOCTYPE html>
<html lang="en">

<!-- Include the card component and user session util file -->
<?php include_once __DIR__ . "/../../components/cards/index.php" ?>
<?php include_once __DIR__ . "/../../utils/user_session.php" ?>

<!-- Set the styles, scripts, and title for the head section and include it -->
<?php
$styles = ["header.css", "footer.css", "cards.css", "browse.css"];
$scripts = ["header.js", "save-unsave.js"];
$title = "Browse";
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <!-- Include the header component -->
  <?php include_once __DIR__ . "/../../components/header/header.php" ?>

  <main>
    <h1>
      <span class="material-symbols-rounded">travel_explore</span>
      <span>Browse</span>
    </h1>

    <!-- Include the post util file and get the page and items per page from the query string -->
    <?php
    include_once __DIR__ . "/../../utils/posts.php";
    $_GET["page"] = $_GET["page"] ?? 1;
    $_GET["items_per_page"] = $_GET["items_per_page"] ?? 30;
    $page = $_GET["page"];
    $items_per_page = $_GET["items_per_page"];

    // Validate the page and items per page values
    if (!is_numeric($page)) $page = 1;
    if ($page < 1) $page = 1;

    if (!is_numeric($items_per_page)) $items_per_page = 30;
    if ($items_per_page < 1) $items_per_page = 30;
    if ($items_per_page > 100) $items_per_page = 100;

    // Get the number of posts and calculate the number of pages
    $count = Posts::get_number_of_posts();
    $number_of_pages = ceil($count / $items_per_page);
    if ($number_of_pages < 1) $number_of_pages = 1;
    if ($page > $number_of_pages) $page = $number_of_pages;

    // Calculate the offset for the database query
    $offset = ($page - 1) * $items_per_page;

    // Get the latest posts from the database
    $latest_posts = Posts::get_latest_posts($items_per_page, $offset);

    // Get an array of saved posts for the current user
    $saved_posts_in_others = [];
    if (UserSession::is_connected()) {
      $post_ids = [];
      foreach ($latest_posts as $post) {
        if (!in_array($post->id, $post_ids)) $post_ids[] = $post->id;
      }
      $saved_posts_in_others = UserSession::are_saved_posts($post_ids);
    }
    ?>

    <!-- Display the pagination links -->
    <div class="pagination-container">
      <div class="pagination">
        <?php
        // Calculate the minimum and maximum page numbers to display
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

        // Display the first page link and ellipsis if necessary
        if ($min_spread > 1) {
          echo <<<HTML
          <a href="/browse?page=1&items_per_page=$items_per_page" class="page-link">1</a>
          HTML;
          if ($min_spread > 2) echo "<span>...</span>";
        }

        // Display the page links
        for ($i = $min_spread; $i <= $max_spread; $i++) {
          if ($i == $page) $class = "current-page page-link";
          else $class = "page-link";
          echo <<<HTML
          <a href="/browse?page=$i&items_per_page=$items_per_page" class="$class">$i</a>
          HTML;
        }

        // Display the last page link and ellipsis if necessary
        if ($max_spread < $number_of_pages) {
          if ($max_spread < $number_of_pages - 1) echo "<span>...</span>";
          echo <<<HTML
          <a href="/browse?page=$number_of_pages&items_per_page=$items_per_page" class="page-link">$number_of_pages</a>
          HTML;
        }
        ?>
      </div>
    </div>

    <!-- Display the latest posts as cards -->
    <div class="content">
      <?php
      foreach ($latest_posts as $post) {
        small_card($post, in_array($post->id, $saved_posts_in_others));
      }
      ?>
    </div>

    <!-- Display the pagination links again -->
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

  <!-- Include the footer component -->
  <?php include_once __DIR__ . "/../../components/footer/footer.php" ?>
</body>
</html>
