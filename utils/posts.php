<?php

include_once __DIR__ . "/database/index.php";
include_once __DIR__ . "/uuid.php";

class PartialPost
{
  public string $id;
  public string $cover;
  public string $title;
  public float $rating;
  public int $performance;

  public function __construct(string $id, string $cover, string $title, float $rating, int $performance)
  {
    $this->id = $id;
    $this->cover = $cover;
    $this->title = $title;
    $this->rating = $rating;
    $this->performance = $performance;
  }

  public static function from_sql_result($result)
  {
    return new PartialPost(
      strtolower($result["id"]),
      strtolower($result["cover"]),
      $result["title"],
      $result["rating"],
      $result["performance"]
    );
  }
}

class Posts
{
  public static function get_latest_posts(int $limit = 5)
  {
    $result = self::sql_query("SELECT hex(id) AS id, hex(cover) AS cover, title, rating, performance FROM posts ORDER BY date DESC LIMIT ?", "i", [$limit]);
    if (gettype($result) === "integer") return $result;

    $posts = [];

    for ($i = 0; $i < $limit; $i++) {
      $res = $result->fetch_assoc();
      if (is_array($res)) $posts[] = PartialPost::from_sql_result($res);
    }

    return $posts;
  }

  public static function get_best_perf(int $limit = 5)
  {
    $result = self::sql_query("SELECT hex(id) AS id, hex(cover) AS cover, title, rating, performance FROM posts ORDER BY performance DESC LIMIT ?", "i", [$limit]);
    if (gettype($result) === "integer") return $result;

    $posts = [];

    for ($i = 0; $i < $limit; $i++) {
      $res = $result->fetch_assoc();
      if (is_array($res)) $posts[] = PartialPost::from_sql_result($res);
    }

    return $posts;
  }

  private static function sql_query(string $query, string $types, array $params)
  {
    $link = get_database_link();
    if (gettype($link) === "integer") return $link;

    $stmt = $link->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false)
      return 3;

    return $result;
  }
}
