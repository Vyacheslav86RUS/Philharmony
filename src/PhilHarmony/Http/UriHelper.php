<?php

namespace PhilHarmony\Http;

use PhilHarmony\Exception\PhilHarmonyInvalidArgumentException;

class UriHelper
{
    /**
     * @param int|null $port
     * @return int
     */
    public static function filterPort(?int $port): int
    {
        if ($port === null) {
            return null;
        }

        $port = (int) $port;
        if (0 > $port || 0xffff < $port) {
            throw new PhilHarmonyInvalidArgumentException(
                sprintf('Invalid port: %d. Must be between 0 and 65535', $port)
            );
        }

        return $port;
    }

    /**
     * @param string $scheme
     * @return string
     */
    public static function filterScheme(string $scheme): string
    {
        return strtolower(static::filterString($scheme, 'Scheme must be a string'));
    }

    /**
     * @param string $component
     * @return string
     */
    public static function filterUserInfo(string $component): string
    {
        return static::filterString($component, 'User info must be a string');
    }

    /**
     * @param string $host
     * @return string
     */
    public static function filterHost(string $host): string
    {
        return strtolower(static::filterString($host, 'Host must be a string'));
    }

    /**
     * @param string $path
     * @return string
     */
    public static function filterPath(string $path): string
    {
        return static::filterString($path, 'Path must be a string');
    }

    /**
     * @param string $query
     * @return string
     */
    public static function filterQuery(string $query): string
    {
        return static::filterString($query,'Query must be a string');
    }

    /**
     * @param string $fragment
     * @return string
     */
    public static function filterFragment(string $fragment): string
    {
        return static::filterString($fragment, 'Fragment must be a string');
    }

    /**
     * @param string $component
     * @param string $message
     * @return string
     */
    private static function filterString(string $component, string $message): string
    {
        if (!is_string($component)) {
            throw new PhilHarmonyInvalidArgumentException($message);
        }

        return $component;
    }
}
