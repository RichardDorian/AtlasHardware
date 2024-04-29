<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? "$title • Atlas Hardware" : "Atlas Hardware" ?></title>
  <link rel="icon" href="/assets/images/icon_atlas_hardware.png">
  <?php include_once __DIR__ . "/fonts.php" ?>
  <link rel="stylesheet" href="/assets/styles/root.css">
  <?php include_once __DIR__ . "/meta.php" ?>
  <?php
  if (isset($styles))
    foreach ($styles as $style)
      echo <<<HTML
        <link rel="stylesheet" href="/assets/styles/$style">
      HTML;

  if (isset($scripts))
    foreach ($scripts as $script)
      echo <<<HTML
        <script src="/assets/scripts/$script" defer></script>
      HTML;
  ?>
</head>