<?php

function small_card($title, $image, $rating, $benchmark, $bookmarked, $id)
{
  $data = [
    "title" => $title,
    "image" => $image,
    "rating" => $rating,
    "benchmark" => $benchmark,
    "bookmarked" => $bookmarked,
    "id" => $id
  ];
  include __DIR__ . "/small.php";
}
