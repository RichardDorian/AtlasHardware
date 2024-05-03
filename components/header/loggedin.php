<!-- View for logged in users -->
<a href="/add-post" class="with-icon">
  <span class="material-symbols-rounded">add</span>
  <span>Post</span>
</a>
<a href="/me/saved" class="with-icon">
  <span class="material-symbols-rounded">bookmark</span>
  <span>Saved</span>
</a>
<div id="my-account">
  <button class="with-icon">
    <span class="material-symbols-rounded">account_circle</span>
    <span>My account</span>
  </button>
  <div class="hidden">
    <a href="/me">My account</a>
    <a href="/me/posts">My posts</a>
    <hr />
    <?php echo "<a href=\"/logout?redirect=" . urlencode($_SERVER["REQUEST_URI"]) . "\">Logout</a>" ?>
  </div>
</div>