<?php

include_once __DIR__ . "/../../utils/posts.php";

if (!isset($_GET["id"])) {
  header('Location: /');
  exit();
}

$post = Posts::get_post($_GET["id"]);

if (gettype($post) === "integer" && $post == 4) {
  header('Location: /');
  exit();
}

$post->fetch_images();
$cover_url = $post->get_cover_url();
?>

<!DOCTYPE html>
<html lang="en">
<?php
$styles = ["header.css", "post.css", "button.css", "scroll-indicator.css", "cards.css", "footer.css"];
$scripts = ["header.js", "scroll-indicator.js", "save-unsave.js"];
include_once __DIR__ . "/../../components/head/head.php";

echo <<<HTML
<style>main { --background-url: url("$cover_url"); }</style>
HTML;
?>

<body>
  <?php include_once __DIR__ . "/../../components/header/header.php" ?>
  <main>
    <div id="background"></div>
    <div id="content">
      <div id="main">
        <h1> <?php echo $post->title ?> </h1>
        <div id="post-details">
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
          <div id="details-action">
            <?php
            $data = ["text" => "Rate", "icon" => "star"];
            include __DIR__ . "/../../components/button.php";

            $data = ["text" => "$post->rating/10", "icon" => "hotel_class"];
            include __DIR__ . "/../../components/button.php";

            if (UserSession::is_connected()) {
              $is_saved = UserSession::is_saved_post($post->id);

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
        <div id="images_and_scrollindicator">
          <div id="images">
            <?php
            foreach ($post->images as $image) {
              echo "<img src=\"{$post->get_image_url($image)}\" draggable=\"false\">";
              echo "<img src=\"{$post->get_image_url($image)}\" draggable=\"false\">";
            }
            ?>
          </div>
          <div>
          <?php
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
          ?></div>
        </div>
        <div id="description">
          <p><?php echo $post->description ?></p>
        </div>
        <h2 id="performance">Performance</h2>
        <h2 id="technical-specs">Technical specs</h2>
        <div id="technical-specs-content">
          <p>Starting price: $TODO</p>
          <div id="components-grid">
            <div>
              <span>
                <span class="material-symbols-rounded">memory</span>
                <h3>CPU</h3>
              </span>
              <a href="https://google.com/search?q=<?php echo $post->specs["cpu"] ?>" target="_blank"><?php echo $post->specs["cpu"] ?></a>
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">monitor</span>
                <h3>GPU</h3>
              </span>
              <a href="https://google.com/search?q=<?php echo $post->specs["gpu"] ?>" target="_blank"><?php echo $post->specs["gpu"] ?></a>
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">developer_board</span>
                <h3>Motherboard</h3>
              </span>
              <a href="https://google.com/search?q=<?php echo $post->specs["motherboard"] ?>" target="_blank"><?php echo $post->specs["motherboard"] ?></a>
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">bolt</span>
                <h3>PSU</h3>
              </span>
              <a href="https://google.com/search?q=<?php echo $post->specs["psu"] ?>" target="_blank"><?php echo $post->specs["psu"] ?></a>
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">memory_alt</span>
                <h3>RAM</h3>
              </span>
              <a href="https://google.com/search?q=<?php echo $post->specs["ram"] ?>" target="_blank"><?php echo $post->specs["ram"] ?></a>
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">database</span>
                <h3>Storage</h3>
              </span>
              <?php
              foreach ($post->specs["storage"] as $storage) {
                echo "<a href=\"https://google.com/search?q=$storage\" target=\"_blank\">$storage</a>";
              }
              ?>
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">package_2</span>
                <h3>Case</h3>
              </span>
              <a href="https://google.com/search?q=<?php echo $post->specs["case"] ?>" target="_blank"><?php echo $post->specs["case"] ?></a>
            </div>
          </div>
        </div>
        <div id="comments-title">
          <h2 id="comments">Comments</h2>
          <?php
          $data = [
            "text" => "Write comment",
            "icon" => "comment",
          ];
          include __DIR__ . "/../../components/button.php";
          ?>
        </div>
        <div id="comments-list">

        </div><!--
        <h2 id="more-builds">More builds</h2>
        <div id="more-builds-content">
          <?php /*
          include_once __DIR__ . "/../../utils/posts.php";
          include_once __DIR__ . "/../../components/cards/index.php";
          $saved_posts_in_others = [];
          $latest_posts = Posts::get_latest_posts(4);

          if (UserSession::is_connected()) {
            $latest_posts_ids = [];
            foreach ($latest_posts as $post) {
              if (!in_array($post->id, $latest_posts_ids)) $latest_posts_ids[] = $post->id;
            }

            $saved_posts_in_others = UserSession::are_saved_posts($latest_posts_ids);
          }

          foreach ($latest_posts as $post) {
            small_card($post, in_array($post->id, $saved_posts_in_others));
          }*/
          ?>
        </div>-->
      </div>
      <div>
        <?php
        /*$data = [
          "links" => [
            ["overview", "Overview", true],
            ["images", "Images"],
            ["description", "Description"],
            ["performance", "Performance"],
            ["technical-specs", "Technical specs"],
            ["comments", "Comments"],
            ["more-builds", "More builds"]
          ]
        ];
        include_once __DIR__ . "/../../components/post/scroll-indicatator.php";*/
        $data = ["text" => "Share", "icon" => "share"];
        // include __DIR__ . "/../../components/button.php";
        ?>
      </div>
    </div>
  </main>
  <?php
  include_once __DIR__ . "/../../components/footer/footer.php"
  ?>
</body>

</html>