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
  public array $specs;

  public function __construct(string $id, string $cover, string $title, float $rating, int $performance, string $author, string $date, string $description, string $raw_specs)
  {
    parent::__construct($id, $cover, $title, $rating, $performance);
    $this->author = $author;
    $this->date = $date;
    $this->description = $description;
    $this->specs = json_decode($raw_specs, true);
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
      $result["description"],
      $result["specs"]
    );
  }
}

class PartialUser
{
  public string $id;
  public string $username;
}

class Comment
{
  public string $id;
  public string $post;
  public string $content;
  public string $reply_to;
  public string $author;
  public string $date;

  public function __construct(string $id, string $post, string $content, string $reply_to, string $author, string $date)
  {
    $this->id = $id;
    $this->post = $post;
    $this->content = $content;
    $this->reply_to = $reply_to;
    $this->author = $author;
    $this->date = $date;
  }

  public function get_author(): PartialUser
  {
    return new PartialUser();
  }

  public static function from_sql_result($result)
  {
    return new Comment(
      $result["id"],
      $result["post"],
      $result["content"],
      $result["reply_to"],
      $result["author"],
      $result["date"]
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
    $result = self::sql_query("SELECT hex(id) AS id, hex(cover) AS cover, title, rating, performance, specs FROM posts ORDER BY performance DESC LIMIT ? OFFSET ?", "ii", [$limit, $offset]);
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
    $result = self::sql_query("SELECT hex(author) AS author, hex(cover) AS cover, date, title, description, rating, performance, specs FROM posts WHERE id = unhex(?)", "s", [$id]);
    if (gettype($result) === "integer") return $result;

    $res = $result->fetch_assoc();
    if (!is_array($res)) return 4;

    $res["id"] = $id;

    return Post::from_sql_result($res);
  }

  public static function get_images_for_post(string $id)
  {
    $result = self::sql_query("SELECT hex(images.id) AS id FROM posts INNER JOIN post_images ON posts.id = post_images.post INNER JOIN images ON post_images.image = images.id WHERE posts.id = unhex(?) ORDER BY post_images.position;", "s", [$id]);
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


  /**
   * Search for posts that match the search query
   * @param string $search The search query
   * @return array An array containing the posts that match the search query
   * @return string An error message if there are no results
   */
  public static function get_posts_from_search(string $search)
  {
    // Search for the exact component
    $result = self::sql_query("SELECT hex(id) AS id, hex(cover) AS cover, title, rating, performance FROM posts WHERE title LIKE ?", "s", ["%$search%"]);
    // Check if the query failed
    if (gettype($result) === "integer") return $result;

    // Fetch the results
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $error_msg = "";

    // If no results are found
    if (count($results) === 0) {
      // Retrieve all the posts
      $result = self::sql_query("SELECT hex(id) AS id, hex(cover) AS cover, title, rating, performance FROM posts", "", []);
      // Check if the query failed
      if (gettype($result) === "integer") return $result;

      // Fetch the results
      $results = $result->fetch_all(MYSQLI_ASSOC);

      // Create an array to store the distance between the search and the title
      $list = [];
      foreach ($results as $res) {
        // Levenshtein distance for the title of all the posts : https://www.scaler.com/topics/levenshtein-distance-python/

        $n = strlen($res["title"]);
        $m = strlen($search);

        // Create a n*m matrix
        $dp = array_fill(0, $n + 1, array_fill(0, $m + 1, 0));

        // Base case when n = 0
        for ($i = 0; $i <= $n; $i++) {
          $dp[$i][0] = $i;
        }

        // Base case when m = 0
        for ($i = 0; $i <= $m; $i++) {
          $dp[0][$i] = $i;
        }

        // Transitions
        for ($i = 1; $i <= $n; $i++) {
          for ($j = 1; $j <= $m; $j++) {
            $cost = ($res["title"][$i - 1] == $search[$j - 1]) ? 0 : 1;
            $dp[$i][$j] = min(
              $dp[$i - 1][$j] + 1,
              $dp[$i][$j - 1] + 1,
              $dp[$i - 1][$j - 1] + $cost
            );
          }
        }

        // Store the distance and the post
        $list[] = [$dp[$n][$m], $res];
      }

      // Create an array with the distance
      $keys = array_column($list, 0);

      // Sort $list based on the distance
      array_multisort($keys, SORT_ASC, $list);

      // Slice the sorted array
      $sliced_array = array_slice($list, 0, 3);

      // If the first element has a distance greater than 15 we consider that there is no match
      if ($sliced_array[0][0] > 15) {
        $error_msg = "No posts match the specified search terms : Here are some results that could match";
      }

      // If the first element has a distance greater than 30 we consider that it's useless to display the results
      if ($sliced_array[0][0] > 30) {
        $error_msg = "No posts match the specified search terms";
        $sliced_array = [];
      }

      // Create an array with the results
      $results = array_column($sliced_array, 1);
    }

    // Format the results
    $posts = [];
    foreach ($results as $res) {
      $posts[] = PartialPost::from_sql_result($res);
    }


    return array("posts" => $posts, "error_msg" => $error_msg);
  }

  public static function get_number_of_posts_each_month()
  {
    $res = self::sql_query("SELECT YEAR(date) AS annee, MONTH(date) AS mois, COUNT(id) AS nb_posts FROM posts GROUP BY annee, mois ORDER BY annee ASC, mois ASC;", "", []);
    if (gettype($res) === "integer") return $res;
    $res = $res->fetch_all(MYSQLI_ASSOC);

    $result = array();

    // Initialiser les tableaux pour chaque année avec des valeurs 0
    foreach ($res as $item) {
      $annee = $item["annee"];
      if (!isset($result[$annee])) {
        $result[$annee] = array_fill(1, 12, "0");
      }
    }

    $month_array = array(
      1 => "Janvier",
      2 => "Février",
      3 => "Mars",
      4 => "Avril",
      5 => "Mai",
      6 => "Juin",
      7 => "Juillet",
      8 => "Août",
      9 => "Septembre",
      10 => "Octobre",
      11 => "Novembre",
      12 => "Décembre"
    );

    // Remplir les données réelles
    foreach ($res as $item) {
      $annee = $item["annee"];
      $mois = $item["mois"];
      $nb_posts = $item["nb_posts"];
      $result[$annee][$mois] = $nb_posts;
    }

    $month_array = array(
      1 => "Janvier",
      2 => "Février",
      3 => "Mars",
      4 => "Avril",
      5 => "Mai",
      6 => "Juin",
      7 => "Juillet",
      8 => "Août",
      9 => "Septembre",
      10 => "Octobre",
      11 => "Novembre",
      12 => "Décembre"
    );

    return ["result" => $result, "month_array" => $month_array];
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
