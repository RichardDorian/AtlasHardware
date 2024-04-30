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
  public array $images;

  public function __construct(string $id, string $cover, string $title, float $rating, int $performance)
  {
    $this->id = $id;
    $this->cover = $cover;
    $this->title = $title;
    $this->rating = $rating;
    $this->performance = $performance;
    $this->images = [];
  }

  public function fetch_images()
  {
    $this->images = Posts::get_images_for_post($this->id);
  }

  public function get_cover_url()
  {
    return $this->get_image_url($this->cover);
  }

  public function get_author_name()
  {
    return Posts::get_post_author_name($this->id);
  }

  public function get_image_url(string $id)
  {
    return "/assets/image/" . $id;
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

class Post extends PartialPost
{
  public string $author;
  public string $date;
  public string $description;

  public function __construct(string $id, string $cover, string $title, float $rating, int $performance, string $author, string $date, string $description)
  {
    parent::__construct($id, $cover, $title, $rating, $performance);
    $this->author = $author;
    $this->date = $date;
    $this->description = $description;
  }

  public static function from_sql_result($result)
  {
    return new Post(
      strtolower($result["id"]),
      strtolower($result["cover"]),
      $result["title"],
      $result["rating"],
      $result["performance"],
      strtolower($result["author"]),
      $result["date"],
      $result["description"]
    );
  }
}

class Posts
{
  public static function get_latest_posts(int $limit = 5, int $offset = 0)
  {
    $result = self::sql_query("SELECT hex(id) AS id, hex(cover) AS cover, title, rating, performance FROM posts ORDER BY date DESC LIMIT ? OFFSET ?", "ii", [$limit, $offset]);
    if (gettype($result) === "integer") return $result;

    $posts = [];

    for ($i = 0; $i < $limit; $i++) {
      $res = $result->fetch_assoc();
      if (is_array($res)) $posts[] = PartialPost::from_sql_result($res);
    }

    return $posts;
  }

  public static function get_best_perf(int $limit = 5, int $offset = 0)
  {
    $result = self::sql_query("SELECT hex(id) AS id, hex(cover) AS cover, title, rating, performance FROM posts ORDER BY performance DESC LIMIT ? OFFSET ?", "ii", [$limit, $offset]);
    if (gettype($result) === "integer") return $result;

    $posts = [];

    for ($i = 0; $i < $limit; $i++) {
      $res = $result->fetch_assoc();
      if (is_array($res)) $posts[] = PartialPost::from_sql_result($res);
    }

    return $posts;
  }

  public static function get_post(string $id)
  {
    $result = self::sql_query("SELECT hex(author) AS author, hex(cover) AS cover, date, title, description, rating, performance FROM posts WHERE id = unhex(?)", "s", [$id]);
    if (gettype($result) === "integer") return $result;

    $res = $result->fetch_assoc();
    if (!is_array($res)) return 4;

    $res["id"] = $id;

    return Post::from_sql_result($res);
  }

  public static function get_images_for_post(string $id)
  {
    $result = self::sql_query("SELECT hex(images.id) AS id FROM posts INNER JOIN post_images ON posts.id = post_images.post INNER JOIN images ON post_images.image = images.id WHERE posts.id = unhex(?);", "s", [$id]);
    if (gettype($result) === "integer") return $result;

    $images = [];

    while ($res = $result->fetch_assoc()) {
      $images[] = strtolower($res["id"]);
    }

    return $images;
  }

  public static function get_post_author_name(string $id)
  {
    $result = self::sql_query("SELECT users.username AS username FROM users INNER JOIN posts ON users.id = posts.author WHERE posts.id = unhex(?)", "s", [$id]);
    if (gettype($result) === "integer") return $result;

    $res = $result->fetch_assoc();
    if (!is_array($res)) return 4;

    return $res["username"];
  }

  public static function get_number_of_posts()
  {
    $result = self::sql_query("SELECT COUNT(id) AS count FROM posts", "", []);
    return $result->fetch_assoc()["count"];
  }

  private static function sql_query(string $query, string $types, array $params)
  {
    $link = get_database_link();
    if (gettype($link) === "integer") return $link;

    $stmt = $link->prepare($query);
    if ($types !== "") $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false)
      return 3;

    return $result;
  }
}
