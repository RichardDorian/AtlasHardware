<div class="card small">
  <img src="<?php echo $data["image"] ?>" width="310" draggable="false">
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
    <span class="material-symbols-rounded bookmark <?php echo $data["bookmarked"] ? "added" : "" ?>">
      <?php echo $data["bookmarked"] ? "bookmark_added" : "bookmark" ?>
    </span>
  </div>
  <button class="main">
    <span class="material-symbols-rounded">chevron_right</span>
    <span>Read post</span>
  </button>
</div>