<?php

function small_card(PartialPost $post, bool $saved)
{
  $data = [
    "id" => $post->id,
    "image" => $post->cover,
    "title" => $post->title,
    "rating" => $post->rating,
    "benchmark" => $post->performance,
    "saved" => $saved,
  ];
  include __DIR__ . "/small.php";
}
