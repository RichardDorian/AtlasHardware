<footer>
  <?php
    $connected = false;
    if (!$connected) {
      include_once __DIR__ . "/loggedout.php";
    }
  ?>
  <div id="links">
    <div>
      <a href="/">Home</a>
      <a href="/browse">Browse</a>
      <a href="/register">Register</a>
      <a href="/login">Login</a>
    </div>
    <div>
      <a>Conditions of Use</a>
      <a>Privacy Policy</a>
      <a href="https://github.com/RichardDorian/AtlasHardware" target="about:blank">GitHub</a>
    </div>
  </div>
  <span id="copyright">© 2024 Atlas Hardware</span>
</footer>