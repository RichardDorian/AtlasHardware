<?php

$links = $data["links"] ?? [];

?>

<div id="scroll-indicator">
  <span></span>
  <div>
    <?php
    $i = 0;
    foreach ($links as $link) {
      echo "<a href=\"#$link[0]\" data-id=\"$i\"";

      if ($i == 0)
        echo " class=\"selected\"";

      if (isset($link[2]) && $link[2] === true)
        echo " data-scroll-to-top";

      echo ">$link[1]</a>";
      $i++;
    }
    ?>
  </div>
</div>