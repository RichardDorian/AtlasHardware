<!-- Head -->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Title, based on the $title variable -->
  <title><?php echo isset($title) ? "$title • Atlas Hardware" : "Atlas Hardware" ?></title>

  <!-- Icon -->
  <link rel="icon" href="/assets/images/icon_atlas_hardware.png">

  <!-- Fonts (the M3 icons are also in a font) -->
  <?php include_once __DIR__ . "/fonts.php" ?>

  <!-- Root style -->
  <link rel="stylesheet" href="/assets/styles/root.css">

  <!-- Meta tags -->
  <?php include_once __DIR__ . "/meta.php" ?>

  <?php
  // Include the CSS and JS files
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