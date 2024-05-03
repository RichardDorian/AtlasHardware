<?php

include_once __DIR__ . "/user.php";
include_once __DIR__ . "/uuid.php";

class Comment
{
  public string $id;
  public string $post;
  public string $comment;
  public ?string $replied_to_id;
  public ?Comment $replied_to = NULL;
  public ?User $author = NULL;
  public string $author_id;
  public string $date;

  public function __construct(string $id, string $post, string $comment, ?string $replied_to, string $author, string $date)
  {
    $this->id = $id;
    $this->post = $post;
    $this->comment = $comment;
    $this->replied_to_id = $replied_to;
    $this->author_id = $author;
    $this->date = $date;
  }

  public function fetch_author()
  {
    $this->author = Users::get_user_by_id($this->author_id);
  }

  public function fetch_reply_to()
  {
    if ($this->replied_to_id == NULL) return NULL;

    $this->replied_to = Comments::get_comment_by_id($this->replied_to_id);
  }

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

class Comments extends TableRelation
{
  public static function get_comment_by_id(string $comment_id)
  {
    return self::get_comments_by_ids([$comment_id]);
  }

  public static function get_comments_by_ids(array $comment_ids)
  {
    $post_id_placeholders = implode(",", array_fill(0, count($comment_ids), "unhex(?)"));
    $sql = "SELECT hex(id) AS id, hex(post) AS post, comment, hex(replied_to) AS replied_to, hex(author) AS author, date FROM comments WHERE id IN ($post_id_placeholders)";
    $types = str_repeat('s', count($comment_ids));
    $result = self::sql_query($sql, $types, $comment_ids);
    if (gettype($result) === "integer") return $result;

    $comments = [];
    while ($res = $result->fetch_assoc()) {
      $comment = Comment::from_sql_result($res);
      $comment->fetch_author();
      $comments[] = $comment;
    }
    return $comments;
  }

  public static function get_comments_of_post(string $post_id)
  {
    $result = self::sql_query("SELECT hex(id) AS id, comment, hex(replied_to) AS replied_to, hex(author) AS author, date FROM comments WHERE post = unhex(?)", "s", [$post_id]);
    if (gettype($result) === "integer") return $result;

    $comments = [];
    while ($res = $result->fetch_assoc()) {
      $res["post"] = $post_id;
      $comment = Comment::from_sql_result($res);
      $comments[] = $comment;
    }

    return $comments;
  }

  public static function add_comment(string $comment, string $post, string $author, ?string $replied_to = NULL)
  {
    $id = UUID::generate_v4();
    return self::sql_query("INSERT INTO comments (id, comment, post, author, replied_to) VALUES (unhex(?), ?, unhex(?), unhex(?), ?)", "sssss", [$id, $comment, $post, $author, $replied_to]);
  }
}
