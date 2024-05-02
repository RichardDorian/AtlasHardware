<?php
include_once __DIR__ . "/../../utils/user_session.php";
?>

<div class="card small">
  <img src="<?php echo "/assets/image/" . $data["image"] ?>" draggable="false" alt="Image du PC contenant : <?php echo $data["title"] ?>">
  <h3>
    <?php echo $data["title"] ?>
  </h3>
  <div class="details">
    <div class="numbers">
      <span class="material-symbols-rounded">hotel_class</span>
      <span class="text">
        <?php echo $data["rating"] ?>
      </span>
      <span class="material-symbols-rounded">speed</span>
      <span class="text">
        <?php echo $data["benchmark"] ?>
      </span>
    </div>
    <?php
    if (UserSession::is_connected()) {
      $class = $data["saved"] ? " saved" : "";
      $icon = $data["saved"] ? "bookmark_added" : "bookmark";
      $id = $data["id"];
      echo <<<HTML
      <span class="material-symbols-rounded bookmark$class" data-save-unsave="$id">$icon</span>
      HTML;
    }
    ?>
  </div>
  <a class="main" href="/post/<?php echo $data["id"] ?>">
    <span class="material-symbols-rounded">chevron_right</span>
    <span>Read post</span>
  </a>
</div>