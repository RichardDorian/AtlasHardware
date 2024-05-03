<?php

include_once __DIR__ . "/database/index.php";
include_once __DIR__ . "/database/table.php";
include_once __DIR__ . "/uuid.php";
include_once __DIR__ . "/user.php";

// Define the PartialPost class
class PartialPost
{
  public string $id;
  public string $cover;
  public string $title;
  public float $starting_price;
  public int $performance;
  public array $images;

  /** Initialize a new PartialPost object
   * @param string $id
   * @param string $cover
   * @param string $title
   * @param float $starting_price
   * @param int $performance
   */
  public function __construct(string $id, string $cover, string $title, float $starting_price, int $performance)
  {
    $this->id = $id;
    $this->cover = $cover;
    $this->title = $title;
    $this->starting_price = $starting_price;
    $this->performance = $performance;
    $this->images = [];
  }

  /** Fetch the images for the post
   */
  public function fetch_images()
  {
    $this->images = Posts::get_images_for_post($this->id);
  }

  /** Get the URL for the cover image
   * @return string
   */
  public function get_cover_url()
  {
    return $this->get_image_url($this->cover);
  }

  /** Get the URL for an image
   * @param string $id
   * @return string
   */
  public function get_image_url(string $id)
  {
    return "/assets/image/" . $id;
  }

  /** Create a new PartialPost object from an SQL result
   * @param array $result
   * @return PartialPost
   */
  public static function from_sql_result($result)
  {
    return new PartialPost(
      strtolower($result["id"]),
      strtolower($result["cover"]),
      $result["title"],
      $result["starting_price"],
      $result["performance"]
    );
  }
}

// Define the Post class
class Post extends PartialPost
{
  public string $author_id;
  public string $date;
  public string $description;
  public array $specs;
  public ?User $author;
  public float $rating;

  /** Initialize a new Post object
   * @param string $id
   * @param string $cover
   * @param string $title
   * @param float $rating
   * @param int $performance
   * @param string $author
   * @param string $date
   * @param string $description
   * @param string $raw_specs
   * @param float $starting_price
   */
  public function __construct(string $id, string $cover, string $title, float $rating, int $performance, string $author, string $date, string $description, string $raw_specs, float $starting_price)
  {
    parent::__construct($id, $cover, $title, $starting_price, $performance);
    $this->author_id = $author;
    $this->date = $date;
    $this->description = $description;
    $this->specs = json_decode($raw_specs, true);
    $this->rating = $rating;
  }

  /** Fetch the author of the post
   */
  public function fetch_author()
  {
    $this->author = Users::get_user_by_id($this->author_id);
  }

  /** Create a new Post object from an SQL result
   * @param array $result
   * @return Post
   */
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
      $result["specs"],
      $result["starting_price"]
    );
  }
}

// Define the Posts class
class Posts extends TableRelation
{
  /** Get the latest posts
   * @param int $limit
   * @param int $offset
   * @return array|int
   */
  public static function get_latest_posts(int $limit = 5, int $offset = 0)
  {
    // Query the database for the latest posts
    $result = self::sql_query("SELECT hex(id) AS id, hex(cover) AS cover, title, starting_price, performance FROM posts ORDER BY date DESC LIMIT ? OFFSET ?", "ii", [$limit, $offset]);
    if (gettype($result) === "integer") return $result;

    // Initialize an array to store the posts
    $posts = [];

    // Loop through the results and create a PartialPost object for each post
    for ($i = 0; $i < $limit; $i++) {
      $res = $result->fetch_assoc();
      if (is_array($res)) $posts[] = PartialPost::from_sql_result($res);
    }

    return $posts;
  }

  /** Get the most active posts
   * @param int $limit
   * @param int $offset
   * @return array|int
   */
  public static function get_most_active_posts(int $limit = 5, int $offset = 0)
  {
    // Query the database for the most active posts
    $result = self::sql_query("SELECT hex(posts.id) AS id, hex(cover) AS cover, title, starting_price, performance, COUNT(comment) nposts FROM comments RIGHT JOIN posts ON posts.id = comments.post AND comments.date >= CURDATE() - INTERVAL 7 DAY GROUP BY posts.id ORDER BY `nposts` DESC LIMIT ? OFFSET ?", "ii", [$limit, $offset]);
    if (gettype($result) === "integer") return $result;

    // Initialize an array to store the posts
    $posts = [];

    // Loop through the results and create a PartialPost object for each post
    for ($i = 0; $i < $limit; $i++) {
      $res = $result->fetch_assoc();
      if (is_array($res)) $posts[] = PartialPost::from_sql_result($res);
    }

    return $posts;
  }

  /** Get the best performing posts
   * @param int $limit
   * @param int $offset
   * @return array|int
   */
  public static function get_best_perf(int $limit = 5, int $offset = 0)
  {
    // Query the database for the best performing posts
    $result = self::sql_query("SELECT hex(id) AS id, hex(cover) AS cover, title, starting_price, performance, specs FROM posts ORDER BY performance DESC LIMIT ? OFFSET ?", "ii", [$limit, $offset]);
    if (gettype($result) === "integer") return $result;

    // Initialize an array to store the posts
    $posts = [];

    // Loop through the results and create a PartialPost object for each post
    for ($i = 0; $i < $limit; $i++) {
      $res = $result->fetch_assoc();
      if (is_array($res)) $posts[] = PartialPost::from_sql_result($res);
    }

    return $posts;
  }

