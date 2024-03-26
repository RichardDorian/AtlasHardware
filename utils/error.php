<?php

function exit_with_error(string $message, int $status_code): never
{
  echo $message;
  http_response_code($status_code);
  exit();
}

function exit_from_error_code_map(int $error_code, array $map)
{
  foreach ($map as $code => $details)
    if ($error_code === $code)
      exit_with_error($details[0], $details[1]);

  exit_with_error("Error: unknown error", 500);
}
