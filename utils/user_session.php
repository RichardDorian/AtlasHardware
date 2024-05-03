<?php

include_once __DIR__ . "/database/index.php";
include_once __DIR__ . "/uuid.php";

// Define the UserSession class
class UserSession
{
  /** Check if the user is connected
   * @return bool
   */
  public static function is_connected(): bool
  {
    if (session_status() !== 2) return false;
    if (!isset($_SESSION["user_id"])) return false;
    return true;
  }

  /** Start a new session for the user
   * @param string $uuid
   */
  private static function start_session(string $uuid)
  {
    $_SESSION["user_id"] = $uuid;
  }

  /** Restore the user's session
   */
  public static function restore_session()
  {
    if (self::is_connected()) return;
    session_start();
  }

  /** End the user's session
   */
  public static function logout()
  {
    session_destroy();
    setcookie(session_name(), "", time() - 3600, "/");
  }

  /** Log in the user
   * @param string $username
   * @param string $password
   * @return int
   */
  public static function login(string $username, string $password): int
  {
    $link = get_database_link();
    if (gettype($link) === "integer") return $link;

    // Prepare the SQL statement to fetch the user's ID and password
    $stmt = $link->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Return error codes based on the result

    if ($result === false)
      return 3;

    if ($result->num_rows !== 1)
      return 4;

    $row = $result->fetch_assoc();
    if (!password_verify($password, $row["password"]))
      return 5;

    // Start the user's session if there is no error
    self::start_session(UUID::from_binary($row["id"]));
    return 0;
  }

  /** Register a new user
   * @param string $username
   * @param string $password
   * @return int
   */
  public static function register(string $username, string $password): int
  {
    $link = get_database_link();
    if (gettype($link) === "integer") return $link;

    // Generate a new UUID for the user and hash the password
    $id = UUID::generate_v4();
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to insert the new user into the database
    $stmt = $link->prepare("INSERT INTO users (id, username, password, avatar) VALUES (unhex(?), ?, ?, null)");
    $stmt->bind_param("sss", $id, $username, $hashed_password);
    try {
      $stmt->execute();
    } catch (Exception $e) {
      // Username already exists
      if ($stmt->errno === 1062)
        return 4;

      return 3;
    };

    self::start_session($id);
    return 0;
  }

  /** Check if the user has saved this post
   * @param string $post_id
   * @return bool
   */
  public static function is_saved_post($post_id): bool
  {
    $arr = self::are_saved_posts([$post_id]);
    return count($arr) === 1;
  }

  /** Check if the user has saved these posts
   * @param array $posts_ids
   * @return array
   */
  public static function are_saved_posts(array $posts_ids): array
  {
    $link = get_database_link();
    if (gettype($link) === "integer") return [];

    $stmt = $link->prepare("SELECT hex(post) AS post FROM users_saved_posts WHERE user = unhex(?) AND post IN (unhex(?)" . str_repeat(", unhex(?)", count($posts_ids) - 1) . ")");
    $stmt->bind_param("s" . str_repeat("s", count($posts_ids)), $_SESSION["user_id"], ...$posts_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize an empty array to store the saved posts
    $saved_posts = [];

    // Loop through each saved post in the result set
    while ($row = $result->fetch_assoc()) {
      $saved_posts[] = strtolower($row["post"]);
    }

    return $saved_posts;
  }

  /** Get the user's saved posts
   * @return array
   */
  public static function get_saved_posts()
  {
    $link = get_database_link();
    if (gettype($link) === "integer") return [];

    $stmt = $link->prepare("SELECT hex(id) AS id, hex(cover) AS cover, title, rating, performance FROM users_saved_posts INNER JOIN posts ON users_saved_posts.post = posts.id WHERE users_saved_posts.user = unhex(?)");
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();

    $saved_posts = [];
    while ($row = $result->fetch_assoc()) {
      $saved_posts[] = PartialPost::from_sql_result($row);
    }

    return $saved_posts;
  }

  /** Get the user's posts
   * @return array
   */
  public static function get_user_posts()
  {
    $link = get_database_link();
    if (gettype($link) === "integer") return [];

    $stmt = $link->prepare("SELECT hex(id) AS id, hex(cover) AS cover, title, rating, performance FROM posts WHERE author = unhex(?)");
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();

    $user_posts = [];
    while ($row = $result->fetch_assoc()) {
      $user_posts[] = PartialPost::from_sql_result($row);
    }

    return $user_posts;
  }
}

UserSession::restore_session();
