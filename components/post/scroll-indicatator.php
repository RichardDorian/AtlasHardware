<?php

// Get the links array from the $data variable, with an empty array as the default value
$links = $data["links"] ?? [];

?>

<!-- Scroll indicator container -->
<div id="scroll-indicator">
  <span></span>
  <div>
    <?php
    // Initialize a counter variable for the links
    $i = 0;
    // Loop through each link in the $links array
    foreach ($links as $link) {
      // Print out the link with its corresponding attributes
      echo "<a href=\"#$link[0]\" data-id=\"$i\"";

      // If this is the first link, add a "selected" class to it
      if ($i == 0)
        echo " class=\"selected\"";

      if (isset($link[2]) && $link[2] === true)
        echo " data-scroll-to-top";

      // Close the link tag and print out the link text
      echo ">$link[1]</a>";

      $i++;
    }
    ?>
  </div>
</div>
