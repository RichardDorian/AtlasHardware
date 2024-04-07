<?php include_once __DIR__ . "/../components/cards/index.php" ?>

<!DOCTYPE html>
<html lang="en">
<?php
$styles = ["header.css", "home.css", "cards.css", "footer.css"];
$scripts = ["header.js"];
$title = "Home";
include_once __DIR__ . "/../components/head/head.php";
?>

<body>
  <?php include_once __DIR__ . "/../components/header/header.php" ?>
  <main>

    <section>
      <h1>Top Budget</h1>
      <div>
        <div class="section-header">
          <h2>Top Budget</h2>
          <p>Find the budget builds with the best value for money</p>
        </div>
        <div class="section-content">
          <?php
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/0.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/1.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/4.webp", 8.9, 891, true, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/2.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/3.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          ?>
        </div>
      </div>
    </section>

    <section>
      <h1>Latest Builds</h1>
      <div>
        <div class="section-header">
          <h2>Latest Builds</h2>
          <p>Explore the latest builds submitted by the other members</p>
        </div>
        <div class="section-content">
          <?php
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/2.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/4.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/0.webp", 8.9, 891, true, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/1.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/3.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          ?>
        </div>
      </div>
    </section>

    <section>
      <h1>Your Favorites</h1>
      <div>
        <div class="section-header">
          <h2>Your Favorites</h2>
          <p>We remembered them for you! Here are a selection of your favorite builds</p>
        </div>
        <div class="section-content">
          <?php
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/3.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/1.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/4.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/2.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/0.webp", 8.9, 891, true, "9ee01e36a96547dc9141ff092085cd73");
          ?>
        </div>
      </div>
    </section>

    <section>
      <h1>Best Perf.</h1>
      <div>
        <div class="section-header">
          <h2>Best Performance</h2>
          <p>Are you looking for performance? Find builds that are pure beast, just raw power</p>
        </div>
        <div class="section-content">
          <?php
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/0.webp", 8.9, 891, true, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/1.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/2.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/3.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          small_card("R5 3600 • RTX 3090 • Black", "/assets/images/4.webp", 8.9, 891, false, "9ee01e36a96547dc9141ff092085cd73");
          ?>
        </div>
      </div>
    </section>

  </main>
  <?php include_once __DIR__ . "/../components/footer/footer.php" ?>
</body>

</html>