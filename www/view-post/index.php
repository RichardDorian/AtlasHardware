<?php

include_once __DIR__ . "/../../utils/posts.php";

if (!isset($_GET["id"])) {
  header('Location: /');
  exit();
}

$post = Posts::get_post($_GET["id"]);
$post->fetch_images();

if (gettype($post) === "integer" && $post == 4) {
  header('Location: /');
  exit();
}

$cover_url = $post->get_cover_url();
?>

<!DOCTYPE html>
<html lang="en">
<?php
$styles = ["header.css", "post.css", "scroll-indicator.css", "footer.css"];
$scripts = ["header.js"];
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
            <a><?php echo $post->get_author_name() ?></a>
          </p>
          <div id="details-action">
            <?php
            $data = ["text" => "Rate", "icon" => "star"];
            include __DIR__ . "/../../components/button.php";

            $data = ["text" => "8.9/10 (200k)", "icon" => "hotel_class"];
            include __DIR__ . "/../../components/button.php";

            $data = ["text" => "Save", "icon" => "bookmark"];
            include __DIR__ . "/../../components/button.php";
            ?>
          </div>
        </div>
        <div id="images">
          <?php
          foreach ($post->images as $image) {
            echo "<img src=\"{$post->get_image_url($image)}\" draggable=\"false\">";
          }
          ?>
        </div>
        <div id="description">
          <p><?php echo $post->description ?></p>
          <?php
          $data = ["text" => "Save this build", "icon" => "bookmark"];
          include __DIR__ . "/../../components/button.php";
          ?>
        </div>
      </div>
      <div>
        <?php
        include_once __DIR__ . "/../../components/post/scroll-indicatator.php";
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