  /** Get the post for the given ID
   * @param string $id
   * @return Post|int
   */
  public static function get_post(string $id)
  {
    // Query the database for the post with the given ID
    $result = self::sql_query("SELECT hex(author) AS author, hex(cover) AS cover, date, title, description, rating, performance, specs, starting_price FROM posts WHERE id = unhex(?)", "s", [$id]);
    if (gettype($result) === "integer") return $result;

    // Fetch the result
    $res = $result->fetch_assoc();
    if (!is_array($res)) return 4;

    // Create a new Post object from the SQL result and return it
    $res["id"] = $id;

    return Post::from_sql_result($res);
  }

  /** Get images for the post with the given ID
   * @param string $id
   * @return array|int
   */
  public static function get_images_for_post(string $id)
  {
    // Query the database for the images of the post with the given ID
    $result = self::sql_query("SELECT hex(images.id) AS id FROM posts INNER JOIN post_images ON posts.id = post_images.post INNER JOIN images ON post_images.image = images.id WHERE posts.id = unhex(?) ORDER BY post_images.position;", "s", [$id]);
    if (gettype($result) === "integer") return $result;

    // Initialize an array to store the image IDs
    $images = [];

    // Loop through the results and add the image IDs to the array
    while ($res = $result->fetch_assoc()) {
      $images[] = strtolower($res["id"]);
    }

    return $images;
  }

  /** Add a new post to the database
   * @param string $user
   * @param string $title
   * @param string $description
   * @param int $price
   * @param int $performance
   * @param float $rating
   * @param string $specs
   * @param array $files
   * @return string|int
   */
  public static function add_post(string $user, string $title, string $description, int $price, int $performance, float $rating, string $specs, array $files)
  {
    $link = get_database_link();
    $post_id = UUID::generate_v4();

    foreach ($files["tmp_name"] as $i => $file) {

      $image_id = UUID::generate_v4();
      #Get the blob data from the file info
      $filedata = file_get_contents($file);
      $position = $i;
      $stmt = $link->prepare("INSERT INTO images (id, image) VALUES (unhex(?), ?)");
      $stmt->bind_param("ss", $image_id, $filedata);
      $stmt->execute();
      if ($i == 0) {
        $cover = $image_id;
        $date = date("Y-m-d H:i:s");
        $price = floatval($price);
        $stmt = $link->prepare("INSERT INTO posts (id, author, cover, title, date, description, rating, performance, specs, starting_price) VALUES (unhex(?), unhex(?), unhex(?), ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssdisd", $post_id, $user, $cover, $title, $date, $description, $rating, $performance, $specs, $price);
        $stmt->execute();
      }
      $stmt = $link->prepare("INSERT INTO post_images (post, image, position) VALUES (unhex(?), unhex(?), ?)");
      $stmt->bind_param("ssi", $post_id, $image_id, $position);
      $stmt->execute();

      if ($stmt->errno) return $stmt->errno;
    }


    if ($stmt->errno) return $stmt->errno;
    return "/post/$post_id";
  }

  /** Get the number of posts in the database
   * @return int
   */
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
    $result = self::sql_query("SELECT hex(id) AS id, hex(cover) AS cover, title, starting_price, performance FROM posts WHERE title LIKE ?", "s", ["%$search%"]);
    // Check if the query failed
    if (gettype($result) === "integer") return $result;

    // Fetch the results
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $error_msg = "";

    // If no results are found
    if (count($results) === 0) {
      // Retrieve all the posts
      $result = self::sql_query("SELECT hex(id) AS id, hex(cover) AS cover, title, starting_price, performance FROM posts", "", []);
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

  /** Get the number of posts each month
   * @return array|int
   */
  public static function get_number_of_posts_each_month()
  {
    // Query the database
    $res = self::sql_query("SELECT YEAR(date) AS annee, MONTH(date) AS mois, COUNT(id) AS nb_posts FROM posts GROUP BY annee, mois ORDER BY annee ASC, mois ASC;", "", []);
    if (gettype($res) === "integer") return $res;
    
    // Fetch the results
    $res = $res->fetch_all(MYSQLI_ASSOC);

    // Initialize an array to store the results
    $result = array();

    // Fill the array with the years and fill the months with 0
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

    // Fill the array with the number of posts
    foreach ($res as $item) {
      $annee = $item["annee"];
      $mois = $item["mois"];
      $nb_posts = $item["nb_posts"];
      $result[$annee][$mois] = $nb_posts;
    }

    // Create an array with the months
    $month_array = array(
      1 => "January",
      2 => "February",
      3 => "March",
      4 => "April",
      5 => "May",
      6 => "June",
      7 => "July",
      8 => "August",
      9 => "September",
      10 => "October",
      11 => "November",
      12 => "December"
    );

    return ["result" => $result, "month_array" => $month_array];
  }

  /** Get the author of a post
   * @param string $post_id
   * @return string|int
   */
  public static function get_post_author($post_id)
  {
    $res = self::sql_query("SELECT hex(author) AS author FROM posts WHERE id = unhex(?)", "s", [$post_id]);
    if (gettype($res) === "integer") return $res;
    $res = $res->fetch_assoc();
    return $res["author"];
  }
}
