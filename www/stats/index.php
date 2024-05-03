<!DOCTYPE html>
<html lang="en">
<?php
// Define the CSS and JS files to be included in the head of the document
$styles = ["header.css", "footer.css", "stats.css"];
$scripts = ["header.js"];

$title = "Stats";

// Include the head component with the defined variables
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <?php 
  // Include the header component
  include_once __DIR__ . "/../../components/header/header.php" 
  ?>

  <!-- Main content of the page -->
  <main>

    <!-- Title of the page -->
    <h1>
      <span class="material-symbols-rounded">query_stats</span>
      <span>Stats</span>
    </h1>

    <p>Numbers of posts each month</p>

    <?php
    // Include the posts utility
    include_once __DIR__ . "/../../utils/posts.php";

    // Get the number of posts each month
    $resp = Posts::get_number_of_posts_each_month();
    $result = $resp["result"];
    $month_array = $resp["month_array"];
    ?>

    <div>

      <!-- Table of the number of posts each month -->
      <table>
        <thead>
          <tr>
            <!-- Table headers -->
            <th></th>
            <?php
            foreach ($result as $annee => $mois) {
              echo "<th>$annee</th>";
            }
            ?>
          </tr>
        </thead>
        <tbody>
          <?php
          // For each month
          for ($i = 1; $i <= 12; $i++) {
            echo "<tr>";
            echo "<td>" . $month_array[$i] . "</td>";
            // For each year display the number of posts
            foreach ($result as $annee => $mois) {
              echo "<td>" . $mois[$i] . "</td>";
            }
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <?php 
  // Include the footer component
  include_once __DIR__ . "/../../components/footer/footer.php" 
  ?>
  
</body>

</html>