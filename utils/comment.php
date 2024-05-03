<?php

// Include the User and UUID classes
include_once __DIR__ . "/user.php";
include_once __DIR__ . "/uuid.php";

// Define the Comment class
class Comment
{
  // Declare properties for the comment
  public string $id;
  public string $post;
  public string $comment;
  public ?string $replied_to_id;
  public ?Comment $replied_to = NULL;
  public ?User $author = NULL;
  public string $author_id;
  public string $date;

  /** Initialize a new Comment object
   * @param string $id
   * @param string $post
   * @param string $comment
   * @param string|null $replied_to
   * @param string $author
   * @param string $date
   */
  public function __construct(string $id, string $post, string $comment, ?string $replied_to, string $author, string $date)
  {
    // Initialize the properties of the Comment object
    $this->id = $id;
    $this->post = $post;
    $this->comment = $comment;
    $this->replied_to_id = $replied_to;
    $this->author_id = $author;
    $this->date = $date;
  }

  /** Fetch the author of the comment
   */
  public function fetch_author()
  {
    $this->author = Users::get_user_by_id($this->author_id);
  }

  /** Fetch the comment that this comment is a reply to
   */
  public function fetch_reply_to()
  {
    if ($this->replied_to_id == NULL) return NULL;

    $this->replied_to = Comments::get_comment_by_id($this->replied_to_id);
  }

  /** Create a new Comment object from an SQL result
   * @param array $result
   * @return Comment
   */
  public static function from_sql_result($result)
  {
    return new Comment(
      strtolower($result["id"]),
      strtolower($result["post"]),
      $result["comment"],
      $result["replied_to"] ? strtolower($result["replied_to"]) : NULL,
      strtolower($result["author"]),
      $result["date"]
    );
  }
}

// Define the Comments class
class Comments extends TableRelation
{
  /** Get a comment by its ID
   * @param string $comment_id
   * @return Comment|array|integer
   */
  public static function get_comment_by_id(string $comment_id)
  {
    return self::get_comments_by_ids([$comment_id]);
  }

  /** Get multiple comments by their IDs
   * @param array $comment_ids
   * @return array|integer
   */
  public static function get_comments_by_ids(array $comment_ids)
  {
    // If there are no comment IDs provided, return an empty array
    $post_id_placeholders = implode(",", array_fill(0, count($comment_ids), "unhex(?)"));

    // Fetch the comments from the database
    $sql = "SELECT hex(id) AS id, hex(post) AS post, comment, hex(replied_to) AS replied_to, hex(author) AS author, date FROM comments WHERE id IN ($post_id_placeholders)";
    
    // Bind the comment IDs as parameters to the SQL query
    $types = str_repeat('s', count($comment_ids));

    // Execute the SQL query
    $result = self::sql_query($sql, $types, $comment_ids);
    if (gettype($result) === "integer") return $result;

    // Initialize an empty array to store the comments
    $comments = [];

    // Loop through each comment in the result set
    while ($res = $result->fetch_assoc()) {
      // Create a new Comment object from the SQL result
      $comment = Comment::from_sql_result($res);
      $comment->fetch_author();
      $comments[] = $comment;
    }
    return $comments;
  }

  // Get all comments for a given post
  /**
   * @param string $post_id
   * @return array|integer
   */
  public static function get_comments_of_post(string $post_id)
  {
    // Fetch all comments for the given post from the database
    $result = self::sql_query("SELECT hex(id) AS id, comment, hex(replied_to) AS replied_to, hex(author) AS author, date FROM comments WHERE post = unhex(?)", "s", [$post_id]);
    if (gettype($result) === "integer") return $result;

    // Initialize an empty array to store the comments
    $comments = [];

    // Loop through each comment in the result set
    while ($res = $result->fetch_assoc()) {
      // Create a new Comment object from the SQL result
      $res["post"] = $post_id;
      $comment = Comment::from_sql_result($res);
      $comments[] = $comment;
    }

    return $comments;
  }

  /** Add a new comment to the database
   * @param string $comment
   * @param string $post
   * @param string $author
   * @param string|null $replied_to
   * @return int
   */
  public static function add_comment(string $comment, string $post, string $author, ?string $replied_to = NULL)
  {
    $id = UUID::generate_v4();
    return self::sql_query("INSERT INTO comments (id, comment, post, author, replied_to) VALUES (unhex(?), ?, unhex(?), unhex(?), ?)", "sssss", [$id, $comment, $post, $author, $replied_to]);
  }
}
