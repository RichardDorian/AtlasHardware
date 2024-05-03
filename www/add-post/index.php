<?php include_once __DIR__ . "/add-post.php" ?>

<?php include_once __DIR__ . "/../../components/cards/index.php" ?>
<?php include_once __DIR__ . "/../../utils/user_session.php" ?>

<!DOCTYPE html>
<html lang="en">
<?php
$styles = ["header.css", "footer.css", "add-post.css", "input.css", "button.css"];
$scripts = ["header.js", "add-post.js"];
$title = "New post";
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <?php
  if (!UserSession::is_connected()) {
    header("Location: /login");
    exit();
  }
  ?>
  <?php include_once __DIR__ . "/../../components/header/header.php" ?>
  <main>
    <h1>
      <span class="material-symbols-rounded">add</span>
      <span>New Post</span>
    </h1>

    <form id="add-post-form">
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" class="styled big-input" placeholder="i7 11700k RTX 3060 Ti" required />
        <label for="description">Description</label>
        <textarea id="description" class="styled big-input" name="description" placeholder="Describe your PC config here!" required></textarea>
        <label for="price">Starting Price</label>
        <input type="number" id="price" class="styled small-input" name="price" min="0" max="20000 " placeholder="1420" required />
        <label for="performance">Performance</label>
        <input type="number" id="performance" class="styled small-input" name="performance" min="0" max="999" placeholder="875" required />
        <input type="file" id="image-file-picker" accept="image/*" style="display: none" />
      </div>
      <div id="components-grid">
            <div>
              <span>
                <span class="material-symbols-rounded">memory</span>
                <h3>CPU</h3>
              </span>
              <input type="text" id="cpu" class="styled big-input" name="cpu" placeholder="i7 11700k" required />
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">monitor</span>
                <h3>GPU</h3>
              </span>
              <input type="text" id="gpu" class="styled big-input" name="gpu" placeholder="RTX 3060 Ti" required />
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">developer_board</span>
                <h3>Motherboard</h3>
              </span>
              <input type="text" id="motherboard" class="styled big-input" name="motherboard" placeholder="MSI Z490-A PRO" required />
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">bolt</span>
                <h3>PSU</h3>
              </span>
              <input type="text" id="psu" class="styled big-input" name="psu" placeholder="Corsair RM750x" required />
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">memory_alt</span>
                <h3>RAM</h3>
              </span>
              <input type="text" id="ram" class="styled big-input" name="ram" placeholder="Corsair Vengeance LPX 16GB" required />
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">database</span>
                <h3>Storage</h3>
              </span>
              <input type="text" id="storage" class="styled big-input" name="storage" placeholder="Samsung 970 EVO 1TB" required />
              <input type="text" id="storage2" class="styled big-input" name="storage2" placeholder="Seagate Barracuda 4to" />
            </div>
            <div>
              <span>
                <span class="material-symbols-rounded">package_2</span>
                <h3>Case</h3>
              </span>
              <input type="text" id="case" class="styled big-input" name="case" placeholder="NZXT H510" required />
            </div>
          </div>
        </div>
      <div id="image-container">
        <div id="button_to_add_img" onclick="chooseImageFile()">
          <p>Add image(s) to your post</p>
          <span class="material-symbols-rounded" id="image-picker-button">add_a_photo</span>
        </div>
      </div>

      <button type="submit" class="styled">Post</button>

    </form>

  </main>
  <?php include_once __DIR__ . "/../../components/footer/footer.php" ?>
</body>

</html>