<?php

class UUID
{
  public static function generate_v4()
  {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return bin2hex($data);
  }

  public static function from_binary(string $binary): string
  {
    return bin2hex($binary);
  }
}
