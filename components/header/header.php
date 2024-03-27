<header>
  <?php include_once __DIR__ . "/../../utils/user_session.php" ?>
  <a href="/">Home</a>
  <a href="/browse">Browse</a>
  <form action="/search" method="get" id="search">
    <input type="text" name="query" id="query" placeholder="Search Atlas Hardware">
    <button type="submit">
      <span class="material-symbols-rounded">search</span>
    </button>
  </form>
  <?php
  if ($is_connected) {
    include_once __DIR__ . "/loggedin.php";
  } else {
    include_once __DIR__ . "/loggedout.php";
  }
  ?>
</header>