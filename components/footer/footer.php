<!-- Footer -->

<?php include_once __DIR__ . "/../../utils/user_session.php" ?>

<footer>
  <?php
  // Include the footer component based on the user's connection status
  if (!UserSession::is_connected() && !(isset($hide_register_footer) && $hide_register_footer)) {
    include_once __DIR__ . "/loggedout.php";
  }
  ?>
  <div id="links">
    <div>
      <a href="/">Home</a>
      <a href="/browse">Browse</a>
      <a href="/register">Register</a>
      <a href="/login">Login</a>
      <a href="/stats">Stats</a>
    </div>
    <div>
      <a href="/conditions-of-use">Conditions of Use</a>
      <a href="/privacy-policy">Privacy Policy</a>
      <a href="/site-map">Site map</a>
      <a href="https://github.com/RichardDorian/AtlasHardware" target="about:blank">GitHub</a>
    </div>
  </div>
  <span id="copyright">© 2024 Atlas Hardware</span>
</footer>