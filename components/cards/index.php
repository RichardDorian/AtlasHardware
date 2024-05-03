<?php
/**
 * Generates a small card with post details.
 *
 * @param PartialPost $post The post object containing details like id, cover image, title, rating, and performance.
 * @param bool $saved Indicates whether the post is saved or not.
 *
 * @return void
 */
function small_card(PartialPost $post, bool $saved)
{
  $data = [
    "id" => $post->id,
    "image" => $post->cover,
    "title" => $post->title,
    "starting_price" => $post->starting_price,
    "benchmark" => $post->performance,
    "saved" => $saved,
  ];
  include __DIR__ . "/small.php";
}
