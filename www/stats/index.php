<!DOCTYPE html>
<html lang="en">
<?php
$styles = ["header.css", "footer.css", "stats.css"];
$scripts = ["header.js"];
$title = "Stats";
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <?php include_once __DIR__ . "/../../components/header/header.php" ?>
  <main>
    <h1>
      <span class="material-symbols-rounded">query_stats</span>
      <span>Stats</span>
    </h1>

    <p>Numbers of posts each month</p>
    <?php
    include_once __DIR__ . "/../../utils/posts.php";

    $resp = Posts::get_number_of_posts_each_month();
    $result = $resp["result"];
    $month_array = $resp["month_array"];
    ?>
    <div>
      <table>
        <thead>
          <tr>
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
          for ($i = 1; $i <= 12; $i++) {
            echo "<tr>";
            echo "<td>" . $month_array[$i] . "</td>";
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
  <?php include_once __DIR__ . "/../../components/footer/footer.php" ?>
</body>

</html>