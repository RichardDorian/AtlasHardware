<?php

include_once __DIR__ . "/database/table.php";

class User
{
  public string $id;
  public string $username;
  public ?string $avatar;

  public function __construct(string $id, string $username, ?string $avatar)
  {
    $this->id = $id;
    $this->username = $username;
    $this->avatar = $avatar;
  }

  public static function from_sql_result($result)
  {
    return new User(strtolower($result["id"]), $result["username"], $result["avatar"] ? strtolower($result["avatar"]) : NULL);
  }
}

class Users extends TableRelation
{
  public static function get_user_by_id(string $id): User
  {
    $result = self::sql_query("SELECT hex(id) AS id, username, hex(avatar) AS avatar FROM users WHERE id = unhex(?)", "s", [$id]);
    if (gettype($result) === "integer") return $result;
    $res = $result->fetch_assoc();
    return User::from_sql_result($res);
  }
}
