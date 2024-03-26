<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? "$title • Atlas Hardware" : "Atlas Hardware" ?></title>
  <?php include_once __DIR__ . "/fonts.php" ?>
  <link rel="stylesheet" href="/assets/styles/root.css">
  <?php include_once __DIR__ . "/meta.php" ?>
  <?php
    if (isset($additional_styles)) {
      foreach ($additional_styles as $style) {
        echo "<link rel=\"stylesheet\" href=\"/assets/styles/$style\">";
      }
    }
  ?>
</head>