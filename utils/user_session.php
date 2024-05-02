<?php

include_once __DIR__ . "/database/index.php";
include_once __DIR__ . "/uuid.php";

class UserSession
{
  public static function is_connected(): bool
  {
    if (session_status() !== 2) return false;
    if (!isset($_SESSION["user_id"])) return false;
    return true;
  }

  private static function start_session(string $uuid)
  {
    $_SESSION["user_id"] = $uuid;
  }

  public static function restore_session()
  {
    if (self::is_connected()) return;
    session_start();
  }

  public static function logout()
  {
    session_destroy();
    setcookie(session_name(), "", time() - 3600, "/");
  }

  public static function login(string $username, string $password): int
  {
    $link = get_database_link();
    if (gettype($link) === "integer") return $link;

    $stmt = $link->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false)
      return 3;

    if ($result->num_rows !== 1)
      return 4;

    $row = $result->fetch_assoc();
    if (!password_verify($password, $row["password"]))
      return 5;

    self::start_session(UUID::from_binary($row["id"]));
    return 0;
  }

  public static function register(string $username, string $password): int
  {
    $link = get_database_link();
    if (gettype($link) === "integer") return $link;

    $id = UUID::generate_v4();
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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

  public static function is_saved_post($post_id): bool
  {
    $arr = self::are_saved_posts([$post_id]);
    return count($arr) === 1;
  }

  public static function are_saved_posts(array $posts_ids): array
  {
    $link = get_database_link();
    if (gettype($link) === "integer") return [];

    $stmt = $link->prepare("SELECT hex(post) AS post FROM users_saved_posts WHERE user = unhex(?) AND post IN (unhex(?)" . str_repeat(", unhex(?)", count($posts_ids) - 1) . ")");
    $stmt->bind_param("s" . str_repeat("s", count($posts_ids)), $_SESSION["user_id"], ...$posts_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    $saved_posts = [];
    while ($row = $result->fetch_assoc()) {
      $saved_posts[] = strtolower($row["post"]);
    }

    return $saved_posts;
  }

  public static function get_saved_posts()
  {
    $link = get_database_link();
    if (gettype($link) === "integer") return [];

    $stmt = $link->prepare("SELECT hex(id) AS id, hex(cover) AS cover, title, rating, performance FROM users_saved_posts INNER JOIN posts ON users_saved_posts.post = posts.id WHERE users_saved_posts.user = unhex(?) LIMIT 5");
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();

    $saved_posts = [];
    while ($row = $result->fetch_assoc()) {
      $saved_posts[] = PartialPost::from_sql_result($row);
    }

    return $saved_posts;
  }
}

UserSession::restore_session();
