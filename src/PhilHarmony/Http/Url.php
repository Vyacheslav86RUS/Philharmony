<?php

namespace PhilHarmony\Http;

class Url
{
    private static $PROTOCOL_HTTPS = 'https';
    private static $PROTOCOL_HTTP = 'http';

    public static function createUrl(): string
    {
        return self::getProtocol() . '://' . self::getHostName() .  self::getPath() . self::getQueryParams();
    }

    private static function getProtocol(): string
    {
        return strpos(strtolower($_SERVER['SERVER_PROTOCOL']), self::$PROTOCOL_HTTPS) === false
            ? self::$PROTOCOL_HTTPS
            : self::$PROTOCOL_HTTP;
    }

    private static function getHostName(): string
    {
        return $_SERVER['HTTP_HOST'];
    }

    private static function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    private static function getQueryParams(): string
    {
        $params = '';
        if ($_SERVER['QUERY_STRING'] ?? null) {
            $params  = '?' . $_SERVER['QUERY_STRING'];
        }

        return $params;
    }
}
