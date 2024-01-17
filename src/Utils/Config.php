<?php

namespace Bakkerit\PhpRipedbApi\Utils;

class Config
{
    private static array $config = [];

    public static function set($key, $value) {
        self::$config[$key] = $value;
    }

    public static function get($key) {
        return self::$config[$key];
    }

}
