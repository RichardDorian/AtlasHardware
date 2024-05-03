<?php
// Include the component for generating the card elements
include_once __DIR__ . "/../../components/cards/index.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php
// Define the CSS and JS files to be included in the head of the document
$styles = ["header.css", "cards.css", "saved_search.css", "footer.css"];
$scripts = ["header.js", "save-unsave.js"];

// Define the title of the document
$title = "Search";

// Include the head component with the defined variables
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <?php
  // Include the header component
  include_once __DIR__ . "/../../components/header/header.php";
  ?>

  <main>
    <?php
    // Include the utility file for handling posts
    include_once __DIR__ . "/../../utils/posts.php";

    // Check if the search query is set in the GET parameters
    if (isset($_GET['query'])) {
      // Get the search query
      $query = $_GET['query'];

      // Search for posts matching the query
      $response = Posts::get_posts_from_search($query);

      // Get the posts and the error message (if any) from the response
      $posts = $response['posts'];
      $error_msg = $response['error_msg'];
    } else {
      // If the search query is not set, initialize the variables
      $query = "";
      $posts = [];
      $error_msg = "No search query provided";
    }
    ?>

    <!-- Display the search results -->
    <h1>
      <span class="material-symbols-rounded">search</span>
      <span>Search</span>
    </h1>
    <h2>Results for : <?php echo $query ?></h2>
    <div>
      <?php echo "<p>" . $error_msg . "</p>"; ?>

      <!-- Display the posts found in the search -->
      <div class="section-content">
        <?php
        foreach ($posts as $post) {
          // Display each post using the small card format
          small_card($post, true);
        }
        ?>
      </div>
    </div>
  </main>

  <?php
  // Include the footer component
  include_once __DIR__ . "/../../components/footer/footer.php";
  ?>

</body>

</html>
