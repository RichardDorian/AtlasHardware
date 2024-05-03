<?php include_once __DIR__ . "/../../components/cards/index.php" ?>
<?php include_once __DIR__ . "/../../utils/user_session.php" ?>
<!DOCTYPE html>
<html lang="en">
<?php
$styles = ["header.css", "footer.css", "add-post.css"];
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
        <input type="text" id="title" name="title" required />
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Describe your PC config here!" required></textarea>
        <label for="price">Starting Price</label>
        <input type="number" id="price" name="price" min="0" max="20000 " required />
        <label for="performance">Performance</label>
        <input type="number" id="performance" name="performance" min="0" max="999" required />
        <label for="image">Image</label>
        <input type="file" id="image-file-picker" accept="image/*" style="display: none" />
    </div>
    <div id="image-container">
        <span class="material-symbols-rounded" id="image-picker-button" onclick="chooseImageFile()">add_a_photo</span>
    </div>

    <button type="submit">Post</button>

    </form>

    </main>
    <?php include_once __DIR__ . "/../../components/footer/footer.php" ?>
  </body>
</html>
