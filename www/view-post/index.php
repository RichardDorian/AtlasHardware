<?php
// Include the posts utility
include_once __DIR__ . "/../../utils/posts.php";

// Check if the post ID is set else redirect to the home page
if (!isset($_GET["id"])) {
  header('Location: /');
  exit();
}

// Fetch the post with the given ID
$post = Posts::get_post($_GET["id"]);

// Check if the post doesn't exist or if the ID is invalid else redirect to the home page
if (gettype($post) === "integer" && $post == 4) {
  header('Location: /');
  exit();
}

// Fetch the images of the post
$post->fetch_images();
$cover_url = $post->get_cover_url();
?>

<!DOCTYPE html>
<html lang="en">
<?php
// Define the CSS and JS files to be included in the head of the document
$styles = ["header.css", "post.css", "button.css", "scroll-indicator.css", "cards.css", "footer.css"];
$scripts = ["header.js", "scroll-indicator.js", "comments.js", "save-unsave.js"];

// Include the head component with the defined variables
include_once __DIR__ . "/../../components/head/head.php";

// Show the cover image of the post as the background of the page
echo <<<HTML
<style>main { --background-url: url("$cover_url"); }</style>
HTML;
?>

<body>

  <?php
  // Include the header component
  include_once __DIR__ . "/../../components/header/header.php"
  ?>

  <!-- Main content of the page -->
  <main>

    <!-- Background -->
    <div id="background"></div>

    <!-- Content of the page -->
    <div id="content">

      <div id="main">
        <!-- Title of the post -->
        <h1> <?php echo $post->title ?> </h1>

        <!-- Details of the post -->
        <div id="post-details">

          <!-- Date and author of the post -->
          <p>
            <span>
              <?php
              $date = new DateTimeImmutable($post->date);
              echo "On {$date->format("F j Y")} by";
              ?>
            </span>
            <a>
              <?php
              $post->fetch_author();
              echo $post->author->username;
              ?>
            </a>
          </p>

          <!-- Buttons to rate and save -->
          <div id="details-action">
            <?php
            // Button to rate the post
            $data = ["text" => "Rate", "icon" => "star"];
            include __DIR__ . "/../../components/button.php";

            // Button to show the rating of the post
            $data = ["text" => "$post->rating/10", "icon" => "hotel_class"];
            include __DIR__ . "/../../components/button.php";

            // Button to save or unsave the post if the user is connected
            if (UserSession::is_connected()) {
              $is_saved = UserSession::is_saved_post($post->id);

              // Data of the button
              $data = [
                "text" => $is_saved ? "Saved" : "Save",
                "icon" => $is_saved ? "bookmark_added" : "bookmark",
                "style" => $is_saved ? "text-primary saved" : "",
                "custom_props" => [
                  "data-save-unsave" => $post->id
                ]
              ];
              include __DIR__ . "/../../components/button.php";
            }
            ?>
          </div>
        </div>

        <!-- Images and scrollindicator of the post -->
        <div id="images_and_scrollindicator">

          <!-- Images of the post -->
          <div id="images">
            <?php
            // Show all the images of the post
            foreach ($post->images as $image) {
              echo "<img src=\"{$post->get_image_url($image)}\" draggable=\"false\">";
            }
            ?>
          </div>

          <!-- Scroll indicator of the page -->
          <div>
            <?php
            // Data for the scroll indicator
            $data = [
              "links" => [
                ["overview", "Overview", true],
                ["images", "Images"],
                ["description", "Description"],
                ["performance", "Performance"],
                ["technical-specs", "Technical specs"],
                ["comments", "Comments"],
              ]
            ];
            include_once __DIR__ . "/../../components/post/scroll-indicatator.php";
            ?>
          </div>
        </div>

        <!-- Description of the post -->
        <div id="description">
          <p><?php echo $post->description ?></p>
        </div>

        <!-- Performance of the post -->
        <h2 id="performance">Other</h2>
        <div>
          <p>Performance: <?php echo $post->performance ?>/1000</p>
          <p>Starting price: <?php echo $post->StartingPrice ?></p>
        </div>

        <!-- Technical specs of the build -->
        <h2 id="technical-specs">Technical specs</h2>
        <div id="technical-specs-content">
          <div id="components-grid">
            <?php
            /**
             * Function to create a link to search for a component on Google
             * @param string $component The name of the component
             */
            function componentLink($component)
            {
              $link = "https://google.com/search?q=" . urlencode($component);
              echo <<<HTML
              <a href="$link" target="_blank">$component</a>
              HTML;
            }
            ?>
            <div>
              <span>
                <span class="material-symbols-rounded">memory</span>
                <h3>CPU</h3>
              </span>
              <?php componentLink($post->specs["cpu"]) ?>
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">monitor</span>
                <h3>GPU</h3>
              </span>
              <?php componentLink($post->specs["gpu"]) ?>
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">developer_board</span>
                <h3>Motherboard</h3>
              </span>
              <?php componentLink($post->specs["motherboard"]) ?>
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">bolt</span>
                <h3>PSU</h3>
              </span>
              <?php componentLink($post->specs["psu"]) ?>
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">memory_alt</span>
                <h3>RAM</h3>
              </span>
              <?php componentLink($post->specs["ram"]) ?>
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">database</span>
                <h3>Storage</h3>
              </span>
              <?php
              foreach ($post->specs["storage"] as $storage) {
                componentLink($storage);
              }
              ?>
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">package_2</span>
                <h3>Case</h3>
              </span>
              <?php componentLink($post->specs["case"]) ?>
            </div>
          </div>
        </div>

        <!-- Comments of the post -->
        <div id="comments-title">
          <h2 id="comments">Comments</h2>
          <?php
          // Data for the button to write a comment
          $data = [
            "text" => "Write comment",
            "icon" => "comment",
            "custom_props" => [
              "id" => "write-comment-button"
            ]
          ];
          include __DIR__ . "/../../components/button.php";
          ?>
        </div>

        <!-- List of all the comments of the post -->
        <div id="comments-list">
          <?php
          // Include the comment utility
          include_once __DIR__ . "/../../utils/comment.php";

          // Fetch all the comments of the post
          $comments = Comments::get_comments_of_post($post->id);

          // Show all the comments
          foreach ($comments as $comment) {
            $comment->fetch_author();
            $date = new DateTimeImmutable($comment->date);

            $data = [
              "author" => $comment->author->username,
              "date" => $date->format("F j Y H:i:s"),
              "content" => $comment->comment
            ];
            include __DIR__ . "/../../components/post/comment.php";
          }
          ?>
        </div>
      </div>
    </div>
  </main>

  <?php
  // Include the footer component
  include_once __DIR__ . "/../../components/footer/footer.php"
  ?>

</body>

</html>