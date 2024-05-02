<?php
$button_class = "component";
$custom_props = "";

if (isset($data["style"])) {
  $button_class .= " $data[style]";
}

if (isset($data["custom_props"])) {
  foreach ($data["custom_props"] as $key => $value) {
    $custom_props .= " $key=\"$value\"";
  }
}
?>

<button class="<?php echo $button_class ?>" <?php echo $custom_props ?>>
  <span class="material-symbols-rounded">
    <?php echo $data["icon"] ?>
  </span>
  <span>
    <?php echo $data["text"] ?>
  </span>
</button>