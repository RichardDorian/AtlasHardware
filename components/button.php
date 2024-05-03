<?php
// Define default button class
$button_class = "component";

$custom_props = "";

// Check if style is set in data and append to button class
if (isset($data["style"])) {
  $button_class .= " $data[style]";
}

// Check if custom props are set in data and append to custom props variable
if (isset($data["custom_props"])) {
  foreach ($data["custom_props"] as $key => $value) {
    $custom_props .= " $key=\"$value\"";
  }
}

// Output button element with material icon and text
?>

<button class="<?php echo $button_class ?>" <?php echo $custom_props ?>>
  <span class="material-symbols-rounded">
    <?php echo $data["icon"] ?>
  </span>
  <span>
    <?php echo $data["text"] ?>
  </span>
</button>
