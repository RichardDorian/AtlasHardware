<?php

/** Exit the script with an error message and status code
 * @param string $message
 * @param int $status_code
 */
function exit_with_error(string $message, int $status_code): never
{
  echo $message;
  http_response_code($status_code);
  exit();
}

/** Exit the script with an error message and status code based on an error code
 * @param int $error_code
 * @param array $map
 */
function exit_from_error_code_map(int $error_code, array $map)
{
  foreach ($map as $code => $details)
    if ($error_code === $code)
      exit_with_error($details[0], $details[1]);

  exit_with_error("Error: unknown error", 500);
}
