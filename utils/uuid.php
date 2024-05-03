<?php

// Define the UUID class
class UUID
{
  /** Generate a v4 UUID
   * @return string
   */
  public static function generate_v4()
  {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return self::from_binary($data);
  }

  /** Convert a binary UUID to a string
   * @param string $binary
   * @return string
   */
  public static function from_binary(string $binary): string
  {
    return bin2hex($binary);
  }
}
