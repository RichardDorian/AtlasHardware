<?php

class TableRelation
{
  protected static function sql_query(string $query, string $types, array $params)
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
