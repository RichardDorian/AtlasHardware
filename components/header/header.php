<?php include_once __DIR__ . "/../../utils/user_session.php" ?>

<header>
  <a href="/" class="with-icon">
    <span class="material-symbols-rounded">home</span>
    <span>Home</span>
  </a>
  
  <a href="/browse" class="with-icon">
    <span class="material-symbols-rounded">travel_explore</span>
    <span>Browse</span>
  </a>
  
  <form action="/search" method="get" id="search">
    <input type="text" name="query" id="query" placeholder="Search Atlas Hardware" required>
    <button type="submit">
      <span class="material-symbols-rounded">search</span>
    </button>
  </form>
  <?php
  if (UserSession::is_connected()) {
    include_once __DIR__ . "/loggedin.php";
  } else {
    include_once __DIR__ . "/loggedout.php";
  }
  ?>
</header>