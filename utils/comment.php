<?php

include_once __DIR__ . "/user.php";

class Comment
{
  public string $id;
  public string $post;
  public string $content;
  public ?string $reply_to_id;
  public ?Comment $reply_to = NULL;
  public ?User $author = NULL;
  public string $author_id;
  public string $date;

  public function __construct(string $id, string $post, string $content, ?string $reply_to, string $author, string $date)
  {
    $this->id = $id;
    $this->post = $post;
    $this->content = $content;
    $this->reply_to_id = $reply_to;
    $this->author_id = $author;
    $this->date = $date;
  }

  public function fetch_author()
  {
    $this->author = Users::get_user_by_id($this->author_id);
  }

  public function fetch_reply_to()
  {
    if ($this->reply_to_id == NULL) return NULL;

    $this->reply_to = Comments::get_comment_by_id($this->reply_to_id);
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

class Comments extends TableRelation
{
  public static function get_comment_by_id(string $post_id)
  {
    return self::get_comments_by_ids([$post_id]);
  }

  public static function get_comments_by_ids(array $post_ids)
  {
    $post_id_placeholders = implode(",", array_fill(0, count($post_ids), "unhex(?)"));
    $sql = "SELECT hex(id) AS id, hex(post) AS post, content, hex(reply_to) AS reply_to, hex(author) AS author, date FROM comments WHERE post IN ($post_id_placeholders)";
    $types = str_repeat('s', count($post_ids));
    $result = self::sql_query($sql, $types, $post_ids);
    if (gettype($result) === "integer") return $result;

    $comments = [];
    while ($res = $result->fetch_assoc()) {
      $comment = Comment::from_sql_result($res);
      $comment->fetch_author();
      $comments[] = $comment;
    }
    return $comments;
  }
}
