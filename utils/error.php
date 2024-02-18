<?php

function exit_with_error(string $message, int $status_code): never
{
  echo $message;
  http_response_code($status_code);
  exit();
}